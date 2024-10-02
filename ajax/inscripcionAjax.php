<?php

    $peticionAjax = true;

    require_once "../config/APP.php";





    if(isset($_POST['buscar_asistente']) || isset($_POST['id_agregar_asistente']) || isset($_POST['id_eliminar_asistente'])
        || isset($_POST['buscar_evento']) || isset($_POST['id_agregar_evento']) ) { 

        require_once"../controladores/inscripcionControlador.php"; 

        $ins_inscripcion = new inscripcionControlador();

        //activandocontrolador buscar evento
        if(isset($_POST['buscar_asistente'])){
            echo $ins_inscripcion->buscar_asistente_inscripcion_controlador();
        }
          //agregar asistente
          if(isset($_POST['id_agregar_asistente'])){
            echo $ins_inscripcion->agregar_asistente_inscripcion_controlador();
        }

        //eliminar asistente
        if(isset($_POST['id_eliminar_asistente'])){

            echo $ins_inscripcion->eliminar_asistente_inscripcion_controlador();
            
        }

         //buscar evento
         if(isset($_POST['buscar_evento'])){
            echo $ins_inscripcion->buscar_evento_inscripcion_controlador();
        }

        //agregar evento
        if(isset($_POST['id_agregar_evento'])){
            echo $ins_inscripcion->agregar_evento_inscripcion_controlador();
        }

     


    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
    

 