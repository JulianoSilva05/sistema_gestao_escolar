
# Sistema de Gestão SENAI

## Descrição

Este projeto é um **sistema de gestão acadêmica** que integra **FastAPI** (Python) e **PHP** para o gerenciamento da coordenação de cursos do Senai em Betim.
Ele utiliza **MongoDB Atlas** como banco de dados na nuvem, garantindo escalabilidade e segurança.

---

## Estrutura do Projeto
```
|- api/                       # Backend em Python (FastAPI)
|   |-- auth_utils.py         # Funções JWT
|   |-- auth.py               # Funções de hash de senha
|   |-- curso.py              # Operações CRUD de cursos
|   |-- db.py                 # Conexão com MongoDB
|   |-- main.py               # Inicialização do FastAPI
|   |-- models.py             # Modelos Pydantic
|   |-- rotas_curso.py        # Rotas de cursos
|   |-- rotas_empresa.py      # Rotas de empresas
|   |-- rotas_instituicao.py  # Rotas de instituições
|   |-- rotas_uc.py           # Rotas de unidades curriculares
|   |-- rotas_usuario.py      # Rotas de login
|   |-- usuario.py            # Operações de usuários
|- backend/                   # Scripts PHP para operações
|- config/
|   |-- config.php            # Configurações gerais
|- css/                       # Estilização
|- views/                     # Páginas HTML/PHP do painel
|- assets/                    # Imagens
```

---

## Requisitos

- **XAMPP**
- **Python 3.10+**
- **PHP 8.0+**
- **MongoDB Atlas** (acessar site online) *acesso online, com o login e senha do criador. Entre em contato para solicitar o acesso
- **Bibliotecas Python**:
  - fastapi
  - uvicorn
  - pymongo
  - python-jose
  - bcrypt
  - python-dotenv

---

## Instalação

### 1. Clonar o repositório
```bash
git clone https://github.com/LorranyMarim/sistema_gestao_senai.git
cd seu-repositorio
```
### 2. Instalar dependências
```bash
pip install -r requirements.txt
```
---

## Arquivo `requirements.txt`
```
fastapi
uvicorn
pymongo
python-jose
bcrypt
python-dotenv
```
---

# Execução do Projeto:

#### Observação: Banco de Dados: O sistema usa MongoDB Atlas. No arquivo `api/db.py` a URL padrão já está configurada. A base de dados se chama "senai_betim_bd". Para acessar a base de dados é necessário fazer download do mongo e criar um cluster com o mesmo nome. Depois, é necessário carregar as coleções manualmente. Importante, é aconselhável que não faça esse processo, pois, pode gerar duplicidade e inconsistÊncia nos dados.
---

## 1º Passo: Executando o Painel XAMPP
1. Faça o clone do projeto ou baixe o arquivo .zip
2. Coloque os arquivos do projeto dentro de `htdocs`
3. Acesse no navegador:
```
http://localhost/seu-projeto/views/index.php
```


## 2º Passo: Executando o Backend (API)
Dentro da pasta do projeto, dentro da pasta 'api', abra o terminal e rode o código abaixo:
```bash
uvicorn api.main:app --reload
```
A API estará disponível em:
```
http://127.0.0.1:8000
```
