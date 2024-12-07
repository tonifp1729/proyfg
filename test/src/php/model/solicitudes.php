<?php
/**
 * Clase `Solicitudes` que gestiona la interacción con la tabla `Solicitudes` en la base de datos.
 */

require_once 'db.php';

class Solicitudes {
    /** @var mysqli $conexion Objeto de conexión a la base de datos. */
    private $conexion;

    /**
     * Constructor de la clase.
     * Establece la conexión con la base de datos al crear una instancia.
     */
    public function __construct() {
        $db = new Conexiondb();
        $this->conexion = $db->conexion;
    }

    /**
     * Obtiene todas las solicitudes realizadas por un usuario específico.
     * 
     * @param int $idUsuario ID del usuario solicitante.
     * @return array Arreglo con las solicitudes encontradas.
     */
    public function obtenerSolicitudesPorUsuario($idUsuario) {
        $sql = "SELECT * FROM Solicitudes WHERE idUsuarioSolicitante = ?";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("i", $idUsuario);
        $consulta->execute();
        return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Obtiene todas las solicitudes asociadas a un curso específico.
     * 
     * @param int $idCurso ID del curso.
     * @return array Arreglo con las solicitudes del curso.
     */
    public function obtenerSolicitudesPorCurso($idCurso) {
        $sql = "SELECT * FROM Solicitudes WHERE idCurso = ?";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("i", $idCurso);
        $consulta->execute();
        return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Obtiene todas las solicitudes relacionadas a un curso y una etapa específica.
     * 
     * @param int $idCurso ID del curso.
     * @param int $idEtapa ID de la etapa.
     * @return array Arreglo con las solicitudes que cumplen los criterios.
     */
    public function obtenerSolicitudesPorCursoYEtapa($idCurso, $idEtapa) {
        $sql = "SELECT s.* FROM Solicitudes s
                INNER JOIN UsuarioEtapas ue ON s.idUsuarioSolicitante = ue.idUsuario
                WHERE s.idCurso = ? AND ue.idEtapa = ?";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("ii", $idCurso, $idEtapa);
        $consulta->execute();
        return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Obtiene todas las solicitudes activas cuya fecha de inicio sea posterior a la fecha actual.
     * 
     * @return array Arreglo con las solicitudes activas.
     */
    public function obtenerSolicitudesActivas() {
        $sql = "SELECT * FROM Solicitudes WHERE fechaInicioAusencia > CURDATE()";
        $consulta = $this->conexion->query($sql);
        return $consulta->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Obtiene solicitudes filtradas por estado (aprobadas, rechazadas o pendientes).
     * 
     * @param int $estado Estado de la solicitud.
     * @return array Arreglo con las solicitudes filtradas.
     */
    public function obtenerSolicitudesPorEstado($estado) {
        $sql = "SELECT * FROM Solicitudes WHERE estado = ?";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("i", $estado);
        $consulta->execute();
        return $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Crea una nueva solicitud de ausencia.
     * 
     * @param int $idUsuarioSolicitante ID del usuario que realiza la solicitud.
     * @param string $fechaInicio Fecha de inicio de la ausencia.
     * @param string $fechaFin Fecha de finalización de la ausencia.
     * @param int $horas Cantidad de horas de ausencia.
     * @param string $motivo Motivo de la ausencia.
     * @param string $descripcion Descripción detallada del motivo.
     * @param int $idCurso ID del curso relacionado.
     * @return array Resultado del intento de creación de la solicitud.
     */
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
?>
