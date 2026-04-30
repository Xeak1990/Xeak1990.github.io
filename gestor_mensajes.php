<?php
// Clase GestorMensajes
// Propósito: Almacenar y mostrar mensajes de contacto del portafolio

class GestorMensajes {
    // Propiedades privadas
    private $nombre;
    private $correo;
    private $telefono;
    private $asunto;
    private $mensaje;
    private $fecha;
    private $archivo = "mensajes.txt";

    // Constructor
    public function __construct($nombre, $correo, $telefono, $asunto, $mensaje) {
        $this->nombre = htmlspecialchars(trim($nombre));
        $this->correo = htmlspecialchars(trim($correo));
        $this->telefono = htmlspecialchars(trim($telefono));
        $this->asunto = htmlspecialchars(trim($asunto));
        $this->mensaje = htmlspecialchars(trim($mensaje));
        $this->fecha = date("Y-m-d H:i:s");
    }

    // Método público guardar() - Almacena en archivo .txt
    public function guardar() {
        if (empty($this->nombre) || empty($this->correo) || empty($this->asunto) || empty($this->mensaje)) {
            return false;
        }

        // Formato para guardar cada mensaje
        $contenido = "=== MENSAJE ===\n";
        $contenido .= "Fecha: {$this->fecha}\n";
        $contenido .= "Nombre: {$this->nombre}\n";
        $contenido .= "Correo: {$this->correo}\n";
        $contenido .= "Teléfono: {$this->telefono}\n";
        $contenido .= "Asunto: {$this->asunto}\n";
        $contenido .= "Mensaje: {$this->mensaje}\n";
        $contenido .= "---\n\n";

        // Guardar en el archivo
        return file_put_contents($this->archivo, $contenido, FILE_APPEND | LOCK_EX) !== false;
    }

    // Método público mostrar() - Devuelve contenido formateado en HTML
    public function mostrar() {
        if (!file_exists($this->archivo)) {
            return "<p class='text-muted'>No hay mensajes guardados.</p>";
        }

        $contenido = file_get_contents($this->archivo);
        $mensajes = explode("=== MENSAJE ===", $contenido);
        $html = '<div class="mensajes-container">';

        foreach ($mensajes as $msg) {
            if (trim($msg) == "") continue;

            // Extraer datos con regex
            preg_match('/Fecha: (.+)/', $msg, $fechaMatch);
            preg_match('/Nombre: (.+)/', $msg, $nombreMatch);
            preg_match('/Correo: (.+)/', $msg, $correoMatch);
            preg_match('/Teléfono: (.+)/', $msg, $telefonoMatch);
            preg_match('/Asunto: (.+)/', $msg, $asuntoMatch);
            preg_match('/Mensaje: (.+)/', $msg, $mensajeMatch);

            $fecha = $fechaMatch[1] ?? 'Sin fecha';
            $nombre = $nombreMatch[1] ?? 'Anónimo';
            $correo = $correoMatch[1] ?? 'Sin correo';
            $telefono = $telefonoMatch[1] ?? 'No proporcionado';
            $asunto = $asuntoMatch[1] ?? 'Sin asunto';
            $mensaje = $mensajeMatch[1] ?? 'Sin mensaje';

            $html .= '
            <div class="mensaje-card" style="background:#1a1a1a; border-radius:15px; padding:20px; margin-bottom:20px; border-left:4px solid #9b59b6;">
                <h3 style="color:#9b59b6;">📩 ' . htmlspecialchars($asunto) . '</h3>
                <p><strong>👤 Nombre:</strong> ' . htmlspecialchars($nombre) . '</p>
                <p><strong>📧 Correo:</strong> ' . htmlspecialchars($correo) . '</p>
                <p><strong>📱 Teléfono:</strong> ' . htmlspecialchars($telefono) . '</p>
                <p><strong>💬 Mensaje:</strong><br>' . nl2br(htmlspecialchars($mensaje)) . '</p>
                <small style="color:#888;">📅 ' . htmlspecialchars($fecha) . '</small>
            </div>';
        }

        $html .= '</div>';
        return $html;
    }

    // Método para obtener todos los mensajes sin formatear (opcional)
    public function obtenerMensajes() {
        if (!file_exists($this->archivo)) {
            return [];
        }
        return file($this->archivo, FILE_IGNORE_NEW_LINES);
    }
}
?>