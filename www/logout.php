<?php
require_once 'constantes.php'
include_once APP_PATH . '/config.inc.php';
include_once APP_PATH . '/Conexion.inc.php';
include_once APP_PATH . '/RepositorioAlumnos.inc.php';
include_once APP_PATH . '/ValidadorLogin.inc.php';
include_once APP_PATH . '/ControlSesion.inc.php';
include_once APP_PATH . '/Redireccion.inc.php';

if (ControlSesion::sesion_iniciada_alumno()) {

    //Procedemos a cerrar la sesion
    $nombre_alumno = $_SESSION['nombre_alumno'];
    
    ControlSesion::cerrar_sesion_alumno();
} else {
    Redireccion::redirigir(SERVIDOR); //Un usuario sin sesion que quiere cerrar sesion, lo redirigimos.
}

$titulo = 'Logout';

include_once WWW_PATH . '/plantillas/documento-declaracion.inc.php';
include_once WWW_PATH . '/plantillas/navbar.inc.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Sesión cerrada</h4>
                </div>
                <div class="panel-body">
                    <p>Esperamos que vuelvas pronto <?php echo $nombre_alumno?>.</p>
                    <br>
                    <div class="text-center">
                        <a href="<?php echo RUTA_LOGIN ?>">Iniciar sesión</a>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-3"></div>

    </div>
</div>

<?php
include_once WWW_PATH . '/plantillas/documento-cierre.inc.php';
?>
