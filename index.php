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
<body id="index" class="text-center bg-light h-100">

<?php
    
    //Declaración de variables
    $email= $emailErr= $password= $passwordErr= $error= "";
    $emailOk= $passwordOk= false;

    //Si se ha pulsado "autentificarse"
    if(isset($_POST["autenti"])){
            
        //Comprobacíones de los campos de texto
        //Email
        if (empty($_POST["email"])) {

            $emailErr = "Email es requerido";
        } else {
            $email = $_POST["email"];
            //Verifica si la dirección de correo electrónico está bien formada
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                //La función filter_var () filtra una variable con el filtro especificado y 
                //el filtro FILTER_VALIDATE_EMAIL valida una dirección de correo electrónico

                $emailOk = true;
            }else{
            
                $emailErr = "Formato de correo no valido";
            }
        }
        
        //Password
        if(empty($_POST["password"])){
            $passwordErr = "Contraseña es requerida";
        }else{
            $password = $_POST["password"];

            if(strlen($password)>0 && strlen($password) <21){
                $passwordOk = true;          
            }else{
                $passwordErr = "La contraseña debe tener entre 1 y 20 caracteres";
            }     
        }
        
        //Si todo está correcto, envío los datos a la función para comprobar si existe el usuario y si es correcta la contraseña
        if($emailOk && $passwordOk){

            $db = new db();
            $error = $db->comprobarUsuario($usuario, $password);

            //Si es correcto el resultado redirecciono
            if($error=="OK"){
                header('Location: escaparate.php');
            }
        }    
    }
?>

    <section class="container">        
        <div class="row justify-content-center align-items-center minh-100">
            <div class="col-sm-7 mt-4">
                <div class="col-sm-12">

                    <!-- Formulario html -->
                    <form name="formLogin" id="formLogin" class="form-signin" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

                        <div class="form-group">
                            <img src="imagenes/logo_centrado.png" class="img-fluid"  alt="Logotipo On Repair" width="100%" height="auto">    
                        </div>

                        <!-- Campos rellenables de usuario y contraseña -->
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" id="email" placeholder="&#128272;  Email" value="<?php echo $email;?>" autofocus maxlength="50" required> 
                            <span class="error"><?php echo $emailErr;?></span>    
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="&#128272; Contraseña" value="<?php echo $password;?>" maxlength="20" required>
                            <span class="error"><?php echo $passwordErr;?></span>
                        </div>

                        <!-- Botón enviar -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary btn-block" name="autenti">Autentificarse</button>
                            <span class="error"><?php echo $error;?></span>
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