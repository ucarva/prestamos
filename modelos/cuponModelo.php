<?php

require_once "mainModel.php";

class cuponModelo extends mainModel
{
    
    protected static function agregar_cupon_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO codigo_promocional (codigo,porcentaje_descuento,estado,fecha_vigencia_inicio,fecha_vigencia_fin,id_admin)
           VALUES(:Codigo,:Porcentaje,:Estado,:Inicio,:Fin,:id_admin)");

        $sql->bindParam(":Codigo", $datos['Codigo']);
        $sql->bindParam(":Porcentaje", $datos['Porcentaje']);
        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":Inicio", $datos['Inicio']);
        $sql->bindParam(":Fin", $datos['Fin']);
        $sql->bindParam(":id_admin", $datos['id_admin']);

        $sql->execute();
        return $sql;
    } 

    
    protected static function datos_cupon_modelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT * FROM codigo_promocional WHERE id_codigo=:ID ");

            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Conteo") {
            $sql = mainModel::conectar()->prepare("SELECT id_codigo FROM codigo_promocional ");
        }

        $sql->execute();
        return $sql;
    }

    
    protected static function consultar_cupon_modelo($inicio, $registros, $busqueda)
    {
        $conexion = mainModel::conectar();

        if (!empty($busqueda)) {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM codigo_promocional
                                        WHERE codigo LIKE :busqueda OR porcentaje_descuento LIKE :busqueda 
                                        OR estado LIKE :busqueda OR fecha_vigencia_inicio LIKE :busqueda 
                                        OR fecha_vigencia_fin LIKE :busqueda 
                                        ORDER BY id_codigo ASC LIMIT $inicio, $registros");
            $busqueda = "%$busqueda%"; // Ajustamos el valor de búsqueda
            $consulta->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        } else {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM codigo_promocional 
                                        ORDER BY id_codigo ASC LIMIT $inicio, $registros");
        }

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }


    
    protected static function actualizar_cupon_modelo($datos)
    {
        // Limpiar y obtener el ID del cupón
        $id = mainModel::decryption($_POST['cupon_id_up']);
        $id = mainModel::limpiar_cadena($id);
        $datos["ID"] = $id;

        // Verificar si el cupón existe
        $obtenerCupon = mainModel::ejecutar_consulta_simple("SELECT * FROM codigo_promocional WHERE id_codigo = '$id'");
        if ($obtenerCupon->rowCount() > 0) {
            // Preparar la consulta de actualización
            $sql = mainModel::conectar()->prepare("UPDATE codigo_promocional SET
            codigo = :Codigo,
            porcentaje_descuento = :Descuento,
            estado = :Estado,
            fecha_vigencia_inicio = :Inicio,
            fecha_vigencia_fin = :Fin,
            id_admin = :id_admin
            WHERE id_codigo = :ID");

            // Asignar valores a los parámetros
            $sql->bindParam(":Codigo", $datos['Codigo']);
            $sql->bindParam(":Descuento", $datos['Descuento']);
            $sql->bindParam(":Estado", $datos['Estado']);
            $sql->bindParam(":Inicio", $datos['Inicio']);
            $sql->bindParam(":Fin", $datos['Fin']);
            $sql->bindParam(":id_admin", $datos['id_admin']);
            $sql->bindParam(":ID", $datos['ID']);


            $sql->execute();
            return $sql;
        } else {

            return null;
        }
    }

   
    protected static function eliminar_cupon_modelo()
    {
        // Limpiar y obtener el ID del cupón
        $id = mainModel::decryption($_POST['cupon_id_del']);
        $id = mainModel::limpiar_cadena($id);

        // Verificar si el cupón existe
        $obtenerCupon = mainModel::ejecutar_consulta_simple("SELECT id_codigo FROM codigo_promocional WHERE id_codigo='$id'");
        if ($obtenerCupon->rowCount() > 0) {
            // Preparar la consulta de eliminación
            $sql = mainModel::conectar()->prepare("DELETE FROM codigo_promocional WHERE id_codigo=:ID");

            // Sustituyendo marcador :ID por la variable $id
            $sql->bindParam(":ID", $id);
            $sql->execute();

            // Retornar el resultado de la consulta
            return $sql->rowCount() > 0; // Retorna true si se eliminó al menos un registro
        } else {
            return null; // El cupón no fue encontrado
        }
    }

}
