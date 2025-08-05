<?php
// Inclusão dos seus arquivos de dados
require_once '../data/dados_turmas.php';
require_once '../data/dados_uc.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Turmas - SENAI</title>
    <link rel="stylesheet" href="../css/style_turmas.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        :root {
            --cor-primaria: #007BFF;
            --cor-sidebar: #004B8D;
            --cor-texto-principal: #004B8D;
            --cor-aviso: #FFC107;
            --cor-perigo: #dc3545;
            --cor-sucesso: #28a745;
            --cor-fundo: #f0f2f5;
            --cor-texto-sidebar: #ffffff;
            --cor-borda: #dee2e6;
            --sombra-caixa: 0 4px 12px rgba(0, 0, 0, 0.08);
            --cor-cinza-texto: #6c757d;
        }


        .content-section {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: var(--sombra-caixa);
        }

        .content-section h2 {
            color: #004B8D;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .search-container .form-control {
            padding-left: 40px;
            height: 45px;
            border-radius: 5px;
            border: 1px solid var(--cor-borda);
        }

        .search-container .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--cor-cinza-texto);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--cor-borda);
        }

        .data-table thead th {
            background-color: var(--cor-primaria);
            color: white;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .data-table .actions {
            text-align: center;
        }

        .btn-icon {
            background: none;
            border: none;
            padding: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            margin: 0 4px;
            transition: transform 0.2s;
        }

        .btn-icon:hover {
            transform: scale(1.2);
        }

        .btn-view i {
            color: var(--cor-aviso);
        }

        .btn-edit i {
            color: var(--cor-primaria);
        }

        .btn-delete i {
            color: var(--cor-perigo);
        }

        /* Modal Base */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            box-shadow: var(--sombra-caixa);
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }

        .modal-header {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--cor-borda);
        }

        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--cor-texto-principal);
            margin: 0;
        }

        .close-button {
            background: none;
            border: none;
            font-size: 2rem;
            color: #888;
            cursor: pointer;
        }

        .modal-body {
            padding: 25px;
            overflow-y: auto;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 20px 25px;
            border-top: 1px solid var(--cor-borda);
        }

        /* Stepper */
        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 33.33%;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #fff;
            border: 3px solid var(--cor-borda);
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: var(--cor-borda);
            transition: all 0.4s ease;
        }

        .step-item:not(:first-child)::before {
            content: '';
            position: absolute;
            top: 15px;
            right: 50%;
            width: 100%;
            height: 3px;
            background-color: var(--cor-borda);
            z-index: -1;
            transition: background-color 0.4s ease;
        }

        .step-item.active .step-circle {
            background-color: var(--cor-primaria);
            color: white;
            border-color: var(--cor-primaria);
        }

        .step-item.active:not(:first-child)::before {
            background-color: var(--cor-primaria);
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: left;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--cor-borda);
            border-radius: 5px;
            font-size: 1rem;
        }

        /* Modal de Visualização com Abas */
        .modal-tabs {
            display: flex;
            border-bottom: 1px solid var(--cor-borda);
            margin-bottom: 20px;
        }

        .tab-button {
            padding: 10px 20px;
            cursor: pointer;
            background-color: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            font-size: 1rem;
            color: var(--cor-cinza-texto);
            margin-bottom: -1px;
            transition: all 0.3s ease;
        }

        .tab-button.active,
        .tab-button:hover {
            color: var(--cor-primaria);
            border-bottom-color: var(--cor-primaria);
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        .info-grid {
            display: grid;
            grid-template-columns: max-content 1fr;
            gap: 10px 20px;
            font-size: 0.95rem;
        }

        .info-grid strong {
            color: #333;
            font-weight: bold;
        }

        .info-grid span {
            color: #555;
        }

        .modal-footer {
            padding: 15px 25px;
            border-top: 1px solid var(--cor-borda);
            text-align: right;
            margin-top: auto;
        }

        /* Modal de UCs */
        #ucModal .modal-content {
            max-width: 950px;
        }

        #uc-rows-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .uc-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .uc-row-order {
            font-weight: bold;
            font-size: 1.1rem;
            min-width: 20px;
        }

        .uc-row .inputs-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 5px;
            background-color: #fdfdfd;
            flex-grow: 1;
        }

        .uc-row .form-group {
            margin-bottom: 0;
            flex: 1 1 auto;
        }

        .uc-row .form-group.small {
            min-width: 60px;
            flex-grow: 0;
        }

        .uc-row .form-group.medium {
            min-width: 150px;
        }

        .uc-row input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .uc-row .btn-add-remove {
            width: 35px;
            height: 35px;
            min-width: 35px;
            padding: 0;
            font-size: 1rem;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
            color: white;
            cursor: pointer;
        }

        .uc-row .btn-add-uc {
            background-color: var(--cor-sucesso);
        }

        .uc-row .btn-remove-uc {
            background-color: var(--cor-perigo);
        }

        .uc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .uc-table th,
        .uc-table td {
            border: 1px solid var(--cor-borda);
            padding: 8px;
            text-align: left;
        }

        .uc-table thead {
            background-color: #f2f2f2;
        }

        .uc-table th {
            font-weight: bold;
        }

        .uc-table .sub-header th {
            font-size: 0.8rem;
            text-align: center;
            background-color: #e9ecef;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../assets/logo.png" alt="Logo SENAI" class="sidebar-logo">
                <h3>Menu Principal</h3>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="gestao_cursos.php"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
                    <li><a href="gestao_turmas.php" class="active"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="gestao_calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Gestão de Turmas</h1>
                <button class="btn btn-primary" id="addTurmaBtn">
                    <i class="fas fa-plus-circle"></i> Adicionar Turma
                </button>
            </header>
            <section class="content-section">
                <h2>Turmas Cadastradas</h2>

                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar por código da turma ou curso...">
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código da Turma</th>
                                <th>Curso</th>
                                <th>Data Inicial</th>
                                <th>Data Final</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="viewModal" class="modal"></div>

    <div id="turmaFormModal" class="modal">
        <div class="modal-content">
            <header class="modal-header">
                <h2 id="modalTitle">Adicionar Turma</h2>
                <button class="close-button" id="closeFormModalBtn">&times;</button>
            </header>
            <div class="modal-body">
                <div class="stepper-wrapper">
                    <div class="step-item active" data-step="1">
                        <div class="step-circle">1</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-circle">2</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-circle">3</div>
                    </div>
                </div>
                <form id="multiStepForm" novalidate>
                    <input type="hidden" id="turmaId" name="turmaId">

                    <div class="form-step active" data-step="1">
                        <div class="form-group"><label for="codigo_turma">Código da Turma:</label><input type="text" id="codigo_turma" required></div>
                        <div class="form-group"><label for="curso">Curso:</label><input type="text" id="curso" required></div>
                        <div class="form-group"><label for="data_inicio">Data de Início:</label><input type="date" id="data_inicio" required></div>
                        <div class="form-group"><label for="data_termino">Data de Término:</label><input type="date" id="data_termino" required></div>
                    </div>

                    <div class="form-step" data-step="2">
                        <div class="form-group"><label for="turno">Turno:</label><select id="turno" required>
                                <option value="">Selecione</option>
                                <option value="MANHA">Manhã</option>
                                <option value="TARDE">Tarde</option>
                                <option value="NOITE">Noite</option>
                                <option value="INTEGRAL">Integral</option>
                                <option value="TARDE/NOITE">Tarde/Noite</option>
                            </select></div>
                        <div class="form-group"><label for="num_alunos">Número de Alunos:</label><input type="number" id="num_alunos" required min="1"></div>
                        <div class="form-group"><label for="instituicao">Instituição:</label><input type="text" id="instituicao" value="SENAI CFP Afonso Bicalho"></div>
                        <div class="form-group"><label for="calendario">Calendário:</label><input type="text" id="calendario" value="Padrão 2025/1"></div>
                        <div class="form-group"><label for="empresa">Empresa/Parceiro:</label><input type="text" id="empresa" value="Comunidade"></div>
                    </div>

                    <div class="form-step" data-step="3">
                        <div class="form-group"><label for="eixo">Eixo Tecnológico:</label><input type="text" id="eixo" value="Informação e Comunicação"></div>
                        <div class="form-group"><label for="categoria">Categoria:</label><input type="text" id="categoria" value="Técnico"></div>
                        <div class="form-group"><label for="modalidade">Modalidade:</label><input type="text" id="modalidade" value="Presencial"></div>
                        <div class="form-group"><label for="tipo">Tipo:</label><input type="text" id="tipo" value="Qualificação"></div>
                        <div class="form-group"><label for="cargaHoraria">Carga horária total:</label><input type="number" id="cargaHoraria" placeholder="Ex: 1200" required min="1"></div>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelFormBtn">Cancelar</button>
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">Voltar</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Próximo</button>
            </div>
        </div>
    </div>

    <div id="ucModal" class="modal">
        <div class="modal-content">
            <header class="modal-header">
                <h2>Cadastrar Unidades Curriculares na Turma</h2>
                <button class="close-button" id="closeUcModalBtn">&times;</button>
            </header>
            <div class="modal-body">
                <h3>Ordem das Unidades Curriculares</h3>
                <div id="uc-rows-container"></div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelUcBtn">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveUcBtn">Salvar Turma e UCs</button>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let turmasData = JSON.parse(JSON.stringify(<?php echo json_encode($turmas); ?>));
            const ucData = <?php echo json_encode($unidades_curriculares); ?>;

            // --- Variáveis Globais ---
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.querySelector('.data-table tbody');

            // Modal de Visualização
            const viewModal = document.getElementById('viewModal');

            // Modal de Formulário (Multi-Step)
            const turmaFormModal = document.getElementById('turmaFormModal');
            const modalTitle = document.getElementById('modalTitle');
            const addTurmaBtn = document.getElementById('addTurmaBtn');
            const closeFormModalBtn = document.getElementById('closeFormModalBtn');
            const cancelFormBtn = document.getElementById('cancelFormBtn');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const multiStepForm = document.getElementById('multiStepForm');
            const formSteps = document.querySelectorAll('.form-step');
            const stepItems = document.querySelectorAll('.step-item');
            let currentStep = 1;
            let turmaEmEdicao = {}; // Objeto temporário para guardar dados entre os modais

            // Modal de UCs
            const ucModal = document.getElementById('ucModal');
            const ucRowsContainer = document.getElementById('uc-rows-container');
            const saveUcBtn = document.getElementById('saveUcBtn');
            const cancelUcBtn = document.getElementById('cancelUcBtn');
            const closeUcModalBtn = document.getElementById('closeUcModalBtn');

            function formatarDataJS(data) {
                if (!data) return '---';
                const [ano, mes, dia] = data.split('-');
                if (ano && mes && dia) return `${dia}/${mes}/${ano}`;
                return '---';
            }

            // --- LÓGICA DO MODAL DE VISUALIZAÇÃO ---
            function openViewModal(turmaId) {
                const turma = turmasData.find(t => t.id == turmaId);
                if (!turma) {
                    alert('Turma não encontrada!');
                    return;
                }

                let ucRowsHtml = '';
                if (turma.unidades_curriculares && turma.unidades_curriculares.length > 0) {
                    turma.unidades_curriculares.forEach(uc => {
                        ucRowsHtml += `<tr><td>${uc.ordem || '---'}</td><td>${uc.descricao || '---'}</td><td>${uc.presencial_ch || '0'}</td><td>${uc.presencial_qa || '0'}</td><td>${uc.presencial_qd || '0'}</td><td>${uc.ead_ch || '0'}</td><td>${uc.ead_qa || '0'}</td><td>${uc.ead_qd || '0'}</td><td>${uc.instrutor || 'A definir'}</td><td>${formatarDataJS(uc.data_inicio)}</td><td>${formatarDataJS(uc.data_termino)}</td></tr>`;
                    });
                } else {
                    ucRowsHtml = '<tr><td colspan="11" style="text-align:center;">Nenhuma unidade curricular encontrada para esta turma.</td></tr>';
                }

                const modalContent = `<div class="modal-content" style="max-width: 900px;"><header class="modal-header"><h2>Dados da Turma: ${turma.codigo_turma}</h2><button class="close-button" id="closeViewModalBtn">&times;</button></header><div class="modal-body"><div class="modal-tabs"><button class="tab-button active" data-target="#info-gerais-pane">Informações Gerais</button><button class="tab-button" data-target="#ucs-pane">Unidades Curriculares</button></div><div id="info-gerais-pane" class="tab-pane active"><div class="info-grid"><strong>Código da Turma:</strong> <span>${turma.codigo_turma || '---'}</span><strong>Curso:</strong> <span>${turma.curso || '---'}</span><strong>Data de Início:</strong> <span>${formatarDataJS(turma.data_inicio)}</span><strong>Data de Término:</strong> <span>${formatarDataJS(turma.data_termino)}</span><strong>Turno:</strong> <span>${turma.turno || '---'}</span><strong>Número de Alunos:</strong> <span>${turma.num_alunos || '---'}</span><strong>Instituição:</strong> <span>${turma.instituicao || '---'}</span><strong>Categoria:</strong> <span>${turma.categoria || '---'}</span></div></div><div id="ucs-pane" class="tab-pane"><div class="table-responsive"><table class="uc-table"><thead><tr><th rowspan="2">Ordem</th><th rowspan="2">Descrição</th><th colspan="3">Presencial</th><th colspan="3">EAD</th><th rowspan="2">Instrutor</th><th rowspan="2">Início</th><th rowspan="2">Fim</th></tr><tr class="sub-header"><th>C.H</th><th>Q.A</th><th>Q.D</th><th>C.H</th><th>Q.A</th><th>Q.D</th></tr></thead><tbody>${ucRowsHtml}</tbody></table></div></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" id="closeViewModalFooterBtn">Fechar</button></div></div>`;
                viewModal.innerHTML = modalContent;
                viewModal.style.display = 'flex';
                document.body.classList.add('modal-open');

                const tabButtons = viewModal.querySelectorAll('.tab-button');
                const tabPanes = viewModal.querySelectorAll('.tab-pane');
                tabButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        tabButtons.forEach(btn => btn.classList.remove('active'));
                        tabPanes.forEach(pane => pane.classList.remove('active'));
                        button.classList.add('active');
                        viewModal.querySelector(button.dataset.target).classList.add('active');
                    });
                });
                document.getElementById('closeViewModalBtn').addEventListener('click', closeViewModal);
                document.getElementById('closeViewModalFooterBtn').addEventListener('click', closeViewModal);
            }

            function closeViewModal() {
                viewModal.style.display = 'none';
                viewModal.innerHTML = '';
                document.body.classList.remove('modal-open');
            }
            viewModal.addEventListener('click', (event) => {
                if (event.target === viewModal) closeViewModal();
            });


            // --- LÓGICA DO FORMULÁRIO MULTI-STEP ---
            function openFormModal(turmaId = null) {
                multiStepForm.reset();
                turmaEmEdicao = {};
                currentStep = 1;
                updateFormStep();

                if (turmaId) { // Modo Edição
                    modalTitle.textContent = 'Editar Turma';
                    const turma = turmasData.find(t => t.id == turmaId);
                    if (turma) {
                        turmaEmEdicao.id = turma.id; // Guarda o ID para o salvamento final
                        // Preenche todos os campos do formulário
                        Object.keys(turma).forEach(key => {
                            const field = document.getElementById(key);
                            if (field) field.value = turma[key];
                        });
                    }
                } else { // Modo Adição
                    modalTitle.textContent = 'Adicionar Turma';
                }
                turmaFormModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }

            function closeFormModal() {
                turmaFormModal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }

            function updateFormStep() {
                formSteps.forEach(step => step.classList.remove('active'));
                formSteps[currentStep - 1].classList.add('active');
                stepItems.forEach((item, index) => {
                    item.classList.toggle('active', index < currentStep);
                });
                prevBtn.style.display = currentStep > 1 ? 'inline-flex' : 'none';
                cancelFormBtn.style.display = currentStep === 1 ? 'inline-flex' : 'none';
                nextBtn.textContent = (currentStep === formSteps.length) ? 'Avançar para UCs' : 'Próximo';
            }

            addTurmaBtn.addEventListener('click', () => openFormModal());
            closeFormModalBtn.addEventListener('click', closeFormModal);
            cancelFormBtn.addEventListener('click', closeFormModal);
            prevBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateFormStep();
                }
            });
            nextBtn.addEventListener('click', () => {
                if (currentStep < formSteps.length) {
                    currentStep++;
                    updateFormStep();
                } else {
                    // Guarda dados do form e abre modal de UCs
                    const formElements = multiStepForm.elements;
                    for (const element of formElements) {
                        if (element.id) turmaEmEdicao[element.id] = element.value;
                    }
                    closeFormModal();
                    openUcModal();
                }
            });

            // --- LÓGICA DO MODAL DE UCs ---
            function openUcModal() {
                ucModal.style.display = 'flex';
                document.body.classList.add('modal-open');
                ucRowsContainer.innerHTML = '';
                // Se estiver editando e a turma já tiver UCs, preenche aqui (opcional)
                const ucsExistentes = turmaEmEdicao.unidades_curriculares || [];
                if (ucsExistentes.length > 0) {
                    ucsExistentes.forEach(uc => addUcRow(uc));
                } else {
                    addUcRow(); // Adiciona a primeira linha em branco
                }
            }

            function closeUcModal() {
                if (confirm('Tem certeza que deseja cancelar? Todas as alterações na turma e UCs serão perdidas.')) {
                    ucModal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                }
            }

            function createUcSelectOptions() {
                let options = '<option value="">Selecione</option>';
                ucData.forEach(uc => {
                    options += `<option value="${uc.id}">${uc.descricao}</option>`;
                });
                return options;
            }

            function addUcRow(uc = {}) {
                const newRow = document.createElement('div');
                newRow.className = 'uc-row';
                const rowIndex = ucRowsContainer.children.length + 1;
                newRow.innerHTML = `<span class="uc-row-order">${rowIndex}º</span><div class="inputs-container"><div class="form-group medium"><label>Descrição</label><select class="uc-select">${createUcSelectOptions()}</select></div><div class="form-group small"><label>Pres. C.H.</label><input type="text" class="uc-presencial-ch" readonly></div><div class="form-group small"><label>Pres. Q.A.</label><input type="text" class="uc-presencial-qa" readonly></div><div class="form-group small"><label>Pres. Q.D.</label><input type="text" class="uc-presencial-qd" readonly></div><div class="form-group small"><label>EAD C.H.</label><input type="text" class="uc-ead-ch" readonly></div><div class="form-group small"><label>EAD Q.A.</label><input type="text" class="uc-ead-qa" readonly></div><div class="form-group small"><label>EAD Q.D.</label><input type="text" class="uc-ead-qd" readonly></div><div class="form-group medium"><label>Instrutor</label><input type="text" class="uc-instrutor"></div><div class="form-group medium"><label>Data Início</label><input type="date" class="uc-data-inicio"></div><div class="form-group medium"><label>Data Fim</label><input type="date" class="uc-data-fim"></div></div><button type="button" class="btn-add-remove btn-add-uc">+</button><button type="button" class="btn-add-remove btn-remove-uc">-</button>`;
                ucRowsContainer.appendChild(newRow);
                updateUcRowButtons();
            }

            function removeUcRow(button) {
                button.closest('.uc-row').remove();
                updateUcRowOrder();
            }

            function updateUcRowButtons() {
                const rows = ucRowsContainer.querySelectorAll('.uc-row');
                rows.forEach((row, index) => {
                    row.querySelector('.btn-remove-uc').style.display = (rows.length > 1) ? 'flex' : 'none';
                });
            }

            function updateUcRowOrder() {
                ucRowsContainer.querySelectorAll('.uc-row').forEach((row, index) => {
                    row.querySelector('.uc-row-order').textContent = `${index + 1}º`;
                });
            }

            ucRowsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-add-uc')) addUcRow();
                if (e.target.classList.contains('btn-remove-uc')) removeUcRow(e.target);
            });
            ucRowsContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('uc-select')) {
                    const selectedId = e.target.value;
                    const selectedUc = ucData.find(uc => uc.id == selectedId);
                    const parentRow = e.target.closest('.uc-row');
                    if (selectedUc) {
                        parentRow.querySelector('.uc-presencial-ch').value = selectedUc.presencial_ch;
                        parentRow.querySelector('.uc-presencial-qa').value = selectedUc.presencial_qa;
                        parentRow.querySelector('.uc-presencial-qd').value = selectedUc.presencial_qd;
                        parentRow.querySelector('.uc-ead-ch').value = selectedUc.ead_ch;
                        parentRow.querySelector('.uc-ead-qa').value = selectedUc.ead_qa;
                        parentRow.querySelector('.uc-ead-qd').value = selectedUc.ead_qd;
                    } else {
                        parentRow.querySelectorAll('input[readonly]').forEach(input => input.value = '');
                    }
                }
            });

            cancelUcBtn.addEventListener('click', closeUcModal);
            closeUcModalBtn.addEventListener('click', closeUcModal);
            saveUcBtn.addEventListener('click', () => {
                const ucsSalvas = [];
                ucRowsContainer.querySelectorAll('.uc-row').forEach((row, index) => {
                    const ucSelect = row.querySelector('.uc-select');
                    const selectedUcData = ucData.find(uc => uc.id == ucSelect.value);
                    if (selectedUcData) {
                        ucsSalvas.push({
                            ordem: index + 1,
                            descricao: selectedUcData.descricao,
                            presencial_ch: row.querySelector('.uc-presencial-ch').value,
                            presencial_qa: row.querySelector('.uc-presencial-qa').value,
                            presencial_qd: row.querySelector('.uc-presencial-qd').value,
                            ead_ch: row.querySelector('.uc-ead-ch').value,
                            ead_qa: row.querySelector('.uc-ead-qa').value,
                            ead_qd: row.querySelector('.uc-ead-qd').value,
                            instrutor: row.querySelector('.uc-instrutor').value,
                            data_inicio: row.querySelector('.uc-data-inicio').value,
                            data_termino: row.querySelector('.uc-data-fim').value
                        });
                    }
                });

                turmaEmEdicao.unidades_curriculares = ucsSalvas;

                if (turmaEmEdicao.turmaId) { // Editando
                    const index = turmasData.findIndex(t => t.id == turmaEmEdicao.turmaId);
                    if (index !== -1) turmasData[index] = turmaEmEdicao;
                } else { // Adicionando
                    const newId = turmasData.length > 0 ? Math.max(...turmasData.map(t => t.id)) + 1 : 1;
                    turmaEmEdicao.id = newId;
                    turmasData.push(turmaEmEdicao);
                }

                ucModal.style.display = 'none';
                document.body.classList.remove('modal-open');
                updateTableDisplay();
            });


            // --- LÓGICA DA TABELA PRINCIPAL ---
            function updateTableDisplay() {
                const searchTerm = searchInput.value.toLowerCase();
                tableBody.innerHTML = '';
                const filteredTurmas = turmasData.filter(turma => (turma.codigo_turma && turma.codigo_turma.toLowerCase().includes(searchTerm)) || (turma.curso && turma.curso.toLowerCase().includes(searchTerm)));
                if (filteredTurmas.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Nenhuma turma encontrada.</td></tr>`;
                    return;
                }

                filteredTurmas.forEach(turma => {
                    const row = `<tr><td>${turma.id}</td><td>${turma.codigo_turma}</td><td>${turma.curso}</td><td>${formatarDataJS(turma.data_inicio)}</td><td>${formatarDataJS(turma.data_termino)}</td><td class="actions"><button class="btn-icon btn-view" data-id="${turma.id}"><i class="fas fa-eye"></i></button><button class="btn-icon btn-edit" data-id="${turma.id}"><i class="fas fa-edit"></i></button><button class="btn-icon btn-delete" data-id="${turma.id}"><i class="fas fa-trash-alt"></i></button></td></tr>`;
                    tableBody.innerHTML += row;
                });
                attachTableActionListeners();
            }

            function attachTableActionListeners() {
                document.querySelectorAll('.btn-view').forEach(button => button.addEventListener('click', (e) => openViewModal(e.currentTarget.dataset.id)));
                document.querySelectorAll('.btn-edit').forEach(button => button.addEventListener('click', (e) => openFormModal(e.currentTarget.dataset.id)));
                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.addEventListener('click', (e) => {
                        if (confirm(`Tem certeza que deseja deletar a turma?`)) {
                            const id = e.currentTarget.dataset.id;
                            turmasData = turmasData.filter(t => t.id != id);
                            updateTableDisplay();
                        }
                    });
                });
            }

            searchInput.addEventListener('input', updateTableDisplay);
            updateTableDisplay(); // Chamada inicial
        });
    </script>

</body>

</html>