<?php 
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Persistencia/Persistencia.php");

    class Logica{
       
        public function loginTransportista($ci,$password){
            $transportistas=Persistencia::pedirTransportistas();
            
            if($transportistas!=null){
                foreach($transportistas as $transportista){
                    if($ci==$transportista->getCedula() && !$transportista->getDesactivada()){
                        if(md5($password)==$transportista->getPin()) {
                            session_start();
                            $_SESSION["cedula"] = $ci;
                            $_SESSION["tipo"] ="t";
                            $_SESSION["transportista"]=Persistencia::buscarTransportista($ci);

                            return true;
                        }
                    }
                }  
            }
            return false;
        }
        public function loginEncargado($ci,$password){
            $encargados=Persistencia::pedirEncargados();
            if($encargados!=null){
                foreach($encargados as $encargado){
                    if($ci==$encargado->getCedula()){
                        if(md5($password)==$encargado->getPin()) {
                            session_start();
                            $_SESSION["cedula"] = $ci;
                            $_SESSION["tipo"] ="e";
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

    }
?>