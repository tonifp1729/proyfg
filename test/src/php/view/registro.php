<!-- VISTA REGISTRO DE USUARIO --------------------------------------------------------------------------------->
<div id="login">
    <h1>¡Regístrate!</h1>
    <p id="mensaje">Por favor, introduce tus credenciales para acceder. Recuerda que debes tener ya el correo de la fundación para disfrutar de esta función.</p>

    <!-- Formulario de registro de usuario -->
    <form action="index.php?controlador=Register&action=registro" method="post">
        <label for="correo">Correo Electrónico:</label>
        <input type="mail" name="correo" placeholder="Ingresa tu correo">

        <label for="confirmarCorreo">Confirmar correo:</label>
        <input type="mail" name="confirmarCorreo" placeholder="Confirma el correo introducido">

        <label for="nombre">Nombre:</label>
        <input type="nombre" name="nombre" placeholder="Ingresa tu nombre">

        <label for="apellidos">Apellidos:</label>
        <input type="apellidos" name="apellidos" placeholder="Ingresa tus apellidos">

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Ingresa tu contraseña">

        <label for="confirmarContrasena">Confirmar contraseña:</label>
        <input type="password" name="confirmarContrasena" placeholder="Ingresa tu contraseña de nuevo">

        <button type="submit">Completar registro</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="index.php?controlador=Login&action=irsesion">Inicia sesión aquí</a></p>
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
<script src="js/registro.js"></script>