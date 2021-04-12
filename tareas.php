<?php 
    /** Página que muestra las tareas
     *
     * @author Francisco José López Zafra
     */
    
    //Incluyo más archivos    
    include("includes/menu.php");

    //Compruebo sesión
    if(!comprobarSesion()){
        //Redirijo a la página de Inicio para volver a identificarse
        header("Location: index.php");
    } 
    
?>
    
            <div class="content">
                <div class="container">
                    <div class="row pb-2">                        

                        <!-- Contenedor que contiene el título de la página -->
                        <div class="col-lg-3 text-left mt-2">
                            <h2 class="mt-1 text-info"><ion-icon name="clipboard" class="lead text-warning"></ion-icon> TAREAS</h2>                        
                        </div>

                        <div class="col-lg-2 mt-3 text-right text-secondary">                            
                            <span class="text-right">Ordenadas por: </span>
                        </div>

                        <div class="col-lg-4 mt-2">
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                                    fecha, descendente
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                    <a href="#" class="ordenTareas dropdown-item">fecha, ascendente</a>
                                    <a href="#" class="ordenTareas dropdown-item">finalizada</a>
                                    <a href="#" class="ordenTareas dropdown-item">máquina, nombre</a>
                                    <a href="#" class="ordenTareas dropdown-item">técnico, alfabéticamente</a>                                    
                                </div>
                            </div>                            
                        </div>

                        <div class="col-lg-3 text-right">
                                <button type="button" class="btn btn-success mt-2 mr-2" id="crearTarea">Nueva Tarea</button>
                        </div>
                    </div>  

                    <!-- Contenedor que alojará las tareas a mostrar -->
                    <div id="cont_mostrar_tareas">
                        
                    </div>
                            
                    
                     <!-- Modal para las Tareas -->
                    <div class="modal fade" id="modalTarea" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">

                                <form>
                                    <div class="modal-header">
                                        <h5 class="modal-title text-info" id="tituloModalTarea"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body bg-light justify-content-center">
                                        <div class="row">
                                            <!-- Título -->
                                            <div class="col-lg-6">
                                                <!-- Id -->
                                                <input type="hidden" class="inputIdTarea" id="inputIdTarea"> 
                                                <label for="inputTituloTarea" class="text-success ml-2">Título *</label>                                                                        <!--  pattern="[A-Za-z0-9\.\,\-]{3,50}" -->
                                                <input type="text" class="form-control" name="inputTituloTarea" id="inputTituloTarea" placeholder="Añadir titulo ..."  minlength="3" maxlength="50" autofocus required> 
                                                <span class="errorModal" id="errTituloTarea">Solo admite letras mayúsculas, minúsculas, números y los signos ".,-" , entre 3 y 50 caracteres</span>
                                            </div> 
                                            <!-- Fecha -->
                                            <div class="col-lg-6">
                                                <label for="inputFechaTarea" class="text-success ml-2">Fecha *</label>
                                                <input type="date" class="form-control" name="inputFechaTarea" id="inputFechaTarea" min="2021-01-01" pattern="\d{4}-\d{2}-\d{2}" required> 
                                                <span class="errorModal" id="errFechaTarea">Solo admite formato fecha</span>                                   
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <!-- Tiempo empleado -->
                                            <div class="col-lg-6">
                                                <label for="inputTiempoTarea" class="text-success ml-2">Tiempo Empleado *</label><span>(entre 00:15 y 08:00 h)</span>
                                                <input type="time" class="form-control" name="inputTiempoTarea" id="inputTiempoTarea" min="00:15" max="08:00" pattern="[0-9]{2}:[0-9]{2}" required>
                                                <span class="errorModal" id="errTiempoTarea">Solo admite formato hora, entre 00:15 y 08:00 h</span>
                                            </div> 
                                            <!-- Finalizada -->
                                            <div class="col-lg-6">
                                                <label for="inputFinalTarea" class="text-success ml-2">Finalizada</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select" name="inputFinalTarea" id="inputFinalTarea" required>
                                                                                                        
                                                    </select>
                                                </div>                                                                
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <!-- Máquina -->
                                            <div class="col-lg-6">
                                                <label for="inputMaquinaTarea" class="text-success ml-2">Máquina *</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select" name="inputMaquinaTarea" id="inputMaquinaTarea" required>
                                                                                            
                                                    </select>
                                                </div>
                                                <span class="errorModal" id="errMaquinaTarea">Debe seleccionar una de las opciones</span>
                                            </div> 
                                            <!-- Técnico -->
                                            <div class="col-lg-6">
                                                <label for="inputTecnicoTarea" class="text-success ml-2">Técnico *</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select" name="inputTecnicoTarea" id="inputTecnicoTarea" required>
                                                        
                                                    </select>
                                                </div>
                                                <span class="errorModal" id="errinputTecnicoTarea">Debe seleccionar una de las opciones</span>                                                                   
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <!-- Tipo de Avería -->
                                            <div class="col-lg-6">
                                                <label for="inputAveriaTarea" class="text-success ml-2">Tipo de Avería *</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select" name="inputAveriaTarea" id="inputAveriaTarea" required>
                                                                                            
                                                    </select>
                                                </div>
                                                <span class="errorModal" id="errAveriaTarea">Debe seleccionar una de las opciones</span>
                                            </div> 
                                            <!-- Tipo de Mantenimiento -->
                                            <div class="col-lg-6">
                                                <label for="inputMantTarea" class="text-success ml-2">Tipo de Mantenimiento *</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select" name="inputMantTarea" id="inputMantTarea" required>
                                                        
                                                    </select>
                                                </div>
                                                <span class="errorModal" id="errinputMantTarea">Debe seleccionar una de las opciones</span>                                                                   
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <!-- Descripcion -->
                                            <div class="col-lg-12">
                                                <label for="inputDescTarea"class="text-success ml-2">Descripción *</label>
                                                
                                                <textarea class="form-control" name="inputDescTarea" id="inputDescTarea" placeholder="Añadir descripción de la tarea..." rows="3" minlengh="5" maxlength="800" required></textarea>
                                                <span class="errorModal" id="errDescTarea">Solo admite letras mayúsculas, minúsculas, números y los signos " . , - " , entre 5 y 800 caracteres</span> 
                                            </div>                     
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-12 text-center text-warning">
                                                <span>* Campos requeridos, no pueden quedar vacíos</span> 
                                            </div>                     
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id="cancelarModalTarea" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success" id="aceptarModalTarea">Aceptar</button>
                                    </div>                                        
                                </form>

                            </div>
                        </div>        
                    </div>





                    <!-- Modal para los Repuestos en Tarea -->
                    <div class="modal fade" id="modalRepTarea" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <form>
                                    <div class="modal-header">
                                        <h5 class="modal-title text-info" id="tituloModalRepTarea"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body bg-light justify-content-center">
                                        <div class="row">
                                            <!-- Referencia -->
                                            <div class="col-lg-8">
                                                <!-- Id Tarea-->
                                                <!-- <input type="hidden" id="inputRefRepTarea">  -->
                                                <input type="hidden" id="idTarea">
                                                <label for="inputNomRepTarea" class="text-success ml-2">Nombre repuesto utilizado *</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select" name="inputNomRepTarea" id="inputNomRepTarea" required>
                                                                                                    
                                                    </select>
                                                </div>  
                                                <span class="errorModal" id="errNomRepTarea">Debe seleccionar una de las opciones</span>                                                              
                                            </div> 
                                            <!-- Cantidad -->
                                            <div class="col-lg-4">
                                                <label for="inputCantRepTarea" class="text-success ml-2">Cantidad *</label>
                                                <input type="number" class="form-control" name="inputCantRepTarea" id="inputCantRepTarea" min="1" max="1000" minlength="1" maxlength="4" required> 
                                                <span class="errorModal" id="errCantRepTarea">Solo admite números enteros del 0 al 1000</span>                                   
                                            </div>
                                        </div>                     

                                        <div class="row mt-2">
                                            <div class="col-lg-12 text-center text-warning">
                                                <span>* Campos requeridos, no pueden quedar vacíos</span> 
                                            </div>                     
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id="cancelarModalRepTarea" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success" id="aceptarModalRepTarea">Aceptar</button>
                                    </div>                                        
                                </form>

                            </div>
                        </div>        
                    </div>
                    
                    
                </div>                    
            </div>



    </div>
</div>

<?php
    //Incluyo pie
    include("includes/footer.php");
?>