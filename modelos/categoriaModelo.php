<?php

require_once "mainModel.php";

class categoriaModelo extends mainModel
{


    protected static function agregar_categoria_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO categoria (descripcion,id_admin)
            VALUES(:Descripcion,:id_admin)");

        $sql->bindParam(":Descripcion", $datos['Descripcion']);
        $sql->bindParam(":id_admin", $datos['id_admin']);

        $sql->execute();
        return $sql;
    } 
  
    protected static function consultar_categoria_modelo($inicio, $registros, $busqueda)
    {
        $conexion = mainModel::conectar();

        if (!empty($busqueda)) {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM categoria 
                                            WHERE descripcion LIKE :busqueda 
                                            
                                            ORDER BY id_categoria ASC LIMIT :inicio, :registros");
            $busqueda = "%$busqueda%"; 
            $consulta->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        } else {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM categoria 
                                            ORDER BY id_categoria ASC LIMIT :inicio, :registros");
        }

        $consulta->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $consulta->bindParam(':registros', $registros, PDO::PARAM_INT);

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    } 

    protected static function eliminar_categoria_modelo()
    {
        $id = mainModel::decryption($_POST['categoria_id_del']);
        $id = mainModel::limpiar_cadena($id);

        $obtenerCategoria = mainModel::ejecutar_consulta_simple("SELECT id_categoria FROM categoria WHERE id_categoria='$id'");
        if ($obtenerCategoria->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare("DELETE FROM categoria WHERE id_categoria=:ID");

            //sustituyendo marcador :ID por la variable $id
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    } 

    protected static function actualizar_categoria_modelo($datos)
    {
        $id = mainModel::decryption($_POST['categoria_id_up']);
        $id = mainModel::limpiar_cadena($id);

        $obtenerCategoria = mainModel::ejecutar_consulta_simple("SELECT id_categoria FROM categoria WHERE id_categoria='$id'");

        if ($obtenerCategoria->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare(("UPDATE categoria SET
            descripcion=:Descripcion,id_admin=:id_admin
            WHERE id_categoria=:ID"));

            $sql->bindParam(":Descripcion", $datos['Descripcion']);
            $sql->bindParam(":id_admin", $datos['id_admin']);
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
            
        } else {
            return null;
        }
    }

    protected static function datos_categoria_modelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT * FROM categoria WHERE id_categoria=:ID ");

            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Conteo") {
            $sql = mainModel::conectar()->prepare("SELECT id_categoria FROM categoria ");
        }

        $sql->execute();
        return $sql;
    } 
   
}
