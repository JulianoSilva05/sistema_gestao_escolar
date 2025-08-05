<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Gestão de Alocação - SENAI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/style_turmas.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.2);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }

    .modal.show {
      display: flex !important;
    }

    .modal-content {
      display: flex;
      background: #fff;
      border-radius: 10px;
      min-width: 350px;
      max-width: 90vw;
      padding: 30px;
      box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
      position: relative;
    }

    .close-button {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.3);
      align-items: center;
      justify-content: center;
      z-index: 999;
    }

    .modal.show {
      display: flex !important;
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
          <li><a href="gestao_alocacao.php" class="active"><i class="fas fa-random"></i> Gestão de Alocações</a></li>
          <li><a href="gestao_cursos.php"><i class="fas fa-book"></i> Gestão de Cursos</a></li>
          <li><a href="gestao_turmas.php"><i class="fas fa-users"></i> Gestão de Turmas</a></li>
          <li><a href="gestao_instrutores.php"><i class="fas fa-chalkboard-teacher"></i> Gestão de Instrutores</a></li>
          <li><a href="gestao_salas.php"><i class="fas fa-door-open"></i> Gestão de Salas</a></li>
          <li><a href="gestao_empresas.php"><i class="fas fa-building"></i> Gestão de Empresas</a></li>
          <li><a href="gestao_unidades_curriculares.php"><i class="fas fa-graduation-cap"></i> Gestão de UCs</a></li>
          <li><a href="gestao_calendario.php"><i class="fas fa-calendar-alt"></i> Calendário</a></li>
          <li><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content">
      <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
      <header class="main-header flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Gestão de Alocações</h1>
        <button class="btn btn-primary flex items-center" id="btnOpenModal">
          <i class="fas fa-plus-circle mr-2"></i> Gerar Alocação
        </button>
      </header>

      <section class="table-section mt-6">
        <h2 class="text-xl mb-4">Alocações Geradas</h2>
        <div class="filter-section mb-4">
          <div class="filter-group">
            <label for="searchAlocacao" class="mr-2">Buscar:</label>
            <input type="text" id="searchAlocacao" placeholder="Digite para filtrar..."
              class="search-input border rounded px-2 py-1">
          </div>
        </div>
        <div class="table-responsive overflow-auto">
          <table class="data-table w-full table-auto border-collapse">
            <thead>
              <tr class="bg-gray-200">
                <th class="border px-4 py-2 text-left">ID</th>
                <th class="border px-4 py-2 text-left">Data de Geração</th>
                <th class="border px-4 py-2 text-left">Turmas</th>
                <th class="border px-4 py-2 text-left">Ações</th>
              </tr>
            </thead>
            <tbody id="alocacaoTableBody">
              <!-- Será preenchido via JS -->
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>

  <!-- Modal Gerar Alocação -->
  <div id="modalGerarAlocacao" class="modal">
    <div class="modal-content">
      <span class="close-button">&times;</span>
      <h2 class="text-xl mb-4">Gerar Alocação</h2>
      <form id="formGerarAlocacao">
        <div class="form-group">
          <label for="selectTurma" class="block mb-1">Turma(s)</label>
          <select id="selectTurma" name="turma[]" multiple style="width: 100%"></select>
        </div>
        <div class="form-group">
          <label for="selectTurno" class="block mb-1">Turno(s)</label>
          <select id="selectTurno" name="turno[]" multiple style="width: 100%" disabled></select>
        </div>
        <div class="form-group">
          <label for="selectInstrutor" class="block mb-1">Instrutor(es)</label>
          <select id="selectInstrutor" name="instrutor[]" multiple style="width: 100%" disabled></select>
        </div>
        <div class="flex justify-end space-x-2 mt-6">
          <button type="button" class="btn btn-secondary" id="cancelBtn">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Dependências JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
  </script>

  <script>
    $(function () {
      // inicializa Select2
      $('#selectTurma').select2({ placeholder: 'Selecione Turmas' });
      $('#selectTurno').select2({ placeholder: 'Selecione Turnos' }).prop('disabled', true);
      $('#selectInstrutor').select2({ placeholder: 'Selecione Instrutores' }).prop('disabled', true);

      let turmaData = {}, instrutorData = {};

      // busca turmas
      $.getJSON('/api/turma', data => {
        data.forEach(t => {
          let id = t._id.$oid || t._id;
          turmaData[id] = t;
        });
        let opts = data.map(t => ({ id: t._id.$oid || t._id, text: t.nome }));
        $('#selectTurma').empty().select2({ data: opts, placeholder: 'Selecione Turmas' });
      });

      // busca instrutores
      $.getJSON('/api/instrutor', data => {
        data.forEach(ins => {
          let id = ins._id.$oid || ins._id;
          instrutorData[id] = ins;
        });
      });

      // ao mudar Turma → popula Turnos
      $('#selectTurma').on('change', function () {
        let sel = $(this).val() || [], turnos = {};
        sel.forEach(id => {
          let t = turmaData[id];
          if (t.turnos.manha) turnos.manha = 'Manhã';
          if (t.turnos.tarde) turnos.tarde = 'Tarde';
          if (t.turnos.noite) turnos.noite = 'Noite';
        });
        let opts = Object.keys(turnos).map(k => ({ id: k, text: turnos[k] }));
        $('#selectTurno')
          .empty()
          .select2({ data: opts, placeholder: 'Selecione Turnos' })
          .prop('disabled', opts.length === 0);
        $('#selectInstrutor').empty().prop('disabled', true);
      });

      // ao mudar Turno → popula Instrutores
      $('#selectTurno').on('change', function () {
        let sel = $(this).val() || [], arr = [];
        sel.forEach(turno => {
          $.each(instrutorData, (id, ins) => {
            if (ins.turnos[turno]) arr.push({ id, text: ins.nome });
          });
        });
        // remove duplicatas
        let unique = arr.filter((v, i, a) => a.findIndex(t => t.id === v.id) === i);
        $('#selectInstrutor')
          .empty()
          .select2({ data: unique, placeholder: 'Selecione Instrutores' })
          .prop('disabled', unique.length === 0);
      });

      // abrir/fechar modal
      $('#btnOpenModal').click(() => $('#modalGerarAlocacao').addClass('show'));
      $('.close-button, #cancelBtn').click(() => $('#modalGerarAlocacao').removeClass('show'));

      // submit
      $('#formGerarAlocacao').on('submit', function (e) {
        e.preventDefault();
        // TODO: AJAX para processa_alocacao.php
        console.log($(this).serialize());
        $('#modalGerarAlocacao').removeClass('show');
      });
    });
  </script>
</body>

</html>