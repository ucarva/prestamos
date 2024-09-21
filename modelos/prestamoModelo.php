<?php

require_once "mainModel.php";

class prestamoModelo extends mainModel{
    //Modelo para agregar prestamo
protected static function agregar_prestamo_modelo($datos)
{
        $sql=mainModel::conectar()->prepare
        ("INSERT INTO prestamo (prestamo_codigo,prestamo_fecha_inicio,prestamo_hora_inicio,prestamo_fecha_final,prestamo_hora_final,prestamo_cantidad,prestamo_total,prestamo_pagado,
         prestamo_estado,prestamo_observacion,usuario_id,cliente_id)
            VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion)");

            $sql->bindParam(":DNI",$datos['DNI']);
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Apellido",$datos['Apellido']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
            $sql->bindParam(":Direccion",$datos['Direccion']);

            $sql->execute();
            return $sql;       
}//fin modelo
}