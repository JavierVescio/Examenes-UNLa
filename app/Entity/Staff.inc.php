<?php


class Staff
{
  private $id_staff;
  private $apellido;
  private $nombre;
  private $tipo_doc;
  private $documento;
  private $tipo_perfil;
  private $email;
  private $clave_acceso;
  private $id_sede;

    /**
     * Staff constructor.
     * @param $id_staff
     * @param $apellido
     * @param $nombre
     * @param $tipo_doc
     * @param $documento
     * @param $tipo_perfil
     * @param $email
     * @param $clave_acceso
     * @param $id_sede
     */
    public function __construct($id_staff, $apellido, $nombre, $tipo_doc, $documento, $tipo_perfil, $email, $clave_acceso, $id_sede)
    {
        $this->id_staff = $id_staff;
        $this->apellido = $apellido;
        $this->nombre = $nombre;
        $this->tipo_doc = $tipo_doc;
        $this->documento = $documento;
        $this->tipo_perfil = $tipo_perfil;
        $this->email = $email;
        $this->clave_acceso = $clave_acceso;
        $this->id_sede = $id_sede;
    }

    public static function buildFromArray(array $arr){
        //var_dump($arr);
        return new Staff($arr['id_staff'],
                         $arr['apellido'],
                        $arr['nombre'],
                        $arr['tipo_doc'],
                        $arr['documento'],
                        $arr['tipo_perfil'],
                        $arr['email'],
                        $arr['clave_acceso'],
                        $arr['id_sede']);
    }


    /**
     * @return mixed
     */
    public function getIdStaff()
    {
        return $this->id_staff;
    }

    /**
     * @param mixed $id_staff
     */
    public function setIdStaff($id_staff)
    {
        $this->id_staff = $id_staff;
    }

    /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
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
    public function getTipoDoc()
    {
        return $this->tipo_doc;
    }

    /**
     * @param mixed $tipo_doc
     */
    public function setTipoDoc($tipo_doc)
    {
        $this->tipo_doc = $tipo_doc;
    }

    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param mixed $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    /**
     * @return mixed
     */
    public function getTipoPerfil()
    {
        return $this->tipo_perfil;
    }

    /**
     * @param mixed $tipo_perfil
     */
    public function setTipoPerfil($tipo_perfil)
    {
        $this->tipo_perfil = $tipo_perfil;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getClaveAcceso()
    {
        return $this->clave_acceso;
    }

    /**
     * @param mixed $clave_acceso
     */
    public function setClaveAcceso($clave_acceso)
    {
        $this->clave_acceso = $clave_acceso;
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




}