<?php
    require_once 'db.php'; // Incluye la clase de conexión a la base de datos

    class Usuarios {
        private $conexion; // Almacena la conexión a la base de datos

        /**
         * Constructor: Inicializa la conexión a la base de datos.
         */
        public function __construct() {
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        /**
         * Inserta un nuevo usuario en la base de datos.
         *
         * @param string $correo Correo electrónico del usuario.
         * @param string $nombre Nombre del usuario.
         * @param string $apellidos Apellidos del usuario.
         * @param string $contrasena Contraseña sin cifrar del usuario.
         */
        public function insertarUsuario($correo, $nombre, $apellidos, $contrasena) {
            // Cifra la contraseña utilizando el algoritmo bcrypt
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

            // Consulta SQL para insertar el usuario con rol predeterminado 'U' (usuario común)
            $SQL = "INSERT INTO Usuarios (correo, nombre, apellidos, contrasena, rol) VALUES (?, ?, ?, ?, 'U');";

            // Prepara y ejecuta la consulta
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("ssss", $correo, $nombre, $apellidos, $hashed_password);
            $consulta->execute();
            $consulta->close();
        }

        /**
         * Identifica a un usuario mediante correo y contraseña.
         *
         * @param string $correo Correo del usuario.
         * @param string $contrasena Contraseña del usuario.
         * @return array|false Retorna los datos del usuario si es correcto, o `false` si falla.
         */
        public function identificacion($correo, $contrasena) {
            $SQL = "SELECT idUsuario, nombre, contrasena, rol FROM Usuarios WHERE correo = ?";

            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("s", $correo);
            $consulta->execute();
            $resultado = $consulta->get_result();

            if ($resultado->num_rows == 1) {
                $usuario = $resultado->fetch_assoc();

                // Verifica la contraseña ingresada con la almacenada
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    unset($usuario['contrasena']); // Elimina la contraseña antes de devolver los datos
                    return $usuario;
                } else {
                    return false; // Contraseña incorrecta
                }
            } else {
                return false; // Usuario no encontrado
            }
            $consulta->close();
        }

        /**
         * Comprueba si un correo ya está registrado en la base de datos.
         *
         * @param string $correo Correo a verificar.
         * @return bool `true` si está registrado, `false` en caso contrario.
         */
        public function correoRegistrado($correo) {
            $SQL = "SELECT idUsuario FROM Usuarios WHERE correo = ?";

            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param('s', $correo);
            $consulta->execute();
            $resultado = $consulta->get_result();

            return $resultado->num_rows > 0; // Retorna verdadero si se encuentra al menos un registro
        }

        /**
         * Elimina un usuario y sus datos relacionados en la base de datos.
         *
         * @param int $idUsuario ID del usuario a eliminar.
         * @return array Resultado de la operación con estado y mensaje.
         */
        public function eliminarUsuario($idUsuario) {
            $this->conexion->begin_transaction(); // Inicia la transacción

            try {
                // Elimina etapas relacionadas
                $sqlEtapas = "DELETE FROM UsuarioEtapas WHERE idUsuario = ?";
                $stmtEtapas = $this->conexion->prepare($sqlEtapas);
                $stmtEtapas->bind_param("i", $idUsuario);
                $stmtEtapas->execute();
                $stmtEtapas->close();

                // Elimina solicitudes relacionadas
                $sqlSolicitudes = "DELETE FROM Solicitudes WHERE idUsuarioSolicitante = ?";
                $stmtSolicitudes = $this->conexion->prepare($sqlSolicitudes);
                $stmtSolicitudes->bind_param("i", $idUsuario);
                $stmtSolicitudes->execute();
                $stmtSolicitudes->close();

                // Elimina el usuario
                $sqlUsuario = "DELETE FROM Usuarios WHERE idUsuario = ?";
                $stmtUsuario = $this->conexion->prepare($sqlUsuario);
                $stmtUsuario->bind_param("i", $idUsuario);
                $stmtUsuario->execute();
                $stmtUsuario->close();

                $this->conexion->commit(); // Confirma la transacción
                return ['status' => 'success', 'message' => 'Usuario y sus datos eliminados exitosamente'];
            } catch (Exception $e) {
                $this->conexion->rollback(); // Revierte la transacción en caso de error
                return ['status' => 'error', 'message' => 'Error al eliminar usuario: ' . $e->getMessage()];
            }
        }

        // usuarios.php
        public function guardarToken($correo, $token, $expiracion) {
            $SQL = "UPDATE Usuarios SET token_recuperacion = ?, expiracion_token = ? WHERE correo = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("sis", $token, $expiracion, $correo);
            $consulta->execute();
            $consulta->close();
        }

        // usuarios.php
        public function validarToken($token) {
            $SQL = "SELECT idUsuario FROM Usuarios WHERE token_recuperacion = ? AND expiracion_token > ?";
            $consulta = $this->conexion->prepare($SQL);
            $tiempoActual = time();
            $consulta->bind_param("si", $token, $tiempoActual);
            $consulta->execute();
            $resultado = $consulta->get_result();

            return $resultado->num_rows === 1 ? $resultado->fetch_assoc() : false;
        }

        public function actualizarContrasena($idUsuario, $nuevaContrasena) {
            $SQL = "UPDATE Usuarios SET contrasena = ? WHERE idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("si", $nuevaContrasena, $idUsuario);
            $consulta->execute();
            $consulta->close();
        }

        public function invalidarToken($idUsuario) {
            $SQL = "UPDATE Usuarios SET token_recuperacion = NULL, expiracion_token = NULL WHERE idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idUsuario);
            $consulta->execute();
            $consulta->close();
        }

    }
?>
