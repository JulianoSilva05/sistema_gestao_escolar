from jose import jwt, JWTError
from datetime import datetime, timedelta
from fastapi import HTTPException, Request, status, Depends

# É altamente recomendável mover esta chave para uma variável de ambiente
SECRET_KEY = "uma-chave-secreta-muito-forte-e-dificil-de-adivinhar-12345"
ALGORITHM = "HS256"
SESSION_EXP_MINUTES = 60

def criar_token(data: dict, expires_delta: timedelta = None):
    to_encode = data.copy()
    expire = datetime.utcnow() + (expires_delta or timedelta(minutes=SESSION_EXP_MINUTES))
    to_encode.update({"exp": expire})
    encoded_jwt = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)
    return encoded_jwt

def verificar_token(token: str):
    credentials_exception = HTTPException(
        status_code=status.HTTP_401_UNAUTHORIZED,
        detail="Token inválido ou expirado. Faça login novamente.",
        headers={"WWW-Authenticate": "Bearer"},
    )
    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        user_name: str = payload.get("sub")
        if user_name is None:
            raise credentials_exception
        return user_name
    except JWTError:
        raise credentials_exception

async def autenticar_usuario_dep(request: Request):
    """
    Dependência FastAPI para proteger rotas. Verifica o cookie da sessão.
    """
    token = request.cookies.get("session_token")
    if not token:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Não autenticado. Faça login para acessar."
        )
    username = verificar_token(token)
    return {"username": username}