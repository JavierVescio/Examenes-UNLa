<?php

// TODO corregir ruta con variables
include_once('../../app/Controller/ControllerPais.inc.php');
include_once('../../app/Conexion.inc.php');
Conexion::abrir_conexion();
// TODO Verificar logueo y perfil

$controller = new ControllerPais();
$controller->post($_POST);
echo $controller->run();