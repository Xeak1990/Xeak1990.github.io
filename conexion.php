<?php
// conexion.php
// Configuración de la conexión a la base de datos

$host = 'localhost';
$usuario = 'root';
$contraseña = 'root1234';  // Cambia por la contraseña que pusiste al instalar
$basedatos = 'portafolio_db';

// Crear conexión usando MySQLi (orientado a objetos)
$conn = new mysqli($host, $usuario, $contraseña, $basedatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Configurar charset para evitar problemas con caracteres especiales
$conn->set_charset("utf8mb4");

// La variable $conn estará disponible en cualquier archivo que incluya este
?>