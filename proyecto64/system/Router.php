<?php
class Router {
    public static function route() {
        $url = $_GET['url'] ?? 'auth/login';
        $parts = explode('/', $url);

        // Convertir a singular si está en plural
        $controllerBase = rtrim($parts[0] ?? 'auth', 's'); // Elimina 's' final
        $controllerName = ucfirst($controllerBase) . 'Controller';

        $method = $parts[1] ?? 'index';
        $params = array_slice($parts, 2);

        $controllerFile = APP_DIR . "/controllers/{$controllerName}.php";

        if (!file_exists($controllerFile)) {
            self::showError("Controlador no encontrado: {$controllerName}");
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            self::showError("Clase {$controllerName} no encontrada");
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            self::showError("Método {$method} no existe en {$controllerName}");
            return;
        }

        call_user_func_array([$controller, $method], $params);
    }

    public static function redirect($path) {
        header("Location: " . BASE_URL . $path);
        exit;
    }

    private static function showError($message) {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Error</h1>";
        echo "<p>{$message}</p>";
        echo "<a href='" .BASE_URL. "'>Volver al inicio</a>";
        exit;
    }
}