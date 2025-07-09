<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SENAI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <img src="logo_azul.png" alt="Logo SENAI" class="senai-logo">
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
            <?php
            // Exibe a mensagem de erro se houver
            if (isset($_GET['erro'])) {
                echo '<p class="error-message">Usuário ou senha inválidos.</p>';
            }
            ?>
        </form>
    </div>
</body>
</html>