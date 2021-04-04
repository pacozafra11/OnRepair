
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
                                    <td colspan="2"><span class="text-success font-weight-bold">Título </span><span class"titulo">${buscado.titulo}</span></td>
                                    <td class="colDerecha text-right">
                                        <button type='button' class='actualizarTarea btn btn-outline-primary m-1'><ion-icon name='create' class='pt-1'></ion-icon></button>&nbsp
                                        ${botones}
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="4"><span class="text-success font-weight-bold">Descripción </span><br><span class"desc">${buscado.descripcion}</span></td>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Máquina </span><span class"maquina">${buscado.maquina}</span></td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Id </span><span class"id">${id}</span></td> 
                                </tr>
                                <tr>                                    
                                    <td class="pl-3"><span class="text-success font-weight-bold">Técnico </span><span class"tecnico">${buscado.tecnico}</span></td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tiempo Empleado </span>${buscado.tiempo}</span>h</td>                                          
                                </tr>
                                <tr>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Fecha </span><span class"fecha">${buscado.fecha}</td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Avería </span><span class"averia">${buscado.averia}</span></td>
                                </tr>
                                <tr>
                                    <td class="pl-3"><span class="text-success font-weight-bold">Finalizada </span><span class"final">${buscado.finalizada}</span></td>
                                    <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Mantenimiento </span><span class"mant">${buscado.mantenimiento}</span></td>
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
        console.log(tecnico);

            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { repTarea },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    
                    resultado += "<div class='col-lg-12 text-right'><button type='button' class='nuevoRepTarea btn btn-success m-2' id='crearTarea'>Nuevo repuesto en esta tarea</button></div>";

                    if(typeof info !== "string"){

                        info.forEach(buscado => {                        
                        id = buscado.referencia + "_" + buscado.id;
                        resultado +=`<div class="col-lg-3 mt-2"><span class="text-success font-weight-bold">Referencia </span><span class="refRepTarea">${buscado.referencia}</span></div>
                                    <div class="col-lg-5 mt-2"><span class="text-success font-weight-bold">Nombre </span><span class="nombreRepTarea">${buscado.nombre}</span></div>  
                                    <div class="col-lg-2 mt-2"><span class="text-success font-weight-bold">Cantidad </span><span class="cantRepTarea">${buscado.cantidad}</span></div>
                                    <div class="col-lg-2">
                                        <button type='button' class='actualizarRepTarea btn btn-outline-primary'>
                                            <ion-icon name='create' class='pt-1'></ion-icon>
                                        </button>
                                        <button type='button' class='eliminarRepTarea btn btn-outline-danger'>
                                            <ion-icon name='trash' class='pt-1'></ion-icon>
                                        </button>
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


});