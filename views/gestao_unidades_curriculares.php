<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Unidades Curriculares - SENAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style_turmas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.3);
            align-items: center;
            justify-content: center;
            z-index: 999;
        }
        .modal.show { display: flex !important; }
        .modal-content {
            background: #fff; border-radius: 10px; padding: 30px;
            min-width: 320px; max-width: 90vw; position: relative;
        }
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
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php" class="active"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="gestao_calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
            <header class="main-header">
                <h1>Gestão de Unidades Curriculares</h1>
                <button class="btn btn-primary" id="addUcBtn"><i class="fas fa-plus-circle"></i> Adicionar Nova UC</button>
            </header>
            <section class="table-section">
                <h2>Unidades Curriculares Cadastradas</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchUc">Buscar UC:</label>
                        <input type="text" id="searchUc" placeholder="Digite para filtrar..." class="search-input">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Instituição</th>
                                <th>Descrição da Unidade Curricular</th>
                                <th>Sala Ideal</th>
                                <th>Status</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="ucTableBody"></tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal UC -->
    <div id="ucModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModalBtn">&times;</span>
            <h2 id="modalTitleUc">Adicionar Nova Unidade Curricular</h2>
            <form id="ucForm" autocomplete="off">
                <input type="hidden" id="ucId">
                <div id="alertUc" style="display:none"></div>
                <div class="form-group">
                    <label for="instituicaoUc">Instituição:</label>
                    <select id="instituicaoUc" required>
                        <option value="">Selecione a instituição</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descricaoUc">Descrição da UC:</label>
                    <input type="text" id="descricaoUc" required minlength="2" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="salaIdeal">Sala Ideal:</label>
                    <input type="text" id="salaIdeal" required minlength="2" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="statusUc">Status:</label>
                    <select id="statusUc" required>
                        <option value="Ativa" selected>Ativa</option>
                        <option value="Inativa">Inativa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar UC</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times-circle"></i> Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal Visualizar UC -->
    <div id="visualizarUcModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeVisualizarUcBtn">&times;</span>
            <h2>Detalhes da Unidade Curricular</h2>
            <form>
                <div class="form-group">
                    <label>Instituição:</label>
                    <input type="text" id="viewInstituicaoUc" readonly>
                </div>
                <div class="form-group">
                    <label>Descrição da UC:</label>
                    <input type="text" id="viewDescricaoUc" readonly>
                </div>
                <div class="form-group">
                    <label>Sala Ideal:</label>
                    <input type="text" id="viewSalaIdealUc" readonly>
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <input type="text" id="viewStatusUc" readonly>
                </div>
                <button type="button" class="btn btn-secondary" id="fecharVisualizarUcBtn">Fechar</button>
            </form>
        </div>
    </div>

    <script>
        // Sidebar
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const dashboardContainer = document.querySelector('.dashboard-container');
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            dashboardContainer.classList.toggle('sidebar-active');
        });
        dashboardContainer.addEventListener('click', (event) => {
            if (dashboardContainer.classList.contains('sidebar-active') && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
                dashboardContainer.classList.remove('sidebar-active');
            }
        });

        // Globals & elements
        let instituicoesCache = [];
        let ucsCache = [];
        let ucEditId = null;

        const ucModal = document.getElementById('ucModal');
        const addUcBtn = document.getElementById('addUcBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const ucForm = document.getElementById('ucForm');
        const modalTitleUc = document.getElementById('modalTitleUc');
        const ucIdInput = document.getElementById('ucId');
        const descricaoUcInput = document.getElementById('descricaoUc');
        const salaIdealInput = document.getElementById('salaIdeal');
        const selectInstituicao = document.getElementById('instituicaoUc');
        const statusUc = document.getElementById('statusUc');
        const alertUc = document.getElementById('alertUc');

        const visualizarUcModal = document.getElementById('visualizarUcModal');
        const closeVisualizarUcBtn = document.getElementById('closeVisualizarUcBtn');
        const fecharVisualizarUcBtn = document.getElementById('fecharVisualizarUcBtn');
        const viewInstituicaoUc = document.getElementById('viewInstituicaoUc');
        const viewDescricaoUc = document.getElementById('viewDescricaoUc');
        const viewSalaIdealUc = document.getElementById('viewSalaIdealUc');
        const viewStatusUc = document.getElementById('viewStatusUc');

        // Caracteres proibidos
        const forbiddenChars = /[<>"';{}]/g;

        // Instituições
        async function fetchInstituicoes() {
            if (instituicoesCache.length > 0) return instituicoesCache;
            const resp = await fetch('../backend/processa_instituicao.php');
            instituicoesCache = await resp.json();
            return instituicoesCache;
        }
        async function preencherSelectInstituicao(selectedId = "") {
            const insts = await fetchInstituicoes();
            selectInstituicao.innerHTML = '<option value="">Selecione a instituição</option>';
            insts.forEach(i => {
                selectInstituicao.innerHTML += `<option value="${i._id}" ${i._id === selectedId ? "selected" : ""}>${i.razao_social}</option>`;
            });
        }

        // Modal control
        function openModalUC(edit = false, uc = {}) {
            preencherSelectInstituicao(edit ? uc.instituicao_id : "");
            ucModal.classList.add('show');
            ucIdInput.value = edit ? uc._id : '';
            descricaoUcInput.value = edit ? uc.descricao : '';
            salaIdealInput.value = edit ? uc.sala_ideal : '';
            statusUc.value = edit ? uc.status : "Ativa";
            modalTitleUc.innerText = edit ? "Editar Unidade Curricular" : "Adicionar Nova Unidade Curricular";
            ucEditId = edit ? uc._id : null;
            alertUc.style.display = "none";
            alertUc.className = "";
            alertUc.textContent = "";
        }
        function closeModalUC() {
            ucModal.classList.remove('show');
            ucForm.reset();
            ucEditId = null;
            alertUc.style.display = "none";
            alertUc.className = "";
            alertUc.textContent = "";
        }
        addUcBtn.onclick = () => openModalUC();
        closeModalBtn.onclick = closeModalUC;
        cancelBtn.onclick = closeModalUC;
        window.onclick = function (event) {
            if (event.target === ucModal) closeModalUC();
            if (event.target === visualizarUcModal) closeVisualizarUcModal();
        };

        // Visualizar UC
        function openVisualizarUcModal(uc) {
            const inst = instituicoesCache.find(i => i._id === uc.instituicao_id);
            viewInstituicaoUc.value = inst ? inst.razao_social : '';
            viewDescricaoUc.value = uc.descricao ?? '';
            viewSalaIdealUc.value = uc.sala_ideal ?? '';
            viewStatusUc.value = uc.status ?? 'Ativa';
            visualizarUcModal.classList.add('show');
        }
        function closeVisualizarUcModal() {
            visualizarUcModal.classList.remove('show');
        }
        closeVisualizarUcBtn.onclick = closeVisualizarUcModal;
        fecharVisualizarUcBtn.onclick = closeVisualizarUcModal;

        // Busca e tabela
        async function carregarUnidadesCurriculares() {
            try {
                const [ucs, insts] = await Promise.all([
                    fetch('../backend/processa_unidade_curricular.php').then(r => r.json()),
                    fetchInstituicoes()
                ]);
                ucsCache = ucs;
                renderTableUC(ucs, insts);
            } catch (err) {
                document.getElementById('ucTableBody').innerHTML = `<tr><td colspan="6">Erro ao buscar dados.</td></tr>`;
            }
        }
        function renderTableUC(ucs, insts) {
            const tbody = document.getElementById('ucTableBody');
            const search = (document.getElementById('searchUc').value || '').toLowerCase();
            tbody.innerHTML = '';
            const filtrar = ucs.filter(uc => {
                const inst = insts.find(i => i._id === uc.instituicao_id);
                return (
                    !search ||
                    (uc.descricao || '').toLowerCase().includes(search) ||
                    (uc.sala_ideal || '').toLowerCase().includes(search) ||
                    (inst && (inst.razao_social || '').toLowerCase().includes(search))
                );
            });
            if (!filtrar.length) {
                tbody.innerHTML = `<tr><td colspan="6">Nenhuma UC cadastrada.</td></tr>`;
                return;
            }
            filtrar.forEach((uc) => {
                const inst = insts.find(i => i._id === uc.instituicao_id);
                tbody.innerHTML += `
                <tr>
                    <td>${uc._id}</td>
                    <td>${inst ? inst.razao_social : ''}</td>
                    <td>${uc.descricao ?? ''}</td>
                    <td>${uc.sala_ideal ?? ''}</td>
                    <td>${uc.status ?? 'Ativa'}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-icon btn-view" data-id="${uc._id}" title="Visualizar"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-icon btn-edit" data-id="${uc._id}" title="Editar"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-icon btn-delete" data-id="${uc._id}" title="Excluir"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>
                `;
            });
            document.querySelectorAll('.btn-view').forEach(btn =>
                btn.onclick = async function () {
                    const id = this.dataset.id;
                    const uc = ucsCache.find(uc => uc._id === id);
                    if (uc) openVisualizarUcModal(uc);
                }
            );
            document.querySelectorAll('.btn-edit').forEach(btn =>
                btn.onclick = async function () {
                    const id = this.dataset.id;
                    const uc = ucsCache.find(uc => uc._id === id);
                    if (uc) openModalUC(true, uc);
                }
            );
            document.querySelectorAll('.btn-delete').forEach(btn =>
                btn.onclick = async function () {
                    if (confirm('Deseja excluir esta UC?')) {
                        await fetch('../backend/processa_unidade_curricular.php?id=' + this.dataset.id, { method: 'DELETE' });
                        carregarUnidadesCurriculares();
                    }
                }
            );
        }

        // Validação frontend
        function validateUcForm() {
            alertUc.textContent = ""; alertUc.className = ""; alertUc.style.display = "none";
            function sanitize(val) { return val.replace(/\s+/g, ' ').trim(); }
            if (!selectInstituicao.value) {
                showAlert("Selecione uma instituição.", "error"); selectInstituicao.focus(); return false;
            }
            descricaoUcInput.value = sanitize(descricaoUcInput.value);
            if (descricaoUcInput.value.length < 2 || descricaoUcInput.value.length > 100) {
                showAlert("Descrição deve ter entre 2 e 100 caracteres.", "error"); descricaoUcInput.focus(); return false;
            }
            if (forbiddenChars.test(descricaoUcInput.value)) {
                showAlert("Descrição contém caracteres inválidos.", "error"); descricaoUcInput.focus(); return false;
            }
            salaIdealInput.value = sanitize(salaIdealInput.value);
            if (salaIdealInput.value.length < 2 || salaIdealInput.value.length > 100) {
                showAlert("Sala Ideal deve ter entre 2 e 100 caracteres.", "error"); salaIdealInput.focus(); return false;
            }
            if (forbiddenChars.test(salaIdealInput.value)) {
                showAlert("Sala Ideal contém caracteres inválidos.", "error"); salaIdealInput.focus(); return false;
            }
            if (!statusUc.value) {
                showAlert("Selecione o status.", "error"); statusUc.focus(); return false;
            }
            return true;
        }
        function showAlert(msg, type = "error") {
            alertUc.textContent = msg;
            alertUc.className = (type === "error" ? "alert-error" : "alert-success");
            alertUc.style.display = "block";
            if (type === "success") setTimeout(() => { alertUc.style.display = "none"; }, 2500);
        }
        [descricaoUcInput, salaIdealInput, selectInstituicao, statusUc].forEach(input => {
            input.addEventListener("input", () => {
                alertUc.textContent = "";
                alertUc.className = "";
                alertUc.style.display = "none";
            });
        });

        // CRUD do modal
        ucForm.onsubmit = async function (e) {
            e.preventDefault();
            if (!validateUcForm()) return;

            const data = {
                descricao: descricaoUcInput.value,
                sala_ideal: salaIdealInput.value,
                instituicao_id: selectInstituicao.value,
                status: statusUc.value
            };
            let method, url;
            if (ucEditId) {
                method = 'PUT';
                url = '../backend/processa_unidade_curricular.php?id=' + ucEditId;
            } else {
                method = 'POST';
                url = '../backend/processa_unidade_curricular.php';
            }
            const res = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            if (res.ok) {
                closeModalUC();
                setTimeout(() => {
                    alert('Unidade Curricular salva com sucesso!');
                    carregarUnidadesCurriculares();
                }, 200);
            } else {
                showAlert("Erro ao salvar UC. Tente novamente.", "error");
            }
        };

        document.getElementById('searchUc').oninput = carregarUnidadesCurriculares;
        document.addEventListener('DOMContentLoaded', carregarUnidadesCurriculares);
    </script>
</body>
</html>
