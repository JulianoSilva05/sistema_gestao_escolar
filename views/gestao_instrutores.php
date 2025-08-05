<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Instrutores - SENAI</title>
    <link rel="stylesheet" href="../css/style_turmas.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                   <!--<li><a href="gestao_alocacao.php"><i class="fas fa-random"></i> Gestão de Alocações</a></li>-->
                    <li><a href="gestao_cursos.php"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php" class="active"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                   <!--<li><a href="gestao_salas.php"><i class="fas fa-door-open"></i> Gestão de Salas</a></li>-->
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="gestao_calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <button class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <header class="main-header">
                <h1>Gestão de Instrutores</h1>
                <button class="btn btn-primary" id="addInstrutorBtn"><i class="fas fa-plus-circle"></i> Adicionar Novo Instrutor</button>
            </header>

            <section class="table-section">
                <h2>Instrutores Cadastrados</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchInstrutor">Buscar Instrutor (Nome, Matrícula, Email):</label>
                        <input type="text" id="searchInstrutor" placeholder="Digite para filtrar..." class="search-input">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome do Instrutor</th>
                                <th>Matrícula</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Instituição</th>
                                <!-- <th>Mapa de Competência</th> --> <!-- Removido -->
                                <th>Turnos</th>
                                <th>Carga Horária</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Preenchido pelo JavaScript -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal de Cadastro/Edição -->
    <div id="instrutorModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button" id="closeInstrutorModal">&times;</span>
            <h2 id="modalTitle">Adicionar Novo Instrutor</h2>
            <form id="instrutorForm">
                <input type="hidden" id="instrutorId">
                <div class="form-group">
                    <label for="instituicaoId">Instituição:</label>
                    <select id="instituicaoId" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nomeInstrutor">Nome do Instrutor:</label>
                    <input type="text" id="nomeInstrutor" required>
                </div>
                <div class="form-group">
                    <label for="matriculaInstrutor">Matrícula:</label>
                    <input type="text" id="matriculaInstrutor" required>
                </div>
                <div class="form-group">
                    <label for="instrutorTelefone">Telefone:</label>
                    <input type="text" id="instrutorTelefone" placeholder="(XX) XXXXX-XXXX" required>
                </div>
                <div class="form-group">
                    <label for="instrutorEmail">Email:</label>
                    <input type="email" id="instrutorEmail" required>
                </div>
                <div class="form-group">
                    <label for="mapaCompetencia">Mapa de Competência (UCs):</label>
                    <select id="mapaCompetencia" multiple="multiple" style="width: 100%" required></select>
                </div>
                <div class="form-group">
                    <label for="turnosInstrutor">Turnos:</label>
                    <select id="turnosInstrutor" multiple="multiple" style="width: 100%" required>
                        <option value="Manhã">Manhã</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noite">Noite</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cargaHoraria">Carga Horária (horas):</label>
                    <input type="number" min="0" id="cargaHoraria" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Instrutor</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times-circle"></i> Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal Visualizar Instrutor -->
    <div id="visualizarInstrutorModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button" id="closeVisualizarInstrutor">&times;</span>
            <h2>Detalhes do Instrutor</h2>
            <form>
                <div class="form-group">
                    <label>Instituição:</label>
                    <input type="text" id="viewInstituicao" readonly>
                </div>
                <div class="form-group">
                    <label>Nome do Instrutor:</label>
                    <input type="text" id="viewNomeInstrutor" readonly>
                </div>
                <div class="form-group">
                    <label>Matrícula:</label>
                    <input type="text" id="viewMatriculaInstrutor" readonly>
                </div>
                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" id="viewTelefone" readonly>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" id="viewEmail" readonly>
                </div>
                <div class="form-group">
                    <label>Mapa de Competência:</label>
                    <div id="viewMapaCompetenciaList" style="padding: 4px 0;"></div>
                </div>
                <div class="form-group">
                    <label>Turnos:</label>
                    <input type="text" id="viewTurnosInstrutor" readonly>
                </div>
                <div class="form-group">
                    <label>Carga Horária:</label>
                    <input type="text" id="viewCargaHoraria" readonly>
                </div>
                <button type="button" class="btn btn-secondary" id="fecharVisualizarInstrutor">Fechar</button>
            </form>
        </div>
    </div>

    <script>
        const API_INSTRUTOR = '../backend/processa_instrutor.php';
        let instrutoresData = [];
        let instituicoesMap = {};
        let ucsMap = {};

        const instrutorModal = document.getElementById('instrutorModal');
        const addInstrutorBtn = document.getElementById('addInstrutorBtn');
        const closeInstrutorModalBtn = document.getElementById('closeInstrutorModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const instrutorForm = document.getElementById('instrutorForm');
        const modalTitle = document.getElementById('modalTitle');
        const dataTableBody = document.querySelector('.data-table tbody');
        const searchInstrutorInput = document.getElementById('searchInstrutor');

        const instrutorIdInput = document.getElementById('instrutorId');
        const nomeInstrutorInput = document.getElementById('nomeInstrutor');
        const matriculaInstrutorInput = document.getElementById('matriculaInstrutor');
        const instrutorTelefoneInput = document.getElementById('instrutorTelefone');
        const instrutorEmailInput = document.getElementById('instrutorEmail');
        const instituicaoSelect = document.getElementById('instituicaoId');
        const mapaCompetenciaSelect = $('#mapaCompetencia');
        const turnosSelect = $('#turnosInstrutor');
        const cargaHorariaInput = document.getElementById('cargaHoraria');

        // Modal Visualizar
        const visualizarInstrutorModal = document.getElementById('visualizarInstrutorModal');
        const closeVisualizarInstrutor = document.getElementById('closeVisualizarInstrutor');
        const fecharVisualizarInstrutor = document.getElementById('fecharVisualizarInstrutor');
        const viewInstituicao = document.getElementById('viewInstituicao');
        const viewNomeInstrutor = document.getElementById('viewNomeInstrutor');
        const viewMatriculaInstrutor = document.getElementById('viewMatriculaInstrutor');
        const viewTelefone = document.getElementById('viewTelefone');
        const viewEmail = document.getElementById('viewEmail');
        const viewMapaCompetenciaList = document.getElementById('viewMapaCompetenciaList');
        const viewTurnosInstrutor = document.getElementById('viewTurnosInstrutor');
        const viewCargaHoraria = document.getElementById('viewCargaHoraria');

        async function openModal() {
            await carregarInstituicoes();
            await carregarUCs();
            instrutorModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeModal() {
            instrutorModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            instrutorForm.reset();
            mapaCompetenciaSelect.val(null).trigger('change');
            turnosSelect.val(null).trigger('change');
            modalTitle.textContent = "Adicionar Novo Instrutor";
            instrutorIdInput.value = '';
        }

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

        async function carregarUCs() {
            mapaCompetenciaSelect.empty();
            const resp = await fetch('../backend/processa_unidade_curricular.php');
            const lista = await resp.json();
            ucsMap = {};
            lista.forEach(uc => {
                ucsMap[uc._id] = uc.descricao;
                mapaCompetenciaSelect.append(`<option value="${uc._id}">${uc.descricao}</option>`);
            });
            mapaCompetenciaSelect.select2({
                width: '100%',
                placeholder: 'Selecione as UCs'
            });
            turnosSelect.select2({
                width: '100%',
                placeholder: 'Selecione os Turnos'
            });
        }

        async function carregarInstrutores() {
            const resp = await fetch(API_INSTRUTOR);
            instrutoresData = await resp.json();
            updateTableDisplay();
        }

        function updateTableDisplay() {
            dataTableBody.innerHTML = '';
            const searchTerm = (searchInstrutorInput.value || '').toLowerCase();

            const filteredInstrutores = instrutoresData.filter(instrutor => {
                const searchString = `${instrutor.nome || ''} ${instrutor.matricula || ''} ${instrutor.email || ''}`.toLowerCase();
                return searchString.includes(searchTerm);
            });

            if (filteredInstrutores.length === 0) {
                const noDataRow = dataTableBody.insertRow();
                noDataRow.innerHTML = '<td colspan="9">Nenhum Instrutor encontrado com os filtros aplicados.</td>';
                return;
            }

            filteredInstrutores.forEach(instrutor => {
                // Remover coluna Mapa de Competência da tabela!
                const turnosNomes = (instrutor.turnos || []).join(", ");
                const row = dataTableBody.insertRow();
                row.innerHTML = `
                    <td>${instrutor._id}</td>
                    <td>${instrutor.nome || ''}</td>
                    <td>${instrutor.matricula || ''}</td>
                    <td>${instrutor.telefone || ''}</td>
                    <td>${instrutor.email || ''}</td>
                    <td>${instituicoesMap[instrutor.instituicao_id] || ''}</td>
                    <td>${turnosNomes}</td>
                    <td>${instrutor.carga_horaria || ''}</td>
                    <td class="actions">
                        <button class="btn btn-icon btn-view" title="Visualizar" data-id="${instrutor._id}"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-icon btn-edit" title="Editar" data-id="${instrutor._id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="${instrutor._id}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
            });
            attachTableActionListeners();
        }

        function attachTableActionListeners() {
            document.querySelectorAll('.btn-view').forEach(button => {
                button.onclick = (e) => {
                    const instrutor = instrutoresData.find(emp => emp._id === e.currentTarget.dataset.id);
                    openVisualizarInstrutorModal(instrutor);
                };
            });
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.onclick = (e) => openEditModal(e.currentTarget.dataset.id);
            });
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.onclick = (e) => deleteInstrutor(e.currentTarget.dataset.id);
            });
        }

        function openVisualizarInstrutorModal(instrutor) {
            viewInstituicao.value = instituicoesMap[instrutor.instituicao_id] || '';
            viewNomeInstrutor.value = instrutor.nome || '';
            viewMatriculaInstrutor.value = instrutor.matricula || '';
            viewTelefone.value = instrutor.telefone || '';
            viewEmail.value = instrutor.email || '';
            // Mostra Mapa de Competência um item por linha
            let ucsHtml = '';
            (instrutor.mapa_competencia || []).forEach(id => {
                ucsHtml += `<div>${ucsMap[id] || id}</div>`;
            });
            viewMapaCompetenciaList.innerHTML = ucsHtml || '<div>-</div>';
            viewTurnosInstrutor.value = (instrutor.turnos || []).join(', ');
            viewCargaHoraria.value = instrutor.carga_horaria || '';
            visualizarInstrutorModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeVisualizarInstrutorModal() {
            visualizarInstrutorModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }

        async function openEditModal(id) {
            const instrutor = instrutoresData.find(e => e._id == id);
            if (instrutor) {
                modalTitle.textContent = "Editar Instrutor";
                instrutorIdInput.value = instrutor._id;
                nomeInstrutorInput.value = instrutor.nome || '';
                matriculaInstrutorInput.value = instrutor.matricula || '';
                instrutorTelefoneInput.value = instrutor.telefone || '';
                instrutorEmailInput.value = instrutor.email || '';
                await carregarInstituicoes();
                instituicaoSelect.value = instrutor.instituicao_id || '';
                await carregarUCs();
                mapaCompetenciaSelect.val(instrutor.mapa_competencia || []).trigger('change');
                turnosSelect.val(instrutor.turnos || []).trigger('change');
                cargaHorariaInput.value = instrutor.carga_horaria || '';
                instrutorModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }
        }

        async function deleteInstrutor(id) {
            if (confirm("Tem certeza que deseja excluir o Instrutor?")) {
                await fetch(API_INSTRUTOR + '?id=' + id, { method: 'DELETE' });
                carregarInstrutores();
            }
        }

        // --- Event Listeners ---
        addInstrutorBtn.onclick = async function () {
            modalTitle.textContent = "Adicionar Novo Instrutor";
            instrutorForm.reset();
            instrutorIdInput.value = '';
            await carregarInstituicoes();
            await carregarUCs();
            mapaCompetenciaSelect.val(null).trigger('change');
            turnosSelect.val(null).trigger('change');
            instrutorModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        };
        closeInstrutorModalBtn.onclick = closeModal;
        cancelBtn.onclick = closeModal;
        searchInstrutorInput.oninput = updateTableDisplay;

        closeVisualizarInstrutor.onclick = closeVisualizarInstrutorModal;
        fecharVisualizarInstrutor.onclick = closeVisualizarInstrutorModal;

        instrutorForm.onsubmit = async function (event) {
            event.preventDefault();
            const id = instrutorIdInput.value;
            const payload = {
                nome: nomeInstrutorInput.value,
                matricula: matriculaInstrutorInput.value,
                telefone: instrutorTelefoneInput.value,
                email: instrutorEmailInput.value,
                instituicao_id: instituicaoSelect.value,
                mapa_competencia: mapaCompetenciaSelect.val() || [],
                turnos: turnosSelect.val() || [],
                carga_horaria: Number(cargaHorariaInput.value) || 0
            };

            if (id) {
                await fetch(API_INSTRUTOR + '?id=' + id, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
            } else {
                await fetch(API_INSTRUTOR, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
            }
            closeModal();
            carregarInstrutores();
        };

        window.onclick = (event) => {
            if (event.target == instrutorModal) closeModal();
            if (event.target == visualizarInstrutorModal) closeVisualizarInstrutorModal();
        };

        document.addEventListener('DOMContentLoaded', async function () {
            await carregarInstituicoes();
            await carregarUCs();
            await carregarInstrutores();
        });
    </script>
</body>
</html>
