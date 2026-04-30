<?php
// contacto.php
require_once 'gestor_mensajes.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $nombre = $_POST["nombre"] ?? "";
    $correo = $_POST["email"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $asunto = $_POST["asunto"] ?? "";
    $mensaje = $_POST["mensaje"] ?? "";

    $gestor = new GestorMensajes($nombre, $correo, $telefono, $asunto, $mensaje);

    if ($gestor->guardar()) {
        // Mostrar respuesta exitosa igual que antes
        echo "<!DOCTYPE html>";
        echo "<html><head><meta charset='UTF-8'><title>Mensaje enviado</title>";
        echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'>";
        echo "<style>body{font-family:'Manrope',sans-serif;background:#0a0a0a;color:#fff;padding:30px;}</style>";
        echo "</head><body>";
        echo "<div class='container'>";
        
        echo "<h2 style='color:#9b59b6;'> ¡Gracias por contactarme, " . htmlspecialchars($nombre) . "!</h2>";
        echo "<p>Tu mensaje ha sido guardado en la base de datos.</p>";
        
        echo "<hr>";
        echo "<h3> Mensaje guardado:</h3>";
        echo $gestor->mostrar();
        
        echo "<hr>";
        echo "<h3> Información del servidor:</h3>";
        echo "<p><strong>Método:</strong> " . $_SERVER["REQUEST_METHOD"] . "</p>";
        echo "<p><strong>IP:</strong> " . $_SERVER["REMOTE_ADDR"] . "</p>";
        echo "<p><strong>User Agent:</strong> " . $_SERVER["HTTP_USER_AGENT"] . "</p>";
        
        echo "<br><a href='index.html' class='btn btn-primary-custom' style='background:#9b59b6;color:white;padding:10px 20px;text-decoration:none;border-radius:8px;'>← Volver al portafolio</a>";
        echo "</div></body></html>";
    } else {
        echo "<h2> Error al guardar el mensaje</h2>";
        echo "<a href='javascript:history.back()'>← Volver al formulario</a>";
    }
} else {
    echo "<h3> Acceso no permitido</h3>";
    echo "<a href='index.html#contact'>← Ir al portafolio</a>";
}
?>