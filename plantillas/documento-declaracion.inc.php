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
        
        //echo "<title>$titulo</title>"; //Asi lo hacen en el curso pero no me gusta
        ?>
        
        <!--Esta forma se me ocurrio a mi, me parece mas clara y funciona-->
        <title> 
            <?php
                echo $titulo;
            ?>
        </title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">

    </head>
    <body>