<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Script de Backend: Consulta de Estatísticas e Progresso do Usuário
 */

require_once __DIR__ . '/../bd.php';
require_once __DIR__ . '/auth_check.php';

header('Content-Type: application/json; charset=utf-8');

if (!estaLogado()) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Não autenticado']);
    exit;
}

$usuarioId = (int)$_SESSION['usuario_id'];

try {
    $pdo = getDBConnection();

    // Totais e médias de desempenho
    $stmt = $pdo->prepare("
        SELECT 
            COALESCE(SUM(palavras_certas), 0) AS total_certas,
            COALESCE(SUM(palavras_erradas), 0) AS total_erradas,
            COALESCE(AVG(precisao_pct), 0.0) AS media_precisao,
            COALESCE(MAX(ppm), 0) AS max_ppm,
            COALESCE(SUM(pontos), 0) AS total_pontos,
            COUNT(id) AS total_sessoes
        FROM progresso_digitacao
        WHERE usuario_id = :uid
    ");
    $stmt->execute([':uid' => $usuarioId]);
    $stats = $stmt->fetch();

    // Conquistas desbloqueadas
    $stmtConq = $pdo->prepare("
        SELECT codigo, titulo, descricao, icone, data_conquistada 
        FROM conquistas 
        WHERE usuario_id = :uid 
        ORDER BY id DESC
    ");
    $stmtConq->execute([':uid' => $usuarioId]);
    $conquistas = $stmtConq->fetchAll();

    echo json_encode([
        'sucesso' => true,
        'stats' => [
            'total_certas'   => (int)$stats['total_certas'],
            'total_erradas'  => (int)$stats['total_erradas'],
            'media_precisao' => round((float)$stats['media_precisao'], 1),
            'max_ppm'        => (int)$stats['max_ppm'],
            'total_pontos'   => (int)$stats['total_pontos'],
            'total_sessoes'  => (int)$stats['total_sessoes']
        ],
        'conquistas' => $conquistas
    ]);

} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro: ' . $e->getMessage()]);
}
