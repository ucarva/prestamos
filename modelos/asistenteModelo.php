<?php

require_once "mainModel.php";

class asistenteModelo extends mainModel
{

    //Modelo para registrar asistentes
    protected static function agregar_asistente_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO asistente (nombres,apellidos,fecha_nacimiento,email,celular,id_admin)
            VALUES(:Nombre,:Apellido,:FechaNacimiento,:Email,:Celular,:id_admin)");

        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Apellido", $datos['Apellido']);
        $sql->bindParam(":FechaNacimiento", $datos['FechaNacimiento']);
        $sql->bindParam(":Email", $datos['Email']);
        $sql->bindParam(":Celular", $datos['Celular']);
        $sql->bindParam(":id_admin", $datos['id_admin']);

        $sql->execute();
        return $sql;
    } //fin modelo

    protected static function consultar_asistente_modelo($inicio, $registros, $busqueda)
    {
        $conexion = mainModel::conectar();

        if (!empty($busqueda)) {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM asistente 
                                            WHERE nombres LIKE :busqueda 
                                            OR apellidos LIKE :busqueda 
                                            OR celular LIKE :busqueda 
                                            ORDER BY id_asistente ASC LIMIT :inicio, :registros");
            $busqueda = "%$busqueda%"; // Ajustamos el valor de búsqueda
            $consulta->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        } else {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM asistente 
                                            ORDER BY id_asistente ASC LIMIT :inicio, :registros");
        }

        $consulta->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $consulta->bindParam(':registros', $registros, PDO::PARAM_INT);

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }


    //Modelo para seleccionar los datos de asistente
    protected static function datos_asistente_modelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT * FROM asistente WHERE id_asistente=:ID ");

            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Conteo") {
            $sql = mainModel::conectar()->prepare("SELECT id_asistente FROM asistente ");
        }

        $sql->execute();
        return $sql;
    } //fin modelo


    //Modelo para eliminar el asistente
    protected static function eliminar_asistente_modelo()
    {
        $id = mainModel::decryption($_POST['asistente_id_del']);
        $id = mainModel::limpiar_cadena($id);

        $obtenerAsistente = mainModel::ejecutar_consulta_simple("SELECT id_asistente FROM asistente WHERE id_asistente='$id'");
        if ($obtenerAsistente->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare("DELETE FROM asistente WHERE id_asistente=:ID");

            //sustituyendo marcador :ID por la variable $id
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    } //fin modelo

    //Modelo para actualizar asistente
    protected static function actualizar_asistente_modelo($datos)
    {
        $id = mainModel::decryption($_POST['asistente_id_up']);
        $id = mainModel::limpiar_cadena($id);

        $datos["ID"] = $id;

        $obtenerAsistente = mainModel::ejecutar_consulta_simple("SELECT * FROM asistente WHERE id_asistente = '$id' ");
        if ($obtenerAsistente->rowCount() > 0) {
            $sql = mainModel::conectar()->prepare(("UPDATE asistente SET
         nombres=:Nombre,apellidos=:Apellido,fecha_nacimiento=:FechaNacimiento,email=:Email,celular=:Celular,id_admin=:id_admin
         WHERE id_asistente=:ID "));


            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":Apellido", $datos['Apellido']);
            $sql->bindParam(":FechaNacimiento", $datos['FechaNacimiento']);
            $sql->bindParam(":Email", $datos['Email']);
            $sql->bindParam(":Celular", $datos['Celular']);
            $sql->bindParam(":id_admin", $datos['id_admin']);

            $sql->bindParam(":ID", $datos['ID']);

            $sql->execute();
            return $sql;
        } else {
            return null;
        }
    }
    

   
} //fin modelo
