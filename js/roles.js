
/* Página que contiene las funciones JavaScript que pertenecen a la página Roles 
*
*  @author Francisco José López Zafra
*/


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Funcion para mostrar todos los roles de usuario en la página "Roles", esta página es solo accesible para el "Administrador".
    function mostrarRoles(){
        let roles = "";

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { roles },
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
                                <button type="button" class="actualizarRol btn btn-outline-primary">
                                    <ion-icon name="create" class="pt-1"></ion-icon>
                                </button> 
                                &nbsp 
                                <button type="button" class="eliminarRol btn btn-outline-danger">
                                    <ion-icon name="trash" class="pt-1"></ion-icon>
                                </button>
                            </td>
                        </tr>`;                                                
                            
                    });

                $("#cont_mostrar_roles").html(resultado);        

            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });
    }

    /* Invoco la función */
    mostrarRoles();



    /* Al pulsar sobre de botón "Nuevo Rol" en la página Rol */
    $(document).on("click", "#crearRol", function() {  
        $('#inputNombreRol').removeAttr("value");
        $('#inputIdRol').removeAttr("value");        
        $('#tituloModalRol').text('Nuevo Rol');
        $('#modalRol').modal('show');  
                    
    });


    /* Al pulsar sobre de botón "Actualizar" de algún registro rol */
    $(document).on("click", ".actualizarRol", function() {             
        let id = $(this).parent().siblings('.id').text();
        let nombre = $(this).parent().siblings('.nombre').text();
        
        $('#inputNombreRol').removeAttr("value");
        $('#inputIdRol').removeAttr("value");  
        $('#tituloModalRol').text('Modificar Rol');
        $('#inputIdRol').attr("value", id);
        $('#inputNombreRol').attr("value", nombre);
        $('#modalRol').modal('show');              
    });



    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar rol */
    $(document).on("click", "#aceptarModalRol", function() {         
        let accionRol;

        if($('#tituloModalRol').text()=="Nuevo Rol") { 

            //Recojo los datos
            accionRol = {
                accion: $('#tituloModalRol').text(),
                id: 0,
                nombre: $('#inputNombreRol').val()
            };
        
        } else if($('#tituloModalRol').text()=="Modificar Rol"){

            //Recojo los datos
            accionRol = {
                accion: $('#tituloModalRol').text(),
                id: $('#inputIdRol').val(),
                nombre: $('#inputNombreRol').val()
            };

        }

        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionRol },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta=="si"){

                    $('#modalRol').modal('hide');
                    mostrarRoles();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificdo
                } else{
                
                    $('#modalRol').modal('hide');
                    mostrarRoles();
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


    /* Al pulsar sobre el botón "Borrar" de algún registro rol */
    $(document).on("click", ".eliminarRol", function() {         
        let accionRol; 
        id = $(this).parent().siblings('.id').text();
        nombre = $(this).parent().siblings('.nombre').text(); 

        if(confirm("¿Seguro que quieres borrar el Rol: " + nombre + "?")){
            //Recojo los datos
            accionRol = {
                accion: "Borrar Rol",
                id: id,
                nombre: nombre
            };

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { accionRol },
                success: function(respuesta){
                    
                    //Si se ha modificado
                    if(respuesta=="si"){

                        mostrarRoles();
                        $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                        $("#modalInfo").modal('show');
                        setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                                
                    //Si no se ha modificdo
                    } else{
                    
                        mostrarRoles();
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