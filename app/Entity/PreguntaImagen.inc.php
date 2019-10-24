<?php


class PreguntaImagen
{
    private $id_pregunta_imagen;
    private $path;
    private $descripcion;
    private $id_pregunta;


    /**
     * PreguntaImagen constructor.
     * @param $id_pregunta_imagen
     * @param $path
     * @param $descripcion
     * @param $id_pregunta
     */
    public function __construct($id_pregunta_imagen, $path, $descripcion, $id_pregunta)
    {
        $this->id_pregunta_imagen = $id_pregunta_imagen;
        $this->path = $path;
        $this->descripcion = $descripcion;
        $this->id_pregunta = $id_pregunta;
    }

    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new PreguntaImagen(
            $arr['id_pregunta_imagen'],
            $arr['path'],
            $arr['descripcion'],
            $arr['id_pregunta']);
    }

    /**
     * @return mixed
     */
    public function getIdPreguntaImagen()
    {
        return $this->id_pregunta_imagen;
    }

    /**
     * @param mixed $id_pregunta_imagen
     */
    public function setIdPreguntaImagen($id_pregunta_imagen)
    {
        $this->id_pregunta_imagen = $id_pregunta_imagen;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
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




}