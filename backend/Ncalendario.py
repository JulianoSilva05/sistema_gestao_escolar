from .db import get_mongo_db

def salvar_evento(data):
    db = get_mongo_db()
    return db["calendario_academico"].insert_one(data)

def listar_eventos(filtros=None):
    db = get_mongo_db()
    query = filtros if filtros else {}
    eventos = list(db["calendario_academico"].find(query))
    for evento in eventos:
        evento["_id"] = str(evento["_id"])
    return eventos
