<!-- VISTA INICIO DE SESIÓN --------------------------------------------------------------------------------->
<div id="login">
    <h1>¡Inicia sesión!</h1>
    <p id="mensaje">Por favor, introduce tus credenciales para acceder.</p>

    <!-- Formulario de inicio de sesión -->
    <form action="index.php?controlador=Login&action=identificacion" method="post">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" placeholder="Ingresa tu correo">

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Ingresa tu contraseña">

        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a  href="index.php?controlador=Register&action=registro">Regístrate aquí</a></p>
</div>