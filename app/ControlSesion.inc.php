<?php

class ControlSesion {

    public static function iniciar_sesion_alumno($id_alumno, $nombre_alumno, $email_alumno) {
        if (session_id() == '') {
            session_start();
        }
        
        $_SESSION['id_alumno'] = $id_alumno;
        $_SESSION['nombre_alumno'] = $nombre_alumno;
        $_SESSION['email_alumno'] = $nombre_alumno;
        
    }
    
    public static function cerrar_sesion_alumno() {
        if (session_id() == '') {
            session_start();
        }
        
        if (isset($_SESSION['id_alumno'])) {
            unset($_SESSION['id_alumno']);
        }
        if (isset($_SESSION['nombre_alumno'])) {
            unset($_SESSION['nombre_alumno']);
        }
        if (isset($_SESSION['email_alumno'])) {
            unset($_SESSION['email_alumno']);
        }
        
        session_destroy();
    }
    
    public static function sesion_iniciada_alumno() {
        if (session_id() == '') {
            session_start();
        }
        
        if (isset($_SESSION['nombre_alumno']) && isset($_SESSION['email_alumno']) && isset($_SESSION['id_alumno'])) {
            return true;
        }else{
            return false;
        }
    }
}
