from fastapi import APIRouter, HTTPException
from db import get_mongo_db
from bson.objectid import ObjectId

router = APIRouter()

@router.get("/api/instrutores")
def listar_instrutores():
    db = get_mongo_db()
    instrutores = list(db["instrutor"].find())
    for i in instrutores:
        i["_id"] = str(i["_id"])
        i["mapa_competencia"] = [str(uc) for uc in i.get("mapa_competencia",[])]
        i["turnos"] = i.get("turnos", [])
        i["carga_horaria"] = i.get("carga_horaria", 0)
    return instrutores

@router.post("/api/instrutores")
def criar_instrutor(instrutor: dict):
    db = get_mongo_db()
    if "_id" in instrutor: instrutor.pop("_id")
    instrutor["mapa_competencia"] = instrutor.get("mapa_competencia", [])
    instrutor["turnos"] = instrutor.get("turnos", [])
    instrutor["carga_horaria"] = instrutor.get("carga_horaria", 0)
    result = db["instrutor"].insert_one(instrutor)
    instrutor["_id"] = str(result.inserted_id)
    return instrutor

@router.put("/api/instrutores/{id}")
def atualizar_instrutor(id: str, instrutor: dict):
    db = get_mongo_db()
    instrutor.pop("_id", None)
    instrutor["mapa_competencia"] = instrutor.get("mapa_competencia", [])
    instrutor["turnos"] = instrutor.get("turnos", [])
    instrutor["carga_horaria"] = instrutor.get("carga_horaria", 0)
    result = db["instrutor"].update_one({"_id": ObjectId(id)}, {"$set": instrutor})
    if result.matched_count:
        instrutor["_id"] = id
        return instrutor
    raise HTTPException(status_code=404, detail="Instrutor não encontrado")

@router.delete("/api/instrutores/{id}")
def remover_instrutor(id: str):
    db = get_mongo_db()
    result = db["instrutor"].delete_one({"_id": ObjectId(id)})
    if result.deleted_count:
        return {"msg": "Removido com sucesso"}
    raise HTTPException(status_code=404, detail="Instrutor não encontrado")
