<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Script de Backend: Autenticação de Usuários Existentes
 */

require_once __DIR__ . '/../bd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$email = strtolower(trim($_POST['email'] ?? ''));
$senha = $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    $_SESSION['login_erro'] = "Por favor, preencha o e-mail e a senha cadastrados.";
    $_SESSION['login_email'] = $email;
    header('Location: ../login.php');
    exit;
}

try {
    $pdo = getDBConnection();

    // Consulta segura através de Prepared Statement
    $stmt = $pdo->prepare("
        SELECT id, nome, email, senha_hash, nivel_digitacao, tamanho_fonte_pref, som_habilitado 
        FROM usuarios 
        WHERE email = :email 
        LIMIT 1
    ");
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch();

    if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
        $_SESSION['login_erro'] = "E-mail ou senha incorretos. Por favor, verifique se digitou certinho.";
        $_SESSION['login_email'] = $email;
        header('Location: ../login.php');
        exit;
    }

    // Atualiza a data do último acesso
    try {
        $updateStmt = $pdo->prepare("UPDATE usuarios SET ultimo_acesso = CURRENT_TIMESTAMP WHERE id = :id");
        $updateStmt->execute([':id' => $usuario['id']]);
    } catch (Exception $e) {
        // Ignora falha não crítica de auditoria
    }

    // Inicializa a sessão nativa com os dados do usuário
    $_SESSION['usuario_id'] = (int)$usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['usuario_email'] = $usuario['email'];
    $_SESSION['usuario_nivel'] = $usuario['nivel_digitacao'];
    $_SESSION['usuario_fonte'] = $usuario['tamanho_fonte_pref'] ?? 'grande';
    $_SESSION['usuario_som'] = (int)($usuario['som_habilitado'] ?? 1);

    // Limpa erros anteriores
    unset($_SESSION['login_erro']);
    unset($_SESSION['login_email']);

    $_SESSION['mensagem_sucesso'] = "Que bom ter você de volta, {$usuario['nome']}! Vamos continuar seu treino nas nuvens?";
    
    header('Location: ../painel.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['login_erro'] = "Erro ao conectar com a base de dados. Tente novamente mais tarde.";
    header('Location: ../login.php');
    exit;
}
