<?php
header('Content-Type: application/json');

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
        'data_termino' => '2026-04-22',
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
        'data_termino' => '2025-07-16',
        'turno' => 'MANHA',
        'num_alunos' => 21,
        'curso' => 'APRENDIZAGEM INDUSTRIAL EM PROCESSOS ADMINISTRATIVOS'
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
        'data_termino' => '2025-07-16',
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
        'data_termino' => '2025-07-16',
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
        'data_termino' => '2025-07-16',
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
        'id' => 32, // ID duplicado, mas mantido conforme seu exemplo
        'codigo_turma' => 'HT-SDT-01-N-24-12800_',
        'data_inicio' => '2025-07-20',
        'data_termino' => '2025-12-29',
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
    ],
    [
        'id' => 36,
        'codigo_turma' => 'HT-AUT-02-N-24-12800',
        'data_inicio' => '2025-08-01',
        'data_termino' => '2026-07-29',
        'turno' => 'NOITE',
        'num_alunos' => 32,
        'curso' => 'TÉCNICO EM AUTOMAÇÃO INDUSTRIAL'
    ]
];

echo json_encode($turmas);
?>