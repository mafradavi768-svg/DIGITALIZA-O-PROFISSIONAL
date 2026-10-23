<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Script de Backend: Salvar Progresso e Conquistas do Treino
 * Recebe dados via JSON/POST e salva no MySQL utilizando PDO Prepared Statements.
 */

require_once __DIR__ . '/../bd.php';
require_once __DIR__ . '/auth_check.php';

header('Content-Type: application/json; charset=utf-8');

if (!estaLogado()) {
    echo json_encode([
        'sucesso' => false, 
        'mensagem' => 'Sessão expirada. Faça login para registrar seu progresso permanente.'
    ]);
    exit;
}

$inputRaw = file_get_contents('php://input');
$dados = json_decode($inputRaw, true);

if (!$dados) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos recebidos.']);
    exit;
}

$usuarioId       = (int)$_SESSION['usuario_id'];
$modo            = trim($dados['modo'] ?? 'nuvens_flutuantes');
$palavrasCertas  = max(0, (int)($dados['palavras_certas'] ?? 0));
$palavrasErradas = max(0, (int)($dados['palavras_erradas'] ?? 0));
$precisao        = min(100.0, max(0.0, (float)($dados['precisao_pct'] ?? 0.0)));
$ppm             = max(0, (int)($dados['ppm'] ?? 0));
$pontos          = max(0, (int)($dados['pontos'] ?? 0));

try {
    $pdo = getDBConnection();

    // Insere o registro de treino do aluno
    $stmt = $pdo->prepare("
        INSERT INTO progresso_digitacao 
            (usuario_id, modo, palavras_certas, palavras_erradas, precisao_pct, ppm, pontos)
        VALUES 
            (:uid, :modo, :certas, :erradas, :precisao, :ppm, :pontos)
    ");

    $stmt->execute([
        ':uid'      => $usuarioId,
        ':modo'     => $modo,
        ':certas'   => $palavrasCertas,
        ':erradas'  => $palavrasErradas,
        ':precisao' => $precisao,
        ':ppm'      => $ppm,
        ':pontos'   => $pontos
    ]);

    // Verifica e concede medalhas automáticas
    $novasConquistas = [];

    // Total de palavras já acertadas pelo aluno na história
    $stmtTotal = $pdo->prepare("SELECT SUM(palavras_certas) as total FROM progresso_digitacao WHERE usuario_id = :uid");
    $stmtTotal->execute([':uid' => $usuarioId]);
    $totalGeral = (int)($stmtTotal->fetchColumn() ?: 0);

    // Conquista: 10 Palavras
    if ($totalGeral >= 10) {
        $stmtConq = $pdo->prepare("INSERT OR IGNORE INTO conquistas (usuario_id, codigo, titulo, descricao, icone) VALUES (:uid, 'dez_palavras', 'Nuvem de Algodão', 'Completou mais de 10 palavras com sucesso no céu estrelado.', '☁️')");
        // No MySQL, seria INSERT IGNORE
        if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') {
            $stmtConq = $pdo->prepare("INSERT IGNORE INTO conquistas (usuario_id, codigo, titulo, descricao, icone) VALUES (:uid, 'dez_palavras', 'Nuvem de Algodão', 'Completou mais de 10 palavras com sucesso no céu estrelado.', '☁️')");
        }
        $stmtConq->execute([':uid' => $usuarioId]);
        if ($stmtConq->rowCount() > 0) {
            $novasConquistas[] = ['titulo' => 'Nuvem de Algodão', 'icone' => '☁️', 'descricao' => 'Completou mais de 10 palavras nas nuvens!'];
        }
    }

    // Conquista: Alta Precisão
    if ($precisao >= 90.0 && $palavrasCertas >= 5) {
        $sqlPrec = ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql')
            ? "INSERT IGNORE INTO conquistas (usuario_id, codigo, titulo, descricao, icone) VALUES (:uid, 'mira_certeira', 'Brilho da Lua Dourada', 'Alcançou mais de 90% de precisão ao digitar as palavras flutuantes.', '🌙')"
            : "INSERT OR IGNORE INTO conquistas (usuario_id, codigo, titulo, descricao, icone) VALUES (:uid, 'mira_certeira', 'Brilho da Lua Dourada', 'Alcançou mais de 90% de precisão ao digitar as palavras flutuantes.', '🌙')";
        $stmtPrec = $pdo->prepare($sqlPrec);
        $stmtPrec->execute([':uid' => $usuarioId]);
        if ($stmtPrec->rowCount() > 0) {
            $novasConquistas[] = ['titulo' => 'Brilho da Lua Dourada', 'icone' => '🌙', 'descricao' => 'Precisão incrível acima de 90%!'];
        }
    }

    // Conquista: Velocidade
    if ($ppm >= 20) {
        $sqlVel = ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql')
            ? "INSERT IGNORE INTO conquistas (usuario_id, codigo, titulo, descricao, icone) VALUES (:uid, 'dedos_ageis', 'Estrela Cadente', 'Atingiu 20 Palavras Por Minuto! Seus dedos estão voando pelo teclado.', '⭐')"
            : "INSERT OR IGNORE INTO conquistas (usuario_id, codigo, titulo, descricao, icone) VALUES (:uid, 'dedos_ageis', 'Estrela Cadente', 'Atingiu 20 Palavras Por Minuto! Seus dedos estão voando pelo teclado.', '⭐')";
        $stmtVel = $pdo->prepare($sqlVel);
        $stmtVel->execute([':uid' => $usuarioId]);
        if ($stmtVel->rowCount() > 0) {
            $novasConquistas[] = ['titulo' => 'Estrela Cadente', 'icone' => '⭐', 'descricao' => 'Atingiu 20 Palavras Por Minuto!'];
        }
    }

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Progresso registrado com sucesso!',
        'total_palavras' => $totalGeral,
        'novas_conquistas' => $novasConquistas
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'sucesso' => false, 
        'mensagem' => 'Erro ao salvar progresso no banco: ' . $e->getMessage()
    ]);
}
