<!-- VISTA REGISTRO DE USUARIO --------------------------------------------------------------------------------->

<!-- Sección principal para el registro -->
<div id="login">
    <!-- Título y mensaje descriptivo del formulario -->
    <h1>¡Regístrate!</h1>
    <p id="mensaje">Por favor, introduce tus credenciales para acceder. Recuerda que debes tener ya el correo de la fundación para disfrutar de esta función.</p>

    <!-- Formulario de registro de usuario -->
    <form action="index.php?controlador=Register&action=registro" method="post">
        <label for="correo">Correo Electrónico:</label>
        <input type="mail" name="correo" placeholder="Ingresa tu correo" 
            value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>">

        <label for="confirmarCorreo">Confirmar correo:</label>
        <input type="mail" name="confirmarCorreo" placeholder="Confirma el correo introducido" 
            value="<?php echo isset($_POST['confirmarCorreo']) ? htmlspecialchars($_POST['confirmarCorreo']) : ''; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingresa tu nombre" 
            value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" placeholder="Ingresa tus apellidos" 
            value="<?php echo isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : ''; ?>">

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Ingresa tu contraseña">

        <label for="confirmarContrasena">Confirmar contraseña:</label>
        <input type="password" name="confirmarContrasena" placeholder="Ingresa tu contraseña de nuevo">

        <button type="submit">Completar registro</button>
    </form>


    <!-- Enlace para redirigir al usuario a la página de inicio de sesión si ya tiene cuenta -->
    <p>¿Ya tienes una cuenta? <a href="index.php?controlador=Login&action=irsesion">Inicia sesión aquí</a></p>

    <!-- Mostrar mensajes de error si existen -->
    <?php
        if (isset($datosVista["data"]["error"])) {
            switch ($datosVista["data"]["error"]) {
                case 'faltan_credenciales':
                    echo "<p class='mensaje-error'>Faltan credenciales. Por favor, completa todos los campos.</p>";
                    break;
                case 'correo_erroneo':
                    echo "<p class='mensaje-error'>Los correos electrónicos no coinciden. Por favor, verifica.</p>";
                    break;
                case 'contrasena_incorrecta':
                    echo "<p class='mensaje-error'>Las contraseñas no coinciden. Por favor, inténtalo de nuevo.</p>";
                    break;
                case 'correo_invalido':
                    echo "<p class='mensaje-error'>El correo electrónico no es válido. Por favor, introduce un correo correcto.</p>";
                    break;
                case 'correo_existente':
                    echo "<p class='mensaje-error'>El correo ya está registrado. Por favor, usa otro o inicia sesión.</p>";
                    break;
                default:
                    echo "<p class='mensaje-error'>Ha ocurrido un error inesperado. Por favor, inténtalo más tarde.</p>";
                    break;
            }
        }
    ?>
</div>

<!-- Script asociado al formulario de registro -->
<script src="js/registro.js"></script>
