<?php

$peticionAjax = true;
require_once "../config/APP.php";

if ( isset($_POST['cupon_codigo1_reg']) || isset($_POST['cupon_codigo2_reg']) || isset($_POST['id_evento']) ) {

    require_once "../controladores/facturaControlador.php";
    $ins_factura = new facturaControlador();

    // Validar cupones
    if (isset($_POST['cupon_codigo1_reg']) || isset($_POST['cupon_codigo2_reg'])) {
        echo $ins_factura->validar_cupones();

        
        
    }

    // Agregar factura
    if (isset($_POST['id_evento'])) {
        echo $ins_factura->agregar_factura_controlador();
    }
    
    
}
 else {
    session_start(['name'=>'SPM']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
