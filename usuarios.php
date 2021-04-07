<?php 
    /* Página que muestra los usuarios
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
                        <h2 class="mt-1 text-info"><ion-icon name="contacts" class="lead text-warning"></ion-icon> USUARIOS</h2>                        
                    </div>
                
                    <?php if($rol === "Administrador" || $rol === "Responsable"){
                        echo '<div class="col-lg-4 text-right">
                                <button type="button" class="btn btn-success mt-2 mr-3" id="crearUsuario">Nuevo Usuario</button>
                            </div>';}
                    ?>                    
                </div>

                <!-- Contenedor que alojará a los usuarios a mostrar -->
                <div id="cont_mostrar_usuarios">
                                
                </div>

            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title text-info" id="tituloModalUsuario"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body bg-light justify-content-center">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <input type="hidden" class="inputIdUsuario" id="inputIdUsuario">
                                    <label for="inputNombreUsuario" class="text-success ml-2">Nombre *</label>
                                    <input type="text" class="form-control" name="inputNombreUsuario" id="inputNombreUsuario" placeholder="Añadir Nombre ..." minlength="3" maxlength="50" pattern="[A-Za-z]{3,50}" autofocus required> 
                                    <span class="errorModal" id="errNombre">Solo admite letras mayúsculas y minúsculas, entre 3 y 50 caracteres</span>
                                </div> 
                                <div class="col-lg-6">
                                    <label for="inputRolUsuario" class="text-success ml-2">Rol</label> 
                                    <div class="input-group mb-3">
                                        <select class="custom-select" id="inputRolUsuario" name="inputRolUsuario">
                                            
                                        </select>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="inputEmailUsuario"class="text-success ml-2">Email *</label>
                                    <input type="email" class="form-control" name="inputEmailUsuario" id="inputEmailUsuario" placeholder="Añadir Email ..."  minlength="4" maxlength="50" required>
                                    <span class="errorModal" id="errEmail">Introducir un formato válido de Email</span> 
                                </div> 
                                <div class="col-lg-6">
                                    <label for="inputBloqueUsuario" class="text-success ml-2">Bloqueado</label>                                         
                                    <div class="input-group mb-3">
                                        <select class="custom-select" id="inputBloqueUsuario" name="inputBloqueUsuario">
                                            <option value="0" selected>No</option>
                                            <option value="1">Sí</option>
                                        </select>
                                    </div>                                    
                                </div>                     
                            </div>
                            <div id="filaPassword" class="row mt-4">
                                <div class="col-lg-6">
                                    <label for="inputPasswordUsuario"class="text-success ml-2">Password *</label>                                   
                                    <input type="password" class="form-control" name="inputPasswordUsuario" id="inputPasswordUsuario" placeholder="Añadir Password ..." pattern="[a-zA-Z0-9ñÑ]{4,20}" minlength="4" maxlength="20"> 
                                    <span class="errorModal" id="errPassword">Solo admite letras mayúsculas, minúsculas y números, entre 4 y 20 caracteres</span>
                                </div> 
                                <div class="col-lg-6">
                                    <label for="inputConfPassUsuario"class="text-success ml-2">Confirmar Password *</label>
                                    <input type="password" class="form-control" name="inputConfPassUsuario" id="inputConfPassUsuario" placeholder="Confirmar Password ..." pattern="[a-zA-Z0-9ñÑ]{4,20}" minlength="4" maxlength="20"> 
                                    <span class="errorModal" id="errConfPassword">Las contraseñas deben coincidir</span>
                                </div>                      
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12 text-center text-warning">
                                    <span>* Campos requeridos, no pueden quedar vacíos</span> 
                                </div>                     
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="cancelarModalUsuario" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="aceptarModalUsuario">Aceptar</button>
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