<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioPregunta.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Pregunta.inc.php');

class ControllerPregunta extends GenericController
{
    protected function mapActions(){
        $this->map['create'] = 'create';
        $this->map['update'] = 'create';
        $this->map['delete'] = 'delete' ;
        $this->map['list'] = 'listAll';
        $this->map['show'] = 'show';

    }


    public function create(){
        $pregunta = Pregunta::buildFromArray($this->params);
        $status = RepositorioPregunta::insertOrUpdate(Conexion::getConexion(),$pregunta);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Pregunta creada correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Pregunta creada correctamente';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_pregunta', $this->params))
            throw  new Exception(self::class . ' delete - id_pregunta no definido ');

        $id_pregunta = $this->params['id_pregunta'];
        $status = RepositorioPregunta::delete(Conexion::getConexion(),$id_pregunta);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Pregunta eliminada correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al eliminar Pregunta';
        }
        return json_encode($response);
    }

    public function listAll(){
        $lista = RepositorioPregunta::listAll(Conexion::getConexion());
        if(!is_null($lista)){
            $response['status'] = 'success';
            $response['data'] = $lista;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar preguntas';
        }

        return json_encode($response);

    }

    public function show(){

        if(!array_key_exists('id_pregunta', $this->params))
            throw  new Exception(self::class . ' delete - id_pregunta no definido ');
        $id_pregunta = $this->params['id_pregunta'];

        $pregunta = RepositorioPregunta::findById(Conexion::getConexion(), $id_pregunta);

        if(!is_null($pregunta)){
            $response['status'] = 'success';
            $response['data'] = $pregunta;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar Pregunta';
        }

        return json_encode($response);

    }

}