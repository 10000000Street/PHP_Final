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
        //punto de entrada inicial a la pagina
        if(isset($_POST["modificar"])){ 
            $paquete=Logica::pedirPaquete($_POST["codigo"]);
        }
        else {
            //punto de entrada a la pagina para la modificacion en si
            if(isset($_POST["modificarPaquete"])){ 
                $paquete=Logica::pedirPaquete($_POST["codigo"]);

                $paqueteModificado=new Paquete(
                    $_POST["codigoNuevo"],$_POST["origen"],$_POST["destino"],
                    isset($_POST["fragil"]),isset($_POST["perecedero"]),
                    null,null,null,null,null
                );
                $resultado=Logica::modificarPaquete($_POST["codigo"],$paqueteModificado);

                switch($resultado){
                    case 0:{
                        header("Location: paquetes.php");
                        exit;
                    }
                    case -2:{
                        $error="Error, el paquete ya esta asignado y no puede ser modificado.";
                        break;
                    }
                    case -3:{
                        $error="Error, el nuevo codigo del paquete ya coincide con otro paquete existente.";
                        break;
                    }
                    default:{
                        header("Location: /PhpUDE/Php_Final/Presentacion/error.php");
                        exit;
                    }  
                }
            }
            else {
                header("Location: paquetes.php");
                exit; 
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
            <h1><a href="../bienvenida.php">Paquetitos Punto Com</a></h1>
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
            <h2><a style="color:white;">Modificar Paquete</a></h2>
		    <div id="banner">
                <form method="post" action="modificarPaquete.php">
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
                                            <?php 
                                            function auxFunction($boolean){
                                                if($boolean) return "Si";
                                                else return "No"; 
                                            }
                                            echo'
                                                <tr>
                                                    <td class="column1">'.$paquete->getCodigo().'</td>
                                                    <td class="column6">'.$paquete->getRemitente().'</td>
                                                    <td class="column6">'.$paquete->getDestinatario().'</td>
                                                    <td class="column4">'.auxFunction($paquete->getFragil()).'</td>
                                                    <td class="column5">'.auxFunction($paquete->getPerecedero()).'</td>
                                                ';
                                            ?>
                                            <tr>
                                                <td class="column1"><input name="codigoNuevo" type="text" style="height: 35px; width: 9em; font-size: 20px;" value="<?php echo $paquete->getCodigo()?>" minlength="11" maxlength="13" required></td>
                                                <td class="column6"><input name="origen" type="text" style="height: 35px; width: 10em; font-size: 20px;" value="<?php echo $paquete->getRemitente()?>" required></td>
                                                <td class="column6"><input name="destino" type="text" style="height: 35px; width: 10em; font-size: 20px;" value="<?php echo $paquete->getDestinatario()?>" required></td>
                                                <td class="column4"><input name="fragil" type="checkbox" <?php if($paquete->getFragil()) echo 'checked'?>></td>
                                                <td class="column5"><input name="perecedero" type="checkbox" <?php if($paquete->getPerecedero()) echo 'checked'?>></td>
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
                    <input type="hidden" name="codigo" value="<?php echo $_POST["codigo"]?>"> 
                    <input type="submit" name="modificarPaquete" value="Modificar" class="buttonLogin buttonLogin1" style="width:250px;">
                    <br><br>
                    <?php if(isset($error)) echo $error;?>
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