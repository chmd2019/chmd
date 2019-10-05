<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/sesion.php";
include_once "$root_icloud/components/layout_top.php";

if (isset($authUrl)) {
    ?>
    <style>
        body{
            background-image: url('/pruebascd/icloud/pics/body_bg.jpg');
            background-attachment: scroll;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding:0px;
            margin:0px;
        }
    </style>

    <?php include_once "$root_icloud/components/navbar.php"; ?>

    <div class="main">
        <div class="caja-login" align="center">
            <h3 class="text-center c-azul" style="margin:-10px">
                Mi Maguen
            </h3>
            <br>
            <?php echo '<a  href="' . $authUrl . '"><img src="images/google.png" alt="login" height="240px" width="240px"></a>' ?>
        </div>

        <?php
    } else {
        $user = $service->userinfo->get();
        $correo = $user->email;
        require_once './Model/Login.php';
        $objCliente = new Login();
        $consulta = $objCliente->acceso_login($correo);

        include_once "$root_icloud/components/navbar.php";

        if ($consulta) { //if user already exist change greeting text to "Welcome Back"
            if ($cliente = mysqli_fetch_array($consulta)) {
                $tipo = $cliente[12];
                if ($tipo == 3 || $tipo == 4) {//pendiente por asignar a tipo de usuario correspondiente
                    ?>

                    <script>
                        M.toast({html: 'Bienvenido!', classes: 'green accent-4'});
                    </script>

                    <div class="row">
                        <div style="text-align: right;margin:1rem 1rem 0 0">
                            <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                                <i class="material-icons left">lock</i>Salir
                            </a>
                        </div>

                        <!--MENU PERFIL DE PADRES-->

                        <div class="container b-blanco">
                            <div class="row">
                                <div class="row">
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-effect waves-block waves-light">
                                                <a href='menu.php?idseccion=1'>

                                                    <img src="pics/activos/transportes.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                    INFO
                                                </span>
                                            </div>
                                            <div class="card-reveal b-azul white-text">
                                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                <p>Solicitudes de cambio Permanente, Temporal, Del día.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-effect waves-block waves-light">
                                                <a href='https://users.schoolcloud.net/campus/chmd'>
                                                    <img src="pics/activos/schoolcloud.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                    INFO
                                                </span>
                                            </div>
                                            <div class="card-reveal b-azul white-text">
                                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                <p>Consulta de evaluación.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!--<div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-effect waves-block waves-light">
                                                <a href='Uniformes/menu.php'>
                                                    <img src="pics/activos/uniformes.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                    INFO
                                                </span>
                                            </div>
                                            <div class="card-reveal b-azul white-text">
                                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                <p>Pedidos de paquete de uniformes incluido en la canasta b sica y de uniformes adicionales.</p>
                                            </div>
                                        </div>
                                    </div>      -->

                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-effect waves-block waves-light">
                                                <a href='https://chmd.edu.mx/galeria/' class="mb-3">
                                                    <img src="pics/activos/galeria.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                    INFO
                                                </span>
                                            </div>
                                            <div class="card-reveal b-azul white-text">
                                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                <p>Podrás ver las imágenes de eventos del Colegio.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--

                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-effect waves-block waves-light">
                                                <a href='Especial/menu.php?idseccion=1'>
                                                    <img src="pics/activos/permisos.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                    INFO
                                                </span>
                                            </div>
                                            <div class="card-reveal b-azul white-text">
                                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                <p>Generar permisos extraordinarios, cumplea os y Bar Mitzv .</p>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-effect waves-block waves-light">
                                                <a href='Choferes/Choferes.php'>
                                                    <img src="pics/activos/choferes.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                    INFO
                                                </span>
                                            </div>
                                            <div class="card-reveal b-azul white-text">
                                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                <p>Podrás realizar un evento y generación de minuta del evento.</p>
                                            </div>
                                        </div>
                                    </div>

                                       <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='misarchivos/misarchivos.php'>
                                                <img src="pics/activos/misarchivos.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Encontrarás archivos y formatos relevantes para descargar e imprimir.</p>
                                        </div>
                                    </div>
                                </div>
                                    <!--
                                                                        <div class="col s12 m6 l4">
                                                                            <div class="card" style="box-shadow: none">
                                                                                <div class="card-image waves-effect waves-block waves-light">
                                                                                    <a href='Evento/menu.php'>
                                                                                        <img src="https://www.chmd.edu.mx/pruebascd/icloud/pics/activos/party.svg"
                                                                                             style="padding:3rem;width: 80%;margin: auto">
                                                                                    </a>
                                                                                </div>
                                                                                <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                                                                    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                                                        INFO
                                                                                    </span>
                                                                                </div>
                                                                                <div class="card-reveal b-azul white-text">
                                                                                    <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                                                    <p>INFO pendiente.</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    -->



                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                } elseif ($tipo == 5) {
                    ?>
                    <div style="text-align: right;margin:1rem 1rem 0 0">
                        <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                            <i class="material-icons left">lock</i>Salir
                        </a>
                    </div>
                    <!--MENU PERFIL4-->

                    <br>
                    <div class="container b-blanco">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='menu.php?idseccion=1'>
                                                <img src="pics/activos/transportes.png" style="padding:3rem;">
                                           </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Solicitudes de cambio Permanente, Temporal, Del dáa.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://users.schoolcloud.net/campus/chmd'>
                                                <img src="pics/activos/schoolcloud.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Consulta de evaluación.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://chmd.edu.mx/galeria/' class="mb-3">
                                                <img src="pics/activos/galeria.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>

                                            <p>Podrás ver las imágenes de eventos del Colegio.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='Choferes/Choferes.php'>
                                                <img src="pics/activos/choferes.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Podrás realizar un evento y generación de minuta del evento.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='http://chmd.chmd.edu.mx:65083/demo/Eventos/menu.php'>
                                                <img src="pics/activos/minuta.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Podrás realizar un evento y generación de minuta del evento.</p>
                                        </div>
                                    </div>
                                </div>


                                  <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='misarchivos/misarchivos.php'>
                                                <img src="pics/activos/misarchivos.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Encontrarás archivos y formatos relevantes para descargar e imprimir.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
            } elseif ($tipo == 6) {
                ?>
                    <div class="row">
                        <div style="text-align: right;margin:1rem 1rem 0 0">
                            <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                                <i class="material-icons left">lock</i>Salir
                            </a>
                        </div>
                        <div class="col s12 m3 l4"><br></div>
                        <div class="col s12 m6 l4">
                            <div class="card" style="box-shadow: none;">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <a href='Evento/menu.php'>
                                    <img src="images/Montajes.svg" style="padding:3rem;">
                                    </a>
                                </div>
                                <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                        INFO
                                    </span>
                                </div>
                                <div class="card-reveal b-azul white-text">
                                    <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                    <p>INFO pendiente.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m3 l4"><br></div>
                    </div>
                <?php
            } elseif ($tipo == 8)
            {
                ?>

                <!--
              <div style="text-align: right;margin:1rem 1rem 0 0">
                <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                <i class="material-icons left">lock</i>Salir
                </a>
              </div>
                  -->
                    <div class="container b-blanco">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='menu.php?idseccion=1'>
                                                    <!--- SVG Transporte --->
                                                    <svg width="250px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    	 viewBox="0 0 600 515" style="enable-background:new 0 0 600 515;" xml:space="preserve">
                                                    <style type="text/css">
                                                    	.st0{fill:#6DC1EC;}
                                                    	.st1{fill:#0E497B;stroke:#0E497B;stroke-miterlimit:10;}
                                                    	.st2{fill:#FFFFFF;}
                                                    </style>
                                                    <circle class="st0" cx="300" cy="229.26" r="218.48"/>
                                                    <g>
                                                    	<path class="st1" d="M121.26,470.7h-9.66c-1.82,0-3.24-1.48-3.24-3.24c0-1.76,1.42-3.24,3.24-3.24h26.42
                                                    		c1.76,0,3.18,1.48,3.18,3.24c0,1.76-1.42,3.24-3.18,3.24h-9.72v30.12c0,1.93-1.59,3.47-3.52,3.47c-1.93,0-3.52-1.53-3.52-3.47
                                                    		V470.7z"/>
                                                    	<path class="st1" d="M145.47,467.75c0-1.99,1.53-3.52,3.52-3.52h14.21c5,0,8.92,1.48,11.48,3.98c2.1,2.16,3.3,5.11,3.3,8.58v0.11
                                                    		c0,6.36-3.69,10.23-9.04,11.88l7.61,9.6c0.68,0.85,1.14,1.59,1.14,2.67c0,1.93-1.65,3.24-3.35,3.24c-1.59,0-2.61-0.74-3.41-1.82
                                                    		l-9.66-12.33h-8.81v10.68c0,1.93-1.53,3.47-3.47,3.47c-1.99,0-3.52-1.53-3.52-3.47V467.75z M162.68,483.94c5,0,8.18-2.61,8.18-6.65
                                                    		v-0.11c0-4.26-3.07-6.59-8.24-6.59h-10.17v13.35H162.68z"/>
                                                    	<path class="st1" d="M181.43,499.45l14.77-32.96c0.8-1.76,2.22-2.84,4.21-2.84h0.34c1.99,0,3.35,1.08,4.15,2.84l14.77,32.96
                                                    		c0.28,0.51,0.4,1.02,0.4,1.48c0,1.88-1.42,3.35-3.3,3.35c-1.65,0-2.78-0.97-3.41-2.44l-3.24-7.44h-19.32l-3.35,7.67
                                                    		c-0.57,1.42-1.76,2.22-3.24,2.22c-1.82,0-3.24-1.42-3.24-3.24C180.98,500.53,181.15,500.02,181.43,499.45z M207.46,488.2
                                                    		l-6.99-16.08l-6.99,16.08H207.46z"/>
                                                    	<path class="st1" d="M224.79,467.52c0-1.93,1.53-3.52,3.52-3.52h0.74c1.71,0,2.67,0.85,3.64,2.05l19.89,25.74v-24.43
                                                    		c0-1.88,1.53-3.41,3.41-3.41c1.93,0,3.47,1.53,3.47,3.41v33.41c0,1.93-1.48,3.47-3.41,3.47h-0.28c-1.65,0-2.67-0.85-3.64-2.1
                                                    		l-20.46-26.48v25.23c0,1.88-1.53,3.41-3.41,3.41c-1.93,0-3.47-1.53-3.47-3.41V467.52z"/>
                                                    	<path class="st1" d="M265.81,499.57c-0.79-0.57-1.36-1.53-1.36-2.67c0-1.82,1.48-3.24,3.3-3.24c0.97,0,1.59,0.28,2.05,0.62
                                                    		c3.29,2.61,6.82,4.09,11.14,4.09c4.32,0,7.05-2.04,7.05-5v-0.11c0-2.84-1.59-4.38-8.98-6.08c-8.47-2.04-13.24-4.54-13.24-11.88
                                                    		v-0.11c0-6.82,5.68-11.54,13.58-11.54c5,0,9.04,1.31,12.62,3.69c0.79,0.46,1.53,1.42,1.53,2.78c0,1.82-1.48,3.24-3.3,3.24
                                                    		c-0.68,0-1.25-0.17-1.82-0.51c-3.07-1.99-6.02-3.01-9.15-3.01c-4.09,0-6.48,2.1-6.48,4.72v0.11c0,3.07,1.82,4.43,9.49,6.25
                                                    		c8.41,2.05,12.73,5.06,12.73,11.65v0.11c0,7.44-5.85,11.88-14.21,11.88C275.36,504.57,270.24,502.86,265.81,499.57z"/>
                                                    	<path class="st1" d="M300.36,467.75c0-1.99,1.53-3.52,3.52-3.52h12.16c9.32,0,15.11,5.28,15.11,13.3v0.11
                                                    		c0,8.92-7.16,13.58-15.91,13.58h-7.9v9.6c0,1.93-1.53,3.47-3.47,3.47c-1.99,0-3.52-1.53-3.52-3.47V467.75z M315.47,484.91
                                                    		c5.28,0,8.58-2.96,8.58-7.1v-0.11c0-4.66-3.35-7.1-8.58-7.1h-8.13v14.32H315.47z"/>
                                                    	<path class="st1" d="M333.71,484.23v-0.11c0-11.19,8.64-20.57,20.85-20.57s20.74,9.26,20.74,20.46v0.11
                                                    		c0,11.19-8.64,20.57-20.85,20.57C342.24,504.68,333.71,495.42,333.71,484.23z M367.98,484.23v-0.11c0-7.73-5.62-14.15-13.52-14.15
                                                    		c-7.9,0-13.41,6.31-13.41,14.04v0.11c0,7.73,5.63,14.09,13.52,14.09S367.98,491.95,367.98,484.23z"/>
                                                    	<path class="st1" d="M380.93,467.75c0-1.99,1.53-3.52,3.52-3.52h14.21c5,0,8.92,1.48,11.48,3.98c2.1,2.16,3.3,5.11,3.3,8.58v0.11
                                                    		c0,6.36-3.69,10.23-9.04,11.88l7.61,9.6c0.68,0.85,1.14,1.59,1.14,2.67c0,1.93-1.65,3.24-3.35,3.24c-1.59,0-2.61-0.74-3.41-1.82
                                                    		l-9.66-12.33h-8.81v10.68c0,1.93-1.53,3.47-3.47,3.47c-1.99,0-3.52-1.53-3.52-3.47V467.75z M398.15,483.94c5,0,8.18-2.61,8.18-6.65
                                                    		v-0.11c0-4.26-3.07-6.59-8.24-6.59h-10.17v13.35H398.15z"/>
                                                    	<path class="st1" d="M428.94,470.7h-9.66c-1.82,0-3.24-1.48-3.24-3.24c0-1.76,1.42-3.24,3.24-3.24h26.42
                                                    		c1.76,0,3.18,1.48,3.18,3.24c0,1.76-1.42,3.24-3.18,3.24h-9.72v30.12c0,1.93-1.59,3.47-3.52,3.47c-1.93,0-3.52-1.53-3.52-3.47
                                                    		V470.7z"/>
                                                    	<path class="st1" d="M453.15,500.48v-32.73c0-1.99,1.53-3.52,3.52-3.52h23.13c1.7,0,3.12,1.42,3.12,3.12
                                                    		c0,1.76-1.42,3.12-3.12,3.12h-19.66v10.34h17.1c1.71,0,3.13,1.42,3.13,3.18c0,1.71-1.42,3.07-3.13,3.07h-17.1v10.68h19.95
                                                    		c1.7,0,3.12,1.42,3.12,3.13c0,1.76-1.42,3.12-3.12,3.12h-23.41C454.68,504,453.15,502.47,453.15,500.48z"/>
                                                    	<path class="st1" d="M487.35,499.57c-0.79-0.57-1.36-1.53-1.36-2.67c0-1.82,1.48-3.24,3.3-3.24c0.97,0,1.59,0.28,2.05,0.62
                                                    		c3.29,2.61,6.82,4.09,11.14,4.09c4.32,0,7.05-2.04,7.05-5v-0.11c0-2.84-1.59-4.38-8.98-6.08c-8.47-2.04-13.24-4.54-13.24-11.88
                                                    		v-0.11c0-6.82,5.68-11.54,13.58-11.54c5,0,9.04,1.31,12.62,3.69c0.79,0.46,1.53,1.42,1.53,2.78c0,1.82-1.48,3.24-3.3,3.24
                                                    		c-0.68,0-1.25-0.17-1.82-0.51c-3.07-1.99-6.02-3.01-9.15-3.01c-4.09,0-6.48,2.1-6.48,4.72v0.11c0,3.07,1.82,4.43,9.49,6.25
                                                    		c8.41,2.05,12.73,5.06,12.73,11.65v0.11c0,7.44-5.85,11.88-14.21,11.88C496.9,504.57,491.79,502.86,487.35,499.57z"/>
                                                    </g>
                                                    <g>
                                                    	<g>
                                                    		<path class="st2" d="M332.43,275.54h-64.86c-4.5,0-8.15,3.65-8.15,8.15s3.65,8.15,8.15,8.15h64.87c4.5,0,8.15-3.65,8.15-8.15
                                                    			S336.94,275.54,332.43,275.54z"/>
                                                    		<path class="st2" d="M328.4,100.95h-56.81c-4.5,0-8.15,3.65-8.15,8.15c0,4.5,3.65,8.15,8.15,8.15h56.81c4.5,0,8.15-3.65,8.15-8.15
                                                    			C336.55,104.6,332.9,100.95,328.4,100.95z"/>
                                                    		<path class="st2" d="M426.23,124.13c-0.31-0.04-0.64-0.06-0.95-0.06h-11.3c-5.01-19.17-23.72-46.26-69.83-46.26h-88.31
                                                    			c-47.5,0-64.12,32.02-69.16,46.26h-11.96c-0.32,0-0.64,0.02-0.95,0.06c-10.95,1.29-31.65,10.36-31.65,35.43v44.83
                                                    			c0,4.5,3.65,8.15,8.15,8.15h20.38c4.5,0,8.15-3.65,8.15-8.15v-40.75c0-4.5-3.65-8.15-8.15-8.15h-11.89
                                                    			c2.09-11.99,13.31-14.61,16.53-15.11h9.76v201.56c0,3.64,2.41,6.84,5.91,7.84c0.38,0.11,2.26,0.64,5.33,1.43v21.25
                                                    			c0,10.69,8.7,19.39,19.39,19.39h18.74c10.69,0,19.39-8.7,19.39-19.39v-10.19c15.02,1.96,31.52,3.36,48.13,3.36
                                                    			c15.44,0,30.51-1.21,44.24-2.95v9.79c0,10.69,8.7,19.39,19.39,19.39h18.74c10.69,0,19.39-8.7,19.39-19.39V351.3
                                                    			c3.18-0.87,5.11-1.46,5.49-1.57c3.42-1.05,5.75-4.21,5.75-7.79V140.38h9.75c3.32,0.53,14.46,3.17,16.55,15.11h-11.89
                                                    			c-4.5,0-8.15,3.65-8.15,8.15v40.75c0,4.5,3.65,8.15,8.15,8.15h20.38c4.5,0,8.15-3.65,8.15-8.15v-44.83
                                                    			C457.88,134.5,437.18,125.43,426.23,124.13z M162.49,171.8v24.45h-4.08V171.8H162.49z M201.35,287.95h15.62
                                                    			c2.83,0,5.13,2.3,5.13,5.13v8.86c0,2.83-2.3,5.13-5.13,5.13h-15.62V287.95z M201.35,140.38h197.29V244.5H201.35V140.38z
                                                    			 M398.64,307.07h-15.62c-2.83,0-5.13-2.3-5.13-5.13v-8.86c0-2.83,2.3-5.13,5.13-5.13h15.62V307.07z M255.84,94.11h88.31
                                                    			c35.43,0,48.13,18.46,52.61,29.96H204.11C209.6,112.33,223.35,94.11,255.84,94.11z M237.51,372.46c0,1.7-1.39,3.09-3.09,3.09
                                                    			h-18.74c-1.7,0-3.09-1.39-3.09-3.09v-17.39c7.04,1.54,15.51,3.22,24.92,4.78L237.51,372.46L237.51,372.46z M201.35,335.66v-12.29
                                                    			h15.62c11.82,0,21.44-9.61,21.44-21.43v-8.86c0-11.82-9.61-21.43-21.44-21.43h-15.62V260.8h197.29v10.85h-15.62
                                                    			c-11.81,0-21.43,9.61-21.43,21.43v8.86c0,11.82,9.61,21.43,21.43,21.43h15.62v12.4c-14.54,3.91-54.63,13.55-96.7,13.55
                                                    			C259.62,349.32,216.71,339.54,201.35,335.66z M387.4,372.46c0,1.7-1.39,3.09-3.09,3.09h-18.74c-1.7,0-3.09-1.39-3.09-3.09v-12.19
                                                    			c9.45-1.58,17.89-3.31,24.92-4.9L387.4,372.46L387.4,372.46z M441.58,196.25h-4.08V171.8h4.08V196.25z"/>
                                                    	</g>
                                                    </g>
                                                    </svg>

                                                <!--<img src="pics/activos/transportes.png" style="padding:3rem;"> -->
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Solicitudes de cambio Permanente, Temporal, Del día.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://users.schoolcloud.net/campus/chmd'>
                                                <img src="pics/activos/schoolcloud.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                        <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span> -->
                                            <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                               viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                            <style type="text/css">
                                              .st0{fill:#0E497B;}
                                            </style>
                                            <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                              S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                              S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                              c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                              C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                            <g>
                                              <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                            </g>
                                            </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Consulta de evaluación.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://chmd.edu.mx/galeria/' class="mb-3">
                                                <img src="pics/activos/galeria.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>

                                            <p>Podrás ver las imágenes de eventos del Colegio.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='Choferes/Choferes.php'>
                                                <img src="pics/activos/choferes.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Podrás agregar y/o editar choferes y automoviles.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='Uniformes/menu.php'>
                                                <img src="pics/activos/uniformes.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='http://chmd.chmd.edu.mx:65083/demo/Eventos/menu.php'>
                                                <img src="pics/activos/minuta.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Podrás realizar un evento y generación de minuta del evento.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none;">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='Evento/menu.php'>
                                    <img src="images/Montajes.svg" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i
                                                    class="material-icons right">close</i></span>
                                            <p>INFO pendiente.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='Especial/menu.php?idseccion=1'>
                                                <img src="pics/activos/permisos.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Generar permisos extraordinarios, cumpleaños y Bar Mitzv .</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='misarchivos/misarchivos.php'>
                                                <img src="pics/activos/misarchivos.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                          <!--    <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                  INFO
                                              </span> -->
                                              <svg  class="activator waves-effect waves-light" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#0E497B;}
                                              </style>
                                              <path class="st0" d="M300,589.51c-77.33,0-150.03-30.11-204.72-84.8S10.49,377.33,10.49,300c0-77.33,30.11-150.03,84.8-204.72
                                                S222.67,10.49,300,10.49s150.03,30.11,204.72,84.8s84.8,127.38,84.8,204.72c0,77.33-30.11,150.03-84.8,204.71
                                                S377.33,589.51,300,589.51z M300,38.3c-69.9,0-135.62,27.22-185.05,76.65C65.53,164.38,38.3,230.1,38.3,300
                                                c0,69.9,27.22,135.62,76.65,185.05C164.38,534.47,230.1,561.7,300,561.7s135.62-27.22,185.05-76.65
                                                C534.47,435.62,561.7,369.9,561.7,300c0-69.9-27.22-135.62-76.65-185.05C435.62,65.53,369.9,38.3,300,38.3z"/>
                                              <g>
                                                <path class="st0" d="M288.49,372.82c-12.32,0-21.42-9.1-23.02-21.42l-5.35-46.05c-2.14-14.46,6.43-25.17,20.88-26.77
                                                  c50.33-4.82,78.18-24.1,78.18-57.83v-1.07c0-29.98-23.02-50.87-61.58-50.87c-28.38,0-51.4,10.17-72.82,29.45
                                                  c-5.35,4.28-12.32,7.5-19.81,7.5c-16.6,0-29.99-13.39-29.99-29.45c0-8.03,3.21-16.6,10.71-23.02
                                                  c28.38-26.77,64.25-44.44,113.51-44.44c74.96,0,125.83,41.76,125.83,108.7v1.07c0,67.47-48.72,97.99-108.16,108.16l-2.14,24.63
                                                  c-2.14,11.78-10.71,21.42-23.02,21.42H288.49z M288.49,411.91c21.95,0,38.02,16.06,38.02,36.95v5.35
                                                  c0,20.88-16.06,36.95-38.02,36.95s-38.02-16.06-38.02-36.95v-5.35C250.47,427.97,266.53,411.91,288.49,411.91z"/>
                                              </g>
                                              </svg>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Encontrarás archivos y formatos relevantes para descargar e imprimir.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php
            } else {
                ?>
                    <div class="fixed-action-btn">
                <?php
                echo '<a href="' . $redirect_uri . '?logout=1" class="btn-floating btn-large red" >'
                . "<i class='material-icons'>exit_to_app</i>Salir</a>";
                ?>
                    </div>

                    <div class="container b-blanco">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://hangouts.google.com/'>
                                                <img src="pics/hangout.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://www.google.com/calendar?tab=mc'>
                                                <img src="pics/calendar.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='http://classroom.google.com/'>
                                                <img src="pics/classroom.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://drive.google.com/?tab=mo&authuser=0'>
                                                <img src="pics/drive.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a
                                                href='http://search.ebscohost.com/login.aspx?authtype=uid&user=maguen&password=ebsco&group=main'>
                                                <img src="pics/ebsco.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://mail.google.com/mail/?tab=mm'>
                                                <img src="pics/gmail.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='http://chmd.chmd.edu.mx:61085/login/index.php'>
                                                <img src="pics/moodle.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='https://sites.google.com/?tab=m3'>
                                                <img src="pics/sites.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a
                                                href='http://sn3.colegium.com/es_CL/login/alternativo?id=1583E1CHMD-mx.sha1(YobA6ixTNSO2klMq+1).1'>
                                                <img src="pics/colegium.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='http://esp.brainpop.com/user/loginDo.weml?user=maguen1&password=biblioteca'>
                                                <img src="pics/brainpop.png" style="padding:3rem;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }

            //fin validacion de alumno o maestro
        }//fin de consulta principal
        else {
            ?>
                <center>
                    <span style="margin-top: 3%;margin-bottom: 20%;display: block">

                <?php
                echo 'Este usuario no tiene acceso: <span style="color:#00C2EE">' . $user->email .
                '</span><br>  Favor de comunicarse para validar datos!  '
                . '<br><br><a href="#!" onclick="logout()" class="waves-effect waves-light btn red"> '
                . '<i class="material-icons left">lock</i>Salir del sistema</a>';
                ?>
                    </span>
                </center>
                        <?php
                    }
                } else {
                    echo 'Error';
                }
            }
            ?>
</div>

<script>
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
    });
</script>

<?php include_once "$root_icloud/components/layout_bottom.php"; ?>
