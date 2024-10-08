<?php

if ($peticionAjax) {
    require_once "../modelos/entradaModelo.php";
} else {
    require_once "./modelos/entradaModelo.php";
}


class entradaControlador extends entradaModelo
{
    
    public function agregar_entrada_controlador()
    {
        $descripcion = mainModel::limpiar_cadena($_POST['entrada_nombre_reg']);
        $cantidad = mainModel::limpiar_cadena($_POST['entrada_porcentaje_reg']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        //registro de datos

        $datos_entrada_reg = [
            "Descripcion" => $descripcion,
            "Cantidad" => $cantidad,
            "id_admin" => $id_admin
        ];

        $agregar_entrada = entradaModelo::agregar_entrada_modelo($datos_entrada_reg);

        if ($agregar_entrada->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "entrada registrado",
                "Texto" => "Los datos de la entrada han sido registrado con exito.",
                "Tipo" => "success"

            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se pudo registrar la entrada.",
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

    
    public function paginador_entrada_controlador($pagina, $registros, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);


        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $listaentradas = entradaModelo::consultar_entrada_modelo($inicio, $registros, $busqueda);

        return $listaentradas;
    } 

   
    public function eliminar_entrada_controlador()
    {
        $eliminar_entrada = entradaModelo::eliminar_entrada_modelo();
        if ($eliminar_entrada != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "entrada eliminada.",
                "Texto" => "entrada eliminada con exito.",
                "Tipo" => "success"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "No hemos podido eliminar la entrada.",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    } 

   
    public function actualizar_entrada_controlador()
    {
        //recibiendo parametros del formulario
        $descripcion = mainModel::limpiar_cadena($_POST['entrada_nombre_up']);
        $cantidad = mainModel::limpiar_cadena($_POST['entrada_porcentaje_up']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        //Preparando datos par enviar al modelo
        $datos_entrada_up = [
            "Descripcion" => $descripcion,
            "Cantidad" => $cantidad,
            "id_admin" => $id_admin
        ];

        $entradaActualizada = entradaModelo::actualizar_entrada_modelo($datos_entrada_up);

        if ($entradaActualizada != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos actualizados",
                "Texto" => "Los datos del entrada han sido actualizados con exito.",
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

   
    public  function datos_entrada_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return entradaModelo::datos_entrada_modelo($tipo, $id);
    } 

    
}
