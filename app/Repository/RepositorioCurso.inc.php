<?php


class RepositorioCurso
{
    /**
     * @return Curso[]
     */
    public static function findById($conexion, $id = null)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `cursos`.`id_curso`,
                            `cursos`.`nombre`,
                            `cursos`.`descripcion`
                        FROM `royal_academy`.`cursos`
                       ";

                if(!is_null($id)) {
                    $sql = $sql . " WHERE `id_curso` = :id;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = Curso::buildFromArray($data);
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

    public static function delete($conexion, $id_curso = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_curso)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`cursos` WHERE `id_curso` = :id_curso;";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_curso',$id_curso,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function insert($conexion, Curso $curso) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `royal_academy`.`cursos`
                            (`nombre`, `descripcion`)
                        VALUES
                            (:nombre , :descripcion);
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':nombre',$curso->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':descripcion',$curso->getDescripcion(),PDO::PARAM_STR);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function update($conexion, Curso $curso) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `royal_academy`.`cursos`
                        SET
                        `nombre` = :nombre,
                        `descripcion` = :descripcion
                        WHERE `id_curso` = :id_curso;
                        ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':nombre',$curso->getNombre(),PDO::PARAM_STR);
                $sentencia->bindParam(':descripcion',$curso->getDescripcion(),PDO::PARAM_STR);

                $sentencia->bindParam(':id_curso',$curso->getIdCurso(),PDO::PARAM_INT);
                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insertOrUpdate($conexion, Curso $curso) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($curso->getIdCurso()) or $curso->getIdCurso() == 0)
                    $result = self::insert($conexion,$curso);
                else
                    $result = self::update($conexion,$curso);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }
}