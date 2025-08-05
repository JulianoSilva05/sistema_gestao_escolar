<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Cursos - SENAI</title>
    <link rel="stylesheet" href="../css/style_turmas.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
                    <li><a href="gestao_cursos.php" class="active"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
                    <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
                    <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
                    <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
                    <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
                    <li><a href="gestao_calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
                    <li><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
            <header class="main-header">
                <h1>Gestão de Cursos</h1>
                <button class="btn btn-primary" id="btnAddCurso">
                    <i class="fas fa-plus-circle"></i> Adicionar Novo Curso
                </button>
            </header>
            <section class="table-section">
                <h2>Cursos Cadastrados</h2>
                <div class="filter-section">
                    <div class="filter-group">
                        <label for="searchCurso">Buscar Curso:</label>
                        <input type="text" id="searchCurso" placeholder="Digite para filtrar..." class="search-input">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table" id="cursosTable">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Eixo Tecnológico</th>
                                <th>Empresa/Parceiro</th>
                                <th>Modalidade</th>
                                <th>Carga Horária</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal: Detalhe do Curso -->
                <div class="modal" id="modalDetalheCurso">
                    <div class="modal-content" style="min-width:400px;max-width:90vw;">
                        <span class="modal-close" onclick="fecharModal('modalDetalheCurso')">&times;</span>
                        <h2>Detalhes do Curso</h2>
                        <div id="detalheCursoConteudo"></div>
                        <div style="text-align:right;margin-top:16px;">
                            <button id="btnEditarCurso" class="btn btn-primary">Editar</button>
                            <button id="btnExcluirCurso" class="btn btn-danger">Excluir Curso</button>
                        </div>
                    </div>
                </div>

                <!-- Modal: Adicionar/Editar Curso -->
                <div id="modalCurso" class="modal">
                    <div class="modal-content">
                        <span class="close-button" onclick="fecharModal('modalCurso')">×</span>
                        <h2 id="modalCursoTitulo">Adicionar Novo Curso</h2>
                        <form id="formCurso">
                            <input type="hidden" id="cursoId" name="id">
                            <div class="form-group">
                                <label for="instituicaoId">Instituição:</label>
                                <select id="instituicaoId" name="instituicao_id" required></select>
                            </div>
                            <div class="form-group">
                                <label for="nomeCurso">Nome:</label>
                                <input type="text" id="nomeCurso" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="nivelCurso">Modalidade:</label>
                                <select id="nivelCurso" name="nivel_curso" required>
                                    <option value="">Selecione</option>
                                    <option value="Técnico">Técnico</option>
                                    <option value="Aprendizagem">Aperfeiçoamento</option>
                                    <option value="Aprendizagem">Qualificação</option>
                                    <option value="Aprendizagem">Especialização</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tipoCurso">Tipo:</label>
                                <select id="tipoCurso" name="tipo" required>
                                    <option value="">Selecione</option>
                                    <option value="Presencial">Presencial</option>
                                    <option value="EAD">EAD</option>
                                    <option value="Aprendizagem">Semipresencial</option>
                                </select>
                            </div>
                            <!-- NOVOS CAMPOS -->
                            <div class="form-group">
                                <label for="categoriaCurso">Categoria:</label>
                                <input type="text" id="categoriaCurso" name="categoria" required>
                            </div>
                            <div class="form-group">
                                <label for="eixoTecnologicoCurso">Eixo Tecnológico:</label>
                                <input type="text" id="eixoTecnologicoCurso" name="eixo_tecnologico" required>
                            </div>
                            <!-- FIM NOVOS CAMPOS -->
                            <div class="form-group">
                                <label for="cargaHoraria">Carga Horária (h):</label>
                                <input type="number" id="cargaHoraria" name="carga_horaria" required min="1">
                            </div>
                            <div class="form-group">
                                <label for="convenioSelect">Empresa/Parceiro:</label>
                                <select id="convenioSelect" name="empresa" required>
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ucsSelect">Unidades Curriculares:</label>
                                <select class="form-select" id="ucsSelect" name="ucs[]" multiple style="width:100%;" required></select>
                            </div>
                            <div class="form-group">
                                <label for="observacao">Observação:</label>
                                <input type="text" id="observacao" name="observacao">
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar Curso</button>
                            <button type="button" class="btn btn-secondary" onclick="fecharModal('modalCurso')">Cancelar</button>
                        </form>
                    </div>
                </div>

                <!-- Modal: Configuração de UCs -->
                <div class="modal" id="modalUcsConfig" style="display:none;">
                    <div class="modal-content" style="min-width:420px;max-width:95vw;">
                        <span class="modal-close" onclick="fecharModal('modalUcsConfig')">&times;</span>
                        <h3>Configurar Dados das Unidades Curriculares</h3>
                        <div id="ucsAccordion"></div>
                        <div style="text-align:right;margin-top:18px;">
                            <button class="btn btn-primary" id="saveAllUcsBtn">Salvar</button>
                            <button class="btn btn-secondary" onclick="fecharModal('modalUcsConfig')">Cancelar</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        let empresasCache = [];
        let cursosCache = [], instituicoesCache = [], ucsCache = [], ucDataMap = {};
        let cursoEditando = null, modoEdicao = false;

        $(document).ready(function () {
            inicializarSelects();
            carregarCursos();

            $('#searchCurso').on('input', filtrarCursos);
            $('#btnAddCurso').click(() => {
                preencherSelectConvenios();
                abrirModalCurso();
            });
            $('#formCurso').on('submit', salvarCurso);
            $('#saveAllUcsBtn').on('click', salvarUcsConfig);

            // Delegates para botões
            $(document)
                .on('click', '.btn-view', function (e) {
                    e.stopPropagation();
                    mostrarDetalheCurso($(this).data('id'));
                })
                .on('click', '.btn-edit', function (e) {
                    e.stopPropagation();
                    abrirModalCurso(true, $(this).data('id'));
                })
                .on('click', '.btn-delete', function (e) {
                    e.stopPropagation();
                    excluirCurso($(this).data('id'));
                });

            $('#btnEditarCurso').on('click', function () {
                abrirModalCurso(true, $(this).data('id'));
            });
            $('#btnExcluirCurso').on('click', function () {
                excluirCurso($(this).data('id'));
            });
        });

        // --- FUNÇÕES DE FETCH ---
        async function fetchJson(url) {
            const resp = await fetch(url);
            return resp.ok ? await resp.json() : [];
        }
        async function carregarCursos() {
            [cursosCache, instituicoesCache, ucsCache, empresasCache] = await Promise.all([
                fetchJson('http://localhost:8000/api/cursos'),
                fetchJson('http://localhost:8000/api/instituicoes'),
                fetchJson('http://localhost:8000/api/unidades_curriculares'),
                fetchJson('http://localhost:8000/api/empresas')
            ]);
            ucsCache.forEach(uc => { ucDataMap[uc._id || uc.id] = uc.descricao; });
            renderCursosTable(cursosCache);
        }
        function inicializarSelects() {
            $('#ucsSelect, #convenioSelect').select2({ theme: 'bootstrap-5', width: '100%' });
        }
        function preencherSelectInstituicao(selectedId = "") {
            const select = $('#instituicaoId');
            select.empty().append('<option value="">Selecione</option>');
            instituicoesCache.forEach(inst => {
                select.append(`<option value="${inst._id || inst.id}" ${inst._id == selectedId ? 'selected' : ''}>${inst.razao_social || inst.nome}</option>`);
            });
        }
        function preencherSelectUCs(selectedUcs = []) {
            const select = $('#ucsSelect');
            select.empty();
            ucsCache.forEach(uc => {
                select.append(`<option value="${uc._id}">${uc.descricao}</option>`);
            });
            select.val(selectedUcs).trigger('change');
        }
        function preencherSelectConvenios(selected = []) {
            const select = $('#convenioSelect');
            select.empty();
            select.append('<option value="">Selecione</option>');
            empresasCache.forEach(emp => {
                select.append(`<option value="${emp._id}" ${Array.isArray(selected) && selected.includes(emp._id) ? 'selected' : ''}>${emp.razao_social}</option>`);
            });
            select.val(selected).trigger('change');
        }

        // --- RENDERIZAÇÃO DE TABELA ---
        function renderCursosTable(cursos) {
            const tbody = $('#cursosTable tbody');
            tbody.empty();
            cursos.forEach(curso => {
                let empresaNome = '';
                if (curso.empresa) {
                    if (Array.isArray(curso.empresa)) {
                        empresaNome = curso.empresa.map(empId => {
                            const emp = empresasCache.find(e => e._id == empId);
                            return emp ? emp.razao_social : empId;
                        }).join(', ');
                    } else {
                        const emp = empresasCache.find(e => e._id == curso.empresa);
                        empresaNome = emp ? emp.razao_social : curso.empresa;
                    }
                }
                tbody.append(`<tr>
                    <td>${curso.nome || ''}</td>
                    <td>${curso.tipo || ''}</td>
                    <td>${curso.categoria || ''}</td>
                    <td>${curso.eixo_tecnologico || ''}</td>
                    <td>${empresaNome}</td>
                    <td>${curso.nivel_curso || ''}</td>
                    <td>${curso.carga_horaria || ''}</td>
                    <td>
                        <div style="display: flex; gap: 4px;">
                            <button class="btn btn-icon btn-view" data-id="${curso._id}" title="Visualizar"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-icon btn-edit" data-id="${curso._id}" title="Editar"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-icon btn-delete" data-id="${curso._id}" title="Excluir"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>`);
            });
        }

        function filtrarCursos() {
            const termo = $('#searchCurso').val().toLowerCase();
            const filtrados = cursosCache.filter(curso =>
                Object.values(curso).some(val => String(val).toLowerCase().includes(termo))
            );
            renderCursosTable(filtrados);
        }

        // --- MODAIS ---
        function abrirModalCurso(edit = false, cursoId = null) {
            modoEdicao = edit;
            cursoEditando = edit ? cursosCache.find(c => c._id == cursoId) : null;
            preencherSelectInstituicao(edit ? cursoEditando?.instituicao_id : "");
            preencherSelectConvenios(edit ? cursoEditando?.empresa : "");
            preencherSelectUCs(edit && cursoEditando.ordem_ucs ? cursoEditando.ordem_ucs.map(u => u.id) : []);
            $('#nivelCurso').val(edit ? cursoEditando?.nivel_curso : "");
            $('#tipoCurso').val(edit ? cursoEditando?.tipo : "");
            $('#cargaHoraria').val(edit ? cursoEditando?.carga_horaria : "");
            $('#cursoId').val(edit ? cursoEditando?._id : "");
            $('#nomeCurso').val(edit ? cursoEditando?.nome : "");
            $('#categoriaCurso').val(edit ? cursoEditando?.categoria || "" : "");
            $('#eixoTecnologicoCurso').val(edit ? cursoEditando?.eixo_tecnologico || "" : "");
            $('#modalCursoTitulo').text(edit ? "Editar Curso" : "Adicionar Novo Curso");
            $('#modalCurso').addClass('show');
        }

        function fecharModal(modalId) {
            $('#' + modalId).removeClass('show');
            if (modalId === 'modalUcsConfig') {
                document.getElementById('modalUcsConfig').style.display = "none";
                document.getElementById('ucsAccordion').innerHTML = "";
            }
        }

        // --- VALIDAÇÃO DE DADOS ---
        function validarFormCurso() {
            const nome = $('#nomeCurso').val().trim();
            const modalidade = $('#nivelCurso').val();
            const tipo = $('#tipoCurso').val();
            const categoria = $('#categoriaCurso').val().trim();
            const eixo = $('#eixoTecnologicoCurso').val().trim();
            const cargaHoraria = parseInt($('#cargaHoraria').val(), 10);
            const empresa = $('#convenioSelect').val();
            const instituicao = $('#instituicaoId').val();

            if (!instituicao) {
                alert("Selecione a Instituição.");
                $('#instituicaoId').focus();
                return false;
            }
            if (!nome || nome.length < 3 || nome.length > 100) {
                alert("Nome do curso obrigatório (3-100 caracteres).");
                $('#nomeCurso').focus();
                return false;
            }
            if (!modalidade) {
                alert("Selecione a Modalidade.");
                $('#nivelCurso').focus();
                return false;
            }
            if (!tipo) {
                alert("Selecione o Tipo.");
                $('#tipoCurso').focus();
                return false;
            }
            if (!categoria) {
                alert("Categoria obrigatória.");
                $('#categoriaCurso').focus();
                return false;
            }
            if (!eixo) {
                alert("Eixo Tecnológico obrigatório.");
                $('#eixoTecnologicoCurso').focus();
                return false;
            }
            if (!empresa) {
                alert("Selecione a Empresa/Parceiro.");
                $('#convenioSelect').focus();
                return false;
            }
            if (!cargaHoraria || isNaN(cargaHoraria) || cargaHoraria <= 0) {
                alert("Informe a Carga Horária corretamente.");
                $('#cargaHoraria').focus();
                return false;
            }
            return true;
        }

        // --- CRUD: SALVAR CURSO ---
        function salvarCurso(e) {
            e.preventDefault();
            if (!validarFormCurso()) return;
            const selectedUcs = $('#ucsSelect').val();
            if (!selectedUcs.length) {
                alert('Selecione ao menos uma Unidade Curricular.');
                return;
            }
            const cursoData = {
                nome: $('#nomeCurso').val(),
                tipo: $('#tipoCurso').val(),
                nivel_curso: $('#nivelCurso').val(),
                categoria: $('#categoriaCurso').val(),
                eixo_tecnologico: $('#eixoTecnologicoCurso').val(),
                carga_horaria: parseInt($('#cargaHoraria').val(), 10),
                empresa: $('#convenioSelect').val(),
                instituicao_id: $('#instituicaoId').val(),
                ordem_ucs: selectedUcs.map(id => ({ id, descricao: ucDataMap[id] }))
            };
            if ($('#cursoId').val()) cursoData._id = $('#cursoId').val();
            window._cursoDataToSave = cursoData;
            fecharModal('modalCurso');
            abrirModalUcsConfig(selectedUcs, cursoEditando ? cursoEditando.ordem_ucs : []);
        }

        // --- MODAL CONFIG UCs ---
        function abrirModalUcsConfig(ucsIds, dadosExistentes = []) {
            let html = '<div class="accordion" id="accordionUcModal">';
            ucsIds.forEach((id, idx) => {
                const ucDesc = ucDataMap[id] || id;
                const detalhes = dadosExistentes.find(u => String(u.id) === String(id)) || {};
                html += `
        <div class="accordion-item border border-gray-300 rounded mb-2" style="background:#f9f9f9">
            <div class="accordion-header" id="heading${id}">
                <button class="accordion-button flex justify-between items-center w-full py-3 px-4 text-left font-medium"
                    type="button" onclick="toggleAccordion('${id}')"
                    style="background: none; border: none; width:100%; outline:none;">
                    <span>${ucDesc}</span>
                    <i class="fas fa-chevron-down ml-2"></i>
                </button>
            </div>
            <div id="collapse${id}" class="accordion-collapse" data-ucid="${id}" style="display:${idx === 0 ? 'block' : 'none'};">
                <div class="accordion-body px-4 py-3">
                    <form class="uc-form-config" data-ucid="${id}">
                        <div class="form-group">
                            <label>ID da UC:</label>
                            <input type="text" value="${id}" readonly disabled class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Nome da UC:</label>
                            <input type="text" value="${ucDesc}" readonly disabled class="form-control"/>
                        </div>
                                <div class="form-group">
                                    <label>Carga Horária de Aulas Presenciais:</label>
                                    <input type="number" min="0" class="form-control presencial_ch" name="presencial_ch" required value="${detalhes.presencial?.carga_horaria || 0}"/>
                                </div>
                                <div class="form-group">
                                    <label>Quantidade de Aulas Total (Presencial):</label>
                                    <input type="number" min="0" class="form-control presencial_aulas" name="presencial_aulas" required value="${detalhes.presencial?.quantidade_aulas_45min || 0}"/>
                                </div>
                                <div class="form-group">
                                    <label>Quantidade Total de Dias (Presencial):</label>
                                    <input type="number" min="0" class="form-control presencial_dias" name="presencial_dias" required value="${detalhes.presencial?.dias_letivos || 0}"/>
                                </div>
                                <div class="form-group">
                                    <label>Carga Horária de Aulas EAD:</label>
                                    <input type="number" min="0" class="form-control ead_ch" name="ead_ch" required value="${detalhes.ead?.carga_horaria || 0}"/>
                                </div>
                                <div class="form-group">
                                    <label>Quantidade de Aulas Total (EAD):</label>
                                    <input type="number" min="0" class="form-control ead_aulas" name="ead_aulas" required value="${detalhes.ead?.quantidade_aulas_45min || 0}"/>
                                </div>
                                <div class="form-group">
                                    <label>Quantidade Total de Dias (EAD):</label>
                                    <input type="number" min="0" class="form-control ead_dias" name="ead_dias" required value="${detalhes.ead?.dias_letivos || 0}"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>`;
            });
            html += '</div>';
            document.getElementById('ucsAccordion').innerHTML = html;
            document.getElementById('modalUcsConfig').classList.add('show');
            document.getElementById('modalUcsConfig').style.display = "flex";
        }

        function toggleAccordion(id) {
            document.querySelectorAll('.accordion-collapse').forEach(el => {
                el.style.display = (el.id === 'collapse' + id) ?
                    (el.style.display === 'block' ? 'none' : 'block') :
                    'none';
            });
        }

        // --- SALVAR DETALHES DAS UCs E CURSO FINAL ---
        function salvarUcsConfig() {
            let allForms = document.querySelectorAll('.uc-form-config');
            let ucsToSave = [], erro = false;
            allForms.forEach(form => {
                let id = form.getAttribute('data-ucid');
                let presencial_ch = form.querySelector('.presencial_ch').value;
                let presencial_aulas = form.querySelector('.presencial_aulas').value;
                let presencial_dias = form.querySelector('.presencial_dias').value;
                let ead_ch = form.querySelector('.ead_ch').value;
                let ead_aulas = form.querySelector('.ead_aulas').value;
                let ead_dias = form.querySelector('.ead_dias').value;
                if (
                    presencial_ch === "" || presencial_aulas === "" ||
                    presencial_dias === "" || ead_ch === "" || ead_aulas === "" || ead_dias === ""
                ) erro = true;
                let values = {
                    id: id,
                    unidade_curricular: form.querySelectorAll('input[readonly]')[1].value,
                    presencial: {
                        carga_horaria: parseInt(presencial_ch, 10),
                        quantidade_aulas_45min: parseInt(presencial_aulas, 10),
                        dias_letivos: parseInt(presencial_dias, 10)
                    },
                    ead: {
                        carga_horaria: parseInt(ead_ch, 10),
                        quantidade_aulas_45min: parseInt(ead_aulas, 10),
                        dias_letivos: parseInt(ead_dias, 10)
                    }
                };
                ucsToSave.push(values);
            });
            if (erro) {
                alert('Preencha todos os campos obrigatórios de todas as UCs!');
                return;
            }
            let dataFinal = Object.assign({}, window._cursoDataToSave, { ordem_ucs: ucsToSave });

            let url = 'http://localhost:8000/api/cursos';
            let method = (modoEdicao && cursoEditando && cursoEditando._id) ? 'PUT' : 'POST';
            if (modoEdicao && cursoEditando && cursoEditando._id) url += '/' + cursoEditando._id;

            fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dataFinal)
            }).then(resp => {
                if (resp.ok) {
                    alert(modoEdicao ? 'Curso atualizado com sucesso!' : 'Curso cadastrado com sucesso!');
                    fecharModal('modalUcsConfig');
                    carregarCursos();
                } else {
                    resp.text().then(txt => alert('Erro ao salvar curso: ' + txt));
                }
            }).catch(() => {
                alert('Erro ao conectar com o servidor.');
            });
        }

        // --- VISUALIZAR CURSO: APENAS LEITURA ---
        function mostrarDetalheCurso(cursoId) {
            const curso = cursosCache.find(c => c._id == cursoId);
            const nomeInstituicao = instituicoesCache.find(i => i._id == curso.instituicao_id)?.razao_social || curso.instituicao_id;
            let empresaNome = '';
            if (curso.empresa) {
                if (Array.isArray(curso.empresa)) {
                    empresaNome = curso.empresa.map(empId => {
                        const emp = empresasCache.find(e => e._id == empId);
                        return emp ? emp.razao_social : empId;
                    }).join(', ');
                } else {
                    const emp = empresasCache.find(e => e._id == curso.empresa);
                    empresaNome = emp ? emp.razao_social : curso.empresa;
                }
            }
            let html = `
            <div class="popup-field"><span class="popup-label">ID:</span> ${curso._id}</div>
            <div class="popup-field"><span class="popup-label">Nome:</span> ${curso.nome || ''}</div>
            <div class="popup-field"><span class="popup-label">Tipo:</span> ${curso.tipo || ''}</div>
            <div class="popup-field"><span class="popup-label">Modalidade:</span> ${curso.nivel_curso || ''}</div>
            <div class="popup-field"><span class="popup-label">Categoria:</span> ${curso.categoria || ''}</div>
            <div class="popup-field"><span class="popup-label">Eixo Tecnológico:</span> ${curso.eixo_tecnologico || ''}</div>
            <div class="popup-field"><span class="popup-label">Carga Horária:</span> ${curso.carga_horaria || ''}</div>
            <div class="popup-field"><span class="popup-label">Empresa/Parceiro:</span> ${empresaNome}</div>
            <div class="popup-field"><span class="popup-label">Instituição:</span> ${nomeInstituicao}</div>
            <div class="popup-field"><span class="popup-label">Unidades Curriculares do Curso:</span></div>
            <div style="max-height:350px;overflow:auto;">${renderUCTable(curso.ordem_ucs)}</div>
            `;
            document.getElementById('detalheCursoConteudo').innerHTML = html;
            $('#modalDetalheCurso').addClass('show');
            $('#btnEditarCurso').data('id', cursoId);
            $('#btnExcluirCurso').data('id', cursoId);
        }

        // --- EXCLUIR CURSO ---
        function excluirCurso(cursoId) {
            if (!confirm("Tem certeza que deseja excluir este curso?")) return;
            fetch('http://localhost:8000/api/cursos/' + cursoId, { method: 'DELETE' })
                .then(resp => {
                    if (resp.ok) {
                        alert('Curso excluído com sucesso!');
                        fecharModal('modalDetalheCurso');
                        carregarCursos();
                    } else {
                        resp.text().then(txt => alert('Erro ao excluir curso: ' + txt));
                    }
                });
        }

        // --- RENDERIZAÇÃO DE UNIDADES CURRICULARES NA VISUALIZAÇÃO ---
        function renderUCTable(ucs = []) {
            if (!Array.isArray(ucs) || ucs.length === 0) return "-";
            let html = `<table class="uc-table">
<thead>
    <tr>
        <th>#</th>
        <th>UC</th>
        <th>Presencial (CH/Aulas/Dias)</th>
        <th>EAD (CH/Aulas/Dias)</th>
    </tr>
</thead>
<tbody>`;
            ucs.forEach((uc, idx) => {
                html += `<tr>
<td>${idx + 1}</td>
<td>${uc.unidade_curricular || '-'}</td>
<td>
    ${uc.presencial ? `
    CH: ${uc.presencial.carga_horaria || '-'}<br>
    Aulas: ${uc.presencial.quantidade_aulas_45min || '-'}<br>
    Dias: ${uc.presencial.dias_letivos || '-'}` : '-'}
</td>
<td>
    ${uc.ead ? `
    CH: ${uc.ead.carga_horaria || '-'}<br>
    Aulas: ${uc.ead.quantidade_aulas_45min || '-'}<br>
    Dias: ${uc.ead.dias_letivos || '-'}` : '-'}
</td>
</tr>`;
            });
            html += `</tbody></table>`;
            return html;
        }
    </script>
</body>

</html>
