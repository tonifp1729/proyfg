<thead>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Departamento</th> <!-- Nuevo campo de departamento -->
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
        <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
        <td><?= htmlspecialchars($usuario['correo']) ?></td>
        <td><?= htmlspecialchars($usuario['rol']) ?></td>
        <td><?= htmlspecialchars($usuario['departamento'] ?? 'No asignado') ?></td> <!-- Mostrar el departamento o 'No asignado' -->
        <td>
            <button onclick="editarUsuario(<?= htmlspecialchars($usuario['idUsuario']) ?>)">Editar</button>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>