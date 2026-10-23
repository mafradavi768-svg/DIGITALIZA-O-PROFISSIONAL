<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Escola do Teclado: Lições Passo a Passo do Zero
 * Ensina a digitar como um profissional: postura, teclas guias F e J, e mãos.
 */

$pageTitle = "Escola do Teclado - Digitalização Profissional";
$activeNav = "licoes";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/backend/auth_check.php';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-20">

    <!-- Cabeçalho das Lições -->
    <div class="text-center max-w-3xl mx-auto mb-10">
        <div class="yellow-moon inline-block mb-3" style="width: 64px; height: 64px;"></div>
        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
            Escola do Teclado: Aprenda do Zero
        </h1>
        <p class="text-slate-300 text-base sm:text-lg mt-3 leading-relaxed">
            Esqueça o medo do computador. Você vai aprender a técnica usada por digitadores e secretários profissionais há mais de 100 anos, com calma e paciência.
        </p>
    </div>

    <!-- Módulo 1: O Segredo Número 1 (As Teclas F e J com Relevo) -->
    <div class="mb-10 p-6 sm:p-10 rounded-3xl card-night border-2 border-yellow-500/50 shadow-2xl space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
            <div class="flex items-center gap-3">
                <span class="text-4xl">🔎</span>
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-moon-400">Lição 1 • O Segredo Tátil</span>
                    <h2 class="text-2xl font-black text-white">As Teclas Guia: Letras F e J</h2>
                </div>
            </div>
            <button type="button" class="btn-narrar-instrucao inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-yellow-300 text-xs font-bold border border-slate-700 transition" data-falar-alvo="texto-licao-1">
                <span>🔊</span> Ouvir Lição
            </button>
        </div>

        <div id="texto-licao-1" class="text-slate-200 text-base sm:text-lg leading-relaxed space-y-4">
            <p>
                Você sabia que o seu teclado físico tem um "segredo" invisível? Passe a ponta do seu dedo indicador sobre a letra <strong class="text-yellow-300">F</strong> e depois sobre a letra <strong class="text-yellow-300">J</strong>.
            </p>
            <p>
                Sentiu um <strong>pequeno risquinho ou relevo elevado</strong>? Todos os teclados do mundo têm isso! Esse relevo serve para que você possa posicionar seus dedos no lugar certo <strong>sem precisar olhar para as teclas</strong>.
            </p>
        </div>

        <!-- Ilustração Visual da Casa dos Dedos -->
        <div class="bg-indigo-950/70 p-6 rounded-2xl border border-indigo-900 grid grid-cols-1 md:grid-cols-2 gap-6 text-center sm:text-left">
            <div class="space-y-2">
                <h3 class="text-base font-bold text-emerald-400 flex items-center justify-center sm:justify-start gap-2">
                    <span>✋</span> Mão Esquerda (Descansa em A - S - D - F)
                </h3>
                <ul class="text-sm text-slate-300 space-y-1">
                    <li>• <strong>Mindinho:</strong> Letra <span class="text-yellow-300 font-bold">A</span></li>
                    <li>• <strong>Anelar:</strong> Letra <span class="text-yellow-300 font-bold">S</span></li>
                    <li>• <strong>Médio:</strong> Letra <span class="text-yellow-300 font-bold">D</span></li>
                    <li>• <strong>Indicador:</strong> Letra <span class="text-yellow-300 font-bold">F</span> (onde fica o relevo!)</li>
                </ul>
            </div>

            <div class="space-y-2">
                <h3 class="text-base font-bold text-cyan-400 flex items-center justify-center sm:justify-start gap-2">
                    <span>🤚</span> Mão Direita (Descansa em J - K - L - Ç)
                </h3>
                <ul class="text-sm text-slate-300 space-y-1">
                    <li>• <strong>Indicador:</strong> Letra <span class="text-yellow-300 font-bold">J</span> (onde fica o relevo!)</li>
                    <li>• <strong>Médio:</strong> Letra <span class="text-yellow-300 font-bold">K</span></li>
                    <li>• <strong>Anelar:</strong> Letra <span class="text-yellow-300 font-bold">L</span></li>
                    <li>• <strong>Mindinho:</strong> Letra <span class="text-yellow-300 font-bold">Ç</span></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Módulo 2: Postura e Conforto para Idosos -->
    <div class="mb-10 p-6 sm:p-10 rounded-3xl card-night border border-indigo-900/80 shadow-2xl space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
            <div class="flex items-center gap-3">
                <span class="text-4xl">🪑</span>
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-moon-400">Lição 2 • Saúde e Conforto</span>
                    <h2 class="text-2xl font-black text-white">Postura Correta para Não Sentir Dor</h2>
                </div>
            </div>
            <button type="button" class="btn-narrar-instrucao inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-yellow-300 text-xs font-bold border border-slate-700 transition" data-falar-alvo="texto-licao-2">
                <span>🔊</span> Ouvir Lição
            </button>
        </div>

        <div id="texto-licao-2" class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-slate-300">
            <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-2">
                <span class="text-3xl block">👣</span>
                <strong class="text-white block text-base">Pés Firmes no Chão</strong>
                <p>Mantenha os dois pés apoiados no chão. Se sua cadeira for alta, coloque um banquinho ou almofada sob os pés.</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-2">
                <span class="text-3xl block">🤲</span>
                <strong class="text-white block text-base">Pulsos Flutuantes</strong>
                <p>Não apoie a palma da mão na mesa com força enquanto digita. Imagine que suas mãos estão flutuando suavemente como as nuvens da noite.</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-2">
                <span class="text-3xl block">👀</span>
                <strong class="text-white block text-base">Distância dos Olhos</strong>
                <p>A tela deve ficar a cerca de um braço de distância dos seus olhos. Use os botões A+ no topo do site sempre que precisar aumentar as letras!</p>
            </div>
        </div>
    </div>

    <!-- Módulo 3: Prática Guiada da Linha Base -->
    <div class="p-6 sm:p-10 rounded-3xl bg-gradient-to-br from-indigo-950/80 via-night-900 to-indigo-950 border-2 border-indigo-900/90 shadow-2xl text-center space-y-6">
        <span class="text-5xl block">☁️</span>
        <h2 class="text-2xl sm:text-3xl font-black text-white">
            Agora é hora de praticar nas nuvens da lua amarela!
        </h2>
        <p class="text-slate-300 text-base max-w-xl mx-auto">
            Não se preocupe em ser rápido. A velocidade vem com o tempo, o mais importante agora é a confiança de acertar cada tecla.
        </p>

        <div class="pt-2">
            <a href="treino_nuvens.php" class="btn-accessible bg-gradient-to-r from-moon-400 to-amber-500 text-slate-950 hover:from-moon-300 hover:to-amber-400 font-black text-xl px-10 py-4 rounded-2xl shadow-xl shadow-yellow-500/25">
                <span>🚀</span>
                <span>Ir para o Treino das Palavras Flutuantes</span>
            </a>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
