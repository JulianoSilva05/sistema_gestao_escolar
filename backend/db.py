from pymongo import MongoClient
import os

def get_mongo_db():
    mongo_url = os.environ.get("MONGO_URL", "mongodb://localhost:27017/")
    client = MongoClient(mongo_url)
    return client["alocacao_senai"]
