<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Página Inicial (Landing Page & Apresentação)
 * Design: Noite Azul Escuro com Lua Amarela, nuvens flutuantes e foco na terceira idade.
 */

$pageTitle = "Digitalização Profissional - Aprenda a Digitar do Zero com a Lua Amarela";
$activeNav = "inicio";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/backend/auth_check.php';

$usuario = getUsuarioLogado();
?>

<!-- Seção Hero: O Céu Noturno, a Grande Lua Amarela e as Nuvens Flutuantes -->
<section class="relative min-h-[85vh] flex items-center justify-center px-4 sm:px-6 lg:px-8 py-16 overflow-hidden">
    <!-- Lua Amarela Centralizada/Em Destaque -->
    <div class="absolute top-12 right-6 sm:right-24 md:right-36 lg:right-48 z-10 pointer-events-none opacity-90 sm:opacity-100">
        <div class="yellow-moon yellow-moon-large"></div>
    </div>

    <!-- Nuvens Noturnas Decorativas Flutuantes de Fundo -->
    <div class="absolute top-28 left-6 md:left-20 night-cloud opacity-40 px-12 py-5 hidden sm:block animate-pulse pointer-events-none">
        <span class="text-slate-800 font-bold text-sm tracking-widest">☁️ serenidade</span>
    </div>

    <div class="absolute bottom-24 right-10 md:right-32 night-cloud opacity-30 px-16 py-6 hidden md:block pointer-events-none">
        <span class="text-slate-800 font-bold text-sm tracking-widest">☁️ paciência</span>
    </div>

    <div class="max-w-4xl mx-auto text-center relative z-20 space-y-8">
        
        <!-- Emblema de Acolhimento -->
        <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-indigo-900/60 border border-yellow-500/40 text-yellow-300 text-sm sm:text-base font-semibold shadow-lg shadow-indigo-950">
            <span>✨</span>
            <span>Especialmente desenhado para quem nunca tocou no teclado</span>
        </div>

        <!-- Título Principal com Alto Contraste para Idosos -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
            Aprenda a digitar do zero <br class="hidden sm:inline">
            sob a serenidade da <br class="hidden sm:inline">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-moon-300 via-yellow-400 to-amber-400">
                Lua Amarela da Noite
            </span>
        </h1>

        <!-- Subtítulo Acessível e Carinhoso com Botão de Narração de Voz -->
        <div class="relative max-w-2xl mx-auto">
            <p id="texto-apresentacao" class="text-lg sm:text-2xl text-slate-200 font-normal leading-relaxed">
                Você não precisa mais pedir ajuda aos filhos ou netos para mandar mensagens no computador. 
                Aqui você aprende com calma, teclas guiadas e um jogo relaxante de 
                <strong class="text-yellow-300">palavras flutuantes nas nuvens</strong>.
            </p>

            <!-- Botão de Acessibilidade: Ouvir o Texto Falado em Voz Alta -->
            <button type="button" class="btn-narrar-instrucao mt-3 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 text-yellow-300 text-xs sm:text-sm font-semibold border border-slate-700 transition" data-falar-alvo="texto-apresentacao">
                <span>🔊</span>
                <span>Ouvir este texto em voz alta</span>
            </button>
        </div>

        <!-- Chamadas de Ação Principais (Botões Grandes) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <?php if ($usuario): ?>
                <a href="treino_nuvens.php" class="btn-accessible w-full sm:w-auto bg-gradient-to-r from-moon-400 to-amber-500 text-slate-950 hover:from-moon-300 hover:to-amber-400 font-black text-xl shadow-xl shadow-yellow-500/30">
                    <span>☁️</span>
                    <span>Continuar Treino nas Nuvens</span>
                </a>
                <a href="painel.php" class="btn-accessible w-full sm:w-auto bg-night-800 hover:bg-night-700 text-white border-2 border-indigo-700 font-bold text-lg">
                    <span>📊</span>
                    <span>Ver Meu Progresso</span>
                </a>
            <?php else: ?>
                <a href="cadastro.php" class="btn-accessible w-full sm:w-auto bg-gradient-to-r from-moon-400 to-amber-500 text-slate-950 hover:from-moon-300 hover:to-amber-400 font-black text-xl shadow-xl shadow-yellow-500/30">
                    <span>🌕</span>
                    <span>Criar Meu Cadastro Único</span>
                </a>
                <a href="treino_nuvens.php" class="btn-accessible w-full sm:w-auto bg-night-800 hover:bg-night-700 text-moon-300 border-2 border-yellow-500/40 font-bold text-lg">
                    <span>☁️</span>
                    <span>Experimentar o Jogo das Nuvens</span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Mini Demonstração Interativa das Nuvens -->
        <div class="mt-12 p-6 rounded-3xl card-night border border-indigo-900/80 max-w-2xl mx-auto shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-moon-400 flex items-center gap-2">
                    <span>🎮</span> Como funciona o aprendizado:
                </span>
                <span class="text-xs text-slate-400">100% Intuitivo & Sem Pressa</span>
            </div>
            
            <div class="flex flex-wrap items-center justify-around gap-4 text-center">
                <div class="flex flex-col items-center">
                    <span class="text-3xl mb-1">☁️</span>
                    <span class="text-xs font-semibold text-slate-300">1. A Nuvem Surge</span>
                    <span class="text-[11px] text-slate-400">Palavras do cotidiano</span>
                </div>
                <div class="text-moon-400 text-xl font-bold">➔</div>
                <div class="flex flex-col items-center">
                    <span class="text-3xl mb-1">⌨️</span>
                    <span class="text-xs font-semibold text-slate-300">2. Tecla Guiada</span>
                    <span class="text-[11px] text-slate-400">Dica visual de cada dedo</span>
                </div>
                <div class="text-moon-400 text-xl font-bold">➔</div>
                <div class="flex flex-col items-center">
                    <span class="text-3xl mb-1">🌕</span>
                    <span class="text-xs font-semibold text-slate-300">3. A Nuvem Brilha</span>
                    <span class="text-[11px] text-slate-400">Palavra sobe para a lua</span>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Seção: Por que nosso método funciona para pessoas mais velhas? -->
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-20">
    <div class="text-center max-w-3xl mx-auto mb-14">
        <h2 class="text-2xl sm:text-4xl font-extrabold text-white mb-4">
            Desenvolvido com todo o cuidado que você merece
        </h2>
        <p class="text-base sm:text-lg text-slate-300">
            Chega de letrinhas miúdas, cronômetros apressados e termos complicados em inglês. Nosso objetivo é fazer você digitar como um profissional, no seu próprio ritmo.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Card 1 -->
        <div class="p-8 rounded-3xl card-night border border-indigo-900/60 hover:border-yellow-500/50 transition duration-300 space-y-4">
            <div class="w-14 h-14 rounded-2xl bg-yellow-500/20 text-yellow-300 flex items-center justify-center text-3xl border border-yellow-500/40">
                🖐️
            </div>
            <h3 class="text-xl font-bold text-white">Posição Correta dos Dedos</h3>
            <p class="text-slate-300 text-sm leading-relaxed">
                Você vai aprender as famosas "teclas de descanso" (F e J) e como cada um dos dez dedos tem suas teclas certas, eliminando de vez o vício de "catar milho".
            </p>
            <a href="licoes.php" class="inline-flex items-center gap-1.5 text-moon-400 hover:text-moon-300 text-sm font-semibold pt-2">
                Ver lição dos dedos ➔
            </a>
        </div>

        <!-- Card 2 -->
        <div class="p-8 rounded-3xl card-night border border-indigo-900/60 hover:border-yellow-500/50 transition duration-300 space-y-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center text-3xl border border-indigo-500/40">
                ☁️
            </div>
            <h3 class="text-xl font-bold text-white">Nuvens Noturnas Flutuantes</h3>
            <p class="text-slate-300 text-sm leading-relaxed">
                Palavras suaves flutuam serenas no céu azul escuro. Você tem todo o tempo do mundo para ler e digitar cada letra, com sons calmos e reforço positivo.
            </p>
            <a href="treino_nuvens.php" class="inline-flex items-center gap-1.5 text-moon-400 hover:text-moon-300 text-sm font-semibold pt-2">
                Experimentar o jogo ➔
            </a>
        </div>

        <!-- Card 3 -->
        <div class="p-8 rounded-3xl card-night border border-indigo-900/60 hover:border-yellow-500/50 transition duration-300 space-y-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-3xl border border-emerald-500/40">
                🛡️
            </div>
            <h3 class="text-xl font-bold text-white">Cadastro Único e Seguro</h3>
            <p class="text-slate-300 text-sm leading-relaxed">
                Cada aluno possui um cadastro único e protegido. Ao se cadastrar, perguntamos seu nível inicial para personalizar seu treino do jeito certo.
            </p>
            <a href="cadastro.php" class="inline-flex items-center gap-1.5 text-moon-400 hover:text-moon-300 text-sm font-semibold pt-2">
                Criar cadastro ➔
            </a>
        </div>

    </div>
</section>

<!-- Seção: Regras de Ouro da Plataforma -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto relative z-20">
    <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-br from-indigo-950/80 to-slate-900 border-2 border-indigo-900/80 shadow-2xl space-y-6">
        <div class="flex items-center gap-4">
            <div class="yellow-moon" style="width: 48px; height: 48px;"></div>
            <div>
                <h3 class="text-2xl font-bold text-white">Nossa Promessa e Regras do Portal</h3>
                <p class="text-sm text-indigo-300">Transparência e respeito com nossos queridos alunos</p>
            </div>
        </div>

        <ul class="space-y-4 text-slate-200 text-sm sm:text-base">
            <li class="flex items-start gap-3">
                <span class="text-moon-400 font-bold text-lg mt-0.5">✓</span>
                <span><strong>Design de Noite com Lua Amarela:</strong> Escolhemos esse contraste escuro relaxante para não cansar a vista de quem passa tempo diante da tela.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-moon-400 font-bold text-lg mt-0.5">✓</span>
                <span><strong>Diagnóstico de Nível no Cadastro:</strong> Perguntamos como você se sente hoje (se nunca digitou ou se já conhece algumas letras) para iniciar na dificuldade ideal.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-moon-400 font-bold text-lg mt-0.5">✓</span>
                <span><strong>Inscrição Única:</strong> Conforme nossa política de compromisso, cada pessoa que se cadastrar não poderá criar novos cadastros duplicados com o mesmo e-mail, preservando seu histórico e medalhas intactos.</span>
            </li>
        </ul>

        <div class="pt-4 text-center">
            <a href="cadastro.php" class="btn-accessible bg-moon-400 hover:bg-moon-300 text-slate-950 font-black text-lg px-8 py-3 rounded-2xl shadow-lg shadow-yellow-500/20">
                Quero Aprender a Digitar Como um Profissional ✨
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
