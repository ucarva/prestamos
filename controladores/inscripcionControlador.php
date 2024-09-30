<?php

if ($peticionAjax) {
    require_once "../modelos/inscripcionModelo.php";
} else {
    require_once "./modelos/inscripcionModelo.php";
}

class inscripcionControlador extends inscripcionModelo
{
    public function buscar_asistente_inscripcion_controlador()
    {
        //Recuperar el texto
        $asistente = mainModel::limpiar_cadena($_POST['buscar_asistente']);

        //Comprobar texto
        if ($asistente == "") {
            return '<div class="alert alert-warning" role="alert">
                        <p class="text-center mb-0">
                            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir el titulo asistente
                        </p>
                    </div>';
            exit();
        }

        //seleccionando asistentes en la base de datos
        $datos_asistente = mainModel::ejecutar_consulta_simple("SELECT * FROM asistente WHERE nombres LIKE '%$asistente%'
         OR apellidos LIKE '%$asistente%' 
         ORDER BY id_asistente ASC");

        if ($datos_asistente->rowCount() >= 1) {
            $datos_asistente = $datos_asistente->fetchAll();

            $tabla = '<div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>';
            foreach ($datos_asistente as $rows) {
                $tabla .= '  <tr class="text-center">
                                    <td>' . $rows['nombres'] . '  - ' . $rows['apellidos'] . ' </td>
                                         <td>
                                            <button type="button" class="btn btn-primary" onclick="agregar_asistente(' . $rows['id_asistente'] . ') " ><i class="fas fa-user-plus"></i></button>
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
                         No hemos encontrado ningún asistente en el sistema que coincida con <strong>“' . $asistente . '”</strong>
                    </p>
                 </div>';
            exit();
        }
    }


   
    public function agregar_asistente_inscripcion_controlador()
    {


        $id = mainModel::limpiar_cadena($_POST['id_agregar_asistente']);


        $check_asistente = mainModel::ejecutar_consulta_simple("SELECT * FROM asistente WHERE id_asistente='$id'");

        if ($check_asistente->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos encontrado el asistente en el sistema",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $campos = $check_asistente->fetch();
        }

        //iniciando la sesion
        session_start(['name' => 'SPM']);

        if (empty($_SESSION['datos_asistente'])) {
            $_SESSION['datos_asistente'] = [
                "ID" => $campos['id_asistente'],
                "Nombre" => $campos['nombres'],
                "Apellido" => $campos['apellidos'],

            ];

            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "asistente agregado",
                "Texto" => "El asistente se agrego para inscribirse a los eventos",
                "Tipo" => "success"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "ya existe un asistente en sesion",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    } 


    
    public function eliminar_asistente_inscripcion_controlador()
    {

        
        session_start(['name'=>'SPM']);

        unset($_SESSION['datos_asistente']);

        if (empty($_SESSION['datos_asistente'])) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "asistente removido",
                "Texto" => "Los datos del asistente se han removido con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido remover los datos del asistente",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alerta);
        exit();
    } 

    //controlador para buscar evento
    public function buscar_evento_inscripcion_controlador()
    {

        //Recuperar el texto
        $evento = mainModel::limpiar_cadena($_POST['buscar_evento']);

        //Comprobar texto
        if ($evento == "") {
            return '<div class="alert alert-warning" role="alert">
                        <p class="text-center mb-0">
                            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir el nombre del evento
                        </p>
                    </div>';
            exit();
        }

        //seleccionando eventoen la base de datos
        $datos_evento = mainModel::ejecutar_consulta_simple("SELECT * FROM evento WHERE (titulo LIKE '%$evento%'
         OR descripcion LIKE '%$evento%') AND (estado='Habilitado')   ORDER BY id_evento ASC");


        if ($datos_evento->rowCount() >= 1) {
            $datos_evento = $datos_evento->fetchAll();

            $tabla = '<div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>';
            foreach ($datos_evento as $rows) {
                $tabla .= '  <tr class="text-center">
                                    <td>' . $rows['titulo'] . '-' . $rows['descripcion'] . '</td>
                                         <td>
                                            <button type="button" class="btn btn-primary" onclick="modal_agregar_evento(' . $rows['id_evento'] . ')" ><i class="fas fa-box-open"></i></button>
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
                         No hemos encontrado ningún evento en el sistema que coincida con <strong>“' . $evento . '”</strong>
                    </p>
                 </div>';
            exit();
        }
    } //fin controlador

    //controlador para agregar asistente
    public function agregar_evento_inscripcion_controlador()
    {

        //recibiendo el id del item
        $id = mainModel::limpiar_cadena($_POST['id_agregar_evento']);

        //comprobar item en la bdd
        $check_evento = mainModel::ejecutar_consulta_simple("SELECT * FROM evento WHERE id_evento='$id' ");

        if ($check_evento->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos encontrado el evento en el sistema",
                "Tipo" => "error"
            ];

            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $campos = $check_evento->fetch();
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


}
