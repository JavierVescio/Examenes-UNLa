<?php

// TODO corregir ruta con variables
include_once('../../app/Controller/ControllerSede.inc.php');
include_once('../../app/Conexion.inc.php');
Conexion::abrir_conexion();
// TODO Verificar logueo y perfil

$controller = new ControllerSede();
$controller->post($_POST);
echo $controller->run();