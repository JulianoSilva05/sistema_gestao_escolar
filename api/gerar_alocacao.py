import pandas as pd
from pymongo import MongoClient
from datetime import datetime, timedelta

CAMINHO = r"C:\Users\Lorrany Marim\Documents\projeto_senai_final"
ARQUIVO_GERAL = "relatorio_geral_professores.xlsx"

def get_mongo_db():
    client = MongoClient("mongodb://localhost:27017/")
    return client["senai_betim_bd"]

db = get_mongo_db()

turmas = list(db["turma"].find())
ucs = {str(uc["_id"]): uc for uc in db["unidade_curricular"].find()}
instrutores = list(db["instrutor"].find())
calendario = list(db["calendario_academico"].find())

print("TOTAL TURMAS:", len(turmas))
print("TOTAL UCS:", len(ucs))
print("TOTAL INSTRUTORES:", len(instrutores))
print("TOTAL CALENDARIO:", len(calendario))

def buscar_excecoes(turma):
    tid = turma.get("_id")
    if isinstance(tid, dict) and "$oid" in tid:
        tid = tid["$oid"]
    excecoes = set()
    for ev in calendario:
        ev_tid = ev.get('turma_id')
        if isinstance(ev_tid, dict) and "$oid" in ev_tid:
            ev_tid = ev_tid["$oid"]
        # Todo evento exceto "aula ead" é exceção
        if (ev_tid == tid or not ev_tid) and ev.get('descricao', '').lower() != 'aula ead':
            excecoes.add(ev['data'])
    return excecoes

def get_ordem_professores(turno, uc_id):
    ordem = []
    for t in instrutores:
        if t.get('turnos', {}).get(turno, False):
            # Verifica competência
            if any(str(cid) == uc_id for cid in t.get('mapa_competencia', [])):
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
        print(f"\nTURMA: {tid} - {turma.get('codigo')}")

        ucs_turma = turma.get("unidades_curriculares", [])
        print(f"  Qtd UCs: {len(ucs_turma)}")
        for uc in ucs_turma:
            print(f"    UC: {uc.get('descricao')}, status={uc.get('status')}, dias_letivos={uc.get('dias_letivos')}, uc_id={uc.get('uc_id')}")

        codigo_turma = turma.get("codigo")
        turno = turma.get("turno", "").lower()

        # Ordena UCs: concluídas primeiro, depois pendentes
        concluidas = [uc for uc in ucs_turma if uc.get("status") == "concluido"]
        pendentes = [uc for uc in ucs_turma if uc.get("status") != "concluido"]
        ucs_ordenadas = concluidas + pendentes

        relatorios[tid] = []
        ocupacoes = {}  # (prof, turno, dia): True

        # Prepara exceções e inicia pelo data_inicio da turma
        excecoes = buscar_excecoes(turma)
        data_atual = turma.get("data_inicio")
        if not data_atual:
            print(f"  Turma {codigo_turma} sem data_inicio! Pulando.")
            continue

        for uc in ucs_ordenadas:
            uc_id = str(uc.get("uc_id") or uc.get("_id"))
            nome_uc = uc.get("descricao") or ucs.get(uc_id, {}).get("descricao", uc_id)
            qtd_dias = uc.get("dias_letivos") or ucs.get(uc_id, {}).get("dias_letivos") or 0
            qtd_dias = int(qtd_dias)
            if qtd_dias == 0:
                print(f"    UC {nome_uc} sem dias_letivos, pulando.")
                continue

            # Gera as datas da UC, avançando a partir de data_atual, pulando exceções e fins de semana
            datas_uc = []
            data_temp = data_atual
            while len(datas_uc) < qtd_dias:
                dt = datetime.strptime(data_temp, "%Y-%m-%d")
                if dt.weekday() < 5 and data_temp not in excecoes:
                    datas_uc.append(data_temp)
                data_temp = (dt + timedelta(days=1)).strftime("%Y-%m-%d")

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
            # Próxima UC deve começar no dia seguinte ao final desta
            data_atual = (datetime.strptime(data_fim_uc, "%Y-%m-%d") + timedelta(days=1)).strftime("%Y-%m-%d")

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
