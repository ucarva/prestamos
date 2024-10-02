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
				
				

				
			</div>