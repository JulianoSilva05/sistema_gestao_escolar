<?php
header('Content-Type: application/json');
$api_url = 'http://localhost:8000/api/instituicoes';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        break;
    default:
        http_response_code(405);
        echo json_encode(['error'=>'Método não suportado']);
}
