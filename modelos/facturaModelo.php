<?php

require_once "mainModel.php";

class facturaModelo extends mainModel
{

    protected static function agregar_factura_modelo($datos) {
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
                return true;  // Retornar verdadero si la inserción fue exitosa
            } else {
                return false;  // Retornar falso si falló
            }
        } catch (PDOException $e) {
            // Capturar el error de PDO
            error_log("Error en la inserción de inscripción: " . $e->getMessage());
            return false;  // Retornar falso si hubo una excepción
        }
    }
    
    protected static function consultar_cupon_modelo($cupon) {
        // Obtener la fecha actual
        $fechaActual = date('Y-m-d H:i:s'); // Ajusta el formato según tu base de datos
    
        // Consultar en la base de datos
        $obtenerCupon = mainModel::ejecutar_consulta_simple("SELECT porcentaje_descuento FROM codigo_promocional WHERE codigo='$cupon' AND estado='Activo' AND fecha_vigencia_fin > '$fechaActual'");
    
        if ($obtenerCupon->rowCount() > 0) {
            // Obtiene el porcentaje de descuento de la primera fila del resultado
            return $obtenerCupon->fetchColumn(); // Retorna el valor de la columna porcentaje_descuento
        } else {
            return null; // Devuelve null si no se encontró el cupón
        }
    }
    

}
