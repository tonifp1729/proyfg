<?php

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "usuario", "contraseña", "nombre_bd");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Consultar si existe un curso activo
    $consulta = "SELECT * FROM cursos WHERE CURDATE() BETWEEN fechaInicio AND fechaFin LIMIT 1";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        // Curso activo encontrado, mostrar la opción de solicitud
        echo "¡Bienvenido! Puedes realizar una solicitud.";
    } else {
        // No hay curso activo, mostrar el mensaje de espera
        echo "¡Comenzamos pronto!";
    }

    $conexion->close();
    
?>