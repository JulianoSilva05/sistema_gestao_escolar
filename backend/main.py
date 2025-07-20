from fastapi import FastAPI
from rotas_usuario import router as usuario_router

app = FastAPI()
app.include_router(usuario_router)

@app.get("/")
def status():
    return {"ok": True, "msg": "API online"}
