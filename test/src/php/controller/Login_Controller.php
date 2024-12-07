<?php

require_once 'F:\XAMPP\htdocs\proyfg\test\src\php\model\usuarios.php';

    class Login_Controller {

        public $view;
        private $isesion;

        public function __construct() {
            $this->isesion = new Usuarios();
        }

        /*
          * Este método se ejecuta en cuanto se ha pulsado el botón de envío desde el formulario de inicio de sesión.
          * Se encarga del inicio de sesión en la aplicación.
         **/
        public function identificacion() {
            $error = null;
        
            if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
                $correo = $_POST['correo'];
                $contrasena = $_POST['contrasena'];
        
                if (!str_ends_with($correo, '@fundacionloyola.org')) {
                    $error = 'correo_invalido';
                } else {
                    $usuario = $this->isesion->identificacion($correo, $contrasena);
                    if (!$usuario) {
                        $error = 'correo_inexistente';
                    }
                }
            } else {
                $error = 'faltan_credenciales';
            }
        
            $this->view = 'login';
            $this->data = ['error' => $error];
        }        

        /*
          * Este método se ejecuta en cuanto se pulsa el cierre de sesión.
          * Se encarga de destruir la sesión existente y manda al usuario a la ventana de inicio.
         **/
        public function cerrarSesion() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            session_destroy();
            $this->irsesion();
        }

        public function mostrarSaludo() {
            $this->view = "saludo";
        }        

        public function irinicio() {
            $this->view = "inicial";
        }

        public function irsesion() {
            $this->view = "login"; // Carga la vista de login
            $datosVista = ['data' => ['error' => 'faltan_credenciales', 'formData' => $_POST]];
            require_once 'php/view/' . $this->view . '.php';
        }
        
    }

?>