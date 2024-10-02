<?php

if ($peticionAjax) {
    require_once "../modelos/facturaModelo.php";
} else {
    require_once "./modelos/facturaModelo.php";
}

class facturaControlador extends facturaModelo
{


    public function agregar_factura_controlador()
    {
        // Limpiar los datos enviados por POST
        $id_evento = mainModel::limpiar_cadena($_POST['id_evento']);
        $id_asistente = mainModel::limpiar_cadena($_POST['id_asistente']);
        $id_tipo_entrada = mainModel::limpiar_cadena($_POST['id_tipo_entrada']);

        // Asignar 0 a valor_pago si está vacío
        $valor_pago = !empty($_POST['valor_pago']) ? mainModel::limpiar_cadena($_POST['valor_pago']) : 0;

        $estado_pago = mainModel::limpiar_cadena($_POST['estado_pago']);
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

        // Crear un array para guardar los campos que están vacíos
        $campos_vacios = [];

        // Verificar qué campos están vacíos
        foreach ($campos as $campo => $valor) {
            if (empty($valor) && $campo !== 'valor_pago') { // Ignorar valor_pago ya que tiene valor por defecto
                $campos_vacios[] = $campo;
            }
        }

        // Si hay campos vacíos, devolver un mensaje de error con los nombres de los campos faltantes
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

        // Preparar datos para la factura
        $datos_factura = [
            "Evento" => $id_evento,
            "Asistente" => $id_asistente,
            "Entrada" => $id_tipo_entrada,
            "Valor" => $valor_pago,
            "Estado" => $estado_pago,
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
        // Inicializar el array de alertas
        $alertas = [];
    
        // Validar el cupón 1
        if (isset($_POST['cupon_codigo1_reg'])) {
            $cupon1 = mainModel::limpiar_cadena($_POST['cupon_codigo1_reg']);
            
            // Si el cupón está vacío, se puede manejar como un caso especial
            if (empty($cupon1)) {
                // Opcional: agregar una alerta informando que el cupón 1 está vacío
                $alertas[] = [
                    "Alerta" => "simple",
                    "Titulo" => "Cupón 1 vacío",
                    "Texto" => "No se ha introducido un código para el cupón 1.",
                    "Tipo" => "info" // Puedes usar un tipo diferente para indicar que es información
                ];
            } else {
                $cupon1Valido = facturaModelo::consultar_cupon_modelo($cupon1);
        
                if ($cupon1Valido !== null) {
                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Cupón válido",
                        "Texto" => "El cupón ha sido validado correctamente.",
                        "Tipo" => "success"
                    ];
                } else {
                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Cupón inválido",
                        "Texto" => "El cupón no es válido o ha expirado.",
                        "Tipo" => "error"
                    ];
                }
            }
        }

         // Validar el cupón 2
         if (isset($_POST['cupon_codigo2_reg'])) {
            $cupon2 = mainModel::limpiar_cadena($_POST['cupon_codigo2_reg']);
            
            // Si el cupón está vacío, se puede manejar como un caso especial
            if (empty($cupon2)) {
                // Opcional: agregar una alerta informando que el cupón 2 está vacío
                $alertas[] = [
                    "Alerta" => "simple",
                    "Titulo" => "Cupón 2 vacío",
                    "Texto" => "No se ha introducido un código para el cupón 2.",
                    "Tipo" => "info" // Puedes usar un tipo diferente para indicar que es información
                ];
            } else {
                $cupon2Valido = facturaModelo::consultar_cupon_modelo($cupon2);
        
                if ($cupon2Valido !== null) {
                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Cupón válido",
                        "Texto" => "El cupón ha sido validado correctamente.",
                        "Tipo" => "success"
                    ];
                } else {
                    $alertas[] = [
                        "Alerta" => "simple",
                        "Titulo" => "Cupón inválido",
                        "Texto" => "El cupón no es válido o ha expirado.",
                        "Tipo" => "error"
                    ];
                }
            }
        }
    
        // Enviar respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($alertas);
        exit();
    }
    
    

    
    

}
