from db import get_mongo_db
from bson import ObjectId

def buscar_usuario_por_username(user_name):
    db = get_mongo_db()
    usuario = db["usuario"].find_one({"user_name": user_name})
    if usuario:
        usuario["id"] = str(usuario["_id"])
    return usuario

def salvar_usuario(usuario_dict):
    db = get_mongo_db()
    result = db["usuario"].insert_one(usuario_dict)
    return str(result.inserted_id)
