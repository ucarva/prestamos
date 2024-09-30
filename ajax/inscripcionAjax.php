<?php

    $peticionAjax = true;

    require_once "../config/APP.php";

    if(isset($_POST['buscar_evento'])  || isset($_POST['id_agregar_cliente'])|| isset($_POST['id_eliminar_cliente'])
        || isset($_POST['buscar_item']) || isset($_POST['id_agregar_item']) || isset($_POST['id_eliminar_item'])
        || isset($_POST['prestamo_fecha_inicio_reg']) || isset($_POST['prestamo_codigo_del']) 
        || isset($_POST['pago_codigo_reg'])|| isset($_POST['prestamo_codigo_up'])) { 

        require_once"../controladores/prestamoControlador.php"; 
        $ins_prestamo = new prestamoControlador();

        //buscar cliente
        if(isset($_POST['buscar_evento'])){
            echo $ins_prestamo->buscar_cliente_prestamo_controlador();
        }








    }

    ?>