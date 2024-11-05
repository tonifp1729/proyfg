<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <!-- Contenedor de inicio de sesión -->
        <div id="login">
            <h1>¡Bienvenido!</h1>
            <p id="mensaje">Por favor, introduce tus credenciales para acceder.</p>

            <!-- Formulario de inicio de sesión -->
            <form>
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" placeholder="Ingresa tu correo" required>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" placeholder="Ingresa tu contraseña" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </body>
</html>