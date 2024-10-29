// CONTROLA LAS VALIDACIONES Y GENERA LOS CAMPOS DINÁMICO, COMO LAS LINEAS DE LA TABLA CURSO

    function validarCorreo() {
        const email = document.getElementById('email').value;
        const confirmarEmail = document.getElementById('confirmar-email').value;
        const mensajeError = document.getElementById('mensaje-error');

        mensajeError.style.display = email !== confirmarEmail ? 'block' : 'none';
    }

    function mostrarSeccion(seccionId) {
        const secciones = document.querySelectorAll('.content-section');
        secciones.forEach(seccion => seccion.style.display = 'none');
        document.getElementById(seccionId).style.display = 'block';
    }

    document.getElementById('form-curso').addEventListener('submit', function(e) {
        e.preventDefault();

        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value;
        const nuevoCurso = `${new Date(fechaInicio).getFullYear()}/${new Date(fechaFin).getFullYear()}`;

        agregarCursoATabla(nuevoCurso);
        document.getElementById('form-curso').reset();
    });

    function agregarCursoATabla(curso) {
        const tbody = document.querySelector('#tabla-cursos tbody');
        const fila = document.createElement('tr');
        fila.innerHTML = `<td>${curso}</td>`;
        tbody.appendChild(fila);
    }