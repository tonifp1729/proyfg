<!-- CLASE QUE GESTIONA EL CAMBIO DE VISTAS -->
<?php

    class View {
        public static function render($view, $data = []) {
            extract($data);
            require_once 'src/php/view/' . $view . '.php';
        }
    }
    
?>