<?php
// index.php dentro da pasta /views/
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php"); // ou dashboard.php se usar sessão
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SENAI</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
    <script>
    // Validações avançadas de formulário
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("password");
        const errorDiv = document.createElement("p");
        errorDiv.className = "error-message";
        errorDiv.style.color = "#d9534f";
        errorDiv.style.marginTop = "10px";

        // Restrições configuráveis
        const minLen = 4;
        const maxLen = 50;
        const forbiddenChars = /[<>'"]/;

        form.addEventListener("submit", function(e) {
            let msg = "";

            // Usuário
            const user = usernameInput.value.trim();
            if (!user) {
                msg = "Preencha o campo usuário.";
            } else if (user.length < minLen) {
                msg = "Usuário deve ter no mínimo " + minLen + " caracteres.";
            } else if (user.length > maxLen) {
                msg = "Usuário deve ter no máximo " + maxLen + " caracteres.";
            } else if (forbiddenChars.test(user)) {
                msg = "Usuário contém caracteres inválidos.";
            }

            // Senha
            const pass = passwordInput.value;
            if (!msg) {
                if (!pass) {
                    msg = "Preencha o campo senha.";
                } else if (pass.length < minLen) {
                    msg = "Senha deve ter no mínimo " + minLen + " caracteres.";
                } else if (pass.length > maxLen) {
                    msg = "Senha deve ter no máximo " + maxLen + " caracteres.";
                } else if (forbiddenChars.test(pass)) {
                    msg = "Senha contém caracteres inválidos.";
                }
            }

            // Exibe erro e impede envio se inválido
            if (msg) {
                e.preventDefault();
                // Remove mensagem anterior, se houver
                const oldError = form.querySelector(".error-message");
                if (oldError) oldError.remove();
                errorDiv.textContent = msg;
                form.appendChild(errorDiv);
                // Foca no campo problemático
                if (msg.toLowerCase().includes("usuário")) {
                    usernameInput.focus();
                } else if (msg.toLowerCase().includes("senha")) {
                    passwordInput.focus();
                }
            }
        });

        // Limpa mensagem de erro ao digitar
        [usernameInput, passwordInput].forEach(function(input) {
            input.addEventListener("input", function() {
                const oldError = form.querySelector(".error-message");
                if (oldError) oldError.remove();
            });
        });
    });
    </script>
</head>
<body>
    <div class="login-container">
        <img src="../assets/logo_azul.png" alt="Logo" class="senai-logo">
        <form action="../backend/login.php" method="POST" autocomplete="off" novalidate>
            <div class="input-group">
                <label for="username">Usuário:</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    required 
                    minlength="4" 
                    maxlength="50"
                    pattern="^[^<>'\"]+$"
                    autocomplete="username"
                >
            </div>
            <div class="input-group">
                <label for="password">Senha:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    minlength="4" 
                    maxlength="50"
                    pattern="^[^<>'\"]+$"
                    autocomplete="current-password"
                >
            </div>
            <button type="submit">Entrar</button>
            <?php
            // Exibe a mensagem de erro se houver (backend)
            if (isset($_GET['erro'])) {
                echo '<p class="error-message">Usuário ou senha inválidos.</p>';
            }
            ?>
        </form>
    </div>
</body>
</html>
