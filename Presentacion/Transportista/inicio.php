<?php
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    session_start();
    
    if(isset($_GET["logout"])){
        Logica::logOut();
        header("Location: ../bienvenida.php");
    }
    if(!Logica::refreshTimeOut()) Logica::logOut();

    if (isset($_SESSION["transportista"])){
        $paquete= Logica::pedirPaqueteActivo($_SESSION["transportista"]);

        if(isset($_POST["entrega"]) && $paquete!= null) 
        $resultado=Logica::finalizarEnvio($_SESSION["transportista"]);
        $paquete= Logica::pedirPaqueteActivo($_SESSION["transportista"]);
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
            <h1><a href="../bienvenida.php">Paquetitos Punto Com</a></h1>
        </div>
        <div id="menu2">
            <ul>
                <li><a href="?logout=1" accesskey="5" title=""><?php echo $_SESSION["transportista"]->getNombres()." ".$_SESSION["transportista"]->getApellidos()."  |  ";?>Cerrar Sesion</a></li>
            </ul>
        </div>
    </div>
    
    <div id="page" class="container">
        <div id="header">
            <div id="logo">
                <h1><a href="inicio.php">Transportista:<?php echo "<br>".$_SESSION["transportista"]->getNombres()." ".$_SESSION["transportista"]->getApellidos() ?></a></h1>
                
            </div>
            <div id="menu">
                <ul>
                    <li><a class="buttonA buttonSeleccionado" href="inicio.php" accesskey="1" title="">Inicio</a></li>
                    <li><a class="buttonA buttonA1" href="asignacion.php" accesskey="2" title="">Asignacion de paquetes</a></li>
                    <li><a class="buttonA buttonA1" href="historial.php" accesskey="3" title="">Historial de envios</a></li>
                    <li><a class="buttonA buttonA1" href="?logout=1" accesskey="4" title="">Salir</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
            <h2><a style="color:white;">Informacion Del Paquete Asignado</a></h2>
            <?php 
                function auxFunction($boolean){
                    if($boolean) return "Si";
                    else return "No"; 
                }
                if($paquete!=null){
                    echo '
                    <div id="banner">
                        <div class="limiter">
                            <div class="container-table100">
                                <div class="wrap-table100">
                                    <div class="table100">
                                        <table>
                                            <thead>
                                                <tr class="table100-head">
                                                    <th class="column1">Codigo</th>
                                                    <th class="column2">Direccion (Remitente)</th>
                                                    <th class="column3">Direccion (envio)</th>
                                                    <th class="column4">Fragil</th>
                                                    <th class="column5">Perecedero</th>
                                                    <th class="column6">Fecha de entrega (Estimada)</th>
                                                    <th class="column9">Fecha y Hora de Asignacion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="column1">'.$paquete->getCodigo().'</td>
                                                    <td class="column2">'.$paquete->getRemitente().'</td>
                                                    <td class="column3">'.$paquete->getDestinatario().'</td>
                                                    <td class="column4">'.auxFunction($paquete->getFragil()).'</td>
                                                    <td class="column5">'.auxFunction($paquete->getPerecedero()).'</td>
                                                    <td class="column6">'.$paquete->getFechaEstimada().'</td>
                                                    <td class="column6">'.$paquete->getFechaHoraDeAsignacion().'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <form method="post" action="inicio.php">
                        <input class="buttonLogin buttonLogin1" type="submit" name="entrega" value="Marcar Entrega">
                        </form>
                    </div>';
                }
                else echo "<br><br> No hay un paquete asignado aun.";
            ?>
        </div>
    </div>
<div id="footer">
    <div id="logo3">
        <h2><a>Tade&Fede's Company</a></h2>
    </div>
</div>

</body>
</html>