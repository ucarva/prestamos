<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR ASISTENTE
	</h3>
	
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>asistente-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ASISTENTE</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>asistente-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ASISTENTE</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>asistente-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ASISTENTE</a>
		</li>
	</ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
	<?php
	require_once "./controladores/asistenteControlador.php";
	$ins_asistente = new asistenteControlador();

	$datos_asistente = $ins_asistente->datos_asistente_controlador("Unico", $pagina[1]);
	if ($datos_asistente->rowCount() == 1) {
		$campos = $datos_asistente->fetch();

	?>
		<form class="form-neon FormularioAjax " action="<?php echo SERVERURL; ?>ajax/asistenteAjax.php" method="POST" data-form="update" autocomplete="off">
			<input type="hidden" name="asistente_id_up" value="<?php echo $pagina[1]; ?>">
			<input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">
			<fieldset>
            <legend><i class="far fa-plus-square"></i> &nbsp; Información del Asistente</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="asistente_nombre" class="bmd-label-floating">Nombre</label>
                            <input  value="<?php echo $campos['nombres']; ?>" type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="asistente_nombre_up" id="asistente_nombre" maxlength="140">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="asistente_apellido" class="bmd-label-floating">Apellidos</label>
                            <input value="<?php echo $campos['apellidos']; ?>" type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="asistente_apellido_up" id="asistente_apellido" maxlength="140">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="birthdate" class="bmd-label-floating">Fecha de Nacimiento</label>
                            <input value="<?php echo $campos['fecha_nacimiento']; ?>" type="date" name="asistente_fecha_nacimiento_up" class="form-control" id="birthdate">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="asistente_email" class="bmd-label-floating">Email</label>
                            <input value="<?php echo $campos['email']; ?>" type="email" class="form-control" name="asistente_email_up" id="asistente_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="asistente_telefono" class="bmd-label-floating">Teléfono</label>
                            <input value="<?php echo $campos['celular']; ?>" type="text" pattern="[0-9()+]{8,20}" class="form-control" name="asistente_telefono_up" id="asistente_telefono" maxlength="20">
                        </div>
                    </div>


                </div>
            </div>
        </fieldset>
			<br><br><br>
			<p class="text-center" style="margin-top: 40px;">
				<button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
			</p>
		</form>
	<?php } else { ?>

		<div class="alert alert-danger text-center" role="alert">
			<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
			<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
			<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
		</div>
	<?php }  ?>
</div>