<?php

if ($peticionAjax) {
    require_once "../modelos/asistenteModelo.php";
} else {
    require_once "./modelos/asistenteModelo.php";
}


class asistenteControlador extends asistenteModelo
{

  
    public function agregar_asistente_controlador()
    {
        $nombre = mainModel::limpiar_cadena($_POST['asistente_nombre_reg']);
        $apellido = mainModel::limpiar_cadena($_POST['asistente_apellido_reg']);
        $fecha_nacimiento = mainmodel::limpiar_cadena($_POST['asistente_fecha_nacimiento_reg']);
        $email = mainModel::limpiar_cadena($_POST['asistente_email_reg']);
        $telefono = mainModel::limpiar_cadena($_POST['asistente_telefono_reg']);
        $activo = mainModel::limpiar_cadena($_POST['asistente_activo_reg']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        // Establecer el valor de activo como 1
        $activo = 1; // Por defecto, los nuevos asistentes están activos

        //registro de datos

        $datos_asistente_reg = [

            "Nombre" => $nombre,
            "Apellido" => $apellido,
            "FechaNacimiento" => $fecha_nacimiento,
            "Email" => $email,
            "Celular" => $telefono,
            "Activo" => $activo,
            "id_admin" => $id_admin

        ];

        $agregar_asistente = asistenteModelo::agregar_asistente_modelo($datos_asistente_reg);

        if ($agregar_asistente->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Asistente registrado",
                "Texto" => "Los datos del asistente han sido registrado con exito.",
                "Tipo" => "success"

            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se pudo registrar el asistente.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode($alerta);
        exit();
    } 
 
    public function paginador_asistente_controlador($pagina, $registros, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);


        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $listaAsistentes = asistenteModelo::consultar_asistente_modelo($inicio, $registros, $busqueda);

        return $listaAsistentes;
    } 
  
    public function eliminar_asistente_controlador()
    {
        $eliminar_asistente = asistenteModelo::eliminar_asistente_modelo();

        // Verificar si la desactivación fue exitosa
        if ($eliminar_asistente === true) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Asistente eliminado.",
                "Texto" => "Asistente eliminado con éxito.",
                "Tipo" => "success"
            ];
        } else {
            // Si $eliminar_asistente es null, significa que no se pudo desactivar el asistente
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "No hemos podido eliminar el asistente.",
                "Tipo" => "error"
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($alerta);
        exit();
    } 

    public  function datos_asistente_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return asistenteModelo::datos_asistente_modelo($tipo, $id);
    } 

    public function actualizar_asistente_controlador()
    {
        //recibiendo parametros del formulario
        $nombre = mainModel::limpiar_cadena($_POST['asistente_nombre_up']);
        $apellido = mainModel::limpiar_cadena($_POST['asistente_apellido_up']);
        $fecha_nacimiento = mainmodel::limpiar_cadena($_POST['asistente_fecha_nacimiento_up']);
        $email = mainModel::limpiar_cadena($_POST['asistente_email_up']);
        $telefono = mainModel::limpiar_cadena($_POST['asistente_telefono_up']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        //Preparando datos par enviar al modelo
        $datos_asistente_up = [
            "Nombre" => $nombre,
            "Apellido" => $apellido,
            "FechaNacimiento" => $fecha_nacimiento,
            "Email" => $email,
            "Celular" => $telefono,
            "id_admin" => $id_admin
        ];

        $asistenteActualizado = asistenteModelo::actualizar_asistente_modelo($datos_asistente_up);

        if ($asistenteActualizado != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos actualizados",
                "Texto" => "Los datos del asistente han sido actualizados con exito.",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido actualizar los datos.",
                "Tipo" => "error"
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($alerta);
        exit();
    } 

}
