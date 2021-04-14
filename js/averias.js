
/* Página que contiene las funciones JavaScript que pertenecen a la página Tipos de Averías
*
*  @author Francisco José López Zafra
*/


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Funcion para mostrar todos los tipos de averías en la página "Tipos de Averías"
    function mostrarAverias(){
        let averias = "";
  
            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { averias },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    let botones = "";
                    info.forEach(buscado => {
                        id = buscado.id;
                        if($('#rol').text() === "Administrador" || $('#rol').text() === "Responsable"){                            
                            botones = "<button type='button' class='actualizarAveria btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button>&nbsp<button type='button' class='eliminarAveria btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";
                        }
                        resultado +=`<tr id="${id}">
                            <td class="id align-middle">${id}</td>
                            <td class="nombre align-middle">${buscado.nombre}</td>                                        
                            <td class="botonesGrupos">
                                ${botones}
                            </td>
                        </tr>`;                                                
                              
                    });
  
                $("#cont_mostrar_averias").html(resultado);        
  
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)
  
            }
        });
    }

    /* Invoco la función */
    mostrarAverias();


    /* Reinicia por completo los valores del modal */
    function borrarCamposModal(){
        $('#inputIdAveria').val("");
        $('#inputNombreAveria').val("");
        $('#inputNombreAveria').css("border", "none");
        $("#errNombreAveria").hide();        
    } 


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalManteni").on("hidden.bs.modal", function () {
        borrarCamposModal();
    });

    

    /* Al pulsar sobre de botón "Nuevo Tipo de Averia" en la página Tipos de Averías */
    $(document).on("click", "#crearAveria", function() {  
        borrarCamposModal();        
        $('#tituloModalAveria').text('Nuevo Tipo de Averia');
        $('#modalAveria').modal('show');  
                    
    });


    /* Al pulsar sobre de botón "Actualizar" de algún registro*/
    $(document).on("click", ".actualizarAveria", function() {             
        let id = $(this).parent().siblings('.id').text();
        let nombre = $(this).parent().siblings('.nombre').text();
         
        borrarCamposModal();   
        $('#tituloModalAveria').text('Modificar Tipo de Averia');
        $('#inputIdAveria').val(id);
        $('#inputNombreAveria').val(nombre);
        $('#modalAveria').modal('show');          
    });


    
    var accionAveria;

    /* Función con la llamada Ajax para pasar el parámetro accionAveria con todos los datos recogidos para Crear, Modificar o Eliminar un tipo de avería*/
    function accionAverias(accionAveria){
         //Petición ajax
         $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionAveria },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta=="si"){

                    $('#modalAveria').modal('hide');
                    mostrarAverias();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificdo
                } else{
                
                    $('#modalAveria').modal('hide');
                    mostrarAverias();
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
    $(document).on("click", "#aceptarModalAveria", function(e) {         
        //Detengo la acción por defecto del envío del formulario y su propagación
        e.preventDefault();
        e.stopPropagation();
 
        //Declaro el patron a comparar
        let expNombre = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-\,\.\(\)\s]{3,50}$/;     
     
        //Recojo el valor del campo rellenado
        let id = $('#inputIdAveria').val();
        let nombre = $('#inputNombreAveria').val();         
         
        //Compruebo el campo y maqueto efectos en el formulario
        //Campo Nombre
        if(!expNombre.test(nombre)){
            $("#errNombreAveria").fadeIn();
            $('#inputNombreAveria').focus().css("border", "3px solid red");
            return false;

        } else {
            $("#errNombreAveria").hide();
            $('#inputNombreAveria').css("border", "3px solid #03c003");

            //Recojo los datos
            accionAveria = {
                accion: $('#tituloModalAveria').text(),
                id: id,
                nombre: nombre
            };
                    
            //LLamo a la función y le paso los datos por parámetro para la petición Ajax
            accionAverias(accionAveria);            
        }        
                    
    });


    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarAveria", function() {         
        id = $(this).parent().siblings('.id').text();
        nombre = $(this).parent().siblings('.nombre').text(); 

        if(confirm("¿Seguro que quieres borrar el Tipo de Averia: " + nombre + "?")){
            //Recojo los datos
            accionAveria = {
                accion: "Borrar Tipo de Averia",
                id: id,
                nombre: nombre
            };

            //LLamo a la función y le paso los datos por parámetro para la petición Ajax
            accionAverias(accionAveria);

        }
    });


});