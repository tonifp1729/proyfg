<!-- VISTA PARA MODIFICACIÓN DE USUARIO --------------------------------------------------------------------------------->
<div>
    <h1>Gestión de usuario</h1>
    <p>Aquí puedes otorgar roles de usuario al docente seleccionado</p>

    <!-- Formulario de inicio de sesión -->
    <form action="index.php?controlador=User&action=modificarUsuario&idUsuario=<?php echo $idUsuario = $_GET['idUsuario']; ?>" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo isset($datosVista['data']['usuario']['nombre']) ? $datosVista['data']['usuario']['nombre'] : ''; ?>">
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo isset($datosVista['data']['usuario']['apellidos']) ? $datosVista['data']['usuario']['apellidos'] : ''; ?>">

        <div>
            <label for="rol">Rol del Usuario:</label>
            <select name="rol" id="rol">
                <?php
                if (isset($datosVista['data']['todosRoles']) && !empty($datosVista['data']['todosRoles'])) {
                    foreach ($datosVista['data']['todosRoles'] as $rol) {
                        echo "<option value='".$rol['idRol']."' ".($rol['idRol'] == $datosVista['data']['usuario']['rol'] ? 'selected' : '').">".$rol['nombreRol']."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div>
        <label>Etapas a las que pertenece:</label>
        <?php
            if (isset($datosVista['data']['todasEtapas']) && !empty($datosVista['data']['todasEtapas'])) {
                foreach ($datosVista['data']['todasEtapas'] as $etapa) {
                    $checked = in_array($etapa['idEtapa'], $datosVista['data']['etapasUsuario']) ? 'checked' : '';
                    echo "<div>
                            <input type='checkbox' name='etapas[]' value='".$etapa['idEtapa']."' id='etapa".$etapa['idEtapa']."' $checked>
                            <label for='etapa".$etapa['idEtapa']."'>".$etapa['nombreEtapa']."</label>
                        </div>";
                }
            }
            ?>
        </div>

        <button type="submit">Completar modificación</button>
    </form>
</div>

<!-- Cargamos el archivo del script JS -->
<!-- <script src="js/modusuario.js"></script> -->