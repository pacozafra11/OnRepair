
/* Página que contiene las funciones JavaScript que pertenecen a la página Grupos de Máquinas
*
*  @author Francisco José López Zafra
*/


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Funcion para mostrar todos los grupos de máquinas en la página "Grupos de máquinas"
    function mostrarGrupos(){
        let grupos = "";
  
            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { grupos },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    info.forEach(buscado => {
                        id = buscado.id;
                        resultado +=`<tr id="${id}">
                            <td class="id align-middle">${id}</td>
                            <td class="nombre align-middle">${buscado.nombre}</td>                                        
                            <td class="botonesGrupos text-right">
                                <button type="button" class="actualizarGrupo btn btn-outline-primary">
                                    <ion-icon name="create" class="pt-1"></ion-icon>
                                </button> 
                                &nbsp 
                                <button type="button" class="eliminarGrupo btn btn-outline-danger">
                                    <ion-icon name="trash" class="pt-1"></ion-icon>
                                </button>
                            </td>
                        </tr>`;                 
                    });
  
                $("#cont_mostrar_grupos").html(resultado);        
                             
  
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)
  
            }
        });
    }

    /* Invoco la función */
    mostrarGrupos();

    
    /* Borrar los campos del modal */
    function borrarCamposModal(){
        $('#inputNombreGrupo').val("");
        $('#inputIdGrupo').val("");
    }


    /* Al pulsar sobre de botón "Nuevo Grupo de Máquinas" en la página Grupos de Máquinas */
    $(document).on("click", "#crearGrupo", function() {  
        borrarCamposModal();        
        $('#tituloModalGrupo').text('Nuevo Grupo de Máquinas');
        $('#modalGrupo').modal('show');  
                    
    });


    /* Al pulsar sobre de botón "Actualizar" de algún registro*/
    $(document).on("click", ".actualizarGrupo", function() {             
        let id = $(this).parent().siblings('.id').text();
        let nombre = $(this).parent().siblings('.nombre').text();
         
        borrarCamposModal();   
        $('#tituloModalGrupo').text('Modificar Grupo de Máquinas');
        $('#inputIdGrupo').val(id);
        $('#inputNombreGrupo').val(nombre);
        $('#modalGrupo').modal('show');          
    });


    /* Al pulsar sobre de botón "Cancelar" del Modal vacío los campos*/
    $(document).on("click", "#cancelarModalGrupo", function() {              
        borrarCamposModal();  
        $('#modalGrupo').modal('hide');          
    });


    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar */
    $(document).on("click", "#aceptarModalGrupo", function() {         
        let accionGrupo;

        if($('#tituloModalGrupo').text()=="Nuevo Grupo de Máquinas") { 

            //Recojo los datos
            accionGrupo = {
                accion: $('#tituloModalGrupo').text(),
                id: 0,
                nombre: $('#inputNombreGrupo').val()
            };
        
        } else if($('#tituloModalGrupo').text()=="Modificar Grupo de Máquinas"){

            //Recojo los datos
            accionGrupo = {
                accion: $('#tituloModalGrupo').text(),
                id: $('#inputIdGrupo').val(),
                nombre: $('#inputNombreGrupo').val()
            };

        }

        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionGrupo },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta=="si"){

                    $('#modalGrupo').modal('hide');
                    mostrarGrupos();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificdo
                } else{
                
                    $('#modalGrupo').modal('hide');
                    mostrarGrupos();
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
                    
    });


    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarGrupo", function() {         
        let accionGrupo; 
        id = $(this).parent().siblings('.id').text();
        nombre = $(this).parent().siblings('.nombre').text(); 

        if(confirm("¿Seguro que quieres borrar el Grupo de Máquinas: " + nombre + "?")){
            //Recojo los datos
            accionGrupo = {
                accion: "Borrar Grupo de Máquinas",
                id: id,
                nombre: nombre
            };

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { accionGrupo },
                success: function(respuesta){
                    
                    //Si se ha modificado
                    if(respuesta=="si"){

                        mostrarGrupos();
                        $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                        $("#modalInfo").modal('show');
                        setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                                
                    //Si no se ha modificdo
                    } else{
                    
                        mostrarGrupos();
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