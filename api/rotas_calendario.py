# api/rotas_calendario.py

from fastapi import APIRouter, HTTPException
from db import get_mongo_db
from bson.objectid import ObjectId
from datetime import datetime, timedelta

router = APIRouter()

# Listar calendários
@router.get("/api/calendarios")
def listar_calendarios():
    db = get_mongo_db()
    calendarios = list(db["calendario"].find())
    for cal in calendarios:
        cal["_id"] = str(cal["_id"])
        cal["id_empresa"] = str(cal.get("id_empresa", ""))
        # Para garantir compatibilidade se campo não existir
        if "dias_nao_letivos" not in cal:
            cal["dias_nao_letivos"] = []
    return calendarios

# Adicionar novo calendário
@router.post("/api/calendarios")
def adicionar_calendario(calendario: dict):
    db = get_mongo_db()
    if "nome_calendario" not in calendario or "id_empresa" not in calendario or "data_inicial" not in calendario or "data_final" not in calendario:
        raise HTTPException(status_code=400, detail="Campos obrigatórios: nome_calendario, id_empresa, data_inicial, data_final")
    calendario["dias_nao_letivos"] = []
    result = db["calendario"].insert_one(calendario)
    calendario["_id"] = str(result.inserted_id)
    return calendario

# Editar calendário
@router.put("/api/calendarios/{calendario_id}")
def editar_calendario(calendario_id: str, calendario: dict):
    db = get_mongo_db()
    result = db["calendario"].update_one(
        {"_id": ObjectId(calendario_id)},
        {"$set": calendario}
    )
    if result.matched_count == 0:
        raise HTTPException(status_code=404, detail="Calendário não encontrado")
    calendario["_id"] = calendario_id
    return calendario

# Excluir calendário
@router.delete("/api/calendarios/{calendario_id}")
def excluir_calendario(calendario_id: str):
    db = get_mongo_db()
    result = db["calendario"].delete_one({"_id": ObjectId(calendario_id)})
    if result.deleted_count == 0:
        raise HTTPException(status_code=404, detail="Calendário não encontrado")
    return {"msg": "Calendário excluído"}

# Adicionar evento (um ou mais calendários)
@router.post("/api/calendarios/adicionar_evento")
def adicionar_evento(evento: dict):
    """
    {
        "calendarios_ids": [<id1>, <id2>, ...],
        "descricao": "Nome do evento",
        "data_inicial": "2024-05-02",
        "data_final": "2024-05-10"
    }
    """
    db = get_mongo_db()
    if "calendarios_ids" not in evento or "descricao" not in evento or "data_inicial" not in evento or "data_final" not in evento:
        raise HTTPException(status_code=400, detail="Campos obrigatórios: calendarios_ids, descricao, data_inicial, data_final")
    data_ini = datetime.strptime(evento["data_inicial"], "%Y-%m-%d")
    data_fim = datetime.strptime(evento["data_final"], "%Y-%m-%d")
    dias = []
    dt = data_ini
    while dt <= data_fim:
        dias.append({
            "descricao": evento["descricao"],
            "data": dt.strftime("%Y-%m-%d")
        })
        dt += timedelta(days=1)
    # Para cada calendário, adiciona todos os dias como dia não letivo
    for cal_id in evento["calendarios_ids"]:
        db["calendario"].update_one(
            {"_id": ObjectId(cal_id)},
            {"$push": {"dias_nao_letivos": {"$each": dias}}}
        )
    return {"msg": "Evento(s) adicionado(s) aos calendários selecionados."}

# Editar/Excluir dias não letivos
@router.put("/api/calendarios/{calendario_id}/editar_dia_nao_letivo")
def editar_dia_nao_letivo(calendario_id: str, payload: dict):
    """
    payload = {
      "data_original": "2024-05-02",
      "data_nova": "2024-05-03",
      "descricao": "Nova descrição"
    }
    """
    db = get_mongo_db()
    result = db["calendario"].update_one(
        {"_id": ObjectId(calendario_id), "dias_nao_letivos.data": payload["data_original"]},
        {"$set": {"dias_nao_letivos.$.data": payload["data_nova"], "dias_nao_letivos.$.descricao": payload["descricao"]}}
    )
    return {"msg": "Dia não letivo editado."}

@router.delete("/api/calendarios/{calendario_id}/remover_dia_nao_letivo")
def remover_dia_nao_letivo(calendario_id: str, data: str):
    db = get_mongo_db()
    result = db["calendario"].update_one(
        {"_id": ObjectId(calendario_id)},
        {"$pull": {"dias_nao_letivos": {"data": data}}}
    )
    return {"msg": "Dia não letivo removido."}
