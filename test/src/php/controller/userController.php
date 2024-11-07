<?php
    require_once '../model/usuarios.php';

    $data = json_decode(file_get_contents("php://input"), true);

    $usuario = new Usuarios();

    if (isset($data['accion'])) {
        switch ($data['accion']) {
            case 'registrar':
                $response = $usuario->guardarUsuario($data['correo'], $data['nombre'], $data['apellidos']);
                break;

            case 'obtenerUsuario':
                $response = $usuario->obtenerUsuario($data['idUsuario']);
                break;

            case 'asignarRol':
                $response = $usuario->asignarRol($data['idUsuario'], $data['nuevoRol']);
                break;

            case 'asignarEtapas':
                $response = $usuario->asignarEtapas($data['idUsuario'], $data['etapas']);
                break;

            case 'eliminarEtapa':
                $response = $usuario->eliminarEtapa($data['idUsuario'], $data['idEtapa']);
                break;

            case 'eliminarUsuario':
                $response = $usuario->eliminarUsuario($data['idUsuario']);
                break;

            default:
                $response = ['status' => 'error', 'message' => 'Acción no reconocida'];
                break;
        }

        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se especificó ninguna acción']);
    }