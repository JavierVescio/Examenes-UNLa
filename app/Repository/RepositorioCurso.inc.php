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
}