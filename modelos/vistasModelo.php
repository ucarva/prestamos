<?php

    class vistasModelo{

        //Modelo obtener vistas
        protected static function obtener_vistas_modelo($vistas){
            $listaBlanca =[
                "home","client-list","client-new","client-search","client-update","company","reservation-list","reservation-new","reservation-pending",
                "reservation-reservation","reservation-search","reservation-update","user-list","user-new","user-search","user-update",
                "asistente-list","asistente-new","asistente-search","asistente-update","asistente-search",
                "evento-list","evento-new","evento-search","evento-update","evento-search","evento-ges","categoria-list","categoria-new","categoria-update","entrada-list","entrada-new","entrada-update",
                "cupon-list","cupon-new","cupon-update","factura-new"
            ];
            if(in_array($vistas, $listaBlanca)){

                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido="./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido="404";
                }
            }elseif($vistas=="login" || $vistas=="index"){
                $contenido="login";
            }else{
                $contenido="404";
            }
            return $contenido;
        }
    }
