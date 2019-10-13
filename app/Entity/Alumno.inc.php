<?php

class Alumno {
    private $id_alumno;
    private $apellido;
    private $nombre;
    private $tipo_doc;
    private $documento;
    private $email;
    private $celular;
    private $clave_acceso;
    private $id_sede_inscripcion;
    private $id_staff_inscripcion;
    private $fecha_alta;
    
    public function __construct($id_alumno,$apellido, $nombre, $tipo_doc, $documento, $email, $celular, $clave_acceso, $id_sede_inscripcion, $id_staff_inscripcion, $fecha_alta) {
        $this->id_alumno = $id_alumno;
        $this->apellido = $apellido;
        $this->nombre = $nombre;
        $this->tipo_doc = $tipo_doc;
        $this->documento = $documento;
        $this->email = $email;
        $this->celular = $celular;
        $this->clave_acceso = $clave_acceso;
        $this->id_sede_inscripcion = $id_sede_inscripcion;
        $this->id_staff_inscripcion = $id_staff_inscripcion;
        $this->fecha_alta = $fecha_alta;
    }

    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new Alumno(
            $arr['id_alumno'],
            $arr['apellido'],
            $arr['nombre'],
            $arr['tipo_doc'],
            $arr['documento'],
            $arr['email'],
            $arr['celular'],
            $arr['clave_acceso'],
            $arr['id_sede_inscripcion'],
            $arr['id_staff_inscripcion'],
            $arr['fecha_alta']);
    }
       
    public function getId_alumno() {
        return $this->id_alumno;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getNombre() {
        return $this->nombre;
    }
    
    public function getTipo_doc() {
        return $this->tipo_doc;
    }

    public function getDocumento() {
        return $this->documento;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getClave_acceso() {
        return $this->clave_acceso;
    }

    public function getId_sede_inscripcion() {
        return $this->id_sede_inscripcion;
    }

    public function getId_staff_inscripcion() {
        return $this->id_staff_inscripcion;
    }

    public function getFecha_alta() {
        return $this->fecha_alta;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setTipo_doc($tipo_doc) {
        $this->tipo_doc = $tipo_doc;
    }

    public function setDocumento($documento) {
        $this->documento = $documento;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }

    public function setClave_acceso($clave_acceso) {
        $this->clave_acceso = $clave_acceso;
    }

    public function setId_sede_inscripcion($id_sede_inscripcion) {
        $this->id_sede_inscripcion = $id_sede_inscripcion;
    }

    public function setId_staff_inscripcion($id_staff_inscripcion) {
        $this->id_staff_inscripcion = $id_staff_inscripcion;
    }

    public function setFecha_alta($fecha_alta) {
        $this->fecha_alta = $fecha_alta;
    }


}
