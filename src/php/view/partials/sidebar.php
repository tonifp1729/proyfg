<!-- SIDEBAR ------------------------------------------------------------------------------------------------->
<div class="sidebar">
    <h2>Menú</h2>
    <!-- SE CARGARÁN DINÁMICAMENTE, MOSTRANDOSE DEPENDIENDO DEL TIPO DE USUARIO QUE ACCEDA -->
    <ul>
        <?php
            // SIDEBAR PARTIAL
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Verificar si el usuario tiene sesión iniciada
            if (isset($_SESSION['rol'])) {
                $rol = $_SESSION['rol'];
                echo '<div class="sidebar">
                        <h2>Menú</h2>
                        <ul>';
                switch ($rol) {
                    case 'U': //USUARIO COMÚN
                        echo '<li><a href="solicitudes.php">Solicitudes presentadas</a></li>';
                        echo '<li><a href="nueva_solicitud.php">Nueva solicitud</a></li>';
                        break;
                    case 'A': //USUARIO ADMINISTRADOR
                        echo '<li><a href="listar_usuarios.php">Gestión de usuarios</a></li>';
                        echo '<li><a href="crear_curso.php">Crear curso</a></li>';
                        echo '<li><a href="estadisticas.php">Estadísticas</a></li>';
                        break;
                    case 'M': //USUARIO MODERADOR
                        echo '<li><a href="solicitudes_moderar.php">Moderar solicitudes</a></li>';
                        echo '<li><a href="historial_moderacion.php">Historial de moderación</a></li>';
                        break;
                }
            }
        ?>
    </ul>
    <div class="logout">
        <a href="#">Cerrar Sesión</a>
    </div>
</div>