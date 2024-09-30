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
}

