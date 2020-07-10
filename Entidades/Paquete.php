<?php 
    class Paquete{

        private $codigo;
        private $remitente;
        private $destinatario;
        private $fragil;
        private $perecedero;
        

        private $ci;
        private $fechaHoraDeAsignacion;
        private $fechaDeEntrega;
        private $estado;
        private $fechaEstimada;

        public function __construct($codigo,$remitente,$destinatario,$fragil,$perecedero
        ,$ci,$fechaHoraDeAsignacion,$fechaDeEntrega,$estado,$fechaEstimada){   
                
            $this->codigo=$codigo;
            $this->remitente=$remitente;
            $this->destinatario=$destinatario;
            $this->fragil=$fragil;
            $this->perecedero=$perecedero;
            
            $this->ci=$ci;
            $this->fechaHoraDeAsignacion=$fechaHoraDeAsignacion;
            $this->fechaDeEntrega=$fechaDeEntrega;
            $this->estado=$estado;
            $this->fechaEstimada=$fechaEstimada;
        }
        public function getCi(){
            return $this->ci;
        }
        public function setCi($ci){
            $this->ci=$ci;
        }
        public function getCodigo(){
            return $this->codigo;
        }
        public function setCodigo($codigo){
            $this->codigo=$codigo;
        }
        public function getRemitente(){
            return $this->remitente;
        }
        public function setRemitente($remitente){
            $this->remitente=$remitente;
        }
        public function getDestinatario(){
            return $this->destinatario;
        }
        public function setDestinatario($destinatario){
            $this->destinatario=$destinatario;
        }
        public function getFragil(){
            return $this->fragil;
        }
        public function setFragil($fragil){
            $this->fragil=$fragil;
        }
        public function getPerecedero(){
            return $this->perecedero;
        }
        public function setPerecedero($perecedero){
            $this->perecedero=$perecedero;
        }
        public function getFechaHoraDeAsignacion(){
            return $this->fechaHoraDeAsignacion;
        }
        public function setFechaHoraDeAsignacion($fechaHoraDeAsignacion){
            $this->fechaHoraDeAsignacion=$fechaHoraDeAsignacion;
        }
        public function getFechaDeEntrega(){
            return $this->fechaDeEntrega;
        }
        public function setFechaDeEntrega($fechaDeEntrega){
            $this->fechaDeEntrega=$fechaDeEntrega;
        }
        public function getEstado(){
            return $this->estado;
        }
        public function setEstado($estado){
            $this->estado=$estado;
        }
        public function getFechaEstimada(){
            return $this->fechaEstimada;
        }
        public function setFechaEstimada($fechaEstimada){
            $this->fechaEstimada=$fechaEstimada;
        }

        
    }
?>