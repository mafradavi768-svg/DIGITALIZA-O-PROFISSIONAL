<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Tela do Jogo / Treinador Interativo:
 * "Palavras Flutuantes sobre as Nuvens da Noite da Lua Amarela"
 * Intuitivo, divertido e didático para pessoas idosas e iniciantes.
 */

$pageTitle = "Palavras Flutuantes nas Nuvens - Digitalização Profissional";
$activeNav = "nuvens";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/backend/auth_check.php';

$usuario = getUsuarioLogado();
$nivelUsuario = $usuario['nivel_digitacao'] ?? 'iniciante_zero';
$nomeUsuario = $usuario['nome'] ?? 'Amigo(a)';
$palavrasTreino = getPalavrasPorNivel($nivelUsuario);
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 relative z-20">

    <!-- Cabeçalho da Sala de Treino com a Lua Amarela -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-night-900/90 p-5 rounded-3xl border border-indigo-950 shadow-xl mb-6">
        <div class="flex items-center gap-4 text-center md:text-left">
            <div class="yellow-moon flex-shrink-0" style="width: 60px; height: 60px;"></div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-white">
                    Treino das Nuvens da Lua Amarela ☁️
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm">
                    Digite no seu teclado físico ou toque nas teclas virtuais para fazer as nuvens brilharem!
                </p>
            </div>
        </div>

        <!-- Seletor de Velocidade (Essencial para Idosos e Iniciantes) -->
        <div class="flex flex-wrap items-center justify-center gap-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Velocidade:</span>
            <button id="btn-vel-lento" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-yellow-500/30 text-yellow-300 border border-yellow-500/50 hover:bg-yellow-500/40 transition">
                🐢 Calmo (Iniciante)
            </button>
            <button id="btn-vel-normal" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700 hover:text-white transition">
                🚶 Normal
            </button>
            <button id="btn-vel-rapido" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700 hover:text-white transition">
                🚀 Ágil
            </button>
        </div>
    </div>

    <!-- Barra de Placar e Progresso em Tempo Real -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-6">
        
        <div class="p-4 rounded-2xl bg-indigo-950/60 border border-indigo-900/80 text-center shadow-lg">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-300 block mb-1">Palavras Certas</span>
            <span id="stat-certas" class="text-2xl sm:text-3xl font-black text-white">0</span>
        </div>

        <div class="p-4 rounded-2xl bg-indigo-950/60 border border-indigo-900/80 text-center shadow-lg">
            <span class="text-xs font-bold uppercase tracking-wider text-moon-400 block mb-1">Pontuação</span>
            <span id="stat-pontos" class="text-2xl sm:text-3xl font-black text-yellow-300">0</span>
        </div>

        <div class="p-4 rounded-2xl bg-indigo-950/60 border border-indigo-900/80 text-center shadow-lg">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-300 block mb-1">Precisão</span>
            <span id="stat-precisao" class="text-2xl sm:text-3xl font-black text-emerald-400">100%</span>
        </div>

        <div class="p-4 rounded-2xl bg-indigo-950/60 border border-indigo-900/80 text-center shadow-lg">
            <span class="text-xs font-bold uppercase tracking-wider text-cyan-300 block mb-1">Velocidade (PPM)</span>
            <span id="stat-ppm" class="text-2xl sm:text-3xl font-black text-cyan-400">0</span>
        </div>

    </div>

    <!-- ÁREA DO JOGO: O Céu Noturno Azul Escuro com a Lua Amarela e as Nuvens Flutuantes -->
    <div class="relative w-full h-[360px] sm:h-[420px] rounded-3xl bg-sky-night border-2 border-indigo-900/90 shadow-2xl overflow-hidden mb-6" id="sky-game-area">
        
        <!-- A Grande Lua Amarela no Céu do Jogo -->
        <div class="absolute top-6 right-8 sm:right-16 z-0 pointer-events-none">
            <div class="yellow-moon" style="width: 100px; height: 100px;"></div>
        </div>

        <!-- Instrução Inicial Flutuante -->
        <div id="instrucao-inicio" class="absolute inset-0 z-20 flex flex-col items-center justify-center p-6 text-center bg-night-950/70 backdrop-blur-sm">
            <span class="text-5xl mb-3">🌕</span>
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-2">
                Pronto para treinar sob a lua amarela?
            </h2>
            <p id="texto-regra-jogo" class="text-slate-200 text-sm sm:text-base max-w-lg mb-6 leading-relaxed">
                As nuvens vão atravessar o céu noturno com palavras. Quando uma letra estiver destacada, aperte a mesma tecla no teclado. Sem pressa, com tranquilidade!
            </p>
            <div class="flex flex-wrap gap-3 justify-center">
                <button id="btn-iniciar-jogo" class="btn-accessible bg-gradient-to-r from-moon-400 to-amber-500 text-slate-950 hover:from-moon-300 hover:to-amber-400 font-extrabold text-lg px-8 py-3.5 shadow-xl shadow-yellow-500/30">
                    Começar Treino Agora ✨
                </button>
                <button type="button" class="btn-narrar-instrucao px-4 py-3 rounded-xl bg-slate-800 text-yellow-300 border border-slate-700 text-sm font-semibold hover:bg-slate-700 transition" data-falar-alvo="texto-regra-jogo">
                    🔊 Ouvir Explicação
                </button>
            </div>
        </div>

    </div>

    <!-- Dica de Postura e Posição do Dedo Atual -->
    <div class="mb-4 p-4 rounded-2xl bg-indigo-950/80 border border-indigo-800/90 text-center flex flex-col sm:flex-row items-center justify-between gap-3 shadow-lg">
        <div class="flex items-center gap-2">
            <span class="text-xl">💡</span>
            <span id="dica-dedo-aluno" class="text-sm sm:text-base text-slate-200 font-medium">
                Pressione a primeira tecla da nuvem para começar.
            </span>
        </div>
        <div class="flex items-center gap-3">
            <button id="btn-pausar-jogo" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition">
                ⏸️ Pausar
            </button>
            <button id="btn-salvar-jogo" class="px-3.5 py-1.5 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white text-xs font-bold border border-emerald-600 transition shadow">
                💾 Salvar Progresso
            </button>
        </div>
    </div>

    <!-- TECLADO VIRTUAL INTERATIVO COM GUIA DE DEDOS (ABNT2 BRASILEIRO) -->
    <div class="p-4 sm:p-6 rounded-3xl card-night border border-indigo-900/80 shadow-2xl overflow-x-auto">
        <div class="flex items-center justify-between mb-4 border-b border-slate-800 pb-2">
            <div class="flex items-center gap-2">
                <span class="text-moon-400 font-bold text-sm sm:text-base">⌨️ Teclado Virtual de Apoio</span>
                <span class="text-xs text-slate-400 hidden sm:inline">(A tecla amarela mostra onde apertar!)</span>
            </div>
            
            <!-- Legenda das Cores dos Dedos -->
            <div class="hidden lg:flex items-center gap-3 text-[11px] text-slate-300">
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span> Mindinho</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Anelar</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Médio</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Indicador</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Polegar (Espaço)</span>
            </div>
        </div>

        <div class="min-w-[680px] space-y-2 select-none">
            
            <!-- Linha dos Números -->
            <div class="flex justify-center gap-1.5">
                <div class="virtual-key finger-pinky" data-key="'" data-dedo="Dedo mindinho" data-mao="Esquerda">'</div>
                <div class="virtual-key finger-pinky" data-key="1" data-dedo="Dedo mindinho" data-mao="Esquerda">1</div>
                <div class="virtual-key finger-ring" data-key="2" data-dedo="Dedo anelar" data-mao="Esquerda">2</div>
                <div class="virtual-key finger-middle" data-key="3" data-dedo="Dedo médio" data-mao="Esquerda">3</div>
                <div class="virtual-key finger-index-l" data-key="4" data-dedo="Dedo indicador" data-mao="Esquerda">4</div>
                <div class="virtual-key finger-index-l" data-key="5" data-dedo="Dedo indicador" data-mao="Esquerda">5</div>
                <div class="virtual-key finger-index-r" data-key="6" data-dedo="Dedo indicador" data-mao="Direita">6</div>
                <div class="virtual-key finger-index-r" data-key="7" data-dedo="Dedo indicador" data-mao="Direita">7</div>
                <div class="virtual-key finger-middle" data-key="8" data-dedo="Dedo médio" data-mao="Direita">8</div>
                <div class="virtual-key finger-ring" data-key="9" data-dedo="Dedo anelar" data-mao="Direita">9</div>
                <div class="virtual-key finger-pinky" data-key="0" data-dedo="Dedo mindinho" data-mao="Direita">0</div>
                <div class="virtual-key finger-pinky" data-key="-" data-dedo="Dedo mindinho" data-mao="Direita">-</div>
                <div class="virtual-key finger-pinky" data-key="=" data-dedo="Dedo mindinho" data-mao="Direita">=</div>
            </div>

            <!-- Linha Superior: Q W E R T Y U I O P -->
            <div class="flex justify-center gap-1.5">
                <div class="virtual-key finger-pinky" data-key="q" data-dedo="Dedo mindinho" data-mao="Esquerda">Q</div>
                <div class="virtual-key finger-ring" data-key="w" data-dedo="Dedo anelar" data-mao="Esquerda">W</div>
                <div class="virtual-key finger-middle" data-key="e" data-dedo="Dedo médio" data-mao="Esquerda">E</div>
                <div class="virtual-key finger-index-l" data-key="r" data-dedo="Dedo indicador" data-mao="Esquerda">R</div>
                <div class="virtual-key finger-index-l" data-key="t" data-dedo="Dedo indicador" data-mao="Esquerda">T</div>
                <div class="virtual-key finger-index-r" data-key="y" data-dedo="Dedo indicador" data-mao="Direita">Y</div>
                <div class="virtual-key finger-index-r" data-key="u" data-dedo="Dedo indicador" data-mao="Direita">U</div>
                <div class="virtual-key finger-middle" data-key="i" data-dedo="Dedo médio" data-mao="Direita">I</div>
                <div class="virtual-key finger-ring" data-key="o" data-dedo="Dedo anelar" data-mao="Direita">O</div>
                <div class="virtual-key finger-pinky" data-key="p" data-dedo="Dedo mindinho" data-mao="Direita">P</div>
            </div>

            <!-- Linha Base / Home Row (COM AS TECLAS GUIAS F E J COM RELEVO) -->
            <div class="flex justify-center gap-1.5">
                <div class="virtual-key finger-pinky" data-key="a" data-dedo="Dedo mindinho" data-mao="Esquerda">A</div>
                <div class="virtual-key finger-ring" data-key="s" data-dedo="Dedo anelar" data-mao="Esquerda">S</div>
                <div class="virtual-key finger-middle" data-key="d" data-dedo="Dedo médio" data-mao="Esquerda">D</div>
                <div class="virtual-key finger-index-l key-guide" data-key="f" data-dedo="Dedo indicador (Base Guia)" data-mao="Esquerda" title="Tecla Guia F">F</div>
                <div class="virtual-key finger-index-l" data-key="g" data-dedo="Dedo indicador" data-mao="Esquerda">G</div>
                <div class="virtual-key finger-index-r" data-key="h" data-dedo="Dedo indicador" data-mao="Direita">H</div>
                <div class="virtual-key finger-index-r key-guide" data-key="j" data-dedo="Dedo indicador (Base Guia)" data-mao="Direita" title="Tecla Guia J">J</div>
                <div class="virtual-key finger-middle" data-key="k" data-dedo="Dedo médio" data-mao="Direita">K</div>
                <div class="virtual-key finger-ring" data-key="l" data-dedo="Dedo anelar" data-mao="Direita">L</div>
                <div class="virtual-key finger-pinky" data-key="ç" data-dedo="Dedo mindinho" data-mao="Direita">Ç</div>
            </div>

            <!-- Linha Inferior: Z X C V B N M -->
            <div class="flex justify-center gap-1.5">
                <div class="virtual-key finger-pinky" data-key="z" data-dedo="Dedo mindinho" data-mao="Esquerda">Z</div>
                <div class="virtual-key finger-ring" data-key="x" data-dedo="Dedo anelar" data-mao="Esquerda">X</div>
                <div class="virtual-key finger-middle" data-key="c" data-dedo="Dedo médio" data-mao="Esquerda">C</div>
                <div class="virtual-key finger-index-l" data-key="v" data-dedo="Dedo indicador" data-mao="Esquerda">V</div>
                <div class="virtual-key finger-index-l" data-key="b" data-dedo="Dedo indicador" data-mao="Esquerda">B</div>
                <div class="virtual-key finger-index-r" data-key="n" data-dedo="Dedo indicador" data-mao="Direita">N</div>
                <div class="virtual-key finger-index-r" data-key="m" data-dedo="Dedo indicador" data-mao="Direita">M</div>
                <div class="virtual-key finger-middle" data-key="," data-dedo="Dedo médio" data-mao="Direita">,</div>
                <div class="virtual-key finger-ring" data-key="." data-dedo="Dedo anelar" data-mao="Direita">.</div>
            </div>

            <!-- Barra de Espaço dos Polegares -->
            <div class="flex justify-center pt-1">
                <div class="virtual-key finger-thumb !min-w-[320px]" data-key=" " data-dedo="Dedo polegar (Ambas as mãos)" data-mao="Polegares">
                    BARRA DE ESPAÇO
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Inclusão da Lógica do Jogo -->
<script src="assets/js/nuvens_game.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const palavrasArray = <?= json_encode($palavrasTreino, JSON_UNESCAPED_UNICODE) ?>;
        const nivelAtual = <?= json_encode($nivelUsuario) ?>;

        let jogo = null;
        let velocidadeAtual = 'lento';

        const btnIniciar = document.getElementById('btn-iniciar-jogo');
        const modalInicio = document.getElementById('instrucao-inicio');
        const btnPausar = document.getElementById('btn-pausar-jogo');
        const btnSalvar = document.getElementById('btn-salvar-jogo');

        btnIniciar?.addEventListener('click', () => {
            modalInicio.classList.add('hidden');
            jogo = new NuvensGame({
                palavras: palavrasArray,
                nivel: nivelAtual,
                velocidade: velocidadeAtual
            });
        });

        // Controles de Velocidade
        const botoesVel = [
            { id: 'btn-vel-lento', val: 'lento' },
            { id: 'btn-vel-normal', val: 'normal' },
            { id: 'btn-vel-rapido', val: 'rapido' }
        ];

        botoesVel.forEach(item => {
            document.getElementById(item.id)?.addEventListener('click', () => {
                velocidadeAtual = item.val;
                botoesVel.forEach(b => {
                    const el = document.getElementById(b.id);
                    el.className = (b.val === item.val) 
                        ? 'px-3 py-1.5 rounded-xl text-xs font-bold bg-yellow-500/30 text-yellow-300 border border-yellow-500/50' 
                        : 'px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700';
                });

                if (jogo) {
                    jogo.velocidade = velocidadeAtual;
                    jogo.configurarVelocidade();
                }
            });
        });

        // Botão de Pausar / Retomar
        btnPausar?.addEventListener('click', () => {
            if (!jogo) return;
            jogo.pausado = !jogo.pausado;
            btnPausar.innerText = jogo.pausado ? '▶️ Continuar' : '⏸️ Pausar';
        });

        // Botão de Salvar Manual
        btnSalvar?.addEventListener('click', async () => {
            if (!jogo) return;
            btnSalvar.innerText = 'Salvando...';
            await jogo.salvarProgressoServidor();
            btnSalvar.innerText = '✅ Salvo com Sucesso!';
            setTimeout(() => btnSalvar.innerText = '💾 Salvar Progresso', 2500);
        });

        // Salva automaticamente ao sair da página
        window.addEventListener('beforeunload', () => {
            if (jogo) jogo.salvarProgressoServidor();
        });
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
