<?php

require_once "mainModel.php";

class asistenteModelo extends mainModel
{
    protected static function agregar_asistente_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO asistente (nombres,apellidos,fecha_nacimiento,email,celular,activo,id_admin)
            VALUES(:Nombre,:Apellido,:FechaNacimiento,:Email,:Celular,:Activo,:id_admin)");

        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Apellido", $datos['Apellido']);
        $sql->bindParam(":FechaNacimiento", $datos['FechaNacimiento']);
        $sql->bindParam(":Email", $datos['Email']);
        $sql->bindParam(":Celular", $datos['Celular']);
        $sql->bindParam(":Activo", $datos['Activo']);
        $sql->bindParam(":id_admin", $datos['id_admin']);

        $sql->execute();
        return $sql;
    } 

    protected static function consultar_asistente_modelo($inicio, $registros, $busqueda)
    {
        $conexion = mainModel::conectar();

        if (!empty($busqueda)) {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM asistente 
                                            WHERE (nombres LIKE :busqueda 
                                            OR apellidos LIKE :busqueda 
                                            OR celular LIKE :busqueda) 
                                            AND activo = 1 
                                            ORDER BY id_asistente ASC LIMIT :inicio, :registros");
            $busqueda = "%$busqueda%";
            $consulta->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        } else {
            $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM asistente 
                                            WHERE activo = 1 
                                            ORDER BY id_asistente ASC LIMIT :inicio, :registros");
        }

        $consulta->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $consulta->bindParam(':registros', $registros, PDO::PARAM_INT);

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }
  
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
    } 

    // Modelo para eliminar (desactivar) el asistente
    protected static function eliminar_asistente_modelo()
    {
        $id = mainModel::decryption($_POST['asistente_id_del']);
        $id = mainModel::limpiar_cadena($id);

        // Verificar si el asistente existe
        $obtenerAsistente = mainModel::ejecutar_consulta_simple("SELECT id_asistente FROM asistente WHERE id_asistente = :id AND activo = 1", [':id' => $id]);

        if ($obtenerAsistente->rowCount() > 0) {
            // Desactivar el asistente
            $sql = mainModel::conectar()->prepare("UPDATE asistente SET activo = 0 WHERE id_asistente = :ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();

            // Opcional: desactivar las inscripciones asociadas
            $sqlInscripciones = mainModel::conectar()->prepare("UPDATE inscripcion SET activo = 0 WHERE id_asistente = :id_asistente");
            $sqlInscripciones->bindParam(":id_asistente", $id);
            $sqlInscripciones->execute();

            return true; 
        } else {
            return null; 
        }
    } 
  
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
} 
