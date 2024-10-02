<script>
    // Función para validar cupones
function validarCupon(cuponInputName, cuponInputId) {
    let cuponCodigo = document.querySelector(`#${cuponInputId}`).value.trim();

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
    datos.append('validar_cupon', true); // Indicador de que se está validando el cupón

    fetch("<?php echo SERVERURL; ?>ajax/facturaAjax.php", {
        method: 'POST',
        body: datos
    })
    .then(respuesta => respuesta.json())
    .then(respuesta => {
        return alertas_ajax(respuesta);
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

</script>