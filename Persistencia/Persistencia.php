<?php  
    
    require_once (__DIR__."/../Entidades/Paquete.php");
    require_once (__DIR__."/../Entidades/Persona.php");

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
                            $buffer["desactivada"],
                            $buffer["direccion"],
                            $buffer["telefono"]
                        );
                        $transportistas[]=$transportista;
                    }
                    if(count($transportistas)==0) $transportistas=null; /* para evitar un array vacio */
                    return $transportistas;

                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
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
                            $buffer["desactivada"],
                            $buffer["email"]
                        );
                        $encargados[]=$encargado;
                    }
                    return $encargados;

                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
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
                            $buffer["desactivada"],
                            $buffer["direccion"],
                            $buffer["telefono"]
                        );
                    }
                    else return null;
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
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
                            $buffer["desactivada"],
                            $buffer["email"]
                        );
                    }
                    else return null;
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
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
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function pedirPaquetes($estado){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $adosar="";
                    if($estado!==null) $adosar=" where estado=".$estado." ";

                    $query="select p.*,a.ci,a.fecha_estimada_entrega,a.fecha_hora_asignacion 
                    from Paquete p 
                    left outer join  Asignaciones a on (a.codigo=p.codigo)".
                    $adosar.
                    " order by p.estado";

                    $resultado= mysqli_query($conexion,$query);
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
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
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
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
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
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        //transportistas
        static function agregarTransportista($transportista){
            $foto=$transportista->getFoto();
            $nombreFoto=$transportista->getCedula()."n0.jpg";
            try{
                move_uploaded_file(
                    $foto["tmp_name"],
                    __DIR__."/imagenes/".$nombreFoto
                );

                try{
                    $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                    if($conexion){
                        $query="call ".self::$db.".agregarTransportista(?,?,?,?,?,?,?,@resultado)";
                        $sentencia=mysqli_prepare($conexion,$query);
                        mysqli_stmt_bind_param($sentencia,"isssssi",
                            $transportista->getCedula(),
                            $transportista->getNombres(),
                            $transportista->getApellidos(),
                            $nombreFoto,
                            md5($transportista->getPin()),
                            $transportista->getDireccion(),
                            $transportista->getTelefono()
                        );
                        $sentencia->execute();
    
                        $resultado=mysqli_query($conexion,"select @resultado");
                        
                        return mysqli_fetch_array($resultado,MYSQLI_NUM)[0];
                    }
                    else throw new Exception();
            }
                catch(Exception $e){
                    throw $e;
                }
                finally {
                    mysqli_close($conexion);
                }
            }
            catch(Exception $e){
                if (file_exists(__DIR__."/imagenes/".$nombreFoto))
                    unlink(__DIR__."/imagenes/".$nombreFoto);
            }
            
        }
        static function modificarTransportista($cedula,$transportista){
            function siguienteFoto($foto){
                if($foto!==null){
                    $jpg=explode(".",$foto); //traigo el cedulaN0.jpg
                    $ci_num=explode("n",$jpg[0]);
                    return $ci_num[0]."n".++$ci_num[1].".jpg";
                }
                else return null;
            }
            try{
                $foto=$transportista->getFoto();
                $nombreFoto=self::buscarTransportista($cedula)->getFoto();
                move_uploaded_file(
                    $foto["tmp_name"],
                    __DIR__."/imagenes/".siguienteFoto($nombreFoto)
                );

                try{
                    $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                    if($conexion){
                        $query="call ".self::$db.".modificarTransportista(?,?,?,?,?,?,?,?,@resultado)";
                        $sentencia=mysqli_prepare($conexion,$query);
                        
                        mysqli_stmt_bind_param($sentencia,"iisssssi",
                            $cedula,
                            $transportista->getCedula(),
                            $transportista->getNombres(),
                            $transportista->getApellidos(),
                            siguienteFoto($nombreFoto),
                            md5($transportista->getPin()),
                            $transportista->getDireccion(),
                            $transportista->getTelefono()
                        );
                        $sentencia->execute();
    
                        $resultado=mysqli_query($conexion,"select @resultado");
                        $error=mysqli_fetch_array($resultado,MYSQLI_NUM)[0];
    
                        return $error;
                    }
                    else throw new Exception();
                }
                catch(Exception $e){
                    throw $e;
                }
                finally {
                    mysqli_close($conexion);
                }
            }
            catch(Exception $e){
                if (file_exists(__DIR__."/imagenes/".$nombreFoto))
                    unlink(__DIR__."/imagenes/".$nombreFoto);
            }
        }
        static function desactivarTransportista($cedula){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $query="call ".self::$db.".desactivarTransportista(?,@resultado)";
                    $sentencia=mysqli_prepare($conexion,$query);
                    mysqli_stmt_bind_param($sentencia,"i",$cedula); 
                    $sentencia->execute();
                    
                    $resultado=mysqli_query($conexion,"select @resultado");
                    
                    return mysqli_fetch_array($resultado,MYSQLI_NUM)[0];
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function reactivarTransportista($cedula){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $query="call ".self::$db.".reactivarTransportista(?,@resultado)";
                    $sentencia=mysqli_prepare($conexion,$query);
                    mysqli_stmt_bind_param($sentencia,"i",$cedula); 
                    $sentencia->execute();
                    
                    $resultado=mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_array($resultado,MYSQLI_NUM)[0];
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        //paquetes
        static function agregarPaquete($paquete){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,"call ".self::$db.".agregarPaquete(?,?,?,?,?,@resultado)");
                    mysqli_stmt_bind_param($sentencia,"sssii",
                        $paquete->getCodigo(),
                        $paquete->getRemitente(),
                        $paquete->getDestinatario(),
                        $paquete->getFragil(),
                        $paquete->getPerecedero()
                    );
                    $sentencia->execute();
                    $resultado=mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_array($resultado,MYSQLI_NUM)[0];
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function eliminarPaquete($codigo){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,"call ".self::$db.".eliminarPaquete(?,@resultado)");
                    mysqli_stmt_bind_param($sentencia,"s",$codigo);
                    $sentencia->execute();
                    $resultado=mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_array($resultado,MYSQLI_NUM)[0];
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function modificarPaquete($codigo,$paquete){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,"call ".self::$db.".modificarPaquete(?,?,?,?,?,?,@resultado)");
                    mysqli_stmt_bind_param($sentencia,"ssssii",
                        $codigo,
                        $paquete->getCodigo(),
                        $paquete->getRemitente(),
                        $paquete->getDestinatario(),
                        $paquete->getFragil(),
                        $paquete->getPerecedero()
                    );
                    $sentencia->execute();
                    $resultado=mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_array($resultado,MYSQLI_NUM)[0];
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function asignarPaquete($transportista,$paquete,$fechaEstimada){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,"call ".self::$db.".asignarPaquete(?,?,?,@resultado)");
                    mysqli_stmt_bind_param($sentencia,"iss",$transportista->getCedula(),$paquete->getCodigo(),$fechaEstimada);

                    $sentencia->execute();
                    $resultado= mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_row($resultado)[0];       
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
        static function finalizarEntrega($transportista){
            try{
                $conexion = mysqli_connect(self::$ip,self::$user,self::$pass,self::$db,self::$port);
                if($conexion){
                    $sentencia=mysqli_prepare($conexion,"call ".self::$db.".finalizarEnvio(?,@resultado)");
                    mysqli_stmt_bind_param($sentencia,"i",$transportista->getCedula());
                    $sentencia->execute();
                    $resultado= mysqli_query($conexion,"select @resultado");

                    return mysqli_fetch_row($resultado)[0];       
                }
                else throw new Exception();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                mysqli_close($conexion);
            }
        }
    }
?>
