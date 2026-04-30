<?php
// public/ver_mensajes.php - Panel de administración de mensajes
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../clases/GestorMensajes.php';

$gestor = new GestorMensajes("", "", "", "", "", $conn);
$totalMensajes = $gestor->obtenerTotalMensajes();

// Manejar eliminación de mensaje
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $gestor->eliminarMensaje($_GET['eliminar']);
    header("Location: ver_mensajes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar mensajes - <?php echo $_ENV['SITE_NAME']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            background: #0a0a0a;
            color: #fff;
            padding: 30px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .btn-custom {
            background-color: #9b59b6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .stats {
            background: #1a1a1a;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        hr {
            border-color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        th {
            color: #9b59b6;
        }
        .delete-btn {
            color: #dc3545;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="color:#9b59b6;"> Bandeja de mensajes</h1>
        <p>Mensajes recibidos desde el formulario de contacto.</p>
        
        <div class="stats">
            <strong> Total de mensajes:</strong> <?php echo $totalMensajes; ?>
        </div>
        
        <a href="../index.html" class="btn-custom">← Volver al portafolio</a>
        <hr>
        
        <h3>Lista de mensajes</h3>
        
        <?php
        // Mostrar mensajes en formato tabla
        $sql = "SELECT id, nombre, correo, asunto, fecha FROM contactos ORDER BY fecha DESC";
        $resultado = $conn->query($sql);
        
        if ($resultado->num_rows > 0):
        ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['asunto']); ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td>
                        <a href="?ver=<?php echo $fila['id']; ?>" style="color:#9b59b6;">Ver</a> |
                        <a href="?eliminar=<?php echo $fila['id']; ?>" class="delete-btn" onclick="return confirm('¿Eliminar este mensaje?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="text-muted">No hay mensajes guardados.</p>
        <?php endif; ?>
        
        <hr>
        
        <?php
        // Mostrar detalle de un mensaje específico
        if (isset($_GET['ver']) && is_numeric($_GET['ver'])) {
            $id = $_GET['ver'];
            $sql = "SELECT * FROM contactos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $mensaje = $resultado->fetch_assoc();
            
            if ($mensaje):
        ?>
            <h3>📄 Detalle del mensaje #<?php echo $mensaje['id']; ?></h3>
            <div style="background:#1a1a1a; border-radius:15px; padding:20px; border-left:4px solid #9b59b6;">
                <p><strong> Nombre:</strong> <?php echo htmlspecialchars($mensaje['nombre']); ?></p>
                <p><strong> Correo:</strong> <?php echo htmlspecialchars($mensaje['correo']); ?></p>
                <p><strong> Teléfono:</strong> <?php echo htmlspecialchars($mensaje['telefono'] ?? 'No proporcionado'); ?></p>
                <p><strong> Asunto:</strong> <?php echo htmlspecialchars($mensaje['asunto']); ?></p>
                <p><strong> Mensaje:</strong><br><?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?></p>
                <p><strong> Fecha:</strong> <?php echo $mensaje['fecha']; ?></p>
            </div>
        <?php
            endif;
        }
        ?>
    </div>
</body>
</html>