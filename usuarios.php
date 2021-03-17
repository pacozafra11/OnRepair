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
                    <form action="">
                        <div class="modal-header">
                            <h5 class="modal-title text-info" id="tituloModalUsuario"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body bg-light justify-content-center">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="inputNombreUsuario" class="text-success ml-2">Nombre</label>
                                    <input type="text" class="form-control" name="inputNombreUsuario" id="inputNombreUsuario" placeholder="Añadir Nombre ..." pattern="[A-Za-z]{3,50}" autofocus required> 
                                    <span class="span">*Máximo 50 caractéres, solo admite letras mayúsculas y minúsculas</span>
                                </div> 
                                <div class="col-lg-6">
                                    <label for="inputRolUsuario" class="text-success ml-2">Rol</label> 
                                    <div class="dropdown">
                                        <button class="btn bg-white text-secondary text-left border col-lg-12 dropdown-toggle" type="button" id="inputRolUsuario" name="inputRolUsuario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            
                                        </button>
                                        <div class="dropdown-menu" id="opcionesRolUsuario" role="menu" aria-labelledby="inputRolUsuario">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="inputEmailUsuario"class="text-success ml-2">Email</label>
                                    <input type="email" class="form-control" name="inputEmailUsuario" id="inputEmailUsuario" placeholder="Añadir Email ..." required> 
                                </div> 
                                <div class="col-lg-6">
                                    <label for="inputBloqueUsuario" class="text-success ml-2">Bloqueado</label>
                                    <div class="dropdown">
                                        <button class="btn bg-white text-secondary text-left border col-lg-12 dropdown-toggle" type="button" id="inputBloqueUsuario" name="inputBloqueUsuario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            
                                        </button>
                                        <div class="dropdown-menu" role="menu" aria-labelledby="inputBloqueUsuario">
                                            <a class="bloqueado dropdown-item" href="#">No</a>
                                            <a class="bloqueado dropdown-item" href="#">Sí</a>
                                        </div>
                                    </div>
                                </div>                     
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="inputPasswordUsuario"class="text-success ml-2">Password</label>
                                    <input type="password" class="form-control" name="inputPasswordUsuario" id="inputPasswordUsuario" placeholder="Añadir Password ..." pattern="[A-Za-z0-9]{3,20}" required>
                                    <span class="span">*Máximo 20 caractéres, solo admite letras mayúsculas y minúsculas y números</span> 
                                </div> 
                                <div class="col-lg-6">
                                    <label for="inputConfPassUsuario"class="text-success ml-2">Confirmar Password</label>
                                    <input type="password" class="form-control" name="inputConfPassUsuario" id="inputConfPassUsuario" placeholder="Confirmar Password ..." pattern="[A-Za-z0-9]{3,20}" required> 
                                    <span class="span font-weight-light">*Máximo 20 caractéres, solo admite letras mayúsculas y minúsculas y números</span>
                                </div>                      
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="cancelarModalUsuario">Cancelar</button>
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