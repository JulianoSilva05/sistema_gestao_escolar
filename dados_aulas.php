<?php

header('Content-Type: application/json');

// Simulação de dados de turmas (em um ambiente real, viriam de um banco de dados)
$turmas = [
    [
        'id' => 1,
        'codigo_turma' => 'APOSEM157N',
        'data_inicio' => '2025-05-12',
        'data_termino' => '2025-05-23',
        'turno' => 'NOITE',
        'num_alunos' => 12,
        'curso' => 'Aperfeiçoamento em Operação Segura de Empilhadeira'
    ],
    [
        'id' => 2,
        'codigo_turma' => 'APLUBRIN1IN',
        'data_inicio' => '2025-05-07',
        'data_termino' => '2025-05-09',
        'turno' => 'INTEGRAL',
        'num_alunos' => 7,
        'curso' => 'Aperfeiçoamento em Lubrificação Industrial'
    ],
    [
        'id' => 3,
        'codigo_turma' => 'APOSEM156N',
        'data_inicio' => '2025-04-07',
        'data_termino' => '2025-04-22',
        'turno' => 'NOITE',
        'num_alunos' => 12,
        'curso' => 'Empilhadeira'
    ],
    [
        'id' => 4,
        'codigo_turma' => 'AI-GEI-07-M-25-12800',
        'data_inicio' => '2025-04-14',
        'data_termino' => '',
        'turno' => 'MANHA',
        'num_alunos' => 32,
        'curso' => 'Aprendizagem Industrial em Gestão Industrial'
    ],
    [
        'id' => 5,
        'codigo_turma' => 'AI-GEI-08-T-25-12800',
        'data_inicio' => '',
        'data_termino' => '',
        'turno' => 'TARDE',
        'num_alunos' => 31,
        'curso' => 'Aprendizagem Industrial em Gestão Industrial'
    ],
    [
        'id' => 6,
        'codigo_turma' => 'AI-ETR-03-M-25-12800',
        'data_inicio' => '2025-05-05',
        'data_termino' => '',
        'turno' => 'MANHA',
        'num_alunos' => '',
        'curso' => 'Aprendizagem Industrial Eletricista Industrial'
    ],
    [
        'id' => 7,
        'codigo_turma' => 'AI-ETR-02-T-25-12800',
        'data_inicio' => '2025-05-05',
        'data_termino' => '',
        'turno' => 'TARDE',
        'num_alunos' => '',
        'curso' => 'Aprendizagem Industrial Eletricista Industrial'
    ],
    [
        'id' => 8,
        'codigo_turma' => 'AI-MMA-01-M-23-12800_',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-26',
        'turno' => 'MANHA',
        'num_alunos' => 16,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE AUTOMÓVEIS'
    ],
    [
        'id' => 9,
        'codigo_turma' => 'AI-MMA-02-M-23-12800',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-15',
        'turno' => 'MANHA',
        'num_alunos' => 21,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE AUTOMÓVEIS'
    ],
    [
        'id' => 10,
        'codigo_turma' => 'AI-ADM-03-M-23-12800_',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-26',
        'turno' => 'MANHA',
        'num_alunos' => 17,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM PROCESSOS ADMINISTRATIVOS'
    ],
    [
        'id' => 11,
        'codigo_turma' => 'AI-ADM-04-M-23-12800_',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-15',
        'turno' => 'MANHA',
        'num_alunos' => 21,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM PROCESSOS ADMINISTRATIVOS'
    ],
    [
        'id' => 12,
        'codigo_turma' => 'AI-QUA-02-M-23-12800_',
        'data_inicio' => '2023-09-22',
        'data_termino' => '2025-08-26',
        'turno' => 'MANHA',
        'num_alunos' => 18,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM CONTROLE DE QUALIDADE'
    ],
    [
        'id' => 13,
        'codigo_turma' => 'AI-QUA-03-M-23-12800_',
        'data_inicio' => '2023-09-22',
        'data_termino' => '2025-09-21',
        'turno' => 'MANHA',
        'num_alunos' => 10,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM CONTROLE DE QUALIDADE'
    ],
    [
        'id' => 14,
        'codigo_turma' => 'HT-SIS-01-M-24-12800_',
        'data_inicio' => '2024-03-11',
        'data_termino' => '2025-07-29',
        'turno' => 'MANHA',
        'num_alunos' => 32,
        'curso' => 'TÉCNICO EM DESENVOLVIMENTO DE SISTEMAS'
    ],
    [
        'id' => 15,
        'codigo_turma' => 'HT-IPI-01-M-24-12800_',
        'data_inicio' => '2024-03-11',
        'data_termino' => '2025-07-29',
        'turno' => 'MANHA',
        'num_alunos' => 33,
        'curso' => 'TÉCNICO EM INFORMÁTICA PARA INTERNET'
    ],
    [
        'id' => 16,
        'codigo_turma' => 'AI-MMM-01-24-M-12800',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-15',
        'turno' => 'MANHA',
        'num_alunos' => 20,
        'curso' => 'APRENDIZAGEM MANUTENÇÃO MECÂNICA DE MÁQUINAS INDUSTRIAIS'
    ],
    [
        'id' => 17,
        'codigo_turma' => 'AI-MMA-03-T-23-12800_',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-26',
        'turno' => 'TARDE',
        'num_alunos' => 14,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE AUTOMÓVEIS'
    ],
    [
        'id' => 18,
        'codigo_turma' => 'AI-AUT-01-T-23-12800_',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-15',
        'turno' => 'TARDE',
        'num_alunos' => '',
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM ELETRICIDADE DE AUTOMÓVEIS'
    ],
    [
        'id' => 19,
        'codigo_turma' => 'AI-AUT-02-T-23-12800_',
        'data_inicio' => '2023-03-09',
        'data_termino' => '2025-10-08',
        'turno' => 'TARDE',
        'num_alunos' => 15,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM ELETRICIDADE DE AUTOMÓVEIS'
    ],
    [
        'id' => 20,
        'codigo_turma' => 'AI-AUT-03-T-23-12800_',
        'data_inicio' => '2023-10-09',
        'data_termino' => '2025-10-08',
        'turno' => 'TARDE',
        'num_alunos' => 8,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM ELETRICIDADE DE AUTOMÓVEIS'
    ],
    [
        'id' => 21,
        'codigo_turma' => 'AI-MMM-07-T-23-12800_',
        'data_inicio' => '2023-07-01',
        'data_termino' => '2025-07-31',
        'turno' => 'TARDE',
        'num_alunos' => 14,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE MÁQUINAS INDUSTRIAIS'
    ],
    [
        'id' => 22,
        'codigo_turma' => 'AI-MMM-08-T-23-12800_',
        'data_inicio' => '2023-10-09',
        'data_termino' => '2025-10-08',
        'turno' => 'TARDE',
        'num_alunos' => 17,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE MÁQUINAS INDUSTRIAIS'
    ],
    [
        'id' => 23,
        'codigo_turma' => 'AI-MFC-02-T-23-12800_',
        'data_inicio' => '2023-07-17',
        'data_termino' => '2025-07-28',
        'turno' => 'TARDE',
        'num_alunos' => 13,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM OPERAÇÃO DE MÁQUINAS FERRAMENTAS CONVENCIONAIS'
    ],
    [
        'id' => 24,
        'codigo_turma' => 'AI-ETR-02-T-24-12800_',
        'data_inicio' => '2024-02-19',
        'data_termino' => '2024-12-20',
        'turno' => 'TARDE',
        'num_alunos' => 21,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM ELETRICISTA INDUSTRIAL'
    ],
    [
        'id' => 25,
        'codigo_turma' => 'AI-MEL-01-T-24-12800_',
        'data_inicio' => '2024-04-16',
        'data_termino' => '2025-05-06',
        'turno' => 'TARDE',
        'num_alunos' => 16,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO ELETROMECÂNICA'
    ],
    [
        'id' => 26,
        'codigo_turma' => 'AI-GEI-06-T-24-12800_',
        'data_inicio' => '2024-08-12',
        'data_termino' => '2025-12-17',
        'turno' => 'TARDE',
        'num_alunos' => 30,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM GESTÃO INDUSTRIAL'
    ],
    [
        'id' => 27,
        'codigo_turma' => 'HT-MEC-02-T-24-12800_',
        'data_inicio' => '2024-03-04',
        'data_termino' => '2025-08-08',
        'turno' => 'TARDE',
        'num_alunos' => 36,
        'curso' => 'TÉCNICO EM MECÂNICA'
    ],
    [
        'id' => 28,
        'codigo_turma' => 'HT-ELM-01-T-24-12800_',
        'data_inicio' => '2024-03-11',
        'data_termino' => '2025-07-29',
        'turno' => 'TARDE',
        'num_alunos' => 35,
        'curso' => 'TÉCNICO EM ELETROMECÂNICA'
    ],
    [
        'id' => 29,
        'codigo_turma' => 'AI-MEL-01-T-25-12800',
        'data_inicio' => '2025-01-02',
        'data_termino' => '2025-12-19',
        'turno' => 'TARDE',
        'num_alunos' => 25,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO ELETROMECÂNICA'
    ],
    [
        'id' => 30,
        'codigo_turma' => 'AI-MMM-01-M-25-12800',
        'data_inicio' => '2025-01-02',
        'data_termino' => '',
        'turno' => 'MANHA',
        'num_alunos' => 26,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE MÁQUINAS INDUSTRIAIS'
    ],
    [
        'id' => 31,
        'codigo_turma' => 'AI-MEL-03-T-24-12800',
        'data_inicio' => '2024-09-09',
        'data_termino' => '2025-09-26',
        'turno' => 'TARDE',
        'num_alunos' => 29,
        'curso' => 'Aprendizagem Industrial em Manutenção Eletromecânica'
    ],
    [
        'id' => 32,
        'codigo_turma' => 'HT-SDT-01-N-24-12800_',
        'data_inicio' => '2024-03-11',
        'data_termino' => '2025-07-29',
        'turno' => 'NOITE',
        'num_alunos' => 32,
        'curso' => 'TÉCNICO EM SEGURANÇA DO TRABALHO'
    ],
    [
        'id' => 33,
        'codigo_turma' => 'HT-ETT-04-I-23-12800_',
        'data_inicio' => '2023-09-25',
        'data_termino' => '2025-02-14',
        'turno' => 'TARDE/NOITE',
        'num_alunos' => 13,
        'curso' => 'TÉCNICO EM ELETROTÉCNICA'
    ],
    [
        'id' => 34,
        'codigo_turma' => 'HT-MEC-05-I-23-12800_',
        'data_inicio' => '2025-01-20',
        'data_termino' => '2025-01-22',
        'turno' => 'TARDE/NOITE',
        'num_alunos' => 19,
        'curso' => 'TÉCNICO EM MECÂNICA'
    ],
    [
        'id' => 35,
        'codigo_turma' => 'HT-AUT-01-N-24-12800_',
        'data_inicio' => '2024-03-11',
        'data_termino' => '2025-07-29',
        'turno' => 'NOITE',
        'num_alunos' => 35,
        'curso' => 'TÉCNICO EM AUTOMAÇÃO INDUSTRIAL'
    ]
];

// Mapeamento de cursos para área e unidade curricular (UC)
$mapeamento_curso = [
    'Aperfeiçoamento em Operação Segura de Empilhadeira' => ['area' => 'Mecânica', 'uc' => 'Operação de Empilhadeira'],
    'Aperfeiçoamento em Lubrificação Industrial' => ['area' => 'Mecânica', 'uc' => 'Lubrificação Industrial'],
    'Empilhadeira' => ['area' => 'Mecânica', 'uc' => 'Operação de Empilhadeira'],
    'Aprendizagem Industrial em Gestão Industrial' => ['area' => 'Gestão', 'uc' => 'Gestão Industrial'],
    'Aprendizagem Industrial Eletricista Industrial' => ['area' => 'Eletroeletrônica', 'uc' => 'Eletricista Industrial'],
    'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE AUTOMÓVEIS' => ['area' => 'Mecânica', 'uc' => 'Manutenção Automotiva'],
    'APRENDIZAGEM INDUSTRIAL EM PROCESSOS ADMINISTRATIVOS' => ['area' => 'Gestão', 'uc' => 'Processos Administrativos'],
    'APRENDIZAGEM INDUSTRIAL EM CONTROLE DE QUALIDADE' => ['area' => 'Gestão', 'uc' => 'Controle de Qualidade'],
    'TÉCNICO EM DESENVOLVIMENTO DE SISTEMAS' => ['area' => 'Tecnologia da Informação', 'uc' => 'Desenvolvimento de Sistemas'],
    'TÉCNICO EM INFORMÁTICA PARA INTERNET' => ['area' => 'Tecnologia da Informação', 'uc' => 'Informática para Internet'],
    'APRENDIZAGEM MANUTENÇÃO MECÂNICA DE MÁQUINAS INDUSTRIAIS' => ['area' => 'Mecânica', 'uc' => 'Manutenção de Máquinas'],
    'APRENDIZAGEM INDUSTRIAL EM ELETRICIDADE DE AUTOMÓVEIS' => ['area' => 'Eletroeletrônica', 'uc' => 'Eletricidade Automotiva'],
    'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE MÁQUINAS INDUSTRIAIS' => ['area' => 'Mecânica', 'uc' => 'Manutenção de Máquinas'],
    'APRENDIZAGEM INDUSTRIAL EM OPERAÇÃO DE MÁQUINAS FERRAMENTAS CONVENCIONAIS' => ['area' => 'Mecânica', 'uc' => 'Operação de Máquinas'],
    'APRENDIZAGEM INDUSTRIAL EM ELETRICISTA INDUSTRIAL' => ['area' => 'Eletroeletrônica', 'uc' => 'Eletricista Industrial'],
    'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO ELETROMECÂNICA' => ['area' => 'Eletroeletrônica', 'uc' => 'Manutenção Eletromecânica'],
    'TÉCNICO EM MECÂNICA' => ['area' => 'Mecânica', 'uc' => 'Mecânica'],
    'TÉCNICO EM ELETROMECÂNICA' => ['area' => 'Eletroeletrônica', 'uc' => 'Eletromecânica'],
    'TÉCNICO EM SEGURANÇA DO TRABALHO' => ['area' => 'Gestão', 'uc' => 'Segurança do Trabalho'],
    'TÉCNICO EM ELETROTÉCNICA' => ['area' => 'Eletroeletrônica', 'uc' => 'Eletrotécnica'],
    'TÉCNICO EM AUTOMAÇÃO INDUSTRIAL' => ['area' => 'Eletroeletrônica', 'uc' => 'Automação Industrial'],
];

// --- INÍCIO DA ALTERAÇÃO ---
// Simulação de dados de instrutores
$instrutores = [
    'APOSEM157N' => 'João da Silva',
    'APLUBRIN1IN' => 'Maria de Souza',
    'APOSEM156N' => 'João da Silva',
    'AI-GEI-07-M-25-12800' => 'Pedro Oliveira',
    'AI-GEI-08-T-25-12800' => 'Ana Costa',
    'AI-ETR-03-M-25-12800' => 'Carlos Pereira',
    'AI-ETR-02-T-25-12800' => 'Fernanda Lima',
    'AI-MMA-01-M-23-12800_' => 'Ricardo Almeida',
    'AI-MMA-02-M-23-12800' => 'Ricardo Almeida',
    'AI-ADM-03-M-23-12800_' => 'Gabriela Santos',
    'AI-ADM-04-M-23-12800_' => 'Gabriela Santos',
    'AI-QUA-02-M-23-12800_' => 'Juliana Rocha',
    'AI-QUA-03-M-23-12800_' => 'Juliana Rocha',
    'HT-SIS-01-M-24-12800_' => 'Felipe Martins',
    'HT-IPI-01-M-24-12800_' => 'Luana Ribeiro',
    'AI-MMM-01-24-M-12800' => 'André Fernandes',
    'AI-MMA-03-T-23-12800_' => 'Ricardo Almeida',
    'AI-AUT-01-T-23-12800_' => 'Marcos Vinicius',
    'AI-AUT-02-T-23-12800_' => 'Marcos Vinicius',
    'AI-AUT-03-T-23-12800_' => 'Marcos Vinicius',
    'AI-MMM-07-T-23-12800_' => 'André Fernandes',
    'AI-MMM-08-T-23-12800_' => 'André Fernandes',
    'AI-MFC-02-T-23-12800_' => 'Lucas Barbosa',
    'AI-ETR-02-T-24-12800_' => 'Carlos Pereira',
    'AI-MEL-01-T-24-12800_' => 'Daniela Castro',
    'AI-GEI-06-T-24-12800_' => 'Pedro Oliveira',
    'HT-MEC-02-T-24-12800_' => 'Rafael Costa',
    'HT-ELM-01-T-24-12800_' => 'Daniela Castro',
    'AI-MEL-01-T-25-12800' => 'Daniela Castro',
    'AI-MMM-01-M-25-12800' => 'André Fernandes',
    'AI-MEL-03-T-24-12800' => 'Daniela Castro',
    'HT-SDT-01-N-24-12800_' => 'Tatiana Silva',
    'HT-ETT-04-I-23-12800_' => 'Fernando Santos',
    'HT-MEC-05-I-23-12800_' => 'Rafael Costa',
    'HT-AUT-01-N-24-12800_' => 'Marcos Vinicius',
];
// --- FIM DA ALTERAÇÃO ---


// Funções utilitárias para mapeamento e padronização
function getAreaUc($curso, $mapping) {
    $curso = trim(strtoupper($curso));
    foreach ($mapping as $key => $values) {
        if (strpos(strtoupper($key), $curso) !== false || strpos($curso, strtoupper($key)) !== false) {
            return $values;
        }
    }
    return ['area' => 'Não Definida', 'uc' => $curso];
}

function normalizeTurno($turno) {
    switch (strtoupper($turno)) {
        case 'MANHA':
            return 'Manhã';
        case 'TARDE':
            return 'Tarde';
        case 'NOITE':
            return 'Noite';
        case 'INTEGRAL':
        case 'TARDE/NOITE':
            return 'Integral';
        default:
            return 'Indefinido';
    }
}

// Data de referência (hoje) para turmas em andamento
$today = new DateTime('2025-07-15');
$aulasData = [];

foreach ($turmas as $turma) {
    if (empty($turma['data_inicio'])) {
        continue;
    }

    $startDate = new DateTime($turma['data_inicio']);
    $endDate = empty($turma['data_termino']) ? $today : new DateTime($turma['data_termino']);
    
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

    // --- INÍCIO DA ALTERAÇÃO ---
    // Encontra o nome do instrutor a partir do novo array de mapeamento
    $instrutorNome = $instrutores[$turma['codigo_turma']] ?? 'Instrutor não Atribuído';
    // --- FIM DA ALTERAÇÃO ---

    foreach ($period as $date) {
        if ($date->format('w') == 0 || $date->format('w') == 6) {
            continue;
        }

        $cursoInfo = getAreaUc($turma['curso'], $mapeamento_curso);

        $aulasData[] = [
            'date' => $date->format('Y-m-d'),
            'codigoTurma' => $turma['codigo_turma'],
            // --- INÍCIO DA ALTERAÇÃO ---
            'instrutor' => $instrutorNome, 
            // --- FIM DA ALTERAÇÃO ---
            'sala' => 'Sala ' . rand(1, 10),
            'uc' => $cursoInfo['uc'],
            'turno' => normalizeTurno($turma['turno']),
            'area' => $cursoInfo['area']
        ];
    }
}

echo json_encode($aulasData, JSON_PRETTY_PRINT);
