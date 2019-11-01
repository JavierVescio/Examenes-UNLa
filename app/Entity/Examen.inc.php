<?php


class Examen
{
    private $id_examen;
    private $id_curso;
    private $fecha_creacion;
    private $id_usuario_creador;
    private $cantidad_preguntas;
    private $nota_aprobacion;


    /**
     * Examen constructor.
     * @param $id_examen
     * @param $id_curso
     * @param $fecha_creacion
     * @param $id_usuario_creador
     * @param $cantidad_preguntas
     * @param $nota_aprobacion
     */
    public function __construct($id_examen, $id_curso, $fecha_creacion, $id_usuario_creador, $cantidad_preguntas, $nota_aprobacion)
    {
        $this->id_examen = $id_examen;
        $this->id_curso = $id_curso;
        $this->fecha_creacion = $fecha_creacion;
        $this->id_usuario_creador = $id_usuario_creador;
        $this->cantidad_preguntas = $cantidad_preguntas;
        $this->nota_aprobacion = $nota_aprobacion;
    }

    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new Examen(
            $arr['id_examen'],
            $arr['id_curso'],
            $arr['fecha_creacion'],
            $arr['id_usuario_creador'],
            $arr['cantidad_preguntas'],
            $arr['nota_aprobacion']
        );
    }

    /**
     * @return mixed
     */
    public function getIdExamen()
    {
        return $this->id_examen;
    }

    /**
     * @param mixed $id_examen
     */
    public function setIdExamen($id_examen)
    {
        $this->id_examen = $id_examen;
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
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * @param mixed $fecha_creacion
     */
    public function setFechaCreacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    /**
     * @return mixed
     */
    public function getIdUsuarioCreador()
    {
        return $this->id_usuario_creador;
    }

    /**
     * @param mixed $id_usuario_creador
     */
    public function setIdUsuarioCreador($id_usuario_creador)
    {
        $this->id_usuario_creador = $id_usuario_creador;
    }

    /**
     * @return mixed
     */
    public function getCantidadPreguntas()
    {
        return $this->cantidad_preguntas;
    }

    /**
     * @param mixed $cantidad_preguntas
     */
    public function setCantidadPreguntas($cantidad_preguntas)
    {
        $this->cantidad_preguntas = $cantidad_preguntas;
    }

    /**
     * @return mixed
     */
    public function getNotaAprobacion()
    {
        return $this->nota_aprobacion;
    }

    /**
     * @param mixed $nota_aprobacion
     */
    public function setNotaAprobacion($nota_aprobacion)
    {
        $this->nota_aprobacion = $nota_aprobacion;
    }



}