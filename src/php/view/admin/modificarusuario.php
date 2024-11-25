<!-- MENÚ DE ADMINISTRADOR ----------------------------------------------------------------------------------->
<!-- VISTA ROLES USUARIO -->
<div id="modificar-usuario">
    <h2>Editar Usuario</h2>
    <form id="form-editar-usuario">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" readonly><br>
        
        <label for="correo">Correo:</label>
        <input type="text" id="correo" readonly><br>

        <label for="rol">Rol:</label>
        <select id="rol">
            <!-- este campo debería presentar las opciones de selección de rol de manera dinámica, pues tal vez se añadan roles o haya roles que no se pueden dar a unos usuarios (el administrador dirsecundaria siempre será admin y no se puede modificar nada de este) -->
            <option value="U">Usuario</option>
            <option value="M">Moderador</option>
            <option value="A">Administrador</option>
        </select><br>

        <label for="etapas">Etapas:</label>
        <select id="etapas" multiple>
            <!-- Etapas disponibles, otra tabla que hay que incluir -->
        </select><br>

        <button type="button" onclick="guardarCambios()">Guardar Cambios</button>
    </form>
</div>