<?php
    class Persona{  

        private $cedula;
        private $nombres;
        private $apellidos;
        private $pin;
        private $foto;
        private $desactivada;

        public function __construct($cedula,$nombres,$apellidos,$foto,$pin,$desactivada)
        {
            $this->cedula=$cedula;
            $this->nombres=$nombres;
            $this->apellidos=$apellidos;
            $this->pin=$pin;
            $this->foto=$foto;
        }

        public function getCedula(){ 
            return $this->cedula;
        }
        public function setCedula($cedula){
            $this->cedula=$cedula;
        }
        public function getNombres(){ 
            return $this->nombres;
        }
        public function setNombres($nombres){
            $this->nombres=$nombres;
        }
        public function getApellidos(){ 
            return $this->apellidos;
        }
        public function setApellidos($apellidos){
            $this->apellidos=$apellidos;
        }
        public function getPin(){ 
            return $this->pin;
        }
        public function setPin($pin){
            $this->pin=$pin;
        }
        public function getFoto(){ 
            return $this->foto;
        }
        public function setFoto($foto){
            $this->foto=$foto;
        }
        public function getDesactivada(){ 
            return $this->desactivada;
        }
        public function setDesactivada($desactivada){
            $this->desactivada=$desactivada;
        }

    }
    class Transportista extends Persona{
        
        private $direccion;
        private $telefono;
        
        public function __construct($cedula,$nombres,$apellidos,$foto,$pin,$desactivada,$direccion,$telefono) {

            parent::__construct($cedula,$nombres,$apellidos,$foto,$pin,$desactivada);

            $this->direccion=$direccion;
            $this->telefono=$telefono;
        }
        public function getDireccion(){ 
            return $this->direccion;
        }
        public function setDireccion($direccion){
            $this->direccion=$direccion;
        }
        public function getTelefono(){ 
            return $this->telefono;
        }
        public function setTelefono($telefono){
            $this->telefono=$telefono;
        }
         
    }
    class Encargado extends Persona{
        
        private $email;
        
        public function __construct($cedula,$nombres,$apellidos,$foto,$pin,$desactivada,$email) {
            parent::__construct($cedula,$nombres,$apellidos,$foto,$pin,$desactivada);

            $this->email=$email;
        }
        public function getEmail(){ 
            return $this->direccion;
        }
        public function setEmail($email){
            $this->email=$email;
        }   
    }
?>



