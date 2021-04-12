<?php 

/**
* Menú lateral y superior de todas las páginas
*
* @author Francisco José López Zafra
*/
        
    //Incluyo archivos
    include("includes/head.php");
    include("includes/functions.php");


    //Iniciar variables
    $login= $hora= $nombre= $ultimaConexion= $tituloPagina= "";
    $id= $rol= 0;

    //Retomo la sesión
    session_start();    

    //Si existe la sesion tomo sus valores, si no existe redirecciono a Index para que se identifique
    if(!empty($_SESSION['login'])){
        $id=$_SESSION['id'];
        $login=$_SESSION['login'];
        $hora=$_SESSION['hora'];
        $rol=$_SESSION['rol'];
        $nombre=$_SESSION['nombre'];
        $ultimaConexion=$_SESSION['ultima_conexion'];       
        
    }else{
        header('Location: index.php');
    }
?>



    <div class="d-flex" id="wrapper">

        <!-- Menú Sidebar o Lateral-->
        <div class="bg-info border-right" id="sidebar-wrapper">
                <div id="logo">
                    <img src="images/logo_horizontal.png" class="img-fluid"  alt="Logotipo On Repair" width="auto" height="auto">
                </div>

                <div class="list-group list-group-flush">
                    <a href="tareas.php" class="list-group-item list-group-item-action bg-info text-light border-top-light" id="menuTareas"><ion-icon name="clipboard" class="lead"></ion-icon> Tareas</a>
                    <a href="maquinas.php" class="list-group-item list-group-item-action bg-info text-light" id="menuMaquinas"><ion-icon name="cog" class="lead"></ion-icon> Máquinas</a>
                    <a href="grupos.php" class="list-group-item list-group-item-action bg-info text-light" id="menuGrupos"><ion-icon name="filing" class="lead"></ion-icon> Grupos de máquinas</a>
                    <a href="averias.php" class="list-group-item list-group-item-action bg-info text-light" id="menuAverias"><ion-icon name="flash" class="lead"></ion-icon> Tipos de averías</a>
                    <a href="mantenimientos.php" class="list-group-item list-group-item-action bg-info text-light" id="menuMantenimientos"><ion-icon name="construct" class="lead"></ion-icon> Tipos de mantenimiento</a>
                    <a href="repuestos.php" class="list-group-item list-group-item-action bg-info text-light" id="menuRepuestos"><ion-icon name="git-compare" class="lead"></ion-icon> Repuestos</a>
                    <a href="usuarios.php" class="list-group-item list-group-item-action bg-info text-light" id="menuUsuarios"><ion-icon name="contacts" class="lead"></ion-icon> Usuarios</a>
                    <!-- Se muestra el botón según el rol, SOLO ADMINISTRADOR -->                   
                    <?php if($rol=== "Administrador"){echo '<a href="roles.php" class="list-group-item list-group-item-action bg-info text-light" id="menuRoles"><ion-icon name="podium" class="lead"></ion-icon> Roles</a>';}?>
                </div>
            </div>
            

            <!-- Contenido -->
            <div id="page-content-wrapper">

                <!-- Menú superior -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-info border-bottom">
                    <!-- Botón ocultar menú sidebar -->
                    <button class="btn btn-light mr-4" id="menu-toggle">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <!-- Botón extender menú superior -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <!-- Desplegable con información de usuario -->
                        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $nombre;?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <div class="bg-light ml-2 mr-2 border">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                        <span id="login" class="dropdown-item"><?php echo $login;?></span>
                                        <span class="dropdown-item"><b class="text-info">Hora de Login: </b><span id="hora"><?php echo $hora;?></span></span>
                                        <span class="dropdown-item"><b class="text-info">Rol: </b><span id="rol"><?php echo $rol;?></span></span>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                        <a href="#" id="cambiarPassword" class="dropdown-item text-warning"><ion-icon name="key"></ion-icon>  Cambiar contraseña</a>
                                    <div class="dropdown-divider"></div>
                                        <a href="#" id="cerrarSesion" class="dropdown-item text-danger"><ion-icon name="log-out"></ion-icon>  Cerrar sesión</a>   
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>



                <!-- Modal con el fromulario para la contraseña del usuario activo -->
                <div class="modal fade" id="modalPassword" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">

                            <form id="formularioPassword">

                                <div class="modal-header">
                                    <h5 class="modal-title text-warning" id="tituloModalPassword"> Cambiar Contraseña</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body bg-light justify-content-center">                            
                                    <div class="row mt-3 mb-3">
                                        <div class="col-lg-6">
                                            <label for="passwordUsuario"class="text-success ml-2">Password</label>
                                            <input type="password" class="form-control" name="passwordUsuario" id="passwordUsuario" placeholder="Añadir Password ..." pattern="[a-zA-Z0-9ñÑ]{4,20}"  mixlength="4" maxlength="20" autofocus required>
                                            <span class="errorModal" id="errPass">Solo admite letras mayúsculas, minúsculas y números, entre 4 y 20 caracteres</span>
                                        </div> 
                                        <div class="col-lg-6">
                                            <label for="confPassUsuario"class="text-success ml-2">Confirmar Password</label>
                                            <input type="password" class="form-control" name="confPassUsuario" id="confPassUsuario" placeholder="Confirmar Password ..." pattern="[a-zA-Z0-9ñÑ]{4,20}"  mixlength="4" maxlength="20" required> 
                                            <span class="errorModal" id="errConfPass">Las contraseñas deben coincidir</span>
                                        </div>                      
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="cancelarModalPassword" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success" id="aceptarModalPassword">Aceptar</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                
  