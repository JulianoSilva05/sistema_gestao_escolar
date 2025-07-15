<?php
// A linha abaixo irá carregar o array $instrutores do arquivo externo.
require_once 'dados_instrutores.php';

// Simulação de dados de turmas para o dropdown de associação (você pode carregar do mesmo lugar que sua tela de turmas)
$turmas_disponiveis = [
    ['id' => 1, 'codigo_turma' => 'HT-SIS-01-24-M-12700'],
    ['id' => 2, 'codigo_turma' => 'HT-IPI-01-N-12700'],
    ['id' => 3, 'codigo_turma' => 'HT-ADM-01-M-12700'],
    ['id' => 4, 'codigo_turma' => 'HT-MEC-02-N-12800']
];


// Função para formatar data (opcional, para exibição)
function formatarData($data)
{
    return date('d/m/Y', strtotime($data));
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Instrutores - SENAI</title>
    <link rel="stylesheet" href="style_turmas.css">
    <link rel="stylesheet" href="style_instrutores.css">
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
                    <li><a href="gestao_instrutores.php" class="active"><i class="fas fa-chalkboard-teacher"></i> Gestão
                            de
                            Instrutores</a></li>
                    <li><a href="gestao_salas.php"><i class="fas fa-door-open"></i> Gestão de Salas</a></li>
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
                <h1>Gestão de Instrutores</h1>
                <button class="btn btn-primary" id="addInstrutorBtn">
                    <i class="fas fa-user-plus"></i> Adicionar Instrutor
                </button>
            </div>

            <section class="table-section">
                <h2>Lista de Instrutores</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchInstrutor">Pesquisar Instrutor:</label>
                        <input type="text" id="searchInstrutor" placeholder="Digite para filtrar..."
                            class="search-input">
                    </div>

                    <div class="filter-group">
                        <label for="filterDate">Filtrar por Disponibilidade na Data:</label>
                        <input type="date" id="filterDate" class="search-input">
                    </div>

                    <div class="filter-group">
                        <label for="availabilityFilter">Disponibilidade:</label>
                        <select id="availabilityFilter" class="search-input">
                            <option value="">Mostrar Todos</option>
                            <option value="livre">Livre</option>
                            <option value="ocupado">Ocupado</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Área de Atuação</th>
                                <th>Turmas Associadas</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="instrutorModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="modalTitle">Adicionar Novo Instrutor</h2>
            <form id="instrutorForm">
                <input type="hidden" id="instrutorId">
                <div class="form-group">
                    <label for="nomeInstrutor">Nome Completo:</label>
                    <input type="text" id="nomeInstrutor" required>
                </div>

                <div class="form-group">
                    <label for="telefoneInstrutor">Telefone:</label>
                    <input type="text" id="telefoneInstrutor" placeholder="(XX) XXXXX-XXXX" required>
                </div>

                <div class="form-group">
                    <label for="emailInstrutor">Email:</label>
                    <input type="email" id="emailInstrutor" required>
                </div>

                <div class="form-group">
                    <label for="areaAtuacao">Área de Atuação:</label>
                    <input type="text" id="areaAtuacao" placeholder="Ex: Informática, Administração, Mecânica" required>
                </div>

                <div class="form-group">
                    <label for="observacoesInstrutor">Observações (Competências, etc.):</label>
                    <textarea id="observacoesInstrutor" rows="3"
                        placeholder="Ex: Especialista em Java, Conhecimento em UX/UI."></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Instrutor</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times-circle"></i>
                    Cancelar</button>
            </form>
        </div>
    </div>

    <div id="detalhesInstrutorModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeDetalhesBtn">&times;</span>
            <h2 id="detalhesModalTitle">Detalhes do Instrutor</h2>
            <div class="detalhes-instrutor-container">
                <p><strong>ID:</strong> <span id="detalhesId"></span></p>
                <p><strong>Nome:</strong> <span id="detalhesNome"></span></p>
                <p><strong>Telefone:</strong> <span id="detalhesTelefone"></span></p>
                <p><strong>Email:</strong> <span id="detalhesEmail"></span></p>
                <p><strong>Área de Atuação:</strong> <span id="detalhesAreaAtuacao"></span></p>
                <p><strong>Observações:</strong> <span id="detalhesObservacoes"></span></p>

                <h3>Associação a Turmas</h3>
                <div class="turmas-associadas-list" id="turmasAssociadasList">
                </div>
                <div class="form-group add-turma-form">
                    <label for="addTurmaToInstrutor">Associar nova Turma:</label>
                    <select id="addTurmaToInstrutor">
                        <option value="">Selecione uma turma</option>
                        <?php foreach ($turmas_disponiveis as $turma): ?>
                            <option value="<?php echo $turma['id']; ?>" data-codigo="<?php echo $turma['codigo_turma']; ?>">
                                <?php echo htmlspecialchars($turma['codigo_turma']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary btn-add-small" id="btnAssociarTurma"><i class="fas fa-plus"></i>
                        Associar</button>
                </div>

                <h3>Histórico de Aulas Ministradas</h3>
                <div class="historico-aulas-list" id="historicoAulasList">
                </div>
                <div class="form-group add-aula-form">
                    <h4>Registrar Nova Aula</h4>
                    <input type="hidden" id="aulaInstrutorId">
                    <label for="aulaData">Data:</label>
                    <input type="date" id="aulaData" required>
                    <label for="aulaUnidadeCurricular">Unidade Curricular:</label>
                    <input type="text" id="aulaUnidadeCurricular" placeholder="Ex: Lógica de Programação" required>
                    <label for="aulaTurmaCodigo">Turma (Código):</label>
                    <input type="text" id="aulaTurmaCodigo" placeholder="Ex: HT-SIS-01-24-M-12700" required>
                    <label for="aulaHoras">Horas:</label>
                    <input type="number" id="aulaHoras" min="1" required>
                    <button class="btn btn-primary btn-add-small" id="btnRegistrarAula"><i class="fas fa-plus"></i>
                        Registrar Aula</button>
                </div>

            </div>
        </div>
    </div>


    <script>
        // Dados iniciais e lógica de simulação
        let instrutoresData = <?php echo json_encode($instrutores); ?>;
        let turmasDisponiveis = <?php echo json_encode($turmas_disponiveis); ?>;
        let nextInstrutorId = Math.max(...instrutoresData.map(i => i.id)) + 1;

        // Elementos do Modal de Cadastro/Edição
        const instrutorModal = document.getElementById('instrutorModal');
        const addInstrutorBtn = document.getElementById('addInstrutorBtn');
        const closeInstrutorModalBtn = instrutorModal.querySelector('.close-button');
        const cancelInstrutorBtn = instrutorModal.querySelector('#cancelBtn');
        const modalTitle = document.getElementById('modalTitle');
        const instrutorForm = document.getElementById('instrutorForm');

        // Campos do formulário de Instrutor
        const instrutorIdInput = document.getElementById('instrutorId');
        const nomeInstrutorInput = document.getElementById('nomeInstrutor');
        const telefoneInstrutorInput = document.getElementById('telefoneInstrutor');
        const emailInstrutorInput = document.getElementById('emailInstrutor');
        const areaAtuacaoInput = document.getElementById('areaAtuacao');
        const observacoesInstrutorTextarea = document.getElementById('observacoesInstrutor');

        // Elementos do Modal de Detalhes (Associação/Histórico)
        const detalhesInstrutorModal = document.getElementById('detalhesInstrutorModal');
        const closeDetalhesBtn = document.getElementById('closeDetalhesBtn');
        const detalhesModalTitle = document.getElementById('detalhesModalTitle');
        const detalhesId = document.getElementById('detalhesId');
        const detalhesNome = document.getElementById('detalhesNome');
        const detalhesTelefone = document.getElementById('detalhesTelefone');
        const detalhesEmail = document.getElementById('detalhesEmail');
        const detalhesAreaAtuacao = document.getElementById('detalhesAreaAtuacao');
        const detalhesObservacoes = document.getElementById('detalhesObservacoes');
        const turmasAssociadasList = document.getElementById('turmasAssociadasList');
        const addTurmaToInstrutorSelect = document.getElementById('addTurmaToInstrutor');
        const btnAssociarTurma = document.getElementById('btnAssociarTurma');
        const historicoAulasList = document.getElementById('historicoAulasList');
        const aulaInstrutorIdInput = document.getElementById('aulaInstrutorId');
        const aulaDataInput = document.getElementById('aulaData');
        const aulaUnidadeCurricularInput = document.getElementById('aulaUnidadeCurricular');
        const aulaTurmaCodigoInput = document.getElementById('aulaTurmaCodigo');
        const aulaHorasInput = document.getElementById('aulaHoras');
        const btnRegistrarAula = document.getElementById('btnRegistrarAula');

        // Tabela
        const dataTableBody = document.querySelector('.data-table tbody');
        const searchInstrutorInput = document.getElementById('searchInstrutor');
        const filterDateInput = document.getElementById('filterDate'); // Novo input de data
        const availabilityFilterSelect = document.getElementById('availabilityFilter'); // Novo select de disponibilidade

        // Funções de Utilidade (reutilizadas da tela de turmas)
        function formatDateForInput(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString + 'T00:00:00');
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function formatDisplayDate(dateString) {
            if (!dateString) return '';
            const [year, month, day] = dateString.split('-');
            return `${day}/${month}/${year}`;
        }

        // --- Event Listeners para Abrir/Fechar Modais ---
        addInstrutorBtn.onclick = () => {
            modalTitle.textContent = "Adicionar Novo Instrutor";
            instrutorIdInput.value = '';
            instrutorForm.reset();
            instrutorModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        };

        closeInstrutorModalBtn.onclick = () => {
            instrutorModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        cancelInstrutorBtn.onclick = () => {
            instrutorModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        closeDetalhesBtn.onclick = () => {
            detalhesInstrutorModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        window.onclick = (event) => {
            if (event.target == instrutorModal) {
                instrutorModal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
            if (event.target == detalhesInstrutorModal) {
                detalhesInstrutorModal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        };

        // --- Lógica de CRUD (Simulada no Frontend) ---
        function updateTableDisplay() {
            dataTableBody.innerHTML = '';
            const searchTerm = searchInstrutorInput.value.toLowerCase();
            const filterDate = filterDateInput.value; // Data selecionada no filtro
            const availabilityFilter = availabilityFilterSelect.value; // "livre", "ocupado" ou ""

            const filteredInstrutores = instrutoresData.filter(instrutor => {
                const nomeMatch = instrutor.nome.toLowerCase().includes(searchTerm);
                const emailMatch = instrutor.email.toLowerCase().includes(searchTerm);
                const areaMatch = instrutor.area_atuacao.toLowerCase().includes(searchTerm);
                const obsMatch = instrutor.observacoes.toLowerCase().includes(searchTerm);

                // Lógica de filtro por disponibilidade
                let isAvailable = true; // Assume que está livre por padrão se nenhuma data for selecionada
                if (filterDate) {
                    const hasClassOnSelectedDate = instrutor.historico_aulas.some(aula => aula.data === filterDate);

                    if (availabilityFilter === 'livre') {
                        isAvailable = !hasClassOnSelectedDate;
                    } else if (availabilityFilter === 'ocupado') {
                        isAvailable = hasClassOnSelectedDate;
                    }
                }

                return (nomeMatch || emailMatch || areaMatch || obsMatch) && isAvailable;
            });

            if (filteredInstrutores.length === 0) {
                const noDataRow = dataTableBody.insertRow();
                noDataRow.innerHTML = '<td colspan="7">Nenhum instrutor encontrado com os filtros aplicados.</td>';
                return;
            }

            filteredInstrutores.forEach(instrutor => {
                const row = dataTableBody.insertRow();
                const turmasNomes = instrutor.turmas_associadas.map(t => t.codigo_turma).join(', ') || 'Nenhuma';
                row.innerHTML = `
                    <td>${instrutor.id}</td>
                    <td>${instrutor.nome}</td>
                    <td>${instrutor.telefone}</td>
                    <td>${instrutor.email}</td>
                    <td>${instrutor.area_atuacao}</td>
                    <td>${turmasNomes}</td>
                    <td class="actions">
                        <button class="btn btn-icon btn-view-details" title="Ver Detalhes" data-id="${instrutor.id}"><i class="fas fa-info-circle"></i></button>
                        <button class="btn btn-icon btn-edit" title="Editar" data-id="${instrutor.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="${instrutor.id}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
            });
            attachTableActionListeners();
        }

        function attachTableActionListeners() {
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.onclick = (e) => openEditModal(e.currentTarget.dataset.id);
            });
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.onclick = (e) => deleteInstrutor(e.currentTarget.dataset.id);
            });
            document.querySelectorAll('.btn-view-details').forEach(button => {
                button.onclick = (e) => openDetalhesModal(e.currentTarget.dataset.id);
            });
        }

        instrutorForm.onsubmit = (event) => {
            event.preventDefault();

            const id = instrutorIdInput.value;
            const newInstrutor = {
                id: id ? parseInt(id) : nextInstrutorId++,
                nome: nomeInstrutorInput.value,
                telefone: telefoneInstrutorInput.value,
                email: emailInstrutorInput.value,
                area_atuacao: areaAtuacaoInput.value,
                turmas_associadas: [], // Sempre inicia vazio, associado nos detalhes
                historico_aulas: [], // Sempre inicia vazio, adicionado nos detalhes
                observacoes: observacoesInstrutorTextarea.value
            };

            if (id) {
                const index = instrutoresData.findIndex(i => i.id == id);
                if (index !== -1) {
                    // Mantém turmas_associadas e historico_aulas existentes ao editar
                    newInstrutor.turmas_associadas = instrutoresData[index].turmas_associadas;
                    newInstrutor.historico_aulas = instrutoresData[index].historico_aulas;
                    instrutoresData[index] = newInstrutor;
                }
            } else {
                instrutoresData.push(newInstrutor);
            }

            updateTableDisplay(); // Chama sem termo de busca para aplicar todos os filtros
            instrutorModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        function openEditModal(id) {
            const instrutor = instrutoresData.find(i => i.id == id);
            if (instrutor) {
                modalTitle.textContent = "Editar Instrutor";
                instrutorIdInput.value = instrutor.id;
                nomeInstrutorInput.value = instrutor.nome;
                telefoneInstrutorInput.value = instrutor.telefone;
                emailInstrutorInput.value = instrutor.email;
                areaAtuacaoInput.value = instrutor.area_atuacao;
                observacoesInstrutorTextarea.value = instrutor.observacoes;

                instrutorModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }
        }

        function deleteInstrutor(id) {
            if (confirm(`Tem certeza que deseja excluir o instrutor "${instrutoresData.find(i => i.id == id)?.nome}"?`)) {
                instrutoresData = instrutoresData.filter(i => i.id != id);
                updateTableDisplay(); // Chama sem termo de busca para aplicar todos os filtros
            }
        }

        // --- Lógica do Modal de Detalhes (Associação e Histórico) ---
        function openDetalhesModal(id) {
            const instrutor = instrutoresData.find(i => i.id == id);
            if (instrutor) {
                detalhesModalTitle.textContent = `Detalhes de ${instrutor.nome}`;
                detalhesId.textContent = instrutor.id;
                detalhesNome.textContent = instrutor.nome;
                detalhesTelefone.textContent = instrutor.telefone;
                detalhesEmail.textContent = instrutor.email;
                detalhesAreaAtuacao.textContent = instrutor.area_atuacao;
                detalhesObservacoes.textContent = instrutor.observacoes || 'N/A';

                // Preencher Associação a Turmas
                turmasAssociadasList.innerHTML = '';
                if (instrutor.turmas_associadas.length > 0) {
                    instrutor.turmas_associadas.forEach(turma => {
                        const div = document.createElement('div');
                        div.className = 'tag-turma';
                        div.innerHTML = `
                            <span>${turma.codigo_turma}</span>
                            <button class="remove-tag" data-instrutor-id="${instrutor.id}" data-turma-id="${turma.id_turma}">&times;</button>
                        `;
                        turmasAssociadasList.appendChild(div);
                    });
                } else {
                    turmasAssociadasList.innerHTML = '<p>Nenhuma turma associada.</p>';
                }

                // Preencher Histórico de Aulas
                historicoAulasList.innerHTML = '';
                if (instrutor.historico_aulas.length > 0) {
                    const ul = document.createElement('ul');
                    instrutor.historico_aulas.forEach((aula, index) => {
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <span>${formatDisplayDate(aula.data)} - ${aula.unidade_curricular} (${aula.turma_codigo}) - ${aula.horas}h</span>
                            <button class="remove-tag" data-instrutor-id="${instrutor.id}" data-aula-index="${index}">&times;</button>
                        `;
                        ul.appendChild(li);
                    });
                    historicoAulasList.appendChild(ul);
                } else {
                    historicoAulasList.innerHTML = '<p>Nenhuma aula registrada.</p>';
                }

                // Configurar o formulário de Adicionar Aula
                aulaInstrutorIdInput.value = instrutor.id;
                aulaDataInput.value = '';
                aulaUnidadeCurricularInput.value = '';
                aulaTurmaCodigoInput.value = '';
                aulaHorasInput.value = '';


                // Adicionar listener para remover associação de turma
                document.querySelectorAll('.tag-turma .remove-tag').forEach(button => {
                    button.onclick = (e) => removeTurmaAssociada(e.currentTarget.dataset.instrutorId, e.currentTarget.dataset.turmaId);
                });

                // Adicionar listener para remover aula do histórico
                document.querySelectorAll('.historico-aulas-list .remove-tag').forEach(button => {
                    button.onclick = (e) => removeAulaMinistrada(e.currentTarget.dataset.instrutorId, e.currentTarget.dataset.aulaIndex);
                });

                detalhesInstrutorModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }
        }

        btnAssociarTurma.onclick = () => {
            const instrutorId = detalhesId.textContent;
            const turmaSelecionadaId = addTurmaToInstrutorSelect.value;
            const turmaSelecionadaCodigo = addTurmaToInstrutorSelect.options[addTurmaToInstrutorSelect.selectedIndex].dataset.codigo;

            if (!instrutorId || !turmaSelecionadaId) {
                alert('Selecione uma turma para associar.');
                return;
            }

            const instrutor = instrutoresData.find(i => i.id == instrutorId);
            if (instrutor) {
                const existe = instrutor.turmas_associadas.some(t => t.id_turma == turmaSelecionadaId);
                if (!existe) {
                    instrutor.turmas_associadas.push({ id_turma: parseInt(turmaSelecionadaId), codigo_turma: turmaSelecionadaCodigo });
                    updateTableDisplay(); // Atualiza a tabela principal
                    openDetalhesModal(instrutorId); // Reabre o modal de detalhes para atualizar a lista
                } else {
                    alert('Esta turma já está associada a este instrutor.');
                }
            }
        };

        function removeTurmaAssociada(instrutorId, turmaId) {
            const instrutor = instrutoresData.find(i => i.id == instrutorId);
            if (instrutor) {
                instrutor.turmas_associadas = instrutor.turmas_associadas.filter(t => t.id_turma != turmaId);
                updateTableDisplay();
                openDetalhesModal(instrutorId);
            }
        }

        btnRegistrarAula.onclick = () => {
            const instrutorId = aulaInstrutorIdInput.value;
            const aulaData = aulaDataInput.value;
            const aulaUnidadeCurricular = aulaUnidadeCurricularInput.value;
            const aulaTurmaCodigo = aulaTurmaCodigoInput.value;
            const aulaHoras = parseInt(aulaHorasInput.value);

            if (!instrutorId || !aulaData || !aulaUnidadeCurricular || !aulaTurmaCodigo || isNaN(aulaHoras) || aulaHoras <= 0) {
                alert('Por favor, preencha todos os campos da aula corretamente.');
                return;
            }

            const instrutor = instrutoresData.find(i => i.id == instrutorId);
            if (instrutor) {
                instrutor.historico_aulas.push({
                    data: aulaData,
                    unidade_curricular: aulaUnidadeCurricular,
                    turma_codigo: aulaTurmaCodigo,
                    horas: aulaHoras
                });
                openDetalhesModal(instrutorId); // Reabre o modal para atualizar a lista
            }
        };

        function removeAulaMinistrada(instrutorId, aulaIndex) {
            const instrutor = instrutoresData.find(i => i.id == instrutorId);
            if (instrutor && instrutor.historico_aulas[aulaIndex]) {
                if (confirm(`Tem certeza que deseja remover esta aula: "${instrutor.historico_aulas[aulaIndex].unidade_curricular}"?`)) {
                    instrutor.historico_aulas.splice(aulaIndex, 1);
                    openDetalhesModal(instrutorId); // Reabre o modal para atualizar a lista
                }
            }
        }


        // Inicializa a exibição da tabela ao carregar a página e adiciona listeners para os novos filtros
        searchInstrutorInput.addEventListener('keyup', updateTableDisplay);
        filterDateInput.addEventListener('change', updateTableDisplay);
        availabilityFilterSelect.addEventListener('change', updateTableDisplay);


        document.addEventListener('DOMContentLoaded', () => updateTableDisplay());
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