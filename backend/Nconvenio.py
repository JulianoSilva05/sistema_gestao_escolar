from .db import get_mongo_db

def listar_convenios():
    db = get_mongo_db()
    convenios = list(db["convenio"].find())
    for c in convenios:
        c["_id"] = str(c["_id"])
    return convenios
