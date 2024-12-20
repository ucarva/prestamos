<?php


if ($_SESSION['privilegio_spm'] < 1 || $_SESSION['privilegio_spm'] > 2) {
	echo $lc->forzar_cierre_sesion_controlador();
	exit();
}


?>

<!-- Page header -->
<div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR ITEM
                </h3>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque laudantium necessitatibus eius iure adipisci modi distinctio. Earum repellat iste et aut, ullam, animi similique sed soluta tempore cum quis corporis!
                </p>
            </div>

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a href="<?php echo SERVERURL;?>item-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVERURL;?>item-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVERURL;?>item-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
                    </li>
                </ul>
            </div>
            
            <!--CONTENT-->
            <div class="container-fluid">
			<?php
		require_once "./controladores/itemControlador.php";
		$ins_item = new itemControlador();

		$datos_item=$ins_item->datos_item_controlador("Unico",$pagina[1]);
		if($datos_item->rowCount()==1){
			$campos=$datos_item->fetch();

		?>
				<form class="form-neon FormularioAjax " action="<?php echo SERVERURL; ?>ajax/itemAjax.php" method="POST" data-form="update" autocomplete="off">
					<input type="hidden" name="item_id_up" value="<?php echo $pagina[1]; ?>">
				<fieldset>
						<legend><i class="far fa-plus-square"></i> &nbsp; Información del item</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="item_codigo" class="bmd-label-floating">Códido</label>
										<input value="<?php echo $campos['item_codigo']; ?>" type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="item_codigo_up" id="item_codigo" maxlength="45">
									</div>
								</div>
								
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="item_nombre" class="bmd-label-floating">Nombre</label>
										<input value="<?php echo $campos['item_nombre']; ?>" type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="item_nombre_up" id="item_nombre" maxlength="140">
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="item_stock" class="bmd-label-floating">Stock</label>
										<input value="<?php echo $campos['item_stock']; ?>" type="num" pattern="[0-9]{1,9}" class="form-control" name="item_stock_up" id="item_stock" maxlength="9">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="item_estado" class="bmd-label-floating">Estado</label>
										<select class="form-control" name="item_estado_up" id="item_estado">
											
											<option value="Habilitado" <?php if($campos['item_estado']=="Habilitado"){echo'selected=""';} ?> >Habilitado <?php if($campos['item_estado']=="Habilitado"){echo'(Actual)';} ?></option>
											<option value="Deshabilitado" <?php if($campos['item_estado']=="Deshabilitado"){echo'selected=""';} ?> >Deshabilitado <?php if($campos['item_estado']=="Deshabilitado"){echo'(Actual)';} ?></option>
										</select>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="item_detalle" class="bmd-label-floating">Detalle</label>
										<input value="<?php echo $campos['item_detalle']; ?>" type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="item_detalle_up" id="item_detalle" maxlength="190">
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