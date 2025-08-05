from fastapi import APIRouter, Query, Depends
from typing import List, Optional
from pymongo import MongoClient
from datetime import datetime, timedelta
from auth_utils import autenticar_usuario_dep
from bson import ObjectId

router = APIRouter(prefix="/api/alocacao", tags=["Alocação"])

def get_mongo_db():
    client = MongoClient("mongodb://localhost:27017/")
    return client["senai_betim_bd"]

def get_str_id(obj):
    if isinstance(obj, ObjectId):
        return str(obj)
    if isinstance(obj, dict) and "$oid" in obj:
        return obj["$oid"]
    return str(obj)

@router.get("/gerar", response_model=list)
def gerar_alocacao(
    filtro_turno: Optional[str] = Query(None, description="Filtrar por turno (manha/tarde/noite)"),
    filtro_turma: Optional[str] = Query(None, description="Filtrar por turma (_id)"),
    filtro_instrutor: Optional[str] = Query(None, description="Filtrar por instrutor (nome)"),
    usuario_autenticado: dict = Depends(autenticar_usuario_dep)
):
    db = get_mongo_db()
    turmas = list(db["turma"].find())
    ucs = {get_str_id(uc["_id"]): uc for uc in db["unidade_curricular"].find()}
    instrutores = list(db["instrutor"].find())
    calendario = list(db["calendario_academico"].find())

    # Filtros
    if filtro_turma:
        turmas = [t for t in turmas if get_str_id(t["_id"]) == filtro_turma]
    if filtro_turno:
        turmas = [t for t in turmas if t.get("turno", "").lower() == filtro_turno.lower()]

    relatorios = []
    ocupacoes = {}  # (instrutor_nome, data_str): True

    for turma in turmas:
        tid = get_str_id(turma["_id"])
        codigo_turma = turma.get("codigo")
        turno = turma.get("turno", "").lower()
        ucs_turma = turma.get("unidades_curriculares", [])

        concluidas = [uc for uc in ucs_turma if uc.get("status") == "concluido"]
        pendentes = [uc for uc in ucs_turma if uc.get("status") != "concluido"]
        ucs_ordenadas = concluidas + pendentes

        def buscar_excecoes(turma_atual):
            excecoes = set()
            for ev in calendario:
                if not ev.get('turma_id') or get_str_id(ev.get('turma_id')) == get_str_id(turma_atual["_id"]):
                     if ev.get('descricao', '').lower() != 'aula ead':
                        excecoes.add(ev['data'])
            return excecoes

        excecoes = buscar_excecoes(turma)
        data_atual_obj = datetime.strptime(turma.get("data_inicio"), "%Y-%m-%d") if turma.get("data_inicio") else None
        
        if not data_atual_obj:
            continue

        for uc in ucs_ordenadas:
            uc_id = get_str_id(uc.get("uc_id") or uc.get("_id"))
            uc_info = ucs.get(uc_id, {})
            nome_uc = uc.get("descricao") or uc_info.get("descricao", "UC Desconhecida")
            qtd_dias = int(uc.get("dias_letivos") or uc_info.get("dias_letivos") or 0)
            
            if qtd_dias == 0:
                continue

            datas_uc = []
            dias_contados = 0
            while dias_contados < qtd_dias:
                data_atual_str = data_atual_obj.strftime("%Y-%m-%d")
                if data_atual_obj.weekday() < 5 and data_atual_str not in excecoes:
                    datas_uc.append(data_atual_str)
                    dias_contados += 1
                data_atual_obj += timedelta(days=1)
            
            if not datas_uc:
                continue

            data_inicio_uc = datas_uc[0]
            data_fim_uc = datas_uc[-1]
            status_uc = uc.get("status", "pendente")
            
            instrutor_alocado = "Não definido"
            if status_uc != "concluido":
                instrutores_competentes = [
                    inst for inst in instrutores 
                    if uc_id in [get_str_id(cid) for cid in inst.get('mapa_competencia', [])] 
                    and inst.get('turnos', {}).get(turno)
                ]

                if filtro_instrutor:
                    instrutores_competentes = [inst for inst in instrutores_competentes if inst['nome'] == filtro_instrutor]

                for instrutor in instrutores_competentes:
                    disponivel = True
                    for data_aula in datas_uc:
                        if ocupacoes.get((instrutor['nome'], data_aula)):
                            disponivel = False
                            break
                    if disponivel:
                        instrutor_alocado = instrutor['nome']
                        for data_aula in datas_uc:
                            ocupacoes[(instrutor['nome'], data_aula)] = True
                        break
                
                if instrutor_alocado == "Não definido":
                    instrutor_alocado = "SEM INSTRUTOR DISPONÍVEL"

            relatorios.append({
                "turma_id": tid,
                "codigo_turma": codigo_turma,
                "nome_uc": nome_uc,
                "data_inicio_uc": data_inicio_uc,
                "data_fim_uc": data_fim_uc,
                "status_uc": status_uc,
                "instrutor": instrutor_alocado
            })

    return relatorios