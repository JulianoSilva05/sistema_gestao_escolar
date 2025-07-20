from .db import get_mongo_db

def salvar_instrutor(data):
    db = get_mongo_db()
    return db["instrutor"].insert_one(data)

def listar_instrutores():
    db = get_mongo_db()
    instrutores = list(db["instrutor"].find())
    for i in instrutores:
        i["_id"] = str(i["_id"])
    return instrutores
