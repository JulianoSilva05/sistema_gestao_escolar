from fastapi import FastAPI, Request
from pydantic import BaseModel
from usuario import listar_usuarios  

app = FastAPI()

class LoginData(BaseModel):
    login: str
    senha: str

@app.post("/api/login")
def login(data: LoginData):
    usuarios = listar_usuarios()
    for u in usuarios:
        if u["login"] == data.login and u["senha"] == data.senha:
            return {"ok": True, "username": u["login"]}
    return {"ok": False}
