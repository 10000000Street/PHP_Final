<?php 
    $paquete=null;
    if(isset($_POST["buscar"])) {
        require_once ("/xampp/htdocs/PhpUDE/Php_Final/Logica/Logica.php");
        $paquete=Logica::pedirPaquete($_POST["codigo"]);
        if( $paquete != null){
            header('Location: Visitante/inicio.php?codigo='.$paquete->getCodigo());
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
                        <li><a class="buttonA buttonA1" href="e_login.php" accesskey="2" title="">Encargado</a></li>
                        <li><a class="buttonA buttonSeleccionado" href="visitante.php" accesskey="3" title="">Visitante</a></li>
                    </ul>      
                </div>            
            </div>  
            <div id="main">
                <div id="banner">
                    <div class="container-login100">
                        <div class="wrap-login100">
            
                            <form class="login100-form validate-form" method="post" action="visitante.php">
                                <span class="login100-form-title">
                                    Ingresar Codigo de Paquete Para Ver Su Estado
                                </span>
            
                                <div class="wrap-input100 validate-input">
                                    <input class="input100" type="text" name="codigo" placeholder="Codigo de Paquete" required minlength="12" maxlength="13">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <!--Para hacer div invisible(css): display: none;-->
                                <br>
                                <div class="text-center p-t-12" align="center" 
                                <?php if( !($paquete==null && isset($_POST["buscar"])) ) echo 'style="display: none"'; ?>
                                > 
                                    <div style="color: rgb(204, 34, 34);margin: 10px;width: 250px;padding: 5px; border: 2px solid rgb(161, 34, 34);">
                                    El codigo ingresado no se pudo encontrar.
                                    </div>
                                </div>

                                <div class="container-login100-form-btn">
                                    <input class="buttonLogin buttonLogin1" type="submit" name="buscar" value="Buscar">
                                </div>
                            </form>
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