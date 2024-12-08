<?php

    /**
     * Controlador para manejar el registro de nuevos alumnos en la aplicación.
     * Utiliza el modelo Usuarios para registrar nuevos usuarios y validar credenciales.
     */

    require_once 'F:\XAMPP\htdocs\proyfg\test\src\php\model\usuarios.php';

    class Register_Controller {

        /** @var string $view Vista actual que se cargará en la interfaz. */
        public $view;

        /** @var Usuarios $registrar Instancia del modelo Usuarios para registrar nuevos usuarios. */
        private $registrar;

        /**
         * Constructor de la clase.
         * Inicializa la instancia del modelo Usuarios.
         */
        public function __construct() {
            $this->registrar = new Usuarios();
        }

        /**
         * Método que se ejecuta al recibir los datos del formulario de registro.
         * Verifica que todos los campos estén completos, valida el correo y las contraseñas.
         *
         * @return array Un array con la clave 'error' que contiene el mensaje de error si ocurre.
         */
        public function registro() {
            $error = null;
        
            if (!empty($_POST['correo']) && !empty($_POST['confirmarCorreo']) &&
                !empty($_POST['contrasena']) && !empty($_POST['confirmarContrasena']) &&
                !empty($_POST['nombre']) && !empty($_POST['apellidos'])) {
        
                $correo = $_POST['correo'];
                $confirmacionCorreo = $_POST['confirmarCorreo'];
                $contrasena = $_POST['contrasena'];
                $confirmacion = $_POST['confirmarContrasena'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
        
                if ($correo != $confirmacionCorreo) {
                    $error = 'correo_erroneo';
                } else if ($contrasena != $confirmacion) {
                    $error = 'contrasena_incorrecta';
                } else if (!$this->validarCorreo($correo)) {
                    $error = 'correo_invalido';
                } else {
                    if ($this->registrar->correoRegistrado($correo)) {
                        $error = 'correo_existente';
                    } else {
                        $this->registrar->insertarUsuario($correo, $nombre, $apellidos, $contrasena);
        
                        session_start();
                        $_SESSION['correo'] = $correo;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['rol'] = 'usuario';
        
                        $this->view = "login";
                        return ['error' => $error];
                    }
                }
            } else {
                $error = 'faltan_credenciales';
            }
        
            // Redirige a la vista de registro con los datos enviados para mantenerlos.
            $this->view = "registro";
            return ['error' => $error, 'formData' => $_POST];
        }

        /**
         * Método privado para validar que el correo tenga el dominio correcto.
         * Asegura que el correo electrónico pertenece al dominio "@fundacionloyola.es".
         *
         * @param string $correo El correo electrónico a validar.
         * @return bool True si el correo es válido, false en caso contrario.
         */
        private function validarCorreo($correo) {
            // Expresión regular para validar el dominio del correo
            $regex = '/^[a-zA-Z0-9._%+-]+@fundacionloyola\.es$/';
            return preg_match($regex, $correo) === 1;
        }

        /**
         * Método que redirige a la vista de registro.
         */
        public function irregistro() {
            $this->view = "registro";
        }
    }
?>
