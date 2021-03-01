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
                
                    <div class="col-lg-4 text-right">
                        <button type="button" class="btn btn-success mt-2 mr-3" id="crearUsuario">Nuevo Usuario</button>
                    </div>
                </div>

                <!-- Contenedor que alojará a los usuarios a mostrar -->
                <div id="cont_mostrar_usuarios">
                                
                </div>

            </div>
        </div>

    </div>
</div>

<?php
    //Incluyo pie
    include("includes/footer.php");
?>