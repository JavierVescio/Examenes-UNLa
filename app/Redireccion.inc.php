<?php

class Redireccion {
    public static function redirigir($url){
        header('Location: ' . $url,true,301);
        exit(); //se puede usar die() tambien.
        //El exit es para que los bots de google corten la ejecucion
        //301 indica redireccion
        //el true que no cambie la url en la barra de direcciones
    }
}