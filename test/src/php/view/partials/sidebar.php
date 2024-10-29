<!-- BARRA DE MENÚ LATERAL QUE COMPARTEN TODOS LOS PANELES -->
<?php
    //VAMOS A PASAR LA INFORMACION REQUERIDA DE LA VISTA POR URL O POR EL CONTROLADOR
?>

<div class="sidebar">
    <h2>Menú</h2>
    <ul>
        <?php if ($rol === 'admin'): ?>
            <li><a href="#" onclick="mostrarSeccion('crear-usuario'); ocultarBienvenida();">Crear Usuario</a></li>
            <li><a href="#" onclick="mostrarSeccion('gestionar-cursos'); ocultarBienvenida();">Gestionar Cursos</a></li>
            <li><a href="#" onclick="mostrarSeccion('ver-estadisticas'); ocultarBienvenida();">Ver Estadísticas</a></li>
        <?php elseif ($rol === 'moderador'): ?>
            <li><a href="#" onclick="mostrarSeccion('ver-lista'); ocultarBienvenida();">Ver Lista de Solicitudes</a></li>
            <li><a href="#" onclick="mostrarSeccion('comprobar-estadisticas'); ocultarBienvenida();">Comprobar Estadísticas</a></li>
        <?php elseif ($rol === 'usuario'): ?>
            <li><a href="#" onclick="mostrarSeccion('solicitar-ausencia'); ocultarBienvenida();">Solicitar Ausencia</a></li>
            <li><a href="#" onclick="mostrarSeccion('ver-historial'); ocultarBienvenida();">Ver Historial de Solicitudes</a></li>
        <?php endif; ?>
    </ul>
</div>