<?php

if ($peticionAjax) {
    require_once "../modelos/empresaModelo.php";
} else {
    require_once "./modelos/empresaModelo.php";
}

class empresaControlador extends empresaModelo{

    //controlador para los datos empresa
    public function datos_empresa_controlador(){

        return empresaModelo::datos_empresa_modelo();

    }//fin controlador


    //controlador agregar empresa
    public function agregar_empresa_controlador(){

        $nombre =mainModel::limpiar_cadena($_POST['empresa_nombre_reg']);
        $email =mainModel::limpiar_cadena($_POST['empresa_email_reg']);
        $telefono =mainModel::limpiar_cadena($_POST['empresa_telefono_reg']);
        $direccion =mainModel::limpiar_cadena($_POST['empresa_direccion_reg']);
        
        
        $datos_empresa_reg = [

            "Nombre" => $nombre,
            "Email" => $email,
            "Telefono" => $telefono,
            "Direccion" => $direccion
        
        ];
        
        
        
        $agregar_empresa = empresaModelo::agregar_empresa_modelo($datos_empresa_reg);
        
        if ($agregar_empresa->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "empresa registrado",
                "Texto" => "Los datos de la empresa han sido registrado con exito.",
                "Tipo" => "success"
        
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se pudo registrar la empresa.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode($alerta);
        exit();
        

    }//fin controlador

    //Controlador actualizar datos empresa
    public function actualizar_empresa_controlador(){
         
        $id =mainModel::limpiar_cadena($_POST['empresa_id_up']);
        $nombre =mainModel::limpiar_cadena($_POST['empresa_nombre_up']);
        $email =mainModel::limpiar_cadena($_POST['empresa_email_up']);
        $telefono =mainModel::limpiar_cadena($_POST['empresa_telefono_up']);
        $direccion =mainModel::limpiar_cadena($_POST['empresa_direccion_up']);

        //comprobando privilegios
        session_start(['name'=>'SPM']);
        if($_SESSION['privilegio_spm'] < 1 || $_SESSION['privilegio_spm'] > 2){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No tienes permisos para esta tarea.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
       
        //Preparando datos par enviar al modelo
        $datos_empresa_up = [
            "ID" => $id,
            "Nombre" => $nombre,
            "Email" => $email,
            "Telefono" => $telefono,
            "Direccion" => $direccion,
            

        ];

        if (empresaModelo::actualizar_empresa_modelo($datos_empresa_up)) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos actualizados",
                "Texto" => "Los datos han sido actualizados con exito.",
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

}