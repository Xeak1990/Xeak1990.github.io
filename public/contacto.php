<?php
// public/contacto.php
// Procesa el formulario de contacto usando la clase y variables de entorno

require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../clases/GestorMensajes.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $nombre = $_POST["nombre"] ?? "";
    $correo = $_POST["email"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $asunto = $_POST["asunto"] ?? "";
    $mensaje = $_POST["mensaje"] ?? "";

    $gestor = new GestorMensajes($nombre, $correo, $telefono, $asunto, $mensaje, $conn);

    if ($gestor->guardar()) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Mensaje enviado - <?php echo $_ENV['SITE_NAME']; ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: 'Manrope', sans-serif;
                    background: #0a0a0a;
                    color: #fff;
                    padding: 30px;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    background: #1a1a1a;
                    border-radius: 15px;
                    padding: 30px;
                }
                .btn-primary-custom {
                    background-color: #9b59b6;
                    color: white;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 8px;
                    display: inline-block;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2 style="color:#9b59b6;"> ¡Gracias por contactarme, <?php echo htmlspecialchars($nombre); ?>!</h2>
                <p>Tu mensaje ha sido guardado en la base de datos.</p>
                
                <hr>
                <h3> Mensaje guardado:</h3>
                <?php echo $gestor->mostrar(1); // Muestra solo el último mensaje ?>
                
                <hr>
                <h3> Información del servidor:</h3>
                <p><strong>Método:</strong> <?php echo $_SERVER["REQUEST_METHOD"]; ?></p>
                <p><strong>IP:</strong> <?php echo $_SERVER["REMOTE_ADDR"]; ?></p>
                <p><strong>User Agent:</strong> <?php echo $_SERVER["HTTP_USER_AGENT"]; ?></p>
                
                <br>
                <a href="../index.html" class="btn-primary-custom">← Volver al portafolio</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<h2> Error al guardar el mensaje</h2>";
        echo "<a href='javascript:history.back()'>← Volver al formulario</a>";
    }
} else {
    header("Location: ../index.html#contact");
    exit;
}
?>