
$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Botón ocultar/mostrar menú lateral
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });


    /* $('modal').on('hidden', function() {
        $(this).removeData('modal');
        }); */


    /* Función para borrar por completo el modal de cambio de contraseña */
    function borrarModal(){
        $('#passwordUsuario').val("");
        $('#passwordUsuario').css("border", "none");
        $("#errPass").hide();
        $('#confPassUsuario').val("");
        $('#confPassUsuario').css("border", "none");
        $("#errConfPass").hide();
    }


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalPassword").on("hidden.bs.modal", function () {
        borrarModal();
    });



    /* Al pulsar sobre de botón "Cambiar contraseña" en la página Menú */
    $(document).on("click", "#cambiarPassword", function() {  
        
        borrarModal();
        $('#modalPassword').modal('show');  
                    
    });


    /* Al pulsar sobre de botón "Cerrar Sesión" en la página Menú para salir de la web */
    $(document).on("click", "#cerrarSesion", function() {  
        
        if(confirm("¿Seguro que desea cerrar la sesión y salir?")){
            $(location).attr('href', "includes/go_out.php");
        }       
                    
    });


    /* Al pulsar sobre el botón "Aceptar" del Modal para modificar la contraseña */
    $(document).on("click", "#aceptarModalPassword", function(e) {
        e.preventDefault();

        var expPass = /^[a-zA-Z0-9ñÑ\s]{4,20}$/;
        var pass = $('#passwordUsuario').val();
        var confpass = $('#confPassUsuario').val();
        var id = parseInt($('#id').val());

        //Compruebo cada campo y maqueto efectos en el formulario
        //Campo password o contraseña
        if(!expPass.test(pass)){
            $("#errPass").fadeIn();
            $('#passwordUsuario').focus().css("border", "3px solid red");
            $('#confPassUsuario').css("border", "none");
            $("#errConfPass").hide();
            return false;

        } else {
            $("#errPass").hide();
            $("#errConfPass").hide();
            $('#passwordUsuario').css("border", "3px solid #03c003");
            $('#confPassUsuario').css("border", "none");

            //Campo confirmación password o contraseña
            if(confpass != pass){
                $("#errConfPass").fadeIn();
                $('#confPassUsuario').css("border", "3px solid red");
                $('#passwordUsuario').focus().css("border", "none");
                $('#passwordUsuario').val("");
                $('#confPassUsuario').val("");
                return false;
            
            } else {
                $("#errConfPass").hide();
                $('#confPassUsuario').css("border", "3px solid #03c003");

                if(confirm("¿Seguro que desea cambiar la contraseña?")){

                    //Recojo los datos
                    accionUsuario = {
                        accion: "Cambiar Contrasena",
                        id: id,
                        nombre: "",
                        rol: "",
                        email: "",
                        bloque: "",
                        pass: pass
                    };
                    
                    /* Petición ajax para pasar el parámetro accionUsuario con todos los datos recogidos para cambiar la contraseña del usuario registrado */
                    $.ajax({
                        url:'includes/functions.php',
                        type: 'POST',
                        data: { accionUsuario },
                        success: function(respuesta){
                            
                            //Si se ha modificado
                            if(respuesta == "si"){

                                $('#modalPassword').modal('hide');
                                $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="thumbs-up"></ion-icon> <b>Contraseña cambiada con exito</b></p>');
                                $("#modalInfo").modal('show');
                                setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                                        
                            //Si no se ha modificado
                            } else{
                            
                                $('#modalPassword').modal('hide');
                                $("#infoModal").html('<p class="text-center text-danger pt-3"><ion-icon name="thumbs-down"></ion-icon> <b>Cambio de contraseña fallido,<br>revisa y modifica los datos introducidos</b></p>');
                                $("#modalInfo").modal('show');
                                setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                            }
                        },
                        // Si la petición falla, devuelve en consola el error producido y el estado
                        error: function(estado, error) {
                            console.log("-Error producido: " + error + ". -Estado: " + estado)
                        }
                    });
                              

                } else {
                    
                    borrarModal();
                    $('#modalPassword').modal('hide');
                    $("#infoModal").html('<p class="text-center text-danger pt-3"><ion-icon name="close-circle-outline"></ion-icon> <b>No se ha realizado el cambio de contraseña</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje */
                    return false;
                }
            }
        }
    });




    /* // Si la petición falla, devuelve en consola el error producido y el estado
        error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'No conectado.\n Verificar red.';
            } else if (jqXHR.status == 404) {
                msg = 'No se encontró la página solicitada. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Error de servidor interno [500].';
            } else if (exception === 'parsererror') {
                msg = 'Error de análisis JSON solicitado.';
            } else if (exception === 'timeout') {
                msg = 'Error de tiempo de espera.';
            } else if (exception === 'abort') {
                msg = 'Solicitud de Ajax cancelada.';
            } else {
                msg = 'Error no detectado.\n' + jqXHR.responseText;
            }
            console.log(msg);
        } */






});