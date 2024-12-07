<!-- CONTROLADOR PARA LAS ACCIONES RELACIONADAS CON LAS SOLICITUDES -->
<?php

    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\solicitudes.php';

    class Leaverequests_Controller {
        public $view;
        private $solicitud;

        public function __construct() {
            $this->solicitud = new Solicitudes();
        }

        //Necesitamos generar nombres únicos para los archivos que se van a introducir con cada solicitud
        function generarNombreUnico($archivo) {
            $nombreBase = pathinfo($archivo, PATHINFO_FILENAME); //Extrae el nombre inicial
            $extension = pathinfo($archivo, PATHINFO_EXTENSION); //Extrae la extensión
            $nombreCodificado = uniqid().'_'.hash('sha256', $nombreBase);
            return $nombreCodificado.'.'.$extension; //Combinamos el nuevo nombre que hemos generado con la extensión
        }

        //Necesitamos calcular el total de horas de ausencia entre dos fechas
        function calcularHorasAusencia($fechaInicio, $fechaFin, $horasMarcadas, $todoElDia) {
            //Convertimos las fechas de string a objetos DateTime
            $inicio = new DateTime($fechaInicio);
            $fin = new DateTime($fechaFin);
            $fin->modify('+1 day'); //Necesitamos incluir el último día para sumarlo al cálculo

            $horasTotales = 0;

            //Verificar si las fechas son iguales
            if ($fechaInicio == $fechaFin) {
                //Si son iguales, usamos las horas seleccionadas en el formulario
                if ($todoElDia) {
                    //Si se seleccionó "Todo el Día", asignamos el total de horas
                    $horasTotales = ($inicio->format('N') == 1) ? 7 : 6; // 7 horas para lunes, 6 horas para otros días
                } else {
                    //Si no se seleccionó "Todo el Día", contamos las horas según las casillas seleccionadas
                    $horasTotales = count($horasMarcadas);
                }
            } else {
                //Si las fechas son diferentes debemos iterar sobre los días
                $intervalo = new DateInterval('P1D'); //Definimos el intervalo en un día
                $periodo = new DatePeriod($inicio, $intervalo, $fin);

                foreach ($periodo as $dia) {
                    //Excluir sábados (6) y domingos (7)
                    if ($dia->format('N') != 6 && $dia->format('N') != 7) {
                        if ($todoElDia) {
                            //Si se seleccionó la casilla de "Todo el Día", vamos a asignarle el total de horas equivalentes a ese día
                            $horasTotales += ($dia->format('N') == 1) ? 7 : 6; //7 horas para los lunes, 6 horas para el resto de la semana
                        } else {
                            //Al no marcar la casilla para contar todo el día, contamos las horas según las casillas seleccionadas
                            $horasTotales += count($horasMarcadas);
                        }
                    }
                }
            }

            return $horasTotales;
        }

        public function guardarSolicitud() {

        }


        public function iramilistado() {
            $this->view = "listarmissolicitudes";
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

        public function irsolicitud() {
            //Al momento de cargar la vista es necesario cargar opciones de forma dinámica con la información de la BD
            $motivos = $this->solicitud->obtenerMotivos();

            $this->view = "nuevasolicitud";
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            return ['motivos' => $motivos];
        }
    }
?>