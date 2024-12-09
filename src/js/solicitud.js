document.addEventListener("DOMContentLoaded", function () {
    const fechaInicio = document.getElementById("fecha-inicio");
    const fechaFin = document.getElementById("fecha-fin");
    const todoElDia = document.getElementById("todo-el-dia");
    const horasGroup = document.getElementById("horas-group");
    const asuntoSelect = document.getElementById("asunto");
    const justificanteInput = document.querySelector("input[name='justificante']");
    const materialInput = document.querySelector("input[name='material']");
    const justificacion = document.querySelector("textarea[name='justificacion']");
    const observaciones = document.querySelector("textarea[name='observaciones']");
    const form = document.querySelector("form");

    //Validación de formato de archivo
    function validarArchivo(input) {
        const formatosPermitidos = /(\.jpg|\.jpeg|\.png|\.pdf|\.doc|\.docx|\.xls|\.xlsx)$/i;
        if (input.files.length > 0 && !formatosPermitidos.test(input.files[0].name)) {
            alert("Solo se permiten archivos JPG, PNG, PDF, DOC, DOCX, XLS y XLSX.");
            input.value = ""; // Limpia el archivo
        }
    }

    justificanteInput.addEventListener("blur", () => validarArchivo(justificanteInput));
    materialInput.addEventListener("blur", () => validarArchivo(materialInput));

    //Sincronización de fechas
    fechaInicio.addEventListener("blur", function () {
        if (!fechaFin.value || new Date(fechaInicio.value) > new Date(fechaFin.value)) {
            fechaFin.value = fechaInicio.value;
        }
        toggleHoras();
    });

    fechaFin.addEventListener("blur", function () {
        if (!fechaInicio.value || new Date(fechaFin.value) < new Date(fechaInicio.value)) {
            fechaInicio.value = fechaFin.value;
        }
        toggleHoras();
    });

    //Mostrar u ocultar selección de horas
    function toggleHoras() {
        if (fechaInicio.value && fechaFin.value && fechaInicio.value === fechaFin.value) {
            horasGroup.style.display = "block";
        } else {
            horasGroup.style.display = "none";
            todoElDia.checked = false;
        }
    }

    //Bloqueo de selección de horas al marcar "Todo el Día"
    todoElDia.addEventListener("change", function () {
        const checkboxes = horasGroup.querySelectorAll("input[type='checkbox']");
        checkboxes.forEach((checkbox) => (checkbox.disabled = todoElDia.checked));
    });

    //Validación del campo "Asunto"
    asuntoSelect.addEventListener("blur", function () {
        if (!asuntoSelect.value) {
            alert("Debe seleccionar un asunto de la ausencia.");
        }
    });

    //Validación de los campos de texto "Justificación" y "Observaciones"
    justificacion.addEventListener("blur", function () {
        if (!justificacion.value.trim()) {
            alert("El campo 'Justificación' es obligatorio.");
        }
    });

    observaciones.addEventListener("blur", function () {
        if (!observaciones.value.trim()) {
            alert("El campo 'Observaciones' es obligatorio.");
        }
    });

    //Validación final del formulario
    form.addEventListener("submit", function (e) {
        if (!asuntoSelect.value) {
            alert("Debe seleccionar un asunto de la ausencia.");
            e.preventDefault();  //Previene el envío del formulario
        } else if (!justificacion.value.trim() || !observaciones.value.trim()) {
            alert("Los campos 'Justificación' y 'Observaciones' son obligatorios.");
            e.preventDefault();
        }
    });    
});