<?php

// TODO guardar examen rendido
// Deberia verificar el login del alumno
// Asociar el alumno al examen rendido
// Almacenar las opciones elegidas por cada pregunta del examen al alumno y un timestamp del momento que rinde

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

if(!array_key_exists("id_examen", $_POST)){
    exit("Falta definir id_examen");
}

Conexion::abrir_conexion();


echo "<pre>";
print_r($_POST);
echo "</pre>";

echo "<p>Analisis preguntas</p>";

$id_examen = $_POST['id_examen'];
$arr_preguntas = RepositorioExamen::getPreguntasByExamen(Conexion::getConexion(),$id_examen);

foreach ($arr_preguntas as $arr_pregunta){
    $pregunta = Pregunta::buildFromArray($arr_pregunta);

    // Busco opciones de la pregunta
    $arr_pregunta_opciones = RepositorioPreguntaOpcion::findByPregunta(Conexion::getConexion(),$pregunta->getIdPregunta());

    // Si la pregunta no tiene opciones (por error de carga) no muestro la pregunta
    if(is_null($arr_pregunta_opciones) || sizeof($arr_pregunta_opciones) == 0)
        continue;

    echo "Analizando pregunta ". $pregunta->getDescripcion(). " (ID : ". $pregunta->getIdPregunta(). ")";
    // Verifico si fue contestada o no
    if(array_key_exists("preg_" . $pregunta->getIdPregunta(), $_POST)){
        // Pregunta contestada - Verifico la validez de la respuesta

        $respuestas = $_POST["preg_" . $pregunta->getIdPregunta()];

        // TODO ¿¿Deberia chequear $pregunta->getCantOpcionesValidas() == sizeof($respuesta) ??
        if(is_array($respuestas)){
            echo  "  Es multiple opcion <br>";
            $contesto_bien = null;

            foreach($respuestas as $respuesta){
                foreach ($arr_pregunta_opciones as $arr_pregunta_opcion) {
                    $pregunta_opcion = PreguntaOpcion::buildFromArray($arr_pregunta_opcion);
                    if ($respuesta == $pregunta_opcion->getIdOpcion()) {
                        if ($pregunta_opcion->getEsCorrecta()) {
                            echo "-- Opcion correcta <br>";
                            if(is_null($contesto_bien))
                                $contesto_bien = true;

                        }else {
                            echo "-- Opcion incorrecta  !! <br>";
                            $contesto_bien = false;
                        }
                        break;

                    }
                }
            }

            if($contesto_bien)
                echo "  --> Contesto bien la pregunta <br>";
            else
                echo "  --> Contesto MAL la pregunta <br>";
        }else{
            $respuesta = $respuestas;
            echo "  Es opcion simple<br>";

            foreach ($arr_pregunta_opciones as $arr_pregunta_opcion) {
                $pregunta_opcion = PreguntaOpcion::buildFromArray($arr_pregunta_opcion);
                if( $respuesta == $pregunta_opcion->getIdOpcion()){
                    if( $pregunta_opcion->getEsCorrecta())
                        echo "--Contesto bien <br>";
                    else
                        echo "--Contesto MAL  !! <br>";
                    break;
                }
            }
        }



    }else{
        // No contesto pregunta
        echo  "  No contestada <br>";
    }

}




