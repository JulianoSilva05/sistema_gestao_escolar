<?php
// processa_curso.php

// Em um ambiente real, você faria:
// 1. Incluir conexão com o banco de dados
// 2. Receber os dados do formulário ($_POST)
// 3. Validar e sanitizar os dados
// 4. Executar a operação de banco de dados (INSERT, UPDATE, DELETE)
// 5. Redirecionar de volta para a tela de gestão de cursos com uma mensagem de sucesso/erro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? null;
    $codigo_curso = $_POST['codigo_curso'] ?? '';
    $nome_curso = $_POST['nome_curso'] ?? '';
    $classificacao = $_POST['classificacao'] ?? '';
    $modalidade = $_POST['modalidade'] ?? '';
    $carga_horaria = $_POST['carga_horaria'] ?? '';
    $tipo_curso = $_POST['tipo_curso'] ?? '';
    $categoria = $_POST['categoria'] ?? '';

    $message = "";

    switch ($action) {
        case 'add':
            // Lógica para adicionar curso ao BD
            $message = "Curso '$nome_curso' adicionado com sucesso (simulação).";
            break;
        case 'edit':
            // Lógica para atualizar curso no BD
            $message = "Curso '$nome_curso' (ID: $id) atualizado com sucesso (simulação).";
            break;
        case 'delete':
            // Lógica para deletar curso no BD
            $message = "Curso (ID: $id) excluído com sucesso (simulação).";
            break;
        default:
            $message = "Ação inválida.";
            break;
    }

    // Em um sistema real, você redirecionaria para a página principal da gestão de cursos
    // header("Location: gestao_cursos.html?msg=" . urlencode($message));
    // exit();

    // Por enquanto, apenas exibe a mensagem para teste
    echo $message;
    echo "<br><a href='gestao_cursos.html'>Voltar para Gestão de Cursos</a>";

} else {
    // Redireciona se o acesso não for via POST
    header("Location: gestao_cursos.html");
    exit();
}
?>