<?php

require_once "mainModel.php";

class facturaModelo extends mainModel
{

    protected static function agregar_factura_modelo($datos)
    {
        try {
            $sql = mainModel::conectar()->prepare("
                INSERT INTO inscripcion 
                (id_evento, id_asistente, id_tipo_entrada, valor_pago, estado_pago, id_admin) 
                VALUES (:Evento, :Asistente, :Entrada, :Valor, :Estado, :id_admin)
            ");

            // Asignación de parámetros
            $sql->bindParam(":Evento", $datos['Evento']);
            $sql->bindParam(":Asistente", $datos['Asistente']);
            $sql->bindParam(":Entrada", $datos['Entrada']);
            $sql->bindParam(":Valor", $datos['Valor'], PDO::PARAM_INT); // Asegura que se almacene como número entero
            $sql->bindParam(":Estado", $datos['Estado']);
            $sql->bindParam(":id_admin", $datos['id_admin']);

            // Ejecutar la consulta
            if ($sql->execute()) {
                return true;  
            } else {
                return false;  
            }
        } catch (PDOException $e) {
            // Capturar el error de PDO
            error_log("Error en la inserción de inscripción: " . $e->getMessage());
            return false;  
        }
    }

    protected static function consultar_cupon_modelo($cupon)
    {
        
        $fechaActual = date('Y-m-d H:i:s'); 
    
        // Consultar en la base de datos
        $obtenerCupon = mainModel::ejecutar_consulta_simple("SELECT porcentaje_descuento FROM codigo_promocional WHERE codigo='$cupon' AND estado='Activo' AND fecha_vigencia_fin > '$fechaActual'");
    
        if ($obtenerCupon->rowCount() > 0) {
            // Retorna un array asociativo con el valor de porcentaje_descuento
            return $obtenerCupon->fetch(PDO::FETCH_ASSOC); // Devuelve el resultado completo como array asociativo
        } else {
            return null; // Devuelve null si no se encontró el cupón
        }
    }

    protected static function consultar_valorEntrada_modelo($entrada)
    {
        // Consultar en la base de datos por el id_tipo_entrada
        $valorEntrada = mainModel::ejecutar_consulta_simple("SELECT cantidad FROM tipo_entrada WHERE id_tipo_entrada='$entrada'");
    
        if ($valorEntrada->rowCount() > 0) {
            // Retorna un array asociativo con el valor de la cantidad
            return $valorEntrada->fetch(PDO::FETCH_ASSOC);
        } else {
            return null; // Devuelve null si no se encontró la entrada
        }
    }
    
    

    
}
