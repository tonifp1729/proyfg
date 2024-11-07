<!-- CONTROLADOR PRINCIPAL DE LA APLICACIÓN -->
<?php

    require_once 'src/config/config.php';
    require_once 'src/php/Router.php';
    require_once 'src/php/View.php';
    require_once 'src/php/ErrorHandler.php';

    //Estos son el controlador y la acción por defecto
    $controller = $_GET["controlador"] ?? constant("DEFAULT_CONTROLLER");
    $action = $_GET["action"] ?? constant("DEFAULT_ACTION");

    $datosVista = Router::route($controller, $action);
    $error = $datosVista["error"] ?? null;

    if ($error) {
        ErrorHandler::handle($error);
    }

    View::render($controller.'/'.$action, $datosVista);
    
?>