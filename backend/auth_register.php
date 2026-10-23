<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Script de Backend: Processamento de Cadastro de Novos Usuários
 * 
 * Regras de Negócio Implementadas:
 * - Pergunta obrigatória do nível de digitação.
 * - Bloqueio estrito de re-cadastro (cada pessoa que se cadastrar NÃO terá o direito de se cadastrar novamente).
 * - Uso exclusivo de PDO com Prepared Statements contra SQL Injection.
 * - Gerenciamento através de sessões nativas do PHP.
 */

require_once __DIR__ . '/../bd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../cadastro.php');
    exit;
}

// Sanitização e Coleta dos Dados
$nome = trim($_POST['nome'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$senha = $_POST['senha'] ?? '';
$nivel = trim($_POST['nivel_digitacao'] ?? '');

$erros = [];

// Validação dos Campos
if (mb_strlen($nome) < 2) {
    $erros[] = "Por favor, digite seu nome completo ou como gosta de ser chamado.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "Por favor, informe um endereço de e-mail válido.";
}

if (strlen($senha) < 4) {
    $erros[] = "A senha deve ter pelo menos 4 caracteres (escolha algo que você lembre facilmente).";
}

$niveisValidos = ['iniciante_zero', 'iniciante_catando', 'intermediario', 'avancado'];
if (!in_array($nivel, $niveisValidos, true)) {
    $erros[] = "Por favor, selecione seu nível atual de digitação para podermos personalizar seus treinos.";
}

if (!empty($erros)) {
    $_SESSION['cadastro_erros'] = $erros;
    $_SESSION['cadastro_dados'] = ['nome' => $nome, 'email' => $email, 'nivel_digitacao' => $nivel];
    header('Location: ../cadastro.php');
    exit;
}

try {
    $pdo = getDBConnection();

    // REGRA DE NEGÓCIO CORE:
    // "cada pessoa que se cadastrar nao terá o direito de se cadastrar novamente"
    $stmtVerifica = $pdo->prepare("SELECT id, nome FROM usuarios WHERE email = :email LIMIT 1");
    $stmtVerifica->execute([':email' => $email]);
    $usuarioExistente = $stmtVerifica->fetch();

    if ($usuarioExistente) {
        // Bloqueio rigoroso de re-cadastro
        $_SESSION['cadastro_erros'] = [
            "⛔ ATENÇÃO: O e-mail informado já está registrado no sistema.",
            "De acordo com as regras de uso da plataforma, cada pessoa só pode se cadastrar uma única vez. Não é permitido criar um novo cadastro com o mesmo e-mail.",
            "👉 Por favor, utilize a tela de Login para acessar seus treinos."
        ];
        $_SESSION['cadastro_dados'] = ['nome' => $nome, 'email' => $email, 'nivel_digitacao' => $nivel];
        header('Location: ../cadastro.php');
        exit;
    }

    // Criptografia segura da senha (Argon2 ou Bcrypt nativo)
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserção segura via PDO Prepared Statement
    $stmtInsert = $pdo->prepare("
        INSERT INTO usuarios (nome, email, senha_hash, nivel_digitacao)
        VALUES (:nome, :email, :senha_hash, :nivel)
    ");
    
    $stmtInsert->execute([
        ':nome'       => $nome,
        ':email'      => $email,
        ':senha_hash' => $senhaHash,
        ':nivel'      => $nivel
    ]);

    $novoUsuarioId = (int)$pdo->lastInsertId();

    // Concede a primeira medalha de boas-vindas
    try {
        $stmtMedalha = $pdo->prepare("
            INSERT INTO conquistas (usuario_id, codigo, titulo, descricao, icone)
            VALUES (:uid, 'primeiro_passo', 'Primeiro Passo no Céu Noturno', 'Cadastrou-se com sucesso e deu o primeiro passo para digitar como profissional.', '🌕')
        ");
        $stmtMedalha->execute([':uid' => $novoUsuarioId]);
    } catch (Exception $eMedalha) {
        // Não interrompe o fluxo caso a medalha falhe
    }

    // Configura a sessão nativa do usuário
    $_SESSION['usuario_id'] = $novoUsuarioId;
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['usuario_email'] = $email;
    $_SESSION['usuario_nivel'] = $nivel;
    $_SESSION['usuario_fonte'] = 'grande';
    $_SESSION['usuario_som'] = 1;

    // Limpa dados temporários do formulário
    unset($_SESSION['cadastro_dados']);
    unset($_SESSION['cadastro_erros']);

    $_SESSION['mensagem_sucesso'] = "Boas-vindas, {$nome}! Sua conta foi criada com sucesso. Que as nuvens e a lua amarela iluminem sua jornada de digitação!";
    
    header('Location: ../painel.php');
    exit;

} catch (PDOException $e) {
    // Tratamento de integridade caso ocorra colisão de chave única em concorrência
    if (strpos($e->getMessage(), 'UNIQUE') !== false || $e->getCode() == 23000) {
        $_SESSION['cadastro_erros'] = [
            "⛔ ATENÇÃO: Este e-mail já foi registrado anteriormente. Cada pessoa só pode se cadastrar uma única vez.",
            "Acesse diretamente com seu login existente."
        ];
    } else {
        $_SESSION['cadastro_erros'] = [
            "Ocorreu uma instabilidade temporária ao salvar seus dados: " . $e->getMessage()
        ];
    }
    $_SESSION['cadastro_dados'] = ['nome' => $nome, 'email' => $email, 'nivel_digitacao' => $nivel];
    header('Location: ../cadastro.php');
    exit;
}
