  <!-- Page header -->
  <div class="full-box page-header">
      <h3 class="text-left">
          <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE EVENTOS
      </h3>

  </div>

  <div class="container-fluid">
      <ul class="full-box list-unstyled page-nav-tabs">
          <li>
              <a href="<?php echo SERVERURL; ?>evento-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR EVENTOS</a>
          </li>
          <li>
              <a class="active" href="<?php echo SERVERURL; ?>evento-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE EVENTOS</a>
          </li>
          <li>
              <a href="<?php echo SERVERURL; ?>evento-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTOS</a>
          </li>
      </ul>
  </div>

  <!--CONTENT-->
  <div class="container-fluid">
      <?php

        // llamando al controlador
        require_once "./controladores/eventoControlador.php";
        $ins_evento = new eventoControlador();
        $model = new mainModel();

        // Obtener lista de eventos
        $listaEventos = $ins_evento->paginador_evento_controlador($pagina[1], 20, "");

        // Inicializar la tabla
        $tabla = '<div class="table-responsive">
                     <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">                    
                                <th>NOMBRE</th>
                                <th>DESCRIPCION</th>
                                <th>HORA</th>                        
                                <th>VALOR EVENTO</th>
                                <th>CATEGORIA</th>
                                <th>LUGAR</th>
                                <th>CUPO PERSONAS</th>
                                <th>ESTADO</th>
                                <th>FECHA APERTURA</th>   
                                <th>FECHA CIERRE</th>   
                                <th>TIPO</th>  
                                <th>DETALLE</th>                       
                                
                                <th>EDITAR</th>                        
                                <th>ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>';

        // Verificar si hay asistentes en la lista
        if (count($listaEventos) > 0) {
            // Iterar sobre los Eventos
            foreach ($listaEventos as $rows) {
                $tabla .= '<tr class="text-center">
                            <td>' . $rows['titulo'] . '</td>
                            <td>' . $rows['descripcion'] . '</td>
                            <td>' . $rows['hora'] . '</td>
                            <td>' . $rows['valor_base'] . '</td>
                            <td>' . $rows['categoria_descripcion'] . '</td> 
                            <td>' . $rows['lugar'] . '</td>
                            <td>' . $rows['cupo'] . '</td>
                            <td>' . $rows['estado'] . '</td>
                            <td>' . $rows['fecha_apertura'] . '</td>
                            <td>' . $rows['fecha_cierre'] . '</td>
                            <td>' . $rows['es_entrada_gratis'] . '</td>
                            <td>
                        <a href="' . SERVERURL . 'factura-new/' . $model->encryption($rows['id_evento']) . '/" class="btn btn-success">
                            <i class="fas fa-list"></i>
                        </a>
                    </td>
                            
                                    
                    <td>
                        <a href="' . SERVERURL . 'evento-update/' . $model->encryption($rows['id_evento']) . '" class="btn btn-success">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . SERVERURL . 'ajax/eventoAjax.php" method="POST" data-form="delete" autocomplete="off">
                            <input type="hidden" name="evento_id_del" value="' . $model->encryption($rows['id_evento']) . '" >
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