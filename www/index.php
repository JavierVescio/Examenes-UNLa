<?php
require_once 'constantes.php';

include_once APP_PATH . '/Conexion.inc.php';
include_once APP_PATH . '/Redireccion.inc.php';
include_once APP_PATH . '/ControlSesion.inc.php';


$titulo = 'Menu principal';

include_once WWW_PATH . '/plantillas/documento-declaracion.inc.php';
include_once WWW_PATH . '/plantillas/navbar.inc.php';

if (!ControlSesion::sesion_iniciada_alumno() && !ControlSesion::sesion_iniciada_staff()) {
    Redireccion::redirigir(RUTA_LOGIN);
}
?>

<?php
if (ControlSesion::sesion_iniciada_staff()){
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Staff
                </div>
                <div class="panel-body">
                    <p>Gestionar staff.</p>
                     <a class="btn btn-default form-control" href="<?php echo RUTA_ABM_ADMINS ?>" role="button">Gestionar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Cursos
                </div>
                <div class="panel-body">
                    <p>Gestionar los cursos.</p>
                    <a class="btn btn-default form-control" href="<?php echo RUTA_ABM_CURSOS ?>" role="button">Gestionar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Países
                </div>
                <div class="panel-body">
                    <p>Gestionar los países.</p>
                    <a class="btn btn-default form-control" href="<?php echo RUTA_ABM_PAISES ?>" role="button">Gestionar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sedes
                </div>
                <div class="panel-body">
                    <p>Gestionar las sedes.</p>
                    <a class="btn btn-default form-control" href="<?php echo RUTA_ABM_SEDES ?>" role="button">Gestionar</a>
                </div>
            </div>
        </div>        

    </div>
</div>
<?php }?>


 <!--       <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>-->

<?php
include_once WWW_PATH . '/plantillas/documento-cierre.inc.php';
?>

