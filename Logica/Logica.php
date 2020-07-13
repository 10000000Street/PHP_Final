<?php 
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Persistencia/Persistencia.php");

    class Logica{
        private static $tiempoLogout=3600;
       
        public static function loginTransportista($ci,$password){
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
        public static function loginEncargado($ci,$password){
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
        public static function logOut(){
            session_start(); 
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
            return Persistencia::finalizarEntrega($transportista);
        }
        public static function pedirPaqueteActivo($tranportista){
            return Persistencia::paqueteActivo($tranportista);
        }
        public static function pedirPaquetes($estado){
            return Persistencia::pedirPaquetes($estado);
        }
        public static function asignarPaquete($tranportista,$paquete,$fechaEstimada){
            return Persistencia::asignarPaquete($tranportista,$paquete,$fechaEstimada);
        }
        public static function pedirPaquete($codigo){
            return Persistencia::pedirPaquete($codigo);
        }
        public static function pedirPaquetesEntregados($transportista){
            return Persistencia::pedirPaquetesEntregados($transportista);
        }
        public static function pedirTransportistas(){
            return Persistencia::pedirTransportistas();
        }
        public static function buscarTransportista($ci){
            return Persistencia::buscarTransportista($ci);
        }
        public static function agregarPaquete($paquete){
            return Persistencia::agregarPaquete($paquete);
        }
        public static function eliminarPaquete($codigo){
            return Persistencia::eliminarPaquete($codigo);
        }
        public static function modificarPaquete($codigo,$paquete){
            $paqueteOriginal=Persistencia::pedirPaquete($codigo);
            $paqueteMod=clone $paquete;

            if($paqueteOriginal->getCodigo()===$paquete->getCodigo()) $paqueteMod->setCodigo(null);
            if($paqueteOriginal->getRemitente()===$paquete->getRemitente()) $paqueteMod->setRemitente(null);
            if($paqueteOriginal->getDestinatario()===$paquete->getDestinatario()) $paqueteMod->setDestinatario(null);
            if($paqueteOriginal->getFragil()===$paquete->getFragil()) $paqueteMod->setFragil(null);
            if($paqueteOriginal->getPerecedero()===$paquete->getPerecedero()) $paqueteMod->setPerecedero(null);
    
            return Persistencia::modificarPaquete($codigo, $paqueteMod);
        }
        // transportistas
        public static function agregarTransportista($tranportista){
            return Persistencia::agregarTransportista($tranportista);
        }
        public static function modificarTransportista($cedula,$tranportista){
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
        public static function desactivarTransportista($cedula){
            return Persistencia::desactivarTransportista($cedula);
        }
        public static function reactivarTransportista($cedula){
            return Persistencia::reactivarTransportista($cedula);
        }

    }
?>