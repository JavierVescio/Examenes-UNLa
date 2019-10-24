<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Controller/GenericController.inc.php');
include_once ( $_SERVER['DOCUMENT_ROOT'] . '/../app/Repository/RepositorioAlumnos.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Entity/Alumno.inc.php');

class ControllerAlumno extends GenericController
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
        $list = RepositorioAlumnos::listAll(Conexion::getConexion());
        if(!is_null($list)){
            $response['status'] = 'success';
            $response['data'] = $list;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al listar Alumnos';
        }

        return json_encode($response);

    }
    public function show(){

        if(!array_key_exists('id_alumno', $this->params))
            throw  new Exception(self::class . ' show - id_alumno no definido ');
        $id_alumno = $this->params['id_alumno'];

        $staff = RepositorioAlumnos::findById(Conexion::getConexion(), $id_alumno);

        if(!is_null($staff)){
            $response['status'] = 'success';
            $response['data'] = $staff;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al buscar Alumno con ID: ' + $id_alumno;
        }

        return json_encode($response);

    }

    public function create(){
        $alumno = Alumno::buildFromArray($this->params);
        $status = RepositorioAlumnos::insertOrUpdate(Conexion::getConexion(),$alumno);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Alumno creado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'No pudo crearse Alumno';
        }
        return json_encode($response);
    }

    public function delete(){
        if(!array_key_exists('id_alumno', $this->params))
            throw  new Exception(self::class . ' delete - id_alumno no definido ');

        $id_alumno = $this->params['id_alumno'];
        $status = RepositorioAlumnos::delete(Conexion::getConexion(),$id_alumno);

        if($status){
            $response['status'] = 'success';
            $response['message'] = 'Alumno eliminado correctamente';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Error al eliminar Alumno';
        }
        return json_encode($response);
    }
}