<script>
    //funcion buscar cliente
    function buscar_asistente() {

        let input_asistente = document.querySelector('#input_asistente').value;

        input_asistente = input_asistente.trim();

        if (input_asistente != "") {
            let datos = new FormData();
            datos.append("buscar_asistente", input_asistente);


            fetch("<?php echo SERVERURL; ?>ajax/inscripcionAjax.php", {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.text())
                .then(respuesta => {
                    let tabla_asistente = document.querySelector('#tabla_asistente');
                    tabla_asistente.innerHTML = respuesta;
                });



        } else {
            Swal.fire({
                title: 'Ocurrio un error',
                text: 'Debes introducir el nombre del asistente',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }

    }


    //funcion agregar cliente
    function agregar_asistente(id) {
        $('#ModalCliente').modal('hide');

        Swal.fire({
            title: 'Quieres agregar este asistente?',
            text: 'Se va agregar este asistente para vincularlos a eventos',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, agregar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.value) {
                let datos = new FormData();
                datos.append("id_agregar_asistente", id);


                fetch("<?php echo SERVERURL; ?>ajax/inscripcionAjax.php", {
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
    function buscar_evento() {

        let input_evento = document.querySelector('#input_evento').value;
        //quitar espacios
        input_evento = input_evento.trim();

        if (input_evento != "") {
            let datos = new FormData();
            datos.append("buscar_evento", input_evento);
            fetch("<?php echo SERVERURL; ?>ajax/inscripcionAjax.php", {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.text())
                .then(respuesta => {
                    let tabla_eventos = document.querySelector('#tabla_eventos');
                    tabla_eventos.innerHTML = respuesta;
                });
        } else {
            Swal.fire({
                title: 'Ocurrio un error',
                text: 'Debes introducir el codigo o el nombre del evento',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }

    }


    //Modales del item
    function modal_agregar_evento(id){
        //ocultando ventana
        $('#ModalItem').modal('hide');

        //mostrar siguiente modal
        $('#ModalAgregarItem').modal('show');

        //seleccionar item mediante un selector
        let input_item = document.querySelector('#id_agregar_evento').setAttribute("value",id);
    }

    //modal para buscar item
    function modal_buscar_evento(){

        //mostrar siguiente modal
        $('#ModalAgregarItem').modal('hide');
        
        //ocultando ventana
        $('#ModalItem').modal('show');

        

    }
    
   

 


</script>
