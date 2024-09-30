<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ASISTENTE
    </h3>
    
</div>


<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>asistente-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ASISTENTE</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>asistente-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ASISTENTE</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>asistente-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ASISTENTE</a>
        </li>
    </ul>
</div>

<!--CONTENT-->
<?php
if (!isset($_SESSION['busqueda_asistente']) && empty($_SESSION['busqueda_asistente'])) {
?>
    <div class="container-fluid">
        <form class="form-neon FormularioAjax " action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
            <input type="hidden" name="modulo" value="asistente">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="inputSearch" class="bmd-label-floating">¿Qué asistente estas buscando?</label>
                            <input type="text" class="form-control" name="busqueda_inicial" id="inputSearch" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php } else { ?>

    <div class="container-fluid">
        <form class="form-neon FormularioAjax " action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
            <input type="hidden" name="modulo" value="asistente">
            <input type="hidden" name="eliminar_busqueda" value="eliminar">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-6">
                        <p class="text-center" style="font-size: 20px;">
                            Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_asistente']; ?>”</strong>
                        </p>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid">
    <?php
    // Llamando al controlador
    require_once "./controladores/asistenteControlador.php";
    $ins_asistente = new asistenteControlador();
    $model = new mainModel();

    // Obtener el término de búsqueda desde un formulario 
    $busqueda = isset($_SESSION['busqueda_asistente']) ? $_SESSION['busqueda_asistente'] : "";

    // Obtener lista de asistentes
    $listaAsistentes = $ins_asistente->paginador_asistente_controlador($pagina[1], 20, $busqueda);

    // Inicializar la tabla
    $tabla = '<div class="table-responsive">
                 <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">                    
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>CELULAR</th>                        
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                            <th>EVENTO</th>
                        </tr>
                    </thead>
                    <tbody>';

    // Verificar si hay asistentes en la lista
    if (count($listaAsistentes) > 0) {
        // Iterar sobre los asistentes
        foreach ($listaAsistentes as $rows) {
            $tabla .= '<tr class="text-center">
                <td>' . $rows['nombres'] . '</td>
                <td>' . $rows['apellidos'] . '</td>
                <td>' . $rows['celular'] . '</td>
                <td>
                    <a href="' . SERVERURL . 'asistente-update/' . $model->encryption($rows['id_asistente']) . '/" class="btn btn-success">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
                <td>
                    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/asistenteAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="asistente_id_del" value="' . $model->encryption($rows['id_asistente']) . '" >
                        <button type="submit" class="btn btn-warning">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>';
        }
    } else {
        // Si no hay registros, mostrar mensaje
        $tabla .= '<tr class="text-center"><td colspan="6">No hay registros en el sistema</td></tr>';
    }

    $tabla .= '</tbody>
             </table>
         </div>';

    // Mostrar la tabla
    echo $tabla;
    ?>
</div>



<?php } ?>