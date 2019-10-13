<?php

class RepositorioAlumnos{

    /**
     * @return Alumno[]
     */
    public static function findById($conexion, $id_alumno = null)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `alumnos`.`id_alumno`,
                            `alumnos`.`apellido`,
                            `alumnos`.`nombre`,
                            `alumnos`.`genero`,
                            `alumnos`.`tipo_doc`,
                            `alumnos`.`documento`,
                            `alumnos`.`email`,
                            `alumnos`.`celular`,
                            `alumnos`.`clave_acceso`,
                            `alumnos`.`id_sede_inscripcion`,
                            `alumnos`.`id_staff_inscripcion`,
                            `alumnos`.`fecha_alta`
                        FROM `royal_academy`.`alumnos`
                       ";

                if(!is_null($id_alumno)) {
                    $sql = $sql . " WHERE `id_alumno` = :id_alumno;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = Alumno::buildFromArray($data);
                        $list[] = $data;
                    }
                }

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $list = null;

            }
        }
        return $list;

    }
    public static function listAll($conexion){
        return self::findById($conexion);
    }

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
