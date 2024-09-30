<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR CUPONES
	</h3>

</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>cupon-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CUPONES</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>cupon-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CUPONES</a>
		</li>

	</ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
	<?php
	require_once "./controladores/cuponControlador.php";
	$ins_cupon = new cuponControlador();

	$datos_cupon = $ins_cupon->datos_cupon_controlador("Unico", $pagina[1]);
	if ($datos_cupon->rowCount() == 1) {
		$campos = $datos_cupon->fetch();

	?>
<div class="container-fluid">
	<form class="form-neon FormularioAjax"
		action="<?php echo SERVERURL; ?>ajax/cuponAjax.php" method="POST" data-form="save" autocomplete="off">
		<!-- Campo oculto para registrar el usuario logueado -->
		<input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">
		<input type="hidden" name="cupon_id_up" value="<?php echo $pagina[1]; ?>">

		<fieldset>
			<legend><i class="far fa-plus-square"></i> &nbsp; Actualizar cupones de descuentos</legend>
			<div class="container-fluid">
				<div class="row">
					<!-- Código -->
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="cupon_codigo" class="bmd-label-floating">Código</label>
							<input value="<?php echo $campos['codigo']; ?>" type="text" pattern="[a-zA-Z0-9]{1,30}" class="form-control" name="cupon_codigo_up" id="cupon_codigo" maxlength="30" required>
						</div>
					</div>

					<!-- Porcentaje de descuento -->
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="cupon_descuento" class="bmd-label-floating">Porcentaje de descuento (%)</label>
							<input value="<?php echo $campos['porcentaje_descuento']; ?>" type="number" class="form-control" name="cupon_descuento_up" id="cupon_descuento" max="100" min="0" step="0.01" required>
						</div>
					</div>


					<!-- Estado (Activo/Inactivo) -->
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="cupon_estado" class="bmd-label-floating">Estado</label>
							<select class="form-control" name="cupon_estado_up" id="cupon_estado" required>
								<option value="" disabled="">Seleccione una opción</option>
								<option value="Activo" <?php echo ($campos == "Activo") ? 'selected' : ''; ?>>Activo</option>
								<option value="Inactivo" <?php echo ($campos == "Inactivo") ? 'selected' : ''; ?>>Inactivo</option>
							</select>
						</div>
					</div>


					<!-- Fecha de vigencia -->
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="cupon_fecha_vigencia" class="bmd-label-floating">Fecha de vigencia</label>
							<input value="<?php echo $campos['fecha_vigencia_inicio']; ?>" type="date" class="form-control" name="cupon_fecha_vigencia_up" id="cupon_fecha_vigencia" required>
						</div>
					</div>

					<!-- Fecha de fin -->
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="cupon_fecha_fin" class="bmd-label-floating">Fecha de fin</label>
							<input value="<?php echo $campos['fecha_vigencia_fin']; ?>" type="date" class="form-control" name="cupon_fecha_fin_up" id="cupon_fecha_fin" required>
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
	<?php } else { ?>
		<div class="alert alert-danger text-center" role="alert">
			<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
			<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
			<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
		</div>
	<?php }  ?>
</div>