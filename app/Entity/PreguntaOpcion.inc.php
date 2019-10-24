<?php


class PreguntaOpcion
{
    private $id_opcion;
    private $id_pregunta;
    private $descripcion;
    private $es_correcta;

    /**
     * PreguntaOpcion constructor.
     * @param $id_opcion
     * @param $id_pregunta
     * @param $descripcion
     * @param $es_correcta
     */
    public function __construct($id_opcion, $id_pregunta, $descripcion, $es_correcta)
    {
        $this->id_opcion = $id_opcion;
        $this->id_pregunta = $id_pregunta;
        $this->descripcion = $descripcion;
        $this->es_correcta = $es_correcta;
    }

    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new PreguntaOpcion(
            $arr['id_opcion'],
            $arr['id_pregunta'],
            $arr['descripcion'],
            $arr['es_correcta']);
    }

    /**
     * @return mixed
     */
    public function getIdOpcion()
    {
        return $this->id_opcion;
    }

    /**
     * @param mixed $id_opcion
     */
    public function setIdOpcion($id_opcion)
    {
        $this->id_opcion = $id_opcion;
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
    public function getEsCorrecta()
    {
        return $this->es_correcta;
    }

    /**
     * @param mixed $es_correcta
     */
    public function setEsCorrecta($es_correcta)
    {
        $this->es_correcta = $es_correcta;
    }



}