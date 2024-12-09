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

        //Obtenemos todas las etapas a las que puede pertenecer un profesor
        public function obtenerTodasEtapas() {
            $SQL = "SELECT idEtapa, nombreEtapa FROM Etapas";
            $resultado = $this->conexion->query($SQL);
            
            $etapas = [];
            while ($etapa = $resultado->fetch_assoc()) {
                $etapas[] = $etapa;
            }
            return $etapas;
        }

        //Obtenemos todos los roles que pueden ser asignados a un profesor
        public function obtenerTodosRoles() {
            $SQL = "SELECT idRol, nombreRol FROM Roles";
            $resultado = $this->conexion->query($SQL);
            
            $roles = [];
            while ($rol = $resultado->fetch_assoc()) {
                $roles[] = $rol;
            }
            return $roles;
        }

        public function listarUsuarios() {
            $SQL = "SELECT idUsuario, nombre, apellidos FROM Usuarios";
            $resultado = $this->conexion->query($SQL);

            $usuarios = [];
            while ($usuario = $resultado->fetch_assoc()) {
                $usuarios[] = $usuario;
            }
            return $usuarios;
        }

        public function obtenerUsuario($idUsuario) {
            $SQL = "SELECT u.nombre, u.apellidos, u.rol, r.nombreRol FROM Usuarios u INNER JOIN Roles r ON u.rol = r.idRol WHERE u.idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $usuario = $resultado->fetch_assoc();
            $consulta->close();

            return $usuario;
        }

        public function obtenerEtapasUsuario($idUsuario) {
            $SQL = "SELECT ue.idEtapa FROM usuarios_etapas ue INNER JOIN Etapas e ON ue.idEtapa = e.idEtapa WHERE ue.idUsuario = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->get_result();
            
            $etapasUsuario = [];
            while ($etapa = $resultado->fetch_assoc()) {
                $etapasUsuario[] = $etapa['idEtapa'];
            }
            $consulta->close();
            return $etapasUsuario;
        }

        public function modificarUsuario($idUsuario, $nombre, $apellidos, $rol, $etapas) {
            //Actualizar los datos del usuario
            $sql = "UPDATE Usuarios SET nombre = ?, apellidos = ?, rol = ? WHERE idUsuario = ?";
            $consulta = $this->conexion->prepare($sql); // Usar $this->conexion en lugar de $this->db
            $consulta->bind_param('sssi', $nombre, $apellidos, $rol, $idUsuario);
            $consulta->execute();
        
            // Eliminar las etapas anteriores del usuario
            $sqlDelete = "DELETE FROM usuarios_etapas WHERE idUsuario = ?";
            $consultaDelete = $this->conexion->prepare($sqlDelete); // Usar $this->conexion en lugar de $this->db
            $consultaDelete->bind_param('i', $idUsuario);
            $consultaDelete->execute();
        
            // Insertar las nuevas etapas del usuario
            if (!empty($etapas)) {
                $queryInsert = "INSERT INTO usuarios_etapas (idUsuario, idEtapa) VALUES (?, ?)";
                foreach ($etapas as $etapa) {
                    $stmtInsert = $this->conexion->prepare($queryInsert); // Usar $this->conexion en lugar de $this->db
                    $stmtInsert->bind_param('is', $idUsuario, $etapa);
                    $stmtInsert->execute();
                }
            }
        
            //Cerrar la conexión
            $consulta->close();
            $consultaDelete->close();
        }                 
    }