<?php
// clases/GestorMensajes.php
// Clase para gestionar mensajes usando variables de entorno

class GestorMensajes {
    private $nombre;
    private $correo;
    private $telefono;
    private $asunto;
    private $mensaje;
    private $fecha;
    private $conn;

    // Constructor
    public function __construct($nombre, $correo, $telefono, $asunto, $mensaje, $conn) {
        $this->conn = $conn;
        
        $this->nombre = htmlspecialchars(trim($nombre));
        $this->correo = htmlspecialchars(trim($correo));
        $this->telefono = htmlspecialchars(trim($telefono));
        $this->asunto = htmlspecialchars(trim($asunto));
        $this->mensaje = htmlspecialchars(trim($mensaje));
        $this->fecha = date("Y-m-d H:i:s");
    }

    // Método guardar() - Inserta en la base de datos
    public function guardar() {
        if (empty($this->nombre) || empty($this->correo) || empty($this->asunto) || empty($this->mensaje)) {
            return false;
        }

        $sql = "INSERT INTO contactos (nombre, correo, telefono, asunto, mensaje, fecha) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", 
            $this->nombre, 
            $this->correo, 
            $this->telefono, 
            $this->asunto, 
            $this->mensaje, 
            $this->fecha
        );
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    // Método mostrar() - Obtiene todos los mensajes
    public function mostrar($limit = null) {
        $sql = "SELECT * FROM contactos ORDER BY fecha DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        $resultado = $this->conn->query($sql);
        
        if ($resultado->num_rows == 0) {
            return "<p class='text-muted'>No hay mensajes guardados.</p>";
        }
        
        $html = '<div class="mensajes-container">';
        
        while ($fila = $resultado->fetch_assoc()) {
            $html .= '
            <div class="mensaje-card" style="background:#1a1a1a; border-radius:15px; padding:20px; margin-bottom:20px; border-left:4px solid #9b59b6;">
                <h3 style="color:#9b59b6;"> ' . htmlspecialchars($fila['asunto']) . '</h3>
                <p><strong> Nombre:</strong> ' . htmlspecialchars($fila['nombre']) . '</p>
                <p><strong> Correo:</strong> ' . htmlspecialchars($fila['correo']) . '</p>
                <p><strong> Teléfono:</strong> ' . htmlspecialchars($fila['telefono'] ?? 'No proporcionado') . '</p>
                <p><strong> Mensaje:</strong><br>' . nl2br(htmlspecialchars($fila['mensaje'])) . '</p>
                <small style="color:#888;"> ' . htmlspecialchars($fila['fecha']) . '</small>
            </div>';
        }
        
        $html .= '</div>';
        return $html;
    }
    
    // Obtener total de mensajes
    public function obtenerTotalMensajes() {
        $sql = "SELECT COUNT(*) as total FROM contactos";
        $resultado = $this->conn->query($sql);
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }
    
    // Eliminar un mensaje por ID
    public function eliminarMensaje($id) {
        $sql = "DELETE FROM contactos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>