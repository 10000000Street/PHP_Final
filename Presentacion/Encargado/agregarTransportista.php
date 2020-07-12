<?php
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Paquete.php");
    require_once ("/xampp/htdocs/PhpUDE/Php_Final/Entidades/Persona.php");
    session_start();
    if(isset($_GET["logout"])){
        Logica::logOut();
        header("Location: ../bienvenida.php");
    }
    $error="";
    if (isset($_SESSION["encargado"])){
        if (isset($_POST["agregarTransportista"])){
            $nuevoTransportista=new Transportista(
                $_POST["cedula"],
                $_POST["nombres"],
                $_POST["apellidos"],
                $_FILES["foto"],
                $_POST["pin"],
                null,
                $_POST["direccion"],
                $_POST["telefono"]
            );
            $resultado=Logica::agregarTransportista($nuevoTransportista);
            if($resultado==0){
                header("Location: transportistas.php");
            }
            else {
                if($resultado==-2) $error="El transportista que esta intentando ingresar ya existe, pruebe activandolo.";
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
                    <li><a class="buttonA buttonA1" href="paquetes.php" accesskey="2" title="">Listado-Alta-Baja-Modificacion de paquetes</a></li>
                    <li><a class="buttonA buttonSeleccionado" href="transportistas.php" accesskey="3" title="">Listado-Alta-Baja-Modificacion de Transportista</a></li>
                    <li><a class="buttonA buttonA1" href="historial.php" accesskey="3" title="">Historial de envios</a></li>
                    <li><a class="buttonA buttonA1" href="?logout=1" accesskey="4" title="">Salir</a></li>
                </ul>      
            </div>            
        </div>  
        <div id="main">
            <h2><a style="color:white;">Agregar Transportista</a></h2>
		    <div id="banner">
                <form method="post" action="agregarTransportista.php" enctype="multipart/form-data">
                    <div class="limiter">
                        <div class="container-table100">
                            <div class="wrap-table100" style="margin-right: 50px;">
                                <div class="table100">
                                    <table>
                                        <thead>
                                            <tr class="table100-head">
                                                <th class="column1">Nombre</th>
                                                <th class="column5">Apellido</th> 
                                                <th class="column4">C.I.</th>
                                                <th class="column5">Direccion</th>
                                                <th class="column5">Telefono</th>
                                                <th class="column5">Foto</th>
                                                <th class="column5">Pin</th>       
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="column1"><input name="nombres" style="height: 35px; width: 6em; font-size: 20px;" type="text" maxlength="50" required></td>
                                                <td class="column6"><input name="apellidos" style="height: 35px; width: 6em; font-size: 20px;" type="text" maxlength="50" required></td>
                                                <td class="column4"><input name="cedula" style="height: 35px; width: 6em; font-size: 20px;" type="number" required></td>
                                                <td class="column5"><input name="direccion" style="height: 35px; width: 6em; font-size: 20px;" type="text" maxlength="50" required></td>
                                                <td class="column5"><input name="telefono" style="height: 35px; width: 6em; font-size: 20px;" type="number" required></td>
                                                <td class="column5"><input name="foto" style="height: 35px; width: 6em; font-size: 15px;" type="file" required></td>
                                                <td class="column5"><input name="pin" style="height: 35px; width: 6em; font-size: 20px;" type="text" maxlength="6" minlength="6" required></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>  
                            </div>
                        </div>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <a href="transportistas.php" class="buttonLogin buttonLogin1" style="width:186px;">
                        Cancelar
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type="submit" name="agregarTransportista" value="Agregar" class="buttonLogin buttonLogin1" style="width:250px;">
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