<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioSede.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Sede.inc.php');

class ControllerSede extends GenericController
{


    // Mapea 'action' -> 'metodo_asociado'
    protected function mapActions(){
        $this->map['create'] = 'create';
        $this->map['update'] = 'create';
        $this->map['delete'] = 'delete' ;
        $this->map['list'] = 'listAll';
        $this->map['show'] = 'show';

    }


    public function listAll(){
        $list = RepositorioSede::listAll(Conexion::getConexion());
        if(!is_null($list)){
            $response['status'] = 'success';
            $response['data'] = $list;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar Sedes';
        }

        return json_encode($response);

    }

    public function show(){
        if(!array_key_exists('id_sede', $this->params))
            throw  new Exception(self::class . ' show - id_sede no definido ');
        $id_sede = $this->params['id_sede'];

        $staff = RepositorioSede::findById(Conexion::getConexion(), $id_sede);

        if(!is_null($staff)){
            $response['status'] = 'success';
            $response['data'] = $staff;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar sede con ID: ' + $id_sede;
        }

        return json_encode($response);

    }

    public function create(){
        $sede = Sede::buildFromArray($this->params);
        $status = RepositorioSede::insertOrUpdate(Conexion::getConexion(),$sede);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Sede creado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'No pudo crearse Sede';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_sede', $this->params))
            throw  new Exception(self::class . ' delete - id_sede no definido ');

        $id_sede = $this->params['id_sede'];
        $status = RepositorioSede::delete(Conexion::getConexion(),$id_sede);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Sede eliminada correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al eliminar Sede';
        }
        return json_encode($response);
    }
}