<?php
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/RepositorioAlumnos.inc.php';
include_once 'app/ValidadorLogin.inc.php';
include_once 'app/ControlSesion.inc.php';
include_once 'app/Redireccion.inc.php';

if (ControlSesion::sesion_iniciada_alumno()) {

    //Procedemos a cerrar la sesion
    $nombre_alumno = $_SESSION['nombre_alumno'];
    
    ControlSesion::cerrar_sesion_alumno();
} else {
    Redireccion::redirigir(SERVIDOR); //Un usuario sin sesion que quiere cerrar sesion, lo redirigimos.
}

$titulo = 'Logout';

include_once './plantillas/documento-declaracion.inc.php';
include_once './plantillas/navbar.inc.php';
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
include_once './plantillas/documento-cierre.inc.php';
?>
