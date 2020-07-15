<?php
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    session_start();
    if(isset($_GET["logout"]) || !Logica::refreshTimeOut()){
        Logica::logOut();
        header("Location: ../bienvenida.php");
    }

    
    if (isset($_SESSION["encargado"])){
        $transportistas=Logica::pedirTransportistas();
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
                    <li><a class="buttonA buttonA1" href="paquetes.php" accesskey="2" title="">Administracion de Paquetes</a></li>
                    <li><a class="buttonA buttonSeleccionado" href="transportistas.php" accesskey="3" title="">Administracion de Transportistas</a></li>
                    <li><a class="buttonA buttonA1" href="historial.php" accesskey="3" title="">Historial de envios</a></li>
                    <li><a class="buttonA buttonA1" href="?logout=1" accesskey="4" title="">Salir</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
            <h2><a style="color:white;">Administracion de Transportistas</a></h2>
		    <div id="banner">
                <div class="limiter">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <div class="table100">
                                <table>
                                    <thead>
                                        <tr class="table100-head">
                                            <th class="column1">C.I. del Transportista</th>
                                            <th class="column8">Nombre del Transportista</th>
                                            <th class="column4">Direccion</th>
                                            <th class="column5">Telefono</th>
                                            <th class="column5">Foto</th>
                                            <th class="column5">Modificar</th>
                                            <th class="column5" colspan="2"><a href="agregarTransportista.php" class="buttonLogin buttonLoginAgr">Agregar</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                if($transportistas!==null) foreach($transportistas as $transportista){
                                                echo '
                                            <tr>
                                                <td class="column1">'.$transportista->getCedula().'</td>
                                                <td class="column6">'.$transportista->getNombres()." ".$transportista->getApellidos().'</td>
                                                <td class="column4">'.$transportista->getDireccion().'</td>
                                                <td class="column5">'.$transportista->getTelefono().'</td>
                                                <th class="column5"><img src="/PhpUDE/Php_Final/Persistencia/imagenes/'.$transportista->getFoto().'" height="60"></th>
                                                <th class="column5">
                                                    <form method="post" action="modificarTransportista.php" >
                                                        <input type="hidden" name="cedula" value="'.$transportista->getCedula().'">
                                                        <input type="submit" name="modificar" value="Modificar" class="buttonLogin buttonLogin2">
                                                    </form>
                                                </th>';
                                            if(!$transportista->getDesactivada()) {
                                                echo '
                                                <th class="column5">
                                                    <form method="post" action="eliminarTransportista.php" >
                                                        <input type="hidden" name="cedula" value="'.$transportista->getCedula().'">
                                                        <input type="submit" name="desactivar" value="Desactivar" class="buttonLogin buttonLogin2">
                                                    </form>
                                                </th>';}
                                            else {echo '
                                                <th class="column5">
                                                    <form method="post" action="eliminarTransportista.php" >
                                                        <input type="hidden" name="cedula" value="'.$transportista->getCedula().'">
                                                        <input type="submit" name="activar" value="Activar" class="buttonLogin buttonLogin2">
                                                    </form>
                                                </th>
                                            </tr>';  }      
                                            }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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