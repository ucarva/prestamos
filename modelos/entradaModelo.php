<?php

require_once "mainModel.php";

class entradaModelo extends mainModel
{

    
    protected static function agregar_entrada_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO tipo_entrada(descripcion,cantidad,id_admin)
            VALUES(:Descripcion,:Cantidad,:id_admin)");

        $sql->bindParam(":Descripcion", $datos['Descripcion']);
        $sql->bindParam(":Cantidad", $datos['Cantidad']);
        $sql->bindParam(":id_admin", $datos['id_admin']);

        $sql->execute();
        return $sql;
    } 
 
    protected static function consultar_entrada_modelo($inicio, $registros, $busqueda)
    {
        $conexion = mainModel::conectar();

        if (!empty($busqueda)) {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM tipo_entrada
                                            WHERE descripcion LIKE :busqueda OR cantidad LIKE :busqueda 
                                            
                                            ORDER BY id_tipo_entrada ASC LIMIT :inicio, :registros");
            $busqueda = "%$busqueda%"; // Ajustamos el valor de búsqueda
            $consulta->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        } else {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM tipo_entrada 
                                            ORDER BY id_tipo_entrada ASC LIMIT :inicio, :registros");
        }

        $consulta->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $consulta->bindParam(':registros', $registros, PDO::PARAM_INT);

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    } 
  
    protected static function eliminar_entrada_modelo()
    {
        $id = mainModel::decryption($_POST['entrada_id_del']);
        $id = mainModel::limpiar_cadena($id);

        $obtenerentrada = mainModel::ejecutar_consulta_simple("SELECT id_tipo_entrada FROM tipo_entrada WHERE id_tipo_entrada='$id'");
        if ($obtenerentrada->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare("DELETE FROM tipo_entrada WHERE id_tipo_entrada=:ID");

            //sustituyendo marcador :ID por la variable $id
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    } 
  
    protected static function actualizar_entrada_modelo($datos)
    {
        $id = mainModel::decryption($_POST['entrada_id_up']);
        $id = mainModel::limpiar_cadena($id);

        $obtenerentrada = mainModel::ejecutar_consulta_simple("SELECT id_tipo_entrada FROM tipo_entrada WHERE id_tipo_entrada='$id'");

        if ($obtenerentrada->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare(("UPDATE tipo_entrada SET
            descripcion=:Descripcion,id_admin=:id_admin
            WHERE id_tipo_entrada=:ID"));

            $sql->bindParam(":Descripcion", $datos['Descripcion']);
            $sql->bindParam(":id_admin", $datos['id_admin']);
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    }

    protected static function datos_entrada_modelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT * FROM tipo_entrada WHERE id_tipo_entrada=:ID ");

            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Conteo") {
            $sql = mainModel::conectar()->prepare("SELECT id_tipo_entrada FROM tipo_entrada ");
        }

        $sql->execute();
        return $sql;
    } 
}
