<?php
// Simulação de dados de turmas (em um ambiente real, viriam de um banco de dados)
$turmas = [
    [
        'id' => 1,
        'codigo_turma' => 'HT-SIS-01-24-M-12700',
        'data_inicio' => '2024-08-01',
        'data_termino' => '2025-07-29',
        'turno' => 'MANHÃ',
        'num_alunos' => 30,
        'curso' => 'Desenvolvimento de Sistemas.'
    ],
    [
        'id' => 2,
        'codigo_turma' => 'HT-IPI-01-N-12700',
        'data_inicio' => '2025-05-10',
        'data_termino' => '2026-12-10',
        'turno' => 'NOITE',
        'num_alunos' => 30,
        'curso' => 'Informatica para Internet.'
    ],
    [
        'id' => 3,
        'codigo_turma' => 'HT-ADM-01-M-12700',
        'data_inicio' => '2024-08-01',
        'data_termino' => '2025-07-29',
        'turno' => 'MANHÃ',
        'num_alunos' => 22,
        'curso' => 'Administração.'
    ]
];

// Lógica de manipulação (exemplo simplificado, em um ambiente real usaria POST para formulários)
// A implementação real de CRUD aqui envolveria conexão com BD e manipulação de $_POST

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
    <title>Gestão de Turmas - SENAI</title>
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
                    <li><a href="gestao_turmas.php" class="active"><i class="fas fa-users"></i> Gestão de Turmas</a>
                    </li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de
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
            <div class="main-header">
                <h1>Gestão de Turmas</h1>
                <button class="btn btn-primary" id="addTurmaBtn">
                    <i class="fas fa-plus-circle"></i> Adicionar Turma
                </button>
            </div>

            <section class="table-section">
                <h2>Lista de Turmas</h2>
                <div class="filter-section">
                    <label for="searchTurma">Pesquisar Turma:</label>
                    <input type="text" id="searchTurma" placeholder="Digite o código ou curso..."
                        class="search-input">
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código da Turma</th>
                                <th>Data de Início</th>
                                <th>Data de Término</th>
                                <th>Turno</th>
                                <th>Nº de Alunos</th>
                                <th>Curso</th>
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
    <div id="turmaModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="modalTitle">Adicionar Nova Turma</h2>
            <form id="turmaForm">
                <input type="hidden" id="turmaId">
                <div class="form-group">
                    <label for="codigoTurma">Código da Turma:</label>
                    <input type="text" id="codigoTurma" required>
                </div>

                <div class="form-group">
                    <label for="dataInicio">Data de Início:</label>
                    <input type="date" id="dataInicio" required>
                </div>

                <div class="form-group">
                    <label for="dataTermino">Data de Término:</label>
                    <input type="date" id="dataTermino" required>
                </div>

                <div class="form-group">
                    <label for="turno">Turno:</label>
                    <select id="turno" required>
                        <option value="">Selecione o Turno</option>
                        <option value="MANHÃ">MANHÃ</option>
                        <option value="TARDE">TARDE</option>
                        <option value="NOITE">NOITE</option>
                        <option value="INTEGRAL">INTEGRAL</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="numAlunos">Número de Alunos:</label>
                    <input type="number" id="numAlunos" required>
                </div>

                <div class="form-group">
                    <label for="curso">Observações:</label>
                    <textarea id="curso" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Turma</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times-circle"></i>
                    Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Lógica para abrir e fechar o modal e preencher/enviar formulário (via JavaScript, para simulação frontend)
        const turmaModal = document.getElementById('turmaModal');
        const addTurmaBtn = document.getElementById('addTurmaBtn');
        const closeButton = document.querySelector('#turmaModal .close-button');
        const cancelBtn = document.querySelector('#turmaModal #cancelBtn');
        const modalTitle = document.getElementById('modalTitle');
        const turmaForm = document.getElementById('turmaForm');

        // Campos do formulário
        const turmaIdInput = document.getElementById('turmaId');
        const codigoTurmaInput = document.getElementById('codigoTurma');
        const dataInicioInput = document.getElementById('dataInicio');
        const dataTerminoInput = document.getElementById('dataTermino');
        const turnoSelect = document.getElementById('turno');
        const numAlunosInput = document.getElementById('numAlunos');
        const cursoTextarea = document.getElementById('curso');

        // Referência à tabela para manipulação via JS (para fins de demonstração)
        const dataTableBody = document.querySelector('.data-table tbody');

        // Campo de pesquisa
        const searchTurmaInput = document.getElementById('searchTurma');

        // Funções de formatação de data para JS
        function formatDateForInput(dateString) {
            const date = new Date(dateString + 'T00:00:00'); // Adiciona T00:00:00 para evitar problemas de fuso horário
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


        // --- Event Listeners para Abrir/Fechar Modal ---
        addTurmaBtn.onclick = () => {
            modalTitle.textContent = "Adicionar Nova Turma";
            turmaIdInput.value = ''; // Limpa o ID para indicar nova turma
            turmaForm.reset(); // Limpa todos os campos do formulário
            turmaModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        };

        closeButton.onclick = () => {
            turmaModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        cancelBtn.onclick = () => {
            turmaModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        window.onclick = (event) => {
            if (event.target == turmaModal) {
                turmaModal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        };

        // Simula os dados de PHP no JavaScript para manipulação
        let turmasData = <?php echo json_encode($turmas); ?>;
        let nextId = Math.max(...turmasData.map(t => t.id)) + 1; // Para novos IDs

        // MODIFICADO: updateTableDisplay agora aceita um termo de pesquisa
        function updateTableDisplay(searchTerm = '') {
            dataTableBody.innerHTML = ''; // Limpa a tabela

            // Filtra os dados com base no termo de pesquisa
            const filteredTurmas = turmasData.filter(turma => {
                const lowerCaseSearchTerm = searchTerm.toLowerCase();
                // Verifique se as propriedades existem antes de chamar .toLowerCase() ou .includes()
                const codigoTurmaMatch = turma.codigo_turma && turma.codigo_turma.toLowerCase().includes(lowerCaseSearchTerm);
                const cursoMatch = turma.curso && turma.curso.toLowerCase().includes(lowerCaseSearchTerm);
                const turnoMatch = turma.turno && turma.turno.toLowerCase().includes(lowerCaseSearchTerm);
                
                return codigoTurmaMatch || cursoMatch || turnoMatch;
            });

            if (filteredTurmas.length === 0) {
                const noDataRow = dataTableBody.insertRow();
                noDataRow.innerHTML = '<td colspan="8">Nenhuma turma encontrada.</td>';
                return;
            }

            filteredTurmas.forEach(turma => { // Usa os dados filtrados
                const row = dataTableBody.insertRow();
                row.innerHTML = `
                    <td>${turma.id}</td>
                    <td>${turma.codigo_turma}</td>
                    <td>${formatDisplayDate(turma.data_inicio)}</td>
                    <td>${formatDisplayDate(turma.data_termino)}</td>
                    <td>${turma.turno}</td>
                    <td>${turma.num_alunos}</td>
                    <td>${turma.curso}</td>
                    <td class="actions">
                        <button class="btn btn-icon btn-edit" title="Editar" data-id="${turma.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="${turma.id}"><i class="fas fa-trash-alt"></i></button>
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
                button.onclick = (e) => deleteTurma(e.currentTarget.dataset.id);
            });
        }

        turmaForm.onsubmit = (event) => {
            event.preventDefault();

            const id = turmaIdInput.value;
            const newTurma = {
                id: id ? parseInt(id) : nextId++,
                codigo_turma: codigoTurmaInput.value,
                data_inicio: dataInicioInput.value, // YYYY-MM-DD
                data_termino: dataTerminoInput.value, // YYYY-MM-DD
                turno: turnoSelect.value,
                num_alunos: parseInt(numAlunosInput.value),
                curso: cursoTextarea.value
            };

            if (id) {
                // Editar
                const index = turmasData.findIndex(t => t.id == id);
                if (index !== -1) {
                    turmasData[index] = newTurma;
                }
            } else {
                // Adicionar
                turmasData.push(newTurma);
            }

            // Garante que a tabela é atualizada com o termo de pesquisa atual
            updateTableDisplay(searchTurmaInput.value); 
            turmaModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        function openEditModal(id) {
            const turma = turmasData.find(t => t.id == id);
            if (turma) {
                modalTitle.textContent = "Editar Turma";
                turmaIdInput.value = turma.id;
                codigoTurmaInput.value = turma.codigo_turma;
                dataInicioInput.value = formatDateForInput(turma.data_inicio);
                dataTerminoInput.value = formatDateForInput(turma.data_termino);
                turnoSelect.value = turma.turno;
                numAlunosInput.value = turma.num_alunos;
                cursoTextarea.value = turma.curso;

                turmaModal.style.display = 'flex';
                document.body.classList.add('modal-open');
            }
        }

        function deleteTurma(id) {
            if (confirm(`Tem certeza que deseja excluir a turma com ID ${id} e código ${turmasData.find(t => t.id == id)?.codigo_turma}?`)) {
                turmasData = turmasData.filter(t => t.id != id);
                // Garante que a tabela é atualizada com o termo de pesquisa atual
                updateTableDisplay(searchTurmaInput.value); 
            }
        }

        // Adiciona o event listener para o campo de pesquisa
        searchTurmaInput.addEventListener('keyup', (event) => {
            updateTableDisplay(event.target.value);
        });

        // Inicializa a exibição da tabela ao carregar a página
        // Chama a função com o valor inicial do campo de pesquisa (que será vazio)
        document.addEventListener('DOMContentLoaded', () => updateTableDisplay(searchTurmaInput.value));
    </script>
</body>

</html>