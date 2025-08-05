# models.py
from pydantic import BaseModel, Field

class UsuarioLogin(BaseModel):
    user_name: str = Field(..., min_length=4, max_length=50, example="admin")
    senha: str = Field(..., min_length=4, max_length=50, example="1234")
