
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


    /* Reinicia por completo los valores del modal */
    function borrarCamposModal(){
        $('#inputIdRol').val("");
        $('#inputNombreRol').val("");
        $('#inputNombreRol').css("border", "none");
        $("#errNombreRol").hide();        
    } 


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalRol").on("hidden.bs.modal", function () {
        borrarCamposModal();
    });
    


    /* Al pulsar sobre de botón "Nuevo Rol" en la página Rol */
    $(document).on("click", "#crearRol", function() {  
        borrarCamposModal();         
        $('#tituloModalRol').text('Nuevo Rol');
        $('#inputIdRol').val("");
        $('#modalRol').modal('show');  
                    
    });


    /* Al pulsar sobre de botón "Actualizar" de algún registro */
    $(document).on("click", ".actualizarRol", function() {             
        let id = $(this).parent().siblings('.id').text();
        let nombre = $(this).parent().siblings('.nombre').text();
        
        borrarCamposModal();   
        $('#tituloModalRol').text('Modificar Rol');
        $('#inputIdRol').val(id);
        $('#inputNombreRol').val(nombre);
        $('#modalRol').modal('show');              
    });


    /* Al pulsar sobre de botón "Cancelar" del Modal vacío los campos*/
    $(document).on("click", "#cancelarModalRol", function() {             
        borrarCamposModal();  
        $('#modalRol').modal('hide');          
    });


    var accionRol;

    /* Función con la llamada Ajax para pasar el parámetro accionRol con todos los datos recogidos para Crear, Modificar o Eliminar un rol*/
    function accionRoles(accionRol){
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
    }




    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar */
    $(document).on("click", "#aceptarModalRol", function(e) {  
        //Detengo la acción por defecto del envío del formulario y su propagación
        e.preventDefault();
        e.stopPropagation();
 
        //Declaro el patron a comparar
        let expNombre = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]{3,20}$/;     
     
        //Recojo el valor del campo rellenado
        let id = $('#inputIdRol').val();
        let nombre = $('#inputNombreRol').val();         
         
        //Compruebo el campo y maqueto efectos en el formulario
        //Campo Nombre
        if(!expNombre.test(nombre)){
            $("#errNombreRol").fadeIn();
            $('#inputNombreRol').focus().css("border", "3px solid red");
            return false;

        } else {
            $("#errNombreRol").hide();
            $('#inputNombreRol').css("border", "3px solid #03c003");

            //Recojo los datos
            accionRol = {
                accion: $('#tituloModalRol').text(),
                id: id,
                nombre: nombre
            };
                    
            //LLamo a la función y le paso los datos por parámetro para la petición Ajax
            accionRoles(accionRol);            
        }
    }); 

               


    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarRol", function() {         
        id = $(this).parent().siblings('.id').text();
        nombre = $(this).parent().siblings('.nombre').text(); 

        if(confirm("¿Seguro que quieres borrar el Rol: " + nombre + "?")){
            //Recojo los datos
            accionRol = {
                accion: "Borrar Rol",
                id: id,
                nombre: nombre
            };

            //LLamo a la función y le paso los datos por parámetro para la petición Ajax
            accionRoles(accionRol);

        }
    });


});