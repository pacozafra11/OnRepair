<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS Bootstrap 4-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- CSS Propio -->
    <link rel="stylesheet" href="css/estilos.css">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/jpg" href="imagenes/favicon.jpg"/>

    <title>On Repair - Login</title>
</head>
<body id="index">

<?php
    
    //Declaración de variables
    $email= $emailErr= $password= $passwordErr= "";
?>

    <section>        
        <div class="container">
            <div class="row formLogin align-items-center justify-content-center">
                <div class="col-7 mt-3">
                    <!-- Formulario html -->
                    <form name="formLogin" id="formLogin" action="index.php" method="post">

                        <div class="form-group col-12 col-xs-12">
                            <div class="text-center">
                                <img src="imagenes/loco_centrado.png" class="rounded" alt="Logotipo On Repair">
                            </div>    
                        </div>

                        <!-- Campos rellenables de usuario y contraseña -->
                        <div class="form-group col-12 col-xs-12">
                            <input type="text" class="form-control" name="email" id="email" placeholder="&#128272;  Email" value="<?php echo $email;?>" autofocus maxlength="50" required> 
                            <span class="error"><?php echo $emailErr;?></span>    
                        </div>

                        <div class="form-group col-12 col-xs-12">
                            <input type="password" class="form-control" name="password" id="password" placeholder="&#128272; Contraseña" value="<?php echo $password;?>" autofocus maxlength="20" required>
                            <span class="error"><?php echo $passwordErr;?></span>
                        </div>

                    </form>                     
                </div>                   
            </div>
        </div>        
    </section>


    <!-- JS script jquery-3, Popper y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Paquete de iconos -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>

    <!-- Script propios para la página -->
    <script src="js/funciones.js"></script>

</body>
</html>