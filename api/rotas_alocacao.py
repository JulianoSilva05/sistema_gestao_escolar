from fastapi import APIRouter, Query
from typing import List, Optional
from pymongo import MongoClient
from datetime import datetime, timedelta

router = APIRouter(prefix="/api/alocacao", tags=["Alocação"])

def get_mongo_db():
    client = MongoClient("mongodb://localhost:27017/")
    return client["senai_betim_bd"]

# Utilidade para converter _id para string
def get_str_id(obj):
    if isinstance(obj, dict) and "$oid" in obj:
        return obj["$oid"]
    return str(obj)

@router.get("/gerar", response_model=list)
def gerar_alocacao(
    filtro_turno: Optional[str] = Query(None, description="Filtrar por turno (manha/tarde/noite)"),
    filtro_turma: Optional[str] = Query(None, description="Filtrar por turma (_id)"),
    filtro_instrutor: Optional[str] = Query(None, description="Filtrar por instrutor (nome)")
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
    for turma in turmas:
        tid = get_str_id(turma["_id"])
        codigo_turma = turma.get("codigo")
        turno = turma.get("turno", "").lower()
        ucs_turma = turma.get("unidades_curriculares", [])

        # Ordena UCs: concluídas primeiro, depois pendentes
        concluidas = [uc for uc in ucs_turma if uc.get("status") == "concluido"]
        pendentes = [uc for uc in ucs_turma if uc.get("status") != "concluido"]
        ucs_ordenadas = concluidas + pendentes

        # Prepara exceções (feriados, recesso, etc)
        def buscar_excecoes(turma):
            tid = get_str_id(turma["_id"])
            excecoes = set()
            for ev in calendario:
                ev_tid = ev.get('turma_id')
                if get_str_id(ev_tid) == tid or not ev_tid:
                    if ev.get('descricao', '').lower() != 'aula ead':
                        excecoes.add(ev['data'])
            return excecoes

        ocupacoes = {}  # (prof, turno, dia): True
        excecoes = buscar_excecoes(turma)
        data_atual = turma.get("data_inicio")
        if not data_atual:
            continue

        for uc in ucs_ordenadas:
            uc_id = str(uc.get("uc_id") or uc.get("_id"))
            nome_uc = uc.get("descricao") or ucs.get(uc_id, {}).get("descricao", uc_id)
            qtd_dias = uc.get("dias_letivos") or ucs.get(uc_id, {}).get("dias_letivos") or 0
            qtd_dias = int(qtd_dias)
            if qtd_dias == 0:
                continue

            # Gera as datas da UC, avançando a partir de data_atual, pulando exceções e fins de semana
            datas_uc = []
            data_temp = data_atual
            while len(datas_uc) < qtd_dias:
                dt = datetime.strptime(data_temp, "%Y-%m-%d")
                if dt.weekday() < 5 and data_temp not in excecoes:
                    datas_uc.append(data_temp)
                data_temp = (dt + timedelta(days=1)).strftime("%Y-%m-%d")

            data_inicio_uc = datas_uc[0]
            data_fim_uc = datas_uc[-1]
            status_uc = uc.get("status", "pendente")

            # Filtro instrutor
            def get_ordem_professores(turno, uc_id):
                ordem = []
                for t in instrutores:
                    if t.get('turnos', {}).get(turno, False):
                        # Mapa de competência pode ser ObjectId ou string
                        competencias = [str(cid.get("$oid", cid)) if isinstance(cid, dict) else str(cid) for cid in t.get('mapa_competencia', [])]
                        if uc_id in competencias:
                            if not filtro_instrutor or t['nome'] == filtro_instrutor:
                                ordem.append(t['nome'])
                return ordem

            # Alocação
           
