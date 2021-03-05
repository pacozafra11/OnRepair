<!-- Menú lateral y superior de todas las páginas

@author Francisco José López Zafra -->
    
<?php 
        
        //Incluyo los de mas archivos
        include("includes/head.php");

    
        //Iniciar variables
        $login= $hora= $nombre= $ultimaConexion= $tituloPagina= "";
        $rol= 0;

        //Retomo la sesión
        session_start();    

        //Si existe la sesion tomo sus valores, si no existe redirecciono a Index para que se identifique
        if(!empty($_SESSION['login'])){
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
                    <a href="tareas.php" class="list-group-item list-group-item-action bg-info text-light" id="menuTareas"><ion-icon name="clipboard" class="lead"></ion-icon> Tareas</a>
                    <a href="maquinas.php" class="list-group-item list-group-item-action bg-info text-light" id="menuMaquinas"><ion-icon name="cog" class="lead"></ion-icon> Máquinas</a>
                    <a href="grupos.php" class="list-group-item list-group-item-action bg-info text-light" id="menuGrupos"><ion-icon name="filing" class="lead"></ion-icon> Grupos de máquinas</a>
                    <a href="averias.php" class="list-group-item list-group-item-action bg-info text-light" id="menuAverias"><ion-icon name="flash" class="lead"></ion-icon> Tipos de averías</a>
                    <a href="mantenimientos.php" class="list-group-item list-group-item-action bg-info text-light" id="menuMantenimientos"><ion-icon name="construct" class="lead"></ion-icon> Tipos de mantenimiento</a>
                    <a href="repuestos.php" class="list-group-item list-group-item-action bg-info text-light" id="menuRepuestos"><ion-icon name="git-compare" class="lead"></ion-icon> Repuestos</a>
                    <a href="usuarios.php" class="list-group-item list-group-item-action bg-info text-light" id="menuUsuarios"><ion-icon name="contacts" class="lead"></ion-icon> Usuarios</a>
                    <?php if($rol==1){echo '<a href="roles.php" class="list-group-item list-group-item-action bg-info text-light" id="menuRoles"><ion-icon name="podium" class="lead"></ion-icon> Roles</a>';}?>
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
                                    <span id="login" class="dropdown-item"><?php echo $login;?></span>
                                    <span id="hora" class="dropdown-item"><?php echo $hora;?></span>
                                    <span id="rol" class="dropdown-item"><?php if($rol==1){echo "Administrador";}elseif($rol==2){echo "Responsable";}else{echo "Técnico";}?></span>
                                    <div class="dropdown-divider"></div>
                                    <a href="includes/go_out.php" class="dropdown-item text-danger">Cerrar sesión <ion-icon name="log-out"></ion-icon></a>   
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                
  