
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

**Próximos Passos (Possíveis Melhorias)**

- Persistência de Dados Real: Integrar com um banco de dados (*MySQL, PostgreSQL, Firestore*, etc.) para persistência real dos dados, em vez de usar arquivos PHP estáticos e `localStorage`.
- Autenticação e Autorização: Implementar um sistema de login e controle de acesso baseado em papéis.
- Validação de Formulários: Adicionar validações mais robustas nos formulários.
- Notificações/Alertas: Melhorar o sistema de alertas e notificações para o usuário.
- Relatórios e Gráficos: Expandir o dashboard com mais gráficos e relatórios dinâmicos.
- Funcionalidades de Agendamento: Desenvolver um sistema de agendamento mais completo para salas e instrutores, com visualização de horários.
- Responsividade Aprimorada: Otimizar ainda mais o design para diferentes tamanhos de tela e dispositivos.

---
