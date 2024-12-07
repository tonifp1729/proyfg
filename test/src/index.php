<?php
    //ESTE ES EL CONTROLADOR PRINCIPAL DE LA APLICACIÓN
    require_once 'config/config.php';

    //Asignar valores predeterminados para el controlador y la acción
    if (!isset($_GET["controlador"])) $_GET["controlador"] = constant("DEFAULT_CONTROLLER");
    if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

    //Definir la ruta del controlador solicitado
    $rutaControlador = 'php/controller/' . $_GET["controlador"] . '_Controller.php';

    //Verificamos que el controlador exista y de lo contrario usamos el controlador por defecto
    if (!file_exists($rutaControlador)) $rutaControlador = 'src/php/controller/' . constant("DEFAULT_CONTROLLER") . '.php';

    //Cargamos el controlador solicitado
    require_once $rutaControlador;
    $controladorNombre = $_GET["controlador"].'_Controller';
    $controlador = new $controladorNombre();

    //Comprobamos que se halla definido el método solicitado y lo llama
    $datosVista["data"] = array();
    if(method_exists($controlador,$_GET["action"])) $datosVista["data"] = $controlador->{$_GET["action"]}();

    // Depuración
    var_dump($datosVista);

    //Obtenemos el error que puede recibirse desde el controlador para utilizarlo en la vista de ser necesario
    $error = isset($datosVista["data"]["error"]) ? $datosVista["data"]["error"] : null;

    //Cargamos cada una de las partes de la vista
    require_once 'php/view/partials/header.php'; //Cargamos el header
    require_once 'php/view/' . $controlador->view . '.php'; //Cargamos la parte principal de la vista
    if (isset($_SESSION['rol']) && $_SESSION['rol'] != null) {
        require_once 'php/view/partials/sidebar.php'; //Cargamos la sidebar si el rol existe
    }
    require_once 'php/view/partials/footer.php'; //Cargamos el footer