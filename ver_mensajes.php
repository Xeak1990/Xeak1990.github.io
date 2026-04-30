<?php
// ver_mensajes.php - Página para administrar mensajes (solo para ti)
require_once 'gestor_mensajes.php';

$gestor = new GestorMensajes("", "", "", "", "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar mensajes - Axel Colorado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            background: #0a0a0a;
            color: #fff;
            padding: 30px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .btn-primary-custom {
            background-color: #9b59b6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="color:#9b59b6;">📬 Bandeja de mensajes</h1>
        <p>Mensajes recibidos desde el formulario de contacto.</p>
        <a href="index.html" class="btn-primary-custom">← Volver al portafolio</a>
        <hr>
        <?php echo $gestor->mostrar(); ?>
    </div>
</body>
</html>