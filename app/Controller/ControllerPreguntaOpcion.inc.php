<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioPreguntaOpcion.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/PreguntaOpcion.inc.php');

class ControllerPreguntaOpcion extends GenericController
{
    protected function mapActions(){
        $this->map['create'] = 'create';
        $this->map['update'] = 'create';
        $this->map['delete'] = 'delete' ;
        $this->map['list'] = 'listAll';
        $this->map['show'] = 'show';

    }


    public function create(){
        $preguntaOpcion = PreguntaOpcion::buildFromArray($this->params);
        $status = RepositorioPreguntaOpcion::insertOrUpdate(Conexion::getConexion(),$preguntaOpcion);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Opcion de pregunta creada correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Opcion de pregunta no pudo crearse';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_pregunta_opcion', $this->params))
            throw  new Exception(self::class . ' delete - id_pregunta_opcion no definido ');

        $id_pregunta_opcion = $this->params['id_pregunta_opcion'];
        $status = RepositorioPreguntaOpcion::delete(Conexion::getConexion(),$id_pregunta_opcion);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Opcion de pregunta eliminada correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Opcion de pregunta al eliminar Staff';
        }
        return json_encode($response);
    }

    public function listAll(){
        $lista = RepositorioPreguntaOpcion::listAll(Conexion::getConexion());
        if(!is_null($lista)){
            $response['status'] = 'success';
            $response['data'] = $lista;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar opciones de preguntas';
        }

        return json_encode($response);

    }

    public function show(){

        if(!array_key_exists('id_pregunta_imagen', $this->params))
            throw  new Exception(self::class . ' show - id_pregunta_imagen no definido ');
        $id_pregunta_imagen = $this->params['id_pregunta_imagen'];

        $preguntaImagen = RepositorioPreguntaImagen::findById(Conexion::getConexion(), $id_pregunta_imagen);

        if(!is_null($preguntaImagen)){
            $response['status'] = 'success';
            $response['data'] = $preguntaImagen;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar imagen de pregunta';
        }

        return json_encode($response);

    }

}