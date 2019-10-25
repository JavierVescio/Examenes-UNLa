<?php
require_once 'constantes.php';

include_once APP_PATH . '/Conexion.inc.php';
include_once APP_PATH . '/ValidadorLogin.inc.php';
include_once APP_PATH . '/Redireccion.inc.php';
include_once APP_PATH . '/ControlSesion.inc.php';

$titulo = 'Login';

include_once WWW_PATH . '/plantillas/documento-declaracion.inc.php';
include_once WWW_PATH . '/plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_alumno() || ControlSesion::sesion_iniciada_staff()) {
    Redireccion::redirigir(SERVIDOR); //Si ya inicio sesion el usuario, lo echamos de la pantalla de login
}

if (isset($_POST['login'])) {
    $es_alumno = true;
    if (isset($_POST['checkadmin']) && $_POST['checkadmin'] == 'Yes') {
        $es_alumno = false;
    }

    $validador = new ValidadorLogin($_POST['email'], $_POST['clave'], $es_alumno, Conexion::getConexion());

    if ($validador->obtener_error() === '') {
        if ($es_alumno && !is_null($validador->obtener_alumno())) {
            ControlSesion::iniciar_sesion_alumno(
                    $validador->obtener_alumno()->getId_alumno(), $validador->obtener_alumno()->getNombre(), $validador->obtener_alumno()->getEmail());
        }else{
            ControlSesion::iniciar_sesion_staff(
                    $validador->obtener_staff()->getIdStaff(), $validador->obtener_staff()->getNombre(), $validador->obtener_staff()->getEmail());
        }
        Redireccion::redirigir(RUTA_LOGIN);
    } else {
        
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Inicio de Sesión</h4>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <h3>Introduce tus datos</h3>
                        <br>
                        <label for="email" class="sr-only">Email</label> <!--Sirve para que gente no vidente su sistema pueda leerle y diga email-->
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
                        <br>
                        <label for="clave" class="sr-only">Clave</label>
                        <input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña" required>
                        <br>
                        <?php
                        if (isset($_POST['login'])) {
                            $validador->mostrar_error();
                        }
                        ?>
                        <button type="submit" name="login" class="btn btn-lg btn-primary btn-block">
                            Iniciar sesión
                        </button>
                        <br>
                        <input type="checkbox"  name="checkadmin" value="Yes" default /> Soy administrador
                        <br>
                        <br>
                        <div class="text-center">
                            <a href="#">¿Olvidaste tu contraseña?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>

    </div>
</div>



<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php
include_once WWW_PATH . '/plantillas/documento-cierre.inc.php';
?>

