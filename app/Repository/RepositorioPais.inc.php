<?php


class RepositorioPais
{
    /**
     * @return Pais[]
     */
    public static function findById($conexion, $id_pais = null)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `paises`.`id_pais`,
                            `paises`.`nombre`,
                            `paises`.`nombre_corto`
                        FROM `royal_academy`.`paises`
                       ";

                if(!is_null($id_pais)) {
                    $sql = $sql . " WHERE `id_pais` = :id_pais;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_pais', $id_pais, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = new Pais(
                            $data['id_pais'],
                            $data['nombre'],
                            $data['nombre_corto']);

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

    public static function delete($conexion, $id_pais = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_pais)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`paises` WHERE `id_pais` = :id_pais;";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_pais',$id_pais,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function insert($conexion, Pais $pais) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `royal_academy`.`paises`
                            (`nombre`, `nombre_corto`)
                        VALUES
                            (:nombre, :nombre_corto);
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':nombre',$pais->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':nombre_corto',$pais->getNombreCorto(),PDO::PARAM_STR);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function update($conexion, Pais $pais) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `royal_academy`.`paises`
                        SET
                        `nombre` = :nombre,
                        `nombre_corto` = :nombre_corto
                        WHERE `id_pais` = :id_pais;
                        ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':nombre',$pais->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':nombre_corto',$pais->getNombreCorto(),PDO::PARAM_STR);

                $sentencia->bindParam(':id_pais',$pais->getIdPais(),PDO::PARAM_INT);
                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insertOrUpdate($conexion, Pais $pais) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($pais->getIdPais()) or $pais->getIdPais() == 0)
                    $result = self::insert($conexion,$pais);
                else
                    $result = self::update($conexion,$pais);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }
}