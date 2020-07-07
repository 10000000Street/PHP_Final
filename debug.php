<?php  
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Persistencia/Persistencia.php");

    function paqueteNuevo($codigo,$remitente,$detinatario,$fragil,$perecedero){
        return new Paquete($codigo,$remitente,$detinatario,$fragil,$perecedero,null,null,null,-1,null);
    }
    $paquete = paqueteNuevo(null,"remitente","destinatario",true,false);

    echo Persistencia::modificarPaquete('RT907538385HK',$paquete);







?>