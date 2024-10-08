<?php

if ($peticionAjax) {
    require_once "../modelos/facturaModelo.php";
} else {
    require_once "./modelos/facturaModelo.php";
}

class facturaControlador extends facturaModelo
{

    public function validarInscripcion($evento_id)
    {
        // Obtener el número actual de inscripciones
        $totalInscripciones = facturaModelo::contarInscripciones($evento_id);

        // Obtener el cupo máximo del evento
        $cupoMaximo = facturaModelo::obtenerCupoMaximo($evento_id);

        // Verificar si el cupo ya ha sido alcanzado
        if ($totalInscripciones >= $cupoMaximo) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Evento lleno",
                "Texto" => "El evento ya alcanzó su cupo máximo.",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            return [
                "estado" => "exito",
                "mensaje" => "Inscripción permitida, puedes continuar."
            ];
        }
    }

    public function agregar_factura_controlador()
    {
        // Limpiar los datos enviados por POST
        $id_evento = mainModel::limpiar_cadena($_POST['id_evento']);
        $id_asistente = mainModel::limpiar_cadena($_POST['id_asistente']);
        $id_tipo_entrada = mainModel::limpiar_cadena($_POST['id_tipo_entrada']);
        $valor_pago = !empty($_POST['valor_pago']) ? mainModel::limpiar_cadena($_POST['valor_pago']) : 0;
        $estado_pago = mainModel::limpiar_cadena($_POST['estado_pago']);
        $activo = mainModel::limpiar_cadena($_POST['asistente_activo']);
        $id_admin = mainModel::limpiar_cadena($_POST['id_admin']);

        // Crear un array asociativo de los campos esperados
        $campos = [
            'id_evento' => $id_evento,
            'id_asistente' => $id_asistente,
            'id_tipo_entrada' => $id_tipo_entrada,
            'valor_pago' => $valor_pago,
            'estado_pago' => $estado_pago,        
            'id_admin' => $id_admin
        ];

        // Validar el cupo del evento
        $resultadoValidacion = $this->validarInscripcion($id_evento);

        if ($resultadoValidacion['estado'] == 'error') {
            // Mostrar el mensaje de error de validación de cupo
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Cupo excedido",
                "Texto" => $resultadoValidacion['mensaje'],
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();  // Detener ejecución si el cupo ya fue alcanzado
        }


        // Verificar campos vacíos
        $campos_vacios = [];
        foreach ($campos as $campo => $valor) {
            if (empty($valor) && $campo !== 'valor_pago') {
                $campos_vacios[] = $campo;
            }
        }

        if (!empty($campos_vacios)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Campos incompletos",
                "Texto" => "Los siguientes campos están vacíos: " . implode(', ', $campos_vacios),
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        
         // Establecer el valor de activo como 1
         $activo = 1; // Por defecto, los nuevos asistentes están activos



        // Preparar datos para la factura
        $datos_factura = [
            "Evento" => $id_evento,
            "Asistente" => $id_asistente,
            "Entrada" => $id_tipo_entrada,
            "Valor" => $valor_pago,
            "Estado" => $estado_pago,
            "Activo" => $activo,

            "id_admin" => $id_admin
        ];

        // Llamar al modelo para agregar la factura
        $agregar_factura = facturaModelo::agregar_factura_modelo($datos_factura);

        // Verificar si la inserción fue exitosa
        if ($agregar_factura) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Factura registrada",
                "Texto" => "Los datos de la factura han sido registrados con éxito.",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se pudo registrar la factura.",
                "Tipo" => "error"
            ];
        }

        // Enviar respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($alerta);
        exit();
    }

    public function validar_cupones()
    {
        $alertas = [];
        $totalDescuento = 0;

        if (isset($_POST['cupon_codigo1_reg'])) {
            $cupon1 = mainModel::limpiar_cadena($_POST['cupon_codigo1_reg']);
            if (!empty($cupon1)) {
                $cupon1Valido = facturaModelo::consultar_cupon_modelo($cupon1);
                if ($cupon1Valido !== null) {
                    $descuento1 = $cupon1Valido['porcentaje_descuento'];
                    $totalDescuento += $descuento1;
                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Cupón válido",
                        "Texto" => "El cupón 1 ha sido validado correctamente. Descuento aplicado: $descuento1%",
                        "Tipo" => "success",
                        "NuevoValor" => $descuento1 // Se envía el valor del descuento
                    ];
                }
            }
        }

        if (isset($_POST['cupon_codigo2_reg'])) {
            $cupon2 = mainModel::limpiar_cadena($_POST['cupon_codigo2_reg']);
            if (!empty($cupon2)) {
                $cupon2Valido = facturaModelo::consultar_cupon_modelo($cupon2);
                if ($cupon2Valido !== null) {
                    $descuento2 = $cupon2Valido['porcentaje_descuento'];
                    $totalDescuento += $descuento2;
                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Cupón válido",
                        "Texto" => "El cupón 2 ha sido validado correctamente. Descuento aplicado: $descuento2%",
                        "Tipo" => "success",
                        "NuevoValor" => $descuento2
                    ];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($alertas);
        exit();
    }

    public function validar_entrada()
    {
        $alertas = [];
        $totalDescuento = 0;

        if (isset($_POST['id_tipo_entrada'])) {
            $entrada = mainModel::limpiar_cadena($_POST['id_tipo_entrada']);
            if (!empty($entrada)) {
                $entradaValidado = facturaModelo::consultar_valorEntrada_modelo($entrada);
                if ($entradaValidado !== null) {
                    $precioEntrada = $entradaValidado['cantidad'];
                    $totalDescuento += $precioEntrada;

                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Entrada válida",
                        "Texto" => "La entrada ha sido validada correctamente. Precio: $precioEntrada",
                        "Tipo" => "success",
                        "NuevoValor" => $precioEntrada
                    ];
                } else {
                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Entrada inválida",
                        "Texto" => "El tipo de entrada seleccionado no es válido.",
                        "Tipo" => "error"
                    ];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($alertas);
        exit();
    }


    
}
