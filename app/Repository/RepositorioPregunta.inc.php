<?php


class RepositorioPregunta
{

    /**
     * @return Pregunta[]
     */
    public static function findById($conexion, $id_pregunta = null)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `preguntas`.`id_pregunta`,
                            `preguntas`.`id_curso`,
                            `preguntas`.`descripcion`,
                            `preguntas`.`cant_opciones_validas`
                        FROM `royal_academy`.`preguntas` 
                       ";

                if(!is_null($id_pregunta)) {
                    $sql = $sql . " WHERE `id_pregunta` = :id_pregunta;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = Pregunta::buildFromArray($data);
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
     * @return Pregunta[]
     */
    public static function listAll($conexion){
        return self::findById($conexion);
    }

    public static function delete($conexion, $id_pregunta = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_pregunta)) {
            try {
                $sql = "DELETE FROM `royal_academy`.`preguntas` WHERE `id_pregunta` = :id_pregunta ; ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_pregunta',$id_pregunta,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insert($conexion, Pregunta $pregunta) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `royal_academy`.`preguntas`
                            (`id_curso`, `descripcion`, `cant_opciones_validas`)
                        VALUES
	                        ( :id_curso , :descripcion ,  :cant_opciones_validas );
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_curso',$pregunta->getIdCurso(),PDO::PARAM_INT);
                $sentencia->bindParam(':descripcion',$pregunta->getDescripcion(),PDO::PARAM_STR);
                $sentencia->bindParam(':cant_opciones_validas',$pregunta->getCantOpcionesValidas(),PDO::PARAM_INT);
               

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function update($conexion, Pregunta $pregunta) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `royal_academy`.`preguntas`
                        SET
                        `id_curso` = :id_curso,
                        `descripcion` = :descripcion,
                        `cant_opciones_validas` = :cant_opciones_validas
                        WHERE `id_pregunta` = :id_pregunta ;";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_curso',$pregunta->getIdCurso(),PDO::PARAM_INT);
                $sentencia->bindParam(':descripcion',$pregunta->getDescripcion(),PDO::PARAM_STR);
                $sentencia->bindParam(':cant_opciones_validas',$pregunta->getCantOpcionesValidas(),PDO::PARAM_INT);

                $sentencia->bindParam(':id_pregunta',$pregunta->getIdPregunta(),PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function insertOrUpdate($conexion, Pregunta $pregunta) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($pregunta->getIdPregunta()) or $pregunta->getIdPregunta() == 0)
                    $result = self::insert($conexion,$pregunta);
                else
                    $result = self::update($conexion,$pregunta);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }

        return $result;
    }

    public static function getOpcionesByPregunta($conexion, $id_pregunta){
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT p.id_pregunta,
                               po.id_opcion,
                               po.descripcion,
                               po.es_correcta
                        FROM `preguntas` p
                        LEFT JOIN `preguntas_opciones` po on po.id_pregunta = p.id_pregunta
                        WHERE p.id_pregunta = :id_pregunta;
                ";

                if(!is_null($id_pregunta)) {
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
                }else {
                    throw new Exception("Debe definicar id_examen para recuperar las preguntas");

                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        $result = Pregunta::buildFromArray($data);
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


}