from fastapi import APIRouter, HTTPException, Body
from db import get_mongo_db
from bson import ObjectId
from pydantic import BaseModel, Field, validator
from typing import Literal
import re

router = APIRouter()

FORBIDDEN_CHARS = re.compile(r'[<>"\';{}]')

class UnidadeCurricularModel(BaseModel):
    descricao: str = Field(..., min_length=2, max_length=100)
    sala_ideal: str = Field(..., min_length=2, max_length=100)
    instituicao_id: str = Field(..., min_length=2, max_length=100)
    status: Literal['Ativa', 'Inativa']

    @validator('descricao', 'sala_ideal', 'instituicao_id', pre=True)
    def sanitize_and_check_chars(cls, v):
        if not isinstance(v, str):
            raise ValueError("Valor inválido.")
        val = v.strip()
        if FORBIDDEN_CHARS.search(val):
            raise ValueError("O campo contém caracteres não permitidos.")
        return val

@router.get("/api/unidades_curriculares")
def listar_ucs():
    db = get_mongo_db()
    ucs = list(db["unidade_curricular"].find())
    for uc in ucs:
        uc["_id"] = str(uc["_id"])
    return ucs

@router.post("/api/unidades_curriculares")
def criar_uc(uc: UnidadeCurricularModel):
    db = get_mongo_db()
    data = uc.dict()
    data['status'] = data['status'].capitalize()
    data.pop('_id', None)
    inserted = db["unidade_curricular"].insert_one(data)
    return {"_id": str(inserted.inserted_id)}

@router.put("/api/unidades_curriculares/{id}")
def atualizar_uc(id: str, uc: UnidadeCurricularModel):
    db = get_mongo_db()
    data = uc.dict()
    data['status'] = data['status'].capitalize()
    data.pop('_id', None)
    res = db["unidade_curricular"].update_one({"_id": ObjectId(id)}, {"$set": data})
    if res.matched_count:
        return {"msg": "Atualizado com sucesso"}
    raise HTTPException(status_code=404, detail="UC não encontrada")

@router.delete("/api/unidades_curriculares/{id}")
def deletar_uc(id: str):
    db = get_mongo_db()
    res = db["unidade_curricular"].delete_one({"_id": ObjectId(id)})
    if res.deleted_count:
        return {"msg": "Removido com sucesso"}
    raise HTTPException(status_code=404, detail="UC não encontrada")
