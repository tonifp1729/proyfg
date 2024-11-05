<?php
    require_once '/home/proyectosevg/public_html/2daw00/reconocimientos/src/php/model/isesion.php';

    class Controladorcisesion {

        public $view;
        private $isesion;

        public function __construct() {
            $this->isesion = new InicioSesion();
        }

        /*
          * Este método se ejecuta en cuanto se ha pulsado el botón de envío desde el formulario de inicio de sesión.
          * Se encarga del inicio de sesión en la aplicación.
         **/
        public function identificacion() {
            //Inicializamos la variable de error. Se devolverá en vallor nulo en caso de que no se produzca ningún fallo
            $error = null;

            //Verificarmos que se han recibido las credenciales a través de POST
            if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
                $correo = $_POST['correo'];
                $contrasena = $_POST['contrasena'];
                
                //Comprobamos las credenciales utilizando el método en el modelo
                $alumno = $this->isesion->identificacion($correo, $contrasena);
    
                if (!empty($alumno)) {
                    //Inicia sesión y redirige al índice si las credenciales son correctas
                    session_start();
                    $_SESSION['id'] = $alumno['idAlumno'];
                    $_SESSION['nombre'] = $alumno['nombre'];
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

        public function irindice() {
            $this->view = "indice";
        }

        public function irsesion() {
            $this->view = "forminiciosesion";
        }
    }

?>