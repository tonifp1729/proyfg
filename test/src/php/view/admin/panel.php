    <!-- panel.php -->
    <?php include 'src/php/view/partials/header.php'; ?>
    <?php include 'src/php/view/partials/sidebar.php'; ?>

    <div class="main-content">
        <!-- Mensaje de bienvenida -->
        <div id="bienvenida">
            <h1>Bienvenido, Administrador</h1>
            <p>Esta es tu vista principal, desde aquí puedes gestionar las solicitudes de ausencia y estadísticas.</p>
        </div>

        <!-- Sección para alta de solicitud de usuario -->
        <section id="alta-usuarios" class="content-section" style="display: none;">
            <h2>Alta de Solicitud</h2>
            <p>Formulario para registrar un nuevo usuario.</p>
            <form id="form-usuario">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Introducir nombre" required>
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" placeholder="Introducir apellidos" required>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required placeholder="ejemplo@dominio.com">
                <label for="confirmar-email">Confirmar Correo Electrónico:</label>
                <input type="email" id="confirmar-email" name="confirmar-email" required placeholder="ejemplo@dominio.com" oninput="validarCorreo()">
                <p id="mensaje-error">Los correos electrónicos no coinciden.</p>
                <button class="acciones-solicitud" type="submit">Crear Cuenta</button>
            </form>
        </section>

        <!-- Sección para listar usuarios -->
        <section id="lista-usuarios" class="content-section" style="display: none;">
            <h2>Lista de Usuarios</h2>
            <p>Listado de usuarios del sistema.</p>
            <table id="tabla-usuarios" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Accciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se añadirán los usuarios dinámicamente -->
                </tbody>
            </table>
        </section>

        <!-- Sección para alta de curso académico -->
        <section id="alta-curso" class="content-section" style="display: none;">
            <h2>Alta de Curso Académico</h2>
            <form id="form-curso">
                <label for="fechaInicio">Fecha de Inicio:</label>
                <input type="date" id="fechaInicio" name="fechaInicio" required>
                <label for="fechaFin">Fecha de Fin:</label>
                <input type="date" id="fechaFin" name="fechaFin" required>
                <button class="acciones-solicitud" type="submit">Crear Curso</button>
            </form>
        </section>

        <!-- Sección para listar cursos académicos -->
        <section id="listar-cursos" class="content-section" style="display: none;">
            <h2>Curso Activo</h2>
            <p id="curso-activo">2024/2025</p>
            <h3>Historial de Cursos Académicos</h3>
            <table id="tabla-cursos" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr><th>Año Académico</th></tr>
                </thead>
                <tbody>
                    <!-- Aquí se agregarán los cursos anteriores dinámicamente -->
                </tbody>
            </table>
        </section>
    </div>

    <script src="src/js/admin-panel.js"></script> <!-- Mover lógica de JavaScript a un archivo separado -->
    </body>
</html>