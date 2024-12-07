/**
 * Seleccionamos los elementos del DOM que necesitamos del formulario para validación.
 * Estos incluyen los campos de correo, contraseñas, nombre y apellidos.
 */
const formulario = document.querySelector("form");
const correoInput = document.querySelector("input[name='correo']");
const confirmarCorreoInput = document.querySelector("input[name='confirmarCorreo']");
const contrasenaInput = document.querySelector("input[name='contrasena']");
const confirmarContrasenaInput = document.querySelector("input[name='confirmarContrasena']");
const nombreInput = document.querySelector("input[name='nombre']");
const apellidosInput = document.querySelector("input[name='apellidos']");

/**
 * Muestra un mensaje de error debajo del campo de entrada.
 * Si ya existe un mensaje de error, lo elimina antes de añadir uno nuevo.
 *
 * @param {HTMLInputElement} input - El campo de entrada donde se mostrará el error.
 * @param {string} mensaje - El mensaje de error que se mostrará.
 */
function mostrarError(input, mensaje) {
    const existingError = input.parentNode.querySelector(".error");
    if (existingError) {
        existingError.remove();
    }
    const errorDiv = document.createElement("div");
    errorDiv.className = "error";
    errorDiv.textContent = mensaje;
    input.parentNode.insertBefore(errorDiv, input.nextSibling);
}

/**
 * Valida que el correo cumpla con el formato requerido y pertenezca al dominio especificado.
 *
 * @return {boolean} true si el correo es válido, false si no lo es.
 */
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

/**
 * Valida que el campo de confirmación de correo coincida con el correo original.
 *
 * @return {boolean} true si los correos coinciden, false si no.
 */
function validarConfirmarCorreo() {
    if (confirmarCorreoInput.value.trim() !== correoInput.value.trim()) {
        mostrarError(confirmarCorreoInput, "Los correos no coinciden.");
        return false;
    }
    return true;
}

/**
 * Valida que el nombre no esté vacío.
 *
 * @return {boolean} true si el nombre es válido, false si no.
 */
function validarNombre() {
    if (!nombreInput.value.trim()) {
        mostrarError(nombreInput, "El nombre es obligatorio.");
        return false;
    }
    return true;
}

/**
 * Valida que los apellidos no estén vacíos.
 *
 * @return {boolean} true si los apellidos son válidos, false si no.
 */
function validarApellidos() {
    if (!apellidosInput.value.trim()) {
        mostrarError(apellidosInput, "Los apellidos son obligatorios.");
        return false;
    }
    return true;
}

/**
 * Valida que la contraseña no esté vacía.
 *
 * @return {boolean} true si la contraseña es válida, false si no.
 */
function validarContrasena() {
    if (!contrasenaInput.value.trim()) {
        mostrarError(contrasenaInput, "La contraseña es obligatoria.");
        return false;
    }
    return true;
}

/**
 * Valida que la confirmación de contraseña coincida con la original.
 *
 * @return {boolean} true si las contraseñas coinciden, false si no.
 */
function validarConfirmarContrasena() {
    if (confirmarContrasenaInput.value.trim() !== contrasenaInput.value.trim()) {
        mostrarError(confirmarContrasenaInput, "Las contraseñas no coinciden.");
        return false;
    }
    return true;
}

/**
 * Asocia eventos 'blur' para la validación instantánea de los campos.
 */
correoInput.addEventListener('blur', validarCorreo);
confirmarCorreoInput.addEventListener('blur', validarConfirmarCorreo);
nombreInput.addEventListener('blur', validarNombre);
apellidosInput.addEventListener('blur', validarApellidos);
contrasenaInput.addEventListener('blur', validarContrasena);
confirmarContrasenaInput.addEventListener('blur', validarConfirmarContrasena);

/**
 * Función que valida el formulario completo al intentar enviarlo.
 * Si todas las validaciones son correctas, se envía el formulario.
 *
 * @param {Event} e - El evento submit del formulario.
 */
async function validarFormulario(e) {
    e.preventDefault(); // Previene el envío automático del formulario

    const validoCorreo = validarCorreo();
    const validoConfirmarCorreo = validarConfirmarCorreo();
    const validoNombre = validarNombre();
    const validoApellidos = validarApellidos();
    const validoContrasena = validarContrasena();
    const validoConfirmarContrasena = validarConfirmarContrasena();

    if (validoCorreo && validoConfirmarCorreo && validoNombre && validoApellidos && validoContrasena && validoConfirmarContrasena) {
        formulario.submit(); // Envía el formulario si todo es válido
    }
}

/**
 * Asociamos el evento 'submit' al formulario para validar todos los campos antes de enviarlo.
 */
formulario.addEventListener("submit", validarFormulario);
