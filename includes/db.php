<?php
    /**
     * Clase DB, implementa la conexión a la base de datos y otras funciones a la misma , contiene atributos y el método constructor privados.
     * 
     * @author Francisco José López Zafra
    */
    class DB{

        private $mysql;
        private $log;
        private $pass;


        public function __construct(){

            $this->mysql="mysql: host=localhost; dbname=mantenimiento; charset=utf8";
            $this->log="admin";
            $this->pass="FranciscoZafra";
        }

        //Acceso a la base de datos
        private function accesoDB(){
            
            try {
                //Instancio la conexíon y la codificación
                $conexion = new PDO($this->mysql, $this->log, $this->pass);                
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (Exception $e) {    //Capturo la excepción

                die("Error: " . $e->getMessage());   
                exit();
            } 
            
            return $conexion;            
        }


        //Método para comprobar si existe el usuario, en caso afirmativo comprobar si está bloqueado y su password
        public function comprobarUsuario($log, $pass){
            $error="";
            $contador=0;

            date_default_timezone_set('Europe/Madrid');

            //Si recibo la cookie contador
            if(isset($_COOKIE['usuario']['contador'])){
                $contador = $_COOKIE['usuario']['contador'];
            }

            //Si recibo la cookie login
            if(isset($_COOKIE['usuario']['login'])){
                $loginContador = $_COOKIE['usuario']['login'];
            } else {
                $loginContador = "";
            }

            $conexion = $this->accesoDB();               
            $sql="SELECT * FROM anunciantes WHERE login= :login";
            $resultado = $conexion->prepare($sql);
            $login=htmlentities(addslashes($log));        
            $password=htmlentities(addslashes($pass));
            $resultado->execute(array(":login"=>$login));

            //Si se ejecuta bien la sentencia por que encuentre ese usuario en la tabla y se crea el array
            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                
                //Verifico la contraseña del usuario
                if(password_verify($password, $registro["password"])){

                    if($registro["bloqueado"]==0){                        

                        //Borro la cookie
                        setcookie("usuario[login]", $login, time() -3600);
                        setcookie("usuario[contador]", $contador, time() -3600);

                        //Creo la sesión y le asigno el login y la hora de conexión
                        session_start();
                        $_SESSION['login'] = $login;
                        $_SESSION['hora'] = date('H:i:s');

                        $error = "OK";
                    } else {
                        $error = "El usuario <b>" . $login . "</b> se encuentra bloqueado, contacte con el administrador";
                    }
                //Si la contraseña introducida es incorrecta
                } else {

                    //Si el usuario no es "dwes", el administrador, realizo la acción de contar y bloqueo
                    if($login!="dwes"){
                        //Si se superan los 3 intentos de introducir la contraseña correcta
                        if($loginContador==$login && $contador>2){
                            $error = "El usuario <b>" . $login . "</b> se ha bloqueado";
                        //Si la contraseña es incorrecta
                        } else {
                            if($contador<2){ 
                                $contador++;                       
                                $error = "Contraseña incorrecta, intentos restantes: " . (3-$contador);                                

                                //Creo o modifico la cookie con una duracion de 1 hora
                                setcookie("usuario[login]", $login, time()+3600);
                                setcookie("usuario[contador]", $contador, time()+3600);
                            } else {
                                $bloquear=false;
                                //Bloqueo del usuario por superar los 3 intentos
                                if($bloquear= $this->bloquearUsuario($login)){
                                    //Borro la cookie
                                    setcookie("usuario[login]", $login, time() -3600);
                                    setcookie("usuario[contador]", $contador, time() -3600);

                                    $error = "Se ha bloquedado al usuario <b>" . $login . "</b>, contacte con el administrador";
                                } else {

                                    $error ="-- HA OCURRIDO UN ERROR INTERNO AL BLOQUEAR --";
                                }
                            }
                        }
                    } else {
                        $error = "Contraseña incorrecta";
                    }
                }                 
            } else {
                $error = "Usuario erroneo o no registrado";
            }
            //Devuelo el error para mostrarlo en pantalla
            return $error;
        }




        //Método para bloquear al usuario una vez agotado los 3 intentos de introducir la contraseña
        function bloquearUsuario($login){
            $bloqueado=false;

            $conexion = $this->accesoDB();               
            $sql = "UPDATE anunciantes SET bloqueado='1' WHERE login= :login";
            $resultado = $conexion->prepare($sql); 
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":login", $login);
            $resultado->execute();
            $afectado=$resultado->rowCount();

            if($afectado!=0){
                $bloqueado = true;
            } else {        
                $bloqueado = false;
            }
        
            return $bloqueado;    
        }

    }
?>