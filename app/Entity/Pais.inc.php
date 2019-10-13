<?php


class Pais
{
    private $id_pais;
    private $nombre;
    private $nombre_corto;


    /**
     * Pais constructor.
     * @param $id_pais
     * @param $nombre
     * @param $nombre_corto
     */
    public function __construct($id_pais, $nombre, $nombre_corto)
    {
        $this->id_pais = $id_pais;
        $this->nombre = $nombre;
        $this->nombre_corto = $nombre_corto;
    }


    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new Pais($arr['id_pais'],
            $arr['nombre'],
            $arr['nombre_corto']);
    }

    /**
     * @return mixed
     */
    public function getIdPais()
    {
        return $this->id_pais;
    }

    /**
     * @param mixed $id_pais
     */
    public function setIdPais($id_pais)
    {
        $this->id_pais = $id_pais;
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
    public function getNombreCorto()
    {
        return $this->nombre_corto;
    }

    /**
     * @param mixed $nombre_corto
     */
    public function setNombreCorto($nombre_corto)
    {
        $this->nombre_corto = $nombre_corto;
    }



}