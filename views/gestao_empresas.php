<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Empresas - SENAI</title>
    <link rel="stylesheet" href="../css/style_turmas.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.3);
            align-items: center; justify-content: center;
            z-index: 999;
        }
        .modal.show { display: flex !important; }
        .modal-content { background: #fff; border-radius: 10px; padding: 30px; min-width: 320px; max-width: 90vw; position: relative; }
        .close-button { position: absolute; top: 15px; right: 30px; font-size: 2em; cursor: pointer; }
        .alert-error, .alert-success { margin: 10px 0 0 0; padding: 8px 12px; border-radius: 8px; font-size: 1em; }
        .alert-error { background: #fde2e1; color: #b20000; }
        .alert-success { background: #e7f8e2; color: #227b2f; }
        .form-group label { font-weight: bold; }
        .action-buttons { display: flex; gap: 6px; align-items: center; justify-content: center; }
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
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                    <li><a href="gestao_empresas.php" class="active"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="gestao_calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
            <header class="main-header">
                <h1>Gestão de Empresas</h1>
                <button class="btn btn-primary" id="addEmpresaBtn"><i class="fas fa-plus-circle"></i> Adicionar Nova Empresa</button>
            </header>
            <section class="table-section">
                <h2>Empresas Cadastradas</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchEmpresa">Buscar Empresa (Nome, CNPJ):</label>
                        <input type="text" id="searchEmpresa" placeholder="Digite para filtrar..." class="search-input">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome da Empresa/Parceiro</th>
                                <th>CNPJ</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal de Cadastro/Edição -->
    <div id="empresaModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeEmpresaModal">&times;</span>
            <h2 id="modalTitle">Adicionar Nova Empresa</h2>
            <form id="empresaForm" autocomplete="off">
                <input type="hidden" id="empresaId">
                <div id="alertEmpresa" style="display:none"></div>
                <div class="form-group">
                    <label for="instituicaoId">Instituição:</label>
                    <select id="instituicaoId" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nomeEmpresa">Nome da Empresa/Parceiro:</label>
                    <input type="text" id="nomeEmpresa" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="cnpjMatriz">CNPJ:</label>
                    <input type="text" id="cnpjMatriz" maxlength="18" placeholder="00.000.000/0001-00">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Empresa</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times-circle"></i> Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal Visualizar Empresa -->
    <div id="visualizarEmpresaModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeVisualizarEmpresa">&times;</span>
            <h2>Detalhes da Empresa</h2>
            <form>
                <div class="form-group">
                    <label>Instituição:</label>
                    <input type="text" id="viewInstituicao" readonly>
                </div>
                <div class="form-group">
                    <label>Nome da Empresa/Parceiro:</label>
                    <input type="text" id="viewNomeEmpresa" readonly>
                </div>
                <div class="form-group">
                    <label>CNPJ:</label>
                    <input type="text" id="viewCnpjMatriz" readonly>
                </div>
                <button type="button" class="btn btn-secondary" id="fecharVisualizarEmpresa">Fechar</button>
            </form>
        </div>
    </div>

    <script>
        const API_EMPRESA = '../backend/processa_empresa.php';
        let empresasData = [];
        let instituicoesMap = {};

        // Elementos
        const empresaModal = document.getElementById('empresaModal');
        const addEmpresaBtn = document.getElementById('addEmpresaBtn');
        const closeEmpresaModal = document.getElementById('closeEmpresaModal');
        const cancelBtn = empresaModal.querySelector('#cancelBtn');
        const empresaForm = document.getElementById('empresaForm');
        const modalTitle = document.getElementById('modalTitle');
        const dataTableBody = document.querySelector('.data-table tbody');
        const searchEmpresaInput = document.getElementById('searchEmpresa');

        const empresaIdInput = document.getElementById('empresaId');
        const nomeEmpresaInput = document.getElementById('nomeEmpresa');
        const cnpjMatrizInput = document.getElementById('cnpjMatriz');
        const instituicaoSelect = document.getElementById('instituicaoId');
        const alertEmpresa = document.getElementById('alertEmpresa');

        // Modal Visualizar
        const visualizarEmpresaModal = document.getElementById('visualizarEmpresaModal');
        const closeVisualizarEmpresa = document.getElementById('closeVisualizarEmpresa');
        const fecharVisualizarEmpresa = document.getElementById('fecharVisualizarEmpresa');
        const viewInstituicao = document.getElementById('viewInstituicao');
        const viewNomeEmpresa = document.getElementById('viewNomeEmpresa');
        const viewCnpjMatriz = document.getElementById('viewCnpjMatriz');

        // Carrega instituições
        async function carregarInstituicoes() {
            instituicaoSelect.innerHTML = `<option value="">Selecione</option>`;
            const resp = await fetch('../backend/processa_instituicao.php');
            const lista = await resp.json();
            instituicoesMap = {};
            lista.forEach(inst => {
                instituicoesMap[inst._id] = inst.razao_social;
                instituicaoSelect.innerHTML += `<option value="${inst._id}">${inst.razao_social}</option>`;
            });
        }

        // Carrega empresas
        async function carregarEmpresas() {
            const resp = await fetch(API_EMPRESA);
            empresasData = await resp.json();
            updateTableDisplay();
        }

        // Renderiza tabela
        function updateTableDisplay() {
            dataTableBody.innerHTML = '';
            const searchTerm = (searchEmpresaInput.value || '').toLowerCase();
            const filteredEmpresas = empresasData.filter(empresa => {
                const searchString = `${empresa.razao_social || ''} ${empresa.cnpj || ''}`.toLowerCase();
                return searchString.includes(searchTerm);
            });

            if (filteredEmpresas.length === 0) {
                const noDataRow = dataTableBody.insertRow();
                noDataRow.innerHTML = '<td colspan="4">Nenhuma empresa encontrada com os filtros aplicados.</td>';
                return;
            }

            filteredEmpresas.forEach(empresa => {
                const row = dataTableBody.insertRow();
                row.innerHTML = `
                    <td>${empresa._id}</td>
                    <td>${empresa.razao_social || ''}</td>
                    <td>${empresa.cnpj || ''}</td>
                    <td class="actions">
                        <button class="btn btn-icon btn-view" title="Visualizar" data-id="${empresa._id}"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-icon btn-edit" title="Editar" data-id="${empresa._id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="${empresa._id}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
            });
            attachTableActionListeners();
        }

        function attachTableActionListeners() {
            document.querySelectorAll('.btn-view').forEach(button => {
                button.onclick = (e) => {
                    const empresa = empresasData.find(emp => emp._id === e.currentTarget.dataset.id);
                    openVisualizarEmpresaModal(empresa);
                };
            });
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.onclick = (e) => openEditModal(e.currentTarget.dataset.id);
            });
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.onclick = (e) => deleteEmpresa(e.currentTarget.dataset.id);
            });
        }

        function openVisualizarEmpresaModal(empresa) {
            viewInstituicao.value = instituicoesMap[empresa.instituicao_id] || '';
            viewNomeEmpresa.value = empresa.razao_social || '';
            viewCnpjMatriz.value = empresa.cnpj || '';
            visualizarEmpresaModal.classList.add('show');
            document.body.classList.add('modal-open');
        }
        function closeVisualizarEmpresaModal() {
            visualizarEmpresaModal.classList.remove('show');
            document.body.classList.remove('modal-open');
        }

        async function openEditModal(id) {
            const empresa = empresasData.find(e => e._id == id);
            if (empresa) {
                modalTitle.textContent = "Editar Empresa";
                empresaIdInput.value = empresa._id;
                nomeEmpresaInput.value = empresa.razao_social || '';
                cnpjMatrizInput.value = empresa.cnpj || '';
                await carregarInstituicoes();
                instituicaoSelect.value = empresa.instituicao_id || '';
                empresaModal.classList.add('show');
                document.body.classList.add('modal-open');
            }
        }
        async function deleteEmpresa(id) {
            if (confirm("Tem certeza que deseja excluir a empresa?")) {
                await fetch(API_EMPRESA + '?id=' + id, { method: 'DELETE' });
                carregarEmpresas();
            }
        }

        // Validação de dados
         function validateEmpresaForm() {
        alertEmpresa.style.display = "none";
        alertEmpresa.textContent = "";
        alertEmpresa.className = "";
        const nome = nomeEmpresaInput.value.trim();
        const cnpj = cnpjMatrizInput.value.trim();
        const instituicao = instituicaoSelect.value;
        // Nome - obrigatório, entre 2 e 100 caracteres, sem caracteres especiais
        if (!nome || nome.length < 2 || nome.length > 100 || /[<>"';{}]/g.test(nome)) {
            showAlertEmpresa("Nome da Empresa/Parceiro obrigatório, 2-100 caracteres e sem caracteres especiais.", "error");
            nomeEmpresaInput.focus();
            return false;
        }
        // CNPJ: se preenchido, deve ser válido
        if (cnpj && !/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/.test(cnpj)) {
            showAlertEmpresa("Se preenchido, o CNPJ deve estar no formato 00.000.000/0001-00.", "error");
            cnpjMatrizInput.focus();
            return false;
        }
        // Instituição obrigatória
        if (!instituicao) {
            showAlertEmpresa("Selecione uma instituição.", "error");
            instituicaoSelect.focus();
            return false;
        }
        return true;
        }
        function showAlertEmpresa(msg, type = "error") {
            alertEmpresa.textContent = msg;
            alertEmpresa.className = (type === "error" ? "alert-error" : "alert-success");
            alertEmpresa.style.display = "block";
        }
        [nomeEmpresaInput, cnpjMatrizInput, instituicaoSelect].forEach(input => {
            input.addEventListener("input", () => {
                alertEmpresa.textContent = "";
                alertEmpresa.className = "";
                alertEmpresa.style.display = "none";
            });
        });

        // CRUD
        empresaForm.onsubmit = async function (event) {
            event.preventDefault();
            if (!validateEmpresaForm()) return;
            const id = empresaIdInput.value;
            const payload = {
                razao_social: nomeEmpresaInput.value.trim(),
                cnpj: cnpjMatrizInput.value.trim(),
                instituicao_id: instituicaoSelect.value
            };
            if (id) {
                await fetch(API_EMPRESA + '?id=' + id, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
            } else {
                await fetch(API_EMPRESA, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
            }
            closeEmpresaModalFn();
            setTimeout(() => {
                alert('Empresa salva com sucesso!');
                carregarEmpresas();
            }, 200);
        };

        function closeEmpresaModalFn() {
            empresaModal.classList.remove('show');
            empresaForm.reset();
            modalTitle.textContent = "Adicionar Nova Empresa";
            empresaIdInput.value = '';
            alertEmpresa.textContent = "";
            alertEmpresa.className = "";
            alertEmpresa.style.display = "none";
            document.body.classList.remove('modal-open');
        }

        // --- Event Listeners ---
        addEmpresaBtn.onclick = async function () {
            modalTitle.textContent = "Adicionar Nova Empresa";
            empresaForm.reset();
            empresaIdInput.value = '';
            await carregarInstituicoes();
            empresaModal.classList.add('show');
            document.body.classList.add('modal-open');
        };
        closeEmpresaModal.onclick = closeEmpresaModalFn;
        cancelBtn.onclick = closeEmpresaModalFn;
        searchEmpresaInput.oninput = updateTableDisplay;
        closeVisualizarEmpresa.onclick = closeVisualizarEmpresaModal;
        fecharVisualizarEmpresa.onclick = closeVisualizarEmpresaModal;
        window.onclick = (event) => {
            if (event.target == empresaModal) closeEmpresaModalFn();
            if (event.target == visualizarEmpresaModal) closeVisualizarEmpresaModal();
        };

        document.addEventListener('DOMContentLoaded', async function () {
            await carregarInstituicoes();
            await carregarEmpresas();
        });
    </script>
</body>
</html>
