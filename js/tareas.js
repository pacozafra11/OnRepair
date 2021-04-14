
$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.


    /* al pulsar sobre alguna de las opciones del desplegable para reacer el oren a mostrar las tareas */
    $(document).on("click", ".ordenTareas ", function(e) {
        e.preventDefault();

        var orden = $(this).text();
        $('#dropdownMenuOffset').text(orden);
        mostrarTareas(orden.substr(0,5));
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
                let botones = "";
                info.forEach(buscado => {
                    buscado.finalizada==1 ? buscado.finalizada='Sí' : buscado.finalizada='No';
                    buscado.finalizada=='No' ? clase="col-lg-12 bg-warning text-light border" : clase="col-lg-12 bg-light text-dark border";
                    id = buscado.id;
                    if($('#rol').text() === "Administrador" || $('#rol').text() === "Responsable"){                            
                        botones = "<button type='button' class='eliminarTarea btn btn-outline-danger m-1'><ion-icon name='trash' class='pt-1'></ion-icon></button>";
                    }
                    resultado +=
                    `<div class="row p-2 pl-4 pr-4" id="${id}">
                        <div class="${clase}">

                            <table class="tablasTareas">
                                <tr>
                                    <td colspan="2"><span class="text-success font-weight-bold">Título </span><span class="titulo">${buscado.titulo}</span></td>
                                    <td class="colDerecha text-right">
                                        <button type='button' class='actualizarTarea btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button>&nbsp
                                        ${botones}
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="4"><span class="text-success font-weight-bold">Descripción </span><br><span class="desc">${buscado.descripcion}</span></td>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Máquina </span><span class="maquina">${buscado.maquina}</span></td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Id </span><span class="id">${id}</span></td> 
                                </tr>
                                <tr>                                    
                                    <td class="pl-3"><span class="text-success font-weight-bold">Técnico </span><span class="tecnico">${buscado.tecnico}</span></td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tiempo Empleado </span><span class="tiempo">${buscado.tiempo}</span> h</td>                                          
                                </tr>
                                <tr>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Fecha </span><span class="fecha">${buscado.fecha}</td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Avería </span><span class="averia">${buscado.averia}</span></td>
                                </tr>
                                <tr>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Finalizada </span><span class="final">${buscado.finalizada}</span></td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Mantenimiento </span><span class="mant">${buscado.mantenimiento}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="3">                                        
                                        <a class="mostrarRepuestosTarea nav-link dropdown-toggle text-info text-center" href="#">
                                            <ion-icon name="git-compare"></ion-icon> Repuestos utilizados
                                        </a>                                       
                                        
                                        <div id="r${id}" class="contRepuestosTarea container-fluid hide"></div>
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



    
    /* Reinicia por completo los valores del modal */
    function borrarCamposModal(){
        $('#inputIdTarea').val("");

        $('#inputTituloTarea').val("");
        $('#inputTituloTarea').css("border", "none");
        $("#errTituloTarea").hide();

        //$('#inputFechaTarea').val("");        
        $('#inputFechaTarea').css("border", "none");
        $("#errFechaTarea").hide();

        //$('#inputTiempoTarea').val(""); 
        $('#inputTiempoTarea').css("border", "none"); 
        $("#errTiempoTarea").hide(); 

        //$('#inputMaquinaTarea').val(""); 
        $('#inputMaquinaTarea').css("border", "none"); 
        $("#errMaquinaTarea").hide(); 

        //$('#inputTecnicoTarea').val(""); 
        $('#inputTecnicoTarea').css("border", "none"); 
        $("#errTecnicoTarea").hide(); 

        //$('#inputAveriaTarea').val(""); 
        $('#inputAveriaTarea').css("border", "none"); 
        $("#errAveriaTarea").hide(); 

        //$('#inputMantTarea').val(""); 
        $('#inputMantTarea').css("border", "none"); 
        $("#errMantTarea").hide();

        $('#inputDescTarea').val(""); 
        $('#inputDescTarea').css("border", "none"); 
        $("#errDescTarea").hide();     
    }


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalTarea").on("hidden.bs.modal", function () {
        borrarCamposModal();
    });




    /* Función para mostrar la fecha en el modal, si recibe fecha por parámetro es la que coge por valor, si no, 
    el valor tomado es la fecha actual en el momento de abrir el modal */
    function mostrarFecha(fecha){
        let mes = "";
        let dia = "";
        let ano = "";

        if(fecha==""){
            var fecha2 = new Date(); //Fecha actual
            fecha = fecha2;

            mes = fecha.getMonth()+1; //obteniendo mes
            dia = fecha.getDate(); //obteniendo dia
            ano = fecha.getFullYear(); //obteniendo año
            if(dia<10)
            dia='0'+dia; //agrega cero si el menor de 10
            if(mes<10)
            mes='0'+mes //agrega cero si el menor de 10
        
            $('#inputFechaTarea').val(ano+"-"+mes+"-"+dia);

        } else {
            $('#inputFechaTarea').val(fecha);
        }

        
    }



    /* Función para mostrar la hora en el modal, en el input para indicar el tiempo empleado */
    function mostrarTiempos(tiempo){

        //Si no recibe tiempo, parámetro vacío, pone como valor 0
        if(tiempo==""){
            $('#inputTiempoTarea').val("");

        //Si recibe parámetro adapta el formato y lo introduce como valor
        } else {
            $('#inputTiempoTarea').val("0" + tiempo.replace(".",':'));
        }
    }



    /* Función para comprobar el campo tiempo y formatearlo a double para almacenar en base de datos */
    function comprobarTiempo(tiempo){
        //Patron para comparar
        let expTiempo = /[0-9]{2}:[0-9]{2}$/;

        //Declaro variable
        let resultado = false;

        if(tiempo != "" || tiempo != null || tiempo != "undefined"){
            
            if(expTiempo.test(tiempo)){
                tiempo = tiempo.replace(":", ".");
                tiempo = parseFloat(tiempo);

                if(tiempo>=0.15 && tiempo<=8.00){            
                    resultado = true;

                } else {
                    resultado = false;
                }

            } else {
                resultado = false;
            }
            
        } else {
            resultado = false;
        }

        return resultado;
    }




    /* Función para mostrar si la tarea es finalizada o no, en caso de nueva tarea, el valor seleccionado va a ser Sí por defecto */
    function mostrarFinalizadas(final){
        let resultado = '';

        //Si el formulario/modal es para Nuevo, se añade "selected" a la opción "Sí", para que sea valor predeterminado.
        if($('#tituloModalTarea').text() === 'Nueva Tarea'){
            resultado += "<option value='1' selected>Sí</option><option value='0'>No</option>";

        //Si el formulario/modal es para Modificar, se añade "selected" a la opción que coincida con el valor que tiene ese grupo actualmente,
        // para que sea valor prederterminado.
        } else {
            final === "No" ? final_selec="<option value='1'>Sí</option><option value='0' selected>No</option>" : final_selec="<option value='1' selected>Sí</option><option value='0'>No</option>";
            resultado += final_selec;
        }

        $('#inputFinalTarea').html(resultado); 
    }




    /* Función para mostrar las máquinas existentes en select del modal */
    function mostrarMaquinas(maquina){
        let maquinas = "";
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { maquinas },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '<option value="0" class="text-muted">Elegir una máquina ...</option>"';
                info.forEach(buscado => {                    
                
                    //Si el formulario/modal es para Nuevo, se añade "selected" a la opción "Elegir una máquina", para que sea valor predeterminado.
                    if($('#tituloModalTarea').text() === 'Nueva Tarea'){
                        resultado += "<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";

                    //Si el formulario/modal es para Modificar, se añade "selected" a la opción que coincida con el valor que tiene ese grupo actualmente,
                    // para que sea valor prederterminado.
                    } else {
                        buscado.nombre != maquina ? maquina_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>" : maquina_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>";
                        resultado += maquina_selec;
                    }                                                         
                });

                $("#inputMaquinaTarea").html(resultado);                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }


    /* Función para mostrar los técnicos existentes en select del modal */
    function mostrarTecnicos(tecnico){
        let usuarios = "";
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { usuarios },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '<option value="0" class="text-muted">Elegir un técnico ...</option>"';
                info.forEach(buscado => {                    
                
                    //Si el formulario/modal es para Nuevo, se añade "selected" a la opción "Elegir un técnico", para que sea valor prederterminado.
                    if($('#tituloModalTarea').text() === 'Nueva Tarea'){
                        resultado += "<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";

                    //Si el formulario/modal es para Modificar, se añade "selected" a la opción que conincida con el valor que tiene ese grupo actualmente,
                    // para que sea valor prederterminado.
                    } else {
                        buscado.nombre != tecnico ? tecnico_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>" : tecnico_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>";
                        resultado += tecnico_selec;
                    }                                                         
                });

                $("#inputTecnicoTarea").html(resultado);                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }


    /* Función para mostrar los tipos de mantenimientos existentes en select del modal */
    function mostrarMantenimientos(mante){
        let manteni = "";
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { manteni },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '<option value="0" class="text-muted">Elegir un tipo ...</option>"';
                info.forEach(buscado => {                    
                
                    //Si el formulario/modal es para Nuevo, se añade "selected" a la opción "Elegir un tipo", para que sea valor prederterminado.
                    if($('#tituloModalTarea').text() === 'Nueva Tarea'){
                        resultado += "<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";

                    //Si el formulario/modal es para Modificar, se añade "selected" a la opción que conincida con el valor que tiene ese mantenimiento actualmente,
                    // para que sea valor prederterminado.
                    } else {
                        buscado.nombre != mante ? mante_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>" : mante_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>";
                        resultado += mante_selec;
                    }                                                         
                });

                $("#inputMantTarea").html(resultado);                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }




     /* Función para mostrar los tipos de averias existentes en select del modal */
     function mostrarAverias(averia){
        let averias = "";
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { averias },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '<option value="0" class="text-muted">Elegir un tipo ...</option>"';
                info.forEach(buscado => {                    
                
                    //Si el formulario/modal es para Nuevo, se añade "selected" a la opción "Elegir un tipo", para que sea valor prederterminado.
                    if($('#tituloModalTarea').text() === 'Nueva Tarea'){
                        resultado += "<option value='" + buscado.id + "'>" + buscado.nombre + "</option>";

                    //Si el formulario/modal es para Modificar, se añade "selected" a la opción que conincida con el valor que tiene ese grupo actualmente,
                    // para que sea valor prederterminado.
                    } else {
                        buscado.nombre != averia ? averia_selec="<option value='" + buscado.id + "'>" + buscado.nombre + "</option>" : averia_selec="<option value='" + buscado.id + "' selected>" + buscado.nombre + "</option>";
                        resultado += averia_selec;
                    }                                                         
                });

                $("#inputAveriaTarea").html(resultado);                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }



        /* Al pulsar sobre de botón "Nueva Tarea" en la página Tareas */
        $(document).on("click", "#crearTarea", function() { 
            let fecha = '';
            let tiempo = '';
            let final = '';
            let maquina = ''; 
            let tecnico = ''; 
            let mante = ''; 
            let averia = ''; 

            borrarCamposModal();        
            $('#tituloModalTarea').text('Nueva Tarea');
            mostrarFecha(fecha);
            mostrarTiempos(tiempo);
            mostrarFinalizadas(final);
            mostrarMaquinas(maquina);
            mostrarTecnicos(tecnico);
            mostrarMantenimientos(mante);
            mostrarAverias(averia);
            $('#modalTarea').modal('show');                      
        });




        //Variables generales
        var id;
        var accionTarea;
    
    
        /* Al pulsar sobre de botón "Actualizar" de algún registro*/
        $(document).on("click", ".actualizarTarea", function() {  
            id = $(this).parent().parent().siblings().children().children('.id').text();           
            let titulo = $(this).parent().siblings().children().siblings('.titulo').text();
            let maquina = $(this).parent().parent().siblings().children().children('.maquina').text();
            let tecnico = $(this).parent().parent().siblings().children().children('.tecnico').text();
            let fecha = $(this).parent().parent().siblings().children().children('.fecha').text();
            let final = $(this).parent().parent().siblings().children().children('.final').text();
            let tiempo = $(this).parent().parent().siblings().children().children('.tiempo').text();
            let averia = $(this).parent().parent().siblings().children().children('.averia').text();
            let mant = $(this).parent().parent().siblings().children().children('.mant').text();
            let desc = $(this).parent().parent().siblings().children().children('.desc').text();  
            
            borrarCamposModal();   
            $('#tituloModalTarea').text('Modificar Tarea');
            $('#inputIdTarea').val(id);
            $('#inputTituloTarea').val(titulo);
            mostrarFecha(fecha);
            mostrarTiempos(tiempo);
            mostrarFinalizadas(final);
            mostrarMaquinas(maquina);
            mostrarTecnicos(tecnico);
            mostrarMantenimientos(mant);
            mostrarAverias(averia);       
            $('#inputDescTarea').val(desc);
            $('#modalTarea').modal('show');          
        });




    /* Función con la llamada Ajax para pasar el parámetro accionTarea con todos los datos recogidos para Crear, Modificar o Eliminar una Tarea*/
    function accionTareas(accionTarea){
        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionTarea },
            success: function(respuesta){

                //Si se ha modificado
                if(respuesta == "si"){

                    $('#modalTarea').modal('hide');
                    mostrarTareas();
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificado
                } else{
                
                    $('#modalTarea').modal('hide');
                    mostrarTareas();
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


    
    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar */
    $(document).on("click", "#aceptarModalTarea", function(e) {  
        //Detengo la acción por defecto del envío del formulario y su propagación
        e.preventDefault();
        e.stopPropagation();

        //Declaro los patrones a comparar
        let expTitulo = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-\,\.\s]{3,50}$/;
        let expFecha = /\d{4}-\d{2}-\d{2}$/;
        let expDesc = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-\,\.\s]{5,800}$/;    
    
        //Recojo el valor de los campos rellenados
        let id = $('#inputIdTarea').val();
        let titulo = $('#inputTituloTarea').val();
        let maquina = $('#inputMaquinaTarea').val();
        let tecnico = $('#inputTecnicoTarea').val();
        let fecha = $('#inputFechaTarea').val();
        let final = $('#inputFinalTarea').val();
        let tiempo = $('#inputTiempoTarea').val();
        let averia = $('#inputAveriaTarea').val();
        let mant = $('#inputMantTarea').val();
        let desc = $('#inputDescTarea').val();

        
        //Compruebo cada campo y maqueto efectos en el formulario
        //Campo Título
        if(!expTitulo.test(titulo)){
            $("#errTituloTarea").fadeIn();
            $('#inputTituloTarea').focus().css("border", "3px solid red");
            return false;
        
        } else {
            $("#errTituloTarea").hide();
            $('#inputTituloTarea').css("border", "3px solid #03c003");

            //Campo Fecha
            if(!expFecha.test(fecha)){
                $("#errFechaTarea").fadeIn();
                $('#inputFechaTarea').focus().css("border", "3px solid red");
                return false;

            } else {
                $("#errFechaTarea").hide();
                $('#inputFechaTarea').css("border", "3px solid #03c003");

                //Campo Tiempo empleado
                if(!comprobarTiempo(tiempo)){
                    $("#errTiempoTarea").fadeIn();
                    $('#inputTiempoTarea').focus().css("border", "3px solid red");
                    return false;

                } else {
                    $("#errTiempoTarea").hide();
                    $('#inputTiempoTarea').css("border", "3px solid #03c003");

                    //Formateo el tiempo a número flotante para la base de datos
                    tiempo = tiempo.replace(":", ".");
                    tiempo = parseFloat(tiempo);

                    //Campo Máquina
                    if(maquina==0){
                        $("#errMaquinaTarea").fadeIn();
                        $('#inputMaquinaTarea').focus().css("border", "3px solid red");
                        return false;

                    } else {
                        $("#errMaquinaTarea").hide();
                        $('#inputMaquinaTarea').css("border", "3px solid #03c003");
                    
                        //Campo Técnico
                        if(tecnico==0){
                            $("#errTecnicoTarea").fadeIn();
                            $('#inputTecnicoTarea').focus().css("border", "3px solid red");
                            return false;

                        } else {
                            $("#errTecnicoTarea").hide();
                            $('#inputTecnicoTarea').css("border", "3px solid #03c003");

                            //Campo Tipo de Avería
                            if(averia==0){
                                $("#errAveriaTarea").fadeIn();
                                $('#inputAveriaTarea').focus().css("border", "3px solid red");
                                return false;

                            } else {
                                $("#errAveriaTarea").hide();
                                $('#inputAveriaTarea').css("border", "3px solid #03c003");

                                //Campo Tipo de Mantenimiento
                                if(mant==0){
                                    $("#errMantTarea").fadeIn();
                                    $('#inputMantTarea').focus().css("border", "3px solid red");
                                    return false;

                                } else {
                                    $("#errMantTarea").hide();
                                    $('#inputMantTarea').css("border", "3px solid #03c003");
    
                                    //Campo Descripción
                                    if(!expDesc.test(desc)){
                                        $("#errDescTarea").fadeIn();
                                        $('#inputDescTarea').focus().css("border", "3px solid red");
                                        return false;

                                    } else {
                                        $("#errDescTarea").hide();
                                        $('#inputDescTarea').css("border", "3px solid #03c003");

                                        //Recojo los datos
                                        accionTarea = {
                                            accion: $('#tituloModalTarea').text(),
                                            id: id,
                                            titulo: titulo,
                                            fecha: fecha,
                                            tiempo: tiempo,
                                            final: final,
                                            maquina: maquina,
                                            tecnico: tecnico,
                                            averia: averia,
                                            mant: mant,
                                            desc: desc
                                        };
                                    
                                        //LLamo a la función y le paso los datos por parámetros para la petición Ajax
                                        accionTareas(accionTarea);
                                    }
                                }
                            }
                        } 
                    }
                }
            }
        }                           
    });





    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarTarea", function() {        
        id = $(this).parent().parent().siblings().children().children('.id').text();           
        let titulo = $(this).parent().siblings().children().siblings('.titulo').text();

        if(confirm('¿Seguro que quieres borrar la Tarea: "' + titulo + '" ?')){
             //Recojo los datos
             accionTarea = {
                accion: "Borrar Tarea",
                id: id,
                titulo: titulo,
                fecha: "",
                tiempo: "",
                final: "",
                maquina: "",
                tecnico: "",
                averia: "",
                mant: "",
                desc: ""
            };

           //LLamo a la función y le paso los datos por parámetros para la petición Ajax
           accionTareas(accionTarea);
        }
    });

 

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ */

    /* Al pulsar sobre alguno de los botones "Repuestos utilizados" de cada tarea, invocará a la función que traerá la llamada, y mostrará u ocultará la información */
    $(document).on("click", ".mostrarRepuestosTarea", function(e) {
         
        e.preventDefault();
        var hermano = $(this).siblings();
        var clase = $(this).siblings().attr("class");

        if(clase == "contRepuestosTarea container-fluid hide"){
            var idTarea = $(this).closest(".row").attr("id");
            mostrarRepTareas(idTarea);
            $(hermano).toggleClass("hide");
            $(hermano).fadeIn();

        } else {
            $(hermano).toggleClass("hide");
            $(hermano).hide();           
        }    
                      
    });

    

    
    //Funcion para mostrar todos los repuestos usados en tareas en la página "Tareas", en una fila inferior de cada tarea
    function mostrarRepTareas(idTarea){
        let repTarea = idTarea;
        let tecnico = $("#"+idTarea).children('.tecnico').text();   //'.tecnico'

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { repTarea },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    
                    resultado += "<div class='row'><div class='col-lg-12 text-right'><button type='button' class='nuevoRepTarea btn btn-success mb-2 mr-5' id='crearRepTarea'><abbr title='Añadir Nuevo Repuesto a la Tarea'><ion-icon class='lead pt-1' name='add'></ion-icon></abbr></button></div></div>";

                    if(typeof info !== "string"){

                        info.forEach(buscado => {                        
                        resultado +=`<div class="row border-top">
                                        <div class="col-md-12 col-lg-3 mt-2"><span class="text-success font-weight-bold">Referencia </span><span class="refRepTarea">${buscado.referencia}</span></div>
                                        <div class="col-md-12 col-lg-5 mt-2"><span class="text-success font-weight-bold">Nombre </span><span class="nombreRepTarea">${buscado.nombre}</span></div>  
                                        <div class="col-md-6 col-lg-2 mt-2"><span class="text-success font-weight-bold">Cantidad </span><span class="cantRepTarea">${buscado.cantidad}</span></div>
                                        <div class="col-md-6 col-lg-2 mr-0 text-right">
                                            <button type='button' class='actualizarRepTarea btn btn-outline-primary'>
                                                <ion-icon name='create' class='pt-1'></ion-icon>
                                            </button>
                                            <button type='button' class='eliminarRepTarea btn btn-outline-danger'>
                                                <ion-icon name='trash' class='pt-1'></ion-icon>
                                            </button>
                                        </div>
                                    </div>`;                   
                        });
                    } else {
                        resultado +=`<div class="align-text-bottom col-lg-12 text-secondary pb-2">${info}</div>`; 
                    }

                $("#r" + idTarea).html(resultado);        

            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });
    }





    function borrarCamposModal2(){
        $('#inputNomRepTarea').val("");
        $('#inputNomRepTarea').css("border", "none"); 
        $('#errNomRepTarea').hide();
        $('#inputCantRepTarea').val("");
        $('#inputCantRepTarea').css("border", "none"); 
        $('#errCantRepTarea').hide();   
    }


    //En caso de cerrar el modal con el botón "Cancelar" o con el botón de la X, en la esquina superior derecha
    $("#modalRepTarea").on("hidden.bs.modal", function () {
        borrarCamposModal2();
    });




    /* Función para mostrar los Repuestos existentes en select del modal */
    function mostrarRepuestos(repuesto){
        let repuestos = "";
    
        //Petición ajax para obtener los Roles que existen actualmente
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { repuestos },
            success: function(respuesta){
                let info = JSON.parse(respuesta);
                let resultado = '<option value="0" class="text-muted">Elegir un repuesto ...</option>"';
                info.forEach(buscado => {                    

                    //Si el formulario/modal es para Nuevo, se añade "selected" a la opción "Elegir un repuesto", para que sea valor predeterminado.
                    if($('#tituloModalRepTarea').text() === 'Nuevo Repuesto en Tarea'){
                        resultado += "<option value='" + buscado.referencia + "'>" + buscado.nombre + "</option>";

                    //Si el formulario/modal es para Modificar, se añade "selected" a la opción que conincida con el valor que tiene ese repuesto actualmente,
                    // para que sea valor predeterminado.
                    } else {
                        buscado.referencia != repuesto ? repuesto_selec="<option value='" + buscado.referencia + "'>" + buscado.nombre + "</option>" : repuesto_selec="<option value='" + buscado.referencia + "' selected>" + buscado.nombre + "</option>";
                        resultado += repuesto_selec;
                    }                                                         
                });

                $("#inputNomRepTarea").html(resultado);                
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)

            }
        });        
    }



    /* Función con la llamada Ajax para pasar el parámetro accionRepTareas con todos los datos recogidos para Crear, Modificar o Eliminar un Repuesto en Tarea*/
    function accionRepTareas(accionRepTarea, idTarea){
        //Petición ajax
        $.ajax({
            url:'includes/functions.php',
            type: 'POST',
            data: { accionRepTarea },
            success: function(respuesta){

                //Si se ha modificado
                if(respuesta == "si"){

                    $('#modalRepTarea').modal('hide');
                    mostrarRepTareas(idTarea);
                    $("#infoModal").html('<p class="text-center text-success pt-3"><ion-icon name="checkmark-circle-outline"></ion-icon> <b>La acción se ha realizado correctamente</b></p>');
                    $("#modalInfo").modal('show');
                    setTimeout(function(){ $("#modalInfo").modal('hide'); }, 2000); //Temporizador para desaparecer el mensaje
                                                            
                //Si no se ha modificado
                } else{
                
                    $('#modalRepTarea').modal('hide');
                    mostrarRepTareas(idTarea);
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




    var referencia = '';

    /* Al pulsar sobre de botón "+" en el apartado Repuestos utilizados de cada tarea, para añadir un nuevo repuesto utilizado */
    $(document).on("click", "#crearRepTarea", function() { 

        let idTarea = $(this).parent().parent().parent().attr('id').replace("r", ""); 

        borrarCamposModal2();        
        $('#tituloModalRepTarea').text('Nuevo Repuesto en Tarea');
        $('#idTarea').val(idTarea);
        mostrarRepuestos(referencia);
        $('#modalRepTarea').modal('show');                      
    });

 
 
    /* Al pulsar sobre de botón "Actualizar" de algún registro en los apartados "Repuestos utilizados", para modificar el repuesto utilizado */
    $(document).on("click", ".actualizarRepTarea", function() {  

        let idTarea = $(this).parent().parent().parent().attr('id').replace("r", ""); 
        referencia = $(this).parent().siblings().children('.refRepTarea').text(); 
        //let nombre = $(this).parent().siblings().children('.nombreRepTarea').text();
        let cantidad = $(this).parent().siblings().children('.cantRepTarea').text();
         
        borrarCamposModal2();        
        $('#tituloModalRepTarea').text('Modificar Repuesto en Tarea');
        $('#idTarea').val(idTarea);
        $('#inputRefRepTarea').val(referencia);
        mostrarRepuestos(referencia);
        $('#inputCantRepTarea').val(cantidad);
        $('#modalRepTarea').modal('show');           
    });




    /* Al pulsar sobre el botón "Aceptar" del Modal para crear o modificar */
    $(document).on("click", "#aceptarModalRepTarea", function(e) {  
        //Detengo la acción por defecto del envío del formulario y su propagación
        e.preventDefault();
        e.stopPropagation();

        //Declaro el patrón a comparar
        let expCantidad = /^[0-9\s]{1,4}$/;    
    
        //Recojo el valor de los campos rellenados
        let idTarea = $('#idTarea').val();
        /* let ref = $('#inputRefRepTarea').val(); */
        let referencia = $('#inputNomRepTarea').val();
        let cantidad = parseInt($('#inputCantRepTarea').val());
        
        //Compruebo cada campo y maqueto efectos en el formulario
        //Campo Nombre donde elegir el repuesto
        if(referencia==0){
            $("#errNomRepTarea").fadeIn();
            $('#inputNomRepTarea').focus().css("border", "3px solid red");
            return false;
        
        } else {
            $("#errNomRepTarea").hide();
            $('#inputNomRepTarea').css("border", "3px solid #03c003");

            //Campo Cantidad
            if(!expCantidad.test(cantidad) && cantidad>0 && cantidad<=1000){
                $("#errCantRepTarea").fadeIn();
                $('#inputCantRepTarea').focus().css("border", "3px solid red");
                return false;

            } else {
                $("#errCantRepTarea").hide();
                $('#inputCantRepTarea').css("border", "3px solid #03c003");

                //Recojo los datos
                accionRepTarea = {
                    accion: $('#tituloModalRepTarea').text(),
                    referencia: referencia,
                    idTarea: idTarea,                    
                    cantidad: cantidad
                };

                //LLamo a la función y le paso los datos por parámetros para la petición Ajax
                accionRepTareas(accionRepTarea, idTarea);
            }
        }
                                                  
    });




    /* Al pulsar sobre el botón "Borrar" de algún registro */
    $(document).on("click", ".eliminarRepTarea", function() {        
        let idTarea = $(this).parent().parent().parent().attr('id').replace("r", "");
        let nombre = $(this).parent().siblings().children('.nombreRepTarea').text(); 
        referencia = $(this).parent().siblings().children('.refRepTarea').text(); 

        if(confirm('¿Seguro que quieres borrar el Repuesto en Tarea: "' + nombre + '" ?')){
            //Recojo los datos
            accionRepTarea = {
                accion: "Borrar Repuesto en Tarea",
                referencia: referencia,
                idTarea: idTarea,                    
                cantidad: ""
            };

           //LLamo a la función y le paso los datos por parámetros para la petición Ajax
           accionRepTareas(accionRepTarea, idTarea);
        }
    });


});