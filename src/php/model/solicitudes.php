<?php
    require_once 'db.php';

    class Solicitudes {
        private $conexion;

        public function __construct() {
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        //Con este método obtenemos los motivos que utilizará el usuario como justificación de la ausencia
        public function obtenerMotivos() {
            $sql = "SELECT idMotivo, nombreMotivo FROM Motivos";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->get_result();
            
            $motivos = [];
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $motivos[] = $fila;
                }
            }
            
            return $motivos;
        }

        //Listamos los archivos según la solicitud -------------- INCOMPLETA!!
        public function listarArchivosSolicitud($idUsuario, $fechaInicioAusencia) {
            $sql = "SELECT nombreOriginal, nombreGenerado, categoria, rutaArchivo FROM Archivos WHERE idUsuarioArchiva = ? AND fechaInicioAusencia = ?";
            $consulta = $conexion->prepare($sql);
            $consulta->bind_param("is", $idUsuario, $fechaInicioAusencia);
            $consulta->execute();
            $resultado = $consulta->get_result();
        }


        public function guardarArchivo($idUsuarioArchiva, $fechaInicioAusencia, $nombreOriginal, $nombreGenerado, $tipoArchivo, $rutaArchivo) {
            $sql = "INSERT INTO Archivos (idUsuarioArchiva, fechaInicioAusencia, nombreOriginal, nombreGenerado, tipoArchivo, rutaArchivo)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("isssss", $idUsuarioArchiva, $fechaInicioAusencia, $nombreOriginal, $nombreGenerado, $tipoArchivo, $rutaArchivo);
            
            return $consulta->execute();
        }
        
        //Presentamos una nueva solicitud
        public function insertarSolicitud() {
            
        }
    }