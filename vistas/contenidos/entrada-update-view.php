<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR ENTRADAS
	</h3>

</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>entrada-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ENTRADAS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>entrada-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ENTRADAS</a>
		</li>

	</ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
	<?php
	require_once "./controladores/entradaControlador.php";
	$ins_entrada = new entradaControlador();

	$datos_entrada = $ins_entrada->datos_entrada_controlador("Unico", $pagina[1]);
	if ($datos_entrada->rowCount() == 1) {
		$campos = $datos_entrada->fetch();

	?>
		<form class="form-neon FormularioAjax"
			action="<?php echo SERVERURL; ?>ajax/entradaiaAjax.php" method="POST" data-form="save" autocomplete="off">
			<!-- Campo oculto para registrar el usuario logueado -->
			<input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">
			<input type="hidden" name="entrada_id_up" value="<?php echo $pagina[1]; ?>">

			<fieldset>
				<legend><i class="far fa-plus-square"></i> &nbsp; Crear categoria</legend>
				<div class="container-fluid">
					<div class="row">

						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="evento_nombre" class="bmd-label-floating">Nombre de la entrada</label>
								<input value="<?php echo $campos['descripcion']; ?>" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="entrada_nombre_up" id="categoria_nombre" maxlength="140" required>
							</div>
						</div>
						<div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cupon_descuento" class="bmd-label-floating">Porcentaje de entrada</label>
                            <input  value="<?php echo $campos['cantidad']; ?>" type="number" class="form-control" name="entrada_porcentaje_up" id="entrada_porcentaje" max="100" min="0" step="0.01" required>
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