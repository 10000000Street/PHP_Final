<?php  
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Persistencia/Persistencia.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");

    echo time()."<br>";
    Logica::loginEncargado(87963526,"B3J4Eg");
    echo $_SESSION["timeout"]."segundo inicial<br>";
   //sleep(5);
    Logica::refreshTimeOut();
    echo $_SESSION["timeout"]."segundo final<br>";
?>