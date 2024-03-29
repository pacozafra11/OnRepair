
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
                            botones = "<button type='button' class='actualizarUsuario btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button><button type='button' class='eliminarUsuario btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";

                        } else if($('#rol').text() === "Administrador"){
                            botones = "<button type='button' class='actualizarUsuario btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button><button type='button' class='eliminarUsuario btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";
                        }
                    }
                    id = buscado.id;
                    resultado +=
                    `<div class="row m-3" id="${id}">
                        <div class="${clase}">

                            <div class="row">
                                <div class="col-md-12 col-lg-2 pt-3">
                                    <span class="text-success font-weight-bold">Id: </span><span class="id">${id}</span>
                                </div>
                                <div class="col-md-12 col-lg-4 pt-3">
                                    <span class="text-success font-weight-bold">Nombre: </span><span class="nombre">${buscado.nombre}</span>
                                </div>
                                <div class="col-md-12 col-lg-3 pt-3">
                                    <span class="text-success font-weight-bold">Rol: </span><span class="rol">${buscado.rol}</span>
                                </div>
                                
                                <div class="col-md-12 col-lg-3 text-right mt-1">
                                    ${botones}
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-12 col-lg-6 pt-1">
                                    <span class="text-success font-weight-bold">Email: </span><span class="email">${buscado.email}</span>
                                </div>
                                <div class="col-md-12 col-lg-6 pt-1">
                                    <span class="text-success font-weight-bold">Bloqueado: </span><span class="bloqueado">${buscado.bloqueado}</span>
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



    
    /* Reinicia por completo los valores del modal */
    function borrarCamposModal(){
        $('#inputNombreUsuario').val("");
        $('#inputNombreUsuario').css("border", "none");
        $("#errNombre").hide();
        $('#inputEmailUsuario').val(""); 
        $('#inputEmailUsuario').css("border", "none");
        $("#errEmail").hide();
        $('#inputPasswordUsuario').val("");
        $('#inputPasswordUsuario').css("border", "none");
        $("#errPass").hide();
        $('#inputConfPassUsuario').val(""); 
        $('#inputConfPassUsuario').css("border", "none"); 
        $("#errConfPass").hide();     
    }


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalUsuario").on("hidden.bs.modal", function () {
        borrarCamposModal();
    });




    /* Función para mostrar los roles existentes en select del modal, con excepciones */
    function mostrarRoles(rol){
        let roles = "";
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { roles },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '';
                info.forEach(buscado => {

                    //Si la persona Logueada es "Administrador", muestra todos los valores de roles a tomar, incluido el de Administrador
                    if($('#rol').text() === "Administrador"){
                
                        //Si el formulario/modal es para Nuevo Usuario, se añade "selected" a la opción Técnico, para que sea valor prederterminado.
                        if($('#tituloModalUsuario').text() === 'Nuevo Usuario'){
                            buscado.nombre != "Responsable" ? rol_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>" : rol_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";
                            resultado += rol_selec;

                        //Si el formulario/modal es para Modificar Usuario, se añade "selected" a la opción que conincida con el valor que tiene ese usuario actualmente,
                        // para que sea valor prederterminado.
                        } else {
                            buscado.nombre == rol ? rol_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>" : rol_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";
                            resultado += rol_selec;
                        }
                     
                    //Si la persona Logueada NO es "Administrador", muestra todos los valores de roles a tomar, excepto el de Administrador
                    } else {
                        if(buscado.nombre != "Administrador"){
                            
                            //Si el formulario/modal es para Nuevo Usuario, se añade "selected" a la opción Técnico, para que sea valor prederterminado.
                            if($('#tituloModalUsuario').text() === 'Nuevo Usuario'){
                                buscado.nombre != "Responsable" ? rol_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>" : rol_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";
                                resultado += rol_selec;

                            //Si el formulario/modal es para Modificar Usuario, se añade "selected" a la opción que conincida con el valor que tiene ese usuario actualmente,
                            // para que sea valor prederterminado.
                            } else {
                                buscado.nombre == rol ? rol_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>" : rol_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";
                                resultado += rol_selec;
                            }
                        }                       
                    }                    
                });

                $("#inputRolUsuario").html(resultado);
                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }


    
    /* Al pulsar sobre de botón "Nuevo Usuario" en la página Usuarios */
    $(document).on("click", "#crearUsuario", function() {  
        let rol = 'Técnico';
        borrarCamposModal();        
        $('#tituloModalUsuario').text('Nuevo Usuario');
        mostrarRoles(rol);
        $('#filaPassword').show();
        $('#modalUsuario').modal('show');  
                    
    });



    /* Al pulsar sobre de botón "Actualizar" de algún registro*/
    $(document).on("click", ".actualizarUsuario", function() {  
        let id = $(this).parent().siblings().children().siblings('.id').text();           
        let nombre = $(this).parent().siblings().children().siblings('.nombre').text();
        var rol = $(this).parent().siblings().children().siblings('.rol').text();
        let email = $(this).parent().parent().siblings().children().children().siblings('.email').text();
        let bloque = $(this).parent().parent().siblings().children().children().siblings('.bloqueado').text();
         
        borrarCamposModal();   
        $('#tituloModalUsuario').text('Modificar Usuario');
        $('#inputIdUsuario').val(id);
        $('#inputNombreUsuario').val(nombre);
        mostrarRoles(rol);
        $('#inputEmailUsuario').val(email);
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



    /* Función con la llamada Ajax para pasar el parámetro accionUsuario con todos los datos recogidos para Crear, Modificar o Eliminar un usuario*/
    function accionUsuarios(accionUsuario){
        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionUsuario },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta == "si"){

                    $('#modalUsuario').modal('hide');
                    mostrarUsuarios();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificado
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
        });
    }



    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar */
    $(document).on("click", "#aceptarModalUsuario", function(e) {  
        //Detengo la acción por defecto del envío del formulario y su propagación
        e.preventDefault();
        e.stopPropagation();

        //Declaro los patrones a comparar
        let expNombre = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,50}$/;
        let expEmail = /^[a-z0-9ñÑ_\.\-]+@[a-z0-9\-]+\.[a-z0-9\-\.]+$/;  
        let expPass = /^[a-zA-Z0-9ñÑ\s]{4,20}$/;
        let accionUsuario;    
        let nuevo;

        //Recojo el valor de los campos rellenados
        let id = $('#inputIdUsuario').val();
        let nombre = $('#inputNombreUsuario').val();
        let rol = $('#inputRolUsuario').val();
        let email = $('#inputEmailUsuario').val();
        let bloque = $('#inputBloqueUsuario').val();
        let pass = $('#inputPasswordUsuario').val();
        let confpass = $('#inputConfPassUsuario').val();

        $('#tituloModalUsuario').text() === "Nuevo Usuario" ? nuevo = 1 : nuevo = 0;

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
                if(nuevo == 1){
                    
                    //Campo password o contraseña
                    if(!expPass.test(pass)){
                        $('#errPassword').fadeIn();
                        $('#inputPasswordUsuario').focus().css("border", "3px solid red");
                        return false;
    
                    } else {
                        $("#errPassword").hide();
                        $('#inputPasswordUsuario').css("border", "3px solid #03c003");
    
                        //Campo confirmación password o contraseña
                        if(confpass != pass){
                            $("#errConfPassword").fadeIn();
                            $('#inputConfPassUsuario').focus().css("border", "3px solid red");
                            return false;
                        
                        } else {
                            $("#errConfPassword").hide();
                            $('#inputConfPassUsuario').css("border", "3px solid #03c003");
                        }

                    }

                    //Recojo los datos
                    accionUsuario = {
                        accion: $('#tituloModalUsuario').text(),
                        id: 0,
                        nombre: nombre,
                        rol: rol,
                        email: email.toLowerCase(),     //Paso todos los caractéres a minúscula...por si acaso
                        bloque: bloque,
                        pass: pass
                    };
                    
                    //LLamo a la función y le paso los datos por paármetros para la petición Ajax
                    accionUsuarios(accionUsuario);

                } else {
                    //Recojo los datos
                    accionUsuario = {
                        accion: $('#tituloModalUsuario').text(),    //Paso todos los caractéres a minúscula...por si acaso
                        id: id,
                        nombre: nombre,
                        rol: rol,
                        email: email.toLowerCase(),
                        bloque: bloque,
                        pass: 0
                    };

                    //LLamo a la función y le paso los datos por paármetros para la petición Ajax
                    accionUsuarios(accionUsuario);
                }  
            }
        }                           
    });



    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarUsuario", function() {         
        let accionUsuario; 
        let id = $(this).parent().siblings().children().siblings('.id').text();           
        let nombre = $(this).parent().siblings().children().siblings('.nombre').text(); 

        if(confirm("¿Seguro que quieres borrar el Usuario: " + nombre + "?")){
            //Recojo los datos
            accionUsuario = {
                accion: "Borrar Usuario",
                id: id,
                nombre: "",
                rol: 0,
                email: "",
                bloque: 0,
                pass: 0
            };

            //LLamo a la función y le paso los datos por paármetros para la petición Ajax
            accionUsuarios(accionUsuario);
        }
    });


});