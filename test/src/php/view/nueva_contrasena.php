<form id="nuevaContrasenaForm" action="index.php?controlador=Recover&action=actualizarContrasena" method="post">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
    <label for="nueva_contrasena">Nueva Contraseña:</label>
    <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
    <button type="submit">Actualizar</button>
</form>
