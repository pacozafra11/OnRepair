<?php

    /**
     * Clase DB, implementa la conexión a la base de datos y otras funciones a la misma ,
     * contiene atributos y el método constructor privados.
     * 
     * @author Francisco José López Zafra
     */
    class DB{
        //Variables privadas
        private $mysql;
        private $log;
        private $pass;


        /**
         * Método constructor, de acceso publico, contiene los datos para la conexión en local
         * 
         * @access public
         */
        public function __construct(){

            //CONEXIÓN LOCAL
            $this->mysql="mysql: host=localhost; dbname=mantenimiento; charset=utf8";
            $this->log="admin";
            $this->pass="FranciscoZafra";
        }

        /**
         * Función de acceso a la base de datos, no recibe parámetros y devuelve la conexión
         * 
         * @access private
         * @return $conexion
         */
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


        /**
         * Función para comprobar en la base de datos si existe el usuario, en caso afirmativo devuelve los daots de ses usuario para comprobarlos
         *
         * @access public
         * @param string $login 
         * @return array $realizado
         */
        public function comprobarUsuarioDB($login){

             $conexion = $this->accesoDB();               
            $sql="SELECT usuarios.id AS id, usuarios.nombre AS nombre, usuarios.email AS email, usuarios.password AS password,
                usuarios.bloqueado AS bloqueado, roles.nombre AS rol 
                        FROM usuarios 
                        INNER JOIN roles ON usuarios.id_rol = roles.id
                        WHERE email= :login";
            $resultado = $conexion->prepare($sql);
            $resultado->execute(array(":login"=>$login));
            
            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "Usuario no registrado";
            }         
            return $registros;
        }


        /* ----------------------------------------------------------------------TAREAS----------------------------------------------------------------------------------------- */

        /** 
         * Función para mostrar tareas, según el parámetro recibido, así las ordena
         *
         * @access public
         * @param string $ordenTareas 
         * @return array $realizado
         */        
         public function mostrarTareas($ordenTareas){
            $orden = "";

            //Según se seleccione en el dropdown de ordenación
            switch ($ordenTareas) {
                case "máqui":
                    $orden = "maquina";
                    break;

                case "técni":
                    $orden = "tecnico";
                    break;

                case "final":
                    $orden = "finalizada, fecha DESC";
                    break;

                default:
                    $orden = "fecha DESC";
            }

            $conexion = $this->accesoDB();
            $sql="SELECT tareas.id AS id, tareas.titulo AS titulo, tareas.descripcion AS descripcion, tareas.tiempo AS tiempo, 
                tareas.fecha AS fecha, tareas.finalizada AS finalizada, tipo_mantenimiento.nombre AS mantenimiento, 
                tipo_averia.nombre AS averia, usuarios.nombre AS tecnico, maquinas.nombre AS maquina
                        FROM tareas 
                        INNER JOIN tipo_mantenimiento ON tareas.id_tipo_mantenimiento = tipo_mantenimiento.id
                        INNER JOIN tipo_averia ON tareas.id_tipo_averia = tipo_averia.id
                        INNER JOIN usuarios ON tareas.id_usuario = usuarios.id
                        INNER JOIN maquinas ON tareas.id_maquina = maquinas.id
                        ORDER BY $orden";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }



        /**
         * Función para modificar, crear o borrar una Tarea según la acción recibida
         *
         * @access public
         * @param  string $accion 
         * @param int $id
         * @param string $titulo
         * @param date $fecha
         * @param double $tiempo
         * @param int $maquina 
         * @param int $tecnico
         * @param int $averia
         * @param int $mant 
         * @param string $desc
         * @return string $realizado
         */
        public function accionTarea($accion, $id, $titulo, $fecha, $tiempo, $final, $maquina, $tecnico, $averia, $mant, $desc){
            $realizado = "";
            $afectado=0;
            $conexion = $this->accesoDB();

            //Si la acción es Modificar una Tarea existente
            if ($accion == "Modificar Tarea"){
                $sql="UPDATE tareas SET titulo=:titulo, descripcion=:descripcion, tiempo=:tiempo, fecha=:fecha, finalizada=:final, id_tipo_mantenimiento=:mant, id_tipo_averia=:averia, id_usuario=:tecnico, id_maquina=:maquina WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                $resultado->bindParam(':titulo', $titulo);
                $resultado->bindParam(':descripcion', $desc); 
                $resultado->bindParam(':tiempo', $tiempo);
                $resultado->bindParam(':fecha', $fecha);
                $resultado->bindParam(':final', $final);
                $resultado->bindParam(':mant', $mant);
                $resultado->bindParam(':averia', $averia);
                $resultado->bindParam(':tecnico', $tecnico);
                $resultado->bindParam(':maquina', $maquina);
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear una nueva Tarea
            } elseif ($accion == "Nueva Tarea") {
                $sql="INSERT INTO tareas (titulo, descripcion, tiempo, fecha, finalizada, id_tipo_mantenimiento, id_tipo_averia, id_usuario, id_maquina) VALUES (:titulo, :descripcion, :tiempo, :fecha, :final, :mant, :averia, :tecnico, :maquina)";
                $resultado=$conexion->prepare($sql);           
                $resultado->bindParam(':titulo', $titulo);
                $resultado->bindParam(':descripcion', $desc); 
                $resultado->bindParam(':tiempo', $tiempo);
                $resultado->bindParam(':fecha', $fecha);
                $resultado->bindParam(':final', $final);
                $resultado->bindParam(':mant', $mant);
                $resultado->bindParam(':averia', $averia);
                $resultado->bindParam(':tecnico', $tecnico);
                $resultado->bindParam(':maquina', $maquina);                    
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar una Tarea existente
            } elseif ($accion == "Borrar Tarea") {                
                $sql="DELETE FROM tareas WHERE id=:id";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':id', $id);     
                $resultado->execute();
                $afectado=$resultado->rowCount();

            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }




        /* ----------------------------------------------------------------REPUESTOS EN TAREAS----------------------------------------------------------------------------------- */

         /** 
         * Función para mostrar los repuestos usados en las tareas, recibe como parámetro el id de la tarea que tiene relacionados los repuestos
         *
         * @access public
         * @param int $idTarea
         * @return array $realizado
         */
        public function mostrarRepTarea($idTarea){

            $conexion = $this->accesoDB();
            $sql="SELECT repuestos_en_tarea.referencia_repuesto AS referencia, repuestos_en_tarea.id_tarea AS id, repuestos_en_tarea.cantidad AS cantidad, repuestos.nombre AS nombre
                    FROM repuestos_en_tarea
                    INNER JOIN repuestos ON repuestos_en_tarea.referencia_repuesto = repuestos.referencia
                    WHERE id_tarea = :idTarea";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->bindParam("idTarea", $idTarea);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }



        /**
         * Función para modificar, crear o borrar un Repuesto usado en una tarea, según el parámetro acción recibido
         *
         * @access public
         * @param string $accion 
         * @param string $referencia
         * @param int $idTarea
         * @param int $cantidad
         * @return string $realizado
         */
        public function accionRepTarea($accion, $referencia, $idTarea, $cantidad){
            $realizado = "";
            $afectado=0;
            $conexion = $this->accesoDB();

            //Si la acción es Modificar un Repuesto en Tarea existente
            if ($accion == "Modificar Repuesto en Tarea"){
                $sql="UPDATE repuestos_en_tarea SET referencia_repuesto=:referencia, cantidad=:cantidad WHERE id_tarea=:idTarea";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':idTarea', $idTarea);         
                $resultado->bindParam(':referencia', $referencia);
                $resultado->bindParam(':cantidad', $cantidad); 
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear un nuevo Repuesto en Tarea
            } elseif ($accion == "Nuevo Repuesto en Tarea") {
                $sql="INSERT INTO repuestos_en_tarea (referencia_repuesto, id_tarea, cantidad) VALUES (:referencia, :idTarea, :cantidad)";
                $resultado=$conexion->prepare($sql);           
                $resultado->bindParam(':idTarea', $idTarea);         
                $resultado->bindParam(':referencia', $referencia);
                $resultado->bindParam(':cantidad', $cantidad);                   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar un Repuesto en Tarea existente
            } elseif ($accion == "Borrar Repuesto en Tarea") {                
                $sql="DELETE FROM repuestos_en_tarea WHERE id_tarea=:idTarea";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':idTarea', $idTarea);      
                $resultado->execute();
                $afectado=$resultado->rowCount();

            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }


        /* ----------------------------------------------------------------------MAQUINAS---------------------------------------------------------------------------------------- */

        /** 
         * Función para mostrar maquinas, no recibe parámetros
         *
         * @access public
         * @return array $realizado
         */
        public function mostrarMaquinas(){

            $conexion = $this->accesoDB();
            $sql="SELECT maquinas.id AS id, maquinas.nombre AS nombre, maquinas.marca AS marca, maquinas.modelo AS modelo, maquinas.descripcion AS descripcion, grupos.nombre AS grupo
                        FROM maquinas
                        INNER JOIN grupos ON maquinas.id_grupo = grupos.id";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }



        /** 
         * Función para modificar, crear o borrar una Máquina, según el parámetro acción recibido
         *
         * @access public
         * @param string $accion 
         * @param int $id
         * @param string $nombre
         * @param string $marca
         * @param string $modelo
         * @param int $grupo  
         * @param string $desc
         * @return string $realizado
         */
        public function accionMaquina($accion, $id, $nombre, $marca, $modelo, $grupo, $desc){
            $realizado = "";
            $afectado=0;
            $conexion = $this->accesoDB();

            //Si la acción es Modificar una máquina existente
            if ($accion == "Modificar Máquina"){
                $sql="UPDATE maquinas SET nombre=:nombre, marca=:marca, modelo=:modelo, id_grupo=:grupo, descripcion=:descripcion WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                $resultado->bindParam(':nombre', $nombre);
                $resultado->bindParam(':marca', $marca);
                $resultado->bindParam(':modelo', $modelo);
                $resultado->bindParam(':grupo', $grupo);
                $resultado->bindParam(':descripcion', $desc);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear una nueva máquina
            } elseif ($accion == "Nueva Máquina") {
                $sql="INSERT INTO maquinas (nombre, marca, modelo, descripcion, id_grupo) VALUES (:nombre, :marca, :modelo, :descripcion, :grupo)";
                $resultado=$conexion->prepare($sql);           
                $resultado->bindParam(':nombre', $nombre);
                $resultado->bindParam(':marca', $marca);
                $resultado->bindParam(':modelo', $modelo);
                $resultado->bindParam(':grupo', $grupo);
                $resultado->bindParam(':descripcion', $desc);                    
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar una máquina existente
            } elseif ($accion == "Borrar Máquina") {                
                $sql="DELETE FROM maquinas WHERE id=:id";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':id', $id);     
                $resultado->execute();
                $afectado=$resultado->rowCount();

            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }


        /**
         * Función pública, devuelve un array asociativo que contiene el codigo y nombre de los productos que comiencen con 
         * los caracteres o palabras pasadas como parámetro.
         * 
         * @access public
         * @param string $nombre
         * @return array $registros
         */
        public function buscarNombres($nombre){
            $registros="";
            $nombre1= $nombre . "%";

            $conexion = $this->accesoDB();
               
            $sql="SELECT id, nombre FROM maquinas WHERE nombre LIKE :nombre";
            $resultado = $conexion->prepare($sql);        
            $resultado->execute(array(":nombre"=>$nombre1));

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = array(array("nombre"=>"No hay datos que mostrar"));
            }         
            return $registros; 
        }



        /* ------------------------------------------------------------------GRUPOS DE MAQUINAS-------------------------------------------------------------------------------- */

        /** 
         * Función para mostrar grupos de máquinas, no recibe parámetros, devuelve un array con los grupos
         *
         * @access public
         * @return $registros
         */
        public function mostrarGrupos(){

            $conexion = $this->accesoDB();
            $sql="SELECT * FROM grupos";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }



        /** 
         * Función para modificar, crear o borrar un Grupo de Máquinas, según la acción recibida por el parámetro acción
         *
         * @access public
         * @param string $accion
         * @param int $id
         * @param string $nombre  
         * @return string $realizado
         */ 
        public function accionGrupo($accion, $id, $nombre){
            $realizado = "";
            $conexion = $this->accesoDB();

            //Si la acción es Modificar un Grupo de Máquinas existente
            if($accion=="Modificar Grupo de Máquinas"){
                $sql="UPDATE grupos SET nombre=:nombre WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear un nuevo Grupo de Máquinas
            }elseif($accion=="Nuevo Grupo de Máquinas") {
                $sql="INSERT INTO grupos (nombre) VALUES (:nombre)";
                $resultado=$conexion->prepare($sql);          
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar un Grupo de Máquinas existente
            }elseif($accion=="Borrar Grupo de Máquinas") {                
                $sql="DELETE FROM grupos WHERE id=:id";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':id', $id);     
                $resultado->execute();
                $afectado=$resultado->rowCount();
            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }



        /* -----------------------------------------------------------------------AVERIAS------------------------------------------------------------------------------------------ */

        /** 
         * Función para mostrar los tipos de averías, no recibe parámetros, devuelve un array con todas las averías
         *
         * @access public
         * @return array $registros
         */
        public function mostrarAverias(){

            $conexion = $this->accesoDB();
            $sql="SELECT * FROM tipo_averia";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }


        
        /** 
         * Función para modificar, crear o borrar un Tipo de Averia, según la acción recibida por el parámetro acción
         *
         * @access public
         * @param string $accion
         * @param int $id
         * @param string $nombre  
         * @return string $realizado
         */ 
        public function accionAveria($accion, $id, $nombre){
            $realizado = "";
            $conexion = $this->accesoDB();

            //Si la acción es Modificar un Tipo de Averia existente
            if($accion=="Modificar Tipo de Averia"){
                $sql="UPDATE tipo_averia SET nombre=:nombre WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear un nuevo Tipo de Averia
            }elseif($accion=="Nuevo Tipo de Averia") {
                $sql="INSERT INTO tipo_averia (nombre) VALUES (:nombre)";
                $resultado=$conexion->prepare($sql);          
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar un Tipo de Averia existente
            }elseif($accion=="Borrar Tipo de Averia") {                
                $sql="DELETE FROM tipo_averia WHERE id=:id";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':id', $id);     
                $resultado->execute();
                $afectado=$resultado->rowCount();
            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }
        


        /* ----------------------------------------------------------------TIPOS DE MANTENIMIENTOS-------------------------------------------------------------------------------- */

        /** 
         * Función para mostrar los tipos de mantenimientos, no recibe parámetros, devuelve un array con los datos
         *
         * @access public
         * @return array $registros
         */
        public function mostrarMantenimientos(){

            $conexion = $this->accesoDB();
            $sql="SELECT * FROM tipo_mantenimiento";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }


        /** 
         * Función para modificar, crear o borrar un Tipo de Mantenimiento, según la acción recibida por el parámetro acción
         *
         * @access public
         * @param string $accion 
         * @param int $id
         * @param string $nombre  
         * @return string $realizado
         */ 
        public function accionManteni($accion, $id, $nombre){
            $realizado = "";
            $conexion = $this->accesoDB();

            //Si la acción es Modificar un Tipo de Mantenimiento existente
            if($accion=="Modificar Tipo de Mantenimiento"){
                $sql="UPDATE tipo_mantenimiento SET nombre=:nombre WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear un nuevo Tipo de Mantenimiento
            }elseif($accion=="Nuevo Tipo de Mantenimiento") {
                $sql="INSERT INTO tipo_mantenimiento (nombre) VALUES (:nombre)";
                $resultado=$conexion->prepare($sql);          
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar un Tipo de Mantenimiento existente
            }elseif($accion=="Borrar Tipo de Mantenimiento") {                
                $sql="DELETE FROM tipo_mantenimiento WHERE id=:id";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':id', $id);     
                $resultado->execute();
                $afectado=$resultado->rowCount();
            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }



        /* ---------------------------------------------------------------------REPUESTOS--------------------------------------------------------------------------------------- */
        
        /**
         * Función para mostrar los repuestos, no recibe parámetros, devuelve un array con los datos
         *
         * @access public
         * @return array $registros
         */
        public function mostrarRepuestos(){

            $conexion = $this->accesoDB();
            $sql="SELECT * FROM repuestos";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }



        /** 
         * Función para modificar, crear o borrar un Repuesto, según la acción recibida por el parámetro acción
         *
         * @access public
         * @param string $accion
         * @param int $id_old
         * @param int $id_new
         * @param string $nombre  
         * @param string $desc
         * @return string $realizado
         */
        public function accionRepuesto($accion, $id_old, $id_new, $nombre, $desc){
            $realizado = "";
            $afectado=0;
            $conexion = $this->accesoDB();

            //Si la acción es Modificar un repuesto existente
            if ($accion == "Modificar Repuesto"){
                $sql="UPDATE repuestos SET referencia=:idNew, nombre=:nombre, descripcion=:descripcion WHERE referencia=:idOld";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':idOld', $id_old); 
                $resultado->bindParam(':idNew', $id_new);        
                $resultado->bindParam(':nombre', $nombre);
                $resultado->bindParam(':descripcion', $desc);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear un nuevo repuesto
            } elseif ($accion == "Nuevo Repuesto") {
                $sql="INSERT INTO repuestos (referencia, nombre, descripcion) VALUES (:idNew, :nombre, :descripcion)";
                $resultado=$conexion->prepare($sql);           
                $resultado->bindParam(':idNew', $id_new);        
                $resultado->bindParam(':nombre', $nombre);
                $resultado->bindParam(':descripcion', $desc);                   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar un repuesto existente
            } elseif ($accion == "Borrar Repuesto") {                
                $sql="DELETE FROM repuestos WHERE referencia=:idOld";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':idOld', $id_old);     
                $resultado->execute();
                $afectado=$resultado->rowCount();

            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }



        /* ---------------------------------------------------------------------USUARIOS----------------------------------------------------------------------------------------- */

        /**
         * Función para mostrar los usuarios, no recibe parámetros, devuelve un array con los datos
         *
         * @access public
         * @return array $registros
         */
        public function mostrarUsuarios(){

            $conexion = $this->accesoDB();
            $sql="SELECT usuarios.id AS id, usuarios.nombre AS nombre, usuarios.email AS email, usuarios.password AS password, usuarios.bloqueado AS bloqueado, roles.nombre AS rol
                    FROM usuarios
                    INNER JOIN roles ON usuarios.id_rol = roles.id";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }


        /** 
        * Función para modificar, crear o eliminar un usuario, según la acción recibida por el parámetro acción
         *
         * @access public
         * @param string $accion 
         * @param int $id
         * @param string $nombre  
         * @param int $rol  
         * @param string $email  
         * @param string $bloque  
         * @param int $pass  
         * @return string $realizado
         */
        public function accionUsuario($accion, $id, $nombre, $rol, $email, $bloque, $pass){
            $realizado = "";
            $afectado=0;
            $conexion = $this->accesoDB();

            //Si la acción es Modificar un usuario existente
            if ($accion == "Modificar Usuario"){
                $sql="UPDATE usuarios SET nombre=:nombre, email=:email, bloqueado=:bloqueado, id_rol=:rol WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                $resultado->bindParam(':nombre', $nombre);
                $resultado->bindParam(':email', $email);
                $resultado->bindParam(':rol', $rol);                
                $resultado->bindParam(':bloqueado', $bloque);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear un nuevo usuario
            } elseif ($accion == "Nuevo Usuario") {
                $sql="INSERT INTO usuarios (nombre, email, password, bloqueado, id_rol) VALUES (:nombre, :email, :password, :bloqueado, :id_rol)";
                $resultado=$conexion->prepare($sql);          
                $resultado->bindParam(':nombre', $nombre);
                $resultado->bindParam(':email', $email);
                    //Cifro la contraseña con hash
                    $password=password_hash($pass, PASSWORD_DEFAULT);
                $resultado->bindParam(':password', $password);
                $resultado->bindParam(':bloqueado', $bloque);
                $resultado->bindParam(':id_rol', $rol);                  
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar un usuario existente
            } elseif ($accion == "Borrar Usuario") {                
                $sql="DELETE FROM usuarios WHERE id=:id";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':id', $id);     
                $resultado->execute();
                $afectado=$resultado->rowCount();

            //Si la acción es CAmbiar contraseña de un usuario existente y logueado
            } elseif ($accion == "Cambiar Contrasena") { 
                $sql="UPDATE usuarios SET password=:password WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                    //Cifro la contraseña con hash
                    $password=password_hash($pass, PASSWORD_DEFAULT);
                $resultado->bindParam(':password', $password);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }


        /* -----------------------------------------------------------------------ROLES------------------------------------------------------------------------------------------ */

        /** 
         * Función para mostrar los roles de usuario, no recibe parámetros, devuelve un array con los datos
         *
         * @access public
         * @return array $registros
         */
        public function mostrarRoles(){

            $conexion = $this->accesoDB();
            $sql="SELECT * FROM roles";
                        
            $resultado=$conexion->prepare($sql);
            $resultado->execute();

            if($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                $registros = array($registro); 

                while($tabla=$resultado->fetch(PDO::FETCH_ASSOC)){                    
                    array_push($registros, $tabla);  
                }                   
            } else {
                $registros = "No hay datos registrados que mostrar";
            }         
            return $registros;
        }


        /**
         * Función para crear, modificar o eliminar un Rol, según la acción recibida por el parámetro acción
         *
         * @access public
         * @param string $accion 
         * @param int $id
         * @param string $nombre  
         * @return string $realizado
         */  
        public function accionRol($accion, $id, $nombre){
            $realizado = "";
            $conexion = $this->accesoDB();

            //Si la acción es Modificar un rol existente
            if($accion=="Modificar Rol"){
                $sql="UPDATE roles SET nombre=:nombre WHERE id=:id";
                $resultado=$conexion->prepare($sql);  
                $resultado->bindParam(':id', $id);         
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es crear un nuevo rol
            }elseif($accion=="Nuevo Rol") {
                $sql="INSERT INTO roles (nombre) VALUES (:nombre)";
                $resultado=$conexion->prepare($sql);          
                $resultado->bindParam(':nombre', $nombre);   
                $resultado->execute();   
                $afectado=$resultado->rowCount();

            //Si la acción es borrar un rol existente
            }elseif($accion=="Borrar Rol") {                
                $sql="DELETE FROM roles WHERE id=:id";
                $resultado = $conexion->prepare($sql);     
                $resultado->bindParam(':id', $id);     
                $resultado->execute();
                $afectado=$resultado->rowCount();
            }

            if($afectado!=0){
                $realizado = "si";            
            }else{
                $realizado = "no";
            }
            return $realizado;
        }


    }
?>