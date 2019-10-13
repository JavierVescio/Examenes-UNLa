<?php

class RepositorioAlumnos{

    public static function email_existe($conexion, $email) {
        //Vamos a buscar en la bd cualquier email que tenga ese nombre.
        $email_existe = false;
        
        if (isset($conexion)) {
            try {
                $sql = "SELECT email FROM alumnos WHERE email = :email";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':email',$email,PDO::PARAM_STR);
                
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();
                
                if (count($resultado)){ //cualquier resultado !=0 es verdadero
                    $email_existe = true;
                }
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
            }
        }
        
        return $email_existe;
    }
    
    public static function obtener_alumno_por_email($conexion,$email) {
        $alumno = null;
        
        if (isset($conexion)) {
            try {
                include_once 'Alumno.inc.php';
                
                $sql = "SELECT * FROM alumnos WHERE email = :email";
                $sentencia = $conexion->prepare($sql);
                $sentencia-> bindParam(':email',$email,PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetch(); //no hace falta fetchall, xq dara un unico resultado
                
                if (!empty($resultado)){
                    //$alumnos[] = new Alumno($fila['id'],$fila['nombre'],$fila['email'],$fila['password'],$fila['$fecha_registro'],$fila['activo']);                    
                    $alumno = new Alumno(
                            $resultado['id_alumno'],
                            $resultado['apellido'],
                            $resultado['nombre'],
                            $resultado['tipo_doc'],
                            $resultado['documento'],
                            $resultado['email'],
                            $resultado['celular'],
                            $resultado['clave_acceso'],
                            $resultado['id_sede_inscripcion'],
                            $resultado['id_staff_inscripcion'],
                            $resultado['fecha_alta']);
                }
                
                
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
            }
        }
        
        return $alumno;
    }
}
