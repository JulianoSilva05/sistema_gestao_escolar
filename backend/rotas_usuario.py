from fastapi import APIRouter, HTTPException
from models import UsuarioLogin, UsuarioOut
from usuario import buscar_usuario_por_username
from auth import verificar_senha

router = APIRouter()

@router.post("/api/login", response_model=UsuarioOut)
def login(dados: UsuarioLogin):
    usuario = buscar_usuario_por_username(dados.user_name)
    if not usuario:
        raise HTTPException(status_code=401, detail="Usuário não encontrado")
    if not verificar_senha(dados.senha, usuario['senha']):
        raise HTTPException(status_code=401, detail="Senha incorreta")
    # Monta objeto para retornar ao frontend (sem a senha)
    return UsuarioOut(
        id=usuario["id"],
        nome=usuario["nome"],
        tipo_acesso=usuario["tipo_acesso"],
        user_name=usuario["user_name"],
        instituicao_id=usuario["instituicao_id"]
    )
