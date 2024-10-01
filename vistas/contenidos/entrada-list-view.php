  <!-- Page header -->
  <div class="full-box page-header">
      <h3 class="text-left">
          <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; TIPOS DE ENTRADAS
      </h3>
      
  </div>

  <div class="container-fluid">
      <ul class="full-box list-unstyled page-nav-tabs">
          <li>
              <a href="<?php echo SERVERURL; ?>entrada-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; CREAR ENTRADAS</a>
          </li>
          <li>
              <a class="active" href="<?php echo SERVERURL; ?>entrada-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ENTRADAS</a>
          </li>
          
      </ul>
  </div>

  <!--CONTENT-->
  <div class="container-fluid">
      <?php

        // llamando al controlador
        require_once "./controladores/entradaControlador.php";
        $ins_entrada = new entradaControlador();
        $model = new mainModel();
        
        // Obtener lista de eventos
        $listaEntradas= $ins_entrada->paginador_entrada_controlador($pagina[1], 20, "");
        
        // Inicializar la tabla
        $tabla = '<div class="table-responsive">
                     <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">                    
                                <th>NOMBRE CATEGORIA</th>   
                                <th>VALOR</th> 
                                <th>ACTUALIZAR</th>
                                <th>ELIMINAR</th>                            
                            </tr>
                        </thead>
                        <tbody>';
        
        // Verificar si hay asistentes en la lista
        if (count($listaEntradas) > 0) {
            // Iterar sobre los Categorias
            foreach ($listaEntradas as $rows) {
                $tabla .= '<tr class="text-center">
                    <td>' . $rows['descripcion'] . '</td>
                    <td>' . $rows['cantidad'] . '%</td>
                   
                    <td>
                        <a href="' . SERVERURL . 'entrada-update/' . $model->encryption($rows['id_tipo_entrada']) . '/" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . SERVERURL . 'ajax/entradaAjax.php" method="POST" data-form="delete" autocomplete="off">
                            <input type="hidden" name="entrada_id_del" value="' . $model->encryption($rows['id_tipo_entrada']) . '" >
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