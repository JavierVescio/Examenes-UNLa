<?php


class Sede
{
    private $id_sede;
    private $nombre;
    private $direccion;
    private $id_pais;

    /**
     * Sede constructor.
     * @param $id_sede
     * @param $nombre
     * @param $direccion
     * @param $id_pais
     */
    public function __construct($id_sede, $nombre, $direccion, $id_pais)
    {
        $this->id_sede = $id_sede;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->id_pais = $id_pais;
    }


    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new Sede($arr['id_sede'],
            $arr['nombre'],
            $arr['direccion'],
            $arr['id_pais']);
    }

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->id_sede;
    }

    /**
     * @param mixed $id_sede
     */
    public function setIdSede($id_sede)
    {
        $this->id_sede = $id_sede;
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
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
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



}