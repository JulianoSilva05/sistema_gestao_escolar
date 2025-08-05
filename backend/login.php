<?php
session_start();

// Limite tentativas (opcional)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}
$lock_minutes = 5;
$max_attempts = 5;

if ($_SESSION['login_attempts'] >= $max_attempts) {
    $time_since_last = time() - $_SESSION['last_attempt_time'];
    if ($time_since_last < $lock_minutes * 60) {
        header("Location: ../views/index.php?erro=1");
        exit();
    } else {
        $_SESSION['login_attempts'] = 0;
    }
}

// Checa campos recebidos
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: ../views/index.php?erro=1");
    exit();
}

$user = trim($_POST['username']);
$pass = trim($_POST['password']);

// Sanitiza (proteção básica)
$user = htmlentities($user, ENT_QUOTES, 'UTF-8');

if (strlen($user) < 4 || strlen($user) > 50 || strlen($pass) < 4 || strlen($pass) > 50) {
    header("Location: ../views/index.php?erro=1");
    exit();
}

// Faz requisição para API FastAPI
$api_url = "http://localhost:8000/api/login";
$dados = array("user_name" => $user, "senha" => $pass);

$options = array(
    "http" => array(
        "header"  => "Content-type: application/json\r\n",
        "method"  => "POST",
        "content" => json_encode($dados),
        "ignore_errors" => true // permite capturar resposta 401, etc.
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($api_url, false, $context);
$http_code = null;

// Captura código HTTP (disponível no $http_response_header)
if (isset($http_response_header)) {
    foreach ($http_response_header as $header) {
        if (preg_match('#HTTP/\d+\.\d+ (\d+)#', $header, $matches)) {
            $http_code = intval($matches[1]);
            break;
        }
    }
}

// Se login falhou
if ($http_code !== 200 || $result === false) {
    $_SESSION['login_attempts'] += 1;
    $_SESSION['last_attempt_time'] = time();
    header("Location: ../views/index.php?erro=1");
    exit();
}

// Login OK: salva dados na sessão PHP
$_SESSION['login_attempts'] = 0;
$_SESSION['loggedin'] = true;
$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + (30 * 60); // 30 min

// Decodifica resposta da API para pegar info do usuário (opcional)
$user_data = json_decode($result, true);
if (isset($user_data['id'])) {
    $_SESSION['user_id'] = $user_data['id'];
    $_SESSION['nome'] = $user_data['nome'];
    $_SESSION['tipo_acesso'] = $user_data['tipo_acesso'];
    $_SESSION['user_name'] = $user_data['user_name'];
    $_SESSION['instituicao_id'] = $user_data['instituicao_id'];
}

header("Location: ../views/dashboard.php");
exit();
?>
