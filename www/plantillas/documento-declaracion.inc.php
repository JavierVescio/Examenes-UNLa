<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php
        if (!isset($titulo) || empty($titulo)){
            $titulo = "Gestor de Exámenes";
        }
        ?>
        <title> 
            <?php
                echo $titulo;
            ?>
        </title>
        
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/estilos.css" rel="stylesheet">
        <?php
            $panel = $_GET['panel'];
            foreach ($paneles[$panel]['css'] as $css_doc)
                echo "<link href='/css/" . $css_doc. "' rel='stylesheet'>";
        ?>

    </head>
    <body>