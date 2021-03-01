
<?php 
    /* Página que muestra los tipos de manteniminetos
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
                        <h2 class="mt-1 text-info"><ion-icon name="construct" class="lead text-warning"></ion-icon> TIPOS DE MANTENIMIENTO</h2>                        
                    </div>
                
                    <div class="col-lg-4 text-right">
                        <button type="button" class="btn btn-success mt-2 mr-3" id="crearMantenimiento">Nuevo Tipo de Mantenimiento</button>
                    </div>
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

    </div>
</div>

<?php
    //Incluyo pie
    include("includes/footer.php");
?>