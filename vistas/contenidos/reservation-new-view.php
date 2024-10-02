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

<?php
require_once "./controladores/eventoControlador.php";
$ins_evento = new eventoControlador();



$datos_evento = $ins_evento->datos_evento_controlador("Unico", $pagina[1]);
if ($datos_evento->rowCount() == 1) {
    $campos = $datos_evento->fetch();

    

?>


<div class="container-fluid">
    <div class="container-fluid form-neon">
        <div class="container-fluid">
            <p class="text-center roboto-medium">AGREGAR ASISTENTE O EVENTOS</p>
            <p class="text-center">

                <?php if (empty($_SESSION['datos_asistente'])) { ?>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCliente"><i class="fas fa-user-plus"></i> &nbsp; Agregar asistente</button>
                <?php } ?>

            </p>

            <div>
                <span class="roboto-medium">ASISTENTE:</span>
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
           
        </div>


        
        <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="save" autocomplete="off">
           
          
        <legend><i class="far fa-plus-square"></i> &nbsp; Información del evento</legend>
        <div class="container-fluid">
            <div class="row">
                <!-- Nombre del Evento -->
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="evento_nombre" class="bmd-label-floating">Nombre del Evento</label>
                        <input value="<?php echo $campos['titulo']; ?>" type="text" class="form-control" name="compra_nombre_reg" id="compra_nombre" maxlength="140" required readonly>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="evento_descripcion" class="bmd-label-floating">Descripción</label>
                        <textarea class="form-control" name="compra_descripcion_reg" id="compra_descripcion" rows="3" required readonly><?php echo htmlspecialchars($campos['descripcion']); ?></textarea>
                    </div>
                </div>

                <!-- Hora del Evento -->
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="evento_hora" class="bmd-label-floating">Hora del Evento</label>
                        <input value="<?php echo $campos['hora']; ?>" type="time" class="form-control" name="compra_hora_reg" id="compra_hora" required readonly>
                    </div>
                </div>

                <!-- Fecha de apertura -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="evento_fecha_inicio">Fecha de apertura</label>
                        <input value="<?php echo $campos['fecha_apertura']; ?>" type="date" class="form-control" name="compra_fecha_inicio_reg" id="evento_fecha_inicio" readonly>
                    </div>
                </div>

                <!-- Fecha de cierre -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="evento_fecha_cierre">Fecha de cierre</label>
                        <input value="<?php echo $campos['fecha_cierre']; ?>" type="date" class="form-control" name="evento_fecha_cierre_up" id="evento_fecha_cierre" readonly>
                    </div>
                </div>

                <!-- Valor Base -->
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="evento_valor" class="bmd-label-floating">Valor Base</label>
                        <input value="<?php echo $campos['valor_base']; ?>" type="number" class="form-control" name="evento_valor_base_reg" id="evento_valor" min="0" required readonly>
                    </div>
                </div>

                <!-- Lugar -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="evento_lugar" class="bmd-label-floating">Lugar del evento</label>
                        <input value="<?php echo $campos['lugar']; ?>" type="text" class="form-control" name="evento_lugar_reg" id="evento_lugar" maxlength="70" required readonly>
                    </div>
                </div>

                <!-- Categoría -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="evento_categoria" class="bmd-label-floating">Categoría</label>
                        <select class="form-control" name="evento_categoria_up" id="evento_categoria" required disabled>
                            <option value="">Seleccionar categoría</option>
                            <?php
                            foreach ($listaCategorias as $rows) {
                                $selected = ($rows['id_categoria'] == $campos['id_categoria']) ? 'selected' : '';
                                echo '<option value="' . $rows['id_categoria'] . '" ' . $selected . '>' . $rows['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Cupo -->
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="evento_stock" class="bmd-label-floating">Cupo de evento</label>
                        <input value="<?php echo $campos['cupo']; ?>" type="number" class="form-control" name="evento_cupo1_reg" id="evento_stock" maxlength="9" required readonly>
                    </div>
                </div>

                <!-- Estado -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="evento_estado" class="bmd-label-floating">Estado del evento</label>
                        <select class="form-control" name="evento_estado_reg" id="evento_estado" required disabled>
                            <option value="Habilitado" <?php echo ($campos['estado'] == 'Habilitado') ? 'selected' : ''; ?>>Habilitado</option>
                            <option value="Deshabilitado" <?php echo ($campos['estado'] == 'Deshabilitado') ? 'selected' : ''; ?>>Deshabilitado</option>
                        </select>
                    </div>
                </div>

                <!-- Tipo evento -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="evento_tipo_entrada" class="bmd-label-floating">Tipo evento</label>

                        <select class="form-control" name="" id="evento_tipo_entrada" required disabled>
                            <option value="Pago" <?php echo ($campos['es_entrada_gratis'] == '0') ? 'selected' : ''; ?>>Pago</option>
                            <option value="Gratis" <?php echo ($campos['es_entrada_gratis'] == '1') ? 'selected' : ''; ?>>Gratis</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>



        <?php
        if ($campos['es_entrada_gratis'] == '0') {
        ?>

            <div class="col-12 col-md-6">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="evento_entrada" class="bmd-label-floating">Entradas</label>
                        <select class="form-control" name="porcentaje_entrada_reg" id="evento_categoria" required>
                            <option value="">Selecciona una entrada</option>

                            <?php
                            // llamando al controlador
                            require_once "./controladores/entradaControlador.php";
                            $ins_evento = new entradaControlador();
                            $model = new mainModel();

                            // Obtener lista de categorías
                            $listaentradas = $ins_evento->paginador_entrada_controlador($pagina[1], 20, "");

                            // Verificar si hay categorías en la lista
                            if (count($listaentradas) > 0) {
                                // Iterar sobre las categorías
                                foreach ($listaentradas as $rows) {
                                    echo '<option value="' . $rows['id_tipo_entrada'] . '' . $rows['cantidad'] . '">' . $rows['descripcion'] . '</option>';
                                }
                            } else {

                                echo '<option value="">No hay categorías disponibles</option>';
                            }
                            ?>


                        </select>

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="cupon_codigo1" class="bmd-label-floating">Ingrese cupon uno</label>
                        <input type="text" pattern="[a-zA-Z0-9]{1,30}" class="form-control" name="cupon_codigo1_reg" id="cupon_codigo1" maxlength="30">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="cupon_codigo2" class="bmd-label-floating">Ingrese cupon dos</label>
                        <input type="text" pattern="[a-zA-Z0-9]{1,30}" class="form-control" name="cupon_codigo2_reg" id="cupon_codigo2" maxlength="30">
                    </div>
                </div>
            </div>

            <p class="text-center" style="margin-top: 40px;">


                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; VALIDAR CUPONES</button>
            </p>


            <?php
            // Llamando al controlador
            require_once "./controladores/facturaControlador.php";
            $ins_factura = new facturaControlador();
            $model = new mainModel();

            // Inicializa el valor total
            $valorTotal = 0;

            // Verifica si el formulario ha sido enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $valorTotal = $ins_factura->validar_cupones();
            }
            ?>

            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_valor" class="bmd-label-floating">Valor total</label>
                    <input value="<?php echo $valorTotal; ?>" type="number" class="form-control" name="evento_valor_up" id="evento_valor" min="0" required readonly>
                </div>
            </div>


            </div>
        <?php }  ?>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">

            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; COMPRAR</button>
        </p>
        </form>
        <?php } else { ?>

<div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
    <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
</div>
</div>
<?php }  ?>
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
<?php include_once "./vistas/inc/inscripcion.php"; ?>