


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
                    buscado.finalizada=='No' ? clase="col-lg-12 bg-warning text-light border" : clase="col-lg-12 bg-light text-dark border";
                    id = buscado.id;
                    resultado +=
                    `<div class="row p-2 pl-4 pr-4" id="${id}">
                        <div class="${clase}">

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
                            <div class="col-lg-12 bg-light text-dark border">                               
                                <div class="row">
                                    <div class="col-lg-1"><span class="text-success font-weight-bold">Id: </span>${id}</div>
                                    <div class="col-lg-2"><span class="text-success font-weight-bold">Nombre: </span>${buscado.nombre}</div>
                                    <div class="col-lg-2"><span class="text-success font-weight-bold">Marca: </span>${buscado.marca}</div>
                                    <div class="col-lg-2"><span class="text-success font-weight-bold">Modelo: </span>${buscado.modelo}</div>
                                    <div class="col-lg-3"><span class="text-success font-weight-bold">Grupo de Máquina: </span>${buscado.grupo}</div>
                                    <div class="col-lg-2"> 
                                        <button type="button" class="actualizarMaquina btn btn-outline-primary m-1">
                                            <ion-icon name="create" class="pt-1"></ion-icon>
                                        </button> 
                    
                                        <button type="button" class="eliminarMaquina btn btn-outline-danger m-1">
                                            <ion-icon name="trash" class="pt-1"></ion-icon>
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 pt-1">
                                        <span class="text-success font-weight-bold">Descripción: </span>${buscado.descripcion}
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
                            <td class="align-middle">${id}</td>
                            <td class="align-middle">${buscado.nombre}</td>                                        
                            <td class="botonesGrupos text-right">
                                <button type="button" class="actualizarAveria btn btn-outline-primary">
                                    <ion-icon name="create" class="pt-1"></ion-icon>
                                </button> 
                                &nbsp 
                                <button type="button" class="eliminarAveria btn btn-outline-danger">
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
                    info.forEach(buscado => {
                        id = buscado.id;
                        resultado +=`<tr id="${id}">
                            <td class="align-middle">${id}</td>
                            <td class="align-middle">${buscado.nombre}</td>                                        
                            <td class="botonesGrupos text-right">
                                <button type="button" class="actualizarAveria btn btn-outline-primary">
                                    <ion-icon name="create" class="pt-1"></ion-icon>
                                </button> 
                                &nbsp 
                                <button type="button" class="eliminarAveria btn btn-outline-danger">
                                    <ion-icon name="trash" class="pt-1"></ion-icon>
                                </button>
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
                    info.forEach(buscado => {
                        id = buscado.id;
                        resultado +=`<tr id="${id}">
                            <td class="align-middle">${id}</td>
                            <td class="align-middle">${buscado.nombre}</td>                                        
                            <td class="botonesGrupos text-right">
                                <button type="button" class="actualizarAveria btn btn-outline-primary">
                                    <ion-icon name="create" class="pt-1"></ion-icon>
                                </button> 
                                &nbsp 
                                <button type="button" class="eliminarAveria btn btn-outline-danger">
                                    <ion-icon name="trash" class="pt-1"></ion-icon>
                                </button>
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
                    info.forEach(buscado => {
                        id = buscado.referencia;
                        resultado +=
                        `<div class="row m-3" id="${id}">
                            <div class="col-lg-12 bg-light text-dark border">
    
                                <div class="row">
                                    <div class="col-lg-3 pt-3">
                                        <span class="text-success font-weight-bold">Id: </span>${id}
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <span class="text-success font-weight-bold">Nombre: </span>${buscado.nombre}
                                    </div>
                                    <div class="col-lg-3 text-right mt-2">
                                        <button type="button" class="actualizarMaquina btn btn-outline-primary m-1">
                                            <ion-icon name="create" class="pt-1"></ion-icon>
                                        </button> 
                                        
                                        <button type="button" class="eliminarMaquina btn btn-outline-danger m-1">
                                            <ion-icon name="trash" class="pt-1"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 pt-1">
                                        <span class="text-success font-weight-bold">Descripción: </span>${buscado.descripcion}
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
    




    //Funcion para mostrar todas las máquinas y sus datos en una tabla en la página "Usuarios"
    function mostrarUsuarios(){
        let usuarios = "";
  
            //Petición ajax
            $.ajax({
                url:'includes/functions.php',
                type: 'POST',
                data: { usuarios },
                success: function(respuesta){
                    let info = JSON.parse(respuesta);
                    let resultado = '';
                    let id = "";
                    info.forEach(buscado => {
                        buscado.bloqueado==1 ? buscado.bloqueado='Sí' : buscado.bloqueado='No';
                        buscado.bloqueado=='Sí' ? clase="col-lg-12 bg-secondary text-light border" : clase="col-lg-12 bg-light text-dark border";
                        id = buscado.id;
                        resultado +=
                        `<div class="row m-3" id="${id}">
                            <div class="${clase}">
    
                                <div class="row">
                                    <div class="col-lg-2 pt-3">
                                        <span class="text-success font-weight-bold">Id: </span>${id}
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <span class="text-success font-weight-bold">Nombre: </span>${buscado.nombre}
                                    </div>
                                    <div class="col-lg-3 pt-3">
                                        <span class="text-success font-weight-bold">Rol: </span>${buscado.rol}
                                    </div>
                                    
                                    <div class="col-lg-3 text-right mt-1">
                                        <button type="button" class="actualizarMaquina btn btn-outline-primary m-1">
                                            <ion-icon name="create" class="pt-1"></ion-icon>
                                        </button> 
                                        
                                        <button type="button" class="eliminarMaquina btn btn-outline-danger m-1">
                                            <ion-icon name="trash" class="pt-1"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 pt-1">
                                        <span class="text-success font-weight-bold">Email: </span>${buscado.email}
                                    </div>
                                    <div class="col-lg-6 pt-1">
                                        <span class="text-success font-weight-bold">Bloqueado: </span>${buscado.bloqueado}
                                    </div>
                                </div>
                                                      
                            </div>                   
                        </div>`;  
                    });
  
                $("#cont_mostrar_usuarios").html(resultado);        
                             
  
            },
            // Si la petición falla, devuelve en consola el error producido y el estado
            error: function(estado, error) {
                console.log("-Error producido: " + error + ". -Estado: " + estado)
  
            }
        });
    }

    /* Invoco la función */
    mostrarUsuarios();









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