<?php

class ControlSesion {

    public static function iniciar_sesion_alumno($id_alumno, $nombre_alumno, $email_alumno) {
        if (session_id() == '') {
            session_start();
        }

        $_SESSION['id_alumno'] = $id_alumno;
        $_SESSION['nombre_alumno'] = $nombre_alumno;
        $_SESSION['email_alumno'] = $email_alumno;
    }

    public static function iniciar_sesion_staff($id_staff, $nombre_staff, $email_staff) {
        if (session_id() == '') {
            session_start();
        }

        $_SESSION['id_staff'] = $id_staff;
        $_SESSION['nombre_staff'] = $nombre_staff;
        $_SESSION['email_staff'] = $email_staff;
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

    public static function cerrar_sesion_staff() {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_staff'])) {
            unset($_SESSION['id_staff']);
        }
        if (isset($_SESSION['nombre_staff'])) {
            unset($_SESSION['nombre_staff']);
        }
        if (isset($_SESSION['email_staff'])) {
            unset($_SESSION['email_staff']);
        }

        session_destroy();
    }

    public static function sesion_iniciada_alumno() {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['nombre_alumno']) && isset($_SESSION['email_alumno']) && isset($_SESSION['id_alumno'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function sesion_iniciada_staff() {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['nombre_staff']) && isset($_SESSION['email_staff']) && isset($_SESSION['id_staff'])) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function obtener_id_staff(){
        if (session_id() == '') {
            session_start();
        }
        
        if (isset($_SESSION['id_staff'])){
            return $_SESSION['id_staff'];
        }else {
            return -1;
        }
    }

    public static function obtener_id_alumno(){
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_alumno'])){
            return $_SESSION['id_alumno'];
        }else {
            return -1;
        }
    }

}
