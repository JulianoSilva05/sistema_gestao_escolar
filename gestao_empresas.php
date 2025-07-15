<?php
// Simulação de dados de empresas (em um ambiente real, viriam de um banco de dados)
$empresas = [
    [
        'id' => 1,
        'nome' => 'ACME Soluções Industriais Ltda.',
        'cnpj_matriz' => '00.000.000/0001-01',
        'cnpj_filial' => 'N/A',
        'endereco' => 'Rua das Indústrias, 123 - Distrito Industrial',
        'responsavel_nome' => 'Rodrigo Azevedo',
        'responsavel_telefone' => '(31) 99888-7777',
        'responsavel_email' => 'rodrigo.a@acme.com.br'
    ],
    [
        'id' => 2,
        'nome' => 'TechCorp Sistemas S.A.',
        'cnpj_matriz' => '01.111.111/0001-11',
        'cnpj_filial' => '01.111.111/0002-22',
        'endereco' => 'Avenida dos Inovadores, 456 - Centro',
        'responsavel_nome' => 'Fernanda Costa',
        'responsavel_telefone' => '(31) 99777-6666',
        'responsavel_email' => 'fernanda.c@techcorp.com.br'
    ],
    [
        'id' => 3,
        'nome' => 'Metalúrgica Brasil Ltda.',
        'cnpj_matriz' => '02.222.222/0001-22',
        'cnpj_filial' => 'N/A',
        'endereco' => 'Rua da Usinagem, 789 - Parque Fabril',
        'responsavel_nome' => 'Gustavo Lima',
        'responsavel_telefone' => '(31) 99666-5555',
        'responsavel_email' => 'gustavo.l@metalurgica.com.br'
    ],
    [
        'id' => 4,
        'nome' => 'Logística Rápida S/A',
        'cnpj_matriz' => '03.333.333/0001-33',
        'cnpj_filial' => '03.333.333/0002-44',
        'endereco' => 'Rodovia da Entrega, 101 - Polo Logístico',
        'responsavel_nome' => 'Juliana Souza',
        'responsavel_telefone' => '(31) 99555-4444',
        'responsavel_email' => 'juliana.s@logistica.com.br'
    ]
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
    <title>Gestão de Empresas - SENAI</title>
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
                    <li><a href="gestao_empresas.php" class="active"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
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
                <h1>Gestão de Empresas</h1>
                <button class="btn btn-primary" id="addEmpresaBtn"><i class="fas fa-plus-circle"></i> Adicionar Nova Empresa</button>
            </header>

            <section class="table-section">
                <h2>Empresas Cadastradas</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchEmpresa">Buscar Empresa (Nome, CNPJ, Responsável):</label>
                        <input type="text" id="searchEmpresa" placeholder="Digite para filtrar..." class="search-input">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome da Empresa</th>
                                <th>CNPJ Matriz</th>
                                <th>CNPJ Filial</th>
                                <th>Endereço</th>
                                <th>Responsável</th>
                                <th>Telefone Responsável</th>
                                <th>Email Responsável</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empresas as $empresa) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($empresa['id']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['cnpj_matriz']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['cnpj_filial']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['endereco']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['responsavel_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['responsavel_telefone']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['responsavel_email']); ?></td>
                                    <td class="actions">
                                        <button class="btn btn-icon btn-edit" title="Editar" data-id="<?php echo $empresa['id']; ?>"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="<?php echo $empresa['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="empresaModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="modalTitle">Adicionar Nova Empresa</h2>
            <form id="empresaForm">
                <input type="hidden" id="empresaId">
                <div class="form-group">
                    <label for="nomeEmpresa">Nome da Empresa:</label>
                    <input type="text" id="nomeEmpresa" required>
                </div>
                <div class="form-group">
                    <label for="cnpjMatriz">CNPJ Matriz:</label>
                    <input type="text" id="cnpjMatriz" placeholder="00.000.000/0001-00" required>
                </div>
                <div class="form-group">
                    <label for="cnpjFilial">CNPJ Filial (se houver):</label>
                    <input type="text" id="cnpjFilial" placeholder="00.000.000/0001-00">
                </div>
                <div class="form-group">
                    <label for="enderecoEmpresa">Endereço:</label>
                    <input type="text" id="enderecoEmpresa" required>
                </div>
                <div class="form-group">
                    <label for="responsavelNome">Nome do Responsável:</label>
                    <input type="text" id="responsavelNome" required>
                </div>
                <div class="form-group">
                    <label for="responsavelTelefone">Telefone do Responsável:</label>
                    <input type="text" id="responsavelTelefone" placeholder="(XX) XXXXX-XXXX" required>
                </div>
                <div class="form-group">
                    <label for="responsavelEmail">Email do Responsável:</label>
                    <input type="email" id="responsavelEmail" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Empresa</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times-circle"></i> Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Simulação dos dados e do próximo ID
        let empresasData = <?php echo json_encode($empresas); ?>;
        let nextEmpresaId = <?php echo getNextId($empresas); ?>;

        // Referências aos elementos do DOM
        const empresaModal = document.getElementById('empresaModal');
        const addEmpresaBtn = document.getElementById('addEmpresaBtn');
        const closeBtn = empresaModal.querySelector('.close-button');
        const cancelBtn = empresaModal.querySelector('#cancelBtn');
        const empresaForm = document.getElementById('empresaForm');
        const modalTitle = document.getElementById('modalTitle');
        const dataTableBody = document.querySelector('.data-table tbody');
        const searchEmpresaInput = document.getElementById('searchEmpresa');

        // Campos do formulário
        const empresaIdInput = document.getElementById('empresaId');
        const nomeEmpresaInput = document.getElementById('nomeEmpresa');
        const cnpjMatrizInput = document.getElementById('cnpjMatriz');
        const cnpjFilialInput = document.getElementById('cnpjFilial');
        const enderecoEmpresaInput = document.getElementById('enderecoEmpresa');
        const responsavelNomeInput = document.getElementById('responsavelNome');
        const responsavelTelefoneInput = document.getElementById('responsavelTelefone');
        const responsavelEmailInput = document.getElementById('responsavelEmail');

        // --- Funções do Modal ---
        function openModal() {
            empresaModal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeModal() {
            empresaModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            empresaForm.reset();
            modalTitle.textContent = "Adicionar Nova Empresa";
            empresaIdInput.value = '';
        }

        // --- Funções de CRUD (Simulação) ---
        function updateTableDisplay() {
            dataTableBody.innerHTML = '';
            const searchTerm = searchEmpresaInput.value.toLowerCase();

            const filteredEmpresas = empresasData.filter(empresa => {
                const searchString = `${empresa.nome} ${empresa.cnpj_matriz} ${empresa.cnpj_filial} ${empresa.responsavel_nome} ${empresa.responsavel_email}`.toLowerCase();
                return searchString.includes(searchTerm);
            });

            if (filteredEmpresas.length === 0) {
                const noDataRow = dataTableBody.insertRow();
                noDataRow.innerHTML = '<td colspan="9">Nenhuma empresa encontrada com os filtros aplicados.</td>';
                return;
            }

            filteredEmpresas.forEach(empresa => {
                const row = dataTableBody.insertRow();
                row.innerHTML = `
                    <td>${empresa.id}</td>
                    <td>${empresa.nome}</td>
                    <td>${empresa.cnpj_matriz}</td>
                    <td>${empresa.cnpj_filial}</td>
                    <td>${empresa.endereco}</td>
                    <td>${empresa.responsavel_nome}</td>
                    <td>${empresa.responsavel_telefone}</td>
                    <td>${empresa.responsavel_email}</td>
                    <td class="actions">
                        <button class="btn btn-icon btn-edit" title="Editar" data-id="${empresa.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon btn-delete" title="Excluir" data-id="${empresa.id}"><i class="fas fa-trash-alt"></i></button>
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
                button.onclick = (e) => deleteEmpresa(e.currentTarget.dataset.id);
            });
        }

        function openEditModal(id) {
            const empresa = empresasData.find(e => e.id == id);
            if (empresa) {
                modalTitle.textContent = "Editar Empresa";
                empresaIdInput.value = empresa.id;
                nomeEmpresaInput.value = empresa.nome;
                cnpjMatrizInput.value = empresa.cnpj_matriz;
                cnpjFilialInput.value = empresa.cnpj_filial;
                enderecoEmpresaInput.value = empresa.endereco;
                responsavelNomeInput.value = empresa.responsavel_nome;
                responsavelTelefoneInput.value = empresa.responsavel_telefone;
                responsavelEmailInput.value = empresa.responsavel_email;
                openModal();
            }
        }

        function deleteEmpresa(id) {
            if (confirm(`Tem certeza que deseja excluir a empresa "${empresasData.find(e => e.id == id)?.nome}"?`)) {
                empresasData = empresasData.filter(e => e.id != id);
                updateTableDisplay();
            }
        }

        // --- Event Listeners ---
        addEmpresaBtn.onclick = openModal;
        closeBtn.onclick = closeModal;
        cancelBtn.onclick = closeModal;
        searchEmpresaInput.oninput = updateTableDisplay;

        empresaForm.onsubmit = (event) => {
            event.preventDefault();
            const id = empresaIdInput.value;
            const newEmpresa = {
                id: id ? parseInt(id) : nextEmpresaId++,
                nome: nomeEmpresaInput.value,
                cnpj_matriz: cnpjMatrizInput.value,
                cnpj_filial: cnpjFilialInput.value,
                endereco: enderecoEmpresaInput.value,
                responsavel_nome: responsavelNomeInput.value,
                responsavel_telefone: responsavelTelefoneInput.value,
                responsavel_email: responsavelEmailInput.value,
            };

            if (id) {
                const index = empresasData.findIndex(e => e.id == id);
                if (index !== -1) {
                    empresasData[index] = newEmpresa;
                }
            } else {
                empresasData.push(newEmpresa);
            }
            updateTableDisplay();
            closeModal();
        };

        window.onclick = (event) => {
            if (event.target == empresaModal) {
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