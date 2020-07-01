<?php

    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    session_start();
    if(isset($_GET["logout"])){
        Logica::logOut();
        header("Location: ../bienvenida.php");
    }

   if (isset($_SESSION["encargado"])){
        $paquete= Logica::pedirPaquetesActivos($_SESSION["encargado"]);
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
                <li><a href="?logout=1" title=""><?php echo $_SESSION["encargado"]->getNombres()."  |  ";?>Cerrar Sesion</a></li>
            </ul>
        </div>
    </div>
    
    <div id="page" class="container">
        <div id="header">
            <div id="logo">
                <h1><a href="#">Encargado: <?php echo $_SESSION["encargado"]->getNombres();?></a></h1>
                
            </div>
            <div id="menu">
                <ul>
                    <li><a class="buttonA buttonSeleccionado" href="inicio.php" accesskey="1" title="">Inicio</a></li>
                    <li><a class="buttonA buttonA1" href="paquetes.php" accesskey="2" title="">Listado-Alta-Baja-Modificacion de paquetes</a></li>
                    <li><a class="buttonA buttonA1" href="transportistas.php" accesskey="3" title="">Listado-Alta-Baja-Modificacion de Transportista</a></li>
                    <li><a class="buttonA buttonA1" href="historial.php" accesskey="4" title="">Historial de envios</a></li>
                    <li><a class="buttonA buttonA1" href="?logout=1" accesskey="5" title="">Salir</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
            <h2><a style="color:white;">Listado-Alta-Baja-Modificacion de Paquetes</a></h2>
            <?php if($paquetes!=null) echo '
		    <div id="banner">
                <div class="limiter">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <div class="table100">
                                <table>
                                    <thead>
                                        <tr class="table100-head">
                                        <th class="column1">Codigo del Paquete</th>
                                        <th class="column8">Estado del Paquete</th>
                                        <th class="column4">Nombre del Transportista</th>
                                        <th class="column4">C.I.</th>
                                        <th class="column5">Modificar</th>
                                        <th class="column5">Fecha y Hora de Asignacion</th>
                                        <th class="column5"><a href="4_AgregarPaquete.html" class="buttonLogin buttonLoginAgr">Agregar</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                        if($paquetes!=null)
                                            foreach($paquetes as $paquete){
                                                echo '<tr>';
                                                echo '<td class="column1">'.$paquete->getCodigo().'</td>';
                                                echo '<td> En Transito </td>';
                                                echo '<td class="column1">'.$paquete->getNombre().'</td>';
                                                echo '<td class="column1">'.$paquete->getCi().'</td>';
                                                echo '<td class="column1">'.$paquete->getFechaHoraDeAsignacion().'</td>';
                                                echo '<th class="column5"><a href="4_ModificarPaquete.html" class="buttonLogin buttonLogin2">Modificar</a></th>';
                                                echo '<th class="column5"><a href="4_BorrarPaquete.html" class="buttonLogin buttonLoginBor">Borrar</a></th>';
                                                echo '</tr>';
                                            }
                                        else echo '<br><br>No hay paquetes activos';
                                echo '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>';
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