<?php
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    session_start();
    if(isset($_GET["logout"])){
        Logica::logOut();
        header("Location: ../bienvenida.php");
        exit;
    }
    $href="bienvenida.php";
    $login_logout="Login";
    if(isset($_SESSION["encargado"]) || isset($_SESSION["transportista"])){
        if(isset($_SESSION["encargado"]))  $persona=$_SESSION["encargado"];
        if(isset($_SESSION["transportista"]))  $persona=$_SESSION["transportista"];
        $login_logout=$persona->getNombres()." ".$persona->getApellidos()."  |  Cerrar Sesion";
        $href="?logout=1";
    }

?>
<html>
<head>
<title></title>
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="0_default.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>

    <div id="header2" class="container2">
        <div id="logo2">
            <h1><a href="bienvenida.php">Paquetitos Punto Com</a></h1>
        </div>
        <div id="menu2">
            <ul>
            <li><a href="<?php echo $href;?>" accesskey="5" title=""><?php echo $login_logout; ?></a></li>
            </ul>
        </div>
    </div>
    
    <div id="page" class="container">
        

        
		    <div id="banner" align="center">
                <br> <br> <br>
                <h1 style="color: white;">Ups! Ha Ocurrido Un Error Lo Sentimos <br><br> Intente Nuevamente</h1>
            </div>
        
    </div>

    <div id="footer">
        <div id="logo3">
            <h2><a>Tade&Fede's Company</a></h2>
        </div>
    </div>

</body>
</html>