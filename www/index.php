<?php

    require_once 'constantes.php';

    include_once APP_PATH . '/Conexion.inc.php';
    include_once APP_PATH . '/Redireccion.inc.php';
    include_once APP_PATH . '/ControlSesion.inc.php';
    

    $titulo = 'Menu principal';

    include_once WWW_PATH . './plantillas/documento-declaracion.inc.php';
    include_once WWW_PATH . '/plantillas/navbar.inc.php';
    
    if (!ControlSesion::sesion_iniciada_alumno()) {
        Redireccion::redirigir(RUTA_LOGIN);
    }
?>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

<?php
    include_once APP_PATH . '/plantillas/documento-cierre.inc.php';
?>

