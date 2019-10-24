<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioPais.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Pais.inc.php');

class ControllerPais extends GenericController
{


    // Mapea 'action' -> 'metodo_asociado'
    protected function mapActions(){
        $this->map['create'] = 'create';
        $this->map['update'] = 'create';
        $this->map['delete'] = 'delete' ;
        $this->map['list'] = 'listAll';
        //$this->map['show'] = 'show';

    }


    public function listAll(){
        $list = RepositorioPais::listAll(Conexion::getConexion());
        if(!is_null($list)){
            $response['status'] = 'success';
            $response['data'] = $list;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar Paises';
        }

        return json_encode($response);

    }

    public function show(){

        if(!array_key_exists('id_pais', $this->params))
            throw  new Exception(self::class . ' delete - id_pais no definido ');
        $id_pais = $this->params['id_pais'];

        $pregunta = RepositorioPais::findById(Conexion::getConexion(), $id_pais);

        if(!is_null($pregunta)){
            $response['status'] = 'success';
            $response['data'] = $pregunta;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar Pais';
        }

        return json_encode($response);

    }


    public function create(){
        $pais = Pais::buildFromArray($this->params);
        $status = RepositorioPais::insertOrUpdate(Conexion::getConexion(),$pais);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Pais creado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Pais creado correctamente';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_pais', $this->params))
            throw  new Exception(self::class . ' delete - id_pais no definido ');

        $id_pais = $this->params['id_pais'];
        $status = RepositorioPais::delete(Conexion::getConexion(),$id_pais);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Pais eliminado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al eliminar Pais';
        }
        return json_encode($response);
    }
}