<?php
    $rol = 'moderador'; // Definimos el rol del usuario actual
    include 'partials/header.php'; // Carga el encabezado dinámico
    include 'partials/sidebar.php'; // Incluye el sidebar específico del moderador
?>

<div class="main-content">
    <div id="bienvenida">
        <h1>Bienvenido, Moderador</h1>
        <p>Desde este panel, puedes gestionar solicitudes y verificar estadísticas.</p>
    </div>

    <section id="ver-lista" class="content-section" style="display: none;">
        <h2>Ver Lista de Solicitudes</h2>
        <table id="solicitudes-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Número Solicitud</th>
                    <th>Docente</th>
                    <th>Asunto</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Activa</th>
                </tr>
            </thead>
            <tbody>
                <tr data-color="verde">
                    <td><a href="#" title="Modificar" onclick="mostrarDetallesSolicitud('verde');"><img src="iconos/consultar.svg" alt="Modificar" width="24" height="24"></a></td>
                    <td>20241002_01</td>
                    <td>Juan Pérez</td>
                    <td>Revisión Médica</td>
                    <td>2024-10-12</td>
                    <td>2024-10-13</td>
                    <td>Aceptada</td>
                    <td><span class="semáforo verde"></span></td>
                </tr>
                <!-- Otros datos de solicitudes -->
            </tbody>
        </table>
    </section>

    <section id="comprobar-estadisticas" class="content-section" style="display: none;">
        <h2>Comprobar Estadísticas</h2>
        <!-- Gráficos o tablas de estadísticas -->
    </section>
</div>

<?php include 'partials/footer.php'; ?>