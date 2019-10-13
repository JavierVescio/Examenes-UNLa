<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioSede.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Sede.inc.php');

class ControllerSede extends GenericController
{


    // Mapea 'action' -> 'metodo_asociado'
    protected function mapActions(){
        /*$this->map['create'] = 'create';
        $this->map['update'] = 'create';
        $this->map['delete'] = 'delete' ; */
        $this->map['list'] = 'listAll';
        //$this->map['show'] = 'show';

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
}