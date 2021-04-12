
<?php 
    /**
     *  Página que muestra los tipos de manteniminetos
     *
     * @author Francisco José López Zafra
     */
    
    //Incluyo los de mas archivos    
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
                    <div class="col-lg-8 text-left mt-2">
                        <h2 class="mt-1 text-info"><ion-icon name="construct" class="lead text-warning"></ion-icon> TIPOS DE MANTENIMIENTO</h2>                        
                    </div>
                
                    <!-- Se muestra el botón según el rol -->
                    <?php if($rol === "Administrador" || $rol === "Responsable"){
                        echo '<div class="col-lg-4 text-right">
                                <button type="button" class="btn btn-success mt-2 mr-3" id="crearManteni">Nuevo Tipo de Mantenimiento</button>
                            </div>';}
                    ?>
                </div>

                <!-- Contenedor que alojará los tipos de mantenimineto a mostrar -->
                <div class="row p-4">
                    <table class="table table-striped border">
                        <thead class="bg-info text-light">
                            <th scope="col">Id</th>
                            <th scope="col">Tipos de <span class="text-warning">mantenimiento</span></th>
                            <th scope="col" class="text-right pr-5">Acción</th>
                        </thead>
                        <tbody id="cont_mostrar_mantenimientos">

                        </tbody>
                    </table>     
                </div>

            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalManteni" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title text-info" id="tituloModalManteni"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body bg-light justify-content-center">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" name="inputIdManteni" id="inputIdManteni">
                                    <label for="inputNombreManteni" class="text-success ml-2">Tipo de Mantenimiento *</label>
                                    <input type="text" class="form-control" name="inputNombreManteni" id="inputNombreManteni" placeholder="Añadir nuevo ..." pattern="[A-Za-z]{3,50}"  mixlength="3" maxlength="50" autofocus required> 
                                    <span class="errorModal" id="errNombreManteni">Solo admite letras mayúsculas, minúsculas, números y los signos ". , - () " , entre 3 y 50 caracteres</span>
                                </div>                       
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12 text-center text-warning">
                                    <span>* Campo requerido, no pueden quedar vacío</span> 
                                </div>                     
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="cancelarModalManteni" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="aceptarModalManteni">Aceptar</button>
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