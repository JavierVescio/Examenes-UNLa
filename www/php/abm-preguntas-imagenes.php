<?php
include_once('../constantes.php');
// TODO corregir ruta con variables
include_once(APP_PATH.'/Controller/ControllerPreguntaImagen.inc.php');
include_once(APP_PATH.'/Conexion.inc.php');
Conexion::abrir_conexion();
// TODO Verificar logueo y perfil

$controller = new ControllerPreguntaImagen();

$input_imagen = null ;

$fake_post = array(
    'action' => $_POST['action'],
    'id_pregunta' => $_POST['id_pregunta']
);

if(array_key_exists('nueva_imagen', $_FILES)) {
    $fake_post['nueva_imagen'] = $_FILES['nueva_imagen'];
}


/*$fake_post = array(
  'action' => 'show',
  'id_pregunta' => '2'
);
*/


$controller->post($fake_post);
//$controller->post($_POST);
echo $controller->run();

