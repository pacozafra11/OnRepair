
<!-- Menú lateral de todas las páginas

@author Francisco José López Zafra -->
    
    <?php 
        $_SESSION['rol'] = 3;
    ?>

    <div id="menu" class="sidenav bg-info">
        <img src="images/logo_horizontal.png" class="img-fluid"  alt="Logotipo On Repair" width="100%" height="auto">

        <a href="#" class="active">Tareas</a>
        <a href="#">Máquinas</a>
        <a href="#">Grupos de máquinas</a>
        <a href="#">Tipos de averías</a>
        <a href="#">Tipos de mantenimiento</a>
        <a href="#">Repuestos</a>
        <a href="#">Usuarios</a>
        <?php if($_SESSION['rol']==1){echo '<a href="#">Roles</a>';}?>
        <a href="includes/go_out.php">Salir</a>

        <a href="#" class="closebtn" id ="cerrar_menu" >&times;</a>
    </div>

    
