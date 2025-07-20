from .db import get_mongo_db

def salvar_uc(data):
    db = get_mongo_db()
    return db["unidade_curricular"].insert_one(data)

def listar_ucs():
    db = get_mongo_db()
    ucs = list(db["unidade_curricular"].find())
    for uc in ucs:
        uc["_id"] = str(uc["_id"])
    return ucs

def existe_descricao(descricao, instituicao_id):
    db = get_mongo_db()
    desc_normalizada = descricao.strip().lower()
    # Verifica se existe UC igual na mesma instituição
    return db["unidade_curricular"].find_one({
        "descricao": {"$regex": f"^{desc_normalizada}$", "$options": "i"},
        "instituicao_id": instituicao_id
    }) is not None
