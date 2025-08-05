import bcrypt

def hash_senha(senha: str) -> str:
    hashed = bcrypt.hashpw(senha.encode(), bcrypt.gensalt())
    return hashed.decode()

def verificar_senha(senha: str, senha_hashed: str) -> bool:
    return bcrypt.checkpw(senha.encode(), senha_hashed.encode())
