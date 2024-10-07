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
            <a href="<?php echo SERVERURL; ?>evento-list/"><i class="far fa-calendar-alt"></i> &nbsp; LISTA EVENTOS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>evento-new/"><i class="fas fa-plus  fa-fw"></i> &nbsp; AGREGAR EVENTO</a>
        </li>

        <li>
            <a href="<?php echo SERVERURL; ?>evento-search/"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR EVENTO</a>
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
                            <input type="hidden" name="id_eliminar_asistente" value="<?php echo $_SESSION['datos_asistente']['ID']; ?>">
                            <?php echo $_SESSION['datos_asistente']['Nombre'] . " " . $_SESSION['datos_asistente']['Apellido'] . " "; ?>
                            <button type="submit" class="btn btn-danger"><i class="fas fa-user-times"></i></button>
                        </form>
                    <?php } ?>
                </div>
            </div>

            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/facturaAjax.php" method="POST" data-form="save" autocomplete="off">
                <!-- Campo oculto para el id del evento -->
                <input type="hidden" name="id_evento" value="<?php echo $campos['id_evento']; ?>">
                <!-- Campo oculto para el id del asistente -->
                <?php if (isset($_SESSION['datos_asistente']['ID'])) { ?>
                    <input type="hidden" name="id_asistente" value="<?php echo $_SESSION['datos_asistente']['ID']; ?>">
                <?php } else { ?>
                    <input type="hidden" name="id_asistente" value="0"> <!-- Valor predeterminado si no hay asistente -->
                <?php } ?>

                <!-- Campo oculto para registrar el usuario logueado (id_admin) -->
                <input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">
                <input type="hidden" name="asistente_activo" value="1"> <!-- Campo oculto para activo -->


                <legend><i class="far fa-plus-square"></i> &nbsp; Información del evento</legend>
                <div class="container-fluid">
                    <div class="row">
                        <!-- Información del evento (lectura) -->
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="evento_nombre" class="bmd-label-floating">Nombre del Evento</label>
                                <input value="<?php echo $campos['titulo']; ?>" type="text" class="form-control" name="evento_nombre" id="evento_nombre" required readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="evento_descripcion" class="bmd-label-floating">Descripción</label>
                                <textarea class="form-control" name="evento_descripcion" id="evento_descripcion" rows="3" required readonly><?php echo htmlspecialchars($campos['descripcion']); ?></textarea>
                            </div>
                        </div>
                        <!-- Tipo de Entrada (id_tipo_entrada) -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="evento_tipo_entrada" class="bmd-label-floating">Tipo de evento</label>
                                <input type="text" class="form-control" id="evento_tipo_entrada" value="<?php echo ($campos['es_entrada_gratis'] == '0') ? 'Pago' : 'Gratis'; ?>" readonly>

                                <!-- Campo oculto para enviar el tipo de entrada a la base de datos -->
                                <input type="hidden" name="id_tipo_entrada" value="<?php echo ($campos['es_entrada_gratis'] == '0') ? 'Pago' : 'Gratis'; ?>">
                            </div>
                        </div>
                        <?php
                        require_once "./controladores/facturaControlador.php";
                        $ins_factura = new facturaControlador();
                        ?>
                        <!-- Mostrar campos de cupones solo si el evento no es gratis -->
                        <?php if ($campos['es_entrada_gratis'] == '0') { ?>
                            <div class="container mt-5">
                                <h2 class="text-center">Validación de Códigos de Cupón</h2>
                                <div class="row justify-content-center">
                                    <!-- Cupón 1 -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cupon_codigo1_reg">Código de Cupón 1</label>
                                            <input type="text" class="form-control" name="" id="cupon_codigo1_reg" placeholder="Introduce tu código de cupón">
                                        </div>
                                        <button type="button" class="btn btn-info" id="boton_cupon1" onclick="validarCupon('cupon_codigo1_reg', 'boton_cupon1')">Validar Cupón 1</button>
                                    </div>
                                    <!-- Cupón 2 -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cupon_codigo2_reg">Código de Cupón 2</label>
                                            <input type="text" class="form-control" name="" id="cupon_codigo2_reg" placeholder="Introduce tu código de cupón">
                                        </div>
                                        <button type="button" class="btn btn-info" id="boton_cupon2" onclick="validarCupon('cupon_codigo2_reg', 'boton_cupon2')">Validar Cupón 2</button>
                                    </div>
                                </div>
                                <div id="alert-container" class="mt-3"></div>
                            </div>
                            <?php include_once "./vistas/inc/cupones.php"; ?>
                        <?php } ?>
                        <!-- Tipo de Entrada -->
                        <?php if ($campos['es_entrada_gratis'] == '0') { ?>
                            <div class="container-fluid">
                                <div class="form-group">
                                    <label for="evento_entrada" class="bmd-label-floating">Tipo entrada</label>
                                    <select class="form-control" name="id_tipo_entrada" id="evento_entrada" required>
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
                                                if (!empty($rows['id_tipo_entrada']) && !empty($rows['descripcion'])) {
                                                    echo '<option value="' . htmlspecialchars($rows['id_tipo_entrada']) . '"' .
                                                        (($rows['id_tipo_entrada'] == $campos['id_tipo_entrada']) ? ' selected' : '') .
                                                        '>' . htmlspecialchars($rows['descripcion']) . '</option>';
                                                }
                                            }
                                        } else {
                                            echo '<option value="">No hay entradas disponibles</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-info" id="boton_entrada" onclick="validarEntrada('evento_entrada', 'boton_entrada')">Validar entrada</button>
                            </div>
                            <?php include_once "./vistas/inc/cupones.php"; ?>

                        <?php } ?>
                        <?php if ($campos['es_entrada_gratis'] == '0') { ?>
                            <!-- Mostrar el valor total con descuento aplicado -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="valor_total" class="bmd-label-floating">Valor total a pagar</label>

                                    <input value="<?php echo $campos['valor_base']; ?>" type="number" class="form-control" name="valor_pago" id="valor_total" min="0" readonly>
                                </div>
                            </div>

                        <?php } ?>
                        <!-- Valor Pago (valor_pago) -->

                        <?php if ($campos['es_entrada_gratis'] == '0') { ?>
                            <!-- Mostrar el valor total con descuento aplicado -->
                            <div class="col-12 col-md-4">
                                <div class="form-group ">
                                    <label for="valor_pago" class="bmd-label-floating">Valor evento</label>
                                    <input value="<?php echo ($campos['es_entrada_gratis'] == '1') ? '0' : $campos['valor_base']; ?>" type="number" class="form-control" name="" id="valor_pago" min="0" required readonly>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Estado del Pago (estado_pago) -->
                        <?php if ($campos['es_entrada_gratis'] == '0') { ?>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="estado_pago" class="bmd-label-floating">Estado del Pago</label>
                                    <select class="form-control" name="estado_pago" id="estado_pago" required>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="pagado">Pagado</option>
                                    </select>
                                </div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="estado_pago" value="Gratis"> <!-- Se envía "Gratis" si el evento es gratis -->
                        <?php } ?>

                        <!-- Resto de los campos -->
                    </div>
                </div>

                <p class="text-center" style="margin-top: 40px;">
                    <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; REGISTRAR</button>
                </p>
            </form>


        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
<?php } ?>

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
                        <label for="input_asistente" class="bmd-label-floating">introduce el nombre del asistente</label>
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