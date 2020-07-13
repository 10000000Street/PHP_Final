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
    if (isset($_SESSION["encargado"])){
        $paquetesActivos=Logica::pedirPaquetes(0);
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
                    <li><a class="buttonA buttonSeleccionado" href="inicio.php" accesskey="1" title="">Inicio</a></li>
                    <li><a class="buttonA buttonA1" href="paquetes.php" accesskey="2" title="">Administracion de Paquetes</a></li>
                    <li><a class="buttonA buttonA1" href="transportistas.php" accesskey="3" title="">Administracion de Transportistas</a></li>
                    <li><a class="buttonA buttonA1" href="historial.php" accesskey="3" title="">Historial de envios</a></li>
                    <li><a class="buttonA buttonA1" href="?logout=1" accesskey="4" title="">Salir</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
            <h2><a style="color:white;">Paquetes Activos</a></h2>
		    <div id="banner">
                <div class="limiter">
                    <?php 
                    if($paquetesActivos!==null){
                        echo '
                            <div class="container-table100">
                                <div class="wrap-table100">
                                    <div class="table100">
                                        <table>
                                            <thead>
                                                <tr class="table100-head">
                                                    <th class="column1">Codigo del Paquete</th>
                                                    <th class="column3">Nombre Transportista</th>
                                                    <th class="column4">C.I. Transportista</th>
                                                    <th class="column5">Fecha y Hora de Asignacion</th>
                                                </tr>
                                            </thead>
                                            <tbody>'; 
                                                foreach ($paquetesActivos as $paquete){
                                                    $transportista=Logica::buscarTransportista($paquete->getCi());
                                                    echo '
                                                <tr>
                                                    <td class="column1">'.$paquete->getCodigo().'</td>
                                                    <td class="column2">'.$transportista->getNombres().' '.$transportista->getApellidos().'</td>
                                                    <td class="column3">'.$paquete->getCi().'</td>
                                                    <td class="column4">'.$paquete->getFechaHoraDeAsignacion().'</td>
                                                </tr>';
                                                }
                                            echo '</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>';
                    }
                    else echo "<br> No hay paquetes activos en este momento.";
                    ?>
                </div>  
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