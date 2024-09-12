<?php

if ($peticionAjax) {
    require_once "../modelos/clienteModelo.php";
} else {
    require_once "./modelos/clienteModelo.php";
}

class clienteControlador extends clienteModelo
{
    //Controlador para agregar cliente
    public function agregar_cliente_controlador()
    {
        $dni = mainModel::limpiar_cadena($_POST['cliente_dni_reg']);
        $nombre = mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
        $apellido = mainmodel::limpiar_cadena($_POST['cliente_apellido_reg']);
        $telefono = mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
        $direccion = mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);

    //Comprobar los campos vacios

    if($dni == ""){
        $alerta = [
            "Alerta" => "simple",
            "Titulo" => "Ocurrió un error inesperado",
            "Texto" => "El DNI  es un campo obligatorio",
            "Tipo" => "error"
        ];

        header('Content-Type: application/json');
        echo json_encode($alerta);
        exit();
    }

        //Verificar integridad de los datos
        if (mainModel::verificar_datos("[0-9-]{10,27}", $dni)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El DNI no coincide con el formato solicitado.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        //Comrpobando el DNI
        $check_dni = mainModel::ejecutar_consulta_simple("SELECT cliente_dni FROM cliente WHERE  cliente_dni='$dni'");
        if ($check_dni->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Existe un usuario registrado con ese DNI.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        //registro de datos

        $datos_cliente_reg = [

            "DNI" => $dni,
            "Nombre" => $nombre,
            "Apellido" => $apellido,
            "Telefono" => $telefono,
            "Direccion" => $direccion
           
        ];



        $agregar_cliente = clienteModelo::agregar_cliente_modelo($datos_cliente_reg);

        if ($agregar_cliente->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Cliente registrado",
                "Texto" => "Los datos del cliente han sido registrado con exito.",
                "Tipo" => "success"

            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se pudo registrar el cliente.",
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
}