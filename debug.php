<?php  
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Persistencia/Persistencia.php");

    function paqueteNuevo($codigo,$remitente,$detinatario,$fragil,$perecedero){
        return new Paquete($codigo,$remitente,$detinatario,$fragil,$perecedero,null,null,null,-1,null);
    }
    $paquete = paqueteNuevo(4521741,"remitente","destinatario",true,false);
    $paquete2=clone $paquete;

    var_dump($paquete,$paquete2);







?>