<?php
session_start(); // Inicia a sessão para armazenar informações de login

// Define as credenciais corretas
$usuario_correto = "instrutor";
$senha_correta = "12345"; // Em um sistema real, use password_hash() para senhas!

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica as credenciais
    if ($username === $usuario_correto && $password === $senha_correta) {
        // Credenciais corretas, cria a sessão e redireciona para o painel
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.html"); // Redireciona para a página do painel
        exit(); // Garante que o script pare de executar
    } else {
        // Credenciais inválidas, redireciona de volta para a tela de login com uma mensagem de erro
        header("Location: index.php?erro=1");
        exit();
    }
} else {
    // Se a requisição não for POST (acesso direto ao login.php), redireciona para o index
    header("Location: index.php");
    exit();
}
?>