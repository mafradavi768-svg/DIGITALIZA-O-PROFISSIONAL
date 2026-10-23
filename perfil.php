<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Perfil do Aluno e Conquistas
 * Exibe medalhas, certificado honorífico e dados cadastrais.
 */

$pageTitle = "Meu Perfil e Medalhas - Digitalização Profissional";
$activeNav = "perfil";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/backend/auth_check.php';

exigirLogin();

$usuario = getUsuarioLogado();
$pdo = getDBConnection();
$usuarioId = $usuario['id'];

// Consulta dados completos do usuário
$stmtUser = $pdo->prepare("SELECT nome, email, nivel_digitacao, data_cadastro, ultimo_acesso FROM usuarios WHERE id = :uid");
$stmtUser->execute([':uid' => $usuarioId]);
$dadosUser = $stmtUser->fetch();

// Consulta conquistas desbloqueadas
$stmtConq = $pdo->prepare("SELECT codigo, titulo, descricao, icone, data_conquistada FROM conquistas WHERE usuario_id = :uid ORDER BY id ASC");
$stmtConq->execute([':uid' => $usuarioId]);
$conquistas = $stmtConq->fetchAll();

// Todas as medalhas possíveis do sistema para mostrar o que falta desbloquear
$todasMedalhas = [
    [
        'codigo' => 'primeiro_passo',
        'titulo' => 'Primeiro Passo no Céu Noturno',
        'descricao' => 'Cadastrou-se com sucesso e deu o primeiro passo para digitar como profissional.',
        'icone' => '🌕'
    ],
    [
        'codigo' => 'dez_palavras',
        'titulo' => 'Nuvem de Algodão',
        'descricao' => 'Completou mais de 10 palavras com sucesso no céu estrelado.',
        'icone' => '☁️'
    ],
    [
        'codigo' => 'mira_certeira',
        'titulo' => 'Brilho da Lua Dourada',
        'descricao' => 'Alcançou mais de 90% de precisão ao digitar as palavras flutuantes.',
        'icone' => '🌙'
    ],
    [
        'codigo' => 'dedos_ageis',
        'titulo' => 'Estrela Cadente',
        'descricao' => 'Atingiu 20 Palavras Por Minuto! Seus dedos estão voando pelo teclado.',
        'icone' => '⭐'
    ],
];

$conquistasCodigos = array_column($conquistas, 'codigo');
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-20">

    <!-- Cabeçalho do Perfil -->
    <div class="p-6 sm:p-8 rounded-3xl card-night border border-indigo-900/80 shadow-2xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5 text-center md:text-left">
            <div class="yellow-moon flex-shrink-0" style="width: 80px; height: 80px;"></div>
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-moon-400">Cartão de Membro Oficial</span>
                <h1 class="text-2xl sm:text-3xl font-black text-white mt-1">
                    <?= htmlspecialchars($dadosUser['nome'] ?? $usuario['nome']) ?>
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">
                    <?= htmlspecialchars($dadosUser['email'] ?? $usuario['email']) ?> • 
                    Membro desde: <strong class="text-white"><?= date('d/m/Y', strtotime($dadosUser['data_cadastro'] ?? 'now')) ?></strong>
                </p>
                <div class="mt-2 inline-block px-3 py-1 rounded-full bg-indigo-950 border border-indigo-700 text-xs font-bold text-yellow-300">
                    Nível Inicial: <?= formatarNivelDigitacao($dadosUser['nivel_digitacao'] ?? 'iniciante_zero') ?>
                </div>
            </div>
        </div>

        <a href="treino_nuvens.php" class="btn-accessible bg-gradient-to-r from-moon-400 to-amber-500 text-slate-950 font-black text-sm px-6 py-3 shadow-lg shadow-yellow-500/25">
            Continuar Prática ➔
        </a>
    </div>

    <!-- Seção de Medalhas e Conquistas Estelares -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-white flex items-center gap-2">
                    <span>🏆</span> Minhas Medalhas da Noite
                </h2>
                <p class="text-slate-400 text-xs sm:text-sm">
                    Medalhas conquistadas ao treinar nas palavras flutuantes e sob a lua amarela
                </p>
            </div>
            <span class="text-xs sm:text-sm font-bold text-moon-400 bg-indigo-950 px-3 py-1.5 rounded-xl border border-indigo-900">
                <?= count($conquistas) ?> de <?= count($todasMedalhas) ?> Conquistadas
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ($todasMedalhas as $m): 
                $desbloqueada = in_array($m['codigo'], $conquistasCodigos, true);
            ?>
                <div class="p-5 rounded-2xl border transition duration-300 flex flex-col justify-between <?= $desbloqueada ? 'bg-indigo-950/80 border-yellow-500/50 shadow-xl' : 'bg-slate-900/40 border-slate-800 opacity-50' ?>">
                    <div>
                        <div class="text-4xl mb-3 text-center sm:text-left">
                            <?= $desbloqueada ? $m['icone'] : '🔒' ?>
                        </div>
                        <h3 class="font-bold text-base <?= $desbloqueada ? 'text-white' : 'text-slate-400' ?> mb-1">
                            <?= $m['titulo'] ?>
                        </h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            <?= $m['descricao'] ?>
                        </p>
                    </div>

                    <div class="pt-4 mt-3 border-t border-slate-800/80 text-right">
                        <?php if ($desbloqueada): ?>
                            <span class="text-[11px] font-bold text-emerald-400 flex items-center justify-end gap-1">
                                <span>✓</span> Conquistada
                            </span>
                        <?php else: ?>
                            <span class="text-[11px] font-semibold text-slate-500">
                                Bloqueada
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Certificado Honorífico de Participação e Dedicação -->
    <div class="p-8 sm:p-12 rounded-3xl bg-gradient-to-b from-indigo-950 via-slate-900 to-indigo-950 border-4 border-yellow-500/40 shadow-2xl relative overflow-hidden text-center">
        
        <!-- Fundo de Lua Dourada Translúcida de Selo -->
        <div class="absolute -top-12 -right-12 opacity-15 pointer-events-none">
            <div class="yellow-moon" style="width: 220px; height: 220px;"></div>
        </div>

        <div class="max-w-2xl mx-auto space-y-4">
            <span class="text-xs uppercase tracking-widest text-moon-400 font-extrabold block">
                ★ CERTIFICADO DE DEDICAÇÃO E APRENDIZADO ★
            </span>

            <h3 class="text-2xl sm:text-4xl font-serif font-black text-white">
                Digitalização Profissional
            </h3>

            <p class="text-sm sm:text-base text-slate-300 leading-relaxed pt-2">
                Certificamos com imenso orgulho e carinho que
            </p>

            <div class="text-xl sm:text-3xl font-black text-yellow-300 font-serif border-b-2 border-yellow-500/40 pb-2 inline-block">
                <?= htmlspecialchars($dadosUser['nome'] ?? $usuario['nome']) ?>
            </div>

            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                está trilhando com coragem e maestria o caminho da digitação autônoma, 
                praticando a postura dos dedos e as palavras flutuantes sob o céu estrelado da lua amarela.
            </p>

            <div class="pt-6 flex items-center justify-center gap-2 text-xs text-slate-400">
                <span>Emitido em: <?= date('d/m/Y') ?></span>
                <span>•</span>
                <span>Código de Verificação: DIGIT-<?= str_pad((string)$usuarioId, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
