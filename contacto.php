<?php
// contacto.php
// Procesa el formulario de contacto desde el portafolio de Axel Colorado

// Verificar que los datos vengan por método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Obtener y sanitizar datos usando $_POST
    $nombre = htmlspecialchars(trim($_POST["nombre"] ?? ""));
    $correo = htmlspecialchars(trim($_POST["email"] ?? ""));
    $telefono = htmlspecialchars(trim($_POST["telefono"] ?? ""));
    $asunto = htmlspecialchars(trim($_POST["asunto"] ?? ""));
    $mensaje = htmlspecialchars(trim($_POST["mensaje"] ?? ""));

    // Validar campos obligatorios
    if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head><meta charset='UTF-8'><title>Error</title>";
        echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
        echo "<style>body{font-family:'Manrope',sans-serif;background:#0a0a0a;color:#fff;padding:50px;}</style>";
        echo "</head><body>";
        echo "<div class='container text-center'>";
        echo "<h2 style='color:#9b59b6;'>❌ Error</h2>";
        echo "<p>Todos los campos marcados con <strong>*</strong> son obligatorios.</p>";
        echo "<a href='javascript:history.back()' class='btn btn-primary-custom'>← Volver al formulario</a>";
        echo "</div></body></html>";
        exit;
    }

    // Mostrar respuesta personalizada con variables superglobales
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head><meta charset='UTF-8'><title>Mensaje enviado</title>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<style>
            body{font-family:'Manrope',sans-serif;background:#0a0a0a;color:#fff;padding:50px;}
            .container{max-width:800px;margin:0 auto;background:#1a1a1a;border-radius:15px;padding:30px;}
            .highlight{color:#9b59b6;font-weight:bold;}
            .info-box{background:#2a2a2a;border-radius:10px;padding:15px;margin-top:20px;}
          </style>";
    echo "</head><body>";
    echo "<div class='container'>";
    
    // Mensaje personalizado con el nombre del usuario
    echo "<h1 style='color:#9b59b6;'>✅ ¡Gracias por contactarme, <span class='highlight'>" . $nombre . "</span>!</h1>";
    
    echo "<hr>";
    echo "<h3>📋 Datos recibidos:</h3>";
    echo "<p><strong>📧 Correo:</strong> " . $correo . "</p>";
    if (!empty($telefono)) {
        echo "<p><strong>📱 Teléfono:</strong> " . $telefono . "</p>";
    }
    echo "<p><strong>📌 Asunto:</strong> " . $asunto . "</p>";
    echo "<p><strong>💬 Mensaje:</strong><br>" . nl2br($mensaje) . "</p>";
    
    // Mostrar información de $_SERVER (requerido por la actividad)
    echo "<div class='info-box'>";
    echo "<h3>🖥️ Información del servidor (superglobales):</h3>";
    echo "<p><strong>Método de solicitud:</strong> " . $_SERVER["REQUEST_METHOD"] . "</p>";
    echo "<p><strong>Dirección IP del cliente:</strong> " . $_SERVER["REMOTE_ADDR"] . "</p>";
    echo "<p><strong>Navegador (User Agent):</strong><br><small>" . $_SERVER["HTTP_USER_AGENT"] . "</small></p>";
    echo "<p><strong>Script ejecutado:</strong> " . $_SERVER["SCRIPT_NAME"] . "</p>";
    echo "<p><strong>Servidor web:</strong> " . $_SERVER["SERVER_SOFTWARE"] . "</p>";
    echo "</div>";
    
    echo "<div class='text-center mt-4'>";
    echo "<a href='index.html' class='btn btn-primary-custom'>← Volver al portafolio</a>";
    echo "</div>";
    echo "</div></body></html>";
    
} else {
    // Si alguien intenta acceder directamente sin POST
    echo "<!DOCTYPE html>";
    echo "<html><head><meta charset='UTF-8'><title>Acceso denegado</title>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "</head><body style='background:#0a0a0a;color:#fff;padding:50px;text-align:center;'>";
    echo "<h2 style='color:#9b59b6;'>⚠️ Acceso no autorizado</h2>";
    echo "<p>Por favor, envía el formulario desde la página de contacto.</p>";
    echo "<a href='index.html#contact' class='btn btn-primary-custom'>Ir al portafolio</a>";
    echo "</body></html>";
}
?>