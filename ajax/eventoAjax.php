<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['evento_nombre_reg'])  || isset($_POST['evento_id_del']) || isset($_POST['evento_id_up']) ){ 

        require_once "../controladores/eventoControlador.php";
        $ins_evento = new eventoControlador();
        
        // Agregar un evento
        if(isset($_POST['evento_nombre_reg'])){
            echo $ins_evento->agregar_evento_controlador();
        }

         // eliminar un evento
         if(isset($_POST['evento_id_del'])){
            echo $ins_evento->eliminar_evento_controlador();
        }

         // actualicar un evento
         if(isset($_POST['evento_id_up'])){
            echo $ins_evento->actualizar_evento_controlador();
        }
       
       


       
    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
