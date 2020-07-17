<?php
    require_once ("../../Logica/Logica.php");
    require_once ("../../Entidades/Paquete.php");
    require_once ("../../Entidades/Persona.php");
    session_start();
    if(isset($_GET["codigo"])){
        $paquete=Logica::pedirPaquete($_GET["codigo"]);
    }
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
            <?php if(isset($_SESSION["transportista"])) echo '
            <ul>
                <li><a href="?logout=1" accesskey="5" title=""><?php echo $_SESSION["transportista"]->getNombres()."  |  ";?>Cerrar Sesion</a></li>
            </ul>';?>
        </div>
    </div>
    
    <div id="page" class="container">
        <div id="header">
            <div id="logo">
                <h1><a >Tracking</a></h1>
            </div>
            <div id="menu">
                <ul>
                        <li><a class="buttonA buttonA1" href="../t_login.php" accesskey="1" title="">Transportista</a></li>
                        <li><a class="buttonA buttonA1" href="../e_login.php" accesskey="2" title="">Encargado</a></li>
                        <li><a class="buttonA buttonSeleccionado" href="../visitante.php" accesskey="3" title="">Visitante</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
            <h2><a style="color:white;">Informacion Del Paquete</a></h2>
            <?php 
                function auxFunction($boolean){
                    if($boolean) return "Si";
                    else return "No"; 
                }
                function auxEstado($estado){
                    if($estado==-1) return "Sin Asignar";
                    if($estado==0) return "Asignado";
                    if($estado==1) return "Entregado";
                }
                function auxNull($dato){
                    if($dato==null) return "No";
                    else return $dato; 
                }
                if($paquete!=null){
                    $estado=$paquete->getEstado();
                    if($estado===0 || $estado===1){
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
                                                        <th class="column4">Fragil</th>
                                                        <th class="column5">Perecedero</th>

                                                        <th class="column6">Fecha de entrega (Estimada)</th>';
                                if($estado===1) echo '<th class="column7">Fecha de entrega</th>';
                                                echo '<th class="column8">Estado</th>
                                                        <th class="column9">Fecha y Hora de Asignacion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="column1">'.$paquete->getCodigo().'</td>
                                                        <td class="column4">'.auxFunction($paquete->getFragil()).'</td>
                                                        <td class="column5">'.auxFunction($paquete->getPerecedero()).'</td>

                                                        <td class="column6">'.auxNull($paquete->getFechaEstimada()).'</td>';
                                if($estado===1) echo '<td class="column7">'.auxNull($paquete->getFechaDeEntrega()).'</td>';
                                                echo '<td class="column8">'.auxEstado($estado).'</td>
                                                        <td class="column9">'.auxNull($paquete->getFechaHoraDeAsignacion()).'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>';
                    }
                    else echo "<br><br>El paquete no fue asignado todavia";
                }
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