<?php

include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioStaff.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Staff.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Conexion.inc.php');

class ControllerStaff
{
    private $action = null;
    private $params;

    private $map;

    private function mapActions(){
            $this->map['create'] = 'create';
            $this->map['update'] = 'create';
            $this->map['delete'] = 'delete' ;
            $this->map['list'] = 'listAll';
            $this->map['show'] = 'show';

    }

    public function __construct()
    {

    }

    public function post($arr){

        if(!array_key_exists('action', $arr))
            throw  new Exception(self::class . '- Action no definida en el mapa de acciones ');

        $this->action = $arr['action'];
        $this->params = $arr;
        $this->mapActions();
    }

    public function run(){
            if(is_null($this->action))
                throw  new Exception(self::class . '- Action no definida ');

            $action = $this->map[$this->action];
            return $this->{$action}();

    }

    private function create(){
        $staff = Staff::buildFromArray($this->params);
        $status = RepositorioStaff::insertOrUpdate(Conexion::getConexion(),$staff);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Staff creado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Staff creado correctamente';
        }
        return json_encode($response);
    }

    private function delete(){
        if(!array_key_exists('id_staff', $this->params))
            throw  new Exception(self::class . ' delete - id_staff no definido ');

        $id_staff = $this->params['id_staff'];
        $status = RepositorioStaff::delete(Conexion::getConexion(),$id_staff);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Staff eliminado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al eliminar Staff';
        }
        return json_encode($response);
    }

    private function listAll(){
        $listaStaff = RepositorioStaff::listAll(Conexion::getConexion());
        if(!is_null($listaStaff)){
            $response['status'] = 'success';
            $response['data'] = $listaStaff;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar Staff';
        }
        /*foreach ($listaStaff as $arrStaff){
            $staff = Staff::buildFromArray($arrStaff);
            echo "objStaff " . $staff->getApellido(). "\n";

        }*/

        return json_encode($response);

    }

    private function show(){

        if(!array_key_exists('id_staff', $this->params))
            throw  new Exception(self::class . ' delete - id_staff no definido ');
        $id_staff = $this->params['id_staff'];

        $staff = RepositorioStaff::findById(Conexion::getConexion(), $id_staff);

        if(!is_null($staff)){
            $response['status'] = 'success';
            $response['data'] = $staff;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar Staff';
        }

        return json_encode($response);

    }


}