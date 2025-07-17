<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário - SENAI</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style_turmas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
       
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
                    <li><a href="gestao_cursos.php"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
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
                <h1>Calendário Geral</h1>
            </header>

            <!-- Calendário Principal de Aulas e Feriados -->
            <section class="instructor-calendar-section">
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
                        <button class="btn btn-primary" id="addAulaBtn"><i class="fas fa-plus-circle"></i> Aula</button>
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
                    <!-- Dias do calendário principal serão gerados aqui -->
                </div>
            </section>

            <!-- Novo Calendário de Disponibilidade de Instrutores -->
<section class="instructor-calendar-section">
    <h2>Disponibilidade de Instrutores</h2>
    
    <!-- Adicione este container para o gráfico -->
    <div class="chart-container mb-6" style="position: relative; height:300px; width:100%">
        <canvas id="instructorsPieChart"></canvas>
    </div>
    
    <div class="calendar-grid instructor-calendar-grid">
        <div class="day-name">Dom</div>
        <div class="day-name">Seg</div>
        <div class="day-name">Ter</div>
        <div class="day-name">Qua</div>
        <div class="day-name">Qui</div>
        <div class="day-name">Sex</div>
        <div class="day-name">Sáb</div>
        <!-- Dias do calendário de instrutores serão gerados aqui -->
    </div>
</section>

        </main>
    </div>

    <!-- Modal de Adicionar Feriado -->
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

    <!-- Modal de Adicionar Aula -->
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

    <!-- Novo Modal para Detalhes Diários dos Instrutores -->
    <div id="dailyInstructorDetailsModal" class="modal">
        <div class="modal-content daily-instructor-details-modal-content">
            <span class="close-button" id="closeDailyInstructorDetailsBtn">&times;</span>
            <h2>Disponibilidade de Instrutores em <span id="dailyInstructorDetailsDate"></span></h2>
            <ul id="dailyInstructorDetailsList" class="daily-instructor-details-list">
                <!-- Detalhes dos instrutores para o dia selecionado serão carregados aqui -->
            </ul>
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

        // Elementos do Novo Calendário de Instrutores
        const instructorCalendarGrid = document.querySelector('.instructor-calendar-grid');
        const dailyInstructorDetailsModal = document.getElementById('dailyInstructorDetailsModal');
        const closeDailyInstructorDetailsBtn = document.getElementById('closeDailyInstructorDetailsBtn');
        const dailyInstructorDetailsDate = document.getElementById('dailyInstructorDetailsDate');
        const dailyInstructorDetailsList = document.getElementById('dailyInstructorDetailsList');

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

        let aulasData = []; // Será preenchido via fetch
        let allInstrutoresNames = []; // Lista de todos os instrutores conhecidos

        /**
         * Função assíncrona para buscar os dados das aulas de um arquivo PHP externo.
         */
        async function fetchAulasData() {
            try {
                const response = await fetch('dados_aulas.php');

                if (!response.ok) {
                    throw new Error('Não foi possível carregar os dados das aulas.');
                }

                aulasData = await response.json();

                // Coleta todos os nomes de instrutores únicos das aulas
                allInstrutoresNames = [...new Set(aulasData.map(aula => aula.instrutor))].sort();

                populateInstrutorFilter();
                renderCalendar();
                renderInstructorAvailabilityCalendar(); // Renderiza o novo calendário
            } catch (error) {
                console.error('Erro ao buscar dados:', error);
                // Opcional: mostrar uma mensagem de erro na interface do usuário
            }
        }

        function populateInstrutorFilter() {
            instrutorFilter.innerHTML = '<option value="all">Todos os Instrutores</option>';
            allInstrutoresNames.forEach(instrutor => {
                const option = document.createElement('option');
                option.value = instrutor;
                option.textContent = instrutor;
                instrutorFilter.appendChild(option);
            });
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

        // --- Lógica do Novo Calendário de Disponibilidade de Instrutores ---
let instructorsPieChart = null;

function renderInstructorAvailabilityCalendar() {
    instructorCalendarGrid.innerHTML = `
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
        emptyDay.classList.add('empty-day', 'instructor-day');
        instructorCalendarGrid.appendChild(emptyDay);
    }

    // Variáveis para estatísticas mensais
    let totalFreeDays = 0;
    let totalOccupiedDays = 0;
    let totalConflictDays = 0;

    for (let i = 1; i <= lastDay.getDate(); i++) {
        const day = document.createElement('div');
        day.classList.add('day', 'instructor-day');

        const dateString = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
        day.dataset.date = dateString;

        let dayContent = `<span class="day-number">${i}</span>`;

        const dayStatus = getInstructorDailySummary(dateString);

        let statusClass = 'free';
        let statusText = 'Livre';

        if (dayStatus.conflictCount > 0) {
            statusClass = 'conflict';
            statusText = `Conflito (${dayStatus.conflictCount})`;
            totalConflictDays++;
        } else if (dayStatus.occupiedCount > 0) {
            statusClass = 'occupied';
            statusText = `Ocupado (${dayStatus.occupiedCount})`;
            totalOccupiedDays++;
        } else {
            totalFreeDays++;
        }

        day.classList.add(statusClass);
        dayContent += `<span class="instructor-day-summary">${statusText}</span>`;

        const dayDate = new Date(currentYear, currentMonth, i);
        const isToday = dayDate.toDateString() === today.toDateString();
        if (isToday) {
            day.classList.add('today');
        }

        day.innerHTML = dayContent;
        day.addEventListener('click', () => openDailyInstructorDetailsModal(dateString));
        instructorCalendarGrid.appendChild(day);
    }

    // Atualiza ou cria o gráfico de pizza
    updateInstructorsPieChart(totalFreeDays, totalOccupiedDays, totalConflictDays);
}

function updateInstructorsPieChart(free, occupied, conflict) {
    const ctx = document.getElementById('instructorsPieChart').getContext('2d');
    
    // Destrói o gráfico anterior se existir
    if (instructorsPieChart) {
        instructorsPieChart.destroy();
    }
    
    instructorsPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Instrutores Livres', 'Instrutores Ocupados', 'Conflitos de Agenda'],
            datasets: [{
                data: [free, occupied, conflict],
                backgroundColor: [
                    '#4CAF50', // Verde para livres
                    '#FFC107', // Amarelo para ocupados
                    '#F44336'  // Vermelho para conflitos
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: `Distribuição de Instrutores - ${monthNames[currentMonth]} ${currentYear}`,
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

        function getInstructorDailySummary(dateString) {
            let conflictCount = 0;
            let occupiedCount = 0;
            let freeCount = 0;

            // Para cada instrutor conhecido, verifique seu status para a data
            allInstrutoresNames.forEach(instrutorName => {
                const classesForInstructorOnDay = aulasData.filter(aula =>
                    aula.date === dateString && aula.instrutor === instrutorName
                );

                if (classesForInstructorOnDay.length > 1) {
                    conflictCount++;
                } else if (classesForInstructorOnDay.length === 1) {
                    occupiedCount++;
                } else {
                    freeCount++;
                }
            });

            return {
                conflictCount,
                occupiedCount,
                freeCount
            };
        }

        function openDailyInstructorDetailsModal(dateString) {
    dailyInstructorDetailsDate.textContent = formatDisplayDate(dateString);
    dailyInstructorDetailsList.innerHTML = '';

    const instructorDetailsForDay = [];
    let freeCount = 0;
    let occupiedCount = 0;
    let conflictCount = 0;

    allInstrutoresNames.forEach(instrutorName => {
        const classesForInstructorOnDay = aulasData.filter(aula =>
            aula.date === dateString && aula.instrutor === instrutorName
        );

        let status = 'Livre';
        let statusClass = 'free-text';
        let classesInfo = [];

        if (classesForInstructorOnDay.length > 1) {
            status = 'Conflito';
            statusClass = 'conflict-text';
            conflictCount++;
            classesForInstructorOnDay.forEach(aula => {
                classesInfo.push(`${aula.uc} (${aula.codigoTurma}) - Sala: ${aula.sala} - Turno: ${aula.turno}`);
            });
        } else if (classesForInstructorOnDay.length === 1) {
            status = 'Ocupado';
            statusClass = 'occupied-text';
            occupiedCount++;
            const aula = classesForInstructorOnDay[0];
            classesInfo.push(`${aula.uc} (${aula.codigoTurma}) - Sala: ${aula.sala} - Turno: ${aula.turno}`);
        } else {
            freeCount++;
        }

        instructorDetailsForDay.push({
            name: instrutorName,
            status: status,
            statusClass: statusClass,
            classes: classesInfo
        });
    });

    // Ordena os instrutores: Conflito (vermelho), Ocupado (amarelo), Livre (verde)
    instructorDetailsForDay.sort((a, b) => {
        const order = { 'Conflito': 1, 'Ocupado': 2, 'Livre': 3 };
        return order[a.status] - order[b.status];
    });

    // Adiciona o gráfico de pizza diário
    const chartHtml = `
        <div class="chart-container" style="height: 250px; margin-bottom: 20px;">
            <canvas id="dailyInstructorsPieChart"></canvas>
        </div>
    `;
    dailyInstructorDetailsList.insertAdjacentHTML('beforeend', chartHtml);

    // Cria o gráfico de pizza diário
    const dailyCtx = document.getElementById('dailyInstructorsPieChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'pie',
        data: {
            labels: ['Livre', 'Ocupado', 'Conflito'],
            datasets: [{
                data: [freeCount, occupiedCount, conflictCount],
                backgroundColor: [
                    '#4CAF50', // Verde
                    '#FFC107', // Amarelo
                    '#F44336'  // Vermelho
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: `Status dos Instrutores - ${formatDisplayDate(dateString)}`,
                    font: {
                        size: 14
                    }
                }
            }
        }
    });

    // Adiciona a lista de instrutores
    if (instructorDetailsForDay.length === 0) {
        const li = document.createElement('li');
        li.textContent = 'Nenhum instrutor cadastrado no sistema.';
        dailyInstructorDetailsList.appendChild(li);
    } else {
        instructorDetailsForDay.forEach(item => {
            const li = document.createElement('li');
            li.innerHTML = `<strong>${item.name}:</strong> <span class="status-text ${item.statusClass}">${item.status}</span>`;
            if (item.classes.length > 0) {
                item.classes.forEach(info => {
                    const span = document.createElement('span');
                    span.classList.add('class-info');
                    span.textContent = info;
                    li.appendChild(span);
                });
            }
            dailyInstructorDetailsList.appendChild(li);
        });
    }

    dailyInstructorDetailsModal.style.display = 'flex';
    document.body.classList.add('modal-open');
}

        function closeDailyInstructorDetailsModal() {
            dailyInstructorDetailsModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }

        function formatDisplayDate(dateString) {
            if (!dateString) return '';
            const [year, month, day] = dateString.split('-');
            return `${day}/${month}/${year}`;
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
                renderInstructorAvailabilityCalendar(); // Atualiza o calendário de instrutores
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

                // Adiciona o novo instrutor à lista se ainda não existir
                if (!allInstrutoresNames.includes(nomeInstrutor)) {
                    allInstrutoresNames.push(nomeInstrutor);
                    allInstrutoresNames.sort(); // Mantém a lista ordenada
                }

                populateInstrutorFilter();

                currentYear = new Date(date).getFullYear();
                currentMonth = new Date(date).getMonth();
                renderCalendar();
                renderInstructorAvailabilityCalendar(); // Atualiza o calendário de instrutores
                closeAulaModal();
            }
        });

        // Corrigido: Adicionado o event listener para o botão 'X' do modal de detalhes do instrutor
        closeDailyInstructorDetailsBtn.addEventListener('click', closeDailyInstructorDetailsModal);

        window.onclick = (event) => {
            if (event.target == feriadoModal) {
                closeFeriadoModal();
            }
            if (event.target == aulaModal) {
                closeAulaModal();
            }
            // Corrigido: Chamar a função de fechamento diretamente se o clique for no overlay do modal
            if (event.target == dailyInstructorDetailsModal) {
                closeDailyInstructorDetailsModal();
            }
        };

        prevMonthBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
            renderInstructorAvailabilityCalendar(); // Atualiza o calendário de instrutores
        });

        nextMonthBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
            renderInstructorAvailabilityCalendar(); // Atualiza o calendário de instrutores
        });

        monthSelect.addEventListener('change', () => {
            currentMonth = parseInt(monthSelect.value);
            renderCalendar();
            renderInstructorAvailabilityCalendar(); // Atualiza o calendário de instrutores
        });
        yearSelect.addEventListener('change', () => {
            currentYear = parseInt(yearSelect.value);
            renderCalendar();
            renderInstructorAvailabilityCalendar(); // Atualiza o calendário de instrutores
        });

        areaFilter.addEventListener('change', () => renderCalendar());
        turnoFilter.addEventListener('change', () => renderCalendar());
        instrutorFilter.addEventListener('change', () => renderCalendar());
        searchFilter.addEventListener('input', () => renderCalendar());

        document.addEventListener('DOMContentLoaded', () => {
            fetchAulasData(); // Chama a função para buscar os dados ao carregar a página
        });

        // Menu Toggle para Mobile
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        // Fechar o menu ao clicar fora dele em telas menores
        document.addEventListener('click', (event) => {
            if (window.innerWidth <= 768 && sidebar.classList.contains('active') && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>

</html>
