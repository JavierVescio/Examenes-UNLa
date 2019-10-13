<?php


class Curso
{
    private $id_curso;
    private $nombre;
    private $descripcion;

    /**
     * Curso constructor.
     * @param $id_curso
     * @param $nombre
     * @param $descripcion
     */
    public function __construct($id_curso, $nombre, $descripcion)
    {
        $this->id_curso = $id_curso;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new Curso(
            $arr['id_curso'],
            $arr['nombre'],
            $arr['descripcion']);
    }

    /**
     * @return mixed
     */
    public function getIdCurso()
    {
        return $this->id_curso;
    }

    /**
     * @param mixed $id_curso
     */
    public function setIdCurso($id_curso)
    {
        $this->id_curso = $id_curso;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }



}