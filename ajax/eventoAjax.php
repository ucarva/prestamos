<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['evento_nombre_reg'])  ){

        require_once "../controladores/eventoControlador.php";
        $ins_evento = new eventoControlador();
        
        // Agregar un evento
        if(isset($_POST['evento_nombre_reg'])){
            echo $ins_evento->agregar_evento_controlador();
        }
       


       
    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
