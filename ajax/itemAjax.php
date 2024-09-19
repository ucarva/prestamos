<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['item_codigo_reg']) || isset($_POST['item_id_del'])  ){

        require_once"../controladores/itemControlador.php";
        $ins_item = new itemControlador();
        

        //agregar un item
        if(isset($_POST['item_codigo_reg']) ){
            echo $ins_item->agregar_item_controlador();
        }

        //eliminar un item
        if(isset($_POST['item_id_del'])){
            echo $ins_item->eliminar_item_controlador();
        }

    }else{
        session_start(['name'=>'SPM']);
            session_unset();
            session_destroy();
            header("Location: ".SERVERURL."login/");
            exit();
    }