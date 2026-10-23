<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Tela de Login / Acesso à Conta
 */

$pageTitle = "Acessar Minha Conta - Digitalização Profissional";
$activeNav = "login";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/backend/auth_check.php';

// Se já estiver logado, redireciona para o painel
if (estaLogado()) {
    header('Location: painel.php');
    exit;
}

$erroLogin = $_SESSION['login_erro'] ?? null;
$emailSalvo = $_SESSION['login_email'] ?? '';
$alertaLogin = $_SESSION['alerta_login'] ?? null;

unset($_SESSION['login_erro']);
unset($_SESSION['login_email']);
unset($_SESSION['alerta_login']);
?>

<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-md mx-auto relative z-20">

    <div class="text-center mb-8">
        <div class="yellow-moon" style="width: 70px; height: 70px;"></div>
        <h1 class="text-3xl font-black text-white mt-4">
            Acessar Minha Conta
        </h1>
        <p class="text-slate-300 text-sm mt-1">
            Entre para continuar seus treinos sob o luar estrelado.
        </p>
    </div>

    <!-- Alertas Informativos -->
    <?php if ($alertaLogin): ?>
        <div class="mb-6 p-4 rounded-2xl bg-indigo-950/90 border border-indigo-700 text-indigo-200 text-sm flex items-start gap-3 shadow-lg">
            <span class="text-xl">ℹ️</span>
            <div><?= htmlspecialchars($alertaLogin) ?></div>
        </div>
    <?php endif; ?>

    <!-- Alerta de Erro de Login -->
    <?php if ($erroLogin): ?>
        <div class="mb-6 p-4 rounded-2xl bg-red-950/90 border-2 border-red-700 text-red-200 text-sm flex items-start gap-3 shadow-lg">
            <span class="text-xl">⚠️</span>
            <div>
                <strong class="block text-red-300 font-bold mb-0.5">Não conseguimos entrar:</strong>
                <?= htmlspecialchars($erroLogin) ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Formulário Noturno de Login -->
    <div class="p-6 sm:p-8 rounded-3xl card-night border border-indigo-900/80 shadow-2xl">
        <form action="backend/auth_login.php" method="POST" class="space-y-5">
            
            <div>
                <label for="email" class="block text-sm font-bold text-white mb-2">
                    Seu E-mail Cadastrado
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required 
                    value="<?= htmlspecialchars($emailSalvo) ?>"
                    placeholder="seu.nome@exemplo.com"
                    class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border-2 border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-moon-400 focus:ring-2 focus:ring-moon-400/30 text-base transition"
                >
            </div>

            <div>
                <label for="senha" class="block text-sm font-bold text-white mb-2">
                    Sua Senha
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="senha" 
                        name="senha" 
                        required 
                        placeholder="Digite sua senha"
                        class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border-2 border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-moon-400 focus:ring-2 focus:ring-moon-400/30 text-base transition pr-14"
                    >
                    <button 
                        type="button" 
                        id="btn-toggle-senha" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-moon-400 text-sm font-semibold transition"
                    >
                        👁️ Ver
                    </button>
                </div>
            </div>

            <div class="pt-3">
                <button 
                    type="submit" 
                    class="btn-accessible w-full bg-gradient-to-r from-moon-400 to-amber-500 hover:from-moon-300 hover:to-amber-400 text-slate-950 font-black text-lg py-3.5 rounded-2xl shadow-xl shadow-yellow-500/20 cursor-pointer"
                >
                    <span>🔑</span>
                    <span>Entrar no Sistema</span>
                </button>
            </div>

            <div class="text-center pt-3 border-t border-slate-800">
                <p class="text-sm text-slate-400">
                    Ainda não possui sua inscrição?
                    <a href="cadastro.php" class="text-moon-400 hover:underline font-bold block sm:inline mt-1 sm:mt-0">
                        Cadastre-se grátis ➔
                    </a>
                </p>
            </div>

        </form>
    </div>

</section>

<script>
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
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
