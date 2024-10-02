

<script>
// Función para validar cupones
function validarCupon(cuponInputName, cuponInputId) {
    let cuponCodigo = document.querySelector(`#${cuponInputId}`).value.trim(); // Obtener el valor del cupón

    if (cuponCodigo === "") {
        Swal.fire({
            title: 'Ocurrió un error',
            text: 'Debes introducir un código de cupón.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        return; // Salir de la función si el campo está vacío
    }

    let datos = new FormData();
    datos.append(cuponInputName, cuponCodigo); // Agregar el cupón al FormData
    datos.append('validar_cupon', true); // Indicador de que se está validando el cupón

    fetch("<?php echo SERVERURL; ?>ajax/facturaAjax.php", { // Cambia la URL según tu configuración
        method: 'POST',
        body: datos
    })
    .then(respuesta => respuesta.json())
    .then(respuesta => {
        mostrarAlertas(respuesta); // Manejar la respuesta utilizando la función de alertas
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

// Función para mostrar alertas
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


