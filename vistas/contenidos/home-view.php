<!-- Page header -->
<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
				</h3>
				
			</div>
			
			<!-- Content -->
			<div class="full-box tile-container">

			<?php 	
						require_once "./controladores/asistenteControlador.php";
						$ins_asistente = new asistenteControlador();
						//consulta a la base de datos para ver los registros
						$total_asistentes = $ins_asistente->datos_asistente_controlador("Conteo",0);

				?>
				<a href="<?php echo SERVERURL;?>asistente-list/" class="tile">
					<div class="tile-tittle">asistentes</div>
					<div class="tile-icon">
						<i class="fas fa-pallet fa-fw"></i>
						<p><?php echo $total_asistentes->rowCount(); ?> Registrados</p>
					</div>
				</a>

				<?php 	
						require_once "./controladores/eventoControlador.php";
						$ins_evento = new eventoControlador();
						//consulta a la base de datos para ver los registros
						$total_eventos = $ins_evento->datos_evento_controlador("Conteo",0);

				?>
				<a href="<?php echo SERVERURL;?>evento-new/" class="tile">
					<div class="tile-tittle">Eventos</div>
					<div class="tile-icon">
						<i class="fas fa-users fa-fw"></i>
						<p><?php echo $total_eventos->rowCount(); ?> Registrados</p>
						
					</div>
				</a>
				
				

				<?php 	
						require_once "./controladores/prestamoControlador.php";
						$ins_prestamo = new prestamoControlador();
						//consulta a la base de datos para ver los registros
						$total_prestamos = $ins_prestamo->datos_prestamo_controlador("Conteo_Prestamos",0);
						$total_reservaciones = $ins_prestamo->datos_prestamo_controlador("Conteo_Reservacion",0);
						$total_finalizados = $ins_prestamo->datos_prestamo_controlador("Conteo_Finalizado",0);

				?>

				<a href="<?php echo SERVERURL;?>reservation-reservation/" class="tile">
					<div class="tile-tittle">Reservaciones</div>
					<div class="tile-icon">
						<i class="far fa-calendar-alt fa-fw"></i>
						<p><?php echo $total_reservaciones->rowCount(); ?> Registradas</p>
					</div>
				</a>

				<a href="<?php echo SERVERURL;?>reservation-pending/" class="tile">
					<div class="tile-tittle">Prestamos</div>
					<div class="tile-icon">
						<i class="fas fa-hand-holding-usd fa-fw"></i>
						<p><?php echo $total_prestamos->rowCount(); ?> Registrados</p>
					</div>
				</a>

				<a href="<?php echo SERVERURL;?>reservation-list/" class="tile">
					<div class="tile-tittle">Finalizados</div>
					<div class="tile-icon">
						<i class="fas fa-clipboard-list fa-fw"></i>
						<p><?php echo $total_finalizados->rowCount(); ?> Registrados</p>
					</div>
				</a>
				
				<?php 
					if($_SESSION['privilegio_spm']==1){
						require_once "./controladores/usuarioControlador.php";
						$ins_usuario = new usuarioControlador();
						//consulta a la base de datos para ver los registros
						$total_usuarios = $ins_usuario->datos_usuario_controlador("Conteo",0);

				?>
				<a href="<?php echo SERVERURL;?>user-list/" class="tile">
					<div class="tile-tittle">Usuarios</div>
					<div class="tile-icon">
						<i class="fas fa-user-secret fa-fw"></i>
						<p><?php echo $total_usuarios->rowCount(); ?> Registrados</p>
					</div>
				</a>
				<?php	} ?>

				<a href="<?php echo SERVERURL;?>company/" class="tile">
					<div class="tile-tittle">Empresa</div>
					<div class="tile-icon">
						<i class="fas fa-store-alt fa-fw"></i>
						<p>1 Registrada</p>
					</div>
				</a>
			</div>