


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Botón ocultar/mostrar menú lateral
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    
    //Funcion para mostrar todas las tareas y sus datos en una tabla en la página "Tareas"
    function mostrarTareas(){
      let tareas = "";

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
                    id = buscado.id;
                    resultado +=
                    `<div class="row p-3" id="${id}">
                        <div class="col-lg-12 bg-light text-secondary border">

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
                    info.forEach(buscado => {
                        id = buscado.id;
                        resultado +=
                        `<div class="row m-3" id="${id}">
                            <div class="col-lg-12 bg-light text-secondary border">
    
                                <table class="tablasMaquinas">
                                    <tr>
                                        <td><span class="text-success font-weight-bold">Id: </span>${id}</td>
                                        <td><span class="text-success font-weight-bold">Nombre: </span>${buscado.nombre}</td>
                                        <td><span class="text-success font-weight-bold">Marca: </span>${buscado.marca}</td>
                                        <td><span class="text-success font-weight-bold">Modelo: </span>${buscado.modelo}</td>
                                        <td><span class="text-success font-weight-bold">Grupo de Máquina: </span>${buscado.grupo}</td>
                                        <td rowspan="2" class="text-right mt-2">
                                            <button type="button" class="actualizarMaquina btn btn-outline-primary m-1">
                                                <ion-icon name="create" class="pt-1"></ion-icon>
                                            </button> 
                                            <br> 
                                            <button type="button" class="eliminarMaquina btn btn-outline-danger m-1">
                                                <ion-icon name="trash" class="pt-1"></ion-icon>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"><span class="text-success font-weight-bold">Descripción: </span>${buscado.descripcion}</td>
                                    </tr>
                                                                    
                                </table>                     
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


    



     //Funcion para mostrar todos los grupos de máquinas en una tabla en la página "Grupos de máquinas"
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
                        resultado +=
                        `<div class="row m-3" id="${id}">
                            <div class="col-lg-12 bg-light text-secondary border">
                                <table class="tablasGrupos">
                                    <tr>
                                        <td><span class="text-success font-weight-bold">Id: </span>${id}</td>
                                        <td colspan="3"><span class="text-success font-weight-bold">Nombre: </span>${buscado.nombre}</td>                                        
                                        <td class="botonesGrupos text-right">
                                            <button type="button" class="actualizarTarea btn btn-outline-primary m-1">
                                                <ion-icon name="create" class="pt-1"></ion-icon>
                                            </button> 
                                            &nbsp 
                                            <button type="button" class="eliminarTarea btn btn-outline-danger m-1">
                                                <ion-icon name="trash" class="pt-1"></ion-icon>
                                            </button>
                                        </td>
                                    </tr>                                                                    
                                </table>
                                                     
                            </div>                   
                        </div>`;  
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


    /* `<div class="row m-3" id="${id}">
                            <div class="container-fluid bg-light text-secondary border">
                                <div class="col-lg-3">
                                    <span class="text-success font-weight-bold">Id: </span>${id}
                                </div>
                                <div class="col-lg-5">
                                    <span class="text-success font-weight-bold">Nombre: </span>${buscado.nombre}
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="actualizarTarea btn btn-outline-primary m-1">
                                        <ion-icon name="create" class="pt-1"></ion-icon>
                                    </button> 
                                    &nbsp 
                                    <button type="button" class="eliminarTarea btn btn-outline-danger m-1">
                                        <ion-icon name="trash" class="pt-1"></ion-icon>
                                    </button>
                                </div>
                                                     
                            </div>                   
                        </div>`; */


    





    





});