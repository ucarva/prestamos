<?php

if ($peticionAjax) {
    require_once "../modelos/eventoModelo.php";
} else {
    require_once "./modelos/eventoModelo.php";
}

class eventoControlador extends eventoModelo
{
    // Controlador para agregar evento
    public function agregar_evento_controlador()
    {
        // Limpiar y asignar datos del formulario
        $nombre = mainModel::limpiar_cadena($_POST['evento_nombre_reg']);
        $descripcion = mainModel::limpiar_cadena($_POST['evento_descripcion_reg']);
        $hora = mainModel::limpiar_cadena($_POST['evento_hora_reg']);
        $valor = mainModel::limpiar_cadena($_POST['evento_valor_reg']);
        $categoria = mainModel::limpiar_cadena($_POST['evento_categoria_reg']);
        $lugar = mainModel::limpiar_cadena($_POST['evento_lugar_reg']);
        $cupo = mainModel::limpiar_cadena($_POST['evento_cupo_reg']);
        $estado = mainModel::limpiar_cadena($_POST['evento_estado_reg']);
        $entrada = mainModel::limpiar_cadena($_POST['evento_entrada_reg']);
        $tipo = mainModel::limpiar_cadena($_POST['evento_evento_reg']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        // Arreglo de datos para el registro del evento
        $datos_evento_reg = [
            "Titulo" => $nombre,
            "Descripcion" => $descripcion,
            "Hora" => $hora,
            "Valor" => $valor,
            "Categoria" => $categoria,  // ID de la categoría
            "Lugar" => $lugar,          // Lugar del evento
            "Cupo" => $cupo,
            "Estado" => $estado,
            "Entrada" => $entrada,
            "Tipo" => $tipo,
            "id_admin" => $id_admin
        ];

        // Llamar al modelo para agregar el evento
        $agregar_evento = eventoModelo::agregar_evento_modelo($datos_evento_reg);

        // Preparar la respuesta
        header('Content-Type: application/json');
        echo json_encode($agregar_evento);
        exit();
    }

    // Controlador para paginar asistente
    public function paginador_evento_controlador($pagina, $registros, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);


        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $listaEventos = eventoModelo::consultar_evento_modelo($inicio, $registros, $busqueda);

        return $listaEventos;
    } //fin controlador

    // Controlador para eliminar eventos
    public function eliminar_evento_controlador()
    {
        $eliminar_evento = eventoModelo::eliminar_evento_modelo();
        if ($eliminar_evento != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "evento eliminado.",
                "Texto" => "evento eliminado con exito.",
                "Tipo" => "success"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "No hemos podido eliminar el evento.",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    } //fin controlador

    //controlador para actualizar evento
    public function actualizar_evento_controlador()
    {

        // Limpiar y asignar datos del formulario
        $nombre = mainModel::limpiar_cadena($_POST['evento_nombre_up']);
        $descripcion = mainModel::limpiar_cadena($_POST['evento_descripcion_up']);
        $hora = mainModel::limpiar_cadena($_POST['evento_hora_up']);
        $valor = mainModel::limpiar_cadena($_POST['evento_valor_up']);
        $categoria = mainModel::limpiar_cadena($_POST['evento_categoria_up']);
        $lugar = mainModel::limpiar_cadena($_POST['evento_lugar_up']);
        $cupo = mainModel::limpiar_cadena($_POST['evento_cupo_up']);
        $estado = mainModel::limpiar_cadena($_POST['evento_estado_up']);
        $entrada = mainModel::limpiar_cadena($_POST['evento_entrada_up']);
        $tipo = mainModel::limpiar_cadena($_POST['evento_evento_up']);

        

         // Arreglo de datos para el registro del evento
         $datos_evento_up = [
            "Titulo" => $nombre,
            "Descripcion" => $descripcion,
            "Hora" => $hora,
            "Valor" => $valor,
            "Categoria" => $categoria,  // ID de la categoría
            "Lugar" => $lugar,          // Lugar del evento
            "Cupo" => $cupo,
            "Estado" => $estado,
            "Entrada" => $entrada,
            "Tipo" => $tipo,
            
        ];

        $eventoActualizado = eventoModelo::actualizar_evento_modelo($datos_evento_up);

        if ($eventoActualizado != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos actualizados",
                "Texto" => "Los datos del evento han sido actualizados con exito.",
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

      //controlador para los datos de evento
      public  function datos_evento_controlador($tipo, $id)
      {
          $tipo = mainModel::limpiar_cadena($tipo);
          $id = mainModel::decryption($id);
          $id = mainModel::limpiar_cadena($id);
  
          return eventoModelo::datos_evento_modelo($tipo, $id);
      } // fin controlador

}
