<!-- VISTA DEL FORMULARIO PARA NUEVA SOLICITUD --------------------------------------------------------------------------------->
<div class="content-section">
    <h1>Nueva Solicitud</h1>
    <form action="index.php?controlador=Leaverequests&action=procesarSolicitud" method="post" enctype="multipart/form-data">
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
        
        <!-- Campos de selección de horas -->
        <div id="horas-group">
            <h3>Selecciona Horas:</h3>
            <label><input type="checkbox" name="horas[]" value="1"> 1ª Hora</label>
            <label><input type="checkbox" name="horas[]" value="2"> 2ª Hora</label>
            <label><input type="checkbox" name="horas[]" value="3"> 3ª Hora</label>
            <label><input type="checkbox" name="horas[]" value="4"> 4ª Hora</label>
            <label><input type="checkbox" name="horas[]" value="5"> 5ª Hora</label>
            <label><input type="checkbox" name="horas[]" value="6"> 6ª Hora</label>
            <label><input type="checkbox" name="horas[]" value="7"> 7ª Hora</label>
        </div>

        <!-- Checkbox "Todo el Día" -->
        <div id="checkbox-todo-el-dia">
            <label>
                <input type="checkbox" id="todo-el-dia" onchange="activarHoras()"> Todo el Día
            </label>
        </div>

            <!-- Botón Enviar Solicitud -->
        <div id="enviar-container">
            <button class="tamanio" type="submit">Enviar Solicitud</button>
        </div>
    </form>
</div>
<script src="js/solicitud.js"></script>