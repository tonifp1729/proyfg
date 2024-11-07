<?php
    require_once 'db.php';

    class InicioSesion {
        private $conexion;

        public function __construct() {
            // Creamos un objeto e inicializamos la conexión a la base de datos
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        public function identificacion($correo, $contrasena) {
            //Consulta SQL para obtener el hash de la contraseña del usuario
            $SQL = "SELECT idAlumno, nombre, contrasenia FROM alumno WHERE correo = ?";
            
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
                $alumno = $resultado->fetch_assoc();
                
                //Verificar la contraseña ingresada contra el hash almacenado
                if (password_verify($contrasena, $alumno['contrasenia'])) {
                    //Eliminamos la contraseña del array antes de devolverlo
                    unset($alumno['contrasenia']);
                    return $alumno;
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
    }
?>