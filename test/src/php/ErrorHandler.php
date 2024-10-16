<!-- CLASE PARA EL MANEJO DE ERRORES -->
<?php
    class ErrorHandler {
        public static function handle($error) {
            echo '<div class="error">'.$error.'</div>';
        }
    }
?>