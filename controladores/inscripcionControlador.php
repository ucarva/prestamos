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
        $datos_asistente = mainModel::ejecutar_consulta_simple("SELECT * FROM asistente 
        WHERE (nombres LIKE '%$asistente%' OR apellidos LIKE '%$asistente%') 
        AND activo = 1  
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


        $check_asistente = mainModel::ejecutar_consulta_simple("SELECT * FROM asistente WHERE id_asistente='$id' AND activo = 1 ");

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


        session_start(['name' => 'SPM']);

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
    } 

    public function agregar_evento_inscripcion_controlador()
    {

        //recibiendo el id del evento
        $id = mainModel::limpiar_cadena($_POST['id_agregar_evento']);

        //comprobar evento en la bdd
        $check_evento = mainModel::ejecutar_consulta_simple("SELECT * FROM evento WHERE id_evento='$id' AND (estado='Habilitado')  ");

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


        //recuperando detalles de inscripcion

        $entrada = mainModel::limpiar_cadena($_POST['evento_entrada']);
        $descuento = mainModel::limpiar_cadena($_POST['cupon_codigo']);

        // Verificar si el código está vacío
        if (empty($codigo)) {
            $codigo = "sin codigo";
        }




        session_start(['name' => 'SPM']);
        if (empty($_SESSION['datos_evento'][$id])) {
            

            $_SESSION['datos_evento'][$id] = [

                "ID" => $campos['id_evento'],
                "Entrada" => $campos['evento_entrada'],
                "Descuento" => $campos['cupon_codigo'],
                
                

            ];
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "evento agregado",
                "Texto" => "El evento ha sido agregado con exito.",
                "Tipo" => "success"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El evento que intenta agregar ya se encuentra seleccionado.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    } 
    
    public function contarInscripciones($evento_id) {
        // Consulta SQL con parámetro, ahora contando solo inscripciones activas
        $sql = "SELECT COUNT(*) AS total_inscripciones 
                FROM inscripcion 
                WHERE id_evento = :id_evento AND activo = 1"; // Filtra solo inscripciones activas
        
        // Parámetros a pasar
        $parametros = [':id_evento' => $evento_id];
        
        // Ejecutar la consulta usando el método modificado
        $contarInscripcion = mainModel::ejecutar_consulta_simple($sql, $parametros);
        
        // Obtener el resultado
        $resultado = $contarInscripcion->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total_inscripciones'];
    }
       
    public function obtenerCupoMaximo($evento_id) {
        // Consulta para obtener el cupo máximo del evento
        $sql = "SELECT cupo FROM evento WHERE id_evento = :id_evento AND activo = 1";
        
        // Parámetros a pasar
        $parametros = [':id_evento' => $evento_id];
        
        // Ejecutar la consulta
        $cupoMaximo = mainModel::ejecutar_consulta_simple($sql, $parametros);
        
        // Obtener el resultado
        $resultado = $cupoMaximo->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['cupo']; 
    }
    
    


}
