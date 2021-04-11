<?php 
    /* Index o página de inicio, formulario de autentificación para acceder a la App Web
    *
    * @author Francisco José López Zafra
    */

    //Incluyo funciones
    include("includes/functions.php");
    
    //Declaración de variables
    $email= $emailErr= $password= $passwordErr= $error= $classEmailErr=  $classPassErr= "";
    $emailOk= $passwordOk= false;


    //Función para filtrar y escapar caracteres especiales
    function test_input($dato) {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
      }

    //Primero compruebo sesion
    //comprobarSesion();
        

    
    //Si se ha pulsado "autentificarse"
    if(isset($_POST["autenti"])){
            
        //Comprobacíones de los campos de texto
        //Email
        if (empty($_POST["email"])) {

            $classEmailErr = "classErr";
            $emailErr = "Email es requerido";
        } else {
            //Filtro el dato
            $email = test_input($_POST["email"]);

            //Verifica si la dirección de correo electrónico está bien formada
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                //La función filter_var () filtra una variable con el filtro especificado y 
                //el filtro FILTER_VALIDATE_EMAIL valida una dirección de correo electrónico

                $classEmailErr = "classOk";
                $emailOk = true;
            }else{
            
                $classEmailErr = "classErr";
                $emailErr = "Formato de correo no valido";
            }
        }
        
        //Password
        if(empty($_POST["password"])){

            $classPassErr = "classErr";
            $passwordErr = "Contraseña es requerida";

        }else{
            $password = test_input($_POST["password"]);
            //El filtro FILTER_SANITIZE_SPECIAL_CHARS escapa caracteres especiales.
            $password2 = filter_var($password ,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(strlen($password2)>0 && strlen($password2)<21){
                
                $classPassErr = "classOk";
                $passwordOk = true;         
            }else{
                $passwordErr = "La contraseña debe tener entre 1 y 20 caracteres, no especiales";
                $classPassErr = "classErr";
            }     
        }
        
        //Si todo está correcto, envío los datos a la función para comprobar si existe el usuario y si es correcta la contraseña
        if($emailOk && $passwordOk){
 
            $error = comprobarUsuario($email, $password);
        }    
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS Bootstrap 4-->
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 
    <!-- CSS Propio -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/jpg" href="images/favicon.jpg"/>
    

    <title>On Repair</title>
</head>

<body id="bodyIndex">

    <section class="container">        
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5 mt-4 rounded" id="contLogin">
                <div class="fondo col-lg-12">

                    <!-- Formulario html -->        <!-- Protejo el envío de formulario evitando el XSS (Cross-site scripting) usando "htmlspecialchars()"  -->
                    <form name="formLogin" id="formLogin" class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">

                        <div class="form-group">
                            <img src="images/logo_centrado.png" class="img-fluid rounded mt-2"  alt="Logotipo On Repair" width="100%" height="auto">    
                        </div>

                        <!-- Campos rellenables de usuario y contraseña -->
                        <div class="form-group">
                            <input type="text" class="<?php echo $classEmailErr;?> form-control" name="email" id="email" placeholder="&#128272; Email" value="<?php echo $email;?>" pattern=".+@.+.+" autofocus maxlength="50" required> 
                            <div class="text-center"><span class="error"><?php echo $emailErr;?></span></div>   
                        </div>

                        <div class="form-group">
                            <input type="password" class="<?php echo $classPassErr;?> form-control" name="password" id="password" placeholder="&#128272; Contraseña" value="<?php echo $password;?>" maxlength="20" required>
                            <div class="text-center"><span class="error"><?php echo $passwordErr;?></span></div>
                        </div>

                        <!-- Botón enviar -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success btn-block" name="autenti">Autentificarse</button>
                            <!-- <button class="g-recaptcha btn btn-lg btn-primary btn-block" name="autenti" data-sitekey="reCAPTCHA_site_key" data-callback='onSubmit' data-action='submit'>Autentificarse</button> -->
                            <div class="text-center"><p class="error"><?php echo $error;?></p></div>
                        </div>

                    </form>  
                </div>                   
            </div>                   
        </div>        
    </section>

    <footer class="footer row justify-content-center align-items-center">
        <div class="alert alert-warning alert-dismissible fade show mt-4 col-lg-8 border" role="alert">
            Esta página hace uso de <a href="includes/cookies.php" class="alert-link">cookies</a> para su funcionamiento.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </footer>

    <!-- Script de reCAPTCHA -->
    <!-- <script>
        function onSubmit(token**) {
            document.getElementById("formLogin").submit();
        }
    </script> -->
    
<?php
    //Incluyo pie
    include("includes/footer.php");
?>