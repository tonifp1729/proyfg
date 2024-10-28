<!-- ENRUTADOR QUE SE ENCARGA DEL CONTROL DE LAS URL Y REDIRIGE A LOS CONTROLADORES ADECUADOS PARA CADA MOMENTO -->
<?php

    class Router {
        public static function route($controller, $action) {
            $controllerName =  ucfirst($controller) . 'Controller';
            $controllerFile = 'src/php/controller/' . $controller . '.php';

            if (!file_exists($controllerFile)) {
                $controllerName = 'Controlador' . DEFAULT_CONTROLLER;
                $controllerFile = 'src/php/controller/' . DEFAULT_CONTROLLER . '.php';
            }

            require_once $controllerFile;
            $controllerInstance = new $controllerName();
            if (method_exists($controllerInstance, $action)) {
                return $controllerInstance->$action();
            } else {
                //Si la acción no ha sido encontrada devuelve nulo
                return null;
            }
        }
    }

?>