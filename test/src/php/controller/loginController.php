<?php
    require_once '../model/usuarios.php';
    
    class LoginController {
        private $modeloUsuarios;
    
        public function __construct() {
            $this->modeloUsuarios = new Usuarios();
        }
    
        public function verificarDominio($correo) {
            //Comprueba si el dominio del correo que ha accedido a la aplicación forma parte de la fundación
            $dominiosPermitidos = ['@fundacionloyola.es', '@alumnado.fundacionloyola.net'];
            foreach ($dominiosPermitidos as $dominio) {
                if (str_ends_with($correo, $dominio)) {
                    return true;
                }
            }
            return false;
        }
    
        public function gestionarAcceso($datosUsuario) {
            $correo = $datosUsuario['correo'];
            $nombre = $datosUsuario['nombre'];
            $apellidos = $datosUsuario['apellidos'];
    
            //Verificamos que se trate de un usuario de la aplicación
            if ($this->verificarDominio($correo)) {
                // Guardar usuario si es su primer acceso
                $resultado = $this->modeloUsuarios->guardarUsuario($correo, $nombre, $apellidos);
    
                // Redirigir a la vista inicial
                return ['status' => 'success', 'message' => 'Acceso concedido', 'vista' => 'vista-inicial', 'userData' => $resultado];
            } else {
                // Redirigir a la vista de acceso denegado
                return ['status' => 'error', 'message' => 'Acceso denegado: dominio no autorizado', 'vista' => 'acceso-denegado'];
            }
        }
    }
    
    //Controlador para procesar el inicio de sesión
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!empty($data)) {
        $loginController = new LoginController();
        $response = $loginController->gestionarAcceso($data);
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos']);
    }