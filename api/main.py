from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from rotas_usuario import router as usuario_router
from rotas_curso import router as curso_router
from rotas_instituicao import router as instituicao_router
from rotas_uc import router as uc_router
from rotas_alocacao import router as alocacao_router
from rotas_empresa import router as empresa_router
from rotas_calendario import router as calendario_router
from rotas_instrutor import router as instrutor_router

app = FastAPI()

# Configuração do CORS para permitir comunicação do frontend
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost"], # Permite apenas o seu frontend local
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Inclusão de todas as rotas
app.include_router(usuario_router)
app.include_router(curso_router)
app.include_router(instituicao_router)
app.include_router(uc_router)
app.include_router(alocacao_router)
app.include_router(empresa_router)
app.include_router(calendario_router)
app.include_router(instrutor_router)

@app.get("/")
def status():
    return {"ok": True, "msg": "API de Gestão Escolar SENAI online"}