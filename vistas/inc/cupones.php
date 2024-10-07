<script>
    function validarCupon(cuponInputName, buttonId) {
        let cuponCodigo = document.querySelector(`#${cuponInputName}`).value.trim();

        if (cuponCodigo === "") {
            Swal.fire({
                title: 'Ocurrió un error',
                text: 'Debes introducir un código de cupón.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        let datos = new FormData();
        datos.append(cuponInputName, cuponCodigo);
        datos.append('validar_cupon', true);

        fetch("<?php echo SERVERURL; ?>ajax/facturaAjax.php", {
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                mostrarAlertas(respuesta);
                
                // Verifica si hay un nuevo valor en la respuesta y actualiza el campo
                if (respuesta[0] && respuesta[0].NuevoValor) {
                    let valorBase = parseFloat(document.querySelector('#valor_total').value);
                    let nuevoDescuento = parseFloat(respuesta[0].NuevoValor);
                    document.querySelector('#valor_total').value = valorBase - nuevoDescuento;

                    // Deshabilitar el botón después de una validación exitosa
                    document.querySelector(`#${buttonId}`).disabled = true; // Deshabilitar el botón
                }
            })
            .catch(error => {
                console.error('Error al validar el cupón:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al validar el cupón. Intenta de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
    }

    function mostrarAlertas(respuesta) {
        const alertContainer = document.getElementById("alert-container");
        alertContainer.innerHTML = ""; // Limpiar alertas previas

        respuesta.forEach(alerta => {
            const alertaDiv = document.createElement("div");
            alertaDiv.className = `alert alert-${alerta.Tipo}`;
            alertaDiv.innerText = `${alerta.Titulo}: ${alerta.Texto}`;
            alertContainer.appendChild(alertaDiv);
        });
    }

    function validarEntrada(entradaInputId, buttonId) {
        let entradaId = document.querySelector(`#${entradaInputId}`).value.trim();

        if (entradaId === "") {
            Swal.fire({
                title: 'Ocurrió un error',
                text: 'Debes seleccionar un tipo de entrada.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        let datos = new FormData();
        datos.append('id_tipo_entrada', entradaId);
        datos.append('validar_entrada', true);

        fetch("<?php echo SERVERURL; ?>ajax/facturaAjax.php", {
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                mostrarAlertas(respuesta);
                
                // Verifica si hay un nuevo valor en la respuesta y actualiza el campo
                if (respuesta[0] && respuesta[0].NuevoValor) {
                    let valorBase = parseFloat(document.querySelector('#valor_total').value);
                    let precioEntrada = parseFloat(respuesta[0].NuevoValor);
                    document.querySelector('#valor_total').value = valorBase + precioEntrada;

                    // Deshabilitar el botón después de una validación exitosa
                    document.querySelector(`#${buttonId}`).disabled = true;
                }
            })
            .catch(error => {
                console.error('Error al validar la entrada:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al validar la entrada. Intenta de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
    }

    function mostrarAlertas(respuesta) {
        const alertContainer = document.getElementById("alert-container");
        alertContainer.innerHTML = ""; // Limpiar alertas previas

        respuesta.forEach(alerta => {
            const alertaDiv = document.createElement("div");
            alertaDiv.className = `alert alert-${alerta.Tipo}`;
            alertaDiv.innerText = `${alerta.Titulo}: ${alerta.Texto}`;
            alertContainer.appendChild(alertaDiv);
        });
    }
</script>
