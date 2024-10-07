  <!-- Page header -->
  <div class="full-box page-header">
      <h3 class="text-left">
          <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ASISTENTES
      </h3>
      
  </div>

  <div class="container-fluid">
      <ul class="full-box list-unstyled page-nav-tabs">
          <li>
              <a href="<?php echo SERVERURL; ?>asistente-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ASISTENTE</a>
          </li>
          <li>
              <a class="active" href="<?php echo SERVERURL; ?>asistente-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ASISTENTES</a>
          </li>
          <li>
              <a href="<?php echo SERVERURL; ?>asistente-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ASISTENTE</a>
          </li>
      </ul>
  </div>

  <!--CONTENT-->
  <div class="container-fluid">
      <?php

        // llamando al controlador
        require_once "./controladores/asistenteControlador.php";
        $ins_asistente = new asistenteControlador();
        $model = new mainModel();
        
        // Obtener lista de asistentes
        $listaAsistentes = $ins_asistente->paginador_asistente_controlador($pagina[1], 20, "");
        
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