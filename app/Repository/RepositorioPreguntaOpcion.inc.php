<?php


class RepositorioPreguntaOpcion
{

    /**
     * @return PreguntaOpcion
     */
    public static function findById($conexion, $id_opcion = null)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `preguntas_opciones`.`id_opcion`,
                            `preguntas_opciones`.`id_pregunta`,
                            `preguntas_opciones`.`descripcion`,
                            `preguntas_opciones`.`es_correcta`
                        FROM `royal_academy`.`preguntas_opciones`
                       ";

                if(!is_null($id_opcion)) {
                    $sql = $sql . " WHERE `id_opcion` = :id_opcion;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_opcion', $id_opcion, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = PreguntaOpcion::buildFromArray($data);
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
     * @return PreguntaOpcion[]
     */
    public static function listAll($conexion){
        return self::findById($conexion);
    }

    public static function delete($conexion, $id_opcion = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_opcion)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`preguntas_opciones`  WHERE `id_opcion` = :id_opcion;";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_opcion',$id_opcion,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insert($conexion, PreguntaOpcion $preguntaOpcion) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `royal_academy`.`preguntas_opciones`
                            (`id_pregunta`, `descripcion`, `es_correcta`)
                        VALUES
                            ( :id_pregunta, :descripcion, :es_correcta );
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_pregunta',$preguntaOpcion->getIdPregunta(),PDO::PARAM_INT);
                $sentencia->bindParam(':descripcion',$preguntaOpcion->getDescripcion(),PDO::PARAM_STR);
                $sentencia->bindParam(':es_correcta',$preguntaOpcion->getEsCorrecta(),PDO::PARAM_INT);


                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function update($conexion, PreguntaOpcion $preguntaOpcion) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `royal_academy`.`preguntas_opciones`
                        SET
                        `id_pregunta` = :id_pregunta,
                        `descripcion` = :descripcion,
                        `es_correcta` = :es_correcta
                        WHERE `id_opcion` = :id_opcion;
                        ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_pregunta',$preguntaOpcion->getIdPregunta(),PDO::PARAM_INT);
                $sentencia->bindParam(':descripcion',$preguntaOpcion->getDescripcion(),PDO::PARAM_STR);
                $sentencia->bindParam(':es_correcta',$preguntaOpcion->getEsCorrecta(),PDO::PARAM_INT);

                $sentencia->bindParam(':id_opcion',$preguntaOpcion->getIdOpcion(),PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insertOrUpdate($conexion, PreguntaOpcion $preguntaOpcion) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($preguntaOpcion->getIdOpcion()) or $preguntaOpcion->getIdOpcion() == 0)
                    $result = self::insert($conexion,$preguntaOpcion);
                else
                    $result = self::update($conexion,$preguntaOpcion);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }


}