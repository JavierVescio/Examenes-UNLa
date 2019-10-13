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
                        FROM `royal_academy`.`sedes`;
                       ";

                if(!is_null($id_sede)) {
                    $sql = $sql . " WHERE `id_sede` = :id_sede;";
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
                        $result = new Sede(
                            $data['id_sede'],
                            $data['nombre'],
                            $data['direccion'],
                            $data['id_pais']);

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