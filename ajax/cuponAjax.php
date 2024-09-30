<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['cupon_codigo_reg']) || isset($_POST['cupon_id_del']) || isset($_POST['cupon_id_up']) ){

        require_once "../controladores/cuponControlador.php";
        $ins_cupon = new cuponControlador();
        
        // Agregar un cupon
        if(isset($_POST['cupon_codigo_reg'])){
            echo $ins_cupon->agregar_cupon_controlador();
        }
      
        // eliminar un cupon
        if(isset($_POST['cupon_id_del'])){
            echo $ins_cupon->eliminar_cupon_controlador();
        }

        // actualizar un cupon
          if(isset($_POST['cupon_id_up'])){
            echo $ins_cupon->actualizar_cupon_controlador();
        }

       
    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
