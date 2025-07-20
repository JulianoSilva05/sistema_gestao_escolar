from pydantic import BaseModel, Field

class UsuarioLogin(BaseModel):
    user_name: str = Field(..., example="lorrany.marim")
    senha: str = Field(..., example="1234")

class UsuarioOut(BaseModel):
    id: str
    nome: str
    tipo_acesso: str
    user_name: str
    instituicao_id: str
