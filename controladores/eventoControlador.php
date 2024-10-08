<?php

if ($peticionAjax) {
    require_once "../modelos/eventoModelo.php";
} else {
    require_once "./modelos/eventoModelo.php";
}

class eventoControlador extends eventoModelo
{
    
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
        $fecha_inicio = mainModel::limpiar_cadena($_POST['evento_fecha_inicio_reg']);
        $fecha_cierre = mainModel::limpiar_cadena($_POST['evento_fecha_cierre_reg']);

        $esEntradaGratis = mainModel::limpiar_cadena($_POST['evento_tipo_entrada_reg']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        $esEntradaGratis = $_POST['evento_tipo_entrada_reg'] === '0' ? false : true;

        //validando fechas
        if (strtotime($fecha_inicio) > strtotime($fecha_cierre)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "La fecha de inicio no puede ser mayor que la fecha de fin.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        //formateando fechas
        $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
        $fecha_cierre = date("Y-m-d", strtotime($fecha_cierre));


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
            "FechaInicio" => $fecha_inicio,
            "FechaCierre" => $fecha_cierre,
            "esGratis" => $esEntradaGratis,
            "id_admin" => $id_admin
        ];

        // Llamar al modelo para agregar el evento
        $agregar_evento = eventoModelo::agregar_evento_modelo($datos_evento_reg);

        // Preparar la respuesta
        header('Content-Type: application/json');
        echo json_encode($agregar_evento);
        exit();
    }

    public function paginador_evento_controlador($pagina, $registros, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);


        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $listaEventos = eventoModelo::consultar_evento_modelo($inicio, $registros, $busqueda);

        return $listaEventos;
    } 

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
    }

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
        $fecha_inicio = mainModel::limpiar_cadena($_POST['evento_fecha_inicio_up']);
        $fecha_cierre = mainModel::limpiar_cadena($_POST['evento_fecha_cierre_up']);
        $esEntradaGratis = mainModel::limpiar_cadena($_POST['evento_tipo_entrada_up']);
        $id_evento = mainModel::limpiar_cadena($_POST['evento_id_up']);


        //validando fechas
        if (strtotime($fecha_inicio) > strtotime($fecha_cierre)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "La fecha de inicio no puede ser mayor que la fecha de fin.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        //formateando fechas
        $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
        $fecha_cierre = date("Y-m-d", strtotime($fecha_cierre));



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
            "FechaInicio" => $fecha_inicio,
            "FechaFin" => $fecha_cierre,
            "esGratis" => $esEntradaGratis,
            "ID" => $id_evento

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
    }

    public  function datos_evento_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return eventoModelo::datos_evento_modelo($tipo, $id);
    }

    public function obtenerEventos()
    {
        return eventoModelo::datos_evento_modelo("Conteo", 0);
    }
    public function obtenerCupoMaximo($evento_id)
    {
        // Consulta para obtener el cupo máximo del evento
        $sql = "SELECT cupo FROM evento WHERE id_evento = :id_evento";

        // Parámetros a pasar
        $parametros = [':id_evento' => $evento_id];

        // Ejecutar la consulta
        $cupoMaximo = mainModel::ejecutar_consulta_simple($sql, $parametros);

        // Obtener el resultado
        $resultado = $cupoMaximo->fetch(PDO::FETCH_ASSOC);

        return $resultado['cupo'];
    }
}
