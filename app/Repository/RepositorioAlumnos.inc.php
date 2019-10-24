<?php
require_once WWW_PATH . '/constantes.php';
require_once APP_PATH . '/Entity/Alumno.inc.php';


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
                //include_once 'Alumno.inc.php';
                
                $sql = "SELECT * FROM alumnos WHERE email = :email";
                $sentencia = $conexion->prepare($sql);
                $sentencia-> bindParam(':email',$email,PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetch(); //no hace falta fetchall, xq dara un unico resultado
                
                if (!empty($resultado)){
                    //$alumnos[] = new Alumno($fila['id'],$fila['nombre'],$fila['email'],$fila['password'],$fila['$fecha_registro'],$fila['activo']);                    
                    $alumno = Alumno::buildFromArray($resultado);/*
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
                            $resultado['fecha_alta']);*/
                }
                
                
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
            }
        }
        
        return $alumno;
    }

    public static function delete($conexion, $id_alumno = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_alumno)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`alumnos` WHERE `id_alumno` = :id_alumno ;";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_alumno',$id_alumno,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function insert($conexion, Alumno $alumno) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `royal_academy`.`alumnos`
                            (`apellido`, `nombre`, `genero`, `tipo_doc`, `documento`,
                            `email`, `celular`, `clave_acceso`,  `id_sede_inscripcion`,
                            `id_staff_inscripcion`, `fecha_alta`)
                        VALUES
                            (:apellido , :nombre, :genero , :tipo_doc , :documento, 
                            :email, :celular, :clave_acceso, :id_sede_inscripcion,
                            :id_staff_inscripcion, :fecha_alta);
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':apellido',$alumno->getApellido(),PDO::PARAM_STR);
                $sentencia->bindParam(':nombre',$alumno->getNombre(),PDO::PARAM_STR);
                // TODO agregar genero a Alumno
                $sentencia->bindParam(':genero','M'/*$alumno->getGenero()*/,PDO::PARAM_STR);
                $sentencia->bindParam(':tipo_doc',$alumno->getTipo_doc(),PDO::PARAM_STR);
                $sentencia->bindParam(':documento',$alumno->getDocumento(),PDO::PARAM_STR);
                $sentencia->bindParam(':email',$alumno->getEmail(),PDO::PARAM_STR);
                $sentencia->bindParam(':celular',$alumno->getCelular(),PDO::PARAM_STR);
                $sentencia->bindParam(':clave_acceso',$alumno->getClave_acceso(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_sede_inscripcion',$alumno->getId_sede_inscripcion(),PDO::PARAM_INT);
                $sentencia->bindParam(':id_staff_inscripcion',$alumno->getId_staff_inscripcion(),PDO::PARAM_INT);
                $sentencia->bindParam(':fecha_alta',$alumno->getFecha_alta(),PDO::PARAM_STR);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function update($conexion, Alumno $alumno) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `royal_academy`.`alumnos`
                        SET
                        `apellido` = :apellido,
                        `nombre` = :nombre,
                        `genero` = :genero,
                        `tipo_doc` = :tipo_doc,
                        `documento` = :documento,
                        `email` = :email,
                        `celular` = :celular,
                        `clave_acceso` = :clave_acceso,
                        `id_sede_inscripcion` = :id_sede_inscripcion,
                        `id_staff_inscripcion` = :id_staff_inscripcion,
                        `fecha_alta` = :fecha_alta
                        WHERE `id_alumno` = :id_alumno;
                        ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':apellido',$alumno->getApellido(),PDO::PARAM_STR);
                $sentencia->bindParam(':nombre',$alumno->getNombre(),PDO::PARAM_STR);
                // TODO agregar genero a Alumno
                $sentencia->bindParam(':genero','M'/*$alumno->getGenero()*/,PDO::PARAM_STR);
                $sentencia->bindParam(':tipo_doc',$alumno->getTipo_doc(),PDO::PARAM_STR);
                $sentencia->bindParam(':documento',$alumno->getDocumento(),PDO::PARAM_STR);
                $sentencia->bindParam(':email',$alumno->getEmail(),PDO::PARAM_STR);
                $sentencia->bindParam(':celular',$alumno->getCelular(),PDO::PARAM_STR);
                $sentencia->bindParam(':clave_acceso',$alumno->getClave_acceso(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_sede_inscripcion',$alumno->getId_sede_inscripcion(),PDO::PARAM_INT);
                $sentencia->bindParam(':id_staff_inscripcion',$alumno->getId_staff_inscripcion(),PDO::PARAM_INT);
                $sentencia->bindParam(':fecha_alta',$alumno->getFecha_alta(),PDO::PARAM_STR);

                $sentencia->bindParam(':id_alumno',$alumno->getId_alumno(),PDO::PARAM_INT);
                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function insertOrUpdate($conexion, Alumno $alumno) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($alumno->getId_alumno()) or $alumno->getId_alumno() == 0)
                    $result = self::insert($conexion,$alumno);
                else
                    $result = self::update($conexion,$alumno);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }
}
