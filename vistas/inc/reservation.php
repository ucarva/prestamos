<script>
    //funcion buscar cliente
    function buscar_cliente() {

        let input_cliente = document.querySelector('#input_cliente').value;

        input_cliente = input_cliente.trim();

        if (input_cliente != "") {
            let datos = new FormData();
            datos.append("buscar_cliente", input_cliente);


            fetch("<?php echo SERVERURL; ?>ajax/prestamoAjax.php", {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.text())
                .then(respuesta => {
                    let tabla_clientes = document.querySelector('#tabla_clientes');
                    tabla_clientes.innerHTML = respuesta;
                });



        } else {
            Swal.fire({
                title: 'Ocurrio un error',
                text: 'Debes introducir el DNI,Nombre,Apellido,Telefono',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }

    }


    //funcion agregar cliente
    function agregar_cliente(id) {
        $('#ModalCliente').modal('hide');

        Swal.fire({
            title: 'Quieres agregar este cliente?',
            text: 'Se va agregar este cliente para realizar un prestamo',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, agregar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.value) {
                let datos = new FormData();
                datos.append("id_agregar_cliente", id);


                fetch("<?php echo SERVERURL; ?>ajax/prestamoAjax.php", {
                        method: 'POST',
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        return alertas_ajax(respuesta);
                    });

            } else {
                $('#ModalCliente').modal('show');
            }
        });

    }

    //buscar item
    function buscar_item() {

        let input_item = document.querySelector('#input_item').value;
        //quitar espacios
        input_item = input_item.trim();

        if (input_item != "") {
            let datos = new FormData();
            datos.append("buscar_item", input_item);
            fetch("<?php echo SERVERURL; ?>ajax/prestamoAjax.php", {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.text())
                .then(respuesta => {
                    let tabla_items = document.querySelector('#tabla_items');
                    tabla_items.innerHTML = respuesta;
                });
        } else {
            Swal.fire({
                title: 'Ocurrio un error',
                text: 'Debes introducir el codigo o el nombre del item',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }

    }


    //Modales del item
    function modal_agregar_item(id){
        //ocultando ventana
        $('#ModalItem').modal('hide');

        //mostrar siguiente modal
        $('#ModalAgregarItem').modal('show');

        //seleccionar item mediante un selector
        let input_item = document.querySelector('#id_agregar_item').setAttribute("value",id);
    }

    //modal para buscar item
    function modal_buscar_item(){

        //mostrar siguiente modal
        $('#ModalAgregarItem').modal('hide');
        
        //ocultando ventana
        $('#ModalItem').modal('show');

        

    }
    


</script>