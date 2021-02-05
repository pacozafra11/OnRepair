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
            $error= $loginContador= "";
            $contador=0;

            date_default_timezone_set('Europe/Madrid');

            $conexion = $this->accesoDB();               
            $sql="SELECT * FROM usuarios WHERE email= :login";
            $resultado = $conexion->prepare($sql);
            $login=htmlentities(addslashes($log));        
            $password=htmlentities(addslashes($pass));
            $resultado->execute(array(":login"=>$login));

            //Si recibo la cookie contador
            if(isset($_COOKIE[$login]['contador'])){
                $contador = $_COOKIE[str_replace("_", ".", $login)]['contador'];
            }

            //Si recibo la cookie login
            if(isset($_COOKIE[$login]['login'])){
                $loginContador = $_COOKIE[str_replace("_", ".", $login)]['login'];
            } else {
                $loginContador = "";
            }

            //Si se ejecuta bien la sentencia es por que encuentre ese usuario en la tabla y se crea el array
            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){

                //Compruebo que el usuario no se encuentre bloqueado
                if($registro["bloqueado"]==0){ 

                    //Verifico la contraseña del usuario
                    if(password_verify($password, $registro["password"]) && $contador<2){

                        //Borro la cookie
                        setcookie(str_replace(".", "_", $login) . "[login]", $login, time() -3600);
                        setcookie(str_replace(".", "_", $login) . "[contador]", $contador, time() -3600);

                        //Creo la sesión y le asigno el login y la hora de conexión
                        session_start();
                        
                        $_SESSION['login'] = $login;
                        $_SESSION['hora'] = date('H:i:s');
                        $_SESSION['rol'] = $registro["id_rol"];
                        $_SESSION['ultima_conexion'] = time();   
                        
                        //Redirijo a tareas.php
                        header("Location: tareas.php");

                    //Si la contraseña es incorrecta
                    } else {

                        if($contador<2){ 
                            $contador++;                       
                            $error = "Contraseña incorrecta, intentos restantes: " . (3-$contador);                                

                            //Creo la cookie con una duracion de 1 hora
                            setcookie(str_replace("_", ".", $login) . "[login]", $login, time()+3600);
                            setcookie(str_replace("_", ".", $login) . "[contador]", $contador, time()+3600);

                            echo $loginContador;

                        } else {
                            //Bloqueo del usuario por superar los 3 intentos
                            $error = "Se ha bloquedado el acceso al usuario <br>" . $login . "</br> durante una hora";
                        }
                    }
                    
                } else {
                    $error = "El usuario <b>" . $login . "</b> se encuentra bloqueado, contacte con su responsable";
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
            $sql = "UPDATE usuarios SET bloqueado='1' WHERE email= :login";
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