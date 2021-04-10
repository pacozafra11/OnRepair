<?php
    /* Archivo que contiene funciones auxiliares */

    //Incluyo la páginas necesarias
    include("db.php");

    //Creo un objeto db de la clase DB para su uso en las funciones
    $db = new db();

    function comprobarSesion(){
        $resultado = false;

        //Máxima duración de sesión activa en horas
        define('max_sesion_tiempo', 60 * 60 * 8 );

        //Controla cuando se ha creado y cuando tiempo ha recorrido 
        if(isset( $_SESSION['ultima_conexion'] ) && ( time() - $_SESSION['ultima_conexion'] > max_sesion_tiempo )){

            //Si ha pasado el tiempo sobre el limite destruyo la session
            $_SESSION = array();
            //Remuevo sesión.
            session_unset();
            //Destruyo sesión.
            @session_destroy();
            exit();

            $resultado = false;
        }else{  // si no ha caducado la sesion
            $resultado = true;
        }
        return $resultado;
    }

       

       /*  //Comprobamos si está aún abierta la sesión de antes.
        if(!empty($_SESSION['tiempo'])) {

            //Tiempo en segundos que durará la sesión.
            $activo = 28800;//8h en segundos este caso.

            //Calculamos tiempo de vida inactivo.
            $vida_session = time() - $_SESSION['tiempo'];

            //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
            if($vida_session > $activo){
                //Remuevo sesión.
                session_unset();
                //Destruyo sesión.
                session_destroy();              

                exit();

                $resultado = false; 

            } else {  // si no ha caducado la sesion
                $resultado = true;
            }

        } else {
            $resultado = false;            
        }

        return $resultado; 
    }*/




    /* 
        *   Función para comprobar si existe el usuario, en caso afirmativo comprobar si está bloqueado y su password
        *
        *   @access public
        */
        function comprobarUsuario($log, $pass){
            global $db;
            $error= $loginContador= "";
            $contador= $bloq= 0;            

            //Filtro los datos para pasarlos a la función de la base de datos
            $login=htmlentities(addslashes($log));        
            $password=htmlentities(addslashes($pass));
            $registro = $db->comprobarUsuarioDB($login);  
            
            //Establezco la hora local
            date_default_timezone_set('Europe/Madrid');

            //Reemplazo los posibles simbolos para el posterior almacenaje en cookies
            $reemplazo = array("@", ".", "_", "-", "+", "*", "'", "`");
            $login2 = str_replace($reemplazo, "", $login);

            
            //Si recibo la cookie contador            
            if(isset($_COOKIE[$login2]['contador'])){
                $contador = $_COOKIE[$login2]['contador']; 
            }

            //Si recibo la cookie login
            if(isset($_COOKIE[$login2]['login'])){
                $loginContador = $_COOKIE[$login2]['login']; 
            }

            //Si recibo la cookie contador            
            if(isset($_COOKIE[$login2]['bloq'])){
                $bloq = $_COOKIE[$login2]['bloq']; 
            }
        
          
            //Compruebo que el usuario no esté bloqueado por exceder el número de intentos de Login (3 int x 1h x usu).
            if($bloq===0){

                //Si se ejecuta bien la sentencia es por que encuentre ese usuario en la tabla y se crea el array
                if(gettype($registro) === "array"){

                    //Compruebo que el usuario no se encuentre bloqueado por el responsable
                    if($registro[0]["bloqueado"]==0){ 

                        //Verifico la contraseña del usuario
                        if(password_verify($password, $registro[0]["password"])){

                            //Borro la cookie
                            setcookie($login2 . "[login]", $login2, time()-3600); 
                            setcookie($login2 . "[contador]", $contador, time()-3600);
                            setcookie($login2 . "[bloq]", 0, time()-3600);

                            //Creo la sesión y le asigno el login y la hora de conexión
                            session_start();
                            
                            $_SESSION['id'] = $registro[0]["id"];
                            $_SESSION['login'] = $login;
                            $_SESSION['hora'] = date('H:i:s');
                            $_SESSION['rol'] = $registro[0]["rol"];
                            $_SESSION['nombre'] = $registro[0]["nombre"];
                            $_SESSION['ultima_conexion'] = time();   
                            
                            //Redirijo a tareas.php
                            header("Location: tareas.php");

                        //Si la contraseña es incorrecta
                        } else {
                            $contador++;

                            if($contador<=2){                        
                                $error = "Contraseña incorrecta, intentos restantes: " . (3-$contador);                                

                                //Creo la cookie con una duracion de 1 hora                            
                                setcookie($login2 . "[login]", $login2, time()+3600);  
                                setcookie($login2 . "[contador]", $contador, time()+3600);                           

                                //echo $loginContador;

                            } else {                            
                                //Bloqueo del usuario por superar los 3 intentos
                                $error = "Se ha bloquedado el acceso al usuario <br>" . $login . "</br> durante una hora. (Intentos: " . $contador . ")";
                                setcookie($login2 . "[login]", $login2, time()+3600);   //3600
                                setcookie($login2 . "[contador]", $contador, time()+3600);
                                setcookie($login2 . "[bloq]", 1, time()+3600);
                            }
                        }
                        
                    } else {
                        $error = "El usuario <b>" . $login . "</b> se encuentra bloqueado, contacte con su responsable.";
                    }               
                                        
                } else {
                    $error = $registro;
                }
            } else {
                $contador++;
                setcookie($login2 . "[contador]", $contador, time()+3600);
                $error = "El usuario <b>" . $login . "</b> se encuentra bloqueado durante una hora. (Intentos: " . $contador . ")";
            }
            //Devuelo el error para mostrarlo en pantalla
            return $error;
        }


    /* ------------------------------------------------------------Tareas------------------------------------------------------------- */

    //Si recibe por el método POST el parámetro "tareas", llama al método mostrarTareas() para que se cargen todos los datos de la tabla.
    if(isset($_POST['tareas'])){

        $ordenTareas = $_POST['tareas'];
        $tareas = $db->mostrarTareas($ordenTareas);  

        $json = json_encode($tareas);   //Retorna la representación JSON del valor dado
        echo $json;    
    }



    //Si recibe por el método POST el parámetro "accionTarea", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionTarea'])){

        if(!empty($_POST['accionTarea'])){
            $accionTarea=$_POST['accionTarea'];
            $accion=$accionTarea['accion'];
            $id=htmlentities(addslashes($accionTarea['id']));
            $titulo=htmlentities(addslashes($accionTarea['titulo']));
            $fecha=htmlentities(addslashes($accionTarea['fecha']));
            $tiempo=htmlentities(floatval(addslashes($accionTarea['tiempo'])));
            $final=htmlentities(addslashes($accionTarea['final']));
            $maquina=htmlentities(addslashes($accionTarea['maquina']));
            $tecnico=htmlentities(addslashes($accionTarea['tecnico']));
            $averia=htmlentities(addslashes($accionTarea['averia']));
            $mant=htmlentities(addslashes($accionTarea['mant']));
            $desc=htmlentities(addslashes($accionTarea['desc']));
        
            $realizado = $db->accionTarea($accion, $id, $titulo, $fecha, $tiempo, $final, $maquina, $tecnico, $averia, $mant, $desc);            
            echo $realizado;                                       
        }      
    }



    /* -------------------------------------------------------Repuestos en Tarea----------------------------------------------------------- */



    //Si recibe por el método POST el parámetro "resTareas", llama al método mostrarRepTareas() para que se cargen todos los datos de la tabla.
    if(isset($_POST['repTarea'])){

            $idTarea = $_POST['repTarea'];
            $repTarea = $db->mostrarRepTarea($idTarea);  

            $json = json_encode($repTarea);   //Retorna la representación JSON del valor dado
            echo $json;           
    }


    //Si recibe por el método POST el parámetro "accionRepTarea", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionRepTarea'])){

        if(!empty($_POST['accionRepTarea'])){
            $accionRepTarea=$_POST['accionRepTarea'];
            $accion=$accionRepTarea['accion'];
            $referencia=htmlentities(addslashes($accionRepTarea['referencia']));
            $idTarea2=htmlentities(addslashes($accionRepTarea['idTarea']));
            $cantidad=htmlentities(addslashes($accionRepTarea['cantidad']));
        
            $realizado = $db->accionRepTarea($accion, $referencia, $idTarea2, $cantidad);            
            echo $realizado;
        }      
    }


    /* ------------------------------------------------------------Máquinas------------------------------------------------------------- */

    //Si recibe por el método POST el parámetro "tareas", llama al método mostrarMaquinas() para que se cargen todos los datos de la tabla.
    if(isset($_POST['maquinas'])){

        $maquinas = $db->mostrarMaquinas();  

        $json = json_encode($maquinas);   //Retorna la representación JSON del valor dado
        echo $json;    
    }


    //Si recibe por el método POST el parámetro "accionMaquina", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionMaquina'])){

        if(!empty($_POST['accionMaquina'])){
            $accionMaquina=$_POST['accionMaquina'];
            $accion=$accionMaquina['accion'];
            $id=htmlentities(addslashes($accionMaquina['id']));
            $nombre=htmlentities(addslashes($accionMaquina['nombre']));
            $marca=htmlentities(addslashes($accionMaquina['marca']));
            $modelo=htmlentities(addslashes($accionMaquina['modelo']));
            $grupo=htmlentities((int)addslashes($accionMaquina['grupo']));
            $desc=htmlentities(addslashes($accionMaquina['desc']));
        
            $realizado = $db->accionMaquina($accion, $id, $nombre, $marca, $modelo, $grupo, $desc);            
            echo $realizado;
        }      
    }




    //Si recibe por POST el parámetro "busqueda", , pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    $busqueda="";
    if(isset($_POST['busqueda'])){

        if(!empty($_POST['busqueda'])){
        
            $busqueda=htmlentities(addslashes($_POST['busqueda']));    

            $resultado = $db->buscarNombres($busqueda);        
            $json = json_encode($resultado);    //Retorna la representación JSON del valor dado
            echo $json;
        }    
    }


    /* ------------------------------------------------------------Grupos de Máquinas--------------------------------------------------------- */

    //Si recibe por el método POST el parámetro "grupos", llama al método mostrarGrupos() para que se cargen todos los datos de la tabla.
    if(isset($_POST['grupos'])){

        $grupos = $db->mostrarGrupos();  

        $json = json_encode($grupos);   //Retorna la representación JSON del valor dado
        echo $json;    
    }


     //Si recibe por el método POST el parámetro "accionGrupo", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
     if(isset($_POST['accionGrupo'])){

        if(!empty($_POST['accionGrupo'])){
            $accionGrupo=$_POST['accionGrupo'];
            $accion=$accionGrupo['accion'];
            $id=htmlentities(addslashes($accionGrupo['id']));
            $nombre=htmlentities(addslashes($accionGrupo['nombre']));
        
            $realizado = $db->accionGrupo($accion, $id, $nombre);            
            echo $realizado;
        }      
    }



    /* ------------------------------------------------------------Tipos de Averías-------------------------------------------------------------- */

    //Si recibe por el método POST el parámetro "averias", llama al método mostrarAverias() para que se cargen todos los datos de la tabla.
    if(isset($_POST['averias'])){

        $averias = $db->mostrarAverias();  

        $json = json_encode($averias);   //Retorna la representación JSON del valor dado
        echo $json;    
    }


    //Si recibe por el método POST el parámetro "accionAveria", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionAveria'])){

        if(!empty($_POST['accionAveria'])){
            $accionAveria=$_POST['accionAveria'];
            $accion=$accionAveria['accion'];
            $id=htmlentities(addslashes($accionAveria['id']));
            $nombre=htmlentities(addslashes($accionAveria['nombre']));
        
            $realizado = $db->accionAveria($accion, $id, $nombre);            
            echo $realizado;
        }      
    }


    /* ------------------------------------------------------------Tipos de Mantenimiento--------------------------------------------------------- */

    //Si recibe por el método POST el parámetro "manteni", llama al método mostrarMantenimientos() para que se cargen todos los datos de la tabla.
    if(isset($_POST['manteni'])){

        $manteni = $db->mostrarMantenimientos();  

        $json = json_encode($manteni);   //Retorna la representación JSON del valor dado
        echo $json;    
    }


    //Si recibe por el método POST el parámetro "accionManteni", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionManteni'])){

        if(!empty($_POST['accionManteni'])){
            $accionManteni=$_POST['accionManteni'];
            $accion=$accionManteni['accion'];
            $id=htmlentities(addslashes($accionManteni['id']));
            $nombre=htmlentities(addslashes($accionManteni['nombre']));
        
            $realizado = $db->accionManteni($accion, $id, $nombre);            
            echo $realizado;
        }      
    }


    /* ---------------------------------------------------------------Repuestos----------------------------------------------------------------- */

    //Si recibe por el método POST el parámetro "repuestos", llama al método mostrarRepuestos() para que se cargen todos los datos de la tabla.
    if(isset($_POST['repuestos'])){

        $repuestos = $db->mostrarRepuestos();  

        $json = json_encode($repuestos);   //Retorna la representación JSON del valor dado
        echo $json;    
    }


    //Si recibe por el método POST el parámetro "accionRepuesto", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionRepuesto'])){

        if(!empty($_POST['accionRepuesto'])){
            $accionRepuesto=$_POST['accionRepuesto'];
            $accion=$accionRepuesto['accion'];
            $id_old=htmlentities(addslashes($accionRepuesto['id_old']));
            $id_new=htmlentities(addslashes($accionRepuesto['id_new']));
            $nombre=htmlentities(addslashes($accionRepuesto['nombre']));
            $desc=htmlentities(addslashes($accionRepuesto['desc']));
        
            $realizado = $db->accionRepuesto($accion, $id_old, $id_new, $nombre, $desc);            
            echo $realizado;
        }      
    }

    /* ---------------------------------------------------------------Usuarios----------------------------------------------------------------- */
    
    //Si recibe por el método POST el parámetro "usuarios", llama al método mostrarUsuarios() para que se cargen todos los datos de la tabla.
    if(isset($_POST['usuarios'])){

        $usuarios = $db->mostrarUsuarios();  

        $json = json_encode($usuarios);   //Retorna la representación JSON del valor dado
        echo $json;    
    }


    //Si recibe por el método POST el parámetro "accionUsuario", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionUsuario'])){

        if(!empty($_POST['accionUsuario'])){
            $accionUsuario=$_POST['accionUsuario'];
            $accion=$accionUsuario['accion'];
            $id=htmlentities(addslashes((int)$accionUsuario['id']));
            $nombre=htmlentities(addslashes($accionUsuario['nombre']));
            $rol=htmlentities(addslashes($accionUsuario['rol']));
            $email=htmlentities(addslashes($accionUsuario['email']));
            $bloque=htmlentities(addslashes($accionUsuario['bloque']));
            $pass=htmlentities(addslashes($accionUsuario['pass']));
        
            $realizado = $db->accionUsuario($accion, $id, $nombre, $rol, $email, $bloque, $pass);            
            echo $realizado;
        }      
    }



    /* ------------------------------------------------------------------Roles------------------------------------------------------------------- */

    //Si recibe por el método POST el parámetro "roles", llama al método mostrarRoles() para que se cargen todos los datos de la tabla.
    if(isset($_POST['roles'])){

        $roles = $db->mostrarRoles();  

        $json = json_encode($roles);   //Retorna la representación JSON del valor dado
        echo $json;    
    }


    //Si recibe por el método POST el parámetro "accionRol", pasa los datos recibidos a variables, los filtra e invoca a la función pasandole las variables como parámetros.
    if(isset($_POST['accionRol'])){

        if(!empty($_POST['accionRol'])){
            $accionRol=$_POST['accionRol'];
            $accion=$accionRol['accion'];
            $id=htmlentities(addslashes($accionRol['id']));
            $nombre=htmlentities(addslashes($accionRol['nombre']));
        
            $realizado = $db->accionRol($accion, $id, $nombre);            
            echo $realizado;
        }      
    }
?>