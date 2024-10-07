

<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ASISTENTE
    </h3>
    
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>asistente-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ASISTENTE</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>asistente-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ASISTENTES</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>asistente-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ASISTENTE</a>
        </li>
    </ul>
</div>

<!--CONTENT-->

<div class="container-fluid">
    <form class="form-neon FormularioAjax"
        action="<?php echo SERVERURL; ?>ajax/asistenteAjax.php" method="POST" data-form="save" autocomplete="off">
        <!-- Campo oculto para registrar el usuario logueado -->
        <input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">
        

        <fieldset>
            <legend><i class="far fa-plus-square"></i> &nbsp; Información del Asistente</legend>
            <div class="container-fluid">

            <input type="hidden" name="asistente_activo_reg" value="1"> <!-- Campo oculto para activo -->
                
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="asistente_nombre" class="bmd-label-floating">Nombre</label>
                            <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="asistente_nombre_reg" id="asistente_nombre" maxlength="140">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="asistente_apellido" class="bmd-label-floating">Apellidos</label>
                            <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="asistente_apellido_reg" id="asistente_apellido" maxlength="140">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="birthdate" class="bmd-label-floating">Fecha de Nacimiento</label>
                            <input type="date" name="asistente_fecha_nacimiento_reg" class="form-control" id="birthdate">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="asistente_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="asistente_email_reg" id="asistente_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="asistente_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="asistente_telefono_reg" id="asistente_telefono" maxlength="20">
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