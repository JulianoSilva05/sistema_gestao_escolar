<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Dados fictícios de salas
$salas = [
    
   
    [
        'id' => 1,
        'nome' => '108C',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Aperfeiçoamento em Lubrificação',
        'instrutorAtual' => 'JONATAS MORAIS DE SOUZA',
        'ferramentas' => [],
        'disciplinas' => ['LUBRIFICAÇÃO'],
        'reservas' => [
            [
                'data' => '2025-05-28',
                'turmaId' => null,
                'turmaCodigo' => '',
                'instrutorId' => null,
                'instrutorNome' => 'JONATAS MORAIS DE SOUZA',
                'disciplina' => 'LUBRIFICAÇÃO'
            ],
            [
                'data' => '2025-05-29',
                'turmaId' => null,
                'turmaCodigo' => 'AI-GEI-07-M-25-12800',
                'instrutorId' => null,
                'instrutorNome' => 'CRISTIANE',
                'disciplina' => 'Fundamentos dos Processos Administrativos'
            ]
        ]
    ],
    [
        'id' => 2,
        'nome' => '109C',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Aprendizagem Industrial em Gestão Industrial',
        'instrutorAtual' => 'CRISTIANE',
        'ferramentas' => [],
        'disciplinas' => ['Fundamentos da Qualidade'],
        'reservas' => [
            [
                'data' => '2025-09-11',
                'turmaId' => null,
                'turmaCodigo' => 'AI-GEI-07-M-25-12800',
                'instrutorId' => null,
                'instrutorNome' => 'CRISTIANE',
                'disciplina' => 'Fundamentos da Qualidade'
            ],
            [
                'data' => '2027-01-15',
                'turmaId' => null,
                'turmaCodigo' => 'AI-ETR-03-M-25-12800',
                'instrutorId' => null,
                'instrutorNome' => '?',
                'disciplina' => 'Novas Tecnologias Aplicadas à Eletroeletrônica'
            ]
        ]
    ],
    [
        'id' => 3,
        'nome' => '201A',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Aprendizagem Industrial Eletricista Industrial',
        'instrutorAtual' => '?',
        'ferramentas' => [],
        'disciplinas' => ['Qualidade, Saúde, Meio Ambiente e Segurança do Trabalho aplicados à Eletroeletrônica'],
        'reservas' => [
            [
                'data' => '2025-07-10',
                'turmaId' => null,
                'turmaCodigo' => 'AI-ETR-02-T-25-12800',
                'instrutorId' => null,
                'instrutorNome' => '?',
                'disciplina' => 'Manutenção Eletroeletrônica Industrial'
            ]
        ]
    ],
    [
        'id' => 4,
        'nome' => '201B',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'APRENDIZAGEM INDUSTRIAL EM MANUTENÇÃO MECÂNICA DE AUTOMÓVEIS',
        'instrutorAtual' => 'FABIANO CAMPOS DA SILVA',
        'ferramentas' => [],
        'disciplinas' => ['Motor de Combustão Interna'],
        'reservas' => [
            [
                'data' => '2025-01-16',
                'turmaId' => null,
                'turmaCodigo' => 'AI-MMA-02-M-23-12800',
                'instrutorId' => null,
                'instrutorNome' => 'FABIANO CAMPOS DA SILVA',
                'disciplina' => 'Motor de Combustão Interna'
            ]
        ]
    ],
    [
        'id' => 5,
        'nome' => '201C',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'APERFEIÇOAMENTO PROFISSIONAL EM METROLOGIA',
        'instrutorAtual' => 'RENAN MARTINS FERREIRA LOPES',
        'ferramentas' => [],
        'disciplinas' => ['Metrologia'],
        'reservas' => [
            [
                'data' => '2025-03-25',
                'turmaId' => null,
                'turmaCodigo' => '',
                'instrutorId' => null,
                'instrutorNome' => 'RENAN MARTINS FERREIRA LOPES',
                'disciplina' => 'Metrologia'
            ],
            [
                'data' => '2025-04-14',
                'turmaId' => null,
                'turmaCodigo' => 'AI-QUA-02-M-23-12800_',
                'instrutorId' => null,
                'instrutorNome' => 'PAMELA GRAZIELA DA COSTA ESTEVES',
                'disciplina' => 'Informatica'
            ]
        ]
    ],
    [
        'id' => 6,
        'nome' => '202A',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Aprendizagem Industrial Eletricista Industrial',
        'instrutorAtual' => '?',
        'ferramentas' => [],
        'disciplinas' => ['Raciocínio Lógico e Análise de Dados'],
        'reservas' => [
            [
                'data' => '2025-07-22',
                'turmaId' => null,
                'turmaCodigo' => 'AI-ETR-03-M-25-12800',
                'instrutorId' => null,
                'instrutorNome' => '?',
                'disciplina' => 'Planejamento e Organização do Trabalho'
            ]
        ]
    ],
    [
        'id' => 7,
        'nome' => '203A',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Aprendizagem Industrial em Gestão Industrial',
        'instrutorAtual' => 'CRISTIANE',
        'ferramentas' => [],
        'disciplinas' => ['Fundamentos dos Processos Financeiros'],
        'reservas' => [
            [
                'data' => '2025-01-15',
                'turmaId' => null,
                'turmaCodigo' => 'AI-GEI-07-M-25-12800',
                'instrutorId' => null,
                'instrutorNome' => 'CRISTIANE',
                'disciplina' => 'Fundamentos dos Processos Financeiros'
            ],
            [
                'data' => '2025-05-16',
                'turmaId' => null,
                'turmaCodigo' => 'AI-ETR-02-T-25-12800',
                'instrutorId' => null,
                'instrutorNome' => '?',
                'disciplina' => 'Instalação de Sistemas Elétricos Industriais I'
            ]
        ]
    ],
    [
        'id' => 8,
        'nome' => '204A',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Aprendizagem Industrial em Gestão Industrial',
        'instrutorAtual' => 'CRISTIANE',
        'ferramentas' => [],
        'disciplinas' => ['Fundamentos de Logística'],
        'reservas' => [
            [
                'data' => '2025-04-28',
                'turmaId' => null,
                'turmaCodigo' => 'AI-GEI-07-M-25-12800',
                'instrutorId' => null,
                'instrutorNome' => 'CRISTIANE',
                'disciplina' => 'Fundamentos de Logística'
            ]
        ]
    ],
    [
        'id' => 9,
        'nome' => '205A',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Empilhadeira',
        'instrutorAtual' => 'HAROLDO LOPES DE OLIVEIRA',
        'ferramentas' => [],
        'disciplinas' => ['EMPILHADEIRA'],
        'reservas' => [
            [
                'data' => '2025-04-07',
                'turmaId' => null,
                'turmaCodigo' => 'APOSEM156N',
                'instrutorId' => null,
                'instrutorNome' => 'HAROLDO LOPES DE OLIVEIRA',
                'disciplina' => 'EMPILHADEIRA'
            ],
            [
                'data' => '2025-01-16',
                'turmaId' => null,
                'turmaCodigo' => 'AI-MMM-07-T-23-12800_',
                'instrutorId' => null,
                'instrutorNome' => 'ERIVELTON JOSE FELIPE NONATO',
                'disciplina' => 'Fabrição Mêcanica Aplicada a Manutenção'
            ]
        ]
    ],
    // Continuação para todas as outras salas...
    [
        'id' => 45,
        'nome' => '220B',
        'capacidade' => null,
        'status' => 'Ocupada',
        'turmaAtual' => 'Aprendizagem Industrial Eletricista Industrial',
        'instrutorAtual' => '?',
        'ferramentas' => [],
        'disciplinas' => ['Práticas Inovadoras'],
        'reservas' => [
            [
                'data' => '2025-08-14',
                'turmaId' => null,
                'turmaCodigo' => 'AI-ETR-03-M-25-12800',
                'instrutorId' => null,
                'instrutorNome' => '?',
                'disciplina' => 'Práticas Inovadoras'
            ]
        ]
    ]

];

// Retorna os dados em formato JSON
echo json_encode($salas);
?>