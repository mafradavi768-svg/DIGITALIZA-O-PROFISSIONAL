<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Script de Backend: Encerramento de Sessão (Logout)
 */

require_once __DIR__ . '/../bd.php';

// Limpa todas as variáveis de sessão nativas
$_SESSION = [];

// Invalida o cookie de sessão do navegador se existir
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Redireciona para a página inicial com mensagem acolhedora
session_start();
$_SESSION['mensagem_info'] = "Você saiu com segurança. Descanse os olhos e volte sempre para treinar sob a lua amarela!";

header('Location: ../index.php');
exit;
