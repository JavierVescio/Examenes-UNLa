<?php

/*include_once ('../Repository/RepositorioStaff.inc.php');
include_once ('../Entity/Staff.inc.php');
include_once '../Conexion.inc.php';
*/

include_once ('../Controller/ControllerStaff.inc.php');
Conexion::abrir_conexion();

$post_simulate['action'] = 'list';
$controller = new ControllerStaff();
$controller->post($post_simulate);
echo $controller->run();

$post_simulate_create = array (
                'id_staff'=> '',
                'apellido'=> '',
                'nombre' => '',
                'tipo_doc' => '',
                'documento' => '',
                'tipo_perfil' => '',
                'email' => '',
                'clave_acceso' => '',
                'id_sede' => ''
            ) ;

$controller->ṕost($post_simulate_create);
echo $controller->run();


// LISTA STAFF
/*$listaStaff = RepositorioStaff::listAll(Conexion::getConexion());
echo "LISTA JSON " . json_encode($listaStaff);
foreach ($listaStaff as $arrStaff){
    $staff = Staff::buildFromArray($arrStaff);
    echo "objStaff " . $staff->getApellido(). "\n";

}*/

// Agregar un STAFF
/*$nuevoStaff = new Staff(null,"Argentino","PEPito", "DNI", "3434343434", "AP", "pepe@gmail.com", "clave123",1);
RepositorioStaff::insertOrUpdate(Conexion::getConexion(),$nuevoStaff);
*/

//UPDATE STAFF
/*$nuevoStaff = new Staff(9,"Argentino","Pepe Augusto", "DNI", "3434343434", "AP", "pepe@gmail.com", "clave123",1);
RepositorioStaff::insertOrUpdate(Conexion::getConexion(),$nuevoStaff);
*/

// BOrrar una staff
/*if(RepositorioStaff::delete(Conexion::getConexion(),8))
    echo "Se borro correctamente";
else
    echo "Error al borrar";

*/

/*
class RepositorioStaffTest extends PHPUnit_Framework_TestCase
{

    public function testListAll()
    {

    }

    public function testFindById()
    {

    }

    public function testInsert()
    {

    }

    public function testDelete()
    {

    }
}

*/