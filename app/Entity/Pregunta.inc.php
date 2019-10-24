<?php


class Pregunta
{
    private $id_pregunta;
    private $id_curso;
    private $descripcion;
    private $cant_opciones_validas;

    /**
     * Pregunta constructor.
     * @param $id_pregunta
     * @param $id_curso
     * @param $descripcion
     * @param $cant_opciones_validas
     */
    public function __construct($id_pregunta, $id_curso, $descripcion, $cant_opciones_validas)
    {
        $this->id_pregunta = $id_pregunta;
        $this->id_curso = $id_curso;
        $this->descripcion = $descripcion;
        $this->cant_opciones_validas = $cant_opciones_validas;
    }

    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new Pregunta(
            $arr['id_pregunta'],
            $arr['id_curso'],
            $arr['descripcion'],
            $arr['cant_opciones_validas']);
    }

    /**
     * @return mixed
     */
    public function getIdPregunta()
    {
        return $this->id_pregunta;
    }

    /**
     * @param mixed $id_pregunta
     */
    public function setIdPregunta($id_pregunta)
    {
        $this->id_pregunta = $id_pregunta;
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

    /**
     * @return mixed
     */
    public function getCantOpcionesValidas()
    {
        return $this->cant_opciones_validas;
    }

    /**
     * @param mixed $cant_opciones_validas
     */
    public function setCantOpcionesValidas($cant_opciones_validas)
    {
        $this->cant_opciones_validas = $cant_opciones_validas;
    }

}