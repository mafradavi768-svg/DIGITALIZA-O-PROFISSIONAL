<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Funções auxiliares de autenticação e sessão de usuário
 */

require_once __DIR__ . '/../bd.php';

/**
 * Verifica se há um usuário autenticado na sessão nativa
 */
function estaLogado(): bool {
    return !empty($_SESSION['usuario_id']);
}

/**
 * Retorna os dados do usuário autenticado ou null
 */
function getUsuarioLogado(): ?array {
    if (!estaLogado()) {
        return null;
    }

    return [
        'id'                 => $_SESSION['usuario_id'],
        'nome'               => $_SESSION['usuario_nome'] ?? 'Amigo(a)',
        'email'              => $_SESSION['usuario_email'] ?? '',
        'nivel_digitacao'    => $_SESSION['usuario_nivel'] ?? 'iniciante_zero',
        'tamanho_fonte_pref' => $_SESSION['usuario_fonte'] ?? 'grande',
        'som_habilitado'     => $_SESSION['usuario_som'] ?? 1,
    ];
}

/**
 * Redireciona para o login se o usuário não estiver autenticado
 */
function exigirLogin(): void {
    if (!estaLogado()) {
        $_SESSION['alerta_login'] = 'Por favor, acesse sua conta ou faça seu cadastro para continuar o aprendizado.';
        header('Location: login.php');
        exit;
    }
}

/**
 * Retorna o nome amigável do nível de digitação
 */
function formatarNivelDigitacao(string $nivel): string {
    $niveis = [
        'iniciante_zero' => 'Iniciante do Zero (Nunca digitei)',
        'iniciante_catando' => 'Básico (Digito catando milho)',
        'intermediario' => 'Em Evolução (Conheço algumas teclas)',
        'avancado' => 'Praticante (Quero velocidade profissional)',
    ];

    return $niveis[$nivel] ?? 'Iniciante';
}

/**
 * Retorna as palavras recomendadas de acordo com o nível do aluno
 */
function getPalavrasPorNivel(string $nivel): array {
    switch ($nivel) {
        case 'iniciante_zero':
            // Letras simples, linha base e palavras de 2 a 4 letras
            return ['sol', 'lua', 'mar', 'paz', 'dia', 'ceu', 'asa', 'mae', 'pai', 'cha', 'ola', 'bom', 'rio', 'flor', 'casa', 'vida'];
        case 'iniciante_catando':
            // Palavras comuns de 4 a 6 letras
            return ['saude', 'amor', 'amigo', 'noite', 'nuvem', 'feliz', 'tempo', 'filho', 'netos', 'livro', 'campo', 'sorriso', 'janela'];
        case 'intermediario':
            // Palavras de média complexidade e frases curtas
            return ['familia', 'computador', 'teclado', 'mensagens', 'trabalho', 'aprender', 'conhecimento', 'paciencia', 'digitalizar'];
        case 'avancado':
            // Palavras longas e técnicas
            return ['profissional', 'desenvolvimento', 'responsabilidade', 'compartilhar', 'concentracao', 'produtividade', 'tecnologia'];
        default:
            return ['lua', 'ceu', 'paz', 'amor', 'vida', 'saude', 'amigo'];
    }
}
