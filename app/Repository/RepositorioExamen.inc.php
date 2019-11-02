<?php
require_once WWW_PATH . '/constantes.php';
require_once APP_PATH . '/Entity/Examen.inc.php';


class RepositorioExamen{

    /**
     * @return Examen[]
     */
    public static function findById($conexion, $id_examen = null, $con_preguntas = false)  {
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT `examenes`.`id_examen`,
                            `examenes`.`id_curso`,
                            `examenes`.`fecha_creacion`,
                            `examenes`.`id_usuario_creador`,
                            `examenes`.`cantidad_preguntas`,
                            `examenes`.`nota_aprobacion`
                        FROM `examenes`
                       ";

                if(!is_null($id_examen)) {
                    $sql = $sql . " WHERE `id_examen` = :id_examen ;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_examen', $id_examen, PDO::PARAM_INT);

                }else {
                    $stmt = $conexion->prepare($sql);
                }
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (!empty($result)) {
                    foreach ($result as $data){
                        //$list[] = Examen::buildFromArray($data);
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


    public static function delete($conexion, $id_examen = null) {
        $result = true ;
        if (isset($conexion) && !is_null($id_examen)) {
            try {
                $sql = "DELETE FROM `examenes` WHERE `id_examen` = :id_examen ;";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_examen',$id_examen,PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function insert($conexion, Examen $examen) {

        $result = true ;
        if (isset($conexion)) {
            try {
                $sql = "INSERT INTO `examenes`
                            (`id_curso`, `fecha_creacion`, `id_usuario_creador`, `cantidad_preguntas`, `nota_aprobacion`)
                        VALUES
                            (:id_curso, :fecha_creacion, :id_usuario_creador, :cantidad_preguntas, :nota_aprobacion);
                        ";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_curso',$examen->getIdCurso(),PDO::PARAM_INT);
                $sentencia->bindParam(':fecha_creacion',$examen->getFechaCreacion(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_usuario_creador',$examen->getIdUsuarioCreador(),PDO::PARAM_INT);
                $sentencia->bindParam(':cantidad_preguntas',$examen->getCantidadPreguntas(),PDO::PARAM_INT);
                $sentencia->bindParam(':nota_aprobacion',$examen->getNotaAprobacion(),PDO::PARAM_INT);

                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function update($conexion, Examen $examen) {
        $result = false;
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `examenes`
                        SET
                            `id_curso` = :id_curso,
                            `fecha_creacion` = :fecha_creacion,
                            `id_usuario_creador` = :id_usuario_creador,
                            `cantidad_preguntas` = :cantidad_preguntas,
                            `nota_aprobacion` = :nota_aprobacion
                        WHERE `id_examen` = :id_examen ;

                        ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_curso',$examen->getIdCurso(),PDO::PARAM_INT);
                $sentencia->bindParam(':fecha_creacion',$examen->getFechaCreacion(),PDO::PARAM_STR);
                $sentencia->bindParam(':id_usuario_creador',$examen->getIdUsuarioCreador(),PDO::PARAM_INT);
                $sentencia->bindParam(':cantidad_preguntas',$examen->getCantidadPreguntas(),PDO::PARAM_INT);
                $sentencia->bindParam(':nota_aprobacion',$examen->getNotaAprobacion(),PDO::PARAM_INT);

                $sentencia->bindParam(':id_examen',$examen->getIdExamen(),PDO::PARAM_INT);
                $sentencia->execute();

                $result = true ;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function insertOrUpdate($conexion, Examen $examen) {
        $result = false;
        if (isset($conexion)) {
            try {
                if(is_null($examen->getIdExamen()) or $examen->getIdExamen() == 0)
                    $result = self::insert($conexion,$examen);
                else
                    $result = self::update($conexion,$examen);

            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
                $result = false;
            }
        }
        return $result;
    }

    public static function getPreguntasByExamen($conexion, $id_examen){
        $list = array();
        if (isset($conexion)) {
            try {
                $sql = "SELECT ep.`id_examenes_preguntas`,
                           ep.`id_examen`,
                           p.id_pregunta,
                           p.descripcion,
                           p.id_curso,
                           p.cant_opciones_validas
                    FROM `examenes_preguntas` ep
                    LEFT JOIN `preguntas` p on ep.id_pregunta = p.id_pregunta
				
                    WHERE `id_examen` = :id_examen;
                ";

                if(!is_null($id_examen)) {
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':id_examen', $id_examen, PDO::PARAM_INT);
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
