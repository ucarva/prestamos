
            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; INSCRIPCION EVENTOS
                </h3>
                
            </div>

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a class="active" href="<?php echo SERVERURL;?>reservation-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA INSCRIPCION</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVERURL;?>reservation-reservation/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVERURL;?>reservation-pending/"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; INSCRIPCION</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVERURL;?>reservation-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVERURL;?>reservation-search/"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR POR FECHA</a>
                    </li>
                </ul>
            </div>

            <div class="container-fluid">
                <div class="container-fluid form-neon">
                    <div class="container-fluid">
                        <p class="text-center roboto-medium">AGREGAR EVENTO Y ASISTENTES</p>
                        <p class="text-center">

                        <?php if(empty($_SESSION['datos_asistente'])) {?>
                           
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCliente"><i class="fas fa-user-plus"></i> &nbsp; Agregar evento</button>
                        <?php } ?>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalItem"><i class="fas fa-box-open"></i> &nbsp; Agregar asistente</button>
                        
                    </p>

                        <div>
                            <span class="roboto-medium">EVENTO:</span> 
                            <?php if(empty($_SESSION['datos_cliente'])) {?>
                            <span class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> Seleccione un evento</span>
                            <?php } else{?>
                            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php"  method="POST" data-form="loans" style="display: inline-block !important;">
                                <input type="hidden" name="id_eliminar_evento" value="<?php echo  $_SESSION['datos_evento']['ID']; ?>" >
                                <?php echo $_SESSION['datos_evento']['titulo']."  (".$_SESSION['categoria_descripcion'].")";?>
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
                                  
                    <?php  if(isset($_SESSION['datos_item'])&& count($_SESSION['datos_item'])>=1){

                                    $_SESSION['prestamo_total']=0;
                                    $_SESSION['prestamo_item']=0;

                                    foreach($_SESSION['datos_item'] as $items){
                                            $subtotal=$items['Cantidad']*($items['Costo']*$items['Tiempo']);

                                            $subtotal=number_format($subtotal,2,'.','');

                        ?>
                                    <tr class="text-center" >
                                        <td><?php echo $items['Nombre']?></td>
                                        <td><?php echo $items['Cantidad']?></td>
                                        <td><?php echo $items['Tiempo']." ".$items['Formato'];?></td>
                                        <td><?php echo MONEDA.$items['Costo']." x 1 ".$items['Formato'];?></td>
                                        <td><?php echo MONEDA.$subtotal; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="<?php echo $items['Nombre']?>" data-content="<?php echo $items['Detalle']?>">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <form class="FormularioAjax" action="<?php echo SERVERURL;?>ajax/prestamoAjax.php" method="POST" data-form="loans"  autocomplete="off">
                                                <input type="hidden" name="id_eliminar_item" value="<?php echo $items['ID']; ?>">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                        <?php
                                 $_SESSION['prestamo_total']+=$subtotal;
                                 $_SESSION['prestamo_item']+=$items['Cantidad'];
                        } 
                        
                        ?>
                                    <tr class="text-center bg-light">
                                       <td><strong>TOTAL</strong></td>
                                        <td><strong><?php echo $_SESSION['prestamo_item']; ?> items</strong></td>
                                        <td colspan="2"></td>
                                        <td><strong><?php echo MONEDA.number_format($_SESSION['prestamo_total'],2,'.','');?></strong></td>
                                        <td colspan="2"></td>
                                    </tr>
                    <?php } else{
                                    $_SESSION['prestamo_total']=0;
                                    $_SESSION['prestamo_item']=0;
                    ?>
                    <tr class="text-center" >
                        <td colspan="7" >no has seleccionado items</td>                                     
                    </tr>
                     <?php } 
                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form class="FormularioAjax" action="<?php echo SERVERURL;?>ajax/inscripcionAjax.php" method="POST" data-form="save"  autocomplete="off">
                        <fieldset>
                            <legend><i class="far fa-clock"></i> &nbsp; Fecha y hora de inscripcion</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="inscripcion_fecha_inicio">Fecha de inscripcion</label>
                                            <input type="date" class="form-control" name="inscripcion_fecha_inicio_reg" value="<?php echo date("Y-m-d"); ?>" id="inscripcion_fecha_inicio">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="inscripcion_hora_inicio">Hora de inscripcion</label>
                                            <input type="time" class="form-control" name="inscripcion_hora_inicio_reg" value="<?php echo date("H:i"); ?>" id="inscripcion_hora_inicio">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend><i class="fas fa-history"></i> &nbsp; Fecha y hora de cierre</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="inscripcion_fecha_final">Fecha de cierre</label>
                                            <input type="date" class="form-control" name="inscripcion_fecha_final_reg" id="inscripcion_fecha_final">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="inscripcion_hora_final">Hora de cierre</label>
                                            <input type="time" class="form-control" name="inscripcion_hora_final_reg" id="inscripcion_hora_final">
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
                                            <label for="inscripcion_estado" class="bmd-label-floating">Estado</label>
                                            <select class="form-control" name="inscripcion_estado_reg" id="inscripcion_estado">
                                                <option value="" selected="">Seleccione una opción</option>
                                                <option value="Reservacion">Reservación</option>
                                                <option value="inscripcion">Préstamo</option>
                                                <option value="Finalizado">Finalizado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="inscripcion_total" class="bmd-label-floating">Total generado evento <?php echo MONEDA;?></label>
                                            <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="<?php echo number_format($_SESSION['inscripcion_total'],2,'.','');?>" id="inscripcion_total" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="inscripcion_pagado" class="bmd-label-floating">Total depositado en <?php echo MONEDA;?></label>
                                            <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="inscripcion_pagado_reg" id="inscripcion_pagado" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="inscripcion_observacion" class="bmd-label-floating">Observación</label>
                                            <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control" name="inscripcion_observacion_reg" id="inscripcion_observacion" maxlength="400">
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
                            <h5 class="modal-title" id="ModalCliente">Agregar evento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <label for="input_cliente" class="bmd-label-floating">Titulo del evento</label>
                                    <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_evento" id="input_evento" maxlength="30">
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


            <!-- MODAL ITEM -->
            <div class="modal fade" id="ModalItem" tabindex="-1" role="dialog" aria-labelledby="ModalItem" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalItem">Agregar item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <label for="input_item" class="bmd-label-floating">Código, Nombre</label>
                                    <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_item" id="input_item" maxlength="30">
                                </div>
                            </div>
                            <br>
                            <div class="container-fluid" id="tabla_items">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"  onclick="buscar_item()" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                            &nbsp; &nbsp;
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- MODAL AGREGAR ITEM -->
            <div class="modal fade" id="ModalAgregarItem" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarItem" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form class="modal-content FormularioAjax" action="<?php echo SERVERURL;?>ajax/prestamoAjax.php" method="POST" data-form="default"  autocomplete="off">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalAgregarItem">Selecciona el formato, cantidad de items, tiempo y costo del préstamo del item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_agregar_item" id="id_agregar_item">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="detalle_formato" class="bmd-label-floating">Formato de préstamo</label>
                                            <select class="form-control" name="detalle_formato" id="detalle_formato">
                                                <option value="Horas" selected="" >Horas</option>
                                                <option value="Dias">Días</option>
                                                <option value="Evento">Evento</option>
                                                <option value="Mes">Mes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="detalle_cantidad" class="bmd-label-floating">Cantidad de items</label>
                                            <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_cantidad" id="detalle_cantidad" maxlength="7" required="" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="detalle_tiempo" class="bmd-label-floating">Tiempo (según formato)</label>
                                            <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_tiempo" id="detalle_tiempo" maxlength="7" required="" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="detalle_costo_tiempo" class="bmd-label-floating">Costo por unidad de tiempo</label>
                                            <input type="text" pattern="[0-9.]{1,15}" class="form-control" name="detalle_costo_tiempo" id="detalle_costo_tiempo" maxlength="15" required="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" >Agregar</button>
                            &nbsp; &nbsp;
                            <button type="button" onclick=" modal_buscar_item()" class="btn btn-secondary" >Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php include_once "./vistas/inc/reservation.php";?>