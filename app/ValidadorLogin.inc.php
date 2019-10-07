<?php
include_once 'RepositorioAlumnos.inc.php';

class ValidadorLogin {
    private $alumno;
    private $error;
    
    public function __construct($email,$clave,$conexion) {
        $this->error = "";
        
        if (!$this->variable_iniciada($email) || !$this->variable_iniciada($clave)){
            $this->alumno = null;
            $this->error="Debes introducir tu email y tu contraseña";
        } else {
            $this->alumno = RepositorioAlumnos::obtener_alumno_por_email($conexion,$email);
            if (is_null($this->alumno) || $clave != $this->alumno->getClave_acceso()){
                $this->error="Datos incorrectos";
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
    
    public function obtener_alumno(){
        return $this->alumno;
    }
    
    public function obtener_error() {
        return $this->error;
    }
    
    public function mostrar_error() {
        if ($this->error !== ''){
            echo "<br><div class='alert alert-danger' role='alert'>";
            echo $this->error;
            echo "</div><br>";
        }
    }
}
