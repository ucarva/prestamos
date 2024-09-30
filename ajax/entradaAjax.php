<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['entrada_nombre_reg']) || isset($_POST['entrada_id_del']) || isset($_POST['entrada_id_up']) ){

        require_once "../controladores/entradaControlador.php";
        $ins_entrada = new entradaControlador();
        
        // Agregar una categoria
        if(isset($_POST['entrada_nombre_reg'])){
            echo $ins_entrada->agregar_entrada_controlador();
        }
        // Eliminar una entrada
        if(isset($_POST['entrada_id_del'])){
            echo $ins_entrada->eliminar_entrada_controlador();
        }
        // actualizar una entrada
        if(isset($_POST['entrada_id_up'])){
            echo $ins_entrada->actualizar_entrada_controlador();
        }


       
    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
