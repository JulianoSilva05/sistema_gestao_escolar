<?php
session_start();

// Roda somente quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepara os dados para a API (FastAPI)
    $payload = json_encode([
        'user_name' => $username,
        'senha' => $password
    ]);

    // Envia requisição para a API Python (ajuste porta se necessário)
    $ch = curl_init('http://localhost:8000/api/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Decodifica a resposta da API
    $result = json_decode($response, true);

    if ($httpCode === 200 && isset($result['user_name'])) {
        // Login OK
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $result['user_name'];
        $_SESSION['tipo_acesso'] = $result['tipo_acesso'];
        $_SESSION['nome'] = $result['nome'];
        $_SESSION['instituicao_id'] = $result['instituicao_id'];
        header("Location: dashboard.html");
        exit();
    } else {
        // Login inválido
        header("Location: index.php?erro=1");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
