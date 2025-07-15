<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário - SENAI</title>
    <link rel="stylesheet" href="style_turmas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos do modal (reutilizados das telas anteriores) */

        .calendar-container {
            /* Mantém o layout do calendário principal */
        }

        .calendar-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* Novo estilo para os filtros */
        .calendar-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;

        }

        /* Estilo para o grupo de label e select */
        .filter-group {
            display: flex;
            flex-direction: column;
            /* Faz os itens se empilharem verticalmente */
            gap: 5px;
            /* Espaço entre a label e o select */
        }

        .calendar-filters label {
            font-weight: bold;
            color: #555;
        }

        .calendar-filters select,
        .calendar-search input {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .calendar-search {
            flex-grow: 1;
            /* Permite que o campo de busca se expanda */
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-left: auto;
            /* Empurra os botões para a direita */
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .calendar-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .calendar-filters {
                flex-direction: column;
                width: 100%;
            }

            .filter-group {
                width: 100%;
                /* Faz cada grupo de filtro ocupar toda a largura */
            }

            .calendar-filters select {
                width: 100%;
            }

            .calendar-search {
                width: 100%;
            }

            .btn-group {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Estilos para impressão */
        @media print {

            /* Esconde elementos que não devem aparecer na impressão */
            .sidebar,
            .menu-toggle,
            .main-header,
            .calendar-header .btn-group,
            .calendar-search,
            .calendar-filters {
                display: none;
            }

            /* Garante que o conteúdo principal ocupe toda a largura */
            .main-content {
                margin: 0;
                padding: 0;
            }

            /* Remove sombras e bordas do corpo para uma impressão mais limpa */
            body {
                background-color: #fff;
                box-shadow: none;
            }
        }
    </style>
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
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                    <li><a href="gestao_salas.php"><i class="fas fa-door-open"></i> Gestão de Salas</a></li>
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="calendario.php" class="active"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <button class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <header class="main-header">
                <h1>Calendário</h1>
            </header>

            <section class="calendar-container">
                <div class="calendar-header">
                    <div class="month-year-controls">
                        <button id="prevMonthBtn"><i class="fas fa-chevron-left"></i></button>
                        <div class="month-year-selects">
                            <select id="monthSelect"></select>
                            <select id="yearSelect"></select>
                        </div>
                        <button id="nextMonthBtn"><i class="fas fa-chevron-right"></i></button>
                    </div>

                    <div class="calendar-filters">
                        <div class="filter-group">
                            <label for="areaFilter">Filtrar por Área:</label>
                            <select id="areaFilter">
                                <option value="all">Todas as Áreas</option>
                                <option value="Tecnologia da Informação">Tecnologia da Informação</option>
                                <option value="Eletroeletrônica">Eletroeletrônica</option>
                                <option value="Mecânica">Mecânica</option>
                                <option value="Gestão">Gestão</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="turnoFilter">Filtrar por Turno:</label>
                            <select id="turnoFilter">
                                <option value="all">Todos os Turnos</option>
                                <option value="Manhã">Manhã</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noite">Noite</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="instrutorFilter">Filtrar por Instrutor:</label>
                            <select id="instrutorFilter">
                                <option value="all">Todos os Instrutores</option>
                            </select>
                        </div>
                    </div>

                    <div class="calendar-search">
                        <input type="text" id="searchFilter" placeholder="Buscar por instrutor, curso, UC ou sala...">
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-secondary" id="printBtn"><i class="fas fa-print"></i> Imprimir</button>
                        <button class="btn btn-primary" id="addFeriadoBtn"><i class="fas fa-plus-circle"></i> Feriado</button>
                        <button class="btn btn-secondary" id="addAulaBtn"><i class="fas fa-plus-circle"></i> Aula</button>
                    </div>
                </div>
                <div class="calendar-grid">
                    <div class="day-name">Dom</div>
                    <div class="day-name">Seg</div>
                    <div class="day-name">Ter</div>
                    <div class="day-name">Qua</div>
                    <div class="day-name">Qui</div>
                    <div class="day-name">Sex</div>
                    <div class="day-name">Sáb</div>
                </div>
            </section>
        </main>
    </div>

    <div id="feriadoModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="feriadoModalTitle">Adicionar Feriado</h2>
            <form id="feriadoForm">
                <div class="form-group">
                    <label for="feriadoDate">Data:</label>
                    <input type="date" id="feriadoDate" required>
                </div>
                <div class="form-group">
                    <label for="feriadoDescricao">Descrição:</label>
                    <textarea id="feriadoDescricao" rows="3" required></textarea>
                </div>
                <div class="btn-modal-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar</button>
                    <button type="button" class="btn btn-secondary" id="cancelFeriadoBtn"><i class="fas fa-times-circle"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="aulaModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="aulaModalTitle">Adicionar Aula</h2>
            <form id="aulaForm">
                <div class="form-group">
                    <label for="aulaDate">Data:</label>
                    <input type="date" id="aulaDate" required>
                </div>
                <div class="form-group">
                    <label for="codigoTurma">Código da Turma:</label>
                    <input type="text" id="codigoTurma" required>
                </div>
                <div class="form-group">
                    <label for="nomeInstrutor">Nome do Instrutor:</label>
                    <input type="text" id="nomeInstrutor" required>
                </div>
                <div class="form-group">
                    <label for="sala">Sala:</label>
                    <input type="text" id="sala" required>
                </div>
                <div class="form-group">
                    <label for="unidadeCurricular">Unidade Curricular:</label>
                    <input type="text" id="unidadeCurricular" required>
                </div>
                <div class="form-group">
                    <label for="turno">Turno:</label>
                    <select id="turno" required>
                        <option value="Manhã">Manhã</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noite">Noite</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="area">Área:</label>
                    <select id="area" required>
                        <option value="Tecnologia da Informação">Tecnologia da Informação</option>
                        <option value="Eletroeletrônica">Eletroeletrônica</option>
                        <option value="Mecânica">Mecânica</option>
                        <option value="Gestão">Gestão</option>
                    </select>
                </div>
                <div class="btn-modal-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar</button>
                    <button type="button" class="btn btn-secondary" id="cancelAulaBtn"><i class="fas fa-times-circle"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>

     <script>
        const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        const calendarGrid = document.querySelector('.calendar-grid');
        const monthSelect = document.getElementById('monthSelect');
        const yearSelect = document.getElementById('yearSelect');
        const prevMonthBtn = document.getElementById('prevMonthBtn');
        const nextMonthBtn = document.getElementById('nextMonthBtn');

        const addFeriadoBtn = document.getElementById('addFeriadoBtn');
        const addAulaBtn = document.getElementById('addAulaBtn');
        const printBtn = document.getElementById('printBtn');

        const areaFilter = document.getElementById('areaFilter');
        const searchFilter = document.getElementById('searchFilter');
        const turnoFilter = document.getElementById('turnoFilter');
        const instrutorFilter = document.getElementById('instrutorFilter');

        const feriadoModal = document.getElementById('feriadoModal');
        const closeFeriadoBtn = feriadoModal.querySelector('.close-button');
        const cancelFeriadoBtn = feriadoModal.querySelector('#cancelFeriadoBtn');
        const feriadoForm = document.getElementById('feriadoForm');
        const feriadoDateInput = document.getElementById('feriadoDate');
        const feriadoDescricaoInput = document.getElementById('feriadoDescricao');

        const aulaModal = document.getElementById('aulaModal');
        const closeAulaBtn = aulaModal.querySelector('.close-button');
        const cancelAulaBtn = aulaModal.querySelector('#cancelAulaBtn');
        const aulaForm = document.getElementById('aulaForm');
        const aulaDateInput = document.getElementById('aulaDate');
        const codigoTurmaInput = document.getElementById('codigoTurma');
        const nomeInstrutorInput = document.getElementById('nomeInstrutor');
        const salaInput = document.getElementById('sala');
        const unidadeCurricularInput = document.getElementById('unidadeCurricular');
        const turnoInput = document.getElementById('turno');
        const areaInput = document.getElementById('area');

        let feriadosData = [{
                date: '2025-01-01',
                description: 'Confraternização Universal'
            },
            {
                date: '2025-04-18',
                description: 'Paixão de Cristo'
            },
            {
                date: '2025-04-21',
                description: 'Tiradentes'
            },
            {
                date: '2025-05-01',
                description: 'Dia do Trabalho'
            },
            {
                date: '2025-07-16',
                description: 'Nossa Senhora do Carmo (Betim)'
            },
            {
                date: '2025-09-07',
                description: 'Independência do Brasil'
            },
            {
                date: '2025-10-12',
                description: 'Nossa Senhora Aparecida'
            },
            {
                date: '2025-11-02',
                description: 'Finados'
            },
            {
                date: '2025-11-15',
                description: 'Proclamação da República'
            },
            {
                date: '2025-11-20',
                description: 'Dia da Consciência Negra'
            },
            {
                date: '2025-12-25',
                description: 'Natal'
            }
        ];
        
        let aulasData = [];

        function populateInstrutorFilter() {
            const instrutores = [...new Set(aulasData.map(aula => aula.instrutor))];
            instrutores.sort();

            instrutorFilter.innerHTML = '<option value="all">Todos os Instrutores</option>';

            instrutores.forEach(instrutor => {
                const option = document.createElement('option');
                option.value = instrutor;
                option.textContent = instrutor;
                instrutorFilter.appendChild(option);
            });
        }
        
        /**
         * Função assíncrona para buscar os dados das aulas de um arquivo PHP externo.
         */
        async function fetchAulasData() {
            try {
                // Use a função fetch() para fazer uma requisição ao arquivo PHP externo.
                // Substitua 'caminho/para/seu/arquivo.php' pelo caminho real do seu arquivo.
                const response = await fetch('dados_aulas.php');

                // Verifica se a resposta da requisição foi bem-sucedida (status 200 OK)
                if (!response.ok) {
                    // Se a resposta não for bem-sucedida, lança um erro com uma mensagem
                    throw new Error('Não foi possível carregar os dados das aulas.');
                }

                // Converte a resposta (JSON) em um objeto JavaScript
                aulasData = await response.json();

                // Depois de buscar os dados, preenche o filtro de instrutores e renderiza o calendário
                populateInstrutorFilter();
                renderCalendar();
            } catch (error) {
                // Captura e exibe qualquer erro que ocorra durante o processo de busca
                console.error('Erro ao buscar dados:', error);
                // Opcional: mostrar uma mensagem de erro na interface do usuário
            }
        }
        
        function renderCalendar() {
            calendarGrid.innerHTML = `
                <div class="day-name">Dom</div>
                <div class="day-name">Seg</div>
                <div class="day-name">Ter</div>
                <div class="day-name">Qua</div>
                <div class="day-name">Qui</div>
                <div class="day-name">Sex</div>
                <div class="day-name">Sáb</div>
            `;

            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const numEmptyDays = firstDay.getDay();

            for (let i = 0; i < numEmptyDays; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('empty-day');
                calendarGrid.appendChild(emptyDay);
            }

            for (let i = 1; i <= lastDay.getDate(); i++) {
                const day = document.createElement('div');
                day.classList.add('day');

                const dateString = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                let dayContent = `<span class="day-number">${i}</span>`;

                const feriado = feriadosData.find(f => f.date === dateString);
                if (feriado) {
                    day.classList.add('feriado');
                    dayContent += `<span class="event-tag feriado-tag" title="${feriado.description}">${feriado.description}</span>`;
                }

                const searchTerm = searchFilter.value.toLowerCase();
                const selectedArea = areaFilter.value;
                const selectedTurno = turnoFilter.value;
                const selectedInstrutor = instrutorFilter.value;

                const filteredAulas = aulasData.filter(a => {
                    const isSameDate = a.date === dateString;
                    const isSameArea = selectedArea === 'all' || a.area === selectedArea;
                    const isSameTurno = selectedTurno === 'all' || a.turno === selectedTurno;
                    const isSameInstrutor = selectedInstrutor === 'all' || a.instrutor === selectedInstrutor;

                    const matchesSearch = searchTerm === '' ||
                        a.instrutor.toLowerCase().includes(searchTerm) ||
                        a.codigoTurma.toLowerCase().includes(searchTerm) ||
                        a.uc.toLowerCase().includes(searchTerm) ||
                        a.sala.toLowerCase().includes(searchTerm);

                    return isSameDate && isSameArea && isSameTurno && isSameInstrutor && matchesSearch;
                });

                const sortedAulas = filteredAulas.sort((a, b) => {
                    const order = {
                        'Manhã': 1,
                        'Tarde': 2,
                        'Noite': 3
                    };
                    return order[a.turno] - order[b.turno];
                });

                sortedAulas.forEach(aula => {
                    let turnoClass = '';
                    if (aula.turno === 'Manhã') {
                        turnoClass = 'aula-manha';
                    } else if (aula.turno === 'Tarde') {
                        turnoClass = 'aula-tarde';
                    } else if (aula.turno === 'Noite') {
                        turnoClass = 'aula-noite';
                    }
                    dayContent += `<span class="event-tag ${turnoClass}" title="Turno: ${aula.turno} | Instrutor: ${aula.instrutor} | Sala: ${aula.sala} | UC: ${aula.uc}">${aula.codigoTurma} (${aula.turno})</span>`;
                });

                const dayDate = new Date(currentYear, currentMonth, i);
                const isToday = dayDate.toDateString() === today.toDateString();
                if (isToday) {
                    day.classList.add('today');
                }

                day.innerHTML = dayContent;
                calendarGrid.appendChild(day);
            }
            updateHeader();
        }

        function updateHeader() {
            monthSelect.innerHTML = monthNames.map((name, index) =>
                `<option value="${index}" ${index === currentMonth ? 'selected' : ''}>${name}</option>`
            ).join('');

            yearSelect.innerHTML = '';
            for (let i = currentYear - 5; i <= currentYear + 5; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                if (i === currentYear) {
                    option.selected = true;
                }
                yearSelect.appendChild(option);
            }
        }

        function openFeriadoModal() {
            feriadoModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeFeriadoModal() {
            feriadoModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            feriadoForm.reset();
        }

        function openAulaModal() {
            aulaModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeAulaModal() {
            aulaModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            aulaForm.reset();
        }

        // Event listener para o botão de imprimir
        printBtn.addEventListener('click', () => {
            window.print();
        });

        addFeriadoBtn.addEventListener('click', openFeriadoModal);
        closeFeriadoBtn.addEventListener('click', closeFeriadoModal);
        cancelFeriadoBtn.addEventListener('click', closeFeriadoModal);

        feriadoForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const date = feriadoDateInput.value;
            const description = feriadoDescricaoInput.value;

            if (date && description) {
                feriadosData = feriadosData.filter(f => f.date !== date);
                feriadosData.push({
                    date,
                    description
                });
                currentYear = new Date(date).getFullYear();
                currentMonth = new Date(date).getMonth();
                renderCalendar();
                closeFeriadoModal();
            }
        });

        addAulaBtn.addEventListener('click', openAulaModal);
        closeAulaBtn.addEventListener('click', closeAulaModal);
        cancelAulaBtn.addEventListener('click', closeAulaModal);

        aulaForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const date = aulaDateInput.value;
            const codigoTurma = codigoTurmaInput.value;
            const nomeInstrutor = nomeInstrutorInput.value;
            const sala = salaInput.value;
            const unidadeCurricular = unidadeCurricularInput.value;
            const turno = turnoInput.value;
            const area = areaInput.value;

            if (date && codigoTurma && nomeInstrutor && sala && unidadeCurricular && turno && area) {
                aulasData.push({
                    date,
                    codigoTurma,
                    instrutor: nomeInstrutor,
                    sala,
                    uc: unidadeCurricular,
                    turno,
                    area
                });

                populateInstrutorFilter();

                currentYear = new Date(date).getFullYear();
                currentMonth = new Date(date).getMonth();
                renderCalendar();
                closeAulaModal();
            }
        });

        window.onclick = (event) => {
            if (event.target == feriadoModal) {
                closeFeriadoModal();
            }
            if (event.target == aulaModal) {
                closeAulaModal();
            }
        };

        prevMonthBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        nextMonthBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        monthSelect.addEventListener('change', () => renderCalendar());
        yearSelect.addEventListener('change', () => renderCalendar());
        areaFilter.addEventListener('change', () => renderCalendar());
        turnoFilter.addEventListener('change', () => renderCalendar());
        instrutorFilter.addEventListener('change', () => renderCalendar());
        searchFilter.addEventListener('input', () => renderCalendar());

        document.addEventListener('DOMContentLoaded', () => {
            fetchAulasData(); // Chama a função para buscar os dados ao carregar a página
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