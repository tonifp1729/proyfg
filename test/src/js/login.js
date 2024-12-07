const loginForm = document.querySelector("form");
const correoInput = document.querySelector("input[name='correo']");
const contrasenaInput = document.querySelector("input[name='contrasena']");

/**
 * Muestra un mensaje de error debajo del campo de entrada.
 */
function mostrarError(input, mensaje) {
    // Elimina cualquier error previo
    const existingError = input.parentNode.querySelector(".error");
    if (existingError) {
        existingError.remove();
    }

    // Crea el mensaje de error
    const errorDiv = document.createElement("div");
    errorDiv.className = "error mensaje-error";
    errorDiv.textContent = mensaje;
    input.parentNode.insertBefore(errorDiv, input.nextSibling);
}

/**
 * Valida el correo para que no esté vacío y cumpla con el dominio correcto.
 */
function validarCorreo() {
    const correoRegex = /^[a-zA-Z0-9._%+-]+@fundacionloyola\.org$/;
    if (!correoInput.value.trim()) {
        mostrarError(correoInput, "El correo electrónico es obligatorio.");
        return false;
    } else if (!correoRegex.test(correoInput.value)) {
        mostrarError(correoInput, "Por favor, ingresa un correo válido del dominio fundacionloyola.org.");
        return false;
    }
    return true;
}

/**
 * Valida que la contraseña no esté vacía.
 */
function validarContrasena() {
    if (!contrasenaInput.value.trim()) {
        mostrarError(contrasenaInput, "La contraseña es obligatoria.");
        return false;
    }
    return true;
}

/**
 * Valida el formulario antes de enviarlo.
 */
function validarFormulario(e) {
    let correoValido = validarCorreo();
    let contrasenaValida = validarContrasena();

    // Si pasa las validaciones del cliente, permitir envío
    if (!correoValido || !contrasenaValida) {
        e.preventDefault(); // Bloquea envío solo si hay errores de cliente
    }
}

// Asociar el evento 'submit' a la validación
loginForm.addEventListener("submit", validarFormulario);
