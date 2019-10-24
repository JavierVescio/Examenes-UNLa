<?php


class RepositorioSede
{

    /**
     * @return Sede[]
     */
    public static function findById($conexion, $id_sede = null)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `sedes`.`id_sede`,
                            `sedes`.`nombre`,
                            `sedes`.`direccion`,
                            `sedes`.`id_pais`
                        FROM `royal_academy`.`sedes` 
                       ";

                if(!is_null($id_sede)) {
                    $sql = $sql . " WHERE `id_sede` = :id_sede ;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_sede', $id_sede, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    //while ($data = $result->fetch_assoc()) {
                    foreach ($result as $data){
                        $result = Sede::buildFromArray($data);
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

    /**
     * @return Sede[]
     */
    public static function listAll($conexion){
        return self::findById($conexion);
    }

    public static function delete($conexion, $id_sede = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_sede)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`sedes` WHERE `id_sede` = :id_sede ;";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_sede',$id_sede,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function insert($conexion, Sede $sede) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `royal_academy`.`sedes`
                            (`nombre`, `direccion`, `id_pais`)
                        VALUES
                            ( :nombre , :direccion , :id_pais );
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':nombre',$sede->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':direccion',$sede->getDireccion(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_pais',$sede->getIdPais(),PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function update($conexion, Sede $sede) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `royal_academy`.`sedes`
                        SET
                        `nombre` = :nombre,
                        `direccion` = :direccion,
                        `id_pais` = :id_pais
                        WHERE `id_sede` = :id_sede ;";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':nombre',$sede->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':direccion',$sede->getDireccion(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_pais',$sede->getIdPais(),PDO::PARAM_INT);

                $sentencia->bindParam(':id_sede',$sede->getIdSede(),PDO::PARAM_INT);
                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insertOrUpdate($conexion, Sede $sede) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($sede->getIdSede()) or $sede->getIdSede() == 0)
                    $result = self::insert($conexion,$sede);
                else
                    $result = self::update($conexion,$sede);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

}