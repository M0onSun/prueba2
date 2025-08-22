<?php
// Definir constantes solo si no existen
if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
    define('APP_DIR', BASE_DIR . '/app');
    define('PUBLIC_DIR', BASE_DIR . '/public');
    define('BASE_URL', 'http://localhost:8080/proyecto64/public/');
    
    // Configuración de base de datos
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'bdusuario2025');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');
}