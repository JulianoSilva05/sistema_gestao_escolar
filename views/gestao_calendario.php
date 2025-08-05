<?php
$eventos_calendario = [];
$calendarios_cadastrados = [];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário - SENAI</title>
    <link rel="stylesheet" href="../css/style_turmas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/locales/pt-br.global.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .calendar-page-layout {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .filters-container {
            flex: 1;
            min-width: 320px;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }
        .calendar-container-main {
            flex: 3;
            min-width: 500px;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }
        .filters-container h2,
        .calendar-container-main h2 {
            color: #004B8D;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.5em;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .action-buttons-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
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
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="gestao_calendario.php" class="active"><i class="fas fa-calendar-alt"></i>Calendário</a></li>
                    <li><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Gestão de Calendário Acadêmico</h1>
            </header>

            <div class="calendar-page-layout">
                <div class="calendar-container-main">
                    <h2>Calendário Geral</h2>
                    <div class="action-buttons-group">
                        <button type="button" class="btn btn-primary"
                                id="btnAbrirModalCadastrarCalendario"><i class="fas fa-plus-circle"></i>Cadastrar Calendário</button>
                        <button type="button" class="btn btn-warning" id="btnAbrirModalAdicionarEvento"><i class="fas fa-calendar-plus"></i>Adicionar Evento</button>
                    </div>
                    <p>Visualize os eventos e datas importantes de todos os calendários cadastrados.</p>
                    <div id="calendario"></div>
                </div>
            </div>

            <section class="table-section">
                <h2>Calendários Cadastrados</h2>
                <div class="form-group">
                    <input type="text" placeholder="Buscar por descrição ou empresa..." class="form-control">
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Empresa/Parceiro</th>
                                <th>Data Inicial</th>
                                <th>Data Final</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyCalendarios">
                            <!-- Preenchido via JS -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- MODAL ADICIONAR EVENTO -->
    <div id="modalAdicionarEvento" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('modalAdicionarEvento')">&times;</span>
            <h2>Adicionar Evento</h2>
            <form id="formAdicionarEvento">
                <div class="form-group">
                    <label for="eventoCalendario">Calendário(s):</label>
                    <select id="eventoCalendario" name="calendarios[]" multiple="multiple" class="form-control" style="width:100%">
                        <!-- options preenchidas via JS -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="eventoDescricao">Descrição:</label>
                    <textarea id="eventoDescricao" name="descricao" rows="2" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="eventoInicio">Início:</label>
                    <input type="date" id="eventoInicio" name="inicio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="eventoFim">Fim:</label>
                    <input type="date" id="eventoFim" name="fim" class="form-control" required>
                </div>
                <button type="button" class="btn btn-warning"
                    onclick="closeModal('modalAdicionarEvento')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar Evento</button>
            </form>
        </div>
    </div>

    <!-- MODAL CADASTRAR CALENDÁRIO -->
    <div id="modalCadastrarCalendario" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('modalCadastrarCalendario')">&times;</span>
            <h2>Cadastrar Calendário</h2>
            <form id="formCadastrarCalendario">
                <div class="form-group">
                    <label for="calInstituicao">Instituição:</label>
                    <select id="calInstituicao" name="instituicao" class="form-control" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="calNome">Nome do Calendário:</label>
                    <input type="text" id="calNome" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="calEmpresa">Empresa/Parceiro:</label>
                    <select id="calEmpresa" name="empresa" class="form-control" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="calInicio">Início do Calendário:</label>
                    <input type="date" id="calInicio" name="inicio_cal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="calFim">Fim do Calendário:</label>
                    <input type="date" id="calFim" name="fim_cal" class="form-control" required>
                </div>
                <button type="button" class="btn btn-warning"
                    onclick="closeModal('modalCadastrarCalendario')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>

    <div id="modalVisualizarCalendario" class="modal">
        <div class="modal-content" style="max-width:500px">
            <span class="close-button" onclick="closeModal('modalVisualizarCalendario')">&times;</span>
            <h2>Detalhes do Calendário</h2>
            <div id="detalhesCalendario"></div>
        </div>
    </div>

    <script>
        let listaEmpresas = [];
        let listaInstituicoes = [];
        let listaCalendarios = [];
        let fullcalendarObj = null; // Para armazenar o calendar

        async function carregarListaCalendariosParaEvento() {
            const res = await fetch('../backend/processa_calendario.php');
            if (res.ok) {
                listaCalendarios = await res.json();
                const select = $('#eventoCalendario');
                select.empty();
                listaCalendarios.forEach(cal => {
                    select.append(`<option value="${cal._id}">${cal.nome_calendario || cal.descricao || '(Sem nome)'}</option>`);
                });
                select.select2('destroy').select2({
                    dropdownParent: $('#modalAdicionarEvento .modal-content'),
                    width: '100%',
                    placeholder: 'Selecione um ou mais calendários'
                });
            }
        }

        document.getElementById('btnAbrirModalAdicionarEvento').addEventListener('click', function () {
            openModal('modalAdicionarEvento');
            carregarListaCalendariosParaEvento();
        });

        function buscarNomeEmpresa(id) {
            const empresa = listaEmpresas.find(e => e._id === id);
            return empresa ? empresa.razao_social : id || '';
        }

        function buscarNomeInstituicao(id) {
            const inst = listaInstituicoes.find(i => i._id === id);
            return inst ? inst.razao_social : id || '';
        }

        async function carregarDadosReferencia() {
            const empRes = await fetch('../backend/processa_empresa.php');
            if (empRes.ok) {
                listaEmpresas = await empRes.json();
            }
            const instRes = await fetch('../backend/processa_instituicao.php');
            if (instRes.ok) {
                listaInstituicoes = await instRes.json();
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            if (modalId === 'modalCadastrarCalendario') {
                document.getElementById('formCadastrarCalendario').reset();
            }
            if (modalId === 'modalAdicionarEvento') {
                document.getElementById('formAdicionarEvento').reset();
                if ($('#eventoCalendario').hasClass("select2-hidden-accessible")) {
                    $('#eventoCalendario').val(null).trigger('change');
                }
            }
        }

        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendario');
            fullcalendarObj = new FullCalendar.Calendar(calendarEl, {
                locale: 'pt-br',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                editable: true,
                selectable: true,
                dayMaxEvents: true,
            });
            fullcalendarObj.render();
            carregarDadosReferencia();
            carregarCalendarios();
            carregarEventosNoCalendario(fullcalendarObj);
        });

        document.getElementById('btnAbrirModalCadastrarCalendario').addEventListener('click', function () {
            openModal('modalCadastrarCalendario');
            carregarInstituicoesEmpresas();
        });

        async function carregarInstituicoesEmpresas() {
            const instSelect = document.getElementById('calInstituicao');
            instSelect.innerHTML = '<option value="">Selecione</option>';
            const instRes = await fetch('../backend/processa_instituicao.php');
            if (instRes.ok) {
                const instList = await instRes.json();
                instList.forEach(i => {
                    let opt = document.createElement('option');
                    opt.value = i._id || i.id || '';
                    opt.textContent = i.razao_social || '(sem nome)';
                    instSelect.appendChild(opt);
                });
            }
            const empSelect = document.getElementById('calEmpresa');
            empSelect.innerHTML = '<option value="">Selecione</option>';
            const empRes = await fetch('../backend/processa_empresa.php');
            if (empRes.ok) {
                const empList = await empRes.json();
                empList.forEach(e => {
                    let opt = document.createElement('option');
                    opt.value = e._id || e.id || '';
                    opt.textContent = e.razao_social || '(sem nome)';
                    empSelect.appendChild(opt);
                });
            }
        }

        document.getElementById('formCadastrarCalendario').onsubmit = async function (e) {
            e.preventDefault();

            const data = {
                id_instituicao: document.getElementById('calInstituicao').value,
                nome_calendario: document.getElementById('calNome').value,
                id_empresa: document.getElementById('calEmpresa').value,
                data_inicial: document.getElementById('calInicio').value,
                data_final: document.getElementById('calFim').value,
                dias_letivos: {}
            };

            if (!data.id_instituicao || !data.nome_calendario || !data.id_empresa || !data.data_inicial || !data.data_final) {
                alert('Preencha todos os campos obrigatórios!');
                return;
            }

            const res = await fetch('../backend/processa_calendario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            if (res.ok) {
                alert('Calendário cadastrado com sucesso!');
                closeModal('modalCadastrarCalendario');
                carregarCalendarios();
                carregarEventosNoCalendario(fullcalendarObj);
            } else {
                alert('Erro ao cadastrar calendário!');
            }
        };

        async function carregarCalendarios() {
            const res = await fetch('../backend/processa_calendario.php');
            if (res.ok) {
                const calendarios = await res.json();
                const tbody = document.getElementById('tbodyCalendarios');
                tbody.innerHTML = '';
                if (calendarios.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Nenhum calendário cadastrado.</td></tr>';
                    return;
                }
                calendarios.forEach(cal => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${cal.nome_calendario || cal.descricao || ''}</td>
                        <td>${buscarNomeEmpresa(cal.id_empresa)}</td>
                        <td>${cal.data_inicial ? formatarDataBR(cal.data_inicial) : ''}</td>
                        <td>${cal.data_final ? formatarDataBR(cal.data_final) : ''}</td>
                        <td class="actions">
                            <button class="btn btn-icon btn-view" title="Visualizar" onclick='visualizarCalendario(${JSON.stringify(cal)})'><i class="fas fa-eye"></i></button>
                            <button class="btn btn-icon btn-edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        }

        function corParaCalendario(id) {
            let hash = 0;
            for (let i = 0; i < id.length; i++) {
                hash = id.charCodeAt(i) + ((hash << 5) - hash);
            }
            const h = (hash % 360 + 360) % 360;
            return `hsl(${h},70%,80%)`;
        }

        async function carregarEventosNoCalendario(calendar) {
            const res = await fetch('../backend/processa_calendario.php');
            if (!res.ok) return;
            const calendarios = await res.json();
            let eventos = [];

            calendarios.forEach(cal => {
                const nomeCalendario = cal.nome_calendario || cal.descricao || '';
                const cor = corParaCalendario(cal._id || cal.id || '');
                if (cal.dias_nao_letivos && Array.isArray(cal.dias_nao_letivos)) {
                    cal.dias_nao_letivos.forEach(dia => {
                        eventos.push({
                            title: `${dia.descricao} (${nomeCalendario})`,
                            start: dia.data,
                            allDay: true,
                            backgroundColor: cor,
                            borderColor: cor,
                        });
                    });
                }
            });

            calendar.removeAllEvents();
            eventos.forEach(evt => calendar.addEvent(evt));
        }

        function formatarDataBR(data) {
            if (!data) return '';
            const partes = data.split('-');
            if (partes.length === 3)
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            return data;
        }

        function visualizarCalendario(cal) {
            let nomeEmpresa = buscarNomeEmpresa(cal.id_empresa);
            let nomeInstituicao = buscarNomeInstituicao(cal.id_instituicao);
            let detalhes = `
                <strong>Nome:</strong> ${cal.nome_calendario || ''}<br>
                <strong>Empresa/Parceiro:</strong> ${nomeEmpresa}<br>
                <strong>Instituição:</strong> ${nomeInstituicao}<br>
                <strong>Data Inicial:</strong> ${cal.data_inicial ? formatarDataBR(cal.data_inicial) : ''}<br>
                <strong>Data Final:</strong> ${cal.data_final ? formatarDataBR(cal.data_final) : ''}<br>
                <strong>Dias Não Letivos:</strong>
                <ul>
            `;
            if (cal.dias_nao_letivos && Array.isArray(cal.dias_nao_letivos) && cal.dias_nao_letivos.length > 0) {
                cal.dias_nao_letivos.forEach(dia => {
                    detalhes += `<li>${formatarDataBR(dia.data)} - ${dia.descricao || ''}</li>`;
                });
            } else {
                detalhes += "<li>Nenhum</li>";
            }
            detalhes += '</ul>';

            document.getElementById('detalhesCalendario').innerHTML = detalhes;
            openModal('modalVisualizarCalendario');
        }

        document.getElementById('formAdicionarEvento').onsubmit = async function (e) {
            e.preventDefault();

            const calendarios_ids = $('#eventoCalendario').val();
            const descricao = document.getElementById('eventoDescricao').value.trim();
            const data_inicial = document.getElementById('eventoInicio').value;
            const data_final = document.getElementById('eventoFim').value;

            if (!calendarios_ids || calendarios_ids.length === 0 || !descricao || !data_inicial || !data_final) {
                alert("Preencha todos os campos obrigatórios e selecione pelo menos um calendário!");
                return;
            }

            const evento = {
                calendarios_ids: calendarios_ids,
                descricao: descricao,
                data_inicial: data_inicial,
                data_final: data_final
            };

            const res = await fetch('../backend/processa_calendario.php?action=evento', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(evento)
            });
            if (res.ok) {
                alert("Evento cadastrado e dias não letivos registrados!");
                closeModal('modalAdicionarEvento');
                carregarCalendarios();
                carregarEventosNoCalendario(fullcalendarObj);
            } else {
                alert("Erro ao cadastrar evento!");
            }
        };
    </script>
</body>
</html>
