<?php
//require_once APP_PATH . '/Entity/Staff.inc.php';

class RepositorioStaff {

    /**
     * @return Staff[]
     */
    public static function findById($conexion, $id_staff = null)  {
        $listStaff = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT 
                            `staff`.`id_staff`, 
                            `staff`.`apellido`,
                            `staff`.`nombre`,
                            `staff`.`tipo_doc`,
                            `staff`.`documento`,
                            `staff`.`tipo_perfil`,
                            `staff`.`email`,
                            `staff`.`clave_acceso`,
                            `staff`.`id_sede`
                        FROM `royal_academy`.`staff`
                       ";

                if(!is_null($id_staff)) {
                    $sql = $sql . " WHERE `id_staff` = :id_staff;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_staff', $id_staff, PDO::PARAM_INT);
                    //$stmt->execute();
                    //$result = $stmt->fetch();
                }else {
                    $stmt = $conexion->prepare($sql);
                    //$stmt->execute();
                    //$result = $stmt->get_result();
                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    //while ($data = $result->fetch_assoc()) {
                    foreach ($result as $data){
                        $result = new Staff(
                            $data['id_staff'],
                            $data['apellido'],
                            $data['nombre'],
                            $data['tipo_doc'],
                            $data['documento'],
                            $data['tipo_perfil'],
                            $data['email'],
                            $data['clave_acceso'],
                            $data['id_sede']);

                        $listStaff[] = $data;
                    }
                }

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $listStaff = null;

            }
        }
        return $listStaff;

    }
    
     public static function obtener_staff_por_email($conexion,$email) {
        $staff = null;
        
        if (isset($conexion)) {
            try {
                //include_once 'Alumno.inc.php';
                
                $sql = "SELECT * FROM staff WHERE email = :email";
                $sentencia = $conexion->prepare($sql);
                $sentencia-> bindParam(':email',$email,PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetch(); //no hace falta fetchall, xq dara un unico resultado
                
                if (!empty($resultado)){
                    $staff = Staff::buildFromArray($resultado);
                }
                
                
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
            }
        }
        
        return $staff;
    }
    
    public static function listAll($conexion){
        return self::findById($conexion);
    }

    public static function delete($conexion, $id_staff = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_staff)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`staff` WHERE id_staff = :id_staff ; ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_staff',$id_staff,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }
    
    public static function insert($conexion, Staff $staff) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO staff 
	                        (`apellido`, `nombre`, `tipo_doc`, `documento`, `tipo_perfil`, `email`, `clave_acceso`, `id_sede`)
                        VALUES
	                        ( :apellido , :nombre ,  :tipo_doc , :documento, :tipo_perfil , :email , :clave_acceso , :id_sede );
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':apellido',$staff->getApellido(),PDO::PARAM_STR);
                $sentencia->bindParam(':nombre',$staff->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':tipo_doc',$staff->getTipoDoc(),PDO::PARAM_STR);
                $sentencia->bindParam(':documento',$staff->getDocumento(),PDO::PARAM_STR);
                $sentencia->bindParam(':tipo_perfil',$staff->getTipoPerfil(),PDO::PARAM_STR);
                $sentencia->bindParam(':email',$staff->getEmail(),PDO::PARAM_STR);
                $sentencia->bindParam(':clave_acceso',$staff->getClaveAcceso(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_sede',$staff->getIdSede(),PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function update($conexion, Staff $staff) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE staff 
                            SET
                                `apellido` = :apellido ,
                                `nombre` = :nombre ,
                                `tipo_doc` = :tipo_doc,
                                `documento` = :documento,
                                `tipo_perfil` = :tipo_perfil,
                                `email` = :email,
                                `clave_acceso` = :clave_acceso,
                                `id_sede` = :id_sede
                            WHERE `id_staff` = :id_staff;";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':apellido',$staff->getApellido(),PDO::PARAM_STR);
                $sentencia->bindParam(':nombre',$staff->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':tipo_doc',$staff->getTipoDoc(),PDO::PARAM_STR);
                $sentencia->bindParam(':documento',$staff->getDocumento(),PDO::PARAM_STR);
                $sentencia->bindParam(':tipo_perfil',$staff->getTipoPerfil(),PDO::PARAM_STR);
                $sentencia->bindParam(':email',$staff->getEmail(),PDO::PARAM_STR);
                $sentencia->bindParam(':clave_acceso',$staff->getClaveAcceso(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_sede',$staff->getIdSede(),PDO::PARAM_INT);

                $sentencia->bindParam(':id_staff',$staff->getIdStaff(),PDO::PARAM_INT);
                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insertOrUpdate($conexion, Staff $staff) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($staff->getIdStaff()) or $staff->getIdStaff() == 0)
                    $result = self::insert($conexion,$staff);
                else
                    $result = self::update($conexion,$staff);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }
}