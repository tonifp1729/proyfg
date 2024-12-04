//Seleccionamos los elementos del DOM
const formulario = document.querySelector("form");
const correoInput = document.querySelector("input[name='correo']");
const confirmarCorreoInput = document.querySelector("input[name='confirmarCorreo']");
const contrasenaInput = document.querySelector("input[name='contrasena']");
const confirmarContrasenaInput = document.querySelector("input[name='confirmarContrasena']");
const nombreInput = document.querySelector("input[name='nombre']");
const apellidosInput = document.querySelector("input[name='apellidos']");

//Mostramos el mensaje de error cuando se pase desde el controlador
function mostrarError(input, mensaje) {
    //Si ya existe un mensaje de error, lo eliminamos antes de añadir uno nuevo
    const existingError = input.parentNode.querySelector(".error");
    if (existingError) {
        existingError.remove();
    }

    const errorDiv = document.createElement("div");
    errorDiv.className = "error";
    errorDiv.textContent = mensaje;
    input.parentNode.insertBefore(errorDiv, input.nextSibling);
}

//Verificamos el formato del correo
function validarCorreo() {
    const correoRegex = /^[a-zA-Z0-9._%+-]+@fundacionloyola\.es$/;
    if (!correoInput.value.trim()) {
        mostrarError(correoInput, "El correo electrónico es obligatorio.");
        return false;
    } else if (!correoRegex.test(correoInput.value)) {
        mostrarError(correoInput, "El correo debe ser válido y del dominio @fundacionloyola.es.");
        return false;
    }
    return true;
}

//Comprobamos si el correo confirmado coincide
function validarConfirmarCorreo() {
    if (confirmarCorreoInput.value.trim() !== correoInput.value.trim()) {
        mostrarError(confirmarCorreoInput, "Los correos no coinciden.");
        return false;
    }
    return true;
}

//Comprobamos el nombre
function validarNombre() {
    if (!nombreInput.value.trim()) {
        mostrarError(nombreInput, "El nombre es obligatorio.");
        return false;
    }
    return true;
}

//Comprobamos los apellidos
function validarApellidos() {
    if (!apellidosInput.value.trim()) {
        mostrarError(apellidosInput, "Los apellidos son obligatorios.");
        return false;
    }
    return true;
}

//Comprobamos la contraseña
function validarContrasena() {
    if (!contrasenaInput.value.trim()) {
        mostrarError(contrasenaInput, "La contraseña es obligatoria.");
        return false;
    }
    return true;
}

//Comprobamos la confirmación de la contraseña
function validarConfirmarContrasena() {
    if (confirmarContrasenaInput.value.trim() !== contrasenaInput.value.trim()) {
        mostrarError(confirmarContrasenaInput, "Las contraseñas no coinciden.");
        return false;
    }
    return true;
}

//Asociamos eventos 'blur' para validación instantánea
correoInput.addEventListener('blur', validarCorreo);
confirmarCorreoInput.addEventListener('blur', validarConfirmarCorreo);
nombreInput.addEventListener('blur', validarNombre);
apellidosInput.addEventListener('blur', validarApellidos);
contrasenaInput.addEventListener('blur', validarContrasena);
confirmarContrasenaInput.addEventListener('blur', validarConfirmarContrasena);

//Validamos el formulario al enviarlo
async function validarFormulario(e) {
    e.preventDefault(); // Previene el envío automático del formulario

    //Ejecutamos la validación de cada campo
    const validoCorreo = validarCorreo();
    const validoConfirmarCorreo = validarConfirmarCorreo();
    const validoNombre = validarNombre();
    const validoApellidos = validarApellidos();
    const validoContrasena = validarContrasena();
    const validoConfirmarContrasena = validarConfirmarContrasena();

    //Si alguna validación falla, no enviamos el formulario
    if (validoCorreo && validoConfirmarCorreo && validoNombre && validoApellidos && validoContrasena && validoConfirmarContrasena) {
        // Si todo es válido, el formulario se envía
        formulario.submit(); // Enviamos el formulario
    }
}

//Asociamos el evento submit al formulario
formulario.addEventListener("submit", validarFormulario);