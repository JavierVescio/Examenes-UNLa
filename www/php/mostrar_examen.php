
<?php

// PARA PROBARLO http://royal-academy.local:81/php/mostrar_examen.php?id_examen=1 (1 o el examen que tengan cargado)
// TODO : Primero armo la estructura como texto plano
// TODO : Una vez que tengo todos los datos le doy formato HTML , con su formulario, radiobutton, checkbox, etc

require_once '../constantes.php';
require_once  APP_PATH . '/config-rutas.inc.php';

include_once APP_PATH . '/Conexion.inc.php';
include_once APP_PATH . '/Redireccion.inc.php';
include_once APP_PATH . '/ControlSesion.inc.php';


//$titulo = 'Menu principal';

include_once WWW_PATH . '/plantillas/documento-declaracion.inc.php';
include_once WWW_PATH . '/plantillas/navbar.inc.php';

if (!ControlSesion::sesion_iniciada_alumno() && !ControlSesion::sesion_iniciada_staff()) {
    Redireccion::redirigir(RUTA_LOGIN);
}


//require_once '../constantes.php';

//include_once APP_PATH . '/ControlSesion.inc.php';
//require_once  APP_PATH . '/config-rutas.inc.php';

//require_once APP_PATH . '/Conexion.inc.php';
require_once APP_PATH . '/Repository/RepositorioExamen.inc.php';
require_once APP_PATH . '/Repository/RepositorioCurso.inc.php';
require_once APP_PATH . '/Repository/RepositorioAlumnos.inc.php';
require_once APP_PATH . '/Repository/RepositorioStaff.inc.php';
require_once APP_PATH . '/Repository/RepositorioPregunta.inc.php';
require_once APP_PATH . '/Repository/RepositorioPreguntaImagen.inc.php';
require_once APP_PATH . '/Repository/RepositorioPreguntaOpcion.inc.php';

require_once APP_PATH . '/Entity/Examen.inc.php';
require_once APP_PATH . '/Entity/Curso.inc.php';
require_once APP_PATH . '/Entity/Alumno.inc.php';
require_once APP_PATH . '/Entity/Staff.inc.php';
require_once APP_PATH . '/Entity/Pregunta.inc.php';
require_once APP_PATH . '/Entity/PreguntaImagen.inc.php';
require_once APP_PATH . '/Entity/PreguntaOpcion.inc.php';

Conexion::abrir_conexion();
$id_rendidor = null;

if(ControlSesion::sesion_iniciada_alumno()) {
    $id_rendidor = ControlSesion::obtener_id_alumno();
    $arr_alumno = RepositorioAlumnos::findById(Conexion::getConexion(),$id_rendidor);
    $alumno = Alumno::buildFromArray($arr_alumno[0]);
    $nombre_completo = $alumno->getApellido() . ', ' . $alumno->getNombre();
}else{
    $id_rendidor = ControlSesion::obtener_id_staff();
    $arr_staff = RepositorioStaff::findById(Conexion::getConexion(),$id_rendidor);
    $staff = Staff::buildFromArray($arr_staff[0]);
    $nombre_completo = $staff->getApellido() . ', ' . $staff->getNombre();
}


$id_examen = $_GET['id_examen'];
$arr_examen = RepositorioExamen::findById(Conexion::getConexion(),$id_examen);

$examen = Examen::buildFromArray($arr_examen[0]);

$arr_curso = RepositorioCurso::findById(Conexion::getConexion(),$examen->getIdCurso());
$curso = Curso::buildFromArray($arr_curso[0]);

?>
<div class="container">
    <div class="well">
        <label>ID EXAMEN:</label><?=$examen->getIdExamen()?></br>
        <label>CURSO:</label><?=$curso->getNombre()?></br>
        <label>FECHA CREACION:</label><?=$examen->getFechaCreacion()?></br>
        <label>ALUMNO:</label><?=$nombre_completo?>
    </div>
</div>

<div class="container">
    <div class="well">

<label>LISTADO DE PREGUNTAS:</label></br>

<?php

$contPreguntas = 0;

// Busco las preguntas del examen
$arr_preguntas = RepositorioExamen::getPreguntasByExamen(Conexion::getConexion(),$id_examen);


?>
<form  action="guardar_examen_rendido.php" class="form-vertical" role="form" autocomplete="off" method="POST">
<fieldset>
    <input type='hidden' name='id_examen' id='id_examen' value='<?=$examen->getIdExamen()?>' />
    <input type='hidden' name='id_alumno' id='id_alumno' value='<?=$id_rendidor?>' />"

    <?php

        //////////////////////////////////////////////////////////////
        // Por cada pregunta la imprimo, su imagen y opciones
        /////////////////////////////////////////////////////////////
        foreach ($arr_preguntas as $arr_pregunta){
            $pregunta = Pregunta::buildFromArray($arr_pregunta);

            // Busco opciones de la pregunta
            $arr_pregunta_opciones = RepositorioPreguntaOpcion::findByPregunta(Conexion::getConexion(),$pregunta->getIdPregunta());

            // Si la pregunta no tiene opciones (por error de carga) no muestro la pregunta
            if(is_null($arr_pregunta_opciones) || sizeof($arr_pregunta_opciones) == 0)
                continue;

            $contPreguntas++;

            // Si tiene una opcion valida deberia armar radiobutton , si tiene mas un checkbox por cada opcion
            if($pregunta->getCantOpcionesValidas() == 1) {
                $tipo = "radio";
                $name = "preg_" . $pregunta->getIdPregunta();
            }else{
                $tipo = "checkbox";
                $name = "preg_" . $pregunta->getIdPregunta(). "[]";
            }

            ///////////////////////////////
            // Busco imagen de la pregunta
            ///////////////////////////////
            $arr_pregunta_imagen = RepositorioPreguntaImagen::findByPregunta(Conexion::getConexion(),$pregunta->getIdPregunta());


            echo "<div class='form-group col-lg-10 '>";
            echo "<label class='control-label' for='" . $name . "'>" . $contPreguntas . ") " . $pregunta->getDescripcion() . "</label><br>" ;

            if(!is_null($arr_pregunta_imagen) && sizeof($arr_pregunta_imagen) > 0) {
                $pregunta_imagen = PreguntaImagen::buildFromArray($arr_pregunta_imagen[0]);
                echo "<div class='block' >";
                echo "<img src='" . $pregunta_imagen->getPath() . "'  title='" . $pregunta_imagen->getDescripcion() . "'>";
                echo "</div>";
            }

            foreach ($arr_pregunta_opciones as $arr_pregunta_opcion){
                $pregunta_opcion = PreguntaOpcion::buildFromArray($arr_pregunta_opcion);
                //echo "<div class='col-sm-10'>" ;
                echo "<input type='" . $tipo. "' name='" . $name. "' id='" . $name. "' value='" . $pregunta_opcion->getIdOpcion() .  "'>" . $pregunta_opcion->getDescripcion() . "<br>";
                //echo "</div>";

            }

            echo "</div>";

        }
        Conexion::cerrar_conexion();
    ?>

    <div class="class='form-group col-lg-10 '">

            <input type="submit" id="submit" name="submit" value="Enviar respuestas">

    </div>
</fieldset>
</form>
    </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
include_once WWW_PATH . '/plantillas/documento-cierre.inc.php';

