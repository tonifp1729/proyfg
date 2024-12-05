<?php
    require_once 'db.php';

    class Usuarios {
        private $conexion;

        public function __construct() {
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        public function insertarUsuario($correo, $nombre, $apellidos, $contrasena) {
            //Cifrar la contraseña antes de almacenarla
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
    
            //Consulta SQL para insertar al nuevo alumno en la bd y lo define como un usuario común de la aplicación al momento del registro
            $SQL = "INSERT INTO Usuarios (correo, nombre, apellidos, contrasena, rol) VALUES (?, ?, ?, ?, 'U');";
            
            //Preparamos la consulta
            $consulta = $this->conexion->prepare($SQL);
            
            //Vinculamos los parámetros a la consulta
            $consulta->bind_param("ssss", $correo, $nombre, $apellidos, $hashed_password);
            
            //Ejecutamos la consulta
            $consulta->execute();
            
            //Cerramos la consulta
            $consulta->close();
        }

        public function identificacion($correo, $contrasena) {
            //Consulta SQL para obtener el hash de la contraseña del usuario
            $SQL = "SELECT idUsuario, nombre, contrasena, rol FROM Usuarios WHERE correo = ?";
            
            //Preparamos la consulta
            $consulta = $this->conexion->prepare($SQL);
            
            //Vinculamos los parámetros a la consulta
            $consulta->bind_param("s", $correo);
            
            //Ejecutar la consulta
            $consulta->execute();
            
            //Obtenemos el resultado de la consulta
            $resultado = $consulta->get_result();
            
            //Comprobamos si se encontró una fila correspondiente al correo proporcionado
            if ($resultado->num_rows == 1) {
                //Obtenemos el id del alumno y el hash de la contraseña
                $usuario = $resultado->fetch_assoc();
                
                //Verificar la contraseña ingresada contra el hash almacenado
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    //Eliminamos la contraseña del array antes de devolverlo
                    unset($usuario['contrasena']);
                    return $usuario;
                } else {
                    //Contraseña incorrecta
                    return false;
                }
            } else {
                //No se encontró el usuario introducido
                return false;
            }

            //Cerramos la consulta
            $consulta->close();
        }

        public function correoRegistrado($correo) {
            //Consulta SQL para obtener el id del usuario que tiene el correo introducido
            $SQL = "SELECT idUsuario FROM Usuarios WHERE correo = ?";

            //Preparamos la consulta
            $consulta = $this->conexion->prepare($SQL);

            // Vinculamos el parámetro con la variable $correo
            $consulta->bind_param('s', $correo);

            // Ejecutamos la consulta
            $consulta->execute();

            // Obtenemos el resultado
            $resultado = $consulta->get_result();

            //Verificamos si se encontró una coincidencia en la BD
            if ($resultado->num_rows > 0) {
                return true; //El usuario con este correo ya existe
            } else {
                return false; //El usuario no existe
            }
        }

        public function eliminarUsuario($idUsuario) {
            //Iniciamos la transacción
            $this->conexion->begin_transaction();
        
            try {
                //Eliminar las etapas relacionadas con el usuario
                $sqlEtapas = "DELETE FROM UsuarioEtapas WHERE idUsuario = ?";
                $stmtEtapas = $this->conexion->prepare($sqlEtapas);
                $stmtEtapas->bind_param("i", $idUsuario);
                $stmtEtapas->execute();
                $stmtEtapas->close();
        
                //Eliminar las solicitudes relacionadas con el usuario
                $sqlSolicitudes = "DELETE FROM Solicitudes WHERE idUsuarioSolicitante = ?";
                $stmtSolicitudes = $this->conexion->prepare($sqlSolicitudes);
                $stmtSolicitudes->bind_param("i", $idUsuario);
                $stmtSolicitudes->execute();
                $stmtSolicitudes->close();
        
                //Eliminar el usuario
                $sqlUsuario = "DELETE FROM Usuarios WHERE idUsuario = ?";
                $stmtUsuario = $this->conexion->prepare($sqlUsuario);
                $stmtUsuario->bind_param("i", $idUsuario);
                $stmtUsuario->execute();
                $stmtUsuario->close();
        
                //Confirmamos la transacción
                $this->conexion->commit();
        
                return ['status' => 'success', 'message' => 'Usuario y sus datos relacionados eliminados exitosamente'];
            } catch (Exception $e) {
                //Si ocurre algún error se hace un rollback para deshacer los cambios
                $this->conexion->rollback();
        
                return ['status' => 'error', 'message' => 'Error al eliminar usuario: ' . $e->getMessage()];
            }
        }
    }