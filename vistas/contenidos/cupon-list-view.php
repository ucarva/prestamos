  <!-- Page header -->
  <div class="full-box page-header">
      <h3 class="text-left">
          <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; TIPOS DE CUPONES
      </h3>
      
  </div>

  <div class="container-fluid">
      <ul class="full-box list-unstyled page-nav-tabs">
          <li>
              <a href="<?php echo SERVERURL; ?>cupon-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; CREAR CUPON</a>
          </li>
          <li>
              <a class="active" href="<?php echo SERVERURL; ?>cupon-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CUPONES</a>
          </li>
          
      </ul>
  </div>

  <!--CONTENT-->
  <div class="container-fluid">
      <?php

        // llamando al controlador
        require_once "./controladores/cuponControlador.php";
        $ins_cupon = new cuponControlador();
        $model = new mainModel();
        
        // Obtener lista de eventos
        $listaCupones= $ins_cupon->paginador_cupon_controlador($pagina[1], 20, "");
        
        // Inicializar la tabla
        $tabla = '<div class="table-responsive">
                     <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">                    
                                <th>NOMBRE DEL CUPON</th>   
                                <th>DESCUENTO </th>
                                <th>ESTADO</th>    
                                <th>FECHA INICIO</th>   
                                <th>FECHA FIN</th>
                                <th>EDITAR</th> 
                                <th>ELIMINAR</th>                           
                            </tr>
                        </thead>
                        <tbody>';
        
        // Verificar si hay asistentes en la lista
        if (count($listaCupones) > 0) {
            // Iterar sobre los Categorias
            foreach ($listaCupones as $rows) {
                $tabla .= '<tr class="text-center">
                    <td>' . $rows['codigo'] . '</td>
                    <td>' . $rows['porcentaje_descuento'] . '%</td>
                    <td>' . $rows['estado'] . '</td>
                    <td>' . $rows['fecha_vigencia_inicio'] . '</td>
                    <td>' . $rows['fecha_vigencia_fin'] . '</td>
                   
                    <td>
                        <a href="' . SERVERURL . 'cupon-update/' . $model->encryption($rows['id_codigo']) . '/" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . SERVERURL . 'ajax/cuponAjax.php" method="POST" data-form="delete" autocomplete="off">
                            <input type="hidden" name="cupon_id_del" value="' . $model->encryption($rows['id_codigo']) . '" >
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