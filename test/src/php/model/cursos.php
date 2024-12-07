<?php

    /**
     * Clase `Cursos` para gestionar los cursos almacenados en la base de datos.
     * Realiza operaciones CRUD y comprueba si hay un curso activo.
     */

    require_once 'db.php';

    class Cursos {

        /** @var mysqli $conexion Conexión a la base de datos. */
        private $conexion;

        /**
         * Constructor de la clase.
         * Inicializa la conexión a la base de datos mediante la clase `Conexiondb`.
         */
        public function __construct() {
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        /**
         * Obtiene una lista completa de los cursos disponibles en la tabla `Cursos`.
         *
         * @return array Un array con la información de todos los cursos.
         */
        public function listarCursos() {
            $SQL = "SELECT * FROM Cursos";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->execute();
            $resultado = $consulta->get_result();

            $cursos = [];
            while ($curso = $resultado->fetch_assoc()) {
                $cursos[] = $curso;
            }

            $consulta->close();
            return $cursos;
        }

        /**
         * Obtiene la información de un curso específico basado en su ID.
         *
         * @param int $idCurso ID del curso a consultar.
         * @return array|null Un array asociativo con los datos del curso o `null` si no se encuentra.
         */
        public function mostrarCurso($idCurso) {
            $SQL = "SELECT * FROM Cursos WHERE idCurso = ?";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("i", $idCurso);
            $consulta->execute();
            $resultado = $consulta->get_result();

            $curso = $resultado->fetch_assoc();

            $consulta->close();
            return $curso;
        }

        /**
         * Inserta un nuevo curso en la tabla `Cursos`.
         *
         * @param int $anoAcademico Año académico del curso.
         * @param string $fechaInicio Fecha de inicio del curso en formato `YYYY-MM-DD`.
         * @param string $fechaFinalizacion Fecha de finalización del curso en formato `YYYY-MM-DD`.
         * @return void
         */
        public function iniciarCurso($anoAcademico, $fechaInicio, $fechaFinalizacion) {
            $SQL = "INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion) VALUES (?, ?, ?)";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("iss", $anoAcademico, $fechaInicio, $fechaFinalizacion);
            $consulta->execute();
            $consulta->close();
        }

        /**
         * Comprueba si hay un curso actualmente activo basándose en las fechas de inicio y finalización.
         *
         * @return int|null El año académico del curso activo o `null` si no hay curso activo.
         */
        public function cursoActivo() {
            $SQL = "SELECT anoAcademico FROM Cursos WHERE CURDATE() BETWEEN fechaInicio AND fechaFinalizacion LIMIT 1";
            $consulta = $this->conexion->prepare($SQL);
            $consulta->execute();

            $anio = null;
            $consulta->bind_result($anio);
            $consulta->fetch();
            $consulta->close();

            return $anio ?: null;
        }
    }

?>
