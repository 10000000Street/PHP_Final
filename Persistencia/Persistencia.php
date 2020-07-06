<?php  
    
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");

    class Persistencia {
        private static $ip="localhost";
        private static $port="3306";
        private static $user="root";
        private static $pass="admin";
        private static $db="db_php";

        static function pedirTransportistas(){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){

                    $resultado= mysqli_query($conexion,"select p.*,t.direccion,t.telefono from Transportista t ,Persona p where t.ci=p.ci");
                    // rellenado del array
                    $transportistas=array();
                    while( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        $transportista= new Transportista(
                            $buffer["ci"],
                            $buffer["nombres"],
                            $buffer["apellidos"],
                            $buffer["foto"],
                            $buffer["pin"],
                            $buffer["direccion"],
                            $buffer["telefono"]
                        );
                        $transportistas[]=$transportista;
                    }
                    if(count($transportistas)==0) $transportistas=null; /* para evitar un array vacio */
                    return $transportistas;

                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function pedirEncargados(){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){

                    $resultado= mysqli_query($conexion,"select p.*,e.email from Encargado e ,Persona p where e.ci=p.ci");
                    // rellenado del array
                    $encargados=array();
                    while( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        $encargado= new Encargado(
                            $buffer["ci"],
                            $buffer["nombres"],
                            $buffer["apellidos"],
                            $buffer["foto"],
                            $buffer["pin"],
                            $buffer["email"]
                        );
                        $encargados[]=$encargado;
                    }
                    return $encargados;

                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function buscarTransportista($ci){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,
                        "select p.*,t.direccion,t.telefono 
                        from Transportista t ,Persona p 
                        where t.ci=p.ci and p.ci=?"
                    );
                    mysqli_stmt_bind_param($sentencia,"i",$ci);
                    $sentencia->execute();
                    $resultado = mysqli_stmt_get_result($sentencia);

                    if( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        
                        return new Transportista(
                            $buffer["ci"],
                            $buffer["nombres"],
                            $buffer["apellidos"],
                            $buffer["foto"],
                            $buffer["pin"],
                            $buffer["direccion"],
                            $buffer["telefono"]
                        );
                    }
                    else return null;
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }

        }
        static function buscarEncargado($ci){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,
                        "select p.*,e.email
                        from Encargado e ,Persona p 
                        where e.ci=p.ci and p.ci=?"
                    );
                    mysqli_stmt_bind_param($sentencia,"i",$ci);
                    $sentencia->execute();
                    $resultado = mysqli_stmt_get_result($sentencia);

                    if( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        
                        return new Encargado(
                            $buffer["ci"],
                            $buffer["nombres"],
                            $buffer["apellidos"],
                            $buffer["foto"],
                            $buffer["pin"],
                            $buffer["email"]
                        );
                    }
                    else return null;
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }

        }
        static function pedirPaquete($codigo){
            
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $query="select p.*,a.ci,a.fecha_estimada_entrega,a.fecha_hora_asignacion from Paquete p left outer join  Asignaciones a on (a.codigo=p.codigo) where p.codigo=?";
                    $sentencia=mysqli_prepare($conexion,$query);
                    mysqli_stmt_bind_param($sentencia,"s",$codigo);
                    $sentencia->execute();
                    $resultado = mysqli_stmt_get_result($sentencia);

                    if( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        return new Paquete(
                            $buffer["codigo"],
                            $buffer["direccion_remitente"],
                            $buffer["direccion_envio"],
                            $buffer["fragil"],
                            $buffer["perecedero"], 
                            $buffer["ci"],
                            $buffer["fecha_hora_asignacion"],
                            $buffer["fecha_entrega"],
                            $buffer["estado"],
                            $buffer["fecha_estimada_entrega"]
                        );
                    }
                    else return null;
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function pedirPaquetes(){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){

                    $resultado= mysqli_query($conexion,"select p.*,a.ci,a.fecha_estimada_entrega,a.fecha_hora_asignacion from Paquete p left outer join  Asignaciones a on (a.codigo=p.codigo)");
                    // rellenado del array
                    $paquetes=array();
                    while( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        $paquete= new Paquete(
                            $buffer["codigo"],
                            $buffer["direccion_remitente"],
                            $buffer["direccion_envio"],
                            $buffer["fragil"],
                            $buffer["perecedero"], 
                            $buffer["ci"],
                            $buffer["fecha_hora_asignacion"],
                            $buffer["fecha_entrega"],
                            $buffer["estado"],
                            $buffer["fecha_estimada_entrega"]
                        );
                        $paquetes[]=$paquete;
                    }
                    if(count($paquetes)==0) $paquetes=null; /* para evitar un array vacio */
                    return $paquetes;
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }  
        static function pedirPaquetesSinAsignar(){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){

                    $resultado= mysqli_query($conexion,"select * from paquete where estado=-1");
                    // rellenado del array
                    $paquetes=array();
                    while( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        $paquete= new Paquete(
                            $buffer["codigo"],
                            $buffer["direccion_remitente"],
                            $buffer["direccion_envio"],
                            $buffer["fragil"],
                            $buffer["perecedero"], 
                            null,
                            null,
                            $buffer["fecha_entrega"],
                            $buffer["estado"],
                            null
                        );
                        $paquetes[]=$paquete;
                    }
                    if(count($paquetes)==0) $paquetes=null; /* para evitar un array vacio */
                    return $paquetes;
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function paqueteActivo($transportista){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $query="select p.*,a.ci,a.fecha_estimada_entrega,a.fecha_hora_asignacion 
                            from Asignaciones a, Paquete p 
                            where a.codigo=p.codigo and ci=? and p.estado=0";
                    $sentencia=mysqli_prepare($conexion,$query);
                    mysqli_stmt_bind_param($sentencia,"i",$transportista->getCedula());

                    $sentencia->execute();
                    $resultado = mysqli_stmt_get_result($sentencia);

                    $paquete=null;
                    if( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        $paquete= new Paquete(
                            $buffer["codigo"],
                            $buffer["direccion_remitente"],
                            $buffer["direccion_envio"],
                            $buffer["fragil"],
                            $buffer["perecedero"], 
                            $buffer["ci"],
                            $buffer["fecha_hora_asignacion"],
                            $buffer["fecha_entrega"],
                            $buffer["estado"],
                            $buffer["fecha_estimada_entrega"]
                        );
                    }
                    return $paquete;
                }
                else return null;
                }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }

        }
        static function asignarPaquete($transportista,$paquete,$fechaEstimada){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,"call db_php.asignarPaquete(?,?,?,@resultado)");
                    mysqli_stmt_bind_param($sentencia,"iss",$transportista->getCedula(),$paquete->getCodigo(),$fechaEstimada);

                    $sentencia->execute();
                    $resultado= mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_row($resultado)[0];       
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function finalizarEntrega($transportista){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,"call db_php.finalizarEnvio(?,@resultado)");
                    mysqli_stmt_bind_param($sentencia,"i",$transportista->getCedula());
                    $sentencia->execute();
                    $resultado= mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_row($resultado)[0];       
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }  
        static function pedirPaquetesEntregados($transportista){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){

                    $sentencia= mysqli_prepare($conexion,"select p.*,a.ci,a.fecha_estimada_entrega,a.fecha_hora_asignacion from Paquete p left outer join  Asignaciones a on (a.codigo=p.codigo) where p.estado=1 and a.ci=?");
                    mysqli_stmt_bind_param($sentencia,"i",$transportista->getCedula());
                    $sentencia->execute();
                    $resultado=mysqli_stmt_get_result($sentencia);

                    // rellenado del array
                    $paquetes=array();
                    while( ($buffer=mysqli_fetch_array($resultado,MYSQLI_ASSOC)) !=false ){
                        $paquete= new Paquete(
                            $buffer["codigo"],
                            $buffer["direccion_remitente"],
                            $buffer["direccion_envio"],
                            $buffer["fragil"],
                            $buffer["perecedero"], 
                            $buffer["ci"],
                            $buffer["fecha_hora_asignacion"],
                            $buffer["fecha_entrega"],
                            $buffer["estado"],
                            $buffer["fecha_estimada_entrega"]
                        );
                        $paquetes[]=$paquete;
                    }
                    if(count($paquetes)==0) $paquetes=null; /* para evitar un array vacio */
                    return $paquetes;
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function Molde(){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){

                    
                }
                else return null;
            }
            catch(Exception $e){
                echo $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
    }
?>
