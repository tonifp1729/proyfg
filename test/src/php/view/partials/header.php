<!-- CABECERA QUE TENDRÁN EN COMÚN TODAS LAS VISTAS -->

<?php
    // Suponiendo que la variable $rol está definida antes de incluir este archivo
    $titulo = ($rol === 'a') ? 'Panel de Administrador' : 'Panel de Moderador';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titulo; ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>