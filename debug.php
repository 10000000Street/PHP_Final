<?php  
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Persistencia/Persistencia.php");
 
    $ricardo= new Transportista(13787574,'Ricardo','Mendez Ductruel','N/A','asdasdasdggf',false,'Nueva Troya 3619',22159412);
    $resultado=Persistencia::agregarTransportista($ricardo);
    echo "AgregarTransportista:".$resultado."<br>";

    $ricardo= new Transportista(13787574,'Ricardo','Mendez','N/A','1234',false,'Nueva Troya 3619',22159412);

    //echo "ModificarTransportista:".Persistencia::modificarTransportista($ricardo,123456789);

    echo "Desactivar:".Persistencia::desactivarTransportista(13787574)."<br>";
    echo "Activar:".Persistencia::reactivarTransportista(13787574);






?>