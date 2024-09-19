<?php

require_once "mainModel.php";

class itemModelo extends mainModel{

    //Modelo para registrar items
        protected static function agregar_item_modelo($datos)
    {
            $sql=mainModel::conectar()->prepare("INSERT INTO item (item_codigo,item_nombre,item_stock,item_estado,item_detalle)
            VALUES(:Codigo,:Nombre,:Stock,:Estado,:Detalle)");

            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Stock",$datos['Stock']);
            $sql->bindParam(":Estado",$datos['Estado']);
            $sql->bindParam(":Detalle",$datos['Detalle']);

            $sql->execute();
            return $sql;
    }//fin modelo
    //Modelo para eliminar el item
    protected static function eliminar_item_modelo($id)
    {

        $sql=mainModel::conectar()->prepare("DELETE FROM item WHERE item_id=:ID");

        //sustituyendo marcador :ID por la variable $id
        $sql->bindParam(":ID",$id);

        $sql->execute();
        return $sql;

    }//fin modelo

    //Modelo para seleccionar los datos de item
    protected static function datos_item_modelo($tipo,$id)
    {
            if($tipo=="Unico"){
                $sql=mainModel::conectar()->prepare("SELECT * FROM item WHERE item_id=:ID ");
    
                $sql->bindParam(":ID",$id);
    
            }elseif($tipo=="Conteo"){
                $sql=mainModel::conectar()->prepare("SELECT item_id FROM item ");   
            }
    
            $sql->execute();
            return $sql;
    }//fin modelo

    //Modelo para actualizar item
    protected static function actualizar_item_modelo($datos)
    {
        $sql=mainModel::conectar()->prepare(("UPDATE item SET
         item_codigo=:Codigo,item_nombre=:Nombre,item_stock=:Stock,item_estado=:Estado,item_detalle=:Detalle
         WHERE item_id=:ID "));

        $sql->bindParam(":Codigo",$datos['Codigo']);
        $sql->bindParam(":Nombre",$datos['Nombre']);
        $sql->bindParam(":Stock",$datos['Stock']);
        $sql->bindParam(":Estado",$datos['Estado']);
        $sql->bindParam(":Detalle",$datos['Detalle']);

        $sql->bindParam(":ID",$datos['ID']);

        $sql->execute();
        return $sql;  



    }//fin modelo

}