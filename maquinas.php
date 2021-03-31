
<?php 
    /* Página que muestra las máquinas
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
                    <div class="col-lg-4 text-left mt-2">
                        <h2 class="mt-1 text-info"><ion-icon name="cog" class="lead text-warning"></ion-icon> MÁQUINAS</h2>                        
                    </div>

                    <!-- Campo de busqueda -->
                    <div class="col-lg-5 text-center">
                        <form class="form-inline position-relative d-inline-block mt-2">
                            <input class="form-control mr-sm-2 border border-info mt-1" type="search" id="busqueda" placeholder="Buscar por nombre" aria-label="Search" pattern="[a-zA-Z 0-9 áéíóúñÑ-]{0,50}" required>
                        </form>
                    </div>
                
                    <!-- Botón Crear Máquina segun permisos -->
                    <?php if($rol === "Administrador" || $rol === "Responsable"){
                        echo '<div class="col-lg-3 text-right">
                                <button type="button" class="btn btn-success mt-2 mr-3" id="crearMaquina">Nueva Máquina</button>
                            </div>';}
                    ?>
                </div>

                <!-- Contenedor que alojará las maquinas a mostrar -->
                <div id="cont_mostrar_maquinas">
                                
                </div>

            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalMaquina" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-info" id="tituloModalMaquina"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body bg-light justify-content-center">

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-lg-6">
                                <!-- Id -->
                                <input type="hidden" class="inputIdMaquina" id="inputIdMaquina"> 
                                <label for="inputNombreMaquina" class="text-success ml-2">Nombre *</label>
                                <input type="text" class="form-control" name="inputNombreMaquina" id="inputNombreMaquina" placeholder="Añadir nombre ..."  minlength="3" maxlength="50" autofocus required> 
                                <span class="errorModal" id="errNombreMaquina">Solo admite letras mayúsculas, minúsculas, números y los signos ".,-()/" , entre 3 y 50 caracteres</span>
                            </div> 
                            <!-- Marca -->
                            <div class="col-lg-6">
                                <label for="inputMarcaMaquina" class="text-success ml-2">Marca *</label>
                                <input type="text" class="form-control" name="inputMarcaMaquina" id="inputMarcaMaquina" placeholder="Añadir marca ..." minlength="3" maxlength="50" required> 
                                <span class="errorModal" id="errMarcaMaquina">Solo admite letras mayúsculas, minúsculas, números y los signos ".,-" , entre 3 y 50 caracteres</span>                                   
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

<?php
    //Incluyo pie
    include("includes/footer.php");
?>