<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; INSCRIPCION EVENTO
    </h3>

</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>reservation-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO INSCRIPCION</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-reservation/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-pending/"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; INSCRIPCIONES</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-search/"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR POR FECHA</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <div class="container-fluid form-neon">
        <div class="container-fluid">
            <p class="text-center roboto-medium">AGREGAR ASISTENTE O EVENTOS</p>
            <p class="text-center">

                <?php if (empty($_SESSION['datos_asistente'])) { ?>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCliente"><i class="fas fa-user-plus"></i> &nbsp; Agregar asistente</button>
                <?php } ?>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalItem"><i class="fas fa-box-open"></i> &nbsp; Agregar evento</button>

            </p>

            <div>
                <span class="roboto-medium">CLIENTE:</span>
                <?php if (empty($_SESSION['datos_asistente'])) { ?>
                    <span class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> Seleccione un asistente</span>
                <?php } else { ?>
                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/inscripcionAjax.php" method="POST" data-form="loans" style="display: inline-block !important;">
                        <input type="hidden" name="id_eliminar_asistente" value="<?php echo  $_SESSION['datos_asistente']['ID']; ?>">
                        <?php echo $_SESSION['datos_asistente']['Nombre'] . " " . $_SESSION['datos_asistente']['Apellido'] . " "; ?>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-user-times"></i></button>
                    </form>
                <?php } ?>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>ITEM</th>
                            <th>CANTIDAD</th>
                            <th>TIEMPO</th>
                            <th>COSTO</th>
                            <th>SUBTOTAL</th>
                            <th>DETALLE</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (isset($_SESSION['datos_item']) && count($_SESSION['datos_item']) >= 1) {

                            $_SESSION['prestamo_total'] = 0;
                            $_SESSION['prestamo_item'] = 0;

                            foreach ($_SESSION['datos_item'] as $items) {
                                $subtotal = $items['Cantidad'] * ($items['Costo'] * $items['Tiempo']);

                                $subtotal = number_format($subtotal, 2, '.', '');

                        ?>
                                <tr class="text-center">
                                    <td><?php echo $items['Nombre'] ?></td>
                                    <td><?php echo $items['Cantidad'] ?></td>
                                    <td><?php echo $items['Tiempo'] . " " . $items['Formato']; ?></td>
                                    <td><?php echo MONEDA . $items['Costo'] . " x 1 " . $items['Formato']; ?></td>
                                    <td><?php echo MONEDA . $subtotal; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="<?php echo $items['Nombre'] ?>" data-content="<?php echo $items['Detalle'] ?>">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="loans" autocomplete="off">
                                            <input type="hidden" name="id_eliminar_item" value="<?php echo $items['ID']; ?>">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            <?php
                                $_SESSION['prestamo_total'] += $subtotal;
                                $_SESSION['prestamo_item'] += $items['Cantidad'];
                            }

                            ?>
                            <tr class="text-center bg-light">
                                <td><strong>TOTAL</strong></td>
                                <td><strong><?php echo $_SESSION['prestamo_item']; ?> items</strong></td>
                                <td colspan="2"></td>
                                <td><strong><?php echo MONEDA . number_format($_SESSION['prestamo_total'], 2, '.', ''); ?></strong></td>
                                <td colspan="2"></td>
                            </tr>
                        <?php } else {
                            $_SESSION['prestamo_total'] = 0;
                            $_SESSION['prestamo_item'] = 0;
                        ?>
                            <tr class="text-center">
                                <td colspan="7">no has seleccionado items</td>
                            </tr>
                        <?php }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="save" autocomplete="off">
            <fieldset>
                <legend><i class="far fa-clock"></i> &nbsp; Fecha y hora de préstamo</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_fecha_inicio">Fecha de préstamo</label>
                                <input type="date" class="form-control" name="prestamo_fecha_inicio_reg" value="<?php echo date("Y-m-d"); ?>" id="prestamo_fecha_inicio">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_hora_inicio">Hora de préstamo</label>
                                <input type="time" class="form-control" name="prestamo_hora_inicio_reg" value="<?php echo date("H:i"); ?>" id="prestamo_hora_inicio">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-history"></i> &nbsp; Fecha y hora de entrega</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_fecha_final">Fecha de entrega</label>
                                <input type="date" class="form-control" name="prestamo_fecha_final_reg" id="prestamo_fecha_final">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_hora_final">Hora de entrega</label>
                                <input type="time" class="form-control" name="prestamo_hora_final_reg" id="prestamo_hora_final">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-cubes"></i> &nbsp; Otros datos</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_estado" class="bmd-label-floating">Estado</label>
                                <select class="form-control" name="prestamo_estado_reg" id="prestamo_estado">
                                    <option value="" selected="">Seleccione una opción</option>
                                    <option value="Reservacion">Reservación</option>
                                    <option value="Prestamo">Préstamo</option>
                                    <option value="Finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_total" class="bmd-label-floating">Total a pagar en <?php echo MONEDA; ?></label>
                                <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="<?php echo number_format($_SESSION['prestamo_total'], 2, '.', ''); ?>" id="prestamo_total" maxlength="10">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_pagado" class="bmd-label-floating">Total depositado en <?php echo MONEDA; ?></label>
                                <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="prestamo_pagado_reg" id="prestamo_pagado" maxlength="10">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="prestamo_observacion" class="bmd-label-floating">Observación</label>
                                <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control" name="prestamo_observacion_reg" id="prestamo_observacion" maxlength="400">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
            </p>
        </form>
    </div>
</div>


<!-- MODAL CLIENTE -->
<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCliente">Agregar asistente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_cliente" class="bmd-label-floating">introduce el nombre del asistente</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_asistente" id="input_asistente" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_asistente">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_asistente()"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL ITEM -->
<div class="modal fade" id="ModalItem" tabindex="-1" role="dialog" aria-labelledby="ModalItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalItem">Agregar evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_item" class="bmd-label-floating">escribe el titulo del evento</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_evento" id="input_evento" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_eventos">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_evento()"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL AGREGAR ITEM -->
<div class="modal fade" id="ModalAgregarItem" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/inscripcionAjax.php" method="POST" data-form="default" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAgregarItem">Selecciona el tipo de entrada que deseas y un codigo descuento si tienes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_agregar_evento" id="id_agregar_evento">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">



                            <div class="form-group">
                                <label for="evento_entrada" class="bmd-label-floating">Tipo entrada</label>
                                <select class="form-control" name="evento_entrada" id="evento_entrada" required>
                                    <option value="">Seleccione un tipo de entrada</option>

                                    <?php
                                    // Llamando al controlador
                                    require_once "./controladores/entradaControlador.php";
                                    $ins_entrada = new entradaControlador();

                                    // Obtener lista de tipos de entrada
                                    $listaEntradas = $ins_entrada->paginador_entrada_controlador($pagina[1], 20, "");

                                    // Verificar si hay entradas en la lista
                                    if (count($listaEntradas) > 0) {
                                        // Iterar sobre las entradas
                                        foreach ($listaEntradas as $rows) {
                                            // Aquí ya no estamos encriptando el ID
                                            echo '<option value="' . $rows['id_tipo_entrada'] . '">' . $rows['descripcion'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No hay entradas disponibles</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="cupon_codigo" class="bmd-label-floating">Igresa cupón descuento</label>
                                <input type="text" pattern="[a-zA-Z0-9]{1,30}" class="form-control" name="cupon_codigo" id="cupon_codigo" maxlength="30" >
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Comprar</button>
                &nbsp; &nbsp;
                <button type="button" onclick=" modal_buscar_evento()" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<?php include_once "./vistas/inc/inscripcion.php"; ?>