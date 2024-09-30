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
}
