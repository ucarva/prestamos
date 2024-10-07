<?php

require_once "mainModel.php";

class inscripcionModelo extends mainModel
{

    protected static function consultar_cupon_modelo($cupon)
    {
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
