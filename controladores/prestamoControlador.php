<?php

if ($peticionAjax) {
    require_once "../modelos/prestamoModelo.php";
} else {
    require_once "./modelos/prestamoModelo.php";
}

class prestamoControlador extends prestamoModelo{

    //Controlador buscar cliente para prestamo
    public function buscar_cliente_prestamo_controlador(){
       
        //Recuperar el texto
        $cliente=mainModel::limpiar_cadena($_POST['buscar_cliente']);

        //Comprobar texto
        if($cliente==""){
            return'<div class="alert alert-warning" role="alert">
                        <p class="text-center mb-0">
                            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir el DNI,Nombre,Apellido,Telefono
                        </p>
                    </div>';
                    exit();
        }

        //seleccionand oclientes en la base de datos
        $datos_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_dni LIKE '%$cliente%'
         OR cliente_nombre LIKE '%$cliente%' OR cliente_apellido LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%'
         ORDER BY cliente_nombre ASC");

        if($datos_cliente->rowCount()>=1){
            $datos_cliente=$datos_cliente->fetchAll();

            $tabla='<div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>';
                foreach( $datos_cliente as $rows){
                    $tabla.='  <tr class="text-center">
                                    <td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].' - '.$rows['cliente_dni'].' </td>
                                         <td>
                                            <button type="button" class="btn btn-primary" onclick="agregar_cliente('.$rows['cliente_id'].') " ><i class="fas fa-user-plus"></i></button>
                                        </td>
                                </tr>';
                }
            $tabla.='</tbody>
                        </table>
                    </div>';

            return $tabla;


              

        }else{
            return'<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                         No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$cliente.'”</strong>
                    </p>
                 </div>';
        exit();
        }



    }//fin controlador

    //Controlador agregar cliente para prestamo
    public function agregar_cliente_prestamo_controlador(){

         //Recuperar el id del cliente
         $id=mainModel::limpiar_cadena($_POST['id_agregar_cliente']);

         //comprobando el cliente en la bdd
        $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");

        if($check_cliente->rowCount()<=0){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos encontrado el cliente en el sistema",
                "Tipo" => "error"
            ];
    
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }else{
            $campos=$check_cliente->fetch();
        }

        //iniciando la sesion
        session_start(['name'=>'SPM']);

        if(empty($_SESSION['datos_cliente'])){
            $_SESSION['datos_cliente']=[
                "ID"=>$campos['cliente_id'],
                "DNI"=>$campos['cliente_dni'],
                "Nombre"=>$campos['cliente_nombre'],
                "Apellido"=>$campos['cliente_apellido'],
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

        }else{
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

    }//fin controlador

    //Controlador eliminar cliente para prestamo
    public function eliminar_cliente_prestamo_controlador(){

        //iniciar la sesion
        session_start(['name'=>'SPM']);

        //eliminar los datos del cliente en la sesion
        unset($_SESSION['datos_cliente']);

        if(empty($_SESSION['datos_cliente'])){
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Cliente removido",
                "Texto" => "Los datos del cliente se han removido con exito",
                "Tipo" => "success"
            ];
    
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido remover los datos del cliente",
                "Tipo" => "error"
            ];      
        }

        echo json_encode($alerta);
        exit();



    }//fin controlador

    //controlador para buscar item
    public function buscar_item_prestamo_controlador(){

    }//fin controlador

}