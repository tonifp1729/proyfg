<?php

    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\usuarios.php';    

    class User_Controller {

        public $view;
        private $usuario;

        public function __construct() {
            $this->usuario = new Usuarios();
        }

        public function modificarUsuario() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        
            //Obtenemos el ID del usuario y los datos enviados por el formulario
            $idUsuario = $_GET['idUsuario'];
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
            $rol = isset($_POST['rol']) ? $_POST['rol'] : '';
            $etapas = isset($_POST['etapas']) ? $_POST['etapas'] : [];
        
            //Llamamos al modelo para actualizar los datos del usuario
            $this->usuario->modificarUsuario($idUsuario, $nombre, $apellidos, $rol, $etapas);
            $this->exito();
        }              

        public function mostrarModificarUsuario() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            //Obtenemos el ID del usuario desde la URL
            $idUsuario = $_GET['idUsuario'];
            
            //Obtenemos los datos del usuario
            $usuario = $this->usuario->obtenerUsuario($idUsuario);
            $etapasUsuario = $this->usuario->obtenerEtapasUsuario($idUsuario);
            $todasEtapas = $this->usuario->obtenerTodasEtapas();
            $todosRoles = $this->usuario->obtenerTodosRoles();

            //Retornamos los datos para la vista y definimos cual cargar
            $this->view = "modificarusuario";
            return [
                'usuario' => $usuario,
                'etapasUsuario' => $etapasUsuario,
                'todasEtapas' => $todasEtapas,
                'todosRoles' => $todosRoles
            ];
        }
        

        public function mostrarListadoUsuarios() {
            $listaUsuarios = $this->usuario->listarUsuarios();

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view = "listausuarios";

            return ['listaUsuarios' => $listaUsuarios];
        }

        public function exito() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view = "avisoexito";
        }
    }

?>