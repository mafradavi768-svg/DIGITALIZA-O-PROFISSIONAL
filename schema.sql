-- =====================================================================
-- DIGITALIZAÇÃO PROFISSIONAL
-- Banco de Dados: MySQL (com PDO)
-- Sistema de Digitação Acessível e Intuitivo para a Terceira Idade
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `digitaliza_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `digitaliza_db`;

-- Tabela de Usuários
-- Regra de negócio: cada pessoa que se cadastrar NÃO terá o direito de se cadastrar novamente (UNIQUE no email)
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `senha_hash` VARCHAR(255) NOT NULL,
    `nivel_digitacao` VARCHAR(50) NOT NULL,
    `tamanho_fonte_pref` VARCHAR(10) DEFAULT 'grande',
    `som_habilitado` TINYINT(1) DEFAULT 1,
    `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `ultimo_acesso` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Progresso e Sessões de Digitação (Palavras Flutuantes e Lições)
CREATE TABLE IF NOT EXISTS `progresso_digitacao` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `modo` VARCHAR(60) NOT NULL,
    `palavras_certas` INT NOT NULL DEFAULT 0,
    `palavras_erradas` INT NOT NULL DEFAULT 0,
    `precisao_pct` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    `ppm` INT NOT NULL DEFAULT 0,
    `pontos` INT NOT NULL DEFAULT 0,
    `data_registro` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_progresso_usuario` FOREIGN KEY (`usuario_id`) 
        REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Medalhas e Conquistas
CREATE TABLE IF NOT EXISTS `conquistas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `codigo` VARCHAR(50) NOT NULL,
    `titulo` VARCHAR(100) NOT NULL,
    `descricao` VARCHAR(255) NOT NULL,
    `icone` VARCHAR(50) NOT NULL,
    `data_conquistada` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_conquistas_usuario` FOREIGN KEY (`usuario_id`) 
        REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `uk_usuario_conquista` (`usuario_id`, `codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
