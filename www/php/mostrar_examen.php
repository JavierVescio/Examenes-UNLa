<!DOCTYPE>
<html>

<body>


<?php

// PARA PROBARLO http://royal-academy.local:81/php/mostrar_examen.php?id_examen=1 (1 o el examen que tengan cargado)
// TODO : Primero armo la estructura como texto plano
// TODO : Una vez que tengo todos los datos le doy formato HTML , con su formulario, radiobutton, checkbox, etc

require_once '../constantes.php';
require_once APP_PATH . '/Conexion.inc.php';
require_once APP_PATH . '/Repository/RepositorioExamen.inc.php';
require_once APP_PATH . '/Repository/RepositorioCurso.inc.php';
require_once APP_PATH . '/Repository/RepositorioPregunta.inc.php';
require_once APP_PATH . '/Repository/RepositorioPreguntaImagen.inc.php';
require_once APP_PATH . '/Repository/RepositorioPreguntaOpcion.inc.php';

require_once APP_PATH . '/Entity/Examen.inc.php';
require_once APP_PATH . '/Entity/Curso.inc.php';
require_once APP_PATH . '/Entity/Pregunta.inc.php';
require_once APP_PATH . '/Entity/PreguntaImagen.inc.php';
require_once APP_PATH . '/Entity/PreguntaOpcion.inc.php';

Conexion::abrir_conexion();

$id_examen = $_GET['id_examen'];
$arr_examen = RepositorioExamen::findById(Conexion::getConexion(),$id_examen);

$examen = Examen::buildFromArray($arr_examen[0]);

$arr_curso = RepositorioCurso::findById(Conexion::getConexion(),$examen->getIdCurso());
$curso = Curso::buildFromArray($arr_curso[0]);

echo "<h1> ID EXAMEN: " . $examen->getIdExamen() . "</h1>";
echo "<h2> CURSO: " . $curso->getNombre(). "</h2>";
echo "<h2> FECHA CREACION: " . $examen->getFechaCreacion() . "</h2>";

echo "<h2> PREGUNTAS: </h2>";
// Busco las preguntas del examen
$arr_preguntas = RepositorioExamen::getPreguntasByExamen(Conexion::getConexion(),$id_examen);

?>

<form  action="guardar_examen_rendido.php" method="POST">

<?php

echo "<input type='hidden' name='id_examen' id='id_examen' value='" . $examen->getIdExamen() . "' />";
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

    echo "<p>";
    echo "<p> PREGUNTA :" . $pregunta->getDescripcion() . "</p>" ;

    ///////////////////////////////
    // Busco imagen de la pregunta
    ///////////////////////////////
    $arr_pregunta_imagen = RepositorioPreguntaImagen::findByPregunta(Conexion::getConexion(),$pregunta->getIdPregunta());

    if(!is_null($arr_pregunta_imagen) && sizeof($arr_pregunta_imagen) > 0) {
        $pregunta_imagen = PreguntaImagen::buildFromArray($arr_pregunta_imagen[0]);
        echo "<p>";
        echo "<img src='" . $pregunta_imagen->getPath() . "' title='" . $pregunta_imagen->getDescripcion() . "'>";
        echo "</p>";
    }

    foreach ($arr_pregunta_opciones as $arr_pregunta_opcion){
        $pregunta_opcion = PreguntaOpcion::buildFromArray($arr_pregunta_opcion);

        // Si tiene una opcion valida deberia armar radiobutton , si tiene mas un checkbox por cada opcion
        if($pregunta->getCantOpcionesValidas() == 1) {
            $tipo = "radio";
            $name = "preg_" . $pregunta_opcion->getIdPregunta();
        }else{
            $tipo = "checkbox";
            $name = "preg_" . $pregunta_opcion->getIdPregunta(). "[]";
        }

        echo "<input type='" . $tipo. "' name='" . $name. "' value='" . $pregunta_opcion->getIdOpcion() .  "'>" . $pregunta_opcion->getDescripcion() . "<br>";
    }
    echo "</p>";

}


Conexion::cerrar_conexion();
?>

<input type="submit" id="submit" name="submit" value="Enviar respuestas">

</form>
</body>

</html>