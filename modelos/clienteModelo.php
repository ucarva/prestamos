<?php

require_once "mainModel.php";

    

  class clienteModelo extends mainModel{

    //Modelo para agregar cliente
    protected static function agregar_cliente_modelo($datos){
        $sql=mainModel::conectar()->prepare
        ("INSERT INTO cliente (cliente_dni,cliente_nombre,cliente_apellido,cliente_telefono,cliente_direccion)
            VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion)");

            $sql->bindParam(":DNI",$datos['DNI']);
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Apellido",$datos['Apellido']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
            $sql->bindParam(":Direccion",$datos['Direccion']);

            $sql->execute();
            return $sql;


        

        
    }//fin modelo

    //Modelo para eliminar el cliente
    protected static function eliminar_cliente_modelo($id){

      $sql=mainModel::conectar()->prepare("DELETE FROM cliente WHERE cliente_id=:ID");

      //sustituyendo marcador :ID por la variable $id
      $sql->bindParam(":ID",$id);

      $sql->execute();
      return $sql;


  }//fin modelo



  }