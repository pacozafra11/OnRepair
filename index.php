<?php 
    /* Index o página de inicio, formulario de autentificación para acceder a la App Web
    *
    * @author Francisco José López Zafra
    */

    //Incluyo cabecera y db
    include("includes/head.php");
    include("includes/functions.php");
    
    //Declaración de variables
    $email= $emailErr= $password= $passwordErr= $error= "";
    $emailOk= $passwordOk= false;


    //Primero compruebo sesion
    //comprobarSesion();
        

    
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

            $error = $db->comprobarUsuario($email, $password);

            //Si es correcto el resultado redirecciono
            if($error=="OK"){
                header('Location: tareas.php');
            }
        }    
    }
?>

    <section class="container">        
        <div class="row justify-content-center align-items-center minh-100">
            <div class="col-sm-6 mt-4">
                <div class="col-sm-12">

                    <!-- Formulario html -->
                    <form name="formLogin" id="formLogin" class="form-signin" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

                        <div class="form-group">
                            <img src="images/logo_centrado.png" class="img-fluid"  alt="Logotipo On Repair" width="100%" height="auto">    
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

    <footer class="footer">
        <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
            Esta página hace uso de <a href="includes/cookies.php" class="alert-link">cookies</a> para su funcionamiento.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </footer>
    
<?php
    //Incluyo pie
    include("includes/footer.php");
?>