<?php

if ($peticionAjax) {
    require_once "../modelos/loginModelo.php";
} else {
    require_once "./modelos/loginModelo.php";
}

class loginControlador extends loginModelo
{

    //Controlador para inicar sesion
    public function iniciar_sesion_controlador()
    {

        $usuario = mainModel::limpiar_cadena($_POST['usuario_log']);
        $clave = mainModel::limpiar_cadena($_POST['clave_log']);


        //comprobar campos vacios

        if ($usuario == "" || $clave == "") {
            echo '<script>
                        Swal.fire({
                        title: "Ocurrio un error inesperado",
                        text: "Usuario y contraseña obligatorios",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                    </script>';
            exit();
        }


        //Verificar integridad de los datos

        if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)) {
            echo '<script>
            Swal.fire({
            title: "Ocurrio un error inesperado",
            text: "El Nombre de usuario no cumple con el formato solicitado",
            type: "error",
            confirmButtonText: "Aceptar"
        });
        </script>';
            exit();
        }
        if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
            echo '<script>
            Swal.fire({
            title: "Ocurrio un error inesperado",
            text: "La contraseña no cumple con el formato solicitado",
            type: "error",
            confirmButtonText: "Aceptar"
        });
        </script>';
            exit();
        }
        $clave = mainModel::encryption($clave);

        $datos_login = [
            "Usuario" => $usuario,
            "Clave" => $clave
        ];

        $datos_cuenta = loginModelo::iniciar_sesion_modelo($datos_login);

        if ($datos_cuenta->rowCount() == 1) {
            $row = $datos_cuenta->fetch();

            session_start(['name' => 'SPM']);

            $_SESSION['id_spm'] = $row['id_admin'];
            $_SESSION['nombre_spm'] = $row['usuario_nombre'];
            $_SESSION['apellido_spm'] = $row['apellido'];
            $_SESSION['usuario_spm'] = $row['telefono'];
            $_SESSION['privilegio_spm'] = $row['privilegio'];
            $_SESSION['token_spm'] = md5(uniqid(mt_rand(), true));

            return header("Location: " .SERVERURL. "home/");
        } else {
            echo '<script>
            Swal.fire({
            title: "Ocurrio un error inesperado",
            text: "El usuario o clave son incorrectas",
            type: "error",
            confirmButtonText: "Aceptar"
        });
        </script>';
            exit();
        }
    } //fin ocntrolador

    //Controlador forzar cierre de sesion sin permisos
    public function forzar_cierre_sesion_controlador()
    {
        session_unset();
        session_destroy();
        if(headers_sent()){
            return "<script> window.location.href='".SERVERURL."login/'; </script>";

        }else{
            return header("Location: " .SERVERURL. "login/");
        }
    }//fin controlador

    //Controlador para cerrar sesión
    public function cerrar_sesion_controlador(){

        session_start(['name'=>'SPM']);
        $token = mainModel::decryption($_POST['token']);
        $usuario = mainModel::decryption($_POST['usuario']);
    
        if ($token == $_SESSION['token_spm'] && $usuario == $_SESSION['usuario_spm']) {
            session_unset();
            session_destroy();
    
            // Configurar la alerta de redirección
            $alerta = [
                "Alerta" => "redireccionar",
                "URL" => SERVERURL."login/"
            ];
    
            // Retornar la respuesta como JSON
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
    
        } else {
            // Manejo de error si el token o usuario no coinciden
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se pudo cerrar la sesión en el sistema.",
                "Tipo" => "error"
            ];
    
            header('Content-Type: application/json');
            echo json_encode($alerta);
            exit();
        }
    }//fin controlador
    

}
