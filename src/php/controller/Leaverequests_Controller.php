<!-- CONTROLADOR PARA LAS ACCIONES RELACIONADAS CON LAS SOLICITUDES -->
<?php

    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\solicitudes.php';
    require_once 'C:\Users\Antonio\WorkSpace\Xampp\htdocs\espacio-proyectos\proyfg\src\php\model\cursos.php';

    class Leaverequests_Controller {
        public $view;
        private $solicitud;
        private $curso;

        public function __construct() {
            $this->solicitud = new Solicitudes();
            $this->curso = new Cursos();
        }

        //Necesitamos generar nombres únicos para los archivos que se van a introducir con cada solicitud
        function generarNombreUnico($archivo) {
            $nombreBase = pathinfo($archivo, PATHINFO_FILENAME); //Extrae el nombre inicial
            $extension = pathinfo($archivo, PATHINFO_EXTENSION); //Extrae la extensión
            $nombreCodificado = uniqid().'_'.hash('sha256', $nombreBase);
            return $nombreCodificado.'.'.$extension; //Combinamos el nuevo nombre que hemos generado con la extensión
        }

        //Necesitamos calcular el total de horas de ausencia entre dos fechas
        function calcularHorasAusencia($fechaInicio, $fechaFin) {
            //Convertimos las fechas de string a objetos DateTime
            $inicio = new DateTime($fechaInicio);
            $fin = new DateTime($fechaFin);
            $fin->modify('+1 day'); //Necesitamos incluir el último día para sumarlo al cálculo
        
            //Variable para acumular las horas de ausencia
            $horasTotales = 0;
        
            //Creamos un intervalo de 1 día
            $intervalo = new DateInterval('P1D');
        
            //Creamos un período que recorra todos los días entre las fechas de inicio y fin
            $periodo = new DatePeriod($inicio, $intervalo, $fin);
        
            //Recorremos cada día en el periodo
            foreach ($periodo as $dia) {
                //Verificamos si el día es un día laborable (lunes a viernes)
                if ($dia->format('N') <= 5) { // 'N' devuelve 1 para lunes, 5 para viernes
                    // Si es lunes, asignamos 7 horas, si no, asignamos 6 horas
                    if ($dia->format('N') == 1) {
                        $horasTotales += 7; //Lunes
                    } else {
                        $horasTotales += 6; //Días de martes a viernes
                    }
                }
            }
        
            return $horasTotales;
        }

        public function procesarSolicitudVariosDias() {
            
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        
            //Recogemos los datos del formulario
            $motivo = $_POST['asunto'];
            $justificacion = $_POST['justificacion'];
            $material = $_FILES['material'];
            $justificante = $_FILES['justificante'];
            $fechaInicioAusencia = $_POST['fechaInicioAusencia'];
            $fechaFinAusencia = $_POST['fechaFinAusencia'];
            $horas = isset($_POST['horas']) ? $_POST['horas'] : []; // SOLO SE RECIBEN EN CASO DE QUE EL DÍA DE INICIO Y DE FIN SEAN EL MISMO
        
            //Consultamos el curso activo y extraemos el identificador
            $cursoActivo = $this->curso->cursoActivo();
            $idCursoActivo = $cursoActivo['idCurso'];
        
            //Procesamos los archivos en caso de que existan
            $infoJustificantes = [];
            if (!empty($justificante['name'][0])) {
                //Si hay múltiples archivos de justificación
                foreach ($justificante['name'] as $index => $fileName) {
                    $file = [
                        'name' => $justificante['name'][$index],
                        'tmp_name' => $justificante['tmp_name'][$index],
                        'type' => $justificante['type'][$index],
                        'error' => $justificante['error'][$index],
                        'size' => $justificante['size'][$index],
                    ];
                    $infoJustificantes[] = $this->manejarSubidaArchivos($file, 'justificantes');
                }
            }
        
            $infoMateriales = [];
            if (!empty($material['name'][0])) {
                //Si hay múltiples archivos de material
                foreach ($material['name'] as $index => $fileName) {
                    $file = [
                        'name' => $material['name'][$index],
                        'tmp_name' => $material['tmp_name'][$index],
                        'type' => $material['type'][$index],
                        'error' => $material['error'][$index],
                        'size' => $material['size'][$index],
                    ];
                    $infoMateriales[] = $this->manejarSubidaArchivos($file, 'material');
                }
            }
        
            //Comprobamos si es un solo día o varios
            if ($fechaInicioAusencia === $fechaFinAusencia) {
                //Calculamos el número de horas seleccionadas
                $horasAusencia = count($horas);
            } else {
                //Si son varios días, calculamos las horas
                $horasAusencia = $this->calcularHorasAusencia($fechaInicioAusencia, $fechaFinAusencia);
            }
        
            //Si no se seleccionaron horas, se cuentan todas
            if ($horasAusencia === 0) {
                $horasAusencia = 6;
            }
        
            //Guardamos la solicitud en la base de datos
            $this->solicitud->insertarSolicitud($_SESSION['id'], $motivo, $justificacion, $fechaInicioAusencia, $fechaFinAusencia, $horasAusencia, $idCursoActivo);
        
            //Guardamos los archivos en la base de datos (si existen)
            foreach ($infoJustificantes as $infoJustificante) {
                $this->solicitud->guardarArchivo(
                    $_SESSION['id'], 
                    $fechaInicioAusencia, 
                    $infoJustificante['nombreOriginal'], 
                    basename($infoJustificante['rutaRelativa']), 
                    $infoJustificante['tipoArchivo'], 
                    $infoJustificante['rutaRelativa']
                );
            }
        
            foreach ($infoMateriales as $infoMaterial) {
                $this->solicitud->guardarArchivo(
                    $_SESSION['id'], 
                    $fechaInicioAusencia, 
                    $infoMaterial['nombreOriginal'], 
                    basename($infoMaterial['rutaRelativa']), 
                    $infoMaterial['tipoArchivo'], 
                    $infoMaterial['rutaRelativa']
                );
            }
        
            //Redirigimos a la vista de éxito
            $this->exito();
        }
        
        
        private function manejarSubidaArchivos($archivo, $subdirectorio) {
            //Ruta base para los archivos subidos
            $rutaBase = 'C:/Users/Antonio/WorkSpace/Xampp/htdocs/espacio-proyectos/proyfg/uploads/';
            $rutaDestino = $rutaBase.$subdirectorio.'/';
            
            //Generar un nombre único para el archivo
            $nombreGenerado = $this->generarNombreUnico($archivo['name']);
            $rutaArchivoFinal = $rutaDestino.$nombreGenerado;
            
            //Movemos el archivo a su destino final
            move_uploaded_file($archivo['tmp_name'], $rutaArchivoFinal);
            
            //Guardamos la extensión del archivo
            $tipoArchivo = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            
            return [
                'rutaRelativa' => $subdirectorio.'/'.$nombreGenerado,
                'nombreOriginal' => $archivo['name'],
                'tipoArchivo' => $tipoArchivo
            ];
        }

        public function exito() {
            $this->view = "avisoexito";
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

        public function iramilistado() {
            $this->view = "listarmissolicitudes";
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

        public function irsolicitud() {
            $motivos = $this->solicitud->obtenerMotivos();
        
            $this->view = "nuevasolicitud";
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        
            return ['motivos' => $motivos];
        }        
    }
?>