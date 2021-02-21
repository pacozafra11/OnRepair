
<?php 
    /* Página que muestra los grupos de máquinas
    *
    * @author Francisco José López Zafra
    */
    
    //Incluyo los de mas archivos    
    include("includes/menu.php");

    $tituloPagina = "GRUPOS DE MÁQUINAS";
    
?>

        <div class="content">
            <div class="container">
                <div class="row pb-2"> 
                    
                    <!-- Contenedor que contiene el título de la página -->
                    <div class="col-lg-9 text-left mt-2">
                        <h2 class="mt-1 text-info">GRUPOS DE MÁQUINAS</h2>                        
                    </div>
                
                    <div class="col-lg-3 text-right">
                        <button type="button" class="btn btn-success mt-2 mr-3" id="crearGrupo">Nuevo Grupo</button>
                    </div>
                </div>

                <!-- Contenedor que alojará las maquinas a mostrar -->
                <div id="cont_mostrar_grupos">
                                
                </div>





            </div>
        </div>

    </div>
</div>

<?php
    //Incluyo pie
    include("includes/footer.php");
?>