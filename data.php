<?php
header('Content-Type: application/json'); // Define o cabeçalho como JSON

$chart_type = isset($_GET['chart']) ? $_GET['chart'] : '';

$data = [];

switch ($chart_type) {
    case 'instrutores_area':
        $data = [
            ['area' => 'TI', 'quantidade' => 15],
            ['area' => 'Gestão', 'quantidade' => 10],
            ['area' => 'Elétrica', 'quantidade' => 8],
            ['area' => 'Mecânica', 'quantidade' => 12],
            ['area' => 'Outras', 'quantidade' => 5]
        ];
        break;
    case 'alocacao_instrutor':
        $data = [
            ['instrutor' => 'Ana Silva', 'porcentagem' => 80],
            ['instrutor' => 'João Costa', 'porcentagem' => 75],
            ['instrutor' => 'Maria Santos', 'porcentagem' => 90],
            ['instrutor' => 'Pedro Almeida', 'porcentagem' => 60],
            ['instrutor' => 'Outros', 'porcentagem' => 100 - (80+75+90+60)/4]
        ];
        $total_porcentagem = array_sum(array_column($data, 'porcentagem'));
        foreach ($data as &$item) {
            $item['porcentagem'] = round(($item['porcentagem'] / $total_porcentagem) * 100);
        }
        break;
    case 'cursos_finalizados':
        // Esta é a parte corrigida: Dados para exibir a proporção de cursos por status
        $data = [
            ['status' => 'Finalizados', 'quantidade' => 60], // 60 cursos finalizados
            ['status' => 'Em Andamento', 'quantidade' => 35], // 35 cursos em andamento
            ['status' => 'Não Iniciados', 'quantidade' => 5]   // 5 cursos não iniciados
        ];
        break;
    case 'instrutores_janela':
        $data = [
            ['turno' => 'Manhã', 'quantidade' => 3],
            ['turno' => 'Tarde', 'quantidade' => 2],
            ['turno' => 'Noite', 'quantidade' => 1]
        ];
        break;
    default:
        $data = ['message' => 'Nenhum gráfico especificado ou gráfico inválido.'];
        break;
}

echo json_encode($data);
?>