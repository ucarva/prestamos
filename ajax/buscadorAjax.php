<?php 
 session_start(['name'=>'SPM']);

 require_once "../config/APP.php";


 if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) ||
    isset($_POST['fecha_inicio']) || isset($_POST['fecha_final']) ){

        $data_url=[
            "asistente"=>"asistente-search",
            "evento"=>"evento-search",

            "usuario"=>"user-search",
            "cliente"=>"client-search",
            "prestamo"=>"reservation-search"
            
        ];

        if(isset($_POST['modulo'])){
            $modulo=$_POST['modulo'];
            if(!isset($data_url[$modulo])){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Error en la busqueda.",
                    "Tipo" => "error"
                ];
                header('Content-Type: application/json');
                echo json_encode($alerta);
                exit();

            }

        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No podemos continuar con la busqueda debido a un error de configuración.",
                "Tipo" => "error"
            ];
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }

        if($modulo=="prestamo"){
            //dos variables de sesión para las fechas
            $fecha_inicio="fecha_inicio_".$modulo;
            $fecha_final="fecha_final_".$modulo;

            //iniciar busqueda 
            if(isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])){

                if($_POST['fecha_inicio'] =="" || $_POST['fecha_final']=="") {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "Por favor escoge la fecha de inicio y fecha fin",
                        "Tipo" => "error"
                    ];
                    header('Content-Type: application/json');
                    echo json_encode($alerta);
                    exit();
                }
                //Definiendo variables de sección
                $_SESSION[$fecha_inicio]=$_POST['fecha_inicio'];
                $_SESSION[$fecha_final]=$_POST['fecha_final'];

            }

                //eliminar busqueda
                if(isset($_POST['eliminar_busqueda'])){
                    unset($_SESSION[$fecha_inicio]);
                    unset($_SESSION[$fecha_final]);

                }

        }else{
            $name_var="busqueda_".$modulo;

            //iniciar busqueda
            if(isset($_POST['busqueda_inicial'])){
                if($_POST['busqueda_inicial']==""){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "Por favor introduce un termino de busqueda.",
                        "Tipo" => "error"
                    ];
                    header('Content-Type: application/json');
                    echo json_encode($alerta);
                    exit();

                }
                $_SESSION[$name_var]=$_POST['busqueda_inicial'];

            }

            //eliminar busqueda
            if(isset($_POST['eliminar_busqueda'])){
                unset( $_SESSION[$name_var]);
            }  


        }

        //redireccionar usuario
        $url=$data_url[$modulo];


        $alerta=[
            "Alerta"=>"redireccionar",
            "URL"=>SERVERURL.$url."/"
        ];

        echo json_encode($alerta);
                exit();





 }else{
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
 }


