<?php 
    /* Página que muestra los roles de usuario
    *
    *  Esta página es solo accesible para el "Administrador".
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
                        <h2 class="mt-1 text-info"><ion-icon name="podium" class="lead text-warning"></ion-icon> ROLES</h2>                        
                    </div>
                
                    <div class="col-lg-4 text-right">                    
                        <button type="button" class="btn btn-success mt-2 mr-3" id="crearRol">Nuevo Rol</button>                            
                    </div>
                                        
                </div>

                <div class="row">
                    <div class="alert alert-warning m-auto" role="alert">
                        <span class="font-weight-bold ">¡Muy importante!</span>  Mucho cuidado al modificar los valores de "Administrador" y "Responsable",<br>
                        se verá afectado el funcionamiento de la Web (como sus validaciones o permisos entre otros).
                    </div>
                </div>

                <!-- Contenedor que alojará los roles de usuario a mostrar -->
                <div class="row p-4">
                    <table class="table table-striped border">
                        <thead class="bg-info text-light">
                            <th scope="col">Id</th>
                            <th scope="col"><span class="text-warning">Rol</span> de usuario</th>
                            <th scope="col" class="text-right pr-5">Acción</th>
                        </thead>
                        <tbody id="cont_mostrar_roles">

                        </tbody>
                    </table>     
                </div>

            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="modalRol" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-info" id="tituloModalRol"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body bg-light justify-content-center">
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="inputIdRol">Id</label>
                                <input type="text" class="form-control" name="inputIdRol" id="inputIdRol" placeholder=" --" readonly> 
                            </div>
                            <div class="col-lg-10">
                                <label for="inputNombreRol">Rol</label>
                                <input type="text" class="form-control" name="inputNombreRol" id="inputNombreRol" placeholder="Añadir nuevo ..." pattern="[A-Za-z]{3,20}" autofocus required> 
                            </div>                       
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="cancelarModalRol">Cancelar</button>
                        <button type="button" class="btn btn-success" id="aceptarModalRol">Aceptar</button>
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
