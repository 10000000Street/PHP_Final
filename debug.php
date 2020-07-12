<?php  
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Persistencia/Persistencia.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
/*
    function paqueteNuevo($codigo,$remitente,$detinatario,$fragil,$perecedero){
        return new Paquete($codigo,$remitente,$detinatario,$fragil,$perecedero,null,null,null,-1,null);
    }
    $paquete = paqueteNuevo(4521741,"remitente","destinatario",true,false);
    $paquete2=clone $paquete;

    var_dump($paquete,$paquete2);*/
/*
    function siguienteFoto($foto){
        $ci_num=explode("n",$foto);
        return $ci_num[0]."n".++$ci_num[1];
    }
    $foto="4848843n0";
    echo siguienteFoto($foto);
*/
    var_dump($resultado=Logica::desactivarTransportista(28853514));
?>