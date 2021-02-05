<?php
    /* Archivo que contiene funciones auxiliares */

    function comprobarSesion(){
        $resultado = false;

        //Máxima duración de sesión activa en horas
        define( 'max_sesion_tiempo', 60 * 60 * 8 );

        //Controla cuando se ha creado y cuando tiempo ha recorrido 
        if(isset( $_SESSION[ 'ultima_conexion' ] ) && ( time() - $_SESSION[ 'ultima_conexion' ] > max_sesion_tiempo )){

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

?>