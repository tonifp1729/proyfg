<!-- VISTA DEL FORMULARIO PARA NUEVA SOLICITUD --------------------------------------------------------------------------------->
<div class="content-section">
    <h1>Nueva Solicitud</h1>
    <form action="index.php?controlador=Leaverequests&action=procesarSolicitudVariosDias" method="post" enctype="multipart/form-data">
        <div>
            <label for="asunto">Asunto de la Ausencia:</label>
            <select name="asunto" id="asunto">
                <option value="">--Marca una de las opciones--</option>
                <?php
                    //Verificamos que los datos estén disponibles antes de recorrer el array con los motivos
                    if (isset($datosVista['data']['motivos']) && !empty($datosVista['data']['motivos'])) {
                        foreach($datosVista['data']['motivos'] as $motivo) {
                            echo "<option value='".$motivo['idMotivo']."'>" .$motivo['nombreMotivo']."</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div>
            <label>Justificación de la Ausencia:</label>
            <textarea name="justificacion" rows="4"></textarea>
        </div>
        <div>
            <label>Subir Justificante:</label>
            <input type="file" name="justificante">
        </div>
        <div>
            <label>Fecha de Inicio:</label>
            <input type="date" id="fecha-inicio" name="fechaInicioAusencia" onchange="toggleHoras()">
        </div>
        <div>
            <label>Fecha de Fin:</label>
            <input type="date" id="fecha-fin" name="fechaFinAusencia" onchange="toggleHoras()">
        </div>
        <div>
            <label>Material de Guardia:</label>
            <input type="file" name="material">
        </div>
        <div>
            <label>Observaciones:</label>
            <textarea name="observaciones" rows="4"></textarea>
        </div>
        
        <!-- Botón Enviar Solicitud -->
        <div id="enviar-container">
            <button class="tamanio" type="submit">Enviar Solicitud</button>
        </div>
    </form>
</div>
<script src="js/solicitud.js"></script>