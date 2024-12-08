<?php

    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\cursos.php';
    

    class Course_Controller {

        public $view;
        private $curso;

        public function __construct() {
            $this->curso = new Cursos();
        }

        public function iniciarCurso() {
            $anoAcademico = null;
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFinalizacion = $_POST['fechaFinalizacion'];
    
            //Calcular el año académico
            $anoInicio = date('Y', strtotime($fechaInicio)); //Año de la fecha de inicio
            $anoFin = date('Y', strtotime($fechaFinalizacion)); //Año de la fecha de finalización
            
            //Concatenamos los años para formar el año académico
            $anoAcademico = $anoInicio.'/'.$anoFin;

            if (!empty($anoAcademico) && !empty($fechaInicio) && !empty($fechaFinalizacion)) {
                $this->curso->insertarCurso($anoAcademico, $fechaInicio, $fechaFinalizacion);
                $this->exito();
            } else {
                $this->irnuevocurso();
            }
        }
        
        public function exito() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view = "avisoexito";
        }

        public function mostrarUsuarios() {
            //FALTA CODE
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view = "listausuarios";
        }        

        public function mostrarCursoActual() {
            $cursoActivo = $this->curso->cursoActivo();

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view = "cursoactual";

            return ['cursoActivo' => $cursoActivo];
        }

        public function irnuevocurso() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view = "nuevocurso";
        }
    }
?>