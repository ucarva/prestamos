	<!-- Nav lateral -->
	<section class="full-box nav-lateral">
		<div class="full-box nav-lateral-bg show-nav-lateral"></div>
		<div class="full-box nav-lateral-content">
			<figure class="full-box nav-lateral-avatar">
				<i class="far fa-times-circle show-nav-lateral"></i>
				<img src="<?php echo SERVERURL; ?>vistas/assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
				<figcaption class="roboto-medium text-center">
					<?php echo $_SESSION['nombre_spm'] . " " . $_SESSION['apellido_spm']; ?>
					<br><small class="roboto-condensed-light"><?php echo $_SESSION['usuario_spm']; ?></small>
				</figcaption>
			</figure>
			<div class="full-box nav-lateral-bar"></div>
			<nav class="full-box nav-lateral-menu">
				<ul>
					<li>
						<a href="<?php echo SERVERURL; ?>home/"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Escritorio</a>
					</li>


					<li>
						<a href="#" class="nav-btn-submenu"><i class="fas fa-users fa-fw"></i> &nbsp; Asistentes <i class="fas fa-chevron-down"></i></a>
						<ul>
							<li>
								<a href="<?php echo SERVERURL; ?>asistente-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar asistente</a>
							</li>
							<li>
								<a href="<?php echo SERVERURL; ?>asistente-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de asistente</a>
							</li>
							<li>
								<a href="<?php echo SERVERURL; ?>asistente-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar asistente</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#" class="nav-btn-submenu"><i class="fas fa-pallet fa-fw"></i> &nbsp; Eventos <i class="fas fa-chevron-down"></i></a>
						<ul>
							<li>
								<a href="#" class="nav-btn-submenu"><i class="fas fa-tasks fa-fw"></i> &nbsp; Gestionar Eventos <i class="fas fa-chevron-down"></i></a>
								<ul>
									<li>
										<a href="<?php echo SERVERURL; ?>categoria-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Crear categoría</a>
									</li>
									<li>
										<a href="<?php echo SERVERURL; ?>entrada-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Crear Entradas</a>
									</li>
									<li>
										<a href="<?php echo SERVERURL; ?>cupon-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Crear Cupones</a>
									</li>
									
								</ul>
								<li>
										<a href="<?php echo SERVERURL; ?>evento-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Crear Eventos</a>
									</li>
									<li>
										<a href="<?php echo SERVERURL; ?>evento-list/"><i class="fas fa-plus fa-fw"></i> &nbsp; Lista de Eventos</a>
									</li>
							</li>
						</ul>
					</li>
					



					
				</ul>
			</nav>
		</div>
	</section>