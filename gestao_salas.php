<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Salas - SENAI</title>
        <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style_turmas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="logo.png" alt="Logo SENAI" class="sidebar-logo">
                <h3>Menu Principal</h3>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.html"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="gestao_cursos.php"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a>
                    </li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de
                            Instrutores</a></li>
                    <li><a href="gestao_salas.php" class="active"><i class="fas fa-door-open"></i> Gestão de Salas</a></li>
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de
                            UCs</a></li>
                    <li><a href="calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <button class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="main-header">
                <h1>Gestão de Salas</h1>
                <button class="btn btn-primary" id="addSalaBtn"><i class="fas fa-plus"></i> Adicionar Sala</button>
            </div>

            <section class="table-section">
                <h2>Lista de Salas</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchSalaInput">Pesquisar por Nome/Turma/Instrutor:</label>
                        <input type="text" id="searchSalaInput" placeholder="Pesquisar...">
                    </div>
                    <div class="filter-group">
                        <label for="filterDateInput">Filtrar por Data:</label>
                        <input type="date" id="filterDateInput">
                    </div>
                    <div class="filter-group">
                        <label for="filterStatusSelect">Filtrar por Status:</label>
                        <select id="filterStatusSelect">
                            <option value="">Todos</option>
                            <option value="Livre">Livre</option>
                            <option value="Ocupada">Ocupada</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table" id="salasTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome da Sala</th>
                                <th>Capacidade</th>
                                <th>Status</th>
                                <th>Turma Atual</th>
                                <th>Instrutor Atual</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>

            <div id="salaModal" class="modal">
                <div class="modal-content">
                    <span class="close-button">&times;</span>
                    <h2 id="salaModalTitle">Adicionar Nova Sala</h2>
                    <form id="salaForm">
                        <input type="hidden" id="salaIdInput">
                        <div class="form-group-flex">
                            <div class="form-group">
                                <label for="salaNomeInput">Nome da Sala:</label>
                                <input type="text" id="salaNomeInput" required>
                            </div>
                            <div class="form-group">
                                <label for="salaCapacidadeInput">Capacidade (Cadeiras):</label>
                                <input type="number" id="salaCapacidadeInput" min="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="salaFerramentasInput">Ferramentas Disponíveis (separar por vírgula):</label>
                            <input type="text" id="salaFerramentasInput" placeholder="Projetor, Lousa Interativa, Kits de Robótica">
                        </div>
                        <div class="form-group">
                            <label for="salaDisciplinasInput">Disciplinas que podem ser aplicadas (separar por vírgula):</label>
                            <input type="text" id="salaDisciplinasInput" placeholder="Programação, Eletrônica, Mecânica">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Sala</button>
                        <button type="button" class="btn btn-secondary close-modal">Cancelar</button>
                    </form>
                </div>
            </div>

            <div id="detalhesSalaModal" class="modal">
                <div class="modal-content">
                    <span class="close-button">&times;</span>
                    <h2>Detalhes da Sala: <span id="detalhesSalaNome"></span></h2>
                    <div class="detalhes-sala-container">
                        <p><strong>ID:</strong> <span id="detalhesSalaId"></span></p>
                        <p><strong>Capacidade:</strong> <span id="detalhesSalaCapacidade"></span> cadeiras</p>
                        <p><strong>Status:</strong> <span id="detalhesSalaStatus"></span></p>
                        <p><strong>Turma Atual:</strong> <span id="detalhesSalaTurmaAtual"></span></p>
                        <p><strong>Instrutor Atual:</strong> <span id="detalhesSalaInstrutorAtual"></span></p>

                        <h3>Disciplinas Preparadas</h3>
                        <div class="disciplinas-preparadas-list" id="detalhesSalaDisciplinas">
                        </div>

                        <h3>Ferramentas Disponíveis</h3>
                        <div class="ferramentas-disponiveis-list" id="detalhesSalaFerramentas">
                        </div>

                        <h3>Calendário de Reservas</h3>
                        <div class="calendario-reserva">
                            <div class="calendario-grid" id="calendarioGrid">
                                <div class="calendario-header">Julho 2025</div>
                                <div class="calendario-dia-semana">Dom</div>
                                <div class="calendario-dia-semana">Seg</div>
                                <div class="calendario-dia-semana">Ter</div>
                                <div class="calendario-dia-semana">Qua</div>
                                <div class="calendario-dia-semana">Qui</div>
                                <div class="calendario-dia-semana">Sex</div>
                                <div class="calendario-dia-semana">Sáb</div>
                            </div>
                            <div class="reservar-form">
                                <h4>Reservar Sala</h4>
                                <div class="form-group-inline">
                                    <label for="reservaDataInput">Data:</label>
                                    <input type="date" id="reservaDataInput">
                                    <label for="reservaTurmaInput">Turma:</label>
                                    <select id="reservaTurmaInput">
                                    </select>
                                    <label for="reservaInstrutorInput">Instrutor:</label>
                                    <select id="reservaInstrutorInput">
                                    </select>
                                    <label for="reservaDisciplinaInput">Disciplina:</label>
                                    <input type="text" id="reservaDisciplinaInput" placeholder="Disciplina">
                                </div>
                                <button class="btn btn-primary" id="btnReservarSala">Reservar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Variáveis globais para armazenar os dados
        let salasData = [];
        let turmasData = [];
        let instrutoresData = [];

        // Referências aos elementos do DOM
        const salasTableBody = document.querySelector('#salasTable tbody');
        const addSalaBtn = document.getElementById('addSalaBtn');
        const salaModal = document.getElementById('salaModal');
        const salaModalTitle = document.getElementById('salaModalTitle');
        const salaForm = document.getElementById('salaForm');
        const salaIdInput = document.getElementById('salaIdInput');
        const salaNomeInput = document.getElementById('salaNomeInput');
        const salaCapacidadeInput = document.getElementById('salaCapacidadeInput');
        const salaFerramentasInput = document.getElementById('salaFerramentasInput');
        const salaDisciplinasInput = document.getElementById('salaDisciplinasInput');
        const searchSalaInput = document.getElementById('searchSalaInput');
        const filterDateInput = document.getElementById('filterDateInput');
        const filterStatusSelect = document.getElementById('filterStatusSelect');

        const detalhesSalaModal = document.getElementById('detalhesSalaModal');
        const detalhesSalaNome = document.getElementById('detalhesSalaNome');
        const detalhesSalaId = document.getElementById('detalhesSalaId');
        const detalhesSalaCapacidade = document.getElementById('detalhesSalaCapacidade');
        const detalhesSalaStatus = document.getElementById('detalhesSalaStatus');
        const detalhesSalaTurmaAtual = document.getElementById('detalhesSalaTurmaAtual');
        const detalhesSalaInstrutorAtual = document.getElementById('detalhesSalaInstrutorAtual');
        const detalhesSalaDisciplinas = document.getElementById('detalhesSalaDisciplinas');
        const detalhesSalaFerramentas = document.getElementById('detalhesSalaFerramentas');
        const calendarioGrid = document.getElementById('calendarioGrid');
        const reservaDataInput = document.getElementById('reservaDataInput');
        const reservaTurmaInput = document.getElementById('reservaTurmaInput');
        const reservaInstrutorInput = document.getElementById('reservaInstrutorInput');
        const reservaDisciplinaInput = document.getElementById('reservaDisciplinaInput');
        const btnReservarSala = document.getElementById('btnReservarSala');

        let currentSalaIdForDetails = null;

        // Função para carregar dados do servidor
        async function loadData() {
            try {
                // Carregar apenas os dados das salas
                const responseSalas = await fetch('dados_salas.php');
                if (!responseSalas.ok) throw new Error('Erro ao carregar dados das salas');
                salasData = await responseSalas.json();
                
                // Extrair turmas e instrutores das reservas das salas
                turmasData = [];
                instrutoresData = [];
                
                salasData.forEach(sala => {
                    if (sala.reservas && sala.reservas.length > 0) {
                        sala.reservas.forEach(reserva => {
                            // Adiciona turma se não existir
                            if (!turmasData.some(t => t.id === reserva.turmaId)) {
                                turmasData.push({
                                    id: reserva.turmaId,
                                    codigo: reserva.turmaCodigo || `Turma ${reserva.turmaId}`
                                });
                            }
                            
                            // Adiciona instrutor se não existir
                            if (!instrutoresData.some(i => i.id === reserva.instrutorId)) {
                                instrutoresData.push({
                                    id: reserva.instrutorId,
                                    nome: reserva.instrutorNome || `Instrutor ${reserva.instrutorId}`
                                });
                            }
                        });
                    }
                });
                
                updateTableDisplay();
            } catch (error) {
                console.error('Erro ao carregar dados:', error);
                alert('Erro ao carregar dados. Por favor, recarregue a página.');
            }
        }

        // Função para atualizar o status e info da sala com base na data atual
        function updateSalaCurrentStatus(sala) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const reservaHoje = sala.reservas.find(reserva => {
                const reservaDate = new Date(reserva.data);
                reservaDate.setHours(0, 0, 0, 0);
                return reservaDate.getTime() === today.getTime();
            });

            if (reservaHoje) {
                sala.status = "Ocupada";
                sala.turmaAtual = reservaHoje.turmaCodigo || `Turma ${reservaHoje.turmaId}`;
                sala.instrutorAtual = reservaHoje.instrutorNome || `Instrutor ${reservaHoje.instrutorId}`;
            } else {
                sala.status = "Livre";
                sala.turmaAtual = "";
                sala.instrutorAtual = "";
            }
        }

        function updateTableDisplay() {
            salasTableBody.innerHTML = '';
            const searchTerm = searchSalaInput.value.toLowerCase();
            const filterDate = filterDateInput.value;
            const filterStatus = filterStatusSelect.value;

            const filteredSalas = salasData.filter(sala => {
                updateSalaCurrentStatus(sala);

                const matchesSearchTerm = sala.nome.toLowerCase().includes(searchTerm) ||
                    sala.turmaAtual.toLowerCase().includes(searchTerm) ||
                    sala.instrutorAtual.toLowerCase().includes(searchTerm);

                let matchesDate = true;
                if (filterDate) {
                    const hasReservationOnDate = sala.reservas.some(reserva => reserva.data === filterDate);

                    if (filterStatus === "Ocupada") {
                        matchesDate = hasReservationOnDate;
                    } else if (filterStatus === "Livre") {
                        matchesDate = !hasReservationOnDate;
                    }
                }

                let matchesStatus = true;
                if (filterStatus) {
                    if (filterDate) {
                        const hasReservationOnDate = sala.reservas.some(reserva => reserva.data === filterDate);
                        if (filterStatus === "Ocupada") {
                            matchesStatus = hasReservationOnDate;
                        } else if (filterStatus === "Livre") {
                            matchesStatus = !hasReservationOnDate;
                        }
                    } else {
                        matchesStatus = sala.status === filterStatus;
                    }
                }

                return matchesSearchTerm && matchesDate && matchesStatus;
            });

            filteredSalas.forEach(sala => {
                const row = salasTableBody.insertRow();
                row.insertCell().textContent = sala.id;
                row.insertCell().textContent = sala.nome;
                row.insertCell().textContent = sala.capacidade;

                let displayStatus = sala.status;
                let displayTurma = sala.turmaAtual || '-';
                let displayInstrutor = sala.instrutorAtual || '-';

                if (filterDate) {
                    const reservaNaDataFiltrada = sala.reservas.find(reserva => reserva.data === filterDate);
                    if (reservaNaDataFiltrada) {
                        displayStatus = "Ocupada";
                        displayTurma = reservaNaDataFiltrada.turmaCodigo || `Turma ${reservaNaDataFiltrada.turmaId}`;
                        displayInstrutor = reservaNaDataFiltrada.instrutorNome || `Instrutor ${reservaNaDataFiltrada.instrutorId}`;
                    } else {
                        displayStatus = "Livre";
                        displayTurma = '-';
                        displayInstrutor = '-';
                    }
                }

                row.insertCell().textContent = displayStatus;
                row.insertCell().textContent = displayTurma;
                row.insertCell().textContent = displayInstrutor;

                const actionsCell = row.insertCell();
                actionsCell.classList.add('actions');

                const detalhesBtn = document.createElement('button');
                detalhesBtn.classList.add('btn', 'btn-icon', 'btn-primary');
                detalhesBtn.innerHTML = '<i class="fas fa-info-circle"></i>';
                detalhesBtn.title = 'Ver Detalhes';
                detalhesBtn.onclick = () => openDetalhesModal(sala.id);
                actionsCell.appendChild(detalhesBtn);

                const editBtn = document.createElement('button');
                editBtn.classList.add('btn', 'btn-icon', 'btn-edit');
                editBtn.innerHTML = '<i class="fas fa-edit"></i>';
                editBtn.title = 'Editar';
                editBtn.onclick = () => openEditModal(sala.id);
                actionsCell.appendChild(editBtn);

                const deleteBtn = document.createElement('button');
                deleteBtn.classList.add('btn', 'btn-icon', 'btn-delete');
                deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                deleteBtn.title = 'Excluir';
                deleteBtn.onclick = () => deleteSala(sala.id);
                actionsCell.appendChild(deleteBtn);
            });
        }

        function openAddModal() {
            salaModalTitle.textContent = "Adicionar Nova Sala";
            salaIdInput.value = '';
            salaForm.reset();
            salaModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function openEditModal(id) {
            const sala = salasData.find(s => s.id == id);
            if (sala) {
                salaModalTitle.textContent = "Editar Sala";
                salaIdInput.value = sala.id;
                salaNomeInput.value = sala.nome;
                salaCapacidadeInput.value = sala.capacidade;
                salaFerramentasInput.value = sala.ferramentas ? sala.ferramentas.join(', ') : '';
                salaDisciplinasInput.value = sala.disciplinas ? sala.disciplinas.join(', ') : '';
                salaModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }
        }

        async function saveSala(event) {
            event.preventDefault();

            const id = salaIdInput.value;
            const nome = salaNomeInput.value.trim();
            const capacidade = parseInt(salaCapacidadeInput.value);
            const ferramentas = salaFerramentasInput.value.split(',').map(f => f.trim()).filter(f => f !== '');
            const disciplinas = salaDisciplinasInput.value.split(',').map(d => d.trim()).filter(d => d !== '');

            const formData = new FormData();
            formData.append('id', id);
            formData.append('nome', nome);
            formData.append('capacidade', capacidade);
            formData.append('ferramentas', JSON.stringify(ferramentas));
            formData.append('disciplinas', JSON.stringify(disciplinas));

            try {
                const response = await fetch('salvar_sala.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Erro ao salvar sala');

                const result = await response.json();
                if (result.success) {
                    alert('Sala salva com sucesso!');
                    salaModal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    loadData();
                } else {
                    throw new Error(result.message || 'Erro ao salvar sala');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao salvar sala: ' + error.message);
            }
        }

        async function deleteSala(id) {
            if (confirm('Tem certeza que deseja excluir esta sala? Esta ação é irreversível.')) {
                try {
                    const response = await fetch(`excluir_sala.php?id=${id}`);
                    
                    if (!response.ok) throw new Error('Erro ao excluir sala');
                    
                    const result = await response.json();
                    if (result.success) {
                        alert('Sala excluída com sucesso!');
                        loadData();
                    } else {
                        throw new Error(result.message || 'Erro ao excluir sala');
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    alert('Erro ao excluir sala: ' + error.message);
                }
            }
        }

        function openDetalhesModal(id) {
            currentSalaIdForDetails = id;
            const sala = salasData.find(s => s.id == id);

            if (sala) {
                updateSalaCurrentStatus(sala);

                detalhesSalaNome.textContent = sala.nome;
                detalhesSalaId.textContent = sala.id;
                detalhesSalaCapacidade.textContent = sala.capacidade;
                detalhesSalaStatus.textContent = sala.status;
                detalhesSalaTurmaAtual.textContent = sala.turmaAtual || '-';
                detalhesSalaInstrutorAtual.textContent = sala.instrutorAtual || '-';

                detalhesSalaDisciplinas.innerHTML = '';
                if (sala.disciplinas && sala.disciplinas.length > 0) {
                    sala.disciplinas.forEach(disciplina => {
                        const span = document.createElement('span');
                        span.classList.add('tag');
                        span.textContent = disciplina;
                        detalhesSalaDisciplinas.appendChild(span);
                    });
                } else {
                    detalhesSalaDisciplinas.textContent = 'Nenhuma disciplina informada.';
                }

                detalhesSalaFerramentas.innerHTML = '';
                if (sala.ferramentas && sala.ferramentas.length > 0) {
                    sala.ferramentas.forEach(ferramenta => {
                        const span = document.createElement('span');
                        span.classList.add('tag');
                        span.textContent = ferramenta;
                        detalhesSalaFerramentas.appendChild(span);
                    });
                } else {
                    detalhesSalaFerramentas.textContent = 'Nenhuma ferramenta informada.';
                }

                renderCalendario(sala);
                populateReservaSelects();

                detalhesSalaModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }
        }

        function renderCalendario(sala) {
            calendarioGrid.innerHTML = `
                <div class="calendario-header">Julho 2025</div>
                <div class="calendario-dia-semana">Dom</div>
                <div class="calendario-dia-semana">Seg</div>
                <div class="calendario-dia-semana">Ter</div>
                <div class="calendario-dia-semana">Qua</div>
                <div class="calendario-dia-semana">Qui</div>
                <div class="calendario-dia-semana">Sex</div>
                <div class="calendario-dia-semana">Sáb</div>
            `;

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const year = 2025;
            const month = 6;

            const firstDayOfMonth = new Date(year, month, 1);
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const startDay = firstDayOfMonth.getDay();

            for (let i = 0; i < startDay; i++) {
                const emptyDiv = document.createElement('div');
                calendarioGrid.appendChild(emptyDiv);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                date.setHours(0, 0, 0, 0);
                const dateString = date.toISOString().split('T')[0];

                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendario-dia');
                dayDiv.textContent = day;
                dayDiv.dataset.date = dateString;

                const isOccupied = sala.reservas.some(reserva => reserva.data === dateString);
                const isPastDate = date.getTime() < today.getTime();

                if (isOccupied) {
                    dayDiv.classList.add('ocupado');
                    const reservaInfo = sala.reservas.find(reserva => reserva.data === dateString);
                    dayDiv.title = `Ocupado por ${reservaInfo.turmaCodigo} (${reservaInfo.disciplina})`;
                } else if (isPastDate) {
                    dayDiv.classList.add('calendario-dia-passado');
                    dayDiv.style.backgroundColor = '#e0e0e0';
                    dayDiv.style.cursor = 'not-allowed';
                } else {
                    dayDiv.addEventListener('click', () => {
                        document.querySelectorAll('.calendario-dia.selecionado').forEach(d => d.classList.remove('selecionado'));
                        dayDiv.classList.add('selecionado');
                        reservaDataInput.value = dateString;
                    });
                }

                if (date.getTime() === today.getTime()) {
                    dayDiv.style.border = '2px solid #007BFF';
                    dayDiv.style.fontWeight = 'bold';
                }

                calendarioGrid.appendChild(dayDiv);
            }
        }

        function populateReservaSelects() {
            reservaTurmaInput.innerHTML = '<option value="">Selecione a Turma</option>';
            turmasData.forEach(turma => {
                const option = document.createElement('option');
                option.value = turma.id;
                option.textContent = turma.codigo;
                reservaTurmaInput.appendChild(option);
            });

            reservaInstrutorInput.innerHTML = '<option value="">Selecione o Instrutor</option>';
            instrutoresData.forEach(instrutor => {
                const option = document.createElement('option');
                option.value = instrutor.id;
                option.textContent = instrutor.nome;
                reservaInstrutorInput.appendChild(option);
            });
        }

        async function reservarSala() {
            const salaId = currentSalaIdForDetails;
            const reservaData = reservaDataInput.value;
            const reservaTurmaId = reservaTurmaInput.value;
            const reservaInstrutorId = reservaInstrutorInput.value;
            const reservaDisciplina = reservaDisciplinaInput.value.trim();

            if (!reservaData || !reservaTurmaId || !reservaInstrutorId || !reservaDisciplina) {
                alert('Por favor, preencha todos os campos da reserva.');
                return;
            }

            const formData = new FormData();
            formData.append('salaId', salaId);
            formData.append('data', reservaData);
            formData.append('turmaId', reservaTurmaId);
            formData.append('instrutorId', reservaInstrutorId);
            formData.append('disciplina', reservaDisciplina);

            try {
                const response = await fetch('reservar_sala.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Erro ao reservar sala');

                const result = await response.json();
                if (result.success) {
                    alert('Sala reservada com sucesso!');
                    openDetalhesModal(salaId);
                    reservaDataInput.value = '';
                    reservaTurmaInput.value = '';
                    reservaInstrutorInput.value = '';
                    reservaDisciplinaInput.value = '';
                    loadData();
                } else {
                    throw new Error(result.message || 'Erro ao reservar sala');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao reservar sala: ' + error.message);
            }
        }

        // Event Listeners
        addSalaBtn.addEventListener('click', openAddModal);
        salaForm.addEventListener('submit', saveSala);
        searchSalaInput.addEventListener('keyup', updateTableDisplay);
        filterDateInput.addEventListener('change', updateTableDisplay);
        filterStatusSelect.addEventListener('change', updateTableDisplay);
        btnReservarSala.addEventListener('click', reservarSala);

        document.querySelectorAll('.close-button, .close-modal').forEach(button => {
            button.onclick = (e) => {
                const modal = e.target.closest('.modal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                }
            };
        });

        window.onclick = (event) => {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        };

        // Inicialização
        document.addEventListener('DOMContentLoaded', () => {
            loadData();
            const today = new Date().toISOString().split('T')[0];
            reservaDataInput.min = today;
            filterDateInput.value = today;
        });
    </script>
    
    <script>
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
</script>
</body>
</html>