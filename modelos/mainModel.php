<?php

if ($peticionAjax) {
    require_once "../config/SERVER.php";
} else {
    require_once "./config/SERVER.php";
}

class mainModel
{
    //Función conectar a BDD
    protected static function conectar()
    {
        $conexion = new PDO(SGBD, USER, PASS);
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;
    }

    // Función Consultas simples para la BDD con soporte para parámetros
    protected static function ejecutar_consulta_simple($consulta, $parametros = [])
    {
        try {
            // Preparar la consulta
            $sql = self::conectar()->prepare($consulta);

            // Vincular los parámetros a la consulta, si hay alguno
            foreach ($parametros as $clave => $valor) {
                $sql->bindValue($clave, $valor);
            }

            // Ejecutar la consulta
            $sql->execute();

            // Retornar el resultado de la consulta
            return $sql;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    //Funciones para seguridad en la url encripta cadenas
    public  function encryption($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    //Funciones para seguridad en la url desencrita cadenas
    protected static function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }


    //Funcióngenerar codigos aleatorios
    protected static function generar_codigo_aleatorio($letra, $longitud, $numero)
    {
        for ($i = 1; $i <= $longitud; $i++) {
            $aleatorio = rand(0, 9);
            $letra .= $aleatorio;
        }
        return $letra . "-" . $numero;
    }

    //Función evitar inyección SQL
    protected static function limpiar_cadena($cadena)
    {
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src", "", $cadena);
        $cadena = str_ireplace("<script typr=", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE * FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("DROP TABLE", "", $cadena);
        $cadena = str_ireplace("DROP DATABASE", "", $cadena);
        $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_ireplace("SHOW TABLES", "", $cadena);
        $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena = str_ireplace("<?PHP", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace(">", "", $cadena);
        $cadena = str_ireplace("<", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(";", "", $cadena);
        $cadena = str_ireplace("::", "", $cadena);
        $cadena = str_ireplace("|", "", $cadena);


        $cadena = stripslashes($cadena);
        $cadena = trim($cadena);

        return $cadena;
    }
    //Función verificar datos 
    protected static function verificar_datos($filtro, $cadena)
    {
        if (preg_match("/^" . $filtro . "$/", $cadena)) {
            return false;
        } else {
            return true;
        }
    }

    //Función validar fechas
    protected static function verificar_fecha($fecha)
    {
        $valores = explode('-', $fecha);
        if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])) {
            return true;  // Fecha válida
        } else {
            return false; // Fecha no válida
        }
    }
    protected static function verificar_hora($hora)
    {
        // Registrar la hora que se va a validar
        error_log("Hora a validar: " . $hora);

        if (preg_match("/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/", $hora)) {
            return false;  // Hora válida
        } else {
            return true;   // Hora no válida
        }
    }


    //función para paginación
    protected static function paginador_tablas($pagina, $Npaginas, $url, $botones)
    {
        $tabla = '<nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">';

        if ($pagina == 1) {
            $tabla .= '
                        <li class="page-item disabled">
                            <a class="page-link">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>';
        } else {
            $tabla .= '
                        <li class="page-item">
                            <a class="page-link" href="' . $url . '1/">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="' . $url . ($pagina - 1) . '/">Anterior</a>
                        </li>';
        }


        $ci = 0;
        for ($i = $pagina; $i <= $Npaginas; $i++) {
            if ($ci >= $botones) {
                break;
            }

            if ($pagina == $i) {
                $tabla .= '<li class="page-item "><a class="page-link active" href="' . $url . $i . '/" 
                >' . $i . '</a></li>';
            } else {
                $tabla .= '<li class="page-item "><a class="page-link " href="' . $url . $i . '/" 
                    >' . $i . '</a></li>';
            }

            $ci++;
        }


        if ($pagina == $Npaginas) {
            $tabla .= '<li class="page-item disabled"><a class="page-link" 
                ><li class="fas fa-angle-double-rigth"></li></a></li>';
        } else {
            $tabla .= '
                <li class="page-item "><a class="page-link" href="' . $url . ($pagina + 1) . '/" 
                >Siguiente</a></li>
                <li class="page-item "><a class="page-link" href="' . $url . $Npaginas . '/" 
                ><li class="fas fa-angle-double-rigth"></li></a></li>         
                ';
        }

        $tabla .= '</ul></nav>';

        return $tabla;
    }
}
