<script>
        //funcion buscar cliente
    function buscar_cliente(){
        
        let input_cliente=document.querySelector('#input_cliente').value;

        input_cliente= input_cliente.trim();

        if( input_cliente!=""){
            let datos = new FormData();
            datos.append("buscar_cliente",input_cliente);

           
           fetch("<?php echo SERVERURL;?>ajax/prestamoAjax.php",{
            method:'POST',
            body:datos
           })
           .then(respuesta => respuesta.text())
           .then(respuesta => {
            let tabla_clientes=document.querySelector('#tabla_clientes'); 
            tabla_clientes.innerHTML=respuesta;
           });
        


        }else{
            Swal.fire({
            title: 'Ocurrio un error',
            text: 'Debes introducir el DNI,Nombre,Apellido,Telefono',
            type: 'error',
            confirmButtonText: 'Aceptar'
        });
        }

    }


    //funcion agregar cliente
    function agregar_cliente(id){
        $('#ModalCliente').modal('hide');

        Swal.fire({
        title: 'Quieres agregar este cliente?',
        text: 'Se va agregar este cliente para realizar un prestamo',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, agregar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.value) {
            let datos = new FormData();
            datos.append("id_agregar_cliente",id);

           
           fetch("<?php echo SERVERURL;?>ajax/prestamoAjax.php",{
            method:'POST',
            body:datos
           })
           .then(respuesta => respuesta.json())
           .then(respuesta => {
                return alertas_ajax(respuesta);
           });
        
        }else{
            $('#ModalCliente').modal('show'); 
        }
    });

    }

</script>