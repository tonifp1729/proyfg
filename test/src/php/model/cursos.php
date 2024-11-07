<?php

    require_once 'db.php';

    class Cursos {
        private $conexion;

        public function __construct() {
            //Creamos un objeto e inicializamos la conexión a la base de datos
            $db = new Conexiondb();
            $this->conexion = $db->conexion;
        }

        /*
        *  Devuelve el listado completo de los cursos disponibles en la tabla Cursos.
        **/
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

        /*
        *  Devuelve la información de un curso específico basado en su ID.
        *  @param int $idCurso - ID del curso.
        **/
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

        /*
        *  Obtiene la lista de solicitudes realizadas durante el curso especificado.
        *  @param int $idCurso - ID del curso.
        *  @return array - Lista de solicitudes realizadas en el curso.
        */
        public function listarSolicitudesPorCurso($idCurso) {
            // Primero obtenemos las fechas de inicio y finalización del curso
            $SQL = "SELECT fechaInicio, fechaFinalizacion FROM Cursos WHERE idCurso = ?";
            $consultaCurso = $this->conexion->prepare($SQL);
            $consultaCurso->bind_param("i", $idCurso);
            $consultaCurso->execute();
            $consultaCurso->bind_result($fechaInicio, $fechaFinalizacion);
            $consultaCurso->fetch();
            $consultaCurso->close();

            // Consultamos las solicitudes en el rango de fechas del curso
            $SQL = "SELECT * FROM Solicitudes 
                    WHERE fechaInicioAusencia >= ? AND fechaFinAusencia <= ?";
            $consultaSolicitudes = $this->conexion->prepare($SQL);
            $consultaSolicitudes->bind_param("ss", $fechaInicio, $fechaFinalizacion);
            $consultaSolicitudes->execute();
            $resultado = $consultaSolicitudes->get_result();

            $solicitudes = [];
            while ($solicitud = $resultado->fetch_assoc()) {
                $solicitudes[] = $solicitud;
            }

            $consultaSolicitudes->close();
            return $solicitudes;
        }

        /*
        *  Inserta un nuevo curso en la tabla Cursos.
        **/
        public function iniciarCurso($anoAcademico, $fechaInicio, $fechaFinalizacion) {
            $SQL = "INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion) VALUES (?, ?, ?)";
            
            $consulta = $this->conexion->prepare($SQL);
            $consulta->bind_param("iss", $anoAcademico, $fechaInicio, $fechaFinalizacion);
            $consulta->execute();
            $consulta->close();
        }

        /*
        *  Comprueba si hay un curso actualmente activo basado en las fechas de inicio y finalización y lo devuelve.
        **/
        public function cursoActivo() {
            $SQL = "SELECT anoAcademico FROM Cursos WHERE CURDATE() BETWEEN fechaInicio AND fechaFinalizacion LIMIT 1";
            
            $consulta = $this->conexion->prepare($SQL);
            $consulta->execute();
            $anio = null;
            $consulta->bind_result($anio);
            $consulta->fetch();
            
            $consulta->close();
            return $anio;
        }
    }