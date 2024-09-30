<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; CREAR ENTRADA
    </h3>

</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>entrada-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ENTRADA</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>entrada-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; TIPOS DE ENTRADAS</a>
        </li>

    </ul>
</div>

<!--CONTENT-->

<div class="container-fluid">
    <form class="form-neon FormularioAjax"
        action="<?php echo SERVERURL; ?>ajax/entradaAjax.php" method="POST" data-form="save" autocomplete="off">
        <!-- Campo oculto para registrar el usuario logueado -->
        <input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">

        <fieldset>
            <legend><i class="far fa-plus-square"></i> &nbsp; Crear entrada</legend>
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="evento_nombre" class="bmd-label-floating">Tipo de entrada</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="entrada_nombre_reg" id="entrada_nombre" maxlength="140" required>
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