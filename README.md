# DIGITALIZAÇÃO PROFISSIONAL 🌕

> **Sistema Acolhedor de Digitação para Pessoas Mais Velhas e Iniciantes**  
> *"Ensinando do zero a digitar como um profissional sob o encanto da lua amarela e o céu estrelado."*

---

## 🌟 Visão Geral do Projeto

O **Digitalização Profissional** é uma plataforma web criada com foco na acessibilidade, empatia e inclusão digital para pessoas idosas e novatos que nunca digitaram ou que "catam milho" com um dedo.

O sistema transforma o aprendizado em uma experiência mágica, intuitiva e divertida através do jogo das **palavras flutuantes sobre as nuvens da noite da lua amarela**.

---

## 🎨 Design & Identidade Visual

- **Céu Noturno Azul Escuro**: Gradientes profundos de azul (`#040817`, `#070f2b`, `#0d1b4a`) com estrelas cintilantes dinâmicas que proporcionam alto contraste e evitam o cansaço visual.
- **Lua Amarela Brilhante**: Uma lua dourada com halo luminoso e crateras suaves que serve de bússola visual e inspiração para os alunos.
- **Nuvens da Noite**: Nuvens etéreas flutuantes que carregam as palavras da lição suavemente pelo céu.
- **Acessibilidade para a Terceira Idade**:
  - Controles de tamanho de texto no topo (`A-`, `A`, `A+`).
  - Sintetizador de voz nativo (Web Speech API pt-BR) que lê em voz alta as instruções para quem tem dificuldade de leitura.
  - Teclado virtual ABNT2 com indicação das teclas de descanso com relevo (**F** e **J**) e cores didáticas para cada dedo.

---

## 📋 Regras de Negócio Implementadas (CORE)

1. **Design de Noite com Lua Amarela**: Toda a interface foi desenhada sobre a paleta azul escuro noturna com a lua amarela celestial.
2. **Diagnóstico no Cadastro**: Todo usuário ao se registrar informa seu nível de digitação:
   - 🟢 *Iniciante do Zero* (Nunca digitei, não sei onde ficam as teclas)
   - 🟡 *Básico* (Digito catando milho devagar com 1 ou 2 dedos)
   - 🔵 *Em Evolução* (Conheço algumas teclas, quero aprender os dedos certos)
   - 🟣 *Praticante* (Quero velocidade profissional e precisão)
3. **Bloqueio Rigoroso de Re-cadastro**:
   - Cada pessoa que se cadastrar **não terá o direito de se cadastrar novamente** com o mesmo e-mail.
   - O sistema valida no banco e exibe alerta explícito e orienta o acesso via login.
4. **Palavras Flutuantes sobre as Nuvens**:
   - As nuvens passeiam pelo céu noturno da lua amarela com palavras adaptadas ao nível do aluno.
   - O teclado virtual mostra a tecla exata e a cor do dedo que deve ser utilizado.
   - Ao completar a palavra, a nuvem sobe em brilho dourado rumo à lua amarela com som harmonioso.

---

## 🛠️ Stack Tecnológico

- **Backend**: PHP estruturado em sessões nativas (`session_start()`, `$_SESSION`).
- **Banco de Dados**: MySQL (com PDO para máxima segurança contra SQL Injections).
  - *Resiliência Automática*: Caso o serviço MySQL esteja desligado na máquina de testes, o arquivo `bd.php` ativa o SQLite nativo sem quebrar o sistema.
- **Frontend**: HTML5 Semântico, PHP, CSS Moderno com Animações e Tailwind CSS responsivo Mobile-First.
- **Efeitos de Áudio**: Web Audio API (tons sintetizados nativos e suaves, sem arquivos externos pesados).
- **Acessibilidade**: Web Speech API nativa em português brasileiro.

---

## 📂 Estrutura de Arquivos

```
digitaliz/
├── bd.php                       # Conexão PDO segura (MySQL com fallback SQLite)
├── schema.sql                   # Estrutura do banco de dados MySQL
├── index.php                    # Apresentação acolhedora e hero noturno com lua
├── cadastro.php                 # Cadastro único com pergunta de nível e bloqueio
├── login.php                    # Acesso seguro do aluno
├── painel.php                   # Dashboard do aluno (estatísticas e histórico)
├── treino_nuvens.php            # Treino interativo das nuvens com lua amarela
├── licoes.php                   # Escola do Teclado (F e J com relevo, postura)
├── perfil.php                   # Medalhas conquistadas e certificado honorífico
├── iniciar_servidor.bat         # Inicia com 1 clique o servidor local na porta 8000
├── iniciar_servidor.ps1         # Script PowerShell de inicialização
├── backend/
│   ├── auth_check.php           # Auxiliares de sessão e níveis de palavras
│   ├── auth_login.php           # Autenticação de usuários existentes
│   ├── auth_logout.php          # Encerramento de sessão
│   ├── auth_register.php        # Validação do cadastro e bloqueio de re-registro
│   ├── get_stats.php            # API JSON de estatísticas do aluno
│   └── save_progress.php        # API JSON que salva pontuação e medalhas
├── includes/
│   ├── header.php               # Cabeçalho responsivo, acessibilidade e lua
│   └── footer.php               # Rodapé com mensagens de encorajamento
└── assets/
    ├── css/
    │   └── custom.css           # Lua amarela, estrelas cintilantes e nuvens
    └── js/
        ├── acessibilidade.js    # Controle de fontes A+/A- e leitor por voz
        ├── audio_effects.js     # Sintetizador de áudio Web Audio API
        └── nuvens_game.js       # Mecânica das nuvens flutuantes e teclado
```

---

## 🚀 Como Executar o Projeto

### Opção 1: Com 1 Clique (Windows)
Dê um duplo clique no arquivo:
```
iniciar_servidor.bat
```
O navegador abrirá automaticamente em `http://localhost:8000`.

### Opção 2: Pelo Terminal / Linha de Comando
Na pasta do projeto, execute:
```bash
php -S localhost:8000
```
E acesse `http://localhost:8000` em seu navegador.

### Opção 3: No XAMPP / WampServer / Laragon
1. Copie a pasta `digitaliz` para a pasta `htdocs` (ou `www`).
2. Importe o arquivo `schema.sql` no phpMyAdmin ou MySQL CLI.
3. Acesse `http://localhost/digitaliz`.
