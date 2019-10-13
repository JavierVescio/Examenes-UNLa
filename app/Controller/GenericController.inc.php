<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../app/Conexion.inc.php');

abstract class GenericController
{

    protected $action = null;
    protected $params;

    protected $map;


    public function __construct()
    {

    }

    protected abstract function mapActions();

    public function post($arr){

        if(!array_key_exists('action', $arr))
            throw  new Exception(self::class . '- Action no definida en el mapa de acciones ');

        $this->action = $arr['action'];
        $this->params = $arr;
        $this->mapActions();
    }


    public function run(){
        if(is_null($this->action))
            throw  new Exception(self::class . '- Action no definida ');

        $action = $this->map[$this->action];
        return $this->{$action}();

    }

}