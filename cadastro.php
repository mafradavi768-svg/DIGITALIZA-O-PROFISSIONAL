<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Tela de Cadastro de Aluno
 * 
 * Regras do Core:
 * - Pergunta obrigatória do nível de digitação.
 * - Regra de bloqueio de re-cadastro explícita.
 * - Design de noite azul escuro com lua amarela.
 */

$pageTitle = "Cadastro de Aluno - Digitalização Profissional";
$activeNav = "cadastro";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/backend/auth_check.php';

// Se já estiver logado, redireciona para o painel
if (estaLogado()) {
    header('Location: painel.php');
    exit;
}

$erros = $_SESSION['cadastro_erros'] ?? [];
$dados = $_SESSION['cadastro_dados'] ?? [];
unset($_SESSION['cadastro_erros']);
unset($_SESSION['cadastro_dados']);
?>

<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto relative z-20">

    <!-- Lua Amarela Decorativa Superior -->
    <div class="text-center mb-6">
        <div class="yellow-moon" style="width: 72px; height: 72px;"></div>
        <h1 class="text-3xl sm:text-4xl font-black text-white mt-4">
            Inscrição na Turma de Digitação
        </h1>
        <p class="text-slate-300 text-sm sm:text-base mt-2">
            Preencha seus dados para começar do zero sua jornada sob a lua amarela.
        </p>

        <!-- Botão de Acessibilidade: Leitor por Voz -->
        <button type="button" class="btn-narrar-instrucao mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 text-yellow-300 text-xs font-semibold border border-slate-700 transition" data-falar-alvo="aviso-regra-cadastro">
            <span>🔊</span>
            <span>Ouvir orientações deste formulário</span>
        </button>
    </div>

    <!-- Regra de Negócio CORE em Destaque Visual Acolhedor -->
    <div id="aviso-regra-cadastro" class="mb-6 p-4 rounded-2xl bg-amber-500/10 border-2 border-yellow-500/50 text-yellow-200 text-sm leading-relaxed flex items-start gap-3 shadow-lg">
        <span class="text-2xl mt-0.5">⚠️</span>
        <div>
            <strong class="block text-yellow-300 font-bold text-base mb-1">Atenção à Regra de Cadastro Único:</strong>
            Conforme as regras do nosso sistema, <strong>cada pessoa só pode se cadastrar uma única vez</strong>. 
            Você não terá o direito de criar novos cadastros após se registrar. Guarde bem seu e-mail e senha para acessar seus treinos sempre que desejar!
        </div>
    </div>

    <!-- Mensagens de Erro / Bloqueio -->
    <?php if (!empty($erros)): ?>
        <div class="mb-6 p-4 rounded-2xl bg-red-950/80 border-2 border-red-700 text-red-200 text-sm space-y-2 shadow-xl">
            <div class="font-bold text-red-300 text-base flex items-center gap-2">
                <span>🛑</span>
                <span>Por favor, verifique as seguintes informações:</span>
            </div>
            <ul class="list-disc list-inside space-y-1">
                <?php foreach ($erros as $erro): ?>
                    <li><?= htmlspecialchars($erro) ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="pt-2 text-right">
                <a href="login.php" class="inline-flex items-center gap-1.5 text-xs font-bold text-yellow-300 hover:underline">
                    Já tem cadastro? Clique aqui para Entrar ➔
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Formulário de Cadastro Noturno -->
    <div class="p-6 sm:p-10 rounded-3xl card-night border border-indigo-900/80 shadow-2xl">
        <form action="backend/auth_register.php" method="POST" class="space-y-6">
            
            <!-- Campo: Nome Completo -->
            <div>
                <label for="nome" class="block text-sm sm:text-base font-bold text-white mb-2">
                    1. Como você gostaria de ser chamado(a)? *
                </label>
                <input 
                    type="text" 
                    id="nome" 
                    name="nome" 
                    required 
                    value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                    placeholder="Ex: Dona Maria, Seu João ou seu nome completo"
                    class="w-full px-4 py-3.5 rounded-xl bg-slate-900/90 border-2 border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-moon-400 focus:ring-2 focus:ring-moon-400/30 text-base transition"
                >
            </div>

            <!-- Campo: E-mail (Identificador Único) -->
            <div>
                <label for="email" class="block text-sm sm:text-base font-bold text-white mb-2">
                    2. Seu melhor endereço de E-mail *
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required 
                    value="<?= htmlspecialchars($dados['email'] ?? '') ?>"
                    placeholder="Exemplo: seu.nome@gmail.com"
                    class="w-full px-4 py-3.5 rounded-xl bg-slate-900/90 border-2 border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-moon-400 focus:ring-2 focus:ring-moon-400/30 text-base transition"
                >
                <p class="text-xs text-slate-400 mt-1.5">
                    🔒 Este e-mail será sua chave de acesso permanente e não poderá ser cadastrado de novo.
                </p>
            </div>

            <!-- Campo: Senha com Opção de Mostrar Senha -->
            <div>
                <label for="senha" class="block text-sm sm:text-base font-bold text-white mb-2">
                    3. Crie uma Senha Fácil de Lembrar *
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="senha" 
                        name="senha" 
                        required 
                        placeholder="Pelo menos 4 letras ou números"
                        class="w-full px-4 py-3.5 rounded-xl bg-slate-900/90 border-2 border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-moon-400 focus:ring-2 focus:ring-moon-400/30 text-base transition pr-14"
                    >
                    <button 
                        type="button" 
                        id="btn-toggle-senha" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-slate-400 hover:text-moon-400 text-sm font-semibold transition"
                        title="Ver o que estou digitando"
                    >
                        👁️ Ver
                    </button>
                </div>
            </div>

            <!-- REGRA DE NEGÓCIO CORE: Pergunta Obrigatória do Nível de Digitação -->
            <div class="pt-2">
                <label class="block text-base sm:text-lg font-black text-moon-400 mb-2">
                    4. Qual é o seu nível atual de digitação? *
                </label>
                <p class="text-xs sm:text-sm text-slate-300 mb-4">
                    Seja muito sincero(a)! Nós adaptaremos o tamanho das palavras e a velocidade das nuvens ao seu ritmo:
                </p>

                <?php 
                $nivelSel = $dados['nivel_digitacao'] ?? 'iniciante_zero'; 
                ?>

                <div class="space-y-3">
                    
                    <!-- Opção 1: Zero absoluto -->
                    <label class="flex items-start p-4 rounded-2xl border-2 cursor-pointer transition <?= $nivelSel === 'iniciante_zero' ? 'border-moon-400 bg-indigo-950/70' : 'border-slate-800 bg-slate-900/60 hover:border-slate-700' ?>">
                        <input type="radio" name="nivel_digitacao" value="iniciante_zero" class="mt-1 mr-3 h-5 w-5 accent-yellow-400" <?= $nivelSel === 'iniciante_zero' ? 'checked' : '' ?> required>
                        <div>
                            <span class="block font-bold text-white text-base">🟢 Iniciante do Zero (Nunca digitei)</span>
                            <span class="block text-xs sm:text-sm text-slate-300 mt-0.5">
                                Não sei onde ficam as teclas, nunca usei teclado ou tenho muita dificuldade para encontrar as letras.
                            </span>
                        </div>
                    </label>

                    <!-- Opção 2: Básico / Catando Milho -->
                    <label class="flex items-start p-4 rounded-2xl border-2 cursor-pointer transition <?= $nivelSel === 'iniciante_catando' ? 'border-moon-400 bg-indigo-950/70' : 'border-slate-800 bg-slate-900/60 hover:border-slate-700' ?>">
                        <input type="radio" name="nivel_digitacao" value="iniciante_catando" class="mt-1 mr-3 h-5 w-5 accent-yellow-400" <?= $nivelSel === 'iniciante_catando' ? 'checked' : '' ?>>
                        <div>
                            <span class="block font-bold text-white text-base">🟡 Básico (Digito catando milho)</span>
                            <span class="block text-xs sm:text-sm text-slate-300 mt-0.5">
                                Digito devagarinho usando apenas um ou dois dedos e preciso ficar olhando para as teclas o tempo todo.
                            </span>
                        </div>
                    </label>

                    <!-- Opção 3: Intermediário / Em Evolução -->
                    <label class="flex items-start p-4 rounded-2xl border-2 cursor-pointer transition <?= $nivelSel === 'intermediario' ? 'border-moon-400 bg-indigo-950/70' : 'border-slate-800 bg-slate-900/60 hover:border-slate-700' ?>">
                        <input type="radio" name="nivel_digitacao" value="intermediario" class="mt-1 mr-3 h-5 w-5 accent-yellow-400" <?= $nivelSel === 'intermediario' ? 'checked' : '' ?>>
                        <div>
                            <span class="block font-bold text-white text-base">🔵 Em Evolução (Conheço algumas teclas)</span>
                            <span class="block text-xs sm:text-sm text-slate-300 mt-0.5">
                                Já sei onde estão a maioria das letras, mas quero aprender a posicionar os dedos certos sem me cansar.
                            </span>
                        </div>
                    </label>

                    <!-- Opção 4: Praticante / Avançado -->
                    <label class="flex items-start p-4 rounded-2xl border-2 cursor-pointer transition <?= $nivelSel === 'avancado' ? 'border-moon-400 bg-indigo-950/70' : 'border-slate-800 bg-slate-900/60 hover:border-slate-700' ?>">
                        <input type="radio" name="nivel_digitacao" value="avancado" class="mt-1 mr-3 h-5 w-5 accent-yellow-400" <?= $nivelSel === 'avancado' ? 'checked' : '' ?>>
                        <div>
                            <span class="block font-bold text-white text-base">🟣 Praticante (Quero velocidade profissional)</span>
                            <span class="block text-xs sm:text-sm text-slate-300 mt-0.5">
                                Quero aumentar a agilidade, digitar textos longos sem erros e sem olhar para o teclado.
                            </span>
                        </div>
                    </label>

                </div>
            </div>

            <!-- Botão de Concluir Inscrição -->
            <div class="pt-4">
                <button 
                    type="submit" 
                    class="btn-accessible w-full bg-gradient-to-r from-moon-400 to-amber-500 hover:from-moon-300 hover:to-amber-400 text-slate-950 font-black text-xl py-4 rounded-2xl shadow-xl shadow-yellow-500/25 cursor-pointer"
                >
                    <span>🌕</span>
                    <span>Concluir Meu Cadastro & Iniciar Treino</span>
                </button>
            </div>

            <!-- Link para quem já tem cadastro -->
            <div class="text-center pt-2">
                <p class="text-sm text-slate-400">
                    Já realizou seu cadastro anteriormente? 
                    <a href="login.php" class="text-moon-400 hover:underline font-bold ml-1">
                        Acesse sua conta aqui ➔
                    </a>
                </p>
            </div>

        </form>
    </div>

</section>

<script>
    // Revelar / Ocultar Senha para facilitar a vida de idosos
    const btnToggle = document.getElementById('btn-toggle-senha');
    const inputSenha = document.getElementById('senha');
    if (btnToggle && inputSenha) {
        btnToggle.addEventListener('click', () => {
            if (inputSenha.type === 'password') {
                inputSenha.type = 'text';
                btnToggle.innerText = '🙈 Ocultar';
            } else {
                inputSenha.type = 'password';
                btnToggle.innerText = '👁️ Ver';
            }
        });
    }

    // Estilizar o rádio selecionado interativamente
    document.querySelectorAll('input[name="nivel_digitacao"]').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('input[name="nivel_digitacao"]').forEach(r => {
                r.closest('label').classList.remove('border-moon-400', 'bg-indigo-950/70');
                r.closest('label').classList.add('border-slate-800', 'bg-slate-900/60');
            });
            if (radio.checked) {
                radio.closest('label').classList.add('border-moon-400', 'bg-indigo-950/70');
                radio.closest('label').classList.remove('border-slate-800', 'bg-slate-900/60');
            }
        });
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
