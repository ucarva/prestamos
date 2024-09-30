<?php

require_once "mainModel.php";

class eventoModelo extends mainModel
{
    // Modelo para registrar eventos
    protected static function agregar_evento_modelo($datos)
    {
        // Validar la categoría
        if (!self::validar_categoria($datos['Categoria'])) {
            return ["Alerta" => "simple", "Titulo" => "Error", "Texto" => "La categoría seleccionada no existe.", "Tipo" => "error"];
        }

        // Validar el tipo de entrada
        if (!self::validar_tipo_entrada($datos['Entrada'])) {
            return ["Alerta" => "simple", "Titulo" => "Error", "Texto" => "El tipo de entrada seleccionado no existe.", "Tipo" => "error"];
        }

        // Preparar la consulta para insertar el evento
        $sql = mainModel::conectar()->prepare("INSERT INTO evento 
            (titulo, descripcion, hora, valor_base, id_categoria, lugar, cupo, estado, tipo, id_tipo_entrada, id_admin)
            VALUES (:Titulo, :Descripcion, :Hora, :Valor, :Categoria, :Lugar, :Cupo, :Estado, :Tipo, :Entrada, :id_admin)");

        // Asignar valores a los parámetros
        $sql->bindParam(":Titulo", $datos['Titulo']);
        $sql->bindParam(":Descripcion", $datos['Descripcion']);
        $sql->bindParam(":Hora", $datos['Hora']);
        $sql->bindParam(":Valor", $datos['Valor']);
        $sql->bindParam(":Categoria", $datos['Categoria']);
        $sql->bindParam(":Lugar", $datos['Lugar']);
        $sql->bindParam(":Cupo", $datos['Cupo']);
        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":Tipo", $datos['Tipo']);
        $sql->bindParam(":Entrada", $datos['Entrada']);
        $sql->bindParam(":id_admin", $datos['id_admin']);

        // Ejecutar la consulta
        if ($sql->execute()) {
            return ["Alerta" => "recargar", "Titulo" => "Éxito", "Texto" => "El evento ha sido registrado correctamente.", "Tipo" => "success"];
        } else {
            return ["Alerta" => "simple", "Titulo" => "Error", "Texto" => "No se pudo registrar el evento. Error: " . $sql->errorInfo()[2], "Tipo" => "error"];
        }
    }

    // Método para validar la existencia de la categoría
    protected static function validar_categoria($id_categoria)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM categoria WHERE id_categoria = :id_categoria");
        $sql->bindParam(":id_categoria", $id_categoria);
        $sql->execute();
        return $sql->rowCount() > 0; // Retorna true si existe
    }

    // Método para validar la existencia del tipo de entrada
    protected static function validar_tipo_entrada($id_tipo_entrada)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM tipo_entrada WHERE id_tipo_entrada = :id_tipo_entrada");
        $sql->bindParam(":id_tipo_entrada", $id_tipo_entrada);
        $sql->execute();
        return $sql->rowCount() > 0; // Retorna true si existe
    }

    //Modelo para seleccionar los datos de evento
    protected static function datos_evento_modelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT * FROM evento WHERE id_evento=:ID ");

            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Conteo") {
            $sql = mainModel::conectar()->prepare("SELECT id_evento FROM evento ");
        }

        $sql->execute();
        return $sql;
    } //fin modelo

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
                   evento.tipo,
                   tipo_entrada.id_tipo_entrada,
                   tipo_entrada.descripcion AS tipo_entrada_descripcion";
    
        // Consulta base con INNER JOIN
        $consulta = "SELECT SQL_CALC_FOUND_ROWS $campos 
                     FROM evento 
                     INNER JOIN categoria ON evento.id_categoria = categoria.id_categoria 
                     INNER JOIN tipo_entrada ON evento.id_tipo_entrada = tipo_entrada.id_tipo_entrada ";
    
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
                           OR evento.tipo LIKE :busqueda 
                           OR tipo_entrada.descripcion LIKE :busqueda ";
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


    //Modelo para eliminar el evento
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
    } //fin modelo


    //Modelo para actualizar evento
    protected static function actualizar_evento_modelo($datos)
    {
        $id = mainModel::decryption($_POST['evento_id_up']);
        $id = mainModel::limpiar_cadena($id);

        $datos["ID"] = $id;

        $obtenerEvento = mainModel::ejecutar_consulta_simple("SELECT * FROM evento WHERE id_evento = '$id' ");
        if ($obtenerEvento->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare(("UPDATE evento SET
         titulo=:Titulo,descripcion=:Descripcion,hora=:Hora,valor_base=:Valor,id_categoria=:Categoria,lugar=:Lugar,cupo=:Cupo,estado=:Estado,tipo=:Tipo,id_tipo_entrada=:Entrada
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
            $sql->bindParam(":Tipo", $datos['Tipo']);
            $sql->bindParam(":Entrada", $datos['Entrada']);

            $sql->bindParam(":ID", $datos['ID']);

            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    }
    


}
