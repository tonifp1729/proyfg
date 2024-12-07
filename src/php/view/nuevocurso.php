<!-- VISTA DEL FORMULARIO PARA INICIAR UN NUEVO CURSO --------------------------------------------------------------------------------->
<div class="container">
    <h1>Iniciar Nuevo Curso</h1>
    <form action="index.php?controlador=Course&action=iniciarCurso" method="POST">
        <div class="form-group">
            <label for="anoAcademico">Año Académico:</label>
            <input type="number" id="anoAcademico" name="anoAcademico" placeholder="Ejemplo: 2024">
        </div>
        <div class="form-group">
            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio">
        </div>
        <div class="form-group">
            <label for="fechaFinalizacion">Fecha de Finalización:</label>
            <input type="date" id="fechaFinalizacion" name="fechaFinalizacion">
        </div>
        <button type="submit">Iniciar Curso</button>
    </form>
</div>