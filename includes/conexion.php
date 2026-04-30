<?php
// includes/conexion.php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

date_default_timezone_set($_ENV['TIMEZONE'] ?? 'America/Mexico_City');

$host = $_ENV['DB_HOST'] ?? 'localhost';
$usuario = $_ENV['DB_USER'] ?? 'root';
$contraseña = $_ENV['DB_PASSWORD'] ?? '';
$basedatos = $_ENV['DB_NAME'] ?? 'portafolio_db';
$puerto = $_ENV['DB_PORT'] ?? 3306;

if (($_ENV['DEBUG_MODE'] ?? 'false') === 'true') {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

try {
    $conn = new mysqli($host, $usuario, $contraseña, $basedatos, (int)$puerto);
    
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    $logFile = __DIR__ . '/../logs/error.log';
    if (!is_dir(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
    
    if (($_ENV['DEBUG_MODE'] ?? 'false') === 'true') {
        die($e->getMessage());
    } else {
        die("Error de conexión a la base de datos. Por favor, intenta más tarde.");
    }
}
?>
EOF