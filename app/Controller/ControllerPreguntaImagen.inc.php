<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioPreguntaImagen.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/PreguntaImagen.inc.php');

class ControllerPreguntaImagen extends GenericController
{
    protected function mapActions(){
        $this->map['create'] = 'replace';
        $this->map['update'] = 'replace';
        //$this->map['delete'] = 'delete' ;
        //$this->map['list'] = 'listAll';
        $this->map['show'] = 'showByPregunta';

    }

    public function replace(){
        if(!array_key_exists('id_pregunta', $this->params))
            throw  new Exception(self::class . ' delete - id_pregunta no definido ');

        $id_pregunta = $this->params['id_pregunta'];
        RepositorioPreguntaImagen::deleteByPregunta(Conexion::getConexion(),$id_pregunta);
        $response = json_decode($this->create(),true);

        if($response['status'] == "success")
            return $this->showByPregunta();
        else
            return json_encode($response) ;
    }

    public function create(){

        $nueva_imagen = $this->params['nueva_imagen'];

        $dir_imagenes = '/img/preguntas/';
        $hash_file = md5_file($nueva_imagen['tmp_name']);
        $fichero_subido = WWW_PATH . $dir_imagenes . $hash_file;

        if (move_uploaded_file($nueva_imagen['tmp_name'], $fichero_subido)) {
            //echo "El fichero es válido y se subió con éxito.\n";
            $this->params['path'] =  $dir_imagenes . $hash_file ;
            $this->params['descripcion'] = $nueva_imagen['name'] ;
            $preguntaImagen = PreguntaImagen::buildFromArray($this->params);
            $status = RepositorioPreguntaImagen::insertOrUpdate(Conexion::getConexion(),$preguntaImagen);
        } else {
            $status = false;
            //echo "¡Posible ataque de subida de ficheros!\n";
        }



        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Imagen de pregunta creada correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Imagen de pregunta no pudo crearse';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_pregunta_imagen', $this->params))
            throw  new Exception(self::class . ' delete - id_pregunta_imagen no definido ');

        $id_pregunta_imagen = $this->params['id_pregunta_imagen'];
        $status = RepositorioPreguntaImagen::delete(Conexion::getConexion(),$id_pregunta_imagen);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Imagen de pregunta eliminada correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Imagen de pregunta al eliminar Staff';
        }
        return json_encode($response);
    }

    public function listAll(){
        $lista = RepositorioPreguntaImagen::listAll(Conexion::getConexion());
        if(!is_null($lista)){
            $response['status'] = 'success';
            $response['data'] = $lista;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar imagenes de preguntas';
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

    public function showByPregunta(){

        if(!array_key_exists('id_pregunta', $this->params))
            throw  new Exception(self::class . ' show - id_pregunta no definido ');
        $id_pregunta = $this->params['id_pregunta'];

        $preguntaImagen = RepositorioPreguntaImagen::findByPregunta(Conexion::getConexion(), $id_pregunta);

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