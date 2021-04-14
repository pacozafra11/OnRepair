
/* Página que contiene las funciones JavaScript que pertenecen a la página Mantenimientos 
*
*  @author Francisco José López Zafra
*/


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Funcion para mostrar todos los tipos de mantenimiento en la página "Tipos de Mantenimiento"
    function mostrarMantenimientos(){
        let manteni = "";
  
            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { manteni },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    let botones = "";
                    info.forEach(buscado => {
                        id = buscado.id;
                        if($('#rol').text() === "Administrador" || $('#rol').text() === "Responsable"){                            
                            botones = "<button type='button' class='actualizarManteni btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button>&nbsp<button type='button' class='eliminarManteni btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";
                        }
                        resultado +=`<tr id="${id}">
                            <td class="id align-middle">${id}</td>
                            <td class="nombre align-middle">${buscado.nombre}</td>                                        
                            <td class="botonesGrupos">
                                ${botones}                                
                            </td>
                        </tr>`;                                                
                              
                    });
  
                $("#cont_mostrar_mantenimientos").html(resultado);        
  
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)
  
            }
        });
    }

    /* Invoco la función */
    mostrarMantenimientos();


    /* Reinicia por completo los valores del modal */
    function borrarCamposModal(){
        $('#inputIdManteni').val("");
        $('#inputNombreManteni').val("");
        $('#inputNombreManteni').css("border", "none");
        $("#errNombreManteni").hide();        
    } 


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalManteni").on("hidden.bs.modal", function () {
        borrarCamposModal();
    });
    

    /* Al pulsar sobre de botón "Nuevo Tipo de Mantenimiento" en la página Tipos de Mantenimiento */
    $(document).on("click", "#crearManteni", function() {  
        borrarCamposModal();        
        $('#tituloModalManteni').text('Nuevo Tipo de Mantenimiento');
        $('#modalManteni').modal('show');  
                    
    });


    /* Al pulsar sobre de botón "Actualizar" de algún registro*/
    $(document).on("click", ".actualizarManteni", function() {             
        let id = $(this).parent().siblings('.id').text();
        let nombre = $(this).parent().siblings('.nombre').text();
         
        borrarCamposModal();   
        $('#tituloModalManteni').text('Modificar Tipo de Mantenimiento');
        $('#inputIdManteni').val(id);
        $('#inputNombreManteni').val(nombre);
        $('#modalManteni').modal('show');          
    });




    var accionManteni;

    /* Función con la llamada Ajax para pasar el parámetro accionManteni con todos los datos recogidos para Crear, Modificar o Eliminar un tipo de mantenimiento*/
    function accionMantenimiento(accionManteni){
        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionManteni },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta=="si"){

                    $('#modalManteni').modal('hide');
                    mostrarMantenimientos();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificdo
                } else{
                
                    $('#modalManteni').modal('hide');
                    mostrarMantenimientos();
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
    $(document).on("click", "#aceptarModalManteni", function(e) {         
        //Detengo la acción por defecto del envío del formulario y su propagación
        e.preventDefault();
        e.stopPropagation();
 
        //Declaro el patron a comparar
        let expNombre = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-\,\.\(\)\s]{3,50}$/;     
     
        //Recojo el valor del campo rellenado
        let id = $('#inputIdManteni').val();
        let nombre = $('#inputNombreManteni').val();         
         
        //Compruebo el campo y maqueto efectos en el formulario
        //Campo Nombre
        if(!expNombre.test(nombre)){
            $("#errNombreManteni").fadeIn();
            $('#inputNombreManteni').focus().css("border", "3px solid red");
            return false;

        } else {
            $("#errNombreManteni").hide();
            $('#inputNombreManteni').css("border", "3px solid #03c003");

            //Recojo los datos
            accionManteni = {
                accion: $('#tituloModalManteni').text(),
                id: id,
                nombre: nombre
            };
                    
            //LLamo a la función y le paso los datos por parámetro para la petición Ajax
            accionMantenimiento(accionManteni);            
        }
    }); 

    


    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarManteni", function() {         
        id = $(this).parent().siblings('.id').text();
        nombre = $(this).parent().siblings('.nombre').text(); 

        if(confirm("¿Seguro que quieres borrar el Tipo de Mantenimiento: " + nombre + "?")){
            //Recojo los datos
            accionManteni = {
                accion: "Borrar Tipo de Mantenimiento",
                id: id,
                nombre: nombre
            };

            //LLamo a la función y le paso los datos por parámetro para la petición Ajax
            accionMantenimiento(accionManteni);
        }
    });


});