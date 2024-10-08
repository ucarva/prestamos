<?php

require_once "mainModel.php";

class eventoModelo extends mainModel
{
    
    protected static function agregar_evento_modelo($datos)
    {
        // Validar la categoría
        if (!self::validar_categoria($datos['Categoria'])) {
            return ["Alerta" => "simple", "Titulo" => "Error", "Texto" => "La categoría seleccionada no existe.", "Tipo" => "error"];
        }

        // Preparar la consulta para insertar el evento
        $sql = mainModel::conectar()->prepare("INSERT INTO evento 
            (titulo, descripcion, hora, valor_base, id_categoria, lugar, cupo, estado, fecha_apertura, fecha_cierre, es_entrada_gratis, id_admin)
           VALUES (:Titulo, :Descripcion, :Hora, :Valor, :Categoria, :Lugar, :Cupo, :Estado, :FechaInicio, :FechaCierre, :esGratis, :id_admin)");

        // Asignar valores a los parámetros
        $sql->bindParam(":Titulo", $datos['Titulo']);
        $sql->bindParam(":Descripcion", $datos['Descripcion']);
        $sql->bindParam(":Hora", $datos['Hora']);
        $sql->bindParam(":Valor", $datos['Valor']);
        $sql->bindParam(":Categoria", $datos['Categoria']);
        $sql->bindParam(":Lugar", $datos['Lugar']);
        $sql->bindParam(":Cupo", $datos['Cupo']);
        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":FechaInicio", $datos['FechaInicio']);
        $sql->bindParam(":FechaCierre", $datos['FechaCierre']);
        $sql->bindParam(":esGratis", $datos['esGratis']);
        $sql->bindParam(":id_admin", $datos['id_admin']);

        // Ejecutar la consulta
        if ($sql->execute()) {
            return ["Alerta" => "recargar", "Titulo" => "Éxito", "Texto" => "El evento ha sido registrado correctamente.", "Tipo" => "success"];
        } else {
            return ["Alerta" => "simple", "Titulo" => "Error", "Texto" => "No se pudo registrar el evento. Error: " . $sql->errorInfo()[2], "Tipo" => "error"];
        }
    }

    protected static function validar_categoria($id_categoria)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM categoria WHERE id_categoria = :id_categoria");
        $sql->bindParam(":id_categoria", $id_categoria);
        $sql->execute();
        return $sql->rowCount() > 0; // Retorna true si existe
    }

    protected static function datos_evento_modelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT * FROM evento WHERE id_evento=:ID  ");

            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Conteo") {
            $sql = mainModel::conectar()->prepare("SELECT id_evento, titulo FROM evento WHERE estado ='Habilitado'");
        }

        $sql->execute();
        return $sql;
    } 

    protected static function consultar_evento_modelo($inicio, $registros, $busqueda)
    {
        $campos = "evento.id_evento,
           evento.titulo,
           evento.descripcion,
           evento.hora,
           evento.valor_base,
           categoria.id_categoria,
           categoria.descripcion AS categoria_descripcion,
           evento.lugar,
           evento.cupo,
           evento.estado,
           evento.fecha_apertura,
           evento.fecha_cierre,
           CASE WHEN evento.es_entrada_gratis = 1 THEN 'Gratis' ELSE 'Pago' END AS es_entrada_gratis  
           ";  


        // Consulta base con INNER JOIN
        $consulta = "SELECT SQL_CALC_FOUND_ROWS $campos 
                     FROM evento 
                     INNER JOIN categoria ON evento.id_categoria = categoria.id_categoria 
                      ";

        // Condición de búsqueda
        if (!empty($busqueda)) {
            $consulta .= " WHERE evento.titulo LIKE :busqueda 
                           OR evento.descripcion LIKE :busqueda 
                           OR evento.hora LIKE :busqueda 
                           OR evento.valor_base LIKE :busqueda 
                           OR categoria.descripcion LIKE :busqueda 
                           OR evento.lugar LIKE :busqueda 
                           OR evento.cupo LIKE :busqueda 
                           OR evento.estado LIKE :busqueda
                           OR evento.fecha_apertura LIKE :busqueda
                           OR evento.fecha_cierre LIKE :busqueda                          
                           OR evento.es_entrada_gratis LIKE :busqueda
                           ";
        }

        $consulta .= " ORDER BY evento.id_evento ASC LIMIT :inicio, :registros";

        $conexion = mainModel::conectar();
        $consulta = $conexion->prepare($consulta);

        // Ajustamos el valor de búsqueda
        if (!empty($busqueda)) {
            $busqueda = "%$busqueda%";
            $consulta->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        }

        $consulta->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $consulta->bindParam(':registros', $registros, PDO::PARAM_INT);

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }
 
    protected static function eliminar_evento_modelo()
    {
        $id = mainModel::decryption($_POST['evento_id_del']);
        $id = mainModel::limpiar_cadena($id);

        $obtenerAsistente = mainModel::ejecutar_consulta_simple("SELECT id_evento FROM evento WHERE id_evento='$id'");
        if ($obtenerAsistente->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare("DELETE FROM evento WHERE id_evento=:ID");

            //sustituyendo marcador :ID por la variable $id
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    } 

    protected static function actualizar_evento_modelo($datos)
    {
        $id = mainModel::decryption($_POST['evento_id_up']);
        $id = mainModel::limpiar_cadena($id);

        $datos["ID"] = $id;

        $obtenerEvento = mainModel::ejecutar_consulta_simple("SELECT * FROM evento WHERE id_evento = '$id' ");
        if ($obtenerEvento->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare(("UPDATE evento SET
         titulo=:Titulo,descripcion=:Descripcion,hora=:Hora,valor_base=:Valor,id_categoria=:Categoria,lugar=:Lugar,cupo=:Cupo,estado=:Estado,fecha_apertura=:FechaInicio,fecha_cierre=:FechaFin, es_entrada_gratis=:esGratis
         WHERE id_evento=:ID "));

            // Asignar valores a los parámetros
            $sql->bindParam(":Titulo", $datos['Titulo']);
            $sql->bindParam(":Descripcion", $datos['Descripcion']);
            $sql->bindParam(":Hora", $datos['Hora']);
            $sql->bindParam(":Valor", $datos['Valor']);
            $sql->bindParam(":Categoria", $datos['Categoria']);
            $sql->bindParam(":Lugar", $datos['Lugar']);
            $sql->bindParam(":Cupo", $datos['Cupo']);
            $sql->bindParam(":Estado", $datos['Estado']);
            $sql->bindParam(":FechaInicio", $datos['FechaInicio']);
            $sql->bindParam(":FechaFin", $datos['FechaFin']);
            $sql->bindParam(":esGratis", $datos['esGratis']);
            $sql->bindParam(":ID", $datos['ID']);

            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    }


   
}
