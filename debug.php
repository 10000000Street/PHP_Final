<?php 
require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
$gestorLogica=new Logica();

$array=Array (73643802 => "qGx4Yn",
87963526=> "B3J4Eg",
44956533=> "RmYCMw",
07242161=> "HQ6WCE",

79041860=> "BYnVpE",
28853514=> "A8PFWq",
63737420=> "qn6FQ9",
92416532=> "XTczHH"
    );

    foreach($array as $usuario=>$clave){
        $acceso=$gestorLogica->loginTransportista($usuario,$clave);
        var_dump($acceso);
        echo "<br>";
    }


?>