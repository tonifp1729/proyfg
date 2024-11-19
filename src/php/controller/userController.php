<?php
    require_once __DIR__ . '/../../vendor/google-api-php-client/vendor/autoload.php';
    require_once __DIR__ . '/../model/usuarios.php';

    class UserController {
        private $usuarios;

        public function __construct() {
            $this->usuarios = new Usuarios();
        }

        public function loginWithGoogle() {
            $client = new Google_Client();
            $client->setClientId('TU_CLIENT_ID');
            $client->setClientSecret('TU_CLIENT_SECRET');
            $client->setRedirectUri('http://29.2daw.esvirgua.com/src/php/controller/UserController.php');
            $client->addScope(['email', 'profile']);

            if (!isset($_GET['code'])) {
                $authUrl = $client->createAuthUrl();
                header('Location: ' . $authUrl);
                exit;
            } else {
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($token);

                $oauth = new Google_Service_Oauth2($client);
                $userInfo = $oauth->userinfo->get();

                $correo = $userInfo->email;
                $nombre = $userInfo->givenName;
                $apellidos = $userInfo->familyName;

                if (strpos($correo, '@fundacionloyola.es') === false) {
                    header('Location: /src/php/view/acceso_denegado.php');
                    exit;
                }

                $resultado = $this->usuarios->guardarUsuario($correo, $nombre, $apellidos);

                if ($resultado['status'] === 'success') {
                    $_SESSION['correo'] = $correo;
                    $_SESSION['rol'] = 'U';
                    header('Location: /src/php/view/user/panel_usuario.php');
                } elseif ($resultado['status'] === 'exists') {
                    $usuario = $this->usuarios->obtenerUsuarioPorCorreo($correo);
                    $_SESSION['correo'] = $correo;
                    $_SESSION['rol'] = $usuario['rol'];
                    $this->redirectUserByRole($usuario['rol']);
                }
            }
        }

        private function redirectUserByRole($rol) {
            switch ($rol) {
                case 'A':
                    header('Location: /src/php/view/admin/panel_admin.php');
                    break;
                case 'M':
                    header('Location: /src/php/view/moder/panel_moderador.php');
                    break;
                default:
                    header('Location: /src/php/view/user/panel_usuario.php');
                    break;
            }
            exit;
        }
    }

    session_start();
    $controller = new UserController();
    $controller->loginWithGoogle();

// --------------------------------------------------------------------------------------------------------------------------
    // require_once '../model/usuarios.php';

    // $data = json_decode(file_get_contents("php://input"), true);

    // $usuario = new Usuarios();

    // if (isset($data['accion'])) {
    //     switch ($data['accion']) {
    //         case 'registrar':
    //             $response = $usuario->guardarUsuario($data['correo'], $data['nombre'], $data['apellidos']);
    //             break;

    //         case 'obtenerUsuario':
    //             $response = $usuario->obtenerUsuario($data['idUsuario']);
    //             break;

    //         case 'asignarRol':
    //             $response = $usuario->asignarRol($data['idUsuario'], $data['nuevoRol']);
    //             break;

    //         case 'asignarEtapas':
    //             $response = $usuario->asignarEtapas($data['idUsuario'], $data['etapas']);
    //             break;

    //         case 'eliminarEtapa':
    //             $response = $usuario->eliminarEtapa($data['idUsuario'], $data['idEtapa']);
    //             break;

    //         case 'eliminarUsuario':
    //             $response = $usuario->eliminarUsuario($data['idUsuario']);
    //             break;

    //         default:
    //             $response = ['status' => 'error', 'message' => 'Acción no reconocida'];
    //             break;
    //     }

    //     echo json_encode($response);
    // } else {
    //     echo json_encode(['status' => 'error', 'message' => 'No se especificó ninguna acción']);
    // }