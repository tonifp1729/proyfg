<?php

    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\usuarios.php';

    class Register_Controller {
        public $view;
        private $registrar;


        public function __construct() {
            $this->registrar = new usuarios();
        }

        /*
          * Este método se ejecuta en cuanto se ha pulsado el botón de envío desde el formulario de registro de alumno.
          * Hace el registro de un nuevo alumno a la aplicación.
         **/
        public function registro() {
            $error = null;

            if (!empty($_POST['correo']) && !empty($_POST['confirmarCorreo']) && !empty($_POST['contrasena']) && !empty($_POST['confirmarContrasena']) && !empty($_POST['nombre'] && !empty($_POST['apellidos']))) {
                $correo = $_POST['correo'];
                $confirmacionCorreo = $_POST['confirmarCorreo'];
                $contrasena = $_POST['contrasena'];
                $confirmacion = $_POST['confirmarContrasena'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                
                if($correo != $confirmacionCorreo ) {
                    $error = 'correo_erroneo';
                    $this->irregistro();
                }
                else if ($contrasena != $confirmacion) {
                    $error = 'contrasena_incorrecta';
                    $this->irregistro();
                } else if (!$this->validarCorreo($correo)) {
                    $error = 'correo_invalido';
                    $this->irregistro();
                } else {
                    if($this->registrar->correoRegistrado($correo)===true){
                        $error = 'correo_existente';
                        $this->irregistro();
                    } else {
                        $this->registrar->insertarUsuario($correo, $nombre, $apellidos, $contrasena);
                        $this->view = "login";
                    }
                }
            } else {
                $error = 'faltan_credenciales';
                $this->irregistro();
            }

            return ['error' => $error];
        }

        /*
          * Este método se ejecuta durante las validaciones del método de registro.
          * Comprueba que el dominio del correo electrónico pertenezca a la fundación loyola.
         **/
        private function validarCorreo($correo) {
            //Expresión regular para asegurar que el correo recibido pertenece a este dominio: "@alumnado.fundacionloyola.net"
            $regex = '/^[a-zA-Z0-9._%+-]+@fundacionloyola\.es$/';
    
            //Comprueba que el correo cumpla con lo establecido en $regex
            return preg_match($regex, $correo) === 1;
        }

        public function irregistro() {
            $this->view = "registro";
        }

    }
?>