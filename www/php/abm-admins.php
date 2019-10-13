<?php

// TODO corregir ruta con variables
include_once('../../app/Controller/ControllerStaff.inc.php');
include_once('../../app/Conexion.inc.php');
Conexion::abrir_conexion();
// TODO Verificar logueo y perfil

$controller = new ControllerStaff();
$controller->post($_POST);
echo $controller->run();
