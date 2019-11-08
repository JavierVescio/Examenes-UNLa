<?php
require_once 'constantes.php';
require_once  APP_PATH . '/config-rutas.inc.php';

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
if (ControlSesion::sesion_iniciada_staff()) {

    if (!array_key_exists('panel', $_GET) || is_null($_GET['panel'])) {
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
                            <a class="btn btn-default form-control" href="/?panel=abm_admins" role="button">Gestionar</a>
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
                            <a class="btn btn-default form-control" href="/?panel=abm_cursos" role="button">Gestionar</a>
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
                            <a class="btn btn-default form-control" href="/?panel=abm_paises" role="button">Gestionar</a>
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
                            <a class="btn btn-default form-control" href="/?panel=abm_sedes" role="button">Gestionar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Preguntas
                        </div>
                        <div class="panel-body">
                            <p>Gestionar las preguntas y sus opciones.</p>
                            <a class="btn btn-default form-control" href="/?panel=abm_preguntas"
                               role="button">Gestionar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Exámenes
                        </div>
                        <div class="panel-body">
                            <p>Gestionar los exámenes.</p>
                            <a class="btn btn-default form-control" href="/?panel=abm_examenes"
                               role="button">Gestionar</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php

    }else{
        $panel = $_GET['panel'];
        include_once WWW_PATH . $paneles[$panel]['home'];
    }
}else if(ControlSesion::sesion_iniciada_alumno()){
    require_once APP_PATH . '/Repository/RepositorioExamen.inc.php';
    require_once APP_PATH . '/Repository/RepositorioCurso.inc.php';
    require_once APP_PATH . '/Entity/Examen.inc.php';
    require_once APP_PATH . '/Entity/Curso.inc.php';

    $arr_examenes = RepositorioExamen::listAll(Conexion::getConexion());
    echo "<div class='container'>";
    foreach ($arr_examenes as $arr_examen) {
        $examen = Examen::buildFromArray($arr_examen);
        $arr_curso = RepositorioCurso::findById(Conexion::getConexion(),$examen->getIdCurso());
        $curso = Curso::buildFromArray($arr_curso[0]);


        echo "Examen del curso ". $curso->getNombre(). " - Fecha creación : ". $examen->getFechaCreacion() . " ";
        echo "<a href='http://royal-academy.local:81/php/mostrar_examen.php?id_examen=".$examen->getIdExamen()."' > ( Rendir )</a>";
        echo "<br>";


    }
    echo "</div>";

}

    ?>


 <!--       <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>-->

<?php
include_once WWW_PATH . '/plantillas/documento-cierre.inc.php';

