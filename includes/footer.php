    </main>

    <!-- Rodapé Estelar Acolhedor -->
    <footer class="relative z-20 bg-night-950 border-t border-indigo-950/80 pt-12 pb-8 mt-16 text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Coluna 1: Propósito -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="yellow-moon" style="width: 38px; height: 38px;"></div>
                        <h3 class="text-lg font-bold text-white">Digitalização Profissional</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-300">
                        Um espaço sereno e carinhoso para pessoas mais velhas e iniciantes aprenderem a digitar do zero com calma, alegria e confiança sob o brilho da lua amarela.
                    </p>
                </div>

                <!-- Coluna 2: Atalhos de Aprendizado -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-moon-400 mb-4">Trilhas de Estudo</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="treino_nuvens.php" class="hover:text-moon-300 transition flex items-center gap-2"><span>☁️</span> Palavras Flutuantes nas Nuvens</a></li>
                        <li><a href="licoes.php" class="hover:text-moon-300 transition flex items-center gap-2"><span>⌨️</span> Teclas Guia F e J e Posição dos Dedos</a></li>
                        <li><a href="painel.php" class="hover:text-moon-300 transition flex items-center gap-2"><span>📈</span> Acompanhar Minha Velocidade e Precisão</a></li>
                        <li><a href="cadastro.php" class="hover:text-moon-300 transition flex items-center gap-2"><span>📝</span> Cadastrar-se na Turma</a></li>
                    </ul>
                </div>

                <!-- Coluna 3: Mensagem Motivacional -->
                <div class="bg-indigo-950/40 p-5 rounded-2xl border border-indigo-900/60">
                    <span class="text-2xl mb-2 block">🌟</span>
                    <h4 class="text-base font-bold text-white mb-1">Você é Plenamente Capaz!</h4>
                    <p class="text-xs sm:text-sm text-indigo-200/90 leading-relaxed">
                        "Nunca é tarde para descobrir a facilidade de se comunicar com quem você ama. Não tenha medo de errar: cada clique no teclado é um passo rumo à maestria."
                    </p>
                </div>
            </div>

            <!-- Aviso de Conexão com o Banco (se houver aviso informativo) -->
            <?php if (!empty($_SESSION['db_aviso'])): ?>
                <div class="mb-6 p-3 rounded-xl bg-slate-900/80 border border-slate-700/60 text-xs text-slate-400 text-center">
                    ℹ️ <?= htmlspecialchars($_SESSION['db_aviso']) ?>
                </div>
            <?php endif; ?>

            <div class="border-t border-slate-900 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-3">
                <p>© <?= date('Y') ?> Digitalização Profissional. Criado com respeito e acessibilidade para todas as idades.</p>
                <div class="flex items-center gap-4 text-xs">
                    <span>🌙 Noite Azul Escuro com Lua Amarela</span>
                    <span>•</span>
                    <span>🛡️ MySQL & PDO Seguro</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts Globais de Acessibilidade e Áudio -->
    <script src="assets/js/audio_effects.js"></script>
    <script src="assets/js/acessibilidade.js"></script>
</body>
</html>
