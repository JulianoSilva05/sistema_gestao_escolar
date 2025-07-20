from .db import get_mongo_db

def salvar_curso(data):
    db = get_mongo_db()
    return db["curso"].insert_one(data)

def listar_cursos():
    db = get_mongo_db()
    cursos = list(db["curso"].find())
    for curso in cursos:
        curso["_id"] = str(curso["_id"])
    return cursos
