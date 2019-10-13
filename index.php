<?php
    include_once './app/Conexion.inc.php';
    include_once './app/Redireccion.inc.php';
    include_once './app/ControlSesion.inc.php';
    

    $titulo = 'Menu principal';

    include_once './plantillas/documento-declaracion.inc.php';
    include_once './plantillas/navbar.inc.php';
    
    if (!ControlSesion::sesion_iniciada_alumno()) {
        Redireccion::redirigir(RUTA_LOGIN);
    }
?>

        <script src="www/js/jquery.min.js"></script>
        <script src="www/js/bootstrap.min.js"></script>

<?php
    include_once './plantillas/documento-cierre.inc.php';
?>

