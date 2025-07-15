<?php
// Simulação de dados de Unidades Curriculares (em um ambiente real, viriam de um banco de dados)
$unidadesCurriculares = [
    [
        'id' => 1,
        'nome' => 'Lógica de Programação',
        'carga_horaria' => 80,
        'dias_pratica' => 10,
        'dias_teorica' => 10,
        'dias_ead' => 0,
        'instrutor_atuante' => 'João Silva',
        'instrutor_substituto' => 'Carlos Pereira',
        'salas_ideais' => 'Laboratório 1, Sala B2'
    ],
    [
        'id' => 2,
        'nome' => 'Banco de Dados',
        'carga_horaria' => 120,
        'dias_pratica' => 15,
        'dias_teorica' => 15,
        'dias_ead' => 0,
        'instrutor_atuante' => 'Maria Oliveira',
        'instrutor_substituto' => 'Ana Santos',
        'salas_ideais' => 'Laboratório 2, Sala C1'
    ],
    [
        'id' => 3,
        'nome' => 'Metodologias Ágeis',
        'carga_horaria' => 40,
        'dias_pratica' => 0,
        'dias_teorica' => 5,
        'dias_ead' => 5,
        'instrutor_atuante' => 'Fernanda Lima',
        'instrutor_substituto' => 'N/A',
        'salas_ideais' => 'Sala Reuniões'
    ],
    [
        'id' => 4,
        'nome' => 'Eletricidade Básica',
        'carga_horaria' => 100,
        'dias_pratica' => 12,
        'dias_teorica' => 13,
        'dias_ead' => 0,
        'instrutor_atuante' => 'Pedro Almeida',
        'instrutor_substituto' => 'N/A',
        'salas_ideais' => 'Oficina Elétrica, Sala A1'
    ],
];

// Função para buscar o próximo ID disponível (simulação)
function getNextId($data)
{
    return !empty($data) ? max(array_column($data, 'id')) + 1 : 1;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Unidades Curriculares - SENAI</title>
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
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                    <li><a href="gestao_salas.php"><i class="fas fa-door-open"></i> Gestão de Salas</a></li>
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php" class="active"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <button class="menu-toggle" id="menu-toggle">
        <i class="fas fa-bars"></i>
    </button>
            
            <header class="main-header">
                <h1>Gestão de Unidades Curriculares</h1>
                <button class="btn btn-primary" id="addUcBtn"><i class="fas fa-plus-circle"></i> Adicionar Nova UC</button>
            </header>

            <section class="table-section">
                <h2>Unidades Curriculares Cadastradas</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchUc">Buscar UC (Nome, Instrutor):</label>
                        <input type="text" id="searchUc" placeholder="Digite para filtrar..." class="search-input">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Carga Horária (h)</th>
                                <th>Prática (dias)</th>
                                <th>Teórica (dias)</th>
                                <th>EAD (dias)</th>
                                <th>Instrutor Atuante</th>
                                <th>Instrutor Substituto</th>
                                <th>Salas Ideais</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($unidadesCurriculares as $uc) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($uc['id']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['carga_horaria']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['dias_pratica']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['dias_teorica']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['dias_ead']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['instrutor_atuante']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['instrutor_substituto']); ?></td>
                                    <td><?php echo htmlspecialchars($uc['salas_ideais']); ?></td>
                                    <td class="actions">
                                        <button class="btn btn-icon btn-edit" title="Editar" data-id="<?php echo $uc['id']; ?>"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="<?php echo $uc['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="ucModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="modalTitle">Adicionar Nova Unidade Curricular</h2>
            <form id="ucForm">
                <input type="hidden" id="ucId">
                <div class="form-group">
                    <label for="nomeUc">Nome:</label>
                    <input type="text" id="nomeUc" required>
                </div>
                <div class="form-group">
                    <label for="cargaHoraria">Carga Horária (h):</label>
                    <input type="number" id="cargaHoraria" required min="1">
                </div>
                <div class="form-group">
                    <label for="diasPratica">Dias de Prática:</label>
                    <input type="number" id="diasPratica" required min="0">
                </div>
                <div class="form-group">
                    <label for="diasTeorica">Dias Teóricos:</label>
                    <input type="number" id="diasTeorica" required min="0">
                </div>
                <div class="form-group">
                    <label for="diasEad">Dias EAD:</label>
                    <input type="number" id="diasEad" required min="0">
                </div>
                <div class="form-group">
                    <label for="instrutorAtuante">Instrutor Atuante:</label>
                    <input type="text" id="instrutorAtuante">
                </div>
                <div class="form-group">
                    <label for="instrutorSubstituto">Instrutor Substituto:</label>
                    <input type="text" id="instrutorSubstituto">
                </div>
                <div class="form-group">
                    <label for="salasIdeais">Salas Ideais:</label>
                    <input type="text" id="salasIdeais">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar UC</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times-circle"></i> Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Simulação dos dados e do próximo ID
        let unidadesCurricularesData = <?php echo json_encode($unidadesCurriculares); ?>;
        let nextUcId = <?php echo getNextId($unidadesCurriculares); ?>;

        // Referências aos elementos do DOM
        const ucModal = document.getElementById('ucModal');
        const addUcBtn = document.getElementById('addUcBtn');
        const closeBtn = ucModal.querySelector('.close-button');
        const cancelBtn = ucModal.querySelector('#cancelBtn');
        const ucForm = document.getElementById('ucForm');
        const modalTitle = document.getElementById('modalTitle');
        const dataTableBody = document.querySelector('.data-table tbody');
        const searchUcInput = document.getElementById('searchUc');

        // Campos do formulário
        const ucIdInput = document.getElementById('ucId');
        const nomeUcInput = document.getElementById('nomeUc');
        const cargaHorariaInput = document.getElementById('cargaHoraria');
        const diasPraticaInput = document.getElementById('diasPratica');
        const diasTeoricaInput = document.getElementById('diasTeorica');
        const diasEadInput = document.getElementById('diasEad');
        const instrutorAtuanteInput = document.getElementById('instrutorAtuante');
        const instrutorSubstitutoInput = document.getElementById('instrutorSubstituto');
        const salasIdeaisInput = document.getElementById('salasIdeais');

        // --- Funções do Modal ---
        function openModal() {
            ucModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeModal() {
            ucModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            ucForm.reset();
            modalTitle.textContent = "Adicionar Nova Unidade Curricular";
            ucIdInput.value = '';
        }

        // --- Funções de CRUD (Simulação) ---
        function updateTableDisplay() {
            dataTableBody.innerHTML = '';
            const searchTerm = searchUcInput.value.toLowerCase();

            const filteredUcs = unidadesCurricularesData.filter(uc => {
                const searchString = `${uc.nome} ${uc.instrutor_atuante} ${uc.instrutor_substituto}`.toLowerCase();
                return searchString.includes(searchTerm);
            });

            if (filteredUcs.length === 0) {
                const noDataRow = dataTableBody.insertRow();
                noDataRow.innerHTML = '<td colspan="10">Nenhuma unidade curricular encontrada com os filtros aplicados.</td>';
                return;
            }

            filteredUcs.forEach(uc => {
                const row = dataTableBody.insertRow();
                row.innerHTML = `
                    <td>${uc.id}</td>
                    <td>${uc.nome}</td>
                    <td>${uc.carga_horaria}</td>
                    <td>${uc.dias_pratica}</td>
                    <td>${uc.dias_teorica}</td>
                    <td>${uc.dias_ead}</td>
                    <td>${uc.instrutor_atuante}</td>
                    <td>${uc.instrutor_substituto}</td>
                    <td>${uc.salas_ideais}</td>
                    <td class="actions">
                        <button class="btn btn-icon btn-edit" title="Editar" data-id="${uc.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="${uc.id}"><i class="fas fa-trash-alt"></i></button>
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
                button.onclick = (e) => deleteUc(e.currentTarget.dataset.id);
            });
        }

        function openEditModal(id) {
            const uc = unidadesCurricularesData.find(e => e.id == id);
            if (uc) {
                modalTitle.textContent = "Editar Unidade Curricular";
                ucIdInput.value = uc.id;
                nomeUcInput.value = uc.nome;
                cargaHorariaInput.value = uc.carga_horaria;
                diasPraticaInput.value = uc.dias_pratica;
                diasTeoricaInput.value = uc.dias_teorica;
                diasEadInput.value = uc.dias_ead;
                instrutorAtuanteInput.value = uc.instrutor_atuante;
                instrutorSubstitutoInput.value = uc.instrutor_substituto;
                salasIdeaisInput.value = uc.salas_ideais;
                openModal();
            }
        }

        function deleteUc(id) {
            if (confirm(`Tem certeza que deseja excluir a UC "${unidadesCurricularesData.find(e => e.id == id)?.nome}"?`)) {
                unidadesCurricularesData = unidadesCurricularesData.filter(e => e.id != id);
                updateTableDisplay();
            }
        }

        // --- Event Listeners ---
        addUcBtn.onclick = openModal;
        closeBtn.onclick = closeModal;
        cancelBtn.onclick = closeModal;
        searchUcInput.oninput = updateTableDisplay;

        ucForm.onsubmit = (event) => {
            event.preventDefault();
            const id = ucIdInput.value;
            const newUc = {
                id: id ? parseInt(id) : nextUcId++,
                nome: nomeUcInput.value,
                carga_horaria: parseInt(cargaHorariaInput.value),
                dias_pratica: parseInt(diasPraticaInput.value),
                dias_teorica: parseInt(diasTeoricaInput.value),
                dias_ead: parseInt(diasEadInput.value),
                instrutor_atuante: instrutorAtuanteInput.value,
                instrutor_substituto: instrutorSubstitutoInput.value,
                salas_ideais: salasIdeaisInput.value,
            };

            if (id) {
                const index = unidadesCurricularesData.findIndex(e => e.id == id);
                if (index !== -1) {
                    unidadesCurricularesData[index] = newUc;
                }
            } else {
                unidadesCurricularesData.push(newUc);
            }
            updateTableDisplay();
            closeModal();
        };

        window.onclick = (event) => {
            if (event.target == ucModal) {
                closeModal();
            }
        };

        // Carrega a tabela na inicialização
        document.addEventListener('DOMContentLoaded', updateTableDisplay);
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