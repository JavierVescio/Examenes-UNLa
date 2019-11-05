<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioExamen.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Examen.inc.php');


class ControllerExamen extends GenericController
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
        $list = RepositorioExamen::listAll(Conexion::getConexion());
        if(!is_null($list)){
            $response['status'] = 'success';
            $response['data'] = $list;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar Examenes';
        }

        return json_encode($response);

    }
    public function show(){

        if(!array_key_exists('id_examen', $this->params))
            throw  new Exception(self::class . ' show - id_examen no definido ');
        $id_examen= $this->params['id_examen'];

        $examen = RepositorioExamen::findById(Conexion::getConexion(), $id_examen);

        if(!is_null($examen)){
            $response['status'] = 'success';
            $response['data'] = $examen;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar Examen con ID: ' + $id_examen;
        }

        return json_encode($response);

    }

    public function create(){
        $examen = Examen::buildFromArray($this->params);
        $status = RepositorioExamen::insertOrUpdate(Conexion::getConexion(),$examen);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Examen creado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al crear Examen';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_examen', $this->params))
            throw  new Exception(self::class . ' delete - id_examen no definido ');

        $id_examen = $this->params['id_examen'];
        $status = RepositorioExamen::delete(Conexion::getConexion(),$id_examen);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Examen eliminado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al eliminar Examen';
        }
        return json_encode($response);
    }

}
