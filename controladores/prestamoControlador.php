<?php

if ($peticionAjax) {
    require_once "../modelos/prestamoModelo.php";
} else {
    require_once "./modelos/prestamoModelo.php";
}

class prestamoControlador extends prestamoModelo
{

    //Controlador buscar cliente para prestamo
    public function buscar_cliente_prestamo_controlador()
    {

        //Recuperar el texto
        $cliente = mainModel::limpiar_cadena($_POST['buscar_cliente']);

        //Comprobar texto
        if ($cliente == "") {
            return '<div class="alert alert-warning" role="alert">
                        <p class="text-center mb-0">
                            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir el DNI,Nombre,Apellido,Telefono
                        </p>
                    </div>';
            exit();
        }

        //seleccionand oclientes en la base de datos
        $datos_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_dni LIKE '%$cliente%'
         OR cliente_nombre LIKE '%$cliente%' OR cliente_apellido LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%'
         ORDER BY cliente_nombre ASC");

        if ($datos_cliente->rowCount() >= 1) {
            $datos_cliente = $datos_cliente->fetchAll();

            $tabla = '<div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>';
            foreach ($datos_cliente as $rows) {
                $tabla .= '  <tr class="text-center">
                                    <td>' . $rows['cliente_nombre'] . ' ' . $rows['cliente_apellido'] . ' - ' . $rows['cliente_dni'] . ' </td>
                                         <td>
                                            <button type="button" class="btn btn-primary" onclick="agregar_cliente(' . $rows['cliente_id'] . ') " ><i class="fas fa-user-plus"></i></button>
                                        </td>
                                </tr>';
            }
            $tabla .= '</tbody>
                        </table>
                    </div>';

            return $tabla;
        } else {
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                         No hemos encontrado ningún cliente en el sistema que coincida con <strong>“' . $cliente . '”</strong>
                    </p>
                 </div>';
            exit();
        }
    } //fin controlador

    //Controlador agregar cliente para prestamo
    public function agregar_cliente_prestamo_controlador()
    {

        //Recuperar el id del cliente
        $id = mainModel::limpiar_cadena($_POST['id_agregar_cliente']);

        //comprobando el cliente en la bdd
        $check_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");

        if ($check_cliente->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos encontrado el cliente en el sistema",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $campos = $check_cliente->fetch();
        }

        //iniciando la sesion
        session_start(['name' => 'SPM']);

        if (empty($_SESSION['datos_cliente'])) {
            $_SESSION['datos_cliente'] = [
                "ID" => $campos['cliente_id'],
                "DNI" => $campos['cliente_dni'],
                "Nombre" => $campos['cliente_nombre'],
                "Apellido" => $campos['cliente_apellido'],
            ];

            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Cliente agregado",
                "Texto" => "El cliente se agrego para realizar un prestamo o reservacion",
                "Tipo" => "success"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "ya existe un cliente en sesion",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    } //fin controlador

    //Controlador eliminar cliente para prestamo
    public function eliminar_cliente_prestamo_controlador()
    {

        //iniciar la sesion
        session_start(['name' => 'SPM']);

        //eliminar los datos del cliente en la sesion
        unset($_SESSION['datos_cliente']);

        if (empty($_SESSION['datos_cliente'])) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Cliente removido",
                "Texto" => "Los datos del cliente se han removido con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido remover los datos del cliente",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alerta);
        exit();
    } //fin controlador

    //controlador para buscar item
    public function buscar_item_prestamo_controlador()
    {

        //Recuperar el texto
        $item = mainModel::limpiar_cadena($_POST['buscar_item']);

        //Comprobar texto
        if ($item == "") {
            return '<div class="alert alert-warning" role="alert">
                        <p class="text-center mb-0">
                            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir codigo o nombre del item
                        </p>
                    </div>';
            exit();
        }

        //seleccionando item en la base de datos
        $datos_item = mainModel::ejecutar_consulta_simple("SELECT * FROM item WHERE (item_codigo LIKE '%$item%'
         OR item_nombre LIKE '%$item%') AND (item_estado='Habilitado') ORDER BY item_nombre ASC");


        if ($datos_item->rowCount() >= 1) {
            $datos_item = $datos_item->fetchAll();

            $tabla = '<div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>';
            foreach ($datos_item as $rows) {
                $tabla .= '  <tr class="text-center">
                                    <td>' . $rows['item_codigo'] . '-' . $rows['item_nombre'] . '</td>
                                         <td>
                                            <button type="button" class="btn btn-primary" onclick="modal_agregar_item(' . $rows['item_id'] . ')" ><i class="fas fa-box-open"></i></button>
                                        </td>
                                </tr>';
            }
            $tabla .= '</tbody>
                        </table>
                    </div>';

            return $tabla;
        } else {
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                         No hemos encontrado ningún item en el sistema que coincida con <strong>“' . $item . '”</strong>
                    </p>
                 </div>';
            exit();
        }
    } //fin controlador

    //controlador para agregar item
    public function agregar_item_prestamo_controlador()
    {

        //recibiendo el id del item
        $id = mainModel::limpiar_cadena($_POST['id_agregar_item']);

        //comprobar item en la bdd
        $check_item = mainModel::ejecutar_consulta_simple("SELECT * FROM item WHERE item_id='$id' AND  item_estado ='Habilitado' ");

        if ($check_item->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos encontrado el item en el sistema",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $campos = $check_item->fetch();
        }


        //recuperando detalles del prestamo

        $formato = mainModel::limpiar_cadena($_POST['detalle_formato']);
        $cantidad = mainModel::limpiar_cadena($_POST['detalle_cantidad']);
        $tiempo = mainModel::limpiar_cadena($_POST['detalle_tiempo']);
        $costo = mainModel::limpiar_cadena($_POST['detalle_costo_tiempo']);

        // Comprobar los datos obligatorios vengan con datos
        if ($cantidad == "" || $tiempo == "" || $costo == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No has llenado todos los campos que son obligatorios.",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        //Verificar integridad de los datos
        if (mainModel::verificar_datos("[0-9]{1,7}", $cantidad)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "La cantidad no coincide con el formato solicitado.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[0-9]{1,7}", $tiempo)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El tiempo no coincide con el formato solicitado.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[0-9.]{1,15}", $costo)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El costo no coincide con el formato solicitado.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        if ($formato != "Horas" && $formato != "Dias" && $formato != "Evento" && $formato != "Mes") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El formato seleccionado no es valido.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        session_start(['name' => 'SPM']);
        if (empty($_SESSION['datos_item'][$id])) {
            $costo = number_format($costo, 2, '.', '');

            $_SESSION['datos_item'][$id] = [

                "ID" => $campos['item_id'],
                "codigo" => $campos['item_codigo'],
                "Nombre" => $campos['item_nombre'],
                "Detalle" => $campos['item_detalle'],
                "Formato" => $formato,
                "Cantidad" => $cantidad,
                "Tiempo" => $tiempo,
                "Costo" => $costo

            ];
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Item agregado",
                "Texto" => "El item ha sido agregado con exito.",
                "Tipo" => "success"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El item que intenta agregar ya se encuentra seleccionado.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    } //fin controlador

    //controlador eliminar item
    public function eliminar_item_prestamo_controlador()
    {
        //recibiendo el id del item
        $id = mainModel::limpiar_cadena($_POST['id_eliminar_item']);

        //iniciar la sesion
        session_start(['name' => 'SPM']);

        //eliminar los datos del cliente en la sesion
        unset($_SESSION['datos_item'][$id]);

        if (empty($_SESSION['datos_item'][$id])) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Item removido",
                "Texto" => "Los datos del item se han removido con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido remover los datos del item",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alerta);
        exit();
    } //fin controlador

}
