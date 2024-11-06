<?php
    require_once 'db.php';

    class Usuarios {
        private $conexion;

        public function __construct() {
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        public function guardarUsuario($correo, $nombre, $apellidos) {
            //Verificamos si el usuario ya existe en la base de datos
            $SQL = "SELECT * FROM Usuarios WHERE correo = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("s", $correo);
            $consulta->execute();
            $resultado = $consulta->get_result();

            if ($resultado->num_rows === 0) { //Si el usuario no ha sido encontrado (no existe), lo insertamos en la BD
                $SQL = "INSERT INTO Usuarios (correo, nombre, apellidos, rol) VALUES (?, ?, ?, 'U')";
                $insert = $this->conexion->prepare($SQL);
                $insert->bind_param("sss", $correo, $nombre, $apellidos);
                $insert->execute();
                $insert->close();

                return ['status' => 'success', 'message' => 'Usuario registrado exitosamente'];
            } else {
                return ['status' => 'exists', 'message' => 'Usuario ya registrado'];
            }

            $consulta->close();
        }
    }

    //Captura los datos enviados por el frontend (desde el inicio de sesión)
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data)) {
        $usuario = new Usuarios();
        $response = $usuario->guardarUsuario($data['correo'], $data['nombre'], $data['apellidos']);
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos']);
    }