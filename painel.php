<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Painel Principal do Aluno
 * Exibe progresso, trilhas de aprendizagem e histórico do aluno.
 */

$pageTitle = "Meu Painel - Digitalização Profissional";
$activeNav = "painel";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/backend/auth_check.php';

exigirLogin();

$usuario = getUsuarioLogado();
$mensagemSucesso = $_SESSION['mensagem_sucesso'] ?? null;
unset($_SESSION['mensagem_sucesso']);

$pdo = getDBConnection();
$usuarioId = $usuario['id'];

// Consulta estatísticas do aluno no banco via PDO
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

// Consulta últimas 5 sessões de treino
$stmtHistorico = $pdo->prepare("
    SELECT modo, palavras_certas, precisao_pct, ppm, pontos, data_registro 
    FROM progresso_digitacao 
    WHERE usuario_id = :uid 
    ORDER BY id DESC 
    LIMIT 5
");
$stmtHistorico->execute([':uid' => $usuarioId]);
$historico = $stmtHistorico->fetchAll();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-20">

    <!-- Mensagem de Boas-Vindas / Sucesso -->
    <?php if ($mensagemSucesso): ?>
        <div class="mb-6 p-4 rounded-2xl bg-emerald-950/80 border-2 border-emerald-600 text-emerald-200 text-sm sm:text-base flex items-start gap-3 shadow-xl">
            <span class="text-2xl">🎉</span>
            <div><?= htmlspecialchars($mensagemSucesso) ?></div>
        </div>
    <?php endif; ?>

    <!-- Banner Superior do Aluno com a Lua Amarela -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-night-900 via-indigo-950 to-night-900 border-2 border-indigo-900/80 shadow-2xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5 text-center md:text-left">
            <div class="yellow-moon flex-shrink-0" style="width: 72px; height: 72px;"></div>
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-moon-400">Portal do Aluno</span>
                <h1 class="text-2xl sm:text-4xl font-black text-white mt-0.5">
                    Olá, <?= htmlspecialchars($usuario['nome']) ?>! 🌙
                </h1>
                <p class="text-sm sm:text-base text-slate-300 mt-1">
                    Nível Atual: <span class="text-yellow-300 font-bold"><?= formatarNivelDigitacao($usuario['nivel_digitacao']) ?></span>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="treino_nuvens.php" class="btn-accessible bg-gradient-to-r from-moon-400 to-amber-500 text-slate-950 hover:from-moon-300 hover:to-amber-400 font-extrabold text-base shadow-lg shadow-yellow-500/25">
                <span>☁️</span>
                <span>Treinar nas Nuvens</span>
            </a>
            <a href="licoes.php" class="btn-accessible bg-night-800 text-white border border-indigo-700 hover:bg-night-700 font-bold text-base">
                <span>⌨️</span>
                <span>Aulas do Teclado</span>
            </a>
        </div>
    </div>

    <!-- Indicadores de Progresso do Aluno -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        
        <div class="p-5 rounded-2xl card-night border border-indigo-900/70 text-center shadow-lg">
            <span class="text-3xl mb-1 block">☁️</span>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Palavras Acertadas</span>
            <span class="text-2xl sm:text-3xl font-black text-white"><?= (int)$stats['total_certas'] ?></span>
        </div>

        <div class="p-5 rounded-2xl card-night border border-indigo-900/70 text-center shadow-lg">
            <span class="text-3xl mb-1 block">🎯</span>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Média de Precisão</span>
            <span class="text-2xl sm:text-3xl font-black text-emerald-400"><?= round((float)$stats['media_precisao'], 1) ?>%</span>
        </div>

        <div class="p-5 rounded-2xl card-night border border-indigo-900/70 text-center shadow-lg">
            <span class="text-3xl mb-1 block">⚡</span>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Melhor Velocidade</span>
            <span class="text-2xl sm:text-3xl font-black text-cyan-400"><?= (int)$stats['max_ppm'] ?> <span class="text-xs font-normal text-slate-400">PPM</span></span>
        </div>

        <div class="p-5 rounded-2xl card-night border border-indigo-900/70 text-center shadow-lg">
            <span class="text-3xl mb-1 block">⭐</span>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Pontos Estelares</span>
            <span class="text-2xl sm:text-3xl font-black text-yellow-300"><?= (int)$stats['total_pontos'] ?></span>
        </div>

    </div>

    <!-- Trilhas Rápidas de Prática -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <!-- Cartão 1: Jogo das Nuvens -->
        <div class="p-6 rounded-3xl card-night border border-indigo-900/80 hover:border-yellow-500/40 transition duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-4xl">☁️</span>
                    <div>
                        <h3 class="text-xl font-bold text-white">Treino das Palavras Flutuantes</h3>
                        <p class="text-xs text-yellow-300 font-semibold">O jogo sob a luz da lua amarela</p>
                    </div>
                </div>
                <p class="text-sm text-slate-300 leading-relaxed mb-4">
                    As palavras passam suavemente pelas nuvens da noite. Digite as letras certas no seu ritmo para fazê-las subir até a lua e conquistar pontos estelares.
                </p>
            </div>
            <a href="treino_nuvens.php" class="btn-accessible bg-moon-400 hover:bg-moon-300 text-slate-950 font-bold text-sm w-full">
                Jogar Agora ➔
            </a>
        </div>

        <!-- Cartão 2: Lições Guiadas dos Dedos -->
        <div class="p-6 rounded-3xl card-night border border-indigo-900/80 hover:border-indigo-600 transition duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-4xl">🖐️</span>
                    <div>
                        <h3 class="text-xl font-bold text-white">Escola do Teclado: Dedos Certos</h3>
                        <p class="text-xs text-indigo-300 font-semibold">Aprenda a posição de descanso F e J</p>
                    </div>
                </div>
                <p class="text-sm text-slate-300 leading-relaxed mb-4">
                    Descubra o segredo dos digitadores profissionais: como apoiar os dedos na linha base sem olhar para baixo e sem cansar os pulsos.
                </p>
            </div>
            <a href="licoes.php" class="btn-accessible bg-night-800 hover:bg-night-700 text-white border border-indigo-700 font-bold text-sm w-full">
                Estudar Lições ➔
            </a>
        </div>

    </div>

    <!-- Tabela de Histórico Recente de Treinos -->
    <div class="p-6 rounded-3xl card-night border border-indigo-900/80 shadow-2xl">
        <div class="flex items-center justify-between mb-4 border-b border-slate-800 pb-3">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span>📋</span> Histórico das Suas Últimas Práticas
            </h3>
            <span class="text-xs text-slate-400">Total de sessões: <?= (int)$stats['total_sessoes'] ?></span>
        </div>

        <?php if (empty($historico)): ?>
            <div class="text-center py-8 text-slate-400">
                <span class="text-4xl block mb-2">🌙</span>
                <p class="text-base font-semibold">Você ainda não realizou nenhum treino.</p>
                <p class="text-xs text-slate-500 mt-1">Clique em "Treinar nas Nuvens" para começar a somar seus primeiros pontos!</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs uppercase bg-slate-900/80 text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">Data</th>
                            <th class="py-3 px-4">Modo</th>
                            <th class="py-3 px-4">Palavras Certas</th>
                            <th class="py-3 px-4">Precisão</th>
                            <th class="py-3 px-4">Velocidade</th>
                            <th class="py-3 px-4">Pontos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($historico as $h): ?>
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3 px-4 text-xs"><?= date('d/m/Y H:i', strtotime($h['data_registro'])) ?></td>
                                <td class="py-3 px-4 font-semibold text-white">☁️ Palavras nas Nuvens</td>
                                <td class="py-3 px-4 text-emerald-400 font-bold"><?= $h['palavras_certas'] ?></td>
                                <td class="py-3 px-4"><?= round($h['precisao_pct'], 1) ?>%</td>
                                <td class="py-3 px-4"><?= $h['ppm'] ?> PPM</td>
                                <td class="py-3 px-4 text-yellow-300 font-bold">+<?= $h['pontos'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
