<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$api_url = 'http://localhost:8000/api/calendarios';

function getRequestData() {
    return json_decode(file_get_contents('php://input'), true);
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === "OPTIONS") {
    http_response_code(200);
    exit;
}

if ($method === "POST" && $action === "evento") {
    // Adicionar evento para 1 ou mais calendários
    $data = getRequestData();
    $ch = curl_init($api_url . "/adicionar_evento");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}

if ($method === "PUT" && $action === "editar_dia_nao_letivo") {
    $id = $_GET['id'] ?? '';
    $data = getRequestData();
    $ch = curl_init($api_url . "/$id/editar_dia_nao_letivo");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}

if ($method === "DELETE" && $action === "remover_dia_nao_letivo") {
    $id = $_GET['id'] ?? '';
    $data = $_GET['data'] ?? '';
    $ch = curl_init($api_url . "/$id/remover_dia_nao_letivo?data=$data");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}

switch ($method) {
    case "GET":
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;

    case "POST":
        $data = getRequestData();
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;

    case "PUT":
        $id = $_GET['id'] ?? '';
        $data = getRequestData();
        $ch = curl_init($api_url . "/$id");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;

    case "DELETE":
        $id = $_GET['id'] ?? '';
        $ch = curl_init($api_url . "/$id");
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
