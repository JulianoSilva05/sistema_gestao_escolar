<?php
// Exemplo simples de como consumir a rota FastAPI para alocação
// (Adapte para POST, se precisar filtros avançados)

$url = "http://localhost:8000/api/alocacao/gerar";
if (isset($_GET['turno'])) $url .= "?filtro_turno=" . urlencode($_GET['turno']);
if (isset($_GET['turma'])) $url .= (strpos($url, '?') ? '&' : '?') . "filtro_turma=" . urlencode($_GET['turma']);
if (isset($_GET['instrutor'])) $url .= (strpos($url, '?') ? '&' : '?') . "filtro_instrutor=" . urlencode($_GET['instrutor']);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;
