<!-- VISTA PARA MODIFICAR VALORES DEL CURSO --------------------------------------------------------------------------------->
<div class="modificar">
    <h2>Modificar Curso Activo</h2>

    <form action="index.php?controlador=Course&action=" method="POST">
        <div class="campo">
            <label for="anoAcademico">Año Académico:</label>
            <input type="text" name="anoAcademico" id="anoAcademico" value="<?= $cursoActivo['anoAcademico'] ?>" disabled>
        </div>

        <div class="campo">
            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" name="fechaInicio" id="fechaInicio" value="<?= $cursoActivo['fechaInicio'] ?>" required>
        </div>

        <div class="campo">
            <label for="fechaFinalizacion">Fecha de Finalización:</label>
            <input type="date" name="fechaFinalizacion" id="fechaFinalizacion" value="<?= $cursoActivo['fechaFinalizacion'] ?>" required>
        </div>

        <button type="submit">Actualizar Curso</button>
    </form>

</div>