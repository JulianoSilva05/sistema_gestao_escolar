<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Salas - SENAI</title>
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
                    <li><a href="gestao_cursos.html"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
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
        // Dados Mockados (simulando um "banco de dados")
        let salasData = JSON.parse(localStorage.getItem('salasData')) || [{
                id: 1,
                nome: "Sala A101",
                capacidade: 30,
                status: "Ocupada", // Será atualizado dinamicamente
                turmaAtual: "TADS2025.1", // Será atualizado dinamicamente
                instrutorAtual: "Prof. Ana Paula", // Será atualizado dinamicamente
                ferramentas: ["Projetor", "Computadores", "Lousa Interativa"],
                disciplinas: ["Programação Web", "Banco de Dados", "Engenharia de Software"],
                reservas: [{
                        data: "2025-07-10",
                        turmaId: 1,
                        instrutorId: 1,
                        disciplina: "Programação Web"
                    },
                    {
                        data: "2025-07-15",
                        turmaId: 2,
                        instrutorId: 2,
                        disciplina: "Banco de Dados"
                    },
                    {
                        data: "2025-07-11",
                        turmaId: 1,
                        instrutorId: 1,
                        disciplina: "Algoritmos"
                    } // Nova reserva para teste
                ]
            },
            {
                id: 2,
                nome: "Laboratório B203",
                capacidade: 20,
                status: "Livre", // Será atualizado dinamicamente
                turmaAtual: "", // Será atualizado dinamicamente
                instrutorAtual: "", // Será atualizado dinamicamente
                ferramentas: ["Microscópios", "Bancadas", "Reagentes"],
                disciplinas: ["Química", "Biologia", "Física Experimental"],
                reservas: [{
                    data: "2025-07-12",
                    turmaId: 3,
                    instrutorId: 3,
                    disciplina: "Química Orgânica"
                }]
            },
            {
                id: 3,
                nome: "Auditório Principal",
                capacidade: 100,
                status: "Livre", // Será atualizado dinamicamente
                turmaAtual: "", // Será atualizado dinamicamente
                instrutorAtual: "", // Será atualizado dinamicamente
                ferramentas: ["Sistema de Som", "Projetor 4K", "Microfones"],
                disciplinas: ["Palestras", "Eventos", "Apresentações"],
                reservas: [{
                    data: "2025-07-20",
                    turmaId: 3,
                    instrutorId: 3,
                    disciplina: "Seminário de Inovação"
                }]
            }
        ];

        let turmasData = JSON.parse(localStorage.getItem('turmasData')) || [{
                id: 1,
                codigo: "TADS2025.1",
                nome: "Turma Análise e Desenvolvimento de Sistemas"
            },
            {
                id: 2,
                codigo: "MEC2024.2",
                nome: "Turma Mecatrônica"
            },
            {
                id: 3,
                codigo: "ADM2025.1",
                nome: "Turma Administração"
            }
        ];

        let instrutoresData = JSON.parse(localStorage.getItem('instrutoresData')) || [{
                id: 1,
                nome: "Prof. Ana Paula"
            },
            {
                id: 2,
                nome: "Prof. Carlos Silva"
            },
            {
                id: 3,
                nome: "Prof. Maria Santos"
            }
        ];

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

        // Novos elementos de filtro
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

        let currentSalaIdForDetails = null; // Para saber qual sala está aberta no modal de detalhes

        // Funções para Salvar e Carregar Dados (simulando persistência)
        function saveData() {
            localStorage.setItem('salasData', JSON.stringify(salasData));
            localStorage.setItem('turmasData', JSON.stringify(turmasData)); // Salvar turmas também
            localStorage.setItem('instrutoresData', JSON.stringify(instrutoresData)); // Salvar instrutores
        }

        // --- Funções de Renderização e Lógica ---

        // Função para atualizar o status e info da sala com base na data atual
        function updateSalaCurrentStatus(sala) {
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Zera hora para comparação de datas

            const reservaHoje = sala.reservas.find(reserva => {
                const reservaDate = new Date(reserva.data);
                reservaDate.setHours(0, 0, 0, 0);
                return reservaDate.getTime() === today.getTime();
            });

            if (reservaHoje) {
                sala.status = "Ocupada";
                const turma = turmasData.find(t => t.id === reservaHoje.turmaId);
                const instrutor = instrutoresData.find(i => i.id === reservaHoje.instrutorId);
                sala.turmaAtual = turma ? turma.codigo : 'N/A';
                sala.instrutorAtual = instrutor ? instrutor.nome : 'N/A';
            } else {
                sala.status = "Livre";
                sala.turmaAtual = "";
                sala.instrutorAtual = "";
            }
        }


        function updateTableDisplay() {
            salasTableBody.innerHTML = '';
            const searchTerm = searchSalaInput.value.toLowerCase();
            const filterDate = filterDateInput.value; // Formato YYYY-MM-DD
            const filterStatus = filterStatusSelect.value;

            const filteredSalas = salasData.filter(sala => {
                // Atualiza o status da sala antes de filtrar
                updateSalaCurrentStatus(sala); // Garante que o status atual da tabela está correto

                const matchesSearchTerm = sala.nome.toLowerCase().includes(searchTerm) ||
                    sala.turmaAtual.toLowerCase().includes(searchTerm) ||
                    sala.instrutorAtual.toLowerCase().includes(searchTerm);

                let matchesDate = true;
                if (filterDate) {
                    // Verifica se a sala tem uma reserva para a data filtrada
                    const hasReservationOnDate = sala.reservas.some(reserva => reserva.data === filterDate);

                    // Se a data de filtro é hoje, o status da sala na tabela deve refletir a reserva de hoje
                    // Se não for hoje, a sala só será considerada "ocupada" na data filtrada se tiver uma reserva específica para ela.
                    // Para "Livre", a sala não deve ter reserva na data filtrada.
                    if (filterStatus === "Ocupada") {
                        matchesDate = hasReservationOnDate;
                    } else if (filterStatus === "Livre") {
                        matchesDate = !hasReservationOnDate;
                    } else { // Se status for "Todos", a data de filtro é apenas uma informação
                        // Se houver uma data, a sala deve ter uma reserva OU estar livre para considerar "matchesDate"
                        // Neste caso, se a data for informada, exibimos todas as salas, e o status será "real" ou "projetado"
                        // Mas para o filtro de tabela, queremos mostrar as que ESTÃO LIVRES OU OCUPADAS na data.
                        // Para simplicidade, se uma data é informada e o status é 'Todos', mostramos todas as salas.
                        matchesDate = true;
                    }
                }

                let matchesStatus = true;
                if (filterStatus) {
                    if (filterDate) {
                        // Se há uma data, o status é "projetado" para aquela data
                        const hasReservationOnDate = sala.reservas.some(reserva => reserva.data === filterDate);
                        if (filterStatus === "Ocupada") {
                            matchesStatus = hasReservationOnDate;
                        } else if (filterStatus === "Livre") {
                            matchesStatus = !hasReservationOnDate;
                        }
                    } else {
                        // Se não há data, o status é o "status atual" da sala (hoje)
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

                // Exibe o status da sala na data filtrada, se houver, ou o status atual
                let displayStatus = sala.status;
                let displayTurma = sala.turmaAtual || '-';
                let displayInstrutor = sala.instrutorAtual || '-';

                if (filterDate) {
                    const reservaNaDataFiltrada = sala.reservas.find(reserva => reserva.data === filterDate);
                    if (reservaNaDataFiltrada) {
                        displayStatus = "Ocupada";
                        const turma = turmasData.find(t => t.id === reservaNaDataFiltrada.turmaId);
                        const instrutor = instrutoresData.find(i => i.id === reservaNaDataFiltrada.instrutorId);
                        displayTurma = turma ? turma.codigo : 'N/A';
                        displayInstrutor = instrutor ? instrutor.nome : 'N/A';
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

                // Botão de Detalhes
                const detalhesBtn = document.createElement('button');
                detalhesBtn.classList.add('btn', 'btn-icon', 'btn-primary');
                detalhesBtn.innerHTML = '<i class="fas fa-info-circle"></i>';
                detalhesBtn.title = 'Ver Detalhes';
                detalhesBtn.onclick = () => openDetalhesModal(sala.id);
                actionsCell.appendChild(detalhesBtn);

                // Botão de Editar
                const editBtn = document.createElement('button');
                editBtn.classList.add('btn', 'btn-icon', 'btn-edit');
                editBtn.innerHTML = '<i class="fas fa-edit"></i>';
                editBtn.title = 'Editar';
                editBtn.onclick = () => openEditModal(sala.id);
                actionsCell.appendChild(editBtn);

                // Botão de Excluir
                const deleteBtn = document.createElement('button');
                deleteBtn.classList.add('btn', 'btn-icon', 'btn-delete');
                deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                deleteBtn.title = 'Excluir';
                deleteBtn.onclick = () => deleteSala(sala.id);
                actionsCell.appendChild(deleteBtn);
            });
            saveData();
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
                salaFerramentasInput.value = sala.ferramentas.join(', ');
                salaDisciplinasInput.value = sala.disciplinas.join(', ');
                salaModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }
        }

        function saveSala(event) {
            event.preventDefault();

            const id = salaIdInput.value;
            const nome = salaNomeInput.value.trim();
            const capacidade = parseInt(salaCapacidadeInput.value);
            const ferramentas = salaFerramentasInput.value.split(',').map(f => f.trim()).filter(f => f !== '');
            const disciplinas = salaDisciplinasInput.value.split(',').map(d => d.trim()).filter(d => d !== '');

            if (id) {
                // Editar Sala
                const index = salasData.findIndex(s => s.id == id);
                if (index !== -1) {
                    salasData[index] = {
                        ...salasData[index], // Mantém status, turma, instrutor e reservas existentes
                        nome,
                        capacidade,
                        ferramentas,
                        disciplinas
                    };
                    alert('Sala atualizada com sucesso!');
                }
            } else {
                // Adicionar Nova Sala
                const newId = salasData.length > 0 ? Math.max(...salasData.map(s => s.id)) + 1 : 1;
                salasData.push({
                    id: newId,
                    nome,
                    capacidade,
                    // Ao adicionar, não definimos status, turma, instrutor, pois são dinâmicos
                    ferramentas,
                    disciplinas,
                    reservas: []
                });
                alert('Sala adicionada com sucesso!');
            }

            salaModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            updateTableDisplay();
        }

        function deleteSala(id) {
            if (confirm('Tem certeza que deseja excluir esta sala? Esta ação é irreversível.')) {
                salasData = salasData.filter(s => s.id != id);
                updateTableDisplay();
                alert('Sala excluída com sucesso!');
            }
        }

        function openDetalhesModal(id) {
            currentSalaIdForDetails = id; // Guarda o ID da sala para uso na reserva
            const sala = salasData.find(s => s.id == id);

            if (sala) {
                // Atualiza o status atual da sala para o modal de detalhes
                updateSalaCurrentStatus(sala);

                detalhesSalaNome.textContent = sala.nome;
                detalhesSalaId.textContent = sala.id;
                detalhesSalaCapacidade.textContent = sala.capacidade;
                detalhesSalaStatus.textContent = sala.status;
                detalhesSalaTurmaAtual.textContent = sala.turmaAtual || '-';
                detalhesSalaInstrutorAtual.textContent = sala.instrutorAtual || '-';

                // Disciplinas Preparadas
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

                // Ferramentas Disponíveis
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

                // Gerar Calendário
                renderCalendario(sala);

                // Preencher selects de turma e instrutor para reserva
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
            today.setHours(0, 0, 0, 0); // Zera a hora para comparação
            const year = 2025; // Ano fixo para o calendário
            const month = 6; // Julho (0-indexed)

            const firstDayOfMonth = new Date(year, month, 1);
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const startDay = firstDayOfMonth.getDay(); // 0 = Domingo, 1 = Segunda...

            // Adicionar dias vazios para preencher o início do mês
            for (let i = 0; i < startDay; i++) {
                const emptyDiv = document.createElement('div');
                calendarioGrid.appendChild(emptyDiv);
            }

            // Adicionar os dias do mês
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                date.setHours(0, 0, 0, 0); // Zera a hora para comparação
                const dateString = date.toISOString().split('T')[0]; // Formato YYYY-MM-DD

                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendario-dia');
                dayDiv.textContent = day;
                dayDiv.dataset.date = dateString;

                const isOccupied = sala.reservas.some(reserva => reserva.data === dateString);
                const isPastDate = date.getTime() < today.getTime(); // Verifica se a data já passou

                if (isOccupied) {
                    dayDiv.classList.add('ocupado');
                    // Opcional: Adicionar tooltip com info da reserva
                    const reservaInfo = sala.reservas.find(reserva => reserva.data === dateString);
                    dayDiv.title = `Ocupado por ${reservaInfo.turmaCodigo} (${reservaInfo.disciplina})`;
                } else if (isPastDate) {
                    dayDiv.classList.add('calendario-dia-passado'); // Nova classe para datas passadas
                    dayDiv.style.backgroundColor = '#e0e0e0'; // Cinza para datas passadas
                    dayDiv.style.cursor = 'not-allowed';
                } else {
                    dayDiv.addEventListener('click', () => {
                        // Remover seleção anterior
                        document.querySelectorAll('.calendario-dia.selecionado').forEach(d => d.classList.remove('selecionado'));
                        // Adicionar seleção ao dia clicado
                        dayDiv.classList.add('selecionado');
                        // Preencher input de data
                        reservaDataInput.value = dateString;
                    });
                }

                if (date.getTime() === today.getTime()) {
                    dayDiv.style.border = '2px solid #007BFF'; // Destaca o dia atual
                    dayDiv.style.fontWeight = 'bold';
                }

                calendarioGrid.appendChild(dayDiv);
            }
        }

        function populateReservaSelects() {
            // Preencher Turmas
            reservaTurmaInput.innerHTML = '<option value="">Selecione a Turma</option>';
            turmasData.forEach(turma => {
                const option = document.createElement('option');
                option.value = turma.id;
                option.textContent = turma.codigo;
                reservaTurmaInput.appendChild(option);
            });

            // Preencher Instrutores
            reservaInstrutorInput.innerHTML = '<option value="">Selecione o Instrutor</option>';
            instrutoresData.forEach(instrutor => {
                const option = document.createElement('option');
                option.value = instrutor.id;
                option.textContent = instrutor.nome;
                reservaInstrutorInput.appendChild(option);
            });
        }

        function reservarSala() {
            const salaId = currentSalaIdForDetails;
            const reservaData = reservaDataInput.value;
            const reservaTurmaId = reservaTurmaInput.value;
            const reservaInstrutorId = reservaInstrutorInput.value;
            const reservaDisciplina = reservaDisciplinaInput.value.trim();

            if (!reservaData || !reservaTurmaId || !reservaInstrutorId || !reservaDisciplina) {
                alert('Por favor, preencha todos os campos da reserva.');
                return;
            }

            const sala = salasData.find(s => s.id == salaId);
            if (sala) {
                const isOccupied = sala.reservas.some(r => r.data === reservaData);
                if (isOccupied) {
                    alert('Esta sala já está reservada para a data selecionada.');
                    return;
                }

                const turma = turmasData.find(t => t.id == reservaTurmaId);
                const instrutor = instrutoresData.find(i => i.id == reservaInstrutorId);

                sala.reservas.push({
                    data: reservaData,
                    turmaId: parseInt(reservaTurmaId),
                    turmaCodigo: turma ? turma.codigo : 'N/A', // Adiciona código da turma para fácil exibição
                    instrutorId: parseInt(reservaInstrutorId),
                    instrutorNome: instrutor ? instrutor.nome : 'N/A', // Adiciona nome do instrutor
                    disciplina: reservaDisciplina
                });

                alert('Sala reservada com sucesso!');
                // Reabrir o modal para atualizar o calendário
                openDetalhesModal(salaId); // Isso também chamará updateSalaCurrentStatus() internamente
                // Limpar formulário de reserva
                reservaDataInput.value = '';
                reservaTurmaInput.value = '';
                reservaInstrutorInput.value = '';
                reservaDisciplinaInput.value = '';
                updateTableDisplay(); // Atualizar a tabela principal
            }
        }


        // --- Event Listeners ---
        addSalaBtn.addEventListener('click', openAddModal);
        salaForm.addEventListener('submit', saveSala);

        // Adicionar listeners para os novos filtros
        searchSalaInput.addEventListener('keyup', updateTableDisplay);
        filterDateInput.addEventListener('change', updateTableDisplay);
        filterStatusSelect.addEventListener('change', updateTableDisplay);

        btnReservarSala.addEventListener('click', reservarSala);


        // Listeners para fechar modais (reutilizando os do seu código CSS)
        document.querySelectorAll('.close-button, .close-modal').forEach(button => {
            button.onclick = (e) => {
                const modal = e.target.closest('.modal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                }
            };
        });

        // Fechar modal clicando fora
        window.onclick = (event) => {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        };

        // Inicializar a exibição da tabela ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            updateTableDisplay();
            // Define a data mínima para o input de reserva como o dia atual
            const today = new Date().toISOString().split('T')[0];
            reservaDataInput.min = today;
            filterDateInput.value = today; // Define a data de filtro inicial para hoje
        });
    </script>
    
    <script>
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const dashboardContainer = document.querySelector('.dashboard-container');

    // Função para abrir/fechar o menu
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        dashboardContainer.classList.toggle('sidebar-active');
    });

    // Função para fechar o menu ao clicar fora dele
    dashboardContainer.addEventListener('click', (event) => {
        // Verifica se o clique foi fora da sidebar e do botão de toggle
        if (dashboardContainer.classList.contains('sidebar-active') && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('active');
            dashboardContainer.classList.remove('sidebar-active');
        }
    });
</script>
</body>

</html>