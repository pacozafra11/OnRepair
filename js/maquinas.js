
/* Página que contiene las funciones JavaScript que pertenecen a la página de Máquinas
*
*  @author Francisco José López Zafra
*/


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Funcion para mostrar todas las máquinas y sus datos en una tabla en la página "Maquinas"
    function mostrarMaquinas(){
        let maquinas = "";

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { maquinas },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    let botones = "";
                    info.forEach(buscado => {
                        id = buscado.id;
                        if($('#rol').text() === "Administrador" || $('#rol').text() === "Responsable"){                            
                            botones = "<button type='button' class='actualizarMaquina btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button><button type='button' class='eliminarMaquina btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";
                        }
                        resultado +=
                        `<div class="row m-3" id="${id}">
                            <div class="col-lg-12 bg-light text-dark border pt-2">                               
                                <div class="row">
                                    <div class="col-lg-1">
                                        <span class="text-success font-weight-bold">Id: </span><span class="id">${id}</span>
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="text-success font-weight-bold">Nombre: </span><br><span class="nombre">${buscado.nombre}</span>
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="text-success font-weight-bold">Marca: </span><br><span class="marca">${buscado.marca}</span>
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="text-success font-weight-bold">Modelo: </span><br><span class="modelo">${buscado.modelo}</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <span class="text-success font-weight-bold">Grupo de Máquina: </span><br><span class="grupo">${buscado.grupo}</span>
                                    </div>
                                    <div class="col-lg-2"> 
                                        ${botones}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 pt-2 pb-2">
                                        <span class="text-success font-weight-bold">Descripción: </span><span class="desc text-muted">${buscado.descripcion}</span>
                                    </div>
                                </div>    
                                                        
                            </div>                   
                        </div>`;  
                    });

                $("#cont_mostrar_maquinas").html(resultado);        
                            

            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });
    }

    /* Invoco la función */
    mostrarMaquinas();





    /* Reinicia por completo los valores del modal */
    function borrarCamposModal(){
        $('#inputIdMaquina').val("");
        $('#inputNombreMaquina').val("");
        $('#inputNombreMaquina').css("border", "none");
        $("#errNombreMaquina").hide();
        $('#inputMarcaMaquina').val("");        
        $('#inputMarcaMaquina').css("border", "none");
        $("#errMarcaMaquina").hide();
        $('#inputModeloMaquina').val(""); 
        $('#inputModeloMaquina').css("border", "none"); 
        $("#errModeloMaquina").hide(); 
        // $('#inputGrupoMaquina').val("");
        $('#inputGrupoMaquina').css("border", "none"); 
        $("#errGrupoMaquina").hide(); 
        $('#inputDescMaquina').val(""); 
        $('#inputDescMaquina').css("border", "none"); 
        $("#errDescMaquina").hide();     
    }


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalMaquina").on("hidden.bs.modal", function () {
        borrarCamposModal();
    });




    /* Función para mostrar los grupos de maquinas existentes en select del modal */
    function mostrarGrupos(grupo){
        let grupos = "";
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { grupos },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '<option value="0" class="text-muted">Elegir una opción ...</option>"';
                info.forEach(buscado => {                    
                
                    //Si el formulario/modal es para Nuevo, se añade "selected" a la opción "Elegir una opción", para que sea valor prederterminado.
                    if($('#tituloModalMaquina').text() === 'Nueva Máquina'){
                        resultado += "<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";

                    //Si el formulario/modal es para Modificar, se añade "selected" a la opción que conincida con el valor que tiene ese grupo actualmente,
                    // para que sea valor prederterminado.
                    } else {
                        buscado.nombre != grupo ? grupo_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>" : grupo_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>";
                        resultado += grupo_selec;
                    }                                                         
                });

                $("#inputGrupoMaquina").html(resultado);                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }



    /* Al pulsar sobre de botón "Nueva Máquina" en la página Máquinas */
    $(document).on("click", "#crearMaquina", function() { 
        let grupo = ''; 
        borrarCamposModal();        
        $('#tituloModalMaquina').text('Nueva Máquina');
        mostrarGrupos(grupo);
        $('#modalMaquina').modal('show');  
                    
    });




    /* Función con la llamada Ajax para pasar el parámetro accionRepuesto con todos los datos recogidos para Crear, Modificar o Eliminar una Maquina*/
    function accionMaquinas(accionMaquina){
        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionMaquina },
            success: function(respuesta){
                
                //Si se ha modificado
                if(respuesta == "si"){

                    $('#modalMaquina').modal('hide');
                    mostrarMaquinas();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificado
                } else{
                
                    $('#modalMaquina').modal('hide');
                    mostrarMaquinas();
                    $("#infoModal").html('<p class="text-center text-danger pt-3"><ion-icon name="close-circle-outline"></ion-icon> <b>No ha podido realizar la acción, revisa y modifica los datos introducidos</b></p>');
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
    var accionMaquina;


     /* Al pulsar sobre de botón "Actualizar" de algún registro*/
     $(document).on("click", ".actualizarMaquina", function() {  
        id = $(this).parent().siblings().children().siblings('.id').text();           
        let nombre = $(this).parent().siblings().children().siblings('.nombre').text();
        let marca = $(this).parent().siblings().children().siblings('.marca').text();
        let modelo = $(this).parent().siblings().children().siblings('.modelo').text();
        let grupo = $(this).parent().siblings().children().siblings('.grupo').text();
        let desc = $(this).parent().parent().siblings().children().children().siblings('.desc').text();  
         
        borrarCamposModal();   
        $('#tituloModalMaquina').text('Modificar Maquina');
        $('#inputIdMaquina').val(id);
        $('#inputNombreMaquina').val(nombre);
        $('#inputMarcaMaquina').val(marca);
        $('#inputModeloMaquina').val(modelo);
        mostrarGrupos(grupo);
        $('#inputDescMaquina').val(desc);
        $('#modalMaquina').modal('show');          
    });





});