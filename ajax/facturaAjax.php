<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$peticionAjax = true;
require_once "../config/APP.php";

if ( isset($_POST['id_evento']) || isset($_POST['cupon_codigo1_reg']) || isset($_POST['cupon_codigo2_reg'])  ) {

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
