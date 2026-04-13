<?php
// config/app.php - Configuración general de la aplicación

define('APP_NAME', 'Le Mascotte');
define('APP_URL', 'https://arevaloshawty.github.io/le-mascotte/');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', true);

// Rutas del proyecto
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Sesión
session_start();

// Zona horaria
date_default_timezone_set('America/El_Salvador');

// Autoload simple
spl_autoload_register(function ($className) {
    $paths = [
        APP_PATH . '/models/' . $className . '.php',
        APP_PATH . '/controllers/' . $className . '.php',
        APP_PATH . '/views/' . $className . '.php',
        ROOT_PATH . '/config/' . $className . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Helpers globales
function redirect(string $url): void {
    header("Location: " . APP_URL . "/" . ltrim($url, '/'));
    exit;
}

function sanitize(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function formatPrice(float $price): string {
    return '$' . number_format($price, 2);
}

function asset(string $path): string {
    // Los assets siguen en la carpeta public, así que añadimos el prefijo
    return APP_URL . '/public/' . ltrim($path, '/');
}

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
?>
