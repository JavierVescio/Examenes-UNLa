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

                if(!is_null($id_sede)) {
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
}