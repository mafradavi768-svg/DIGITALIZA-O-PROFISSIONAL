<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Cabeçalho Global: Tema Noturno Azul Escuro com Lua Amarela
 * Otimizado para Mobile-First e Acessibilidade para Idosos
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$estaLogado = !empty($_SESSION['usuario_id']);
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Amigo(a)';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Digitalização Profissional - Aprenda a Digitar do Zero') ?></title>
    
    <!-- Tailwind CSS (Play CDN para facilidade e responsividade total) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        night: {
                            950: '#040817',
                            900: '#070f2b',
                            800: '#0d1b4a',
                            700: '#142a70',
                        },
                        moon: {
                            300: '#fef08a',
                            400: '#fde047',
                            500: '#eab308',
                            600: '#ca8a04',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Ícones e Fontes Legíveis -->
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="bg-night-950 text-slate-100 flex flex-col min-h-screen selection:bg-moon-400 selection:text-night-950">

    <!-- Céu Estrelado Fixo de Fundo -->
    <div class="stars-container"></div>

    <!-- Barra Superior de Acessibilidade (Especial para Pessoas Idosas) -->
    <div class="relative z-40 bg-slate-900/90 border-b border-slate-800 text-slate-300 text-sm py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="text-moon-400 text-base">👁️</span>
                <span class="font-medium text-xs sm:text-sm">Tamanho do texto:</span>
                <div class="inline-flex rounded-lg bg-slate-800 p-0.5 border border-slate-700">
                    <button id="btn-fonte-diminuir" class="px-2.5 py-1 text-xs hover:text-white rounded transition" title="Tamanho normal">A-</button>
                    <button id="btn-fonte-normal" class="px-2.5 py-1 text-sm font-semibold hover:text-white rounded transition" title="Tamanho grande">A</button>
                    <button id="btn-fonte-aumentar" class="px-2.5 py-1 text-base font-bold text-moon-400 hover:text-white rounded transition" title="Tamanho extra grande">A+</button>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Botão de Ativar/Desativar Sons -->
                <button onclick="window.somDigita && window.somDigita.toggleSom()" class="flex items-center gap-1.5 text-xs sm:text-sm hover:text-moon-400 transition" title="Efeitos de Som">
                    <span>🔊</span>
                    <span class="hidden sm:inline">Efeitos Sonoros</span>
                </button>

                <!-- Status de Login do Usuário -->
                <?php if ($estaLogado): ?>
                    <span class="text-xs sm:text-sm text-slate-400">
                        Olá, <strong class="text-moon-400"><?= htmlspecialchars($nomeUsuario) ?></strong>!
                    </span>
                    <a href="backend/auth_logout.php" class="text-xs bg-red-950/80 hover:bg-red-900 text-red-200 border border-red-800/80 px-2.5 py-1 rounded-md transition">
                        Sair 🚪
                    </a>
                <?php else: ?>
                    <div class="flex items-center gap-2 text-xs sm:text-sm">
                        <a href="login.php" class="hover:text-moon-400 transition font-medium">Entrar</a>
                        <span class="text-slate-600">|</span>
                        <a href="cadastro.php" class="text-moon-400 hover:underline font-bold">Criar Cadastro Grátis</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Navegação Principal com Logo da Lua Amarela da Noite -->
    <header class="relative z-30 bg-night-900/95 backdrop-blur-md border-b border-indigo-950/60 sticky top-0 shadow-lg shadow-black/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo: Noite Azul Escuro com a Lua Amarela -->
                <a href="index.php" class="flex items-center gap-3.5 group">
                    <div class="yellow-moon flex-shrink-0 transition-transform group-hover:scale-105" style="width: 50px; height: 50px;"></div>
                    <div>
                        <span class="block text-xl sm:text-2xl font-black tracking-tight text-white group-hover:text-moon-300 transition">
                            DIGITALIZA<span class="text-moon-400">ÇÃO</span>
                        </span>
                        <span class="block text-xs font-semibold uppercase tracking-widest text-indigo-300/80 -mt-1">
                            Aprenda do Zero como um Profissional
                        </span>
                    </div>
                </a>

                <!-- Menu de Navegação Desktop -->
                <nav class="hidden md:flex items-center gap-1.5 lg:gap-3">
                    <a href="index.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold hover:bg-night-800 hover:text-moon-400 transition <?= ($activeNav ?? '') === 'inicio' ? 'bg-night-800 text-moon-400 border border-indigo-900' : 'text-slate-300' ?>">
                        🏠 Início
                    </a>
                    
                    <a href="treino_nuvens.php" class="px-3.5 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-yellow-500/20 to-amber-500/20 text-moon-300 border border-yellow-500/40 hover:from-yellow-500/30 hover:to-amber-500/30 transition flex items-center gap-2 shadow-sm shadow-yellow-500/20 <?= ($activeNav ?? '') === 'nuvens' ? 'ring-2 ring-moon-400' : '' ?>">
                        <span>☁️</span> Palavras nas Nuvens
                    </a>

                    <a href="licoes.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold hover:bg-night-800 hover:text-moon-400 transition <?= ($activeNav ?? '') === 'licoes' ? 'bg-night-800 text-moon-400 border border-indigo-900' : 'text-slate-300' ?>">
                        ⌨️ Escola do Teclado
                    </a>

                    <?php if ($estaLogado): ?>
                        <a href="painel.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold hover:bg-night-800 hover:text-moon-400 transition <?= ($activeNav ?? '') === 'painel' ? 'bg-night-800 text-moon-400 border border-indigo-900' : 'text-slate-300' ?>">
                            📊 Meu Progresso
                        </a>
                        <a href="perfil.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold hover:bg-night-800 hover:text-moon-400 transition <?= ($activeNav ?? '') === 'perfil' ? 'bg-night-800 text-moon-400 border border-indigo-900' : 'text-slate-300' ?>">
                            🏆 Medalhas
                        </a>
                    <?php else: ?>
                        <a href="cadastro.php" class="ml-2 btn-accessible bg-gradient-to-r from-moon-400 to-amber-500 text-slate-950 hover:from-moon-300 hover:to-amber-400 font-extrabold text-sm !min-h-[44px] !py-2 !px-4 shadow-lg shadow-yellow-500/25">
                            Começar do Zero ✨
                        </a>
                    <?php endif; ?>
                </nav>

                <!-- Botão de Menu Mobile -->
                <div class="md:hidden flex items-center">
                    <button id="btn-mobile-menu" type="button" class="p-2.5 rounded-xl bg-night-800 border border-indigo-900 text-slate-200 hover:text-moon-400 focus:outline-none" aria-label="Abrir Menu">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menu Dropdown Mobile -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 pt-2 border-t border-indigo-950 flex flex-col gap-2">
                <a href="index.php" class="px-4 py-3 rounded-xl font-semibold hover:bg-night-800 text-slate-200 flex items-center gap-3">
                    <span>🏠</span> Início
                </a>
                <a href="treino_nuvens.php" class="px-4 py-3 rounded-xl font-bold bg-night-800/80 text-moon-300 border border-yellow-500/30 flex items-center gap-3">
                    <span>☁️</span> Palavras nas Nuvens (Divertido)
                </a>
                <a href="licoes.php" class="px-4 py-3 rounded-xl font-semibold hover:bg-night-800 text-slate-200 flex items-center gap-3">
                    <span>⌨️</span> Escola do Teclado (Posição dos Dedos)
                </a>
                <?php if ($estaLogado): ?>
                    <a href="painel.php" class="px-4 py-3 rounded-xl font-semibold hover:bg-night-800 text-slate-200 flex items-center gap-3">
                        <span>📊</span> Meu Painel de Estudos
                    </a>
                    <a href="perfil.php" class="px-4 py-3 rounded-xl font-semibold hover:bg-night-800 text-slate-200 flex items-center gap-3">
                        <span>🏆</span> Minhas Medalhas
                    </a>
                <?php else: ?>
                    <a href="login.php" class="px-4 py-3 rounded-xl font-semibold hover:bg-night-800 text-slate-200 flex items-center gap-3">
                        <span>🔑</span> Fazer Login
                    </a>
                    <a href="cadastro.php" class="px-4 py-3 rounded-xl font-bold bg-moon-400 text-slate-950 flex items-center justify-center gap-2">
                        Começar Meu Cadastro Grátis ✨
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script>
        // Toggle Menu Mobile
        document.getElementById('btn-mobile-menu')?.addEventListener('click', () => {
            const m = document.getElementById('mobile-menu');
            if (m) m.classList.toggle('hidden');
        });
    </script>

    <!-- Conteúdo Principal -->
    <main class="flex-grow relative z-10">
