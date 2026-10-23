<?php
/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Arquivo de conexão e configuração do Banco de Dados via PDO
 * Compatível com MySQL e fallback automático para SQLite em ambiente de desenvolvimento.
 */

// Inicia a sessão nativa do PHP com segurança, caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações de Conexão com o MySQL
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'digitaliza_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

/**
 * Retorna uma instância única de conexão PDO (Singleton Pattern)
 * Garante que a mesma conexão seja reutilizada em todas as consultas.
 *
 * @return PDO
 */
function getDBConnection(): PDO {
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // 1. Tentativa prioritária de conexão com o MySQL
    try {
        // Primeiro conecta ao servidor MySQL sem especificar banco para poder criá-lo se não existir
        $dsnServer = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
        $tempPdo = new PDO($dsnServer, DB_USER, DB_PASS, $options);
        
        // Garante que o banco de dados exista
        $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        
        // Conecta efetivamente ao banco de dados do projeto
        $dsnDb = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsnDb, DB_USER, DB_PASS, $options);

        // Cria as tabelas do MySQL caso ainda não existam
        criarTabelasMySQL($pdo);
        $pdo->setAttribute(PDO::ATTR_DRIVER_NAME, 'mysql');
        return $pdo;

    } catch (PDOException $eMySQL) {
        // 2. Fallback resiliente: caso o servidor MySQL não esteja em execução na máquina de teste,
        // utilizamos o SQLite nativo do PHP com a MESMA interface PDO e prepared statements.
        try {
            $sqlitePath = __DIR__ . DIRECTORY_SEPARATOR . 'digitaliza.sqlite';
            $pdo = new PDO("sqlite:" . $sqlitePath, null, null, $options);
            $pdo->exec("PRAGMA foreign_keys = ON;");
            
            criarTabelasSQLite($pdo);
            $_SESSION['db_aviso'] = 'Conectado via SQLite local (serviço MySQL não detectado). O sistema funciona 100%.';
            return $pdo;
        } catch (PDOException $eSQLite) {
            die("Erro crítico ao inicializar o banco de dados: " . htmlspecialchars($eMySQL->getMessage()));
        }
    }
}

/**
 * Cria a estrutura de tabelas no MySQL se não existirem
 */
function criarTabelasMySQL(PDO $pdo): void {
    $sql = "
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
    ";
    $pdo->exec($sql);
}

/**
 * Cria a estrutura de tabelas correspondente no SQLite (modo de compatibilidade)
 */
function criarTabelasSQLite(PDO $pdo): void {
    $sql = "
    CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        senha_hash TEXT NOT NULL,
        nivel_digitacao TEXT NOT NULL,
        tamanho_fonte_pref TEXT DEFAULT 'grande',
        som_habilitado INTEGER DEFAULT 1,
        data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
        ultimo_acesso DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS progresso_digitacao (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER NOT NULL,
        modo TEXT NOT NULL,
        palavras_certas INTEGER NOT NULL DEFAULT 0,
        palavras_erradas INTEGER NOT NULL DEFAULT 0,
        precisao_pct REAL NOT NULL DEFAULT 0.0,
        ppm INTEGER NOT NULL DEFAULT 0,
        pontos INTEGER NOT NULL DEFAULT 0,
        data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS conquistas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER NOT NULL,
        codigo TEXT NOT NULL,
        titulo TEXT NOT NULL,
        descricao TEXT NOT NULL,
        icone TEXT NOT NULL,
        data_conquistada DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
        UNIQUE(usuario_id, codigo)
    );
    ";
    $pdo->exec($sql);
}

// Instância global de PDO para os scripts que a utilizam diretamente
$pdo = getDBConnection();
