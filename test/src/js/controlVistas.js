//SCRIPT PARA EL CONTROL DE LAS VISTAS
function mostrarVista(vistaId) {
    //Oculta todas las secciones de contenido
    document.querySelectorAll('.content-section, #acceso-denegado, #vista-inicial, #vista-saludo').forEach((seccion) => {
        seccion.style.display = 'none';
    });

    //Muestra la sección especificada
    const vista = document.getElementById(vistaId);
    if (vista) {
        vista.style.display = 'block';
    }
}

//Muestra la sidebar y una bienvenida al pulsar "Continuar" en la vista inicial
function mostrarSidebarYVista(vistaId) {
    document.querySelector('.sidebar').style.display = 'block'; //Muestra la sidebar
    mostrarVista(vistaId); //Muestra la vista especificada
}

//Función para cargar la vista de lista de usuarios usando AJAX
function cargarVistaUsuarios() {
    fetch('/src/php/view/vistaListaUsuarios.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('lista-usuarios').innerHTML = html; //Inserta la vista en el contenedor
            mostrarVista('lista-usuarios'); //Muestra la vista de usuarios
        })
        .catch(error => console.error('Error al cargar la vista de usuarios:', error));
}

// Asignación de eventos a los enlaces de la sidebar
document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.sidebar').style.display = 'none'; //Oculta la sidebar inicialmente
    mostrarVista('vista-inicial'); //Muestra solo la vista inicial al cargar

    // Enlaces de la sidebar que controlan qué vista mostrar
    document.getElementById('enlace-alta-curso').addEventListener('click', (e) => {
        e.preventDefault();
        mostrarVista('alta-curso'); //Muestra la vista de alta de curso
    });

    document.getElementById('enlace-listar-cursos').addEventListener('click', (e) => {
        e.preventDefault();
        mostrarVista('listar-cursos'); //Muestra la vista de listar cursos
    });

    document.getElementById('enlace-lista-usuarios').addEventListener('click', (e) => {
        e.preventDefault();
        cargarVistaUsuarios(); //Llama a la función para cargar la vista de usuarios
    });
});

function onSignIn(googleUser) {
    // Obtén la información del perfil del usuario
    const profile = googleUser.getBasicProfile();
    const correo = profile.getEmail();
    const nombre = profile.getGivenName();
    const apellidos = profile.getFamilyName();

    // Envía la información al controlador de backend
    fetch('/src/php/controller/LoginController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ correo, nombre, apellidos })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Redirigir a la vista-inicial
            mostrarVista(data.vista);
        } else {
            // Redirigir a acceso-denegado
            mostrarVista(data.vista);
        }
    })
    .catch(error => console.error('Error al procesar el inicio de sesión:', error));
}
