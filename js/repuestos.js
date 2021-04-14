
/* Página que contiene las funciones JavaScript que pertenecen a la página Repuestos
*
*  @author Francisco José López Zafra
*/


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Funcion para mostrar todas los repuestos y sus datos en una tabla en la página "Repuestos"
    function mostrarRepuestos(){
        let repuestos = "";

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { repuestos },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    let botones = "";
                    info.forEach(buscado => {
                        id = buscado.referencia;
                        if($('#rol').text() === "Administrador" || $('#rol').text() === "Responsable"){                            
                            botones = "<button type='button' class='actualizarRepuesto btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button><button type='button' class='eliminarRepuesto btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";
                        }
                        resultado +=
                        `<div class="row m-3" id="${id}">
                            <div class="col-lg-12 bg-light text-dark border">

                                <div class="row">
                                    <div class="col-md-12 col-lg-4 pt-3">
                                        <span class="text-success font-weight-bold">Referencia: </span><span class="id">${id}</span>
                                    </div>
                                    <div class="col-md-12 col-lg-5 pt-3">
                                        <span class="text-success font-weight-bold">Nombre: </span><span class="nombre">${buscado.nombre}</span>
                                    </div>
                                    <div class="col-md-12 col-lg-3 text-right mt-2">
                                        ${botones}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12  pt-2 pb-2">
                                        <span class="text-success font-weight-bold">Descripción: </span><span class="desc text-muted">${buscado.descripcion}</span>
                                    </div>
                                </div>
                                                    
                            </div>                   
                        </div>`;  
                    });

                $("#cont_mostrar_repuestos").html(resultado);        
                            

            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });
    }

    /* Invoco la función */
    mostrarRepuestos();




    /* Reinicia por completo los valores del modal */
    function borrarCamposModal(){
        $('#inputIdRepuesto').val("");
        $('#inputIdRepuesto').css("border", "none");
        $("#errIdRepuesto").hide();
        $('#inputNombreRepuesto').val("");
        $('#inputNombreRepuesto').css("border", "none");
        $("#errNombreRepuesto").hide();
        $('#inputDescRepuesto').val(""); 
        $('#inputDescRepuesto').css("border", "none"); 
        $("#errDescRepuesto").hide();     
    }


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalRepuesto").on("hidden.bs.modal", function () {
        borrarCamposModal();
    });



    /* Al pulsar sobre de botón "Nuevo Repuesto" en la página Repuestos */
    $(document).on("click", "#crearRepuesto", function() {  
        borrarCamposModal();        
        $('#tituloModalRepuesto').text('Nuevo Repuesto');
        $('#modalRepuesto').modal('show');  
                    
    });



    /* Función con la llamada Ajax para pasar el parámetro accionRepuesto con todos los datos recogidos para Crear, Modificar o Eliminar un repuesto*/
    function accionRepuestos(accionRepuesto){
        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionRepuesto },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta == "si"){

                    $('#modalRepuesto').modal('hide');
                    mostrarRepuestos();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificado
                } else{
                
                    $('#modalRepuesto').modal('hide');
                    mostrarRepuestos();
                    $("#infoModal").html('<p class="text-center text-danger pt-3"><ion-icon name="close-circle-outline"></ion-icon> <b>No ha podido realizar la acción, revisa y modifica los datos introducidos, puede ser que la referencia exista en otro repuesto</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2500); //Temporizador para desaparecer el mensaje
                }
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)
            }
        });
    }



    //Variables generales
    var id;
    var accionRepuesto;


    /* Al pulsar sobre de botón "Actualizar" de algún registro*/
    $(document).on("click", ".actualizarRepuesto", function() {  
        id = $(this).parent().siblings().children().siblings('.id').text();           
        let nombre = $(this).parent().siblings().children().siblings('.nombre').text();
        let desc = $(this).parent().parent().siblings().children().children().siblings('.desc').text();       
         
        borrarCamposModal();   
        $('#tituloModalRepuesto').text('Modificar Repuesto');
        $('#inputIdRepuesto').val(id);
        $('#inputNombreRepuesto').val(nombre);
        $('#inputDescRepuesto').val(desc);
        $('#modalRepuesto').modal('show');          
    });



    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar */
    $(document).on("click", "#aceptarModalRepuesto", function(e) {  
        //Detengo la acción por defecto del envío del formulario y su propagación
        e.preventDefault();
        e.stopPropagation();

        //Declaro los patrones a comparar
        let expRef = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-\,\.\(\)\s]{3,12}/;
        let expNombre = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-\,\.\(\)\s]{3,50}$/;  
        let expDesc = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-\,\.\(\)\s]{0,800}$/;    
    
        //Recojo el valor de los campos rellenados
        let ref = $('#inputIdRepuesto').val();
        let nombre = $('#inputNombreRepuesto').val();
        let desc = $('#inputDescRepuesto').val();
        let id_old;
        
        //Compruebo cada campo y maqueto efectos en el formulario
        //Campo Referencia
        if(!expRef.test(ref)){
            $("#errIdRepuesto").fadeIn();
            $('#inputIdRepuesto').focus().css("border", "3px solid red");
            return false;
        
        } else {
            $("#errIdRepuesto").hide();
            $('#inputIdRepuesto').css("border", "3px solid #03c003");

            //Campo Nombre
            if(!expNombre.test(nombre)){
                $("#errNombreRepuesto").fadeIn();
                $('#inputNombreRepuesto').focus().css("border", "3px solid red");
                return false;

            } else {
                $("#errNombreRepuesto").hide();
                $('#inputNombreRepuesto').css("border", "3px solid #03c003");


                //Campo Descripcion
                if(!expDesc.test(desc)){
                    $("#errDescRepuesto").fadeIn();
                    $('#inputDescRepuesto').focus().css("border", "3px solid red");
                    return false;

                } else {
                    $("#errDescRepuesto").hide();
                    $('#inputDescRepuesto').css("border", "3px solid #03c003");
                    
                    $('#tituloModalRepuesto').text() == 'Modificar Repuesto' ? id_old = id : id_old = ref;

                    //Recojo los datos
                    accionRepuesto = {
                        accion: $('#tituloModalRepuesto').text(),
                        id_old: id_old,
                        id_new: ref,
                        nombre: nombre,
                        desc: desc
                    };
                   
                    //LLamo a la función y le paso los datos por parámetros para la petición Ajax
                    accionRepuestos(accionRepuesto);
                }
            }
        }                           
    });



    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarRepuesto", function() {        
        id = $(this).parent().siblings().children().siblings('.id').text();           
        let nombre = $(this).parent().siblings().children().siblings('.nombre').text();

        if(confirm("¿Seguro que quieres borrar el Repuesto: " + nombre + "?")){
            //Recojo los datos
            accionRepuesto = {
                accion: "Borrar Repuesto",
                id_old: id,
                id_new: "",
                nombre: nombre,
                desc: ""
            };

            //LLamo a la función y le paso los datos por parámetros para la petición Ajax
            accionRepuestos(accionRepuesto);
        }
    });




});