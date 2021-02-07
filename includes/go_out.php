<?php

//Aquí realizo el cierre/destrucción/anulación de las sesiones y conexiones
// a la base de datos, y volver a la página de inicio index.php
session_start();

if(session_unset()){

    if(session_destroy()){

        global $base;
        $base = null;

        header('Location: ../index.php');
    }
}

?>