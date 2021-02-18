<?php 
    /* Página que muestra las tareas
    *
    * @author Francisco José López Zafra
    */

    $tituloPagina = "TAREAS";
    
    //Incluyo los de mas archivos    
    include("includes/menu.php");
    
?>
    
            <div id="content">
                <div class="container">
                    <div class="row pb-2">
                        <div class="col-lg-4">
                            <!-- Campo de busqueda -->
                            <form class="form-inline position-relative d-inline-block mt-2">
                                <input class="form-control mr-sm-2" type="search" id="busqueda" placeholder="Buscar..." aria-label="Search" pattern="[a-zA-Z 0-9 áéíóúñÑ-]{0,50}" required>
                            </form>
                        </div>

                        <div class="col-lg-3 mt-3 text-right">
                            <span class="text-right">Ordenar por: </span>
                        </div>

                        <div class="col-lg-3 mt-2">
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                                    fecha, descendente
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                    <a href="#" class="dropdown-item">fecha, ascendente</a>
                                    <a href="#" class="dropdown-item">máquina, alfabéticamente</a>
                                    <a href="#" class="dropdown-item">técnico, alfabéticamente</a>
                                    <a href="#" class="dropdown-item">finalizada</a>
                                </div>
                            </div>                            
                        </div>

                    <div class="col-lg-2 Align-items-center">
                            <button type="button" class="btn btn-success mt-2" id="crearTarea">Crear nueva
                            </button>
                        </div>
                    </div>  
                            
                    <?php 
                        $db = new db;
                        $tareas = $db->mostrarTareas();                            
                    
                    foreach ($tareas as $tarea){

                        $tarea['Finalizada']==1 ? $tarea['Finalizada']='Sí' : $tarea['Finalizada']='No';

                        echo '<div class="row p-2" id="' . $tarea['Id'] . '">
                                <div class="col-lg-12 bg-light text-secondary border">';

                                echo '<div class="table-responsive">                                
                                    <table class="table" id="tablasTareas">
                                        <tr>
                                            <td colspan="2"><span class="text-success font-weight-bold">Título </span>' . $tarea['Título'] . '</td>
                                            <td class="colDerecha text-right">
                                                <button type="button" class="actualizarTarea btn btn-outline-primary">
                                                    <ion-icon name="create" class="pt-1"></ion-icon>
                                                </button> 
                                                &nbsp 
                                                <button type="button" class="eliminarTarea btn btn-outline-danger">
                                                    <ion-icon name="trash" class="pt-1"></ion-icon>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="4"><span class="text-success font-weight-bold">Descripción </span><br>' . $tarea['Descripción'] . '</td>
                                            <td><span class="text-success font-weight-bold">Máquina </span>' . $tarea['Máquina'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Id </span>' . $tarea['Id'] . '</td> 
                                        </tr>
                                        <tr>
                                            
                                            <td><span class="text-success font-weight-bold">Técnico </span>' . $tarea['Técnico'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Tiempo Empleado </span>' . $tarea['Tiempo Empleado'] . 'h</td>                                          
                                        </tr>
                                        <tr>
                                            
                                            <td><span class="text-success font-weight-bold">Fecha </span>' . $tarea['Fecha'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Avería </span>' . $tarea['Tipo de Avería'] . '</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-success font-weight-bold">Finalizada </span>' . $tarea['Finalizada'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Mantenimiento </span>' . $tarea['Tipo de Mantenimiento'] . '</td>
                                        </tr>                                
                                    </table>';                      

                        echo '</div>
                            </div>                       
                        </div>';
                    }
                    

                    ?>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalModificarTarea">Launch demo modal</button> 

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
                                            <td><input type="text" class="form-group" name="titulo" id="titulo" value="{$autor}" maxlength="20" required>
                                                <span class="error" id="autorErr">{$autorErr}</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td><label for="fecha"><b>Fecha</b></label></td>
                                            <td><input type="date" class="form-group" name="fecha" id="fecha" value="{$fecha}" required>
                                                <span class="error" id="fechaErr">{$fechaErr}</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td><label for="moroso"><b>Moroso</b></label></td>  
                                            <td><input type="text" class="form-group" name="moroso" id="moroso" value="{$moroso}" placeholder="Nombre moroso" maxlength="60" required autofocus>
                                                <span class="error" id="morosoErr">{$morosoErr}</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td><label for="direccion"><b>Dirección</b></label></td>
                                            <td><input type="text" class="form-group" name="direccion" id="direccion" value="{$direccion}" placeholder="Dirección y Localidad" maxlength="60" required>
                                                <span class="error" id="direccionErr">{$direccionErr}</span></td>
                                        </tr>
                                        <tr scope="row">
                                            <td colspan="2"><label for="descripcion"><b>Descripción</b></label><br>
                                                <textarea class="form-group" name="descripcion" id="descripcion" rows="4" cols="40" maxlength="500" value="{$descripcion}" placeholder="Escribe aquí tu descripción..." required></textarea><br>
                                                <span class="error" id="descripcionErr">{$descripcionErr}</span></td>
                                        </tr>
                                    </table>
                                    <!-- <table class="table">
                                        <tr>
                                            <td colspan="2"><span class="text-success font-weight-bold">Título </span>' . $tarea['Título'] . '</td>
                                            <td class="colDerecha text-right">
                                                <button type="button" class="actualizarTarea btn btn-outline-primary">
                                                    <ion-icon name="create" class="pt-1"></ion-icon>
                                                </button> 
                                                &nbsp 
                                                <button type="button" class="eliminarTarea btn btn-outline-danger">
                                                    <ion-icon name="trash" class="pt-1"></ion-icon>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="4"><span class="text-success font-weight-bold">Descripción </span><br>' . $tarea['Descripción'] . '</td>
                                            <td><span class="text-success font-weight-bold">Máquina </span>' . $tarea['Máquina'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Id </span>' . $tarea['Id'] . '</td> 
                                        </tr>
                                        <tr>
                                            
                                            <td><span class="text-success font-weight-bold">Técnico </span>' . $tarea['Técnico'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Tiempo Empleado </span>' . $tarea['Tiempo Empleado'] . 'h</td>                                          
                                        </tr>
                                        <tr>
                                            
                                            <td><span class="text-success font-weight-bold">Fecha </span>' . $tarea['Fecha'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Avería </span>' . $tarea['Tipo de Avería'] . '</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-success font-weight-bold">Finalizada </span>' . $tarea['Finalizada'] . '</td>
                                            <td class="colDerecha"><span class="text-success font-weight-bold">Tipo de Mantenimiento </span>' . $tarea['Tipo de Mantenimiento'] . '</td>
                                        </tr>                                
                                    </table> -->
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
</div>

<?php
    //Incluyo pie
    include("includes/footer.php");
?>