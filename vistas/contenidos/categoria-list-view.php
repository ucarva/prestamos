  <!-- Page header -->
  <div class="full-box page-header">
      <h3 class="text-left">
          <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CATEGORIAS
      </h3>
      
  </div>

  <div class="container-fluid">
      <ul class="full-box list-unstyled page-nav-tabs">
          <li>
              <a href="<?php echo SERVERURL; ?>categoria-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CATEGORIAS</a>
          </li>
          <li>
              <a class="active" href="<?php echo SERVERURL; ?>categoria-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CATEGORIAS</a>
          </li>
          
      </ul>
  </div>

  <!--CONTENT-->
  <div class="container-fluid">
      <?php

        // llamando al controlador
        require_once "./controladores/categoriaControlador.php";
        $ins_evento = new categoriaControlador();
        $model = new mainModel();
        
        // Obtener lista de eventos
        $listaCategorias= $ins_evento->paginador_categoria_controlador($pagina[1], 20, "");
        
        // Inicializar la tabla
        $tabla = '<div class="table-responsive">
                     <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">                    
                                <th>NOMBRE CATEGORIA</th>   
                                <th>ACTUALIZAR</th>
                                <th>ELIMINAR</th>                            
                            </tr>
                        </thead>
                        <tbody>';
        
        // Verificar si hay asistentes en la lista
        if (count($listaCategorias) > 0) {
            // Iterar sobre los Categorias
            foreach ($listaCategorias as $rows) {
                $tabla .= '<tr class="text-center">
                    <td>' . $rows['descripcion'] . '</td>
                   
                    <td>
                        <a href="' . SERVERURL . 'categoria-update/' . $model->encryption($rows['id_categoria']) . '/" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . SERVERURL . 'ajax/eventoAjax.php" method="POST" data-form="delete" autocomplete="off">
                            <input type="hidden" name="categoria_id_del" value="' . $model->encryption($rows['id_categoria']) . '" >
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