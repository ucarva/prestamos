<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; CREAR CUPONES PROMOCIONALES
    </h3>

</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>cupon-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CUPON</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>cupon-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; TIPOS DE CUPONES</a>
        </li>

    </ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax"
        action="<?php echo SERVERURL; ?>ajax/cuponAjax.php" method="POST" data-form="save" autocomplete="off">
        <!-- Campo oculto para registrar el usuario logueado -->
        <input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">

        <fieldset>
            <legend><i class="far fa-plus-square"></i> &nbsp; Crear cupones de descuentos</legend>
            <div class="container-fluid">
                <div class="row">
                    <!-- Código -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cupon_codigo" class="bmd-label-floating">Código</label>
                            <input type="text" pattern="[a-zA-Z0-9]{1,30}" class="form-control" name="cupon_codigo_reg" id="cupon_codigo" maxlength="30" required>
                        </div>
                    </div>

                    <!-- Porcentaje de descuento -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cupon_descuento" class="bmd-label-floating">Porcentaje de descuento (%)</label>
                            <input type="number" class="form-control" name="cupon_descuento_reg" id="cupon_descuento" max="100" min="0" step="0.01" required>
                        </div>
                    </div>


                    <!-- Estado (Activo/Inactivo) -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cupon_estado" class="bmd-label-floating">Estado</label>
                            <select class="form-control" name="cupon_estado_reg" id="cupon_estado" required>
                                <option value="" selected="" disabled="">Seleccione una opción</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fecha de vigencia -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cupon_fecha_vigencia" class="bmd-label-floating">Fecha de vigencia</label>
                            <input type="date" class="form-control" name="cupon_fecha_vigencia_reg" id="cupon_fecha_vigencia" required>
                        </div>
                    </div>

                    <!-- Fecha de fin -->
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cupon_fecha_fin" class="bmd-label-floating">Fecha de fin</label>
                            <input type="date" class="form-control" name="cupon_fecha_fin_reg" id="cupon_fecha_fin" required>
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