<?php
    require_once 'db.php';

    class Solicitudes {
        private $conexion;

        public function __construct() {
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        //Obtenemos todas las solicitudes de un usuario específico
        public function obtenerSolicitudesPorUsuario($idUsuario) {
            $sql = "SELECT * FROM Solicitudes WHERE idUsuarioSolicitante = ?";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("i", $idUsuario);
            $consulta->execute();
            return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        //Obtenemos todas las solicitudes asociadas a un curso específico
        public function obtenerSolicitudesPorCurso($idCurso) {
            $sql = "SELECT * FROM Solicitudes WHERE idCurso = ?";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("i", $idCurso);
            $consulta->execute();
            return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        //Obtenemos todas las solicitudes asociadas a un curso y una etapa específica
        public function obtenerSolicitudesPorCursoYEtapa($idCurso, $idEtapa) {
            $sql = "SELECT s.* FROM Solicitudes s
                    INNER JOIN UsuarioEtapas ue ON s.idUsuarioSolicitante = ue.idUsuario
                    WHERE s.idCurso = ? AND ue.idEtapa = ?";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("ii", $idCurso, $idEtapa);
            $consulta->execute();
            return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        //Obtenemos solicitudes activas (solo hasta el día anterior al inicio)
        public function obtenerSolicitudesActivas() {
            $sql = "SELECT * FROM Solicitudes WHERE fechaInicioAusencia > CURDATE()";
            $consulta = $this->conexion->query($sql);
            return $consulta->fetch_all(MYSQLI_ASSOC);
        }

        //Obtenemos solicitudes por estado (aprobadas, rechazadas, pendientes)
        public function obtenerSolicitudesPorEstado($estado) {
            $sql = "SELECT * FROM Solicitudes WHERE estado = ?";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("i", $estado);
            $consulta->execute();
            return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        
        //creamos una nueva solicitud
        public function crearSolicitud($idUsuarioSolicitante, $fechaInicio, $fechaFin, $horas, $motivo, $descripcion, $idCurso) {
            $sql = "INSERT INTO Solicitudes (idUsuarioSolicitante, fechaInicioAusencia, fechaFinAusencia, horasAusencia, motivo, descripcionMotivo, estado, idCurso)
                    VALUES (?, ?, ?, ?, ?, ?, NULL, ?)";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("ississi", $idUsuarioSolicitante, $fechaInicio, $fechaFin, $horas, $motivo, $descripcion, $idCurso);
    
            if ($consulta->execute()) {
                return ['status' => 'success', 'message' => 'Solicitud creada exitosamente'];
            } else {
                return ['status' => 'error', 'message' => 'Error al crear la solicitud'];
            }
        }
    }