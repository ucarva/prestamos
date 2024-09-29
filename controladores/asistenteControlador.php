<?php

if ($peticionAjax) {
    require_once "../modelos/asistenteModelo.php";
} else {
    require_once "./modelos/asistenteModelo.php";
}


class asistenteControlador extends asistenteModelo
{

    //Controlador para agregar asistente
    public function agregar_asistente_controlador()
    {
        $nombre = mainModel::limpiar_cadena($_POST['asistente_nombre_reg']);
        $apellido = mainModel::limpiar_cadena($_POST['asistente_apellido_reg']);
        $fecha_nacimiento = mainmodel::limpiar_cadena($_POST['asistente_fecha_nacimiento_reg']);
        $email = mainModel::limpiar_cadena($_POST['asistente_email_reg']);
        $telefono = mainModel::limpiar_cadena($_POST['asistente_telefono_reg']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);



        //registro de datos

        $datos_asistente_reg = [

            "Nombre" => $nombre,
            "Apellido" => $apellido,
            "FechaNacimiento" => $fecha_nacimiento,
            "Email" => $email,
            "Celular" => $telefono,
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
    } //fin controlador

    // Controlador para paginar asistente
    public function paginador_asistente_controlador($pagina, $registros,$busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);
       
        
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $listaAsistentes = asistenteModelo::consultar_asistente_modelo($inicio, $registros, $busqueda);

        return $listaAsistentes;
    } //fin controlador

    // Controlador para eliminar asistente
    public function eliminar_asistente_controlador()
    {
        $eliminar_asistente = asistenteModelo::eliminar_asistente_modelo();
        if ($eliminar_asistente != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "asistente eliminado.",
                "Texto" => "asistente eliminado con exito.",
                "Tipo" => "success"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "No hemos podido eliminar el usuario.",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    } //fin controlador

    //controlador para los datos de asistente
    public  function datos_asistente_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return asistenteModelo::datos_asistente_modelo($tipo, $id);
    } // fin controlador

    //controlador para actualizar asistente
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
    } //fin controlador

}
