<?php

if ($peticionAjax) {
    require_once "../modelos/cuponModelo.php";
} else {
    require_once "./modelos/cuponModelo.php";
}


class cuponControlador extends cuponModelo
{

    public function agregar_cupon_controlador()
    {
        if (empty($_POST['cupon_codigo_reg']) || empty($_POST['cupon_descuento_reg']) || empty($_POST['cupon_estado_reg']) || empty($_POST['cupon_fecha_vigencia_reg']) || empty($_POST['cupon_fecha_fin_reg'])) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Todos los campos son obligatorios.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        $cupon = mainModel::limpiar_cadena($_POST['cupon_codigo_reg']);
        $descuento = floatval(mainModel::limpiar_cadena($_POST['cupon_descuento_reg']));
        $estado = mainModel::limpiar_cadena($_POST['cupon_estado_reg']);
        $inicio = mainModel::limpiar_cadena($_POST['cupon_fecha_vigencia_reg']);
        $fin = mainModel::limpiar_cadena($_POST['cupon_fecha_fin_reg']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        //validando fechas
        if (strtotime($inicio) > strtotime($fin)) {
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
        $inicio = date("Y-m-d", strtotime($inicio));
        $fin = date("Y-m-d", strtotime($fin));

        //registro de datos
        $datos_cupon_reg = [
            "Codigo" => $cupon,
            "Porcentaje" => $descuento,
            "Estado" => $estado,
            "Inicio" => $inicio,
            "Fin" => $fin,
            "id_admin" => $id_admin
        ];

        try {
            $agregar_cupon = cuponModelo::agregar_cupon_modelo($datos_cupon_reg);
            if ($agregar_cupon->rowCount() == 1) {
                $alerta = [
                    "Alerta" => "limpiar",
                    "Titulo" => "Cupon registrado",
                    "Texto" => "Los datos del cupón han sido registrados con éxito.",
                    "Tipo" => "success"
                ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No se pudo registrar el cupón.",
                    "Tipo" => "error"
                ];
            }
        } catch (Exception $e) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error en la base de datos",
                "Texto" => $e->getMessage(),
                "Tipo" => "error"
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($alerta);
        exit();
    }

    public  function datos_cupon_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return cuponModelo::datos_cupon_modelo($tipo, $id);
    }

    public function paginador_cupon_controlador($pagina, $registros, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);


        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $listaCupones = cuponModelo::consultar_cupon_modelo($inicio, $registros, $busqueda);

        return $listaCupones;
    }

    public function actualizar_cupon_controlador()
    {
        //recibiendo parametros del formulario
        $cupon = mainModel::limpiar_cadena($_POST['cupon_codigo_up']);
        $descuento = floatval(mainModel::limpiar_cadena($_POST['cupon_descuento_up']));
        $estado = mainModel::limpiar_cadena($_POST['cupon_estado_up']);
        $inicio = mainModel::limpiar_cadena($_POST['cupon_fecha_vigencia_up']);
        $fin = mainModel::limpiar_cadena($_POST['cupon_fecha_fin_up']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        //validando fechas
        if (strtotime($inicio) > strtotime($fin)) {
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
        $inicio = date("Y-m-d", strtotime($inicio));
        $fin = date("Y-m-d", strtotime($fin));

        //Preparando datos par enviar al modelo
        $datos_cupon_up = [
            "Codigo" => $cupon,
            "Descuento" => $descuento,
            "Estado" => $estado,
            "Inicio" => $inicio,
            "Fin" => $fin,
            "id_admin" => $id_admin
        ];

        $cuponActualizado = cuponModelo::actualizar_cupon_modelo($datos_cupon_up);

        if ($cuponActualizado != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos actualizados",
                "Texto" => "Los datos del cupon han sido actualizados con exito.",
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

    public function eliminar_cupon_controlador()
    {
        $eliminar_cupon = cuponModelo::eliminar_cupon_modelo();
        if ($eliminar_cupon != null) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "cupon eliminado.",
                "Texto" => "cupon eliminado con exito.",
                "Tipo" => "success"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "No hemos podido eliminar el cupon.",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    }
}
