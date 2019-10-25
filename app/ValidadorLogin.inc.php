<?php

include_once 'Repository/RepositorioAlumnos.inc.php';
include_once 'Repository/RepositorioStaff.inc.php';

class ValidadorLogin {

    private $alumno;
    private $admin;
    private $error;

    public function __construct($email, $clave, $es_alumno, $conexion) {
        $this->alumno = null;
        $this->admin = null;
        $this->error = "";

        if (!$this->variable_iniciada($email) || !$this->variable_iniciada($clave)) {
            $this->error = "Debes introducir tu email y tu contraseña";
        } else {
            if ($es_alumno) {
                $this->alumno = RepositorioAlumnos::obtener_alumno_por_email($conexion, $email);
                if (is_null($this->alumno) || $clave != $this->alumno->getClave_acceso()) {
                    $this->error = "Datos incorrectos";
                }
            } else {
                $this->admin = RepositorioStaff::obtener_staff_por_email($conexion, $email);
                if (is_null($this->admin) || $clave != $this->admin->getClaveAcceso()) {
                    $this->error = "Datos incorrectos";
                }
            }
        }
    }

    private function variable_iniciada($variable) {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

    public function obtener_alumno() {
        return $this->alumno;
    }

    public function obtener_staff() {
        return $this->admin;
    }

    public function obtener_error() {
        return $this->error;
    }

    public function mostrar_error() {
        if ($this->error !== '') {
            echo "<br><div class='alert alert-danger' role='alert'>";
            echo $this->error;
            echo "</div><br>";
        }
    }

}
