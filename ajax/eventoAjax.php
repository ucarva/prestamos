<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['categoria_nombre_reg']) || isset($_POST['categoria_id_del']) || isset($_POST['categoria_id_up']) ){

        require_once "../controladores/categoriaControlador.php";
        $ins_evento = new categoriaControlador();
        
        // Agregar una categoria
        if(isset($_POST['categoria_nombre_reg'])){
            echo $ins_evento->agregar_categoria_controlador();
        }
        // Eliminar una categoria
        if(isset($_POST['categoria_id_del'])){
            echo $ins_evento->eliminar_categoria_controlador();
        }
        // actualizar una categoria
        if(isset($_POST['categoria_id_up'])){
            echo $ins_evento->actualizar_categoria_controlador();
        }


       
    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
