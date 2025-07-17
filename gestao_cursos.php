<?php
// Inclui o arquivo que contém a lista de cursos
require_once 'dados_cursos.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Cursos - SENAI</title>
    <link rel="stylesheet" href="style_turmas.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="logo.png" alt="Logo SENAI" class="sidebar-logo">
                <h3>Menu Principal</h3>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.html"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="gestao_cursos.php" class="active"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                    <li><a href="gestao_salas.php"><i class="fas fa-door-open"></i> Gestão de Salas</a></li>
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
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
                <h1>Gestão de Cursos</h1>
                <button class="btn btn-primary" onclick="openAddCursoModal()"><i class="fas fa-plus-circle"></i>
                    Adicionar Novo Curso</button>
            </header>

            <section class="table-section">
                <h2>Cursos Cadastrados</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome do Curso</th>
                                <th>Classificação</th>
                                <th>Modalidade</th>
                                <th>Carga Horária (h)</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Unidades Curriculares</th> <!-- Nova coluna -->
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dados serão populados via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal de Adicionar/Editar Curso -->
    <div id="addCursoModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('addCursoModal')">&times;</span>
            <h2><span id="modalTitle">Adicionar Novo Curso</span></h2>
            <form id="cursoForm" action="processa_curso.php" method="POST">
                <input type="hidden" id="cursoId" name="id">
                <input type="hidden" id="action" name="action" value="add">

                <div class="form-group">
                    <label for="codigoCurso">Código do Curso:</label>
                    <input type="text" id="codigoCurso" name="codigo_curso" required>
                </div>
                <div class="form-group">
                    <label for="nomeCurso">Nome do Curso/Turma:</label>
                    <input type="text" id="nomeCurso" name="nome_curso" required>
                </div>
                <div class="form-group">
                    <label for="classificacao">Classificação:</label>
                    <select id="classificacao" name="classificacao" required>
                        <option value="">Selecione</option>
                        <option value="TURMA">TURMA</option>
                        <option value="UNIDADE CURRICULAR">UNIDADE CURRICULAR</option>
                        <option value="APERFEICOAMENTO">APERFEIÇOAMENTO</option>
                        <option value="TECNICO">TÉCNICO</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="modalidade">Modalidade:</label>
                    <select id="modalidade" name="modalidade" required>
                        <option value="">Selecione</option>
                        <option value="APERFEICOAMENTO">APERFEIÇOAMENTO</option>
                        <option value="APRENDIZAGEM">APRENDIZAGEM</option>
                        <option value="TECNICO">TÉCNICO</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cargaHoraria">Carga Horária (h):</label>
                    <input type="number" id="cargaHoraria" name="carga_horaria" required min="1">
                </div>
                <div class="form-group">
                    <label for="tipoCurso">Tipo de Curso:</label>
                    <select id="tipoCurso" name="tipo_curso" required>
                        <option value="">Selecione</option>
                        <option value="PRESENCIAL">PRESENCIAL</option>
                        <option value="EAD">EAD</option>
                        <option value="NA EMPRESA">NA EMPRESA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecione</option>
                        <option value="A">A</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <!-- Nova Seção para Unidades Curriculares da Grade -->
                <div class="uc-selection-section">
                    <h3>Unidades Curriculares da Grade</h3>
                    <div id="ucTagsContainer" class="uc-tags-container">
                        <!-- UCs selecionadas serão exibidas aqui como tags -->
                    </div>
                    <input type="text" id="ucSearchInput" class="uc-search-input" placeholder="Buscar Unidade Curricular...">
                    <div id="ucListForSelection" class="uc-list-container">
                        <!-- Lista de UCs com checkboxes será gerada aqui -->
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Salvar Curso</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('addCursoModal')">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Dados iniciais (simulados) - serão carregados via fetch
        let cursosData = <?php echo json_encode($cursos); ?>;
        let unidadesCurricularesData = []; // Será preenchido via fetch
        let nextCursoId = Math.max(...cursosData.map(c => c.id)) + 1;

        // Elementos do DOM
        const dataTableBody = document.querySelector('.data-table tbody');
        const addCursoModal = document.getElementById('addCursoModal');
        const modalTitle = document.getElementById('modalTitle');
        const cursoForm = document.getElementById('cursoForm');
        const cursoIdInput = document.getElementById('cursoId');
        const actionInput = document.getElementById('action');
        const codigoCursoInput = document.getElementById('codigoCurso');
        const nomeCursoInput = document.getElementById('nomeCurso');
        const classificacaoSelect = document.getElementById('classificacao');
        const modalidadeSelect = document.getElementById('modalidade');
        const cargaHorariaInput = document.getElementById('cargaHoraria');
        const tipoCursoSelect = document.getElementById('tipoCurso');
        const categoriaSelect = document.getElementById('categoria');

        // Elementos da seleção de UC
        const ucTagsContainer = document.getElementById('ucTagsContainer');
        const ucSearchInput = document.getElementById('ucSearchInput');
        const ucListForSelection = document.getElementById('ucListForSelection');
        let selectedUCs = []; // Array para armazenar as UCs selecionadas para o curso atual

        // --- Funções de Fetch de Dados ---
        async function fetchUnidadesCurriculares() {
            try {
                const response = await fetch('dados_unidades_curriculares.php');
                if (!response.ok) {
                    throw new Error(`Erro HTTP! status: ${response.status}`);
                }
                unidadesCurricularesData = await response.json();
                renderUCListForSelection(); // Renderiza a lista de UCs no modal
            } catch (error) {
                console.error("Erro ao buscar dados das Unidades Curriculares:", error);
                ucListForSelection.innerHTML = '<p class="text-red-500">Erro ao carregar UCs. Verifique o servidor PHP.</p>';
            }
        }

        // --- Funções de Renderização e Lógica ---

        function updateTableDisplay() {
            dataTableBody.innerHTML = '';
            cursosData.forEach(curso => {
                const row = dataTableBody.insertRow();
                const ucNames = curso.unidades_curriculares ? curso.unidades_curriculares.map(uc => uc.nome).join(', ') : 'N/A'; // Exibe nomes das UCs
                row.innerHTML = `
                    <td>${htmlspecialchars(curso.codigo)}</td>
                    <td>${htmlspecialchars(curso.nome)}</td>
                    <td>${htmlspecialchars(curso.classificacao)}</td>
                    <td>${htmlspecialchars(curso.modalidade)}</td>
                    <td>${htmlspecialchars(curso.carga_horaria)}</td>
                    <td>${htmlspecialchars(curso.tipo)}</td>
                    <td>${htmlspecialchars(curso.categoria)}</td>
                    <td>${htmlspecialchars(ucNames)}</td>
                    <td class="actions">
                        <button class="btn btn-icon btn-edit" onclick="editCurso(${curso.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon btn-delete" onclick="deleteCurso(${curso.id})"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
            });
        }

        function openAddCursoModal() {
            modalTitle.textContent = 'Adicionar Novo Curso';
            actionInput.value = 'add';
            cursoIdInput.value = '';
            cursoForm.reset();
            selectedUCs = []; // Limpa as UCs selecionadas ao abrir para adicionar
            renderUCTags();
            renderUCListForSelection(); // Garante que a lista de seleção esteja atualizada
            addCursoModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function editCurso(id) {
            const curso = cursosData.find(c => c.id === id);
            if (curso) {
                openModal('addCursoModal');
                modalTitle.textContent = 'Editar Curso';
                actionInput.value = 'edit';
                cursoIdInput.value = curso.id;
                codigoCursoInput.value = curso.codigo;
                nomeCursoInput.value = curso.nome;
                classificacaoSelect.value = curso.classificacao;
                modalidadeSelect.value = curso.modalidade;
                cargaHorariaInput.value = curso.carga_horaria;
                tipoCursoSelect.value = curso.tipo;
                categoriaSelect.value = curso.categoria;

                selectedUCs = curso.unidades_curriculares ? [...curso.unidades_curriculares] : []; // Carrega UCs existentes
                renderUCTags();
                renderUCListForSelection(); // Atualiza checkboxes com base nas UCs carregadas
            } else {
                alert('Curso não encontrado.');
            }
        }

        function saveCurso(event) {
            event.preventDefault();

            const id = cursoIdInput.value;
            const newCurso = {
                id: id ? parseInt(id) : nextCursoId++,
                codigo: codigoCursoInput.value,
                nome: nomeCursoInput.value,
                classificacao: classificacaoSelect.value,
                modalidade: modalidadeSelect.value,
                carga_horaria: parseInt(cargaHorariaInput.value),
                tipo: tipoCursoSelect.value,
                categoria: categoriaSelect.value,
                unidades_curriculares: selectedUCs // Adiciona as UCs selecionadas
            };

            if (id) {
                // Editar Curso
                const index = cursosData.findIndex(c => c.id == id);
                if (index !== -1) {
                    cursosData[index] = newCurso;
                    alert('Curso atualizado com sucesso!');
                }
            } else {
                // Adicionar Novo Curso
                cursosData.push(newCurso);
                alert('Curso adicionado com sucesso!');
            }

            updateTableDisplay();
            closeModal('addCursoModal');
        }

        function deleteCurso(id) {
            if (confirm('Tem certeza que deseja excluir este curso?')) {
                cursosData = cursosData.filter(c => c.id != id);
                updateTableDisplay();
                alert('Curso excluído (simulação).');
            }
        }

        // --- Funções de Gestão de Unidades Curriculares no Modal ---

        function renderUCListForSelection() {
            ucListForSelection.innerHTML = '';
            const searchTerm = ucSearchInput.value.toLowerCase();

            const filteredUCs = unidadesCurricularesData.filter(uc =>
                uc.nome.toLowerCase().includes(searchTerm)
            );

            if (filteredUCs.length === 0) {
                ucListForSelection.innerHTML = '<p class="text-gray-500">Nenhuma UC encontrada.</p>';
                return;
            }

            filteredUCs.forEach(uc => {
                const isSelected = selectedUCs.some(sUC => sUC.id === uc.id);

                const div = document.createElement('div');
                div.classList.add('uc-list-item');
                div.innerHTML = `
                    <input type="checkbox" id="uc-${uc.id}" value="${uc.id}" ${isSelected ? 'checked' : ''}>
                    <label for="uc-${uc.id}">${htmlspecialchars(uc.nome)}</label>
                    <span>(${uc.carga_horaria}h)</span>
                `;
                ucListForSelection.appendChild(div);

                // Adiciona listener ao checkbox
                div.querySelector('input[type="checkbox"]').addEventListener('change', (event) => {
                    if (event.target.checked) {
                        // Adiciona UC se ainda não estiver na lista de selecionadas
                        if (!selectedUCs.some(sUC => sUC.id === uc.id)) {
                            selectedUCs.push(uc);
                        }
                    } else {
                        // Remove UC da lista de selecionadas
                        selectedUCs = selectedUCs.filter(sUC => sUC.id !== uc.id);
                    }
                    renderUCTags(); // Atualiza as tags exibidas
                });
            });
        }

        function renderUCTags() {
            ucTagsContainer.innerHTML = '';
            if (selectedUCs.length === 0) {
                ucTagsContainer.innerHTML = '<p class="text-gray-500 text-sm italic">Nenhuma UC selecionada.</p>';
                return;
            }
            selectedUCs.forEach(uc => {
                const span = document.createElement('span');
                span.classList.add('uc-tag');
                span.innerHTML = `
                    ${htmlspecialchars(uc.nome)}
                    <button type="button" class="remove-uc-tag" data-uc-id="${uc.id}">&times;</button>
                `;
                ucTagsContainer.appendChild(span);

                span.querySelector('.remove-uc-tag').addEventListener('click', (event) => {
                    const ucIdToRemove = parseInt(event.target.dataset.ucId);
                    selectedUCs = selectedUCs.filter(sUC => sUC.id !== ucIdToRemove);
                    renderUCTags(); // Atualiza as tags
                    renderUCListForSelection(); // Desmarca o checkbox na lista de seleção
                });
            });
        }

        // Função auxiliar para escapar HTML
        function htmlspecialchars(str) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(str));
            return div.innerHTML;
        }

        // --- Event Listeners Globais ---
        document.addEventListener('DOMContentLoaded', () => {
            updateTableDisplay();
            fetchUnidadesCurriculares(); // Carrega as UCs ao carregar a página
        });

        cursoForm.addEventListener('submit', saveCurso);
        ucSearchInput.addEventListener('input', renderUCListForSelection); // Filtra a lista de UCs ao digitar

        // Lógica para abrir/fechar modal (ajustada para a nova função openAddCursoModal)
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.classList.remove('modal-open');
            document.getElementById('cursoForm').reset();
            document.getElementById('modalTitle').textContent = 'Adicionar Novo Curso';
            document.getElementById('action').value = 'add';
            document.getElementById('cursoId').value = '';
            selectedUCs = []; // Limpa as UCs selecionadas ao fechar
            renderUCTags(); // Atualiza as tags para refletir a limpeza
        }

        window.onclick = function(event) {
            const modal = document.getElementById('addCursoModal');
            if (event.target == modal) {
                closeModal('addCursoModal');
            }
        }

        // Menu Toggle para Mobile
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');

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
