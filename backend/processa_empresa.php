<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// URL base da API FastAPI
$api_url_empresas     = 'http://localhost:8000/api/empresas';
$api_url_instituicoes = 'http://localhost:8000/api/instituicoes';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

function getRequestData() {
    return json_decode(file_get_contents('php://input'), true);
}

if ($method === "OPTIONS") {
    http_response_code(200);
    exit;
}

// Listar instituições (usado no select do modal)
if ($method === "GET" && $action === "instituicoes") {
    $ch = curl_init($api_url_instituicoes);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}

switch ($method) {
    case "GET":
        // Listar empresas
        $ch = curl_init($api_url_empresas);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;

    case "POST":
        // Criar nova empresa
        $data = getRequestData();
        $ch = curl_init($api_url_empresas);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;

    case "PUT":
        // Editar empresa
        $id = $_GET['id'] ?? '';
        if (!$id) { http_response_code(400); echo json_encode(['error'=>'ID não informado']); exit; }
        $data = getRequestData();
        $ch = curl_init($api_url_empresas . "/$id");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;

    case "DELETE":
        // Excluir empresa
        $id = $_GET['id'] ?? '';
        if (!$id) { http_response_code(400); echo json_encode(['error'=>'ID não informado']); exit; }
        $ch = curl_init($api_url_empresas . "/$id");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não suportado"]);
}
