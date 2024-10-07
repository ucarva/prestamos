<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fab fa-dashcube fa-fw"></i> &nbsp; SISTEMA GESTION DE EVENTOS
	</h3>

</div>

<!-- Content -->
<div class="full-box tile-container">

    <?php
    require_once "./controladores/asistenteControlador.php";
    $ins_asistente = new asistenteControlador();
    // consulta a la base de datos para ver los registros
    $total_asistentes = $ins_asistente->datos_asistente_controlador("Conteo", 0);
    ?>
    <a href="<?php echo SERVERURL; ?>asistente-list/" class="tile">
        <div class="tile-icon" style="display: flex; align-items: center;">
            <i class="fas fa-pallet fa-fw" style="font-size: 1.5em; margin-right: 10px;"></i>
            <div>
                <div class="tile-title" style="font-size: 1.5em; font-weight: bold; margin: 0;">
                    Asistentes
                </div>
                <div class="tile-message" style="font-size: 1em; color: #666;">
                    <?php echo $total_asistentes->rowCount(); ?> Registrados
                </div>
            </div>
        </div>
    </a>

    <?php
    require_once "./controladores/eventoControlador.php";
    $ins_evento = new eventoControlador();
    // consulta a la base de datos para ver los registros
    $total_eventos = $ins_evento->datos_evento_controlador("Conteo", 0);
    ?>
    <a href="<?php echo SERVERURL; ?>evento-list/" class="tile">
        <div class="tile-icon" style="display: flex; align-items: center;">
            <i class="fas fa-users fa-fw" style="font-size: 1.5em; margin-right: 10px;"></i>
            <div>
                <div class="tile-title" style="font-size: 1.5em; font-weight: bold; margin: 0;">
                    Eventos
                </div>
                <div class="tile-message" style="font-size: 1em; color: #666;">
                    <?php echo $total_eventos->rowCount(); ?> Registrados
                </div>
            </div>
        </div>
    </a>

    <?php
    require_once "./controladores/inscripcionControlador.php";
    require_once "./controladores/eventoControlador.php";
    
    // Crear instancias de los controladores
    $contarInscripciones = new inscripcionControlador();
    $eventoControlador = new eventoControlador();

    // Obtener los eventos registrados
    $eventos = $eventoControlador->obtenerEventos();

    // Iterar sobre los eventos para mostrar cada uno
    while ($evento = $eventos->fetch(PDO::FETCH_ASSOC)) {
        $evento_id = $evento['id_evento'];
        $nombre_evento = $evento['titulo'];

        // Obtener el número de inscripciones para cada evento
        $total_inscripciones = $contarInscripciones->contarInscripciones($evento_id);

        // Obtener el cupo máximo del evento
        $cupo_maximo = $eventoControlador->obtenerCupoMaximo($evento_id);
    ?>
        <a href="<?php echo SERVERURL; ?>evento-list/" class="tile">
            <div class="tile-icon" style="display: flex; align-items: center;">
                <i class="fas fa-calendar-alt fa-fw" style="font-size: 1.5em; margin-right: 10px;"></i>
                <div>
                    <div class="tile-title" style="font-size: 1.5em; font-weight: bold; margin: 0;">
                        <?php echo $nombre_evento; ?>
                    </div>
                    <div class="tile-message" style="font-size: 1em; color: #666;">
                        <?php echo "El evento tiene " . $total_inscripciones . " inscripciones registradas."; ?>
                        <br>
                        <?php echo "Cupo máximo: " . $cupo_maximo; ?>
                    </div>
                </div>
            </div>
        </a>
  

    <?php }
    ?>
</div>
