
/* Página que contiene las funciones JavaScript que pertenecen a la página Usuarios
*
*  @author Francisco José López Zafra
*/


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.    


    //Funcion para mostrar todas las máquinas y sus datos en una tabla en la página "Usuarios"
    function mostrarUsuarios(){
        //Declaración de variables
        let usuarios = "";
  
        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { usuarios },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '';
                let id = "";
                let botones = "";
                info.forEach(buscado => {
                    buscado.bloqueado==1 ? buscado.bloqueado='Sí' : buscado.bloqueado='No';
                    buscado.bloqueado=='Sí' ? clase="col-lg-12 bg-secondary text-light border" : clase="col-lg-12 bg-light text-dark border";
                    if($('#rol').text() === "Administrador" || $('#rol').text() === "Responsable"){
                        if($('#rol').text() === "Responsable" && $('#rol').text() === buscado.rol){
                            botones = "<button type='button' class='actualizarUsuario btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button><button type='button' class='eliminarMaquina btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";

                        } else if($('#rol').text() === "Administrador"){
                            botones = "<button type='button' class='actualizarUsuario btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button><button type='button' class='eliminarMaquina btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";
                        }
                    }
                    id = buscado.id;
                    resultado +=
                    `<div class="row m-3" id="${id}">
                        <div class="${clase}">

                            <div class="row">
                                <div class="col-lg-2 pt-3">
                                    <span class="text-success font-weight-bold">Id: </span><span class="id">${id}</span>
                                </div>
                                <div class="col-lg-4 pt-3">
                                    <span class="text-success font-weight-bold">Nombre: </span><span class="nombre">${buscado.nombre}</span>
                                </div>
                                <div class="col-lg-3 pt-3">
                                    <span class="text-success font-weight-bold">Rol: </span><span class="rol">${buscado.rol}</span>
                                </div>
                                
                                <div class="col-lg-3 text-right mt-1">
                                    ${botones}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 pt-1">
                                    <span class="text-success font-weight-bold">Email: </span><span class="email">${buscado.email}</span>
                                </div>
                                <div class="col-lg-6 pt-1">
                                    <span class="text-success font-weight-bold">Bloqueado: </span><span class="bloqueado">${buscado.bloqueado}</span>
                                    <input type="hidden" class="password" value="${buscado.password}">
                                </div>
                            </div>
                                                    
                        </div>                   
                    </div>`;  
                });

                $("#cont_mostrar_usuarios").html(resultado);                 
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });

    }

    /* Invoco la función */
    mostrarUsuarios();



    
    /* Borrar los campos del modal */
    function borrarCamposModal(){
        $('#inputNombreUsuario').val("");
        $('#inputEmailUsuario').val("");
        $('#inputBloqueUsuario').val("");        
    }


    function mostrarRoles(rol){
        let roles = "";
        let select = '';
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { roles },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '';
                info.forEach(buscado => {
                    if($('#rol').text() === "Administrador"){
                        resultado += `<a class="rol dropdown-item" href="#">${buscado.nombre}</a>`;
                                             
                    } else if($('#rol').text() === "Responsable"){
                        if(buscado.nombre != "Administrador"){
                            resultado += `<a class="rol dropdown-item" href="#">${buscado.nombre}</a>`;
                        }                          
                    }                    
                });

                $("#opcionesRolUsuario").html(resultado);
                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }


    /* Al pulsar sobre de botón "Nuevo Usuario" en la página Usuarios */
    $(document).on("click", "#crearUsuario", function() {  
        let rol = '';
        borrarCamposModal();        
        $('#tituloModalUsuario').text('Nuevo Usuario');
        $('#inputRolUsuario').text('Técnico');
        $('#inputBloqueUsuario').text('No');
        mostrarRoles(rol);
        $('#filaPassword').show();
        $('#modalUsuario').modal('show');  
                    
    });


    /* Al pulsar sobre de botón "Actualizar" de algún registro*/
    $(document).on("click", ".actualizarUsuario", function() {             
        let nombre = $(this).parent().siblings().children().siblings('.nombre').text();
        let rol = $(this).parent().siblings().children().siblings('.rol').text();
        let email = $(this).parent().parent().siblings().children().children().siblings('.email').text();
        let bloque = $(this).parent().parent().siblings().children().children().siblings('.bloqueado').text();
        let password = $(this).parent().parent().siblings().children().siblings('.password').val();
        console.log(nombre +" + " + rol +" + " + email +" + " + bloque +" + " + password);
         
        borrarCamposModal();   
        $('#tituloModalUsuario').text('Modificar Usuario');
        $('#inputNombreUsuario').val(nombre);
        $('#inputRolUsuario').text(rol);
        mostrarRoles(rol);
        $('#inputEmailUsuario').val(email);
        $('#inputBloqueUsuario').text(bloque);
        $('#filaPassword').hide();
        $('#modalUsuario').modal('show');          
    });




    /* Al pulsar sobre alguna de las opciones del desplegable Rol */
    $(document).on("click", ".rol", function(e) {

        e.preventDefault();
        $('#inputRolUsuario').text($(this).text());
    });

    /* Al pulsar sobre alguna de las opciones del desplegable Bloqueado */
    $(document).on("click", ".bloqueado", function(e) {

        e.preventDefault();
        $('#inputBloqueUsuario').text($(this).text());
    });





    /* Al pulsar sobre de botón "Cancelar" del Modal vacío los campos*/
    $(document).on("click", "#cancelarModalUsuario", function() {              
        borrarCamposModal();  
        $('#modalUsuario').modal('hide');          
    });


    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar */
    $(document).on("click", "#aceptarModalUsuario", function() {  
        //Declaro los patrones a comparar
        var expNombre = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,50}$/;
        var expEmail = /^[a-zA-Z0-9ñÑ_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;  
        var expPass = /^[a-zA-Z0-9ñÑ\s]{4,20}$/;
        var accionUsuario;    

        //Recojo el valor de los campos rellenados
        var nombre = $('#inputNombreUsuario').val();
        var rol = $('#inputRolUsuario').text();
        var email = $('#inputEmailUsuario').val();
        var bloque = $('#inputBloqueUsuario').text();
        var pass = $('#inputPasswordUsuario').val();
        var confpass = $('#inputConfPassUsuario').val();


        //Compruebo cada campo y maqueto efectos en el formulario
        //Campo nombre
        if(!expNombre.test(nombre)){
            $("#errNombre").fadeIn();
            $('#inputNombreUsuario').focus().css("border", "3px solid red");
            return false;
        
        } else {
            $("#errNombre").hide();
            $('#inputNombreUsuario').css("border", "3px solid #03c003");

            //Campo Email
            if(!expEmail.test(email)){
                $("#errEmail").fadeIn();
                $('#inputEmailUsuario').focus().css("border", "3px solid red");
                return false;

            } else {
                $("#errEmail").hide();
                $('#inputEmailUsuario').css("border", "3px solid #03c003");

                //Si el modal es para crear usuario o para modificarlo
                if($('#tituloModalUsuario').text() == "Nuevo Usuario"){
                    
                    //Campo password o contraseña
                    if(!expPass.test(pass)){
                        $("#errPass").fadeIn();
                        $('#inputPasswordUsuario').focus().css("border", "3px solid red");
                        return false;
    
                    } else {
                        $("#errPass").hide();
                        $('#inputPasswordUsuario').css("border", "3px solid #03c003");
    
                        //Campo confirmación password o contraseña
                        if(confpass != pass){
                            $("#errConfPass").fadeIn();
                            $('#inputConfPassUsuario').focus().css("border", "3px solid red");
                            return false;
                        
                        } else {
                            $("#errConfPass").hide();
                            $('#inputConfPassUsuario').css("border", "3px solid #03c003");
                        }
                    }
                }
            }
        }



        /* if($('#tituloModalUsuario').text()=="Nuevo Usuario") { 

            //Recojo los datos
            accionUsuario = {
                accion: $('#tituloModalUsuario').text(),
                id: 0,
                nombre: $('#inputNombreUsuario').val()
            };
        
        } else if($('#tituloModalUsuario').text()=="Modificar Usuario"){

            //Recojo los datos
            accionUsuario = {
                accion: $('#tituloModalUsuario').text(),
                id: $('#inputIdUsuario').val(),
                nombre: $('#inputNombreUsuario').val()
            };

        } */

        //Petición ajax
       /*  $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionUsuario },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta=="si"){

                    $('#modalUsuario').modal('hide');
                    mostrarUsuarios();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificdo
                } else{
                
                    $('#modalUsuario').modal('hide');
                    mostrarUsuarios();
                    $("#infoModal").html('<p class="text-center text-danger pt-3"><ion-icon name="close-circle-outline"></ion-icon> <b>No ha podido realizar la acción,<br>revisa y modifica los datos introducidos</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                }
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)
            }
        });  */        
                    
    });


    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarUsuario", function() {         
        let accionUsuario; 
        id = $(this).parent().siblings('.id').text();
        nombre = $(this).parent().siblings('.nombre').text(); 

        if(confirm("¿Seguro que quieres borrar el Usuario: " + nombre + "?")){
            //Recojo los datos
            accionUsuario = {
                accion: "Borrar Usuario",
                id: id,
                nombre: nombre
            };

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { accionUsuario },
                success: function(respuesta){
                    
                    //Si se ha modificado
                    if(respuesta=="si"){

                        mostrarUsuarios();
                        $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                        $("#modalInfo").modal('show');
                        setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                                
                    //Si no se ha modificdo
                    } else{
                    
                        mostrarUsuarios();
                        $("#infoModal").html('<p class="text-center text-danger pt-3"><ion-icon name="close-circle-outline"></ion-icon> <b>No ha podido realizar la acción,<br>revisa y modifica los datos introducidos</b></p>');
                        $("#modalInfo").modal('show');
                        setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                    }
                },
                // Si la petición falla, devuelve en consola el error producido y el estado
                error: function(estado, error) {
                    console.log("-Error producido: " + error + ". -Estado: " + estado)
                }
            });

        }
    });


});