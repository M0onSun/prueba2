<?php
// Mostrar errores solo en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
session_start();

// Cargar constantes primero
require_once __DIR__ . '/../config/constants.php';

// Autoloader mejorado
spl_autoload_register(function($class) {
    $file = BASE_DIR . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Iniciar la aplicación
require BASE_DIR . '/system/Router.php';
Router::route();