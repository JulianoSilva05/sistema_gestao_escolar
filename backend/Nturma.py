from .db import get_mongo_db

def salvar_turma(data):
    db = get_mongo_db()
    return db["turma"].insert_one(data)

def listar_turmas():
    db = get_mongo_db()
    turmas = list(db["turma"].find())
    for turma in turmas:
        turma["_id"] = str(turma["_id"])
    return turmas
