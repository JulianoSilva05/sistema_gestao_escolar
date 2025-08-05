# api/rotas_curso.py
from fastapi import APIRouter, HTTPException, Body
from db import get_mongo_db
from bson import ObjectId

router = APIRouter()

@router.get("/api/cursos")
def listar_cursos():
    db = get_mongo_db()
    cursos = list(db["curso"].find())
    for curso in cursos:
        curso["_id"] = str(curso["_id"])
    return cursos

@router.post("/api/cursos")
def criar_curso(curso: dict = Body(...)):
    db = get_mongo_db()
    curso.pop('_id', None)
    inserted = db["curso"].insert_one(curso)
    return {"_id": str(inserted.inserted_id)}

@router.put("/api/cursos/{id}")
def atualizar_curso(id: str, curso: dict = Body(...)):
    db = get_mongo_db()
    curso.pop('_id', None)
    res = db["curso"].update_one({"_id": ObjectId(id)}, {"$set": curso})
    if res.matched_count:
        return {"msg": "Atualizado com sucesso"}
    raise HTTPException(status_code=404, detail="Curso não encontrado")

@router.delete("/api/cursos/{id}")
def deletar_curso(id: str):
    db = get_mongo_db()
    res = db["curso"].delete_one({"_id": ObjectId(id)})
    if res.deleted_count:
        return {"msg": "Removido com sucesso"}
    raise HTTPException(status_code=404, detail="Curso não encontrado")
