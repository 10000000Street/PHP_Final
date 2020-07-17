<?php  
    require_once ("/../Logica/Logica.php");
    session_start();
    if(!Logica::refreshTimeOut()) Logica::logOut();

    if (isset($_SESSION["encargado"])){
        header("Location: Encargado/inicio.php"); 
        exit;
    }
    if (isset($_SESSION["transportista"])){
        header("Location: Transportista/inicio.php"); 
        exit;
    }
    $acceso=null;
    if(isset($_POST["enviar"])){
        $acceso=Logica::loginEncargado($_POST["ci"],$_POST["pin"]);
        if($acceso) {
            header("Location: Encargado/inicio.php"); 
            exit;
        
        } 
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
    </div>
    
    <div id="page" class="container">
        <div id="header">
            <div id="logo">
                <h1><a href="">Seleccione su <br> tipo de cuenta</a></h1>
                
            </div>
            <div id="menu">
                <ul>
                    <li><a class="buttonA buttonA1" href="t_login.php" accesskey="1" title="">Transportista</a></li>
                    <li><a class="buttonA buttonSeleccionado" href="e_login.php" accesskey="2" title="">Encargado</a></li>
                    <li><a class="buttonA buttonA1" href="visitante.php" accesskey="3" title="">Visitante</a></li>
                </ul>      
            </div>            
        </div>  

        <div id="main">
		    <div id="banner">
                <div class="container-login100">
                    <div class="wrap-login100">
        
                        <div class="login100-form validate-form">
                            <span class="login100-form-title">
                                Ingresar Como Encargado
                            </span>
                            <form method="post" action="e_login.php">
                                <div class="wrap-input100 validate-input">
                                    <input class="input100" type="text" name="ci" placeholder="C.I." maxlength="11" required>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <input class="input100" type="password" name="pin" placeholder="Pin"required>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="container-login100-form-btn">
                                    <input class="buttonLogin buttonLogin1" type="submit" name="enviar" value="Login">
                                </div>

                                <!--Para hacer div invisible(css): display: none;-->
                                <br>
                                <div class="text-center p-t-12" align="center" 
                                    <?php if(!($acceso==false && isset($_POST["enviar"])) ) echo 'style="display: none"';?>
                                > 
                                    <div style="color: rgb(204, 34, 34);margin: 10px;width: 250px;padding: 5px; border: 2px solid rgb(161, 34, 34);">
                                    CI/Pin invalidos, intente nuevamente
                                    </div>
                                </div>
                            </form> 
        
                            <div class="text-center p-t-12">
                                <span class="txt1">
                                    Olvidaste tu 
                                </span>
                                <a class="txt2" href="#">
                                    Pin?
                                </a>
                            </div>
        
                            <div class="text-center p-t-136">
                                <a class="txt2" href="#">
                                    Crea una cuenta
                                    <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                                </a>
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