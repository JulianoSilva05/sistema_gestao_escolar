<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html"); // Se não estiver logado, redireciona para a página de login
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Instrutor SENAI</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .welcome-container {
            background-color: #e6ffe6; /* Verde claro para indicar sucesso */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }
        .welcome-container h2 {
            color: #28a745; /* Verde para sucesso */
            margin-bottom: 20px;
        }
        .welcome-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .logout-button {
            background-color: #dc3545; /* Vermelho para logout */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Você acessou o painel do Instrutor SENAI com sucesso.</p>
        <a href="logout.php" class="logout-button">Sair</a>
    </div>
</body>
</html>