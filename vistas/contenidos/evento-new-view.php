<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR EVENTO
    </h3>

</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>evento-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR EVENTO</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>evento-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE EVENTOS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>evento-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTOS</a>
        </li>
    </ul>
</div>

<!--CONTENT-->

<div class="container-fluid">
    <form class="form-neon FormularioAjax "
        action="<?php echo SERVERURL;  ?>ajax/eventoAjax.php" method="POST" data-form="save" autocomplete="off">
        <!-- Campo oculto para registrar el usuario logueado -->
        <input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">

        <fieldset>
            <legend><i class="far fa-plus-square"></i> &nbsp; Información del Evento</legend>
            <div class="container-fluid">
                <div class="row">
                    <!-- Nombre del Evento -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="evento_nombre" class="bmd-label-floating">Nombre del Evento</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="evento_nombre_reg" id="evento_nombre" maxlength="140" required>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="evento_descripcion" class="bmd-label-floating">Descripción</label>
                            <textarea class="form-control" name="evento_descripcion_reg" id="evento_descripcion" rows="3" required></textarea>
                        </div>
                    </div>

                    <!-- Hora del Evento -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="evento_hora" class="bmd-label-floating">Hora del Evento</label>
                            <input type="time" class="form-control" name="evento_hora_reg" id="evento_hora" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="evento_fecha_inicio">Fecha de apertura</label>
                            <input type="date" class="form-control" name="evento_fecha_inicio_reg" value="<?php echo date("Y-m-d"); ?>" id="evento_fecha_inicio">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="evento_fecha_cierre">Fecha de cierre</label>
                            <input type="date" class="form-control" name="evento_fecha_cierre_reg" value="<?php echo date("Y-m-d"); ?>" id="evento_fecha_cierre">
                        </div>
                    </div>

                    <!-- Valor Base -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="evento_valor" class="bmd-label-floating">Valor Base</label>
                            <input type="number" class="form-control" name="evento_valor_reg" id="evento_valor" min="0" required>
                        </div>
                    </div>

                    <!-- Lugar -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="evento_lugar" class="bmd-label-floating">Lugar del evento</label>
                            <input type="text" required pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control" name="evento_lugar_reg" id="empresa_nombre" maxlength="70">
                        </div>
                    </div>

                    <!-- Categoría -->
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="evento_categoria" class="bmd-label-floating">Categoría</label>
                            <select class="form-control" name="evento_categoria_reg" id="evento_categoria" required>
                                <option value="">Seleccionar categoría</option>

                                <?php
                                // llamando al controlador
                                require_once "./controladores/categoriaControlador.php";
                                $ins_evento = new categoriaControlador();
                                $model = new mainModel();

                                // Obtener lista de categorías
                                $listaCategorias = $ins_evento->paginador_categoria_controlador($pagina[1], 20, "");

                                // Verificar si hay categorías en la lista
                                if (count($listaCategorias) > 0) {
                                    // Iterar sobre las categorías
                                    foreach ($listaCategorias as $rows) {
                                        echo '<option value="' . $rows['id_categoria'] . '">' . $rows['descripcion'] . '</option>';
                                    }
                                } else {

                                    echo '<option value="">No hay categorías disponibles</option>';
                                }
                                ?>


                            </select>

                        </div>
                    </div>


                    <!-- Cupo -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="evento_stock" class="bmd-label-floating">Cupo de evento</label>
                            <input type="num" pattern="[0-9]{1,9}" class="form-control" name="evento_cupo_reg" id="evento_stock" maxlength="9">
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="evento_estado" class="bmd-label-floating">Estado del evento</label>
                            <select class="form-control" name="evento_estado_reg" id="evento_estado">
                                <option value="" selected="" disabled="">Seleccione una opción</option>
                                <option value="Habilitado">Habilitado</option>
                                <option value="Deshabilitado">Deshabilitado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tipo de Evento -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="evento_tipo_entrada" class="bmd-label-floating">Tipo entrada evento</label>
                            <select class="form-control" name="evento_tipo_entrada_reg" id="evento_tipo_entrada">
                                <option value="" selected="" disabled="">Seleccione una opción</option>
                                <option value="0">Pago</option>
                                <option value="1">Gratis</option>
                            </select>
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