<?php
    //ESTE ES EL CONTROLADOR PRINCIPAL DE LA APLICACIÓN
    require_once 'config/config.php';
    require_once 'config/path.php';

    //Asignar valores predeterminados para el controlador y la acción
    if (!isset($_GET["controlador"])) $_GET["controlador"] = constant("DEFAULT_CONTROLLER");
    if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

    //Definir la ruta del controlador solicitado
    $rutaControlador = 'php/controller/' . $_GET["controlador"] . '.php';

    //Verificamos que el controlador exista y de lo contrario usamos el controlador por defecto
    if (!file_exists($rutaControlador)) $rutaControlador = 'src/php/controller/' . constant("DEFAULT_CONTROLLER") . '.php';

    //Iniciar sesión si aún no está iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //Cargamos el controlador solicitado
    require_once $rutaControlador;
    $controladorNombre = $_GET["controlador"] . '_Controller';
    $controlador = new $controladorNombre();

    //Verificamos que el método solicitado exista y lo ejecutamos
    $datosVista = ["data" => [], "error" => null];
    if (method_exists($controlador, $_GET["action"])) {
        $datosVista = $controlador->{$_GET["action"]}();
    }

    //Determinar si la `sidebar` debe cargarse (según sesión o lógica específica)
    $mostrarSidebar = isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);

    //Cargamos cada una de las partes de la vista
    require_once 'php/view/partials/header.php'; //Cargamos el header
    if ($mostrarSidebar) {
        require_once 'php/view/partials/sidebar.php'; //Cargamos la sidebar condicionalmente
    }
    require_once 'php/view/' . $controlador->view . '.php'; //Cargamos la parte principal de la vista
    require_once 'php/view/partials/footer.php'; //Cargamos el footer