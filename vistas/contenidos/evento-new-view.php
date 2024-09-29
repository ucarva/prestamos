<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR EVENTO
    </h3>

</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>categoria-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CATEGORIA</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>evento-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE EVENTOS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>evento-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTOS</a>
        </li>
    </ul>
</div>

<!--CONTENT-->

<div class="container-fluid">
    <form class="form-neon FormularioAjax"
        action="<?php echo SERVERURL; ?>ajax/eventoAjax.php" method="POST" data-form="save" autocomplete="off">
        <!-- Campo oculto para registrar el usuario logueado -->
        <input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_spm']; ?>">

        <fieldset>
    <legend><i class="far fa-plus-square"></i> &nbsp; Información del Evento</legend>
    <div class="container-fluid">
        <div class="row">
            <!-- Nombre del Evento -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_nombre" class="bmd-label-floating">Nombre del Evento</label>
                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="evento_nombre_reg" id="evento_nombre" maxlength="140" required>
                </div>
            </div>

            <!-- Descripción -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_descripcion" class="bmd-label-floating">Descripción</label>
                    <textarea class="form-control" name="evento_descripcion_reg" id="evento_descripcion" rows="3" required></textarea>
                </div>
            </div>

            <!-- Hora del Evento -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_hora" class="bmd-label-floating">Hora del Evento</label>
                    <input type="time" class="form-control" name="evento_hora_reg" id="evento_hora" required>
                </div>
            </div>

            <!-- Valor Base -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_valor" class="bmd-label-floating">Valor Base</label>
                    <input type="number" class="form-control" name="evento_valor_reg" id="evento_valor" min="0" required>
                </div>
            </div>

            <!-- Lugar -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_lugar" class="bmd-label-floating">Lugar</label>
                    <select class="form-control" name="evento_lugar_reg" id="evento_lugar" onchange="toggleNewValue('lugar', this.value);" required>
                        <option value="">Seleccionar lugar</option>
                        <option value="lugar1">Lugar 1</option>
                        <option value="lugar2">Lugar 2</option>
                        <option value="nuevo_lugar">Agregar Nuevo Lugar</option>
                    </select>
                    <input type="text" id="nuevo_lugar" name="nuevo_lugar" placeholder="Nuevo Lugar" class="form-control mt-2" style="display:none;">
                </div>
            </div>

            <!-- Categoría -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_categoria" class="bmd-label-floating">Categoría</label>
                    <select class="form-control" name="evento_categoria_reg" id="evento_categoria" onchange="toggleNewValue('categoria', this.value);" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="categoria1">Categoría 1</option>
                        <option value="categoria2">Categoría 2</option>
                        <option value="nueva_categoria">Agregar Nueva Categoría</option>
                    </select>
                    <input type="text" id="nuevo_categoria" name="nuevo_categoria" placeholder="Nueva Categoría" class="form-control mt-2" style="display:none;">
                </div>
            </div>

            <!-- Cupo -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_cupo" class="bmd-label-floating">Cupo</label>
                    <select class="form-control" name="evento_cupo_reg" id="evento_cupo" onchange="toggleNewValue('cupo', this.value);" required>
                        <option value="">Seleccionar cupo</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="nuevo_cupo">Agregar Nuevo Cupo</option>
                    </select>
                    <input type="number" id="nuevo_cupo" name="nuevo_cupo" placeholder="Nuevo Cupo" class="form-control mt-2" style="display:none;" min="1">
                </div>
            </div>

            <!-- Estado -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_estado" class="bmd-label-floating">Estado</label>
                    <select class="form-control" name="evento_estado_reg" id="evento_estado" onchange="toggleNewValue('estado', this.value);" required>
                        <option value="">Seleccionar estado</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="nuevo_estado">Agregar Nuevo Estado</option>
                    </select>
                    <input type="text" id="nuevo_estado" name="nuevo_estado" placeholder="Nuevo Estado" class="form-control mt-2" style="display:none;">
                </div>
            </div>

            <!-- Tipo de Evento -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_tipo" class="bmd-label-floating">Tipo de Evento</label>
                    <select class="form-control" name="evento_tipo_reg" id="evento_tipo" onchange="toggleNewValue('tipo_evento', this.value);" required>
                        <option value="">Seleccionar tipo de evento</option>
                        <option value="tipo1">Tipo 1</option>
                        <option value="tipo2">Tipo 2</option>
                        <option value="nuevo_tipo_evento">Agregar Nuevo Tipo de Evento</option>
                    </select>
                    <input type="text" id="nuevo_tipo_evento" name="nuevo_tipo_evento" placeholder="Nuevo Tipo de Evento" class="form-control mt-2" style="display:none;">
                </div>
            </div>

            <!-- Tipo de Entrada -->
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="evento_tipo_entrada" class="bmd-label-floating">Tipo de Entrada</label>
                    <select class="form-control" name="evento_tipo_entrada_reg" id="evento_tipo_entrada" onchange="toggleNewValue('tipo_entrada', this.value);" required>
                        <option value="">Seleccionar tipo de entrada</option>
                        <option value="entrada1">Entrada 1</option>
                        <option value="entrada2">Entrada 2</option>
                        <option value="nuevo_tipo_entrada">Agregar Nuevo Tipo de Entrada</option>
                    </select>
                    <input type="text" id="nuevo_tipo_entrada" name="nuevo_tipo_entrada" placeholder="Nuevo Tipo de Entrada" class="form-control mt-2" style="display:none;">
                </div>
            </div>
        </div>
    </div>
</fieldset>

<script>
    function toggleNewValue(field, value) {
        const newFieldId = `nuevo_${field}`; // Crea el ID del nuevo campo
        const newField = document.getElementById(newFieldId);
        
        // Verifica si el valor es "nuevo_<field>"
        if (value === `nuevo_${field}`) {
            newField.style.display = 'block'; // Muestra el campo
            newField.focus(); // Enfoca el campo
        } else {
            newField.style.display = 'none'; // Oculta el campo
            newField.value = ''; // Limpia el campo
        }
    }
</script>



        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>