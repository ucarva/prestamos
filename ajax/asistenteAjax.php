<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['asistente_nombre_reg']) || isset($_POST['asistente_id_del']) || isset($_POST['asistente_id_up']) ){

        require_once "../controladores/asistenteControlador.php";
        $ins_asistente = new asistenteControlador();
        
        // Agregar un asistente
        if(isset($_POST['asistente_nombre_reg'])){
            echo $ins_asistente->agregar_asistente_controlador();
        }

        // Eliminar un asistente
        if(isset($_POST['asistente_id_del'])){
            echo $ins_asistente->eliminar_asistente_controlador();
        }

        // Actualizar datos del asistente
        if(isset($_POST['asistente_id_up'])){
            echo $ins_asistente->actualizar_asistente_controlador();
        }

    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
