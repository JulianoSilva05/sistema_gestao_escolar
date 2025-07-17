<?php
header('Content-Type: application/json');

$unidades_curriculares = [
    ['id' => 101, 'nome' => 'Lógica de Programação', 'carga_horaria' => 80],
    ['id' => 102, 'nome' => 'Banco de Dados I', 'carga_horaria' => 60],
    ['id' => 103, 'nome' => 'Desenvolvimento Web Frontend', 'carga_horaria' => 120],
    ['id' => 104, 'nome' => 'Engenharia de Software', 'carga_horaria' => 90],
    ['id' => 105, 'nome' => 'Redes de Computadores', 'carga_horaria' => 70],
    ['id' => 106, 'nome' => 'Sistemas Operacionais', 'carga_horaria' => 50],
    ['id' => 107, 'nome' => 'Cálculo I', 'carga_horaria' => 100],
    ['id' => 108, 'nome' => 'Física Aplicada', 'carga_horaria' => 80],
    ['id' => 109, 'nome' => 'Química Industrial', 'carga_horaria' => 75],
    ['id' => 110, 'nome' => 'Desenho Técnico', 'carga_horaria' => 60],
    ['id' => 111, 'nome' => 'Gestão de Projetos', 'carga_horaria' => 90],
    ['id' => 112, 'nome' => 'Marketing Digital', 'carga_horaria' => 70],
    ['id' => 113, 'nome' => 'Contabilidade Básica', 'carga_horaria' => 50],
    ['id' => 114, 'nome' => 'Segurança do Trabalho', 'carga_horaria' => 40],
    ['id' => 115, 'nome' => 'Eletricidade Básica', 'carga_horaria' => 60],
    ['id' => 116, 'nome' => 'Mecânica dos Materiais', 'carga_horaria' => 80],
    ['id' => 117, 'nome' => 'Robótica Industrial', 'carga_horaria' => 110],
    ['id' => 118, 'nome' => 'Automação Industrial', 'carga_horaria' => 100],
    ['id' => 119, 'nome' => 'Inteligência Artificial', 'carga_horaria' => 130],
    ['id' => 120, 'nome' => 'Ciência de Dados', 'carga_horaria' => 120],
];

echo json_encode($unidades_curriculares);
?>