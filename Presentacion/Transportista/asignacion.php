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
    if(isset($_POST["asignar"])){
        $paquete=Logica::pedirPaquete($_POST["codigo"]);
        Logica::asignarPaquete($_SESSION["transportista"],$paquete,$_POST["fechaEstimada"]);
    }

    if (isset($_SESSION["transportista"])){
        $transportista=$_SESSION["transportista"];
        $paquetes= Logica::pedirPaquetes(-1);
        $paqueteActivo=Logica::pedirPaqueteActivo($transportista);
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
                <li><a href="?logout=1" accesskey="5" title=""><?php echo $_SESSION["transportista"]->getNombres()."  |  ";?>Cerrar Sesion</a></li>
            </ul>
        </div>
    </div>
    
    <div id="page" class="container">
        <div id="header">
            <div id="logo">
                <h1><a href="inicio.php">Transportista:<?php echo "<br>".$_SESSION["transportista"]->getNombres() ?></a></h1>
                
            </div>
            <div id="menu">
                <ul>
                    <li><a class="buttonA buttonA1" href="inicio.php" accesskey="1" title="">Inicio</a></li>
                    <li><a class="buttonA buttonSeleccionado" href="asignacion.php" accesskey="2" title="">Asignacion de paquetes</a></li>
                    <li><a class="buttonA buttonA1" href="historial.php" accesskey="3" title="">Historial de envios</a></li>
                    <li><a class="buttonA buttonA1" href="?logout=1" accesskey="4" title="">Salir</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
            <h2><a style="color:white;">Asignacion de Paquetes</a></h2>
            <?php 
            if($paquetes!=null){echo '
            <div id="banner">
                <div class="limiter">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <div class="table100">
                                <table>
                                    <thead>
                                        <tr class="table100-head">
                                            <th class="column1">Codigo</th>
                                            <th class="column3">Direccion (Remitente)</th>
                                            <th class="column3">Direccion (Destino)</th>
                                            <th class="column4">Fragil</th>
                                            <th class="column5">Perecedero</th>
                                            <th class="column6">Fecha de entrega (Estimada)</th>                                  
                                            <th class="column9">Asignar</th> 
                                        </tr>
                                    </thead>
                                    <tbody>';
                                         function auxFunction($boolean){
                                            if($boolean) return "Si";
                                            else return "No"; 
                                        }
                                        if($paquetes!=null)
                                            foreach($paquetes as $paquete){
                                                echo '<tr><form method="post" action="asignacion.php">';
                                                echo '<td class="column1">'.$paquete->getCodigo().'</td>';
                                                echo '<td class="column1">'.$paquete->getRemitente().'</td>';
                                                echo '<td class="column1">'.$paquete->getDestinatario().'</td>';
                                                echo '<td class="column1">'.auxFunction($paquete->getFragil()).'</td>';
                                                echo '<td class="column1">'.auxFunction($paquete->getPerecedero()).'</td>';
                                                echo '<td class="column1"><input type="date" name="fechaEstimada" placeholder="Fecha" required></td>';
                                                echo '<input type="hidden" name="codigo" value="'.$paquete->getCodigo().'">';
                                                echo '<td class="column1"><input type="submit" name="asignar" class="buttonLogin buttonLogin2" value="Asignar"';
                                                if($paqueteActivo!=null) echo 'disabled';
                                                echo '></td>';
                                                echo '</form></tr>';
                                            }                     
                                echo '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>';
            }
            else echo "<br><br> No hay paquetes disponibles para ser asignados."
            ?>
        </div>
    </div>
<div id="footer">
    <div id="logo3">
        <h2><a >Tade&Fede's Company</a></h2>
    </div>
</div>

</body>
</html>