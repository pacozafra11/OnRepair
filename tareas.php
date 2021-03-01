<?php 
    /* Página que muestra las tareas
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
                        <div class="col-lg-3 text-left mt-2">
                            <h2 class="mt-1 text-info"><ion-icon name="clipboard" class="lead text-warning"></ion-icon> TAREAS</h2>                        
                        </div>

                        <div class="col-lg-2 mt-3 text-right text-secondary">                            
                            <span class="text-right">Ordenadas por: </span>
                        </div>

                        <div class="col-lg-4 mt-2">
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                                    fecha, descendente
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                    <a href="#" class="ordenTareas dropdown-item">fecha, ascendente</a>
                                    <a href="#" class="ordenTareas dropdown-item">máquina, Id ascendente</a>
                                    <a href="#" class="ordenTareas dropdown-item">técnico, alfabéticamente</a>
                                    <a href="#" class="ordenTareas dropdown-item">finalizada</a>
                                </div>
                            </div>                            
                        </div>

                        <div class="col-lg-3 text-right">
                                <button type="button" class="btn btn-success mt-2" id="crearTarea">Nueva Tarea</button>
                        </div>
                    </div>  

                    <!-- Contenedor que alojará las tareas a mostrar -->
                    <div id="cont_mostrar_tareas">
                        
                    </div>
                            
                    

                    <!-- Button trigger modal -->
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalModificarTarea">Launch demo modal</button> -->
                    <!-- Modal -->
                    <div class="modal fade" id="modalModificarTarea" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title text-info" id="tituloModalModificarTarea">Modificar Tarea</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <table class="table table-striped">
                                        <tr scope="row">
                                            <td><label for="titulo"><b>Título</b></label></td>
                                            <td><input type="text" class="form-group" name="titulo" id="titulo" value="autor" maxlength="20" required>
                                                <span class="error" id="autorErr">$autorErr</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td><label for="fecha"><b>Fecha</b></label></td>
                                            <td><input type="date" class="form-group" name="fecha" id="fecha" required>
                                                <span class="error" id="fechaErr">$fechaErr</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td><label for="moroso"><b>Moroso</b></label></td>  
                                            <td><input type="text" class="form-group" name="moroso" id="moroso" value="moroso" placeholder="Nombre moroso" maxlength="60" required autofocus>
                                                <span class="error" id="morosoErr">$morosoErr</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td><label for="direccion"><b>Dirección</b></label></td>
                                            <td><input type="text" class="form-group" name="direccion" id="direccion" value="direccion" placeholder="Dirección y Localidad" maxlength="60" required>
                                                <span class="error" id="direccionErr">$direccionErr</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td colspan="2"><label for="descripcion"><b>Descripción</b></label><br>
                                                <textarea class="form-group" name="descripcion" id="descripcion" rows="4" cols="40" maxlength="500" value="descripcion" placeholder="Escribe aquí tu descripción..." required></textarea><br>
                                                <span class="error" id="descripcionErr">$descripcionErr</span></td>
                                        </tr>
                                    </table>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary">Guardar Cambios</button>
                                </div>
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