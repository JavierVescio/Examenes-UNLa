<?php


// TODO corregir ruta con variables
include_once('../../app/Controller/ControllerAlumno.inc.php');
include_once('../../app/Conexion.inc.php');
Conexion::abrir_conexion();
// TODO Verificar logueo y perfil

$fake_post = array(
    'action' => 'show',
    'id_alumno' => 1
);
/*
$fake_post = array(
    'action' => 'list'
); */

$controller = new ControllerAlumno();
$controller->post($fake_post /*$_POST*/);
echo $controller->run();