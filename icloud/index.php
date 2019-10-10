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
        $url_evento = null;
        if (isset($_COOKIE['url_evento'])) {
            $url_evento = $_COOKIE['url_evento'];
            header("Location: $url_evento");
        }
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
                        <!--  <div style="text-align: right;margin:1rem 1rem 0 0">
                              <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                                  <i class="material-icons left">lock</i>Salir
                              </a>
                          </div> -->

                        <!--MENU PERFIL DE PADRES-->

                        <div class="container b-blanco">
                            <div class="row">
                                <div class="row">
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <!--- SVG Transporte --->
                                                <a href='menu.php?idseccion=1'>
                                                    <img src="images/svg_main_menu/Transportes.svg" style="padding:1.5rem;">
                                                </a>
                                                <!--
                                                -->
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://users.schoolcloud.net/campus/chmd'>
                                                    <!-- schoolcloud -->
                                                    <img src="images/svg_main_menu/School cloud.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://chmd.edu.mx/galeria/' class="mb-3">
                                                    <!-- Galeria -->
                                                    <img src="images/svg_main_menu/Galeria.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='Choferes/Choferes.php'>
                                                    <!-- Choferes -->
                                                    <img src="images/svg_main_menu/Choferes.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='misarchivos/misarchivos.php'>
                                                    <!-- misarchivos -->
                                                    <img src="images/svg_main_menu/Mis documentos.svg" style="padding:1.5rem;">
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
                    <!--
                    <div style="text-align: right;margin:1rem 1rem 0 0">
                        <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                            <i class="material-icons left">lock</i>Salir
                        </a>
                    </div>
                    -->
                    <!--MENU PERFIL4-->

                    <br>
                        <div class="container b-blanco">
                            <div class="row">
                                <div class="row">
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <!--- SVG Transporte --->
                                                <a href='menu.php?idseccion=1'>
                                                    <img src="images/svg_main_menu/Transportes.svg" style="padding:1.5rem;">
                                                </a>
                                                <!--
                                                -->
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://users.schoolcloud.net/campus/chmd'>
                                                    <!-- schoolcloud -->
                                                    <img src="images/svg_main_menu/School cloud.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://chmd.edu.mx/galeria/' class="mb-3">
                                                    <!-- Galeria -->
                                                    <img src="images/svg_main_menu/Galeria.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='Choferes/Choferes.php'>
                                                    <!-- Choferes -->
                                                    <img src="images/svg_main_menu/Choferes.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='http://chmd.chmd.edu.mx:65083/demo/Eventos/menu.php'>
                                                    <!-- Minutas -->
                                                    <img src="images/svg_main_menu/Minutas.svg" style="padding:1.5rem;">
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
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='misarchivos/misarchivos.php'>
                                                    <!-- misarchivos -->
                                                    <img src="images/svg_main_menu/Mis documentos.svg" style="padding:1.5rem;">
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
                    } elseif ($tipo == 6) {
                        ?>
                        <div class="row">
                            <!--  <div style="text-align: right;margin:1rem 1rem 0 0">
                                  <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                                      <i class="material-icons left">lock</i>Salir
                                  </a>
                              </div> -->
                            <div class="col s12 m3 l4"><br></div>
                            <div class="col s12 m6 l4">
                                <div class="card" style="box-shadow: none;">
                                    <div class="card-image waves-block efecto-btn">
                                        <a href='Evento/menu.php'>
                                            <!-- Montajes -->
                                            <img src="images/svg_main_menu/Montajes.svg" style="padding:1.5rem;">
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
                            <div class="col s12 m3 l4"><br></div>
                        </div>
                        <?php
                    } elseif ($tipo == 8) {
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
                                            <div class="card-image waves-block efecto-btn">
                                                <!--- SVG Transporte --->
                                                <a href='menu.php?idseccion=1'>
                                                    <img src="images/svg_main_menu/Transportes.svg" style="padding:1.5rem;">
                                                </a>
                                                <!--
                                                -->
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://users.schoolcloud.net/campus/chmd'>
                                                    <!-- schoolcloud -->
                                                    <img src="images/svg_main_menu/School cloud.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://chmd.edu.mx/galeria/' class="mb-3">
                                                    <!-- Galeria -->
                                                    <img src="images/svg_main_menu/Galeria.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='Choferes/Choferes.php'>
                                                    <!-- Choferes -->
                                                    <img src="images/svg_main_menu/Choferes.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='Uniformes/menu.php'>
                                                    <!-- Uniformes -->
                                                    <img src="images/svg_main_menu/Uniformes.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='http://chmd.chmd.edu.mx:65083/demo/Eventos/menu.php'>
                                                    <!-- Minutas -->
                                                    <img src="images/svg_main_menu/Minutas.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='Evento/menu.php'>
                                                    <!-- Montajes -->
                                                    <img src="images/svg_main_menu/Montajes.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='Especial/menu.php?idseccion=1'>
                                                    <!-- Permisos -->
                                                    <img src="images/svg_main_menu/Permisos.svg" style="padding:1.5rem;">
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='misarchivos/misarchivos.php'>
                                                    <!-- misarchivos -->
                                                    <img src="images/svg_main_menu/Mis documentos.svg" style="padding:1.5rem;">
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
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='Minutas/menu.php'>
                                                    <img src="pics/_minutas.svg" style="padding:3rem;">
                                                </a>
                                            </div>
                                            <div class="card-content text-center" style="padding:0px;margin-top: -30px">
                                                <img class="activator waves-effect waves-light" src="../icloud/images/Info.svg" style="width: 30px;"/>
                                            </div>
                                            <div class="card-reveal b-azul white-text">
                                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                                <p>INFO PENDIENTE</p>
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
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://hangouts.google.com/'>
                                                    <img src="pics/hangout.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://www.google.com/calendar?tab=mc'>
                                                    <img src="pics/calendar.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='http://classroom.google.com/'>
                                                    <img src="pics/classroom.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://drive.google.com/?tab=mo&authuser=0'>
                                                    <img src="pics/drive.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a
                                                    href='http://search.ebscohost.com/login.aspx?authtype=uid&user=maguen&password=ebsco&group=main'>
                                                    <img src="pics/ebsco.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://mail.google.com/mail/?tab=mm'>
                                                    <img src="pics/gmail.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='http://chmd.chmd.edu.mx:61085/login/index.php'>
                                                    <img src="pics/moodle.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
                                                <a href='https://sites.google.com/?tab=m3'>
                                                    <img src="pics/sites.png" style="padding:3rem;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l4">
                                        <div class="card" style="box-shadow: none">
                                            <div class="card-image waves-block efecto-btn">
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
