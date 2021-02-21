
<?php 
    /* Página que muestra las máquinas
    *
    * @author Francisco José López Zafra
    */
    
    //Incluyo los de mas archivos    
    include("includes/menu.php");

    $tituloPagina = "MÁQUINAS";
    
?>

        <div class="content">
            <div class="container">
                <div class="row pb-2">

                    <!-- Contenedor que contiene el título de la página -->
                    <div class="col-lg-3 text-left mt-2">
                        <h2 class="mt-1 text-info">MÁQUINAS</h2>                        
                    </div>

                    <div class="col-lg-6 text-center">
                        <!-- Campo de busqueda -->
                        <form class="form-inline position-relative d-inline-block mt-2">
                            <input class="form-control border border-info mr-sm-2" type="search" id="busqueda" placeholder="Buscar por nombre" aria-label="Search" pattern="[a-zA-Z 0-9 áéíóúñÑ-]{0,50}" required>
                        </form>
                    </div>
                
                    <div class="col-lg-3 text-right">
                        <button type="button" class="btn btn-success mt-2 mr-3" id="crearMaquina">Nueva Máquina</button>
                    </div>
                </div>

                <!-- Contenedor que alojará las maquinas a mostrar -->
                <div id="cont_mostrar_maquinas">
                                
                </div>





            </div>
        </div>

    </div>
</div>

<?php
    //Incluyo pie
    include("includes/footer.php");
?>