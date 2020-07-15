<?php
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    session_start();
    if(isset($_GET["logout"]) || !Logica::refreshTimeOut()){
        Logica::logOut();
        header("Location: ../bienvenida.php");
        exit;
    }
    define("PAQUETEEXISTE","No se pudo ingresar el paquete, el paquete ya existe");
    $error="";
    if (isset($_SESSION["encargado"])){
        if(isset($_POST["agregarPaquete"])){
            $paquete=new Paquete(
                $_POST["codigo"],
                $_POST["origen"],
                $_POST["destino"],
                isset($_POST["fragil"]),
                isset($_POST["perecedero"]),
                null,null,null,-1,null
            );
            $resultado=Logica::agregarPaquete($paquete);
            if($resultado==0) {
                header("Location: paquetes.php");
                exit;
            }
            else {
                if($resultado==-2)$error=PAQUETEEXISTE;
                else ;//header a pagina de error
            }
        }
    }
    else header("Location: ../bienvenida.php");
    

?>

<html>
<head>
<title></title>
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="../0_default.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>

    <div id="header2" class="container2">
        <div id="logo2">
            <h1><a href="#">Paquetitos Punto Com</a></h1>
        </div>
        <div id="menu2">
            <ul>
            <li><a href="?logout=1" accesskey="5" title=""><?php echo $_SESSION["encargado"]->getNombres()." ".$_SESSION["encargado"]->getApellidos()."  |  ";?>Cerrar Sesion</a></li>
            </ul>
        </div>
    </div>
    
    <div id="page" class="container">
        <div id="header">
            <div id="logo">
            <h1><a href="inicio.php">Encargado:<?php echo "<br>".$_SESSION["encargado"]->getNombres()." ".$_SESSION["encargado"]->getApellidos() ?></a></h1>
                
            </div>
            <div id="menu">
                <ul>
                <li><a class="buttonA buttonA1" href="inicio.php" accesskey="1" title="">Inicio</a></li>
                    <li><a class="buttonA buttonSeleccionado" href="paquetes.php" accesskey="2" title="">Listado-Alta-Baja-Modificacion de paquetes</a></li>
                    <li><a class="buttonA buttonA1" href="transportistas.php" accesskey="3" title="">Listado-Alta-Baja-Modificacion de Transportista</a></li>
                    <li><a class="buttonA buttonA1" href="historial.php" accesskey="3" title="">Historial de envios</a></li>
                    <li><a class="buttonA buttonA1" href="?logout=1" accesskey="4" title="">Salir</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
            <h2><a style="color:white;">Agregar Paquete</a></h2>
		    <div id="banner">
                <form method="post" action="agregarpaquete.php">    
                    <div class="limiter">
                        <div class="container-table100">
                            <div class="wrap-table100">
                                <div class="table100">
                                    <table>
                                        <thead>
                                            <tr class="table100-head">
                                                <th class="column1">Codigo del Paquete</th>
                                                <th class="column5">Direccion Remitente</th> 
                                                <th class="column5">Direccion Destino</th> 
                                                <th class="column4">Fragil</th>
                                                <th class="column5">Perecedero</th>       
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="column1"><input type="text" name="codigo" maxlength="13" minlength="11" style="height: 35px; width: 9em; font-size: 20px;" required></td>
                                                <td class="column6"><input type="text" name="origen" maxlength="100" minlength="1" style="height: 35px; width: 10em; font-size: 20px;" required></td>
                                                <td class="column6"><input type="text" name="destino" maxlength="100" minlength="1" style="height: 35px; width: 10em; font-size: 20px;" required></td>
                                                <td class="column4"><input type="checkbox" name="fragil" ></td>
                                                <td class="column5"><input type="checkbox" name="perecedero" ></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>  
                            </div>
                        </div>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <a href="paquetes.php" class="buttonLogin buttonLogin1" style="width:186px;">
                        Cancelar
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type="submit" name="agregarPaquete" value="Agregar" class="buttonLogin buttonLogin1" style="width:250px;">
                    <br><br>
                    <?php echo $error;?>
                </form>
            </div>
        </div>
    </div>
<div id="footer">
    <div id="logo3">
        <h2><a>Tade&Fede's Company</a></h2>
    </div>
</div>

</body>
</html>