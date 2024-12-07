
<?php

// Recover_Controller.php
require_once 'F:\XAMPP\htdocs\proyfg\test\src\php\model\usuarios.php';

class Recover_Controller {
    private $usuarios;

    public function __construct() {
        $this->usuarios = new Usuarios();
    }

    public function enviarCorreo() {
        $correo = $_POST['correo'];
        
        if ($this->usuarios->correoRegistrado($correo)) {
            // Generar token único
            $token = bin2hex(random_bytes(32));
            $expiracion = time() + 3600; // Token válido por 1 hora

            // Guardar token en la base de datos
            $this->usuarios->guardarToken($correo, $token, $expiracion);

            // Enviar correo con enlace
            $enlace = "http://localhost/index.php?controlador=Recover&action=formularioNuevaContrasena&token=" . $token;
            $asunto = "Recuperación de contraseña";
            $mensaje = "Haz clic en el siguiente enlace para restablecer tu contraseña: " . $enlace;
            
            mail($correo, $asunto, $mensaje, "From: solicitud_ausencias.guadalupe@fundacionloyola.es");

            echo "Correo enviado. Revisa tu bandeja de entrada.";
        } else {
            echo "El correo ingresado no está registrado.";
        }
    }

    public function actualizarContrasena() {
        $token = $_POST['token'];
        $nuevaContrasena = $_POST['nueva_contrasena'];
    
        // Validar token
        $usuario = $this->usuarios->validarToken($token);
        if ($usuario) {
            // Actualizar contraseña
            $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
            $this->usuarios->actualizarContrasena($usuario['idUsuario'], $hashedPassword);
    
            // Invalidar token
            $this->usuarios->invalidarToken($usuario['idUsuario']);
    
            echo "Contraseña actualizada exitosamente.";
        } else {
            echo "El token es inválido o ha expirado.";
        }
    }

    public function mostrarFormularioRecuperar() {
        $this->view = "formulario_recuperar"; // Nombre de la vista que se va a cargar
    }
}
?>