// VALIDACIONES EN CLIENTE PARA EL PROCESO DE INICIO Y CIERRE DE SESIÓN

//Esto se lanza en la Sidebar al pulsar en el cierre de sesión con el objetivo de tener un control correcto de las sesiones.
document.querySelector('.logout a').addEventListener('click', function(e) {
    e.preventDefault();

    fetch('index.php?controlador=Login&action=cerrarSesion', {
        method: 'POST'
    }).then(response => {
        if (response.ok) {
            //Recargamos la página para asegurarnos de que pierda los valores de la sesión iniciada anteriormente
            window.location.href = 'index.php?controlador=Login&action=irsesion';
        } else {
            alert('Error al cerrar la sesión. Inténtalo de nuevo.');
        }
    }).catch(error => {
        console.error('Error:', error);
    });
});