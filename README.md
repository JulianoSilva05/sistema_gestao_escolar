
**Sistema de Gestão SENAI**  
Este projeto é um sistema web para auxiliar na gestão de cursos, turmas, instrutores e salas do SENAI, com um dashboard para visualização de dados e funcionalidades de calendário para instrutores.

---

**Visão Geral**  
O sistema é construído com tecnologias web front-end (*HTML, CSS, JavaScript*) e utiliza *PHP* para simular a obtenção de dados do "backend" através de arquivos JSON. Ele oferece uma interface intuitiva para gerenciar diversas entidades educacionais.

---

**Funcionalidades**  
O sistema atualmente inclui os seguintes módulos:

**Dashboard de Turmas:**
- Exibe um resumo visual de dados importantes, como total de turmas, total de alunos, turmas ativas e turmas com dados incompletos.
- Mostra a distribuição de turmas por turno e área.
- Lista próximas turmas e turmas com dados incompletos.

**Gestão de Cursos:**
- Permite adicionar, editar e excluir cursos.
- Associação de Unidades Curriculares (UCs) a cada curso, com funcionalidade de busca e seleção de UCs disponíveis.
- Exibe as UCs associadas diretamente na tabela de cursos.

**Gestão de Instrutores:**
- Permite adicionar, editar e excluir instrutores.
- Associação de turmas e registro de histórico de aulas ministradas por cada instrutor.

**Calendário de Disponibilidade:**
- Um calendário interativo que mostra a disponibilidade dos instrutores por dia.
- Dias no calendário indicam se há instrutores livres, ocupados ou com conflitos de horário (destacados em vermelho).
- Ao clicar em um dia, um modal exibe a lista de todos os instrutores e seu status detalhado para aquela data.

**Gestão de Salas:**
- Permite adicionar, editar e excluir salas.
- Visualização da capacidade, status (Livre/Ocupada), turma e instrutor atuais.
- Funcionalidade de reserva de salas com base em um calendário.

---

**Tecnologias Utilizadas**

**Frontend:**
- HTML5  
- CSS3 (com classes utilitárias do *Tailwind CSS* e estilos personalizados)  
- JavaScript (ES6+)  
- Font Awesome (para ícones)  

**Backend (Simulado):**
- PHP (para servir dados JSON de arquivos estáticos, simulando uma API)

---

**Como Configurar e Executar**  
Para executar este sistema localmente, você precisará de um ambiente de servidor web com suporte a PHP (como XAMPP, WAMP, MAMP ou PHP embutido).

**1. Clone ou Baixe o Projeto:**  
Obtenha todos os arquivos do projeto.

**2. Configurar o Servidor Web:**  
- Coloque a pasta do projeto no diretório de documentos do seu servidor web (ex: `htdocs` para Apache/XAMPP).  
- Certifique-se de que o PHP esteja configurado e funcionando.

**3. Estrutura de Arquivos Necessária:**
- `dashboard.html`  
- `gestao_cursos.php`  
- `gestao_instrutores.php`  
- `gestao_salas.php`  
- `dados_cursos.php` (fornece dados para a gestão de cursos)  
- `dados_instrutores.php` (fornece dados para a gestão de instrutores)  
- `dados_salas.php` (fornece dados para a gestão de salas)  
- `dados_unidades_curriculares.php` (fornece a lista de UCs para a gestão de cursos)  
- `logo.png` (ou um placeholder de imagem, conforme configurado no código)  
- `style_turmas.css` (estilos gerais, embora muitos tenham sido incorporados ao HTML)  
- `style_instrutores.css` (estilos específicos para instrutores, também incorporados)

**4. Acessar o Sistema:**  
Abra seu navegador e navegue até o endereço do projeto no seu servidor local:  
- `http://localhost/seu_projeto/dashboard.html`  
- ou  
- `http://localhost/seu_projeto/gestao_cursos.php`

---

**Uso**

- **Navegação:** Utilize o menu lateral esquerdo para navegar entre os diferentes módulos do sistema (Dashboard, Gestão de Cursos, Gestão de Instrutores, Gestão de Salas, etc.).
- **Adicionar/Editar:** Clique nos botões "Adicionar Novo..." para abrir modais de formulário e preencher os dados. Use os botões de edição (`<i class="fas fa-edit"></i>`) na tabela para modificar entradas existentes.
- **Excluir:** Use os botões de exclusão (`<i class="fas fa-trash-alt"></i>`) para remover entradas.
- **Filtros e Pesquisa:** Utilize os campos de busca e filtros nas tabelas para refinar a visualização dos dados.
- **Calendário de Instrutores:** Navegue entre os meses e clique nos dias para ver a disponibilidade detalhada dos instrutores. Conflitos de horário serão destacados em vermelho.

---
# **Modelo Conceitual para Banco de Dados**

Com base na planilha fornecida, identifiquei as principais entidades e relacionamentos para criar um modelo conceitual de banco de dados para o sistema de gestão de cursos e turmas.

## **Entidades Principais**

1. **Curso**
    - id_curso PK
    - Nome do curso/turma
    - Classificação (TURMA, UNIDADE CURRICULAR)
    - Carga horária (h)
    - Modalidade (APERFEICOAMENTO, APRENDIZAGEM, TECNICO)
    - Tipo de curso (PRESENCIAL, EAD, NA EMPRESA)
    - Categoria (A, C)
    - id_unidades_curriculares FK
2. **Turma**
    - id_turma PK
    - Código da turma
    - Data de início
    - Data de término
    - Turno (MANHÃ, TARDE, NOITE, INTEGRAL)
    - Número de alunos
    - id_curso FK
3. **Instrutor**
    - id_instrutor
    - Nome completo
    - telefone
    - email
    - area_atuacao
    - Categoria (relacionada ao curso A-C)
- [ ]  Usar a matriz de competência para mapear os instrutores mais qualificados para cada disciplina.
- [ ]  Quando incluir turma , sugerir intrutores.
- [ ]  Separar por turno - para saber a alocação por intrutor
- [ ]  Quantas turmas por segmento - Area de conhecimento
1. **Sala**
    - id_sala PK
    - Código da sala (ex: 108C, 211B)
    - Bloco
    - Descrição
    - Cadeira
    - id_uc_pode FK
    - 
    
    Filtro por turno (mnhã, tarde, noite e  *16 às 20horas(integral)
    

verificar locação de salas

Gerar relatorio de ocupação

Validar ocupação

tratar 

Escolha de sala por capacidade e software instalados por pc

1. **Empresa**
    - id_empresa PK
    - Nome da empresa
    - CNPJ Matriz
    - CNPJ Filial
    - Endereço
    - Nome do responsável
    - Telefone do responsável
    - Email do Responsável
2. **Unidade Curricular**
    - id_uc PK
    - Nome
    - Carga horária
    - Dias da prática
    - Dias Teórica
    - Dias EAD
    - Instrutor Atuante
    - Instrutor Substituto
    - Salas Ideias para a UC
    
3. **Calendário**
    - Data
    - Dia da semana
    - Feriado (sim/não)

## **Relacionamentos**

- Um **Curso** pode ter várias **Turmas**
- Uma **Turma** pertence a um **Curso**
- Uma **Turma** pode ter várias **Unidades Curriculares**
- Uma **Turma** é ministrada por um ou mais **Instrutores**
- Uma **Turma** ocorre em uma **Sala**
- Uma **Turma** pode estar associada a uma **Empresa**
- Uma **Unidade Curricular** pertence a uma **Turma**
- Uma **Unidade Curricular** é ministrada por um **Instrutor**
- Uma **Unidade Curricular** ocorre em uma **Sala**

## **Diagrama Conceitual (em texto)**

```
[Curso] 1---* [Turma]
[Turma] *---1 [Sala]
[Turma] *---1 [Empresa]
[Turma] 1---* [Unidade Curricular]
[Unidade Curricular] *---1 [Instrutor]
[Unidade Curricular] *---1 [Sala]
[Turma] *---* [Instrutor]
```

# **Descritivo do Sistemas**

Com base nos dados e necessidades identificadas, o sistema deveria ter as seguintes telas principais:

## **1. Cadastro de Cursos**

- Listagem de todos os cursos
- Formulário para cadastro/edição com campos:
    - Nome do curso
    - Classificação
    - Modalidade
    - Tipo de curso
    - Carga horária total
    - Categoria

## **2. Gestão de Turmas**

- Listagem de turmas com filtros por:
    - Curso
    - Período (data início/término)
    - Turno
    - Empresa
- Formulário para cadastro/edição de turmas

## **3. Cadastro de Unidades Curriculares**

- Vinculação às turmas
- Definição de:
    - Nome
    - Carga horária
    - Dias da prática
    - Dias EAD
    - Instrutor responsável
    - Sala

## **4. Gestão de Instrutores**

- Cadastro de instrutores
- Associação a cursos/turmas
- Histórico de aulas ministradas

## **5. Controle de Salas**

- Cadastro de salas com:
    - Código
    - Bloco
    - Descrição
    - Capacidade
- Agenda de ocupação por período

## **6. Cadastro de Empresas**

- Dados das empresas parceiras
- CNPJ
- Contatos

## **7. Agenda e Calendário**

- Visualização integrada de todas as turmas e aulas
- Filtros por data, curso, instrutor, sala
- Possibilidade de agendamento

## **8. Relatórios**

- Cursos por período
- Ocupação de salas
- Carga horária de instrutores
- Turmas por empresa
- Histórico de cursos realizados

## **9. Painel de Controle**

- Visão geral do sistema
- Indicadores de ocupação
- Próximos eventos
- Alertas (conflitos de agendamento, etc.)

## **10. Configurações**

- Parâmetros do sistema
- Perfis de acesso
- Integrações com outros sistemas

# **Considerações Adicionais**

O sistema deve:

- Ter integração com as macros existentes na planilha
- Permitir a validação automática de dados (como a associação entre instrutor e categoria)
- Gerar listas suspensas conforme configurado na aba INSTRUCOES
- Oferecer funcionalidades de classificação/ordenação conforme os botões existentes na planilha

Este modelo conceitual e as telas propostas cobrem todas as funcionalidades evidenciadas na planilha fornecida, permitindo uma gestão completa dos cursos, turmas, instrutores e recursos físicos da instituição.

## Descrição da tarefa

Inclua uma visão geral da tarefa e detalhes relacionados.
**Próximos Passos (Possíveis Melhorias)**

- Persistência de Dados Real: Integrar com um banco de dados (*MySQL, PostgreSQL, Firestore*, etc.) para persistência real dos dados, em vez de usar arquivos PHP estáticos e `localStorage`.
- Autenticação e Autorização: Implementar um sistema de login e controle de acesso baseado em papéis.
- Validação de Formulários: Adicionar validações mais robustas nos formulários.
- Notificações/Alertas: Melhorar o sistema de alertas e notificações para o usuário.
- Relatórios e Gráficos: Expandir o dashboard com mais gráficos e relatórios dinâmicos.
- Funcionalidades de Agendamento: Desenvolver um sistema de agendamento mais completo para salas e instrutores, com visualização de horários.
- Responsividade Aprimorada: Otimizar ainda mais o design para diferentes tamanhos de tela e dispositivos.

---
