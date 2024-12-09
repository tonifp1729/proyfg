<?php

    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\cursos.php';
    

    class Course_Controller {

        public $view;
        private $curso;

        public function __construct() {
            $this->curso = new Cursos();
        }

        public function iniciarCurso() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $anoAcademico = $_POST['anoAcademico'];
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFinalizacion = $_POST['fechaFinalizacion'];
        
                if (!empty($anoAcademico) && !empty($fechaInicio) && !empty($fechaFinalizacion)) {
                    $this->curso->insertarCurso($anoAcademico, $fechaInicio, $fechaFinalizacion);
                    $this->mostrarCursoActual();
                }
            }
        }
        
        public function mostrarUsuarios() {
            // FALTA CODE
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