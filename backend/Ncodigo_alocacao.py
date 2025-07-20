import pandas as pd
from pymongo import MongoClient
from datetime import datetime, timedelta

CAMINHO = r"C:\Users\Lorrany Marim\Documents\projeto_senai_final"
ARQUIVO_GERAL = "relatorio_geral_professores.xlsx"

def get_mongo_db():
    client = MongoClient("mongodb://localhost:27017/")
    return client["alocacao_senai"]

db = get_mongo_db()

turmas = list(db["turma"].find())
ucs = {str(uc["_id"]): uc for uc in db["unidade_curricular"].find()}
instrutores = list(db["instrutor"].find())
calendario = list(db["calendario_academico"].find())

# Função para obter dias letivos válidos para uma turma (com base no calendário_academico)
def get_dias_letivos_validos(turma_id):
    return sorted([
        c['data'] for c in calendario
        if (c.get('turma_id') == turma_id or not c.get('turma_id')) 
        and c.get('descricao', '').lower() not in ['aula ead', 'recesso escolar', 'feriado', 'recesso - férias']
    ])

# Função para obter exceções (todos dias NÃO letivos para a turma)
def get_excecoes(turma_id):
    return set([
        c['data'] for c in calendario
        if (c.get('turma_id') == turma_id or not c.get('turma_id'))
        and c.get('descricao', '').lower() in ['recesso escolar', 'feriado', 'recesso - férias']
    ])

# Preparar rodízio de instrutores por turno e competência para a UC
def get_ordem_professores(turno, uc_id):
    ordem = []
    for t in instrutores:
        # turnos: {'manha': True, 'tarde': False, ...}
        if t.get('turnos', {}).get(turno, False):
            # Verifica competência pela UC no mapa_competencia
            if any(str(cid.get("$oid", cid)) == uc_id for cid in t.get('mapa_competencia', [])):
                ordem.append(t['nome'])
    return ordem

def professor_disponivel(instrutor, datas_uc, turno, ocupacoes):
    for dia in datas_uc:
        if ocupacoes.get((instrutor, turno, dia)):
            return False
    return True

def gerar_cronograma_e_alocacao():
    relatorios = {}
    linhas_geral = []

    for turma in turmas:
        tid = turma.get("_id")
        if isinstance(tid, dict) and "$oid" in tid:
            tid = tid["$oid"]
        codigo_turma = turma.get("codigo")
        turno = turma.get("turno", "").lower()
        ucs_turma = turma["unidades_curriculares"]

        # Dias letivos válidos para a turma
        dias_letivos = get_dias_letivos_validos(tid)

        # Ordena UCs: concluídas primeiro, depois pendentes
        concluidas = [uc for uc in ucs_turma if uc.get("status") == "concluido"]
        pendentes = [uc for uc in ucs_turma if uc.get("status") != "concluido"]
        ucs_ordenadas = concluidas + pendentes

        relatorios[tid] = []
        ocupacoes = {}  # (prof, turno, dia): True
        data_idx = 0

        for uc in ucs_ordenadas:
            uc_id = str(uc.get("uc_id") or uc.get("_id"))
            nome_uc = uc.get("descricao") or ucs.get(uc_id, {}).get("descricao", uc_id)
            # Busca dias_letivos da UC diretamente do array da turma!
            qtd_dias = uc.get("dias_letivos") or ucs.get(uc_id, {}).get("dias_letivos") or 0
            qtd_dias = int(qtd_dias)
            if qtd_dias == 0:
                continue

            # Gera as datas da UC
            datas_uc = []
            while len(datas_uc) < qtd_dias and data_idx < len(dias_letivos):
                data_candidato = dias_letivos[data_idx]
                datas_uc.append(data_candidato)
                data_idx += 1

            if not datas_uc or len(datas_uc) < qtd_dias:
                # Não há dias letivos suficientes para essa UC
                continue

            data_inicio_uc = datas_uc[0]
            data_fim_uc = datas_uc[-1]
            status_uc = uc.get("status", "pendente")

            # Alocação de instrutor (somente para UCs pendentes)
            if status_uc == "concluido":
                instrutor = "UC já concluída"
            else:
                ordem_professores = get_ordem_professores(turno, uc_id)
                ciclo_prof = 0
                encontrado = None
                tentativas = 0
                while ordem_professores and tentativas < len(ordem_professores):
                    instrutor = ordem_professores[ciclo_prof]
                    if professor_disponivel(instrutor, datas_uc, turno, ocupacoes):
                        encontrado = instrutor
                        for dia in datas_uc:
                            ocupacoes[(instrutor, turno, dia)] = True
                        break
                    ciclo_prof = (ciclo_prof + 1) % len(ordem_professores)
                    tentativas += 1
                if encontrado:
                    instrutor = encontrado
                else:
                    instrutor = "SEM instrutor DISPONÍVEL"

            relatorios[tid].append({
                "id_turma": tid,
                "codigo_turma": codigo_turma,
                "data_inicio_turma": turma.get("data_inicio"),
                "nome_uc": nome_uc,
                "data_inicio_uc": data_inicio_uc,
                "data_fim_uc": data_fim_uc,
                "status_uc": status_uc,
                "instrutor": instrutor,
            })

    # Gerar relatório geral consolidado
    for tid, rows in relatorios.items():
        for row in rows:
            linhas_geral.append(row)

    df_geral = pd.DataFrame(linhas_geral)
    saida = f"{CAMINHO}\\{ARQUIVO_GERAL}"
    df_geral.to_excel(saida, index=False)
    print(f"Relatório geral salvo em {saida}")

if __name__ == "__main__":
    gerar_cronograma_e_alocacao()
