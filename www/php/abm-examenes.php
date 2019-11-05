<?php

// TODO corregir ruta con variables
include_once('../../app/Controller/ControllerExamen.inc.php');
include_once('../../app/Conexion.inc.php');
Conexion::abrir_conexion();
// TODO Verificar logueo y perfil

$controller = new ControllerExamen();
$controller->post($_POST);
echo $controller->run();