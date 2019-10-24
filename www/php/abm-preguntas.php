<?php

// TODO corregir ruta con variables
include_once('../../app/Controller/ControllerPregunta.inc.php');
include_once('../../app/Conexion.inc.php');
Conexion::abrir_conexion();
// TODO Verificar logueo y perfil

$controller = new ControllerPregunta();
$controller->post($_POST);
echo $controller->run();
