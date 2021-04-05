
<?php 
    /* Página que muestra los repuestos
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
                    <div class="col-lg-8 text-left mt-2">
                        <h2 class="mt-1 text-info"><ion-icon name="git-compare" class="lead text-warning"></ion-icon> REPUESTOS</h2>                        
                    </div>
                
                    <?php if($rol === "Administrador" || $rol === "Responsable"){
                        echo '<div class="col-lg-4 text-right">
                                <button type="button" class="btn btn-success mt-2 mr-3" id="crearRepuesto">Nuevo Repuesto</button>
                            </div>';}
                    ?>
                </div>

                <!-- Contenedor que alojará las repuestos a mostrar -->
                <div id="cont_mostrar_repuestos">
                                
                </div>

            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalRepuesto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title text-info" id="tituloModalRepuesto"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body bg-light justify-content-center">
                            <div class="row mt-3">
                                <!-- Referencia -->
                                <div class="col-lg-4">
                                    <label for="inputIdRepuesto" class="text-success ml-2">Referencia *</label>
                                    <input type="text" class="form-control" name="inputIdRepuesto" id="inputIdRepuesto" placeholder="Añadir referencia ..." pattern="[A-Za-z\.\,\-\(\)]{3,12}" minlength="3" maxlength="12" autofocus required> 
                                    <span class="errorModal" id="errIdRepuesto">Solo admite letras mayúsculas, minúsculas, números y los signos ".,-()" , entre 3 y 12 caracteres</span>
                                </div> 
                                <!-- Nombre -->
                                <div class="col-lg-8">
                                    <label for="inputNombreRepuesto" class="text-success ml-2">Nombre *</label>
                                    <input type="text" class="form-control" name="inputNombreRepuesto" id="inputNombreRepuesto" placeholder="Añadir nombre ..." pattern="[A-Za-z\.\,\-\(\)]{3,50}" minlength="3" maxlength="50" required> 
                                    <span class="errorModal" id="errNombreRepuesto">Solo admite letras mayúsculas, minúsculas, números y los signos ".,-()" , entre 3 y 50 caracteres</span>                                   
                                </div>
                            </div>
                            <div class="row mt-3">
                            <!-- Descripción -->
                                <div class="col-lg-12">
                                    <label for="inputDescRepuesto"class="text-success ml-2">Descripción</label>
                                    <textarea class="form-control" name="inputDescRepuesto" id="inputDescRepuesto" placeholder="Añadir descripción ..." rows="4" maxlength="800"></textarea>
                                    <span class="errorModal" id="errDescRepuesto">Solo admite letras mayúsculas, minúsculas, números y los signos " . , - () " , máximo 800 caracteres</span> 
                                </div>                     
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12 text-center text-warning">
                                    <span>* Campos requeridos, no pueden quedar vacíos</span> 
                                </div>                     
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="cancelarModalRepuesto" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="aceptarModalRepuesto">Aceptar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>



    </div>
</div>

<?php
    //Incluyo pie
    include("includes/footer.php");
?>