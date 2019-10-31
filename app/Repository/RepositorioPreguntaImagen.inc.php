<?php


class RepositorioPreguntaImagen
{


    /**
     * @return PreguntaImagen[]
     */
    public static function findById($conexion, $id_imagen = null)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `preguntas_imagenes`.`id_pregunta_imagen`,
                            `preguntas_imagenes`.`path`,
                            `preguntas_imagenes`.`descripcion`,
                            `preguntas_imagenes`.`id_pregunta`
                        FROM `royal_academy`.`preguntas_imagenes`
                       ";

                if(!is_null($id_imagen)) {
                    $sql = $sql . " WHERE `id_pregunta_imagen` = :id_pregunta_imagen;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_pregunta_imagen', $id_imagen, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = PreguntaImagen::buildFromArray($data);
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
     * @return PreguntaImagen[]
     */
    public static function listAll($conexion){
        return self::findById($conexion);
    }

    public static function delete($conexion, $id_imagen = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_imagen)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`preguntas_imagenes` WHERE `id_pregunta_imagen` = :id_pregunta_imagen ;";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_pregunta_imagen',$id_imagen,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insert($conexion, PreguntaImagen $preguntaImagen) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `royal_academy`.`preguntas_imagenes`
                            (`path`, `descripcion`, `id_pregunta`)
                        VALUES
                            (:path, :descripcion, :id_pregunta );
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':path',$preguntaImagen->getPath(),PDO::PARAM_STR);
                $sentencia->bindParam(':descripcion',$preguntaImagen->getDescripcion(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_pregunta',$preguntaImagen->getIdPregunta(),PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function update($conexion, PreguntaImagen $preguntaImagen) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `royal_academy`.`preguntas_imagenes`
                        SET
                        `path` = :path,
                        `descripcion` = :descripcion,
                        `id_pregunta` = :id_pregunta
                        WHERE `id_pregunta_imagen` = :id_pregunta_imagen ;
                        ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':path',$preguntaImagen->getPath(),PDO::PARAM_STR);
                $sentencia->bindParam(':descripcion',$preguntaImagen->getDescripcion(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_pregunta',$preguntaImagen->getIdPregunta(),PDO::PARAM_INT);

                $sentencia->bindParam(':id_pregunta_imagen',$preguntaImagen->getIdPreguntaImagen(),PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insertOrUpdate($conexion, PreguntaImagen $preguntaImagen) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($preguntaImagen->getIdPreguntaImagen()) or $preguntaImagen->getIdPreguntaImagen() == 0)
                    $result = self::insert($conexion,$preguntaImagen);
                else
                    $result = self::update($conexion,$preguntaImagen);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @return PreguntaImagen[]
     */
    public static function findByPregunta($conexion, $id_pregunta )  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `preguntas_imagenes`.`id_pregunta_imagen`,
                            `preguntas_imagenes`.`path`,
                            `preguntas_imagenes`.`descripcion`,
                            `preguntas_imagenes`.`id_pregunta`
                        FROM `royal_academy`.`preguntas_imagenes`
                       ";

                if(!is_null($id_pregunta)) {
                    $sql = $sql . " WHERE `id_pregunta` = :id_pregunta;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);

                }else {
                    throw new Exception("No se define id_pregunta para recuperar imagenes asociadas");

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = PreguntaImagen::buildFromArray($data);
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

    public static function deleteByPregunta($conexion, $id_pregunta) {
        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`preguntas_imagenes` WHERE `id_pregunta` = :id_pregunta ;";

                if(!is_null($id_pregunta)) {
                    $sentencia = $conexion->prepare($sql);
                    $sentencia->bindParam(':id_pregunta',$id_pregunta,PDO::PARAM_INT);

                }else {
                    throw new Exception("No se define id_pregunta para eliminar imagenes asociadas");
                }
                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

}