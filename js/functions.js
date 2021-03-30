
$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Botón ocultar/mostrar menú lateral
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });



    /* al pulsar sobre alguna de las opciones del desplegable para reacer el oren a mostrar las tareas */
    $(document).on("click", ".ordenTareas ", function(e) {

        e.preventDefault();
        var orden = $(this).text();
        mostrarTareas(orden.substr(0,5));
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




    

    //Funcion para mostrar todas las tareas y sus datos en una tabla en la página "Tareas"
    function mostrarTareas(orden){
        let tareas = "";

        orden===undefined ? tareas = "fecha" : tareas = orden       

        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { tareas },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '';
                let id = "";
                info.forEach(buscado => {
                    buscado.finalizada==1 ? buscado.finalizada='Sí' : buscado.finalizada='No';
                    buscado.finalizada=='No' ? clase="col-lg-12 bg-warning text-light border" : clase="col-lg-12 bg-light text-dark border";
                    id = buscado.id;
                    resultado +=
                    `<div class="row p-2 pl-4 pr-4" id="${id}">
                        <div class="${clase}">

                            <table class="tablasTareas">
                                <tr>
                                    <td colspan="2"><span class="text-success font-weight-bold">Título </span>${buscado.titulo}</td>
                                    <td class="colDerecha text-right">
                                        <button type="button" class="actualizarTarea btn btn-outline-primary mt-2">
                                            <ion-icon name="create" class="pt-1"></ion-icon>
                                        </button> 
                                        &nbsp 
                                        <button type="button" class="eliminarTarea btn btn-outline-danger mt-2">
                                            <ion-icon name="trash" class="pt-1"></ion-icon>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="4"><span class="text-success font-weight-bold">Descripción </span><br>${buscado.descripcion}</td>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Máquina </span>${buscado.maquina}</td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Id </span>${id}</td> 
                                </tr>
                                <tr>                                    
                                    <td class="pl-3"><span class="text-success font-weight-bold">Técnico </span>${buscado.tecnico}</td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tiempo Empleado </span>${buscado.tiempo}h</td>                                          
                                </tr>
                                <tr>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Fecha </span>${buscado.fecha}</td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Avería </span>${buscado.averia}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Finalizada </span>${buscado.finalizada}</td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Mantenimiento </span>${buscado.mantenimiento}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">                                        
                                        <a class="mostrarRepuestosTarea nav-link dropdown-toggle text-info text-center" href="#">
                                            <ion-icon name="git-compare"></ion-icon> Repuestos utilizados
                                        </a>                                       
                                        
                                        <div id="r${id}" class="contRepuestosTarea row hide"></div>
                                    </td>                                    
                                </tr>                                
                            </table>  

                        </div>                   
                    </div>`;  
                });

            $("#cont_mostrar_tareas").html(resultado);
                            

          },
          // Si la petición falla, devuelve en consola el error producido y el estado
          error: function(estado, error) {
              console.log("-Error producido: " + error + ". -Estado: " + estado)

          }
      });
    }

    /* Invoco la función */
    mostrarTareas();





    /* Al pulsar sobre alguno de los botones "Repuestos utilizados" de cada tarea, invocará a la función que traerá la llamada, y mostrará u ocultará la información */
    $(document).on("click", ".mostrarRepuestosTarea", function(e) {
         
        e.preventDefault();
        var hermano = $(this).siblings();
        var clase = $(this).siblings().attr("class");

        if(clase == "contRepuestosTarea row hide"){
            var idTarea = $(this).closest(".row").attr("id");
            mostrarRepTareas(idTarea);
            $(hermano).toggleClass("hide");

        } else {
            $(hermano).toggleClass("hide");
            $(hermano).hide();           
        }    
                      
    });

    

    
    //Funcion para mostrar todos los repuestos usados en tareas en la página "Tareas", en una fila inferior de cada tarea
    function mostrarRepTareas(idTarea){
        let repTarea = idTarea;

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { repTarea },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";

                    if(typeof info !== "string"){
                        info.forEach(buscado => {                        
                        id = buscado.referencia + "_" + buscado.id;
                        resultado +=`<div class="align-text-bottom col-lg-4"><span class="text-success font-weight-bold">Referencia </span>${buscado.referencia}</div>
                                    <div class="align-text-bottom col-lg-6"><span class="text-success font-weight-bold">Nombre </span>${buscado.nombre}</div>  
                                    <div class="align-text-bottom col-lg-2"><span class="text-success font-weight-bold">Cantidad </span>${buscado.cantidad}</div>`;                    
                        });
                    } else {
                        resultado +=`<div class="align-text-bottom col-lg-12 text-secondary">${info}</div>`; 
                    }

                $("#r" + idTarea).html(resultado);        

            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });
    }

   






});