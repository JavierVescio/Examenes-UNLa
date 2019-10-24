<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioCurso.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Curso.inc.php');


class ControllerCurso extends GenericController
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
        $list = RepositorioCurso::listAll(Conexion::getConexion());
        if(!is_null($list)){
            $response['status'] = 'success';
            $response['data'] = $list;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar Cursos';
        }

        return json_encode($response);

    }
    public function show(){

        if(!array_key_exists('id_curso', $this->params))
            throw  new Exception(self::class . ' show - id_curso no definido ');
        $id_curso = $this->params['id_curso'];

        $staff = RepositorioCurso::findById(Conexion::getConexion(), $id_curso);

        if(!is_null($staff)){
            $response['status'] = 'success';
            $response['data'] = $staff;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar Curso con ID: ' + $id_curso;
        }

        return json_encode($response);

    }

    public function create(){
        $curso = Curso::buildFromArray($this->params);
        $status = RepositorioCurso::insertOrUpdate(Conexion::getConexion(),$curso);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Curso creado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al crear Curso';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_curso', $this->params))
            throw  new Exception(self::class . ' delete - id_curso no definido ');

        $id_curso = $this->params['id_curso'];
        $status = RepositorioCurso::delete(Conexion::getConexion(),$id_curso);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Curso eliminado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al eliminar Curso';
        }
        return json_encode($response);
    }

}