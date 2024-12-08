<?php include "partials/header.php"; ?>
<?php include "partials/sidebar.php"; ?>

<div class="main-content">
    <div id="login">
        <h1>¡Inicia sesión!</h1>
        <p id="mensaje">Por favor, introduce tus credenciales para acceder.</p>

        <!-- Mostrar errores devueltos por el servidor -->
        <?php
            if (isset($datosVista['data']['error'])) {
                switch ($datosVista['data']['error']) {
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

        <!-- Formulario de inicio de sesión -->
        <form id="loginForm" action="index.php?controlador=Login&action=irsesion" method="post" novalidate>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" placeholder="Ingresa tu correo" value="<?php echo isset($datosVista['data']['formData']['correo']) ? htmlspecialchars($datosVista['data']['formData']['correo']) : ''; ?>">

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" placeholder="Ingresa tu contraseña">

            <button type="submit">Iniciar Sesión</button>
            <p>¿Has olvidado tu contraseña? <a href="index.php?controlador=Recover_Controller&action=mostrarFormularioRecuperar">Recupérala aquí</a></p>
        </form>

        <!-- Enlaces para registro y recuperación de contraseña -->
        <p>¿No tienes una cuenta? <a href="index.php?controlador=Register&action=registro">Regístrate aquí</a></p>
        
    </div>
</div>

<?php include "partials/footer.php"; ?>

<!-- Script para validar el formulario -->
<script src="js/login.js"></script>
