<!-- LISTADO DE USUARIOS DEL ADMINISTRADOR --------------------------------------------------------------------------------->
<div class="container">
    <div id="listadoUsuarios">
        <?php
            if(isset($datosVista['data']['listaUsuarios']) && !empty($datosVista['data']['listaUsuarios'])) {
                foreach($datosVista['data']['listaUsuarios'] as $usuario) {
                    echo '<p><a href="index.php?controlador=User&action=mostrarModificarUsuario&idUsuario='.$usuario['idUsuario'].'">'.$usuario['nombre'].' '.$usuario['apellidos'].'</a></p>';
                }
            } else {
                echo '<p>No tienes usuarios registrados en la aplicación a parte de ti.</p>';
            }
        ?>
    </div>
</div>