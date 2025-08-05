from fastapi import APIRouter
from db import get_mongo_db

router = APIRouter()
@router.get("/api/instituicoes")
def listar_instituicoes():
    db = get_mongo_db()
    instituicoes = list(db["instituicao"].find())
    for inst in instituicoes:
        inst["_id"] = str(inst["_id"])
    return instituicoes