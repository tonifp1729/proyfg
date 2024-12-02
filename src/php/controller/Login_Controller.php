<?php
    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\usuarios.php';
    

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
            //Inicializamos la variable de error. Se devolverá en valor nulo en caso de que no se produzca ningún fallo
            $error = null;

            //Verificarmos que se han recibido las credenciales a través de POST
            if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
                $correo = $_POST['correo'];
                $contrasena = $_POST['contrasena'];
                
                //Comprobamos las credenciales utilizando el método en el modelo
                $usuario = $this->isesion->identificacion($correo, $contrasena);
    
                if (!empty($usuario)) {
                    //Inicia sesión y redirige al índice si las credenciales son correctas
                    session_start();
                    $_SESSION['id'] = $usuario['idUsuario'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $this->irindice(); //PASAMOS LA INFORMACION DE LA SIGUIENTE VISTA. Este es el modo de usar un método de la propia clase
                } else {
                    //Asignamos el mensaje de error si las credenciales introducidas son incorrectas
                    $this->irsesion();
                    $error = 'credenciales_invalidas';
                }
            } else {
                //Asignamos el mensaje de error si faltan credenciales
                $this->irsesion(); //Cargamos de nuevo la vista del formulario de inicio de sesión
                $error = 'faltan_credenciales';
            }

            return ['error' => $error];
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
            //No solo vamos a mostrar el trozo correspondiente a la vista, sino que necesitamos las partes reservadas en partials para construir toda la vista
        }

        public function irinicio() {
            $this->view = "inicial";
        }

        public function irsesion() {
            $this->view = "login";
        }
    }

?>