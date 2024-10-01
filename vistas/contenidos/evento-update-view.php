<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR EVENTO
	</h3>

</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>evento-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR EVENTO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>evento-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE EVENTOS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>evento-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTO</a>
		</li>
	</ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
	<?php
	require_once "./controladores/eventoControlador.php";
	$ins_evento = new eventoControlador();

	$datos_evento = $ins_evento->datos_evento_controlador("Unico", $pagina[1]);
	if ($datos_evento->rowCount() == 1) {
		$campos = $datos_evento->fetch();

	?>
		<form class="form-neon FormularioAjax " action="<?php echo SERVERURL; ?>ajax/eventoAjax.php" method="POST" data-form="update" autocomplete="off">
			<input type="hidden" name="evento_id_up" value="<?php echo $pagina[1]; ?>">
			<input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">
			<fieldset>
				<legend><i class="far fa-plus-square"></i> &nbsp; Información del evento</legend>
				<div class="container-fluid">
					<div class="row">
						<!-- Nombre del Evento -->
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="evento_nombre" class="bmd-label-floating">Nombre del Evento</label>
								<input value="<?php echo $campos['titulo']; ?>" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="evento_nombre_up" id="evento_nombre" maxlength="140" required>
							</div>
						</div>

						<!-- Descripción -->
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="evento_descripcion" class="bmd-label-floating">Descripción</label>
								<textarea class="form-control" name="evento_descripcion_up" id="evento_descripcion" rows="3" required><?php echo htmlspecialchars($campos['descripcion']); ?></textarea>
							</div>
						</div>


						<!-- Hora del Evento -->
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="evento_hora" class="bmd-label-floating">Hora del Evento</label>
								<input value="<?php echo $campos['hora']; ?>" type="time" class="form-control" name="evento_hora_up" id="evento_hora" required>
							</div>
						</div>
						<div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="evento_fecha_inicio">Fecha de apertura</label>
                            <input value="<?php echo $campos['fecha_apertura']; ?>" type="date" class="form-control" name="evento_fecha_inicio_up" value="<?php echo date("Y-m-d"); ?>" id="evento_fecha_inicio">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="evento_fecha_inicio">Fecha de cierre</label>
                            <input value="<?php echo $campos['fecha_cierre']; ?>" type="date" class="form-control" name="evento_fecha_cierre_up" value="<?php echo date("Y-m-d"); ?>" id="evento_fecha_cierre">
                        </div>
                    </div>

						<!-- Valor Base -->
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="evento_valor" class="bmd-label-floating">Valor Base</label>
								<input value="<?php echo $campos['valor_base']; ?>" type="number" class="form-control" name="evento_valor_up" id="evento_valor" min="0" required>
							</div>
						</div>

						<!-- Lugar -->
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="evento_lugar" class="bmd-label-floating">Lugar del evento</label>
								<input value="<?php echo $campos['lugar']; ?>" type="text" required pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control" name="evento_lugar_up" id="empresa_nombre" maxlength="70">
							</div>
						</div>

						<!-- Categoría -->
						<div class="container-fluid">
							<div class="form-group">
								<label for="evento_categoria" class="bmd-label-floating">Categoría</label>
								<select class="form-control" name="evento_categoria_up" id="evento_categoria" required>
									<option value="">Seleccionar categoría</option>

									<?php
									// Llamando al controlador
									require_once "./controladores/categoriaControlador.php";
									$ins_evento = new categoriaControlador();
									$model = new mainModel();

									// Obtener lista de categorías
									$listaCategorias = $ins_evento->paginador_categoria_controlador($pagina[1], 20, "");

									// Suponiendo que tienes la categoría actual a editar almacenada en una variable $categoria_actual
									$categoria_actual = $campos['id_categoria']; // Asegúrate de que esta variable contenga el ID de la categoría actual

									// Verificar si hay categorías en la lista
									if (count($listaCategorias) > 0) {
										// Iterar sobre las categorías
										foreach ($listaCategorias as $rows) {
											// Comparar el ID de la categoría con el ID actual y agregar el atributo 'selected' si coinciden
											$selected = ($rows['id_categoria'] == $categoria_actual) ? 'selected' : '';
											echo '<option value="' . $rows['id_categoria'] . '" ' . $selected . '>' . $rows['descripcion'] . '</option>';
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
								<input value="<?php echo $campos['cupo']; ?>" type="num" pattern="[0-9]{1,9}" class="form-control" name="evento_cupo_up" id="evento_stock" maxlength="9">
							</div>
						</div>

						<!-- Estado -->
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="evento_estado" class="bmd-label-floating">Estado del evento</label>
								<select class="form-control" name="evento_estado_up" id="evento_estado">
									<option value="" disabled>Seleccione una opción</option>
									<option value="Habilitado" <?php echo ($campos['estado'] == 'Habilitado') ? 'selected' : ''; ?>>Habilitado</option>
									<option value="Deshabilitado" <?php echo ($campos['estado'] == 'Deshabilitado') ? 'selected' : ''; ?>>Deshabilitado</option>
								</select>
							</div>
						</div>


						<!-- Tipo de Entrada 
						<div class="container-fluid">
							<div class="form-group">
								<label for="evento_entrada" class="bmd-label-floating">Tipo entrada</label>
								<select class="form-control" name="evento_entrada_up" id="evento_entrada" required>
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
											// Comparar el ID actual con el ID almacenado en $campos['id_tipo_entrada']
											echo '<option value="' . $rows['id_tipo_entrada'] . '"' .
												(($rows['id_tipo_entrada'] == $campos['id_tipo_entrada']) ? ' selected' : '') .
												'>' . $rows['descripcion'] . '</option>';
										}
									} else {
										echo '<option value="">No hay entradas disponibles</option>';
									}
									?>
								</select>
							</div>
						</div>

-->

						<!-- Tipo de Evento -->
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="evento_tipo_entrada" class="bmd-label-floating">Tipo evento</label>
								<select class="form-control" name="evento_tipo_entrada_up" id="evento_tipo_entrada">
									<option value="" selected disabled>Seleccione una opción</option>
									<option value="Pago" <?php echo ($campos['es_entrada_gratis'] == 'Pago') ? 'selected' : ''; ?>>Pago</option>
									<option value="Gratis" <?php echo ($campos['es_entrada_gratis'] == 'Gratis') ? 'selected' : ''; ?>>Gratis</option>
								</select>
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