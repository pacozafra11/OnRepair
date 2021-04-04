<?php 
    /* Página que muestra las tareas
    *
    * @author Francisco José López Zafra
    */
    
    //Incluyo los de mas archivos    
    include("includes/menu.php");
    
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
                            
                    
                     <!-- Modal -->
                    <div class="modal fade" id="modalTarea" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">

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
                                            <label for="inputTituloTarea" class="text-success ml-2">Título *</label>
                                            <input type="text" class="form-control" name="inputTituloTarea" id="inputTituloTarea" placeholder="Añadir titulo ..."  minlength="3" maxlength="50" autofocus required> 
                                            <span class="errorModal" id="errTituloTarea">Solo admite letras mayúsculas, minúsculas, números y los signos ".,-" , entre 3 y 50 caracteres</span>
                                        </div> 
                                        <!-- Fecha -->
                                        <div class="col-lg-6">
                                            <label for="inputFechaTarea" class="text-success ml-2">Fecha *</label>
                                            <input type="date" class="form-control" name="inputFechaTarea" id="inputFechaTarea" min="2018-01-01" required> 
                                            <span class="errorModal" id="errFechaTarea">Solo admite formato fecha</span>                                   
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <!-- Modelo -->
                                        <div class="col-lg-6">
                                            <label for="inputModeloMaquina" class="text-success ml-2">Modelo</label>
                                            <input type="text" class="form-control" name="inputModeloMaquina" id="inputModeloMaquina" placeholder="Añadir modelo ..." maxlength="50"> 
                                            <span class="errorModal" id="errModeloMaquina">Solo admite letras mayúsculas, minúsculas, números y los signos ".,-" , entre 3 y 50 caracteres</span>
                                        </div> 
                                        <!-- Grupo de Máquinas -->
                                        <div class="col-lg-6">
                                            <label for="inputGrupoMaquina" class="text-success ml-2">Grupo de Máquinas *</label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select" name="inputGrupoMaquina" id="inputGrupoMaquina" required>
                                                    
                                                </select>
                                            </div>
                                            <span class="errorModal" id="errGrupoMaquina">Debe seleccionar una de las opciones</span>                                                                   
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <!-- Descripcion -->
                                        <div class="col-lg-12">
                                            <label for="inputDescMaquina"class="text-success ml-2">Descripción</label>
                                            
                                            <textarea class="form-control" name="inputDescMaquina" id="inputDescMaquina" placeholder="Añadir descripción ..." rows="3" maxlength="800"></textarea>
                                            <span class="errorModal" id="errDescMaquina">Solo admite letras mayúsculas, minúsculas, números y los signos " . , - " , máximo 800 caracteres</span> 
                                        </div>                     
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-12 text-center text-warning">
                                            <span>* Campos requeridos, no pueden quedar vacíos</span> 
                                        </div>                     
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id="cancelarModalMaquina" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-success" id="aceptarModalMaquina">Aceptar</button>
                                    </div>
                                </div>
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