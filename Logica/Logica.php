<?php 
    require_once (__DIR__."/../Entidades/Paquete.php");
    require_once (__DIR__."/../Entidades/Persona.php");
    require_once (__DIR__."/../Persistencia/Persistencia.php");

    function trickyOnlyForXamppServer(){
        $arrayDirectorio=explode('\\',__DIR__);
        $indiceHTDOCS=0;
        $ruta="";
        for($i=0;$i<count($arrayDirectorio);$i++){
            if($arrayDirectorio[$i]==="htdocs") {
                $indiceHTDOCS=++$i;
                break;
            }
        }
        for($i=$indiceHTDOCS;$i<count($arrayDirectorio);$i++){
            $ruta=$ruta."/".$arrayDirectorio[$i];
        }
        return $ruta;
    }
    function redireccion(){
        header("Location: ".trickyOnlyForXamppServer()."/../Presentacion/error.php");
        exit;
    }

    class Logica{
        private static $tiempoLogout=3600;
       
        public static function loginTransportista($ci,$password){
            try{
                $transportistas=Persistencia::pedirTransportistas();
                if($transportistas!=null){
                    foreach($transportistas as $transportista){
                        if($ci==$transportista->getCedula() && !$transportista->getDesactivada()){
                            if(md5($password)==$transportista->getPin()) {
                                session_start();
                                $_SESSION["timeout"] = time()+self::$tiempoLogout;
                                $_SESSION["transportista"]=Persistencia::buscarTransportista($ci);

                                return true;
                            }
                        }
                    }  
                }
                return false;
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function loginEncargado($ci,$password){
            try{
                $encargados=Persistencia::pedirEncargados();
                if($encargados!=null){
                    foreach($encargados as $encargado){
                        if($ci==$encargado->getCedula()){
                            if(md5($password)==$encargado->getPin()) {
                                session_start();
                                $_SESSION["timeout"] = time()+self::$tiempoLogout;
                                $_SESSION["encargado"]=Persistencia::buscarEncargado($ci);
                                
                                return true;
                            }
                        }
                    }  
                }
                return false;
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function logOut(){
            if(session_status() != PHP_SESSION_ACTIVE)session_start(); 
            session_unset(); 
            session_destroy();
        }
        public static function refreshTimeOut(){
            $refrescar=false;
            if(isset($_SESSION["timeout"])){
                if($_SESSION["timeout"]>time()){
                    $_SESSION["timeout"] = time()+self::$tiempoLogout;
                    $refrescar= true;
                }
            }
            return $refrescar;
        }
        public static function finalizarEnvio($transportista){
            try{
                return Persistencia::finalizarEntrega($transportista);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function pedirPaqueteActivo($tranportista){ 
            try{
                return Persistencia::paqueteActivo($tranportista);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function pedirPaquetes($estado){
            try{
                return Persistencia::pedirPaquetes($estado);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function asignarPaquete($tranportista,$paquete,$fechaEstimada){
            try{
                return Persistencia::asignarPaquete($tranportista,$paquete,$fechaEstimada);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function pedirPaquete($codigo){
            try{
                return Persistencia::pedirPaquete($codigo);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function pedirPaquetesEntregados($transportista){
            try{
                return Persistencia::pedirPaquetesEntregados($transportista);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function pedirTransportistas(){
            try{
                return Persistencia::pedirTransportistas();
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function buscarTransportista($ci){
            try{
                return Persistencia::buscarTransportista($ci);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function agregarPaquete($paquete){
            try{
                return Persistencia::agregarPaquete($paquete);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function eliminarPaquete($codigo){
            try{
                return Persistencia::eliminarPaquete($codigo);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function modificarPaquete($codigo,$paquete){
            try{
                $paqueteOriginal=Persistencia::pedirPaquete($codigo);

                if($paqueteOriginal->getCodigo()===$paquete->getCodigo()) $paquete->setCodigo(null);
                if($paqueteOriginal->getRemitente()===$paquete->getRemitente()) $paquete->setRemitente(null);
                if($paqueteOriginal->getDestinatario()===$paquete->getDestinatario()) $paquete->setDestinatario(null);
                if($paqueteOriginal->getFragil()===$paquete->getFragil()) $paquete->setFragil(null);
                if($paqueteOriginal->getPerecedero()===$paquete->getPerecedero()) $paquete->setPerecedero(null);
        
                return Persistencia::modificarPaquete($codigo, $paquete);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        // transportistas
        public static function agregarTransportista($tranportista){
            try{
                return Persistencia::agregarTransportista($tranportista);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function modificarTransportista($cedula,$tranportista){
            try{
                $transportistaDB=Persistencia::buscarTransportista($cedula);
            
                if($tranportista->getCedula()===$cedula || empty($tranportista->getCedula()))                            
                    $tranportista->setCedula(null);
                if($tranportista->getNombres()===$transportistaDB->getNombres() || empty($tranportista->getNombres()))    
                    $tranportista->setNombres(null);
                if($tranportista->getApellidos()===$transportistaDB->getApellidos() || empty($tranportista->getApellidos()))
                    $tranportista->setApellidos(null);

                if(empty($tranportista->getFoto()["tmp_name"]))                     
                    $tranportista->setFoto(null);

                if(empty($tranportista->getPin()))                                  
                    $tranportista->setPin(null);
                if($transportistaDB->getDireccion()===$tranportista->getDireccion() || empty($tranportista->getDireccion()))
                    $tranportista->setDireccion(null);
                if($tranportista->getTelefono()===$transportistaDB->getTelefono() || empty($tranportista->getTelefono()))  
                    $tranportista->setTelefono(null);

                return Persistencia::modificarTransportista($cedula,$tranportista);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function desactivarTransportista($cedula){
            try{
                return Persistencia::desactivarTransportista($cedula);
            }
            catch(Exception $e){
                redireccion();
            }
        }
        public static function reactivarTransportista($cedula){
            try{
                return Persistencia::reactivarTransportista($cedula);
            }
            catch(Exception $e){
                redireccion();
            }
        }

    }
?>