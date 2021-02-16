<?php 
    /* Página que muestra las tareas
    *
    * @author Francisco José López Zafra
    */

    //Incluyo los de mas archivos    
    include("includes/menu.php");
    $titulo = "TAREAS";
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
                        <!-- <div class="col-lg-4">
                            <h2 class="mt-3 text-info">TAREAS</h2>
                        </div> -->

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
                                <div class="col-lg-12 bg-warning text-secondary">';

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
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tr>
                                            <td class="font-weight-bold ">Id: </td>
                                            <td class="text-start">' . $tarea['Id'] . '</td>
                                            <td class="font-weight-bold">Título: </td>
                                            <td colspan="2"  class="text-start">' . $tarea['Título'] . '</td>
                                            <td class="text-end"><button type="button" class="btn btn-outline-primary"><ion-icon name="create" class="pt-1"></ion-icon></button> &nbsp <button type="button" class="btn btn-outline-danger"><ion-icon name="trash" class="pt-1"></ion-icon></button></td> 
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Descripción: </td>
                                            <td colspan="5"  class="text-start">' . $tarea['Descripción'] . '</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tiempo Empleado: </td>
                                            <td class="text-start">' . $tarea['Tiempo Empleado'] . 'h</td>
                                            <td class="font-weight-bold">Fecha: </td>
                                            <td class="text-start">' . $tarea['Fecha'] . '</td>
                                            <td class="font-weight-bold">Finalizada: </td>
                                            <td class="text-start">' . $tarea['Finalizada'] . '</td>                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="font-weight-bold">Tipo de Mantenimiento: </td>
                                            <td class="text-start">' . $tarea['Tipo de Mantenimiento'] . '</td>
                                            <td class="font-weight-bold">Tipo de Avería: </td>
                                            <td colspan="2" class="text-start">' . $tarea['Tipo de Avería'] . '</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Técnico: </td>
                                            <td colspan="2" class="text-start">' . $tarea['Técnico'] . '</td>
                                            <td class="font-weight-bold">Máquina: </td>
                                            <td colspan="2" class="text-start">' . $tarea['Máquina'] . '</td>
                                        </tr>                                
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
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