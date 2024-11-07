<?php
    require_once 'db.php';

    class Usuarios {
        private $conexion;

        public function __construct() {
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        // Método para guardar usuario (ya implementado)
        public function guardarUsuario($correo, $nombre, $apellidos) {
            $SQL = "SELECT * FROM Usuarios WHERE correo = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("s", $correo);
            $consulta->execute();
            $resultado = $consulta->get_result();

            if ($resultado->num_rows === 0) {
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

        // Método para obtener los datos de un usuario (incluyendo rol y etapas)
        public function obtenerUsuario($idUsuario) {
            $SQL = "SELECT * FROM Usuarios WHERE idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->get_result();

            if ($resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();

                // Obtenemos las etapas del usuario
                $SQL = "SELECT idEtapa FROM usuarios_etapas WHERE idUsuario = ?";
                $etapasConsulta = $this->conexion->prepare($SQL);
                $etapasConsulta->bind_param("i", $idUsuario);
                $etapasConsulta->execute();
                $etapasResult = $etapasConsulta->get_result();

                $etapas = [];
                while ($etapa = $etapasResult->fetch_assoc()) {
                    $etapas[] = $etapa['idEtapa'];
                }

                $usuario['etapas'] = $etapas;

                $consulta->close();
                return ['status' => 'success', 'usuario' => $usuario];
            } else {
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }
        }

        // Método para asignar un rol a un usuario
        public function asignarRol($idUsuario, $nuevoRol) {
            $SQL = "UPDATE Usuarios SET rol = ? WHERE idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("si", $nuevoRol, $idUsuario);

            if ($consulta->execute()) {
                $consulta->close();
                return ['status' => 'success', 'message' => 'Rol actualizado correctamente'];
            } else {
                $consulta->close();
                return ['status' => 'error', 'message' => 'No se pudo actualizar el rol'];
            }
        }

        // Método para asignar etapas a un usuario
        public function asignarEtapas($idUsuario, $etapas) {
            // Elimina las etapas existentes del usuario para evitar duplicados
            $SQL = "DELETE FROM usuarios_etapas WHERE idUsuario = ?";
            $deleteStmt = $this->conexion->prepare($SQL);
            $deleteStmt->bind_param("i", $idUsuario);
            $deleteStmt->execute();
            $deleteStmt->close();

            // Inserta las nuevas etapas
            $SQL = "INSERT INTO usuarios_etapas (idUsuario, idEtapa) VALUES (?, ?)";
            $insertStmt = $this->conexion->prepare($SQL);

            foreach ($etapas as $etapa) {
                $insertStmt->bind_param("is", $idUsuario, $etapa);
                $insertStmt->execute();
            }

            $insertStmt->close();
            return ['status' => 'success', 'message' => 'Etapas asignadas correctamente'];
        }

        // Método para eliminar una etapa del usuario
        public function eliminarEtapa($idUsuario, $idEtapa) {
            $SQL = "DELETE FROM usuarios_etapas WHERE idUsuario = ? AND idEtapa = ?";
            $deleteStmt = $this->conexion->prepare($SQL);
            $deleteStmt->bind_param("ii", $idUsuario, $idEtapa);
            $deleteStmt->execute();
            $deleteStmt->close();
            return ['status' => 'success', 'message' => 'Etapa eliminada correctamente'];
        }

        public function eliminarUsuario($idUsuario) {
            // Eliminación de etapas
            $SQL = "DELETE FROM usuarios_etapas WHERE idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idUsuario);
            $consulta->execute();
            $consulta->close();
        
            // Eliminación de solicitudes
            $SQL = "DELETE FROM Solicitudes WHERE idUsuarioSolicitante = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idUsuario);
            $consulta->execute();
            $consulta->close();
        
            // Eliminación del usuario
            $SQL = "DELETE FROM Usuarios WHERE idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idUsuario);
            $resultado = $consulta->execute();
            $consulta->close();
        
            if ($resultado) {
                return ['status' => 'success', 'message' => 'Usuario y datos relacionados eliminados exitosamente'];
            } else {
                return ['status' => 'error', 'message' => 'Error al eliminar el usuario'];
            }
        }        
    }