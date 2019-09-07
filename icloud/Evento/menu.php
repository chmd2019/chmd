<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/components/sesion.php";
include_once "$root_icloud/components/layout_top.php";
$idseccion = $_GET['idseccion'];

if (isset($authUrl)) {
    header("Location: $redirect_uri?logout=1");
} else {
    $user = $service->userinfo->get();
    $correo = $user->email;
    require_once "$root_icloud/Model/Login.php";
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    $anio_actual = date("Y");
    if ($idseccion == 1) {
        $titulo = "Cambios de transportes";
    }
    if ($idseccion == 5) {
        $titulo = "Datos de facturación";
    }
    include_once "$root_icloud/components/navbar.php";
    ?>
    <h4 class="b-azul c-blanco text-center" style="padding:1rem;margin-top:0px">
        Mi Maguen
        <?php
        echo $anio_actual;
        ?>
    </h4>
    <div style="text-align: right;margin:1rem 1rem 0 0">
        <a class="waves-effect waves-light" href="<?php echo $redirect_uri; ?>">  
            <img src='../images/Atras.svg' style="width: 110px">     
        </a>
    </div>
    <!--MENU-->
    <div class="row">
        <div class="col s12 m6" style="float:none;margin:auto">
            <?php
            if ($consulta) {
                if ($cliente = mysqli_fetch_array($consulta)) {
                    $familia = $cliente[2];
                    ?>

                    <div class="col s12 l6">
                        <div class="card" style="box-shadow: none">
                            <div class="card-image waves-effect waves-block waves-light">
                                <center><a href="calendario/PCalendario.php">
                                        <img src="../images/Calendario disponible.svg" style="padding:3rem;">
                                    </a></center>
                            </div>
                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                <!--<span class="activator waves-effect waves-light btn b-azul c-blanco">
                                    INFO
                                </span>-->
                                <svg  class="activator waves-effect waves-light" width="60px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                <p>DEMO.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="card" style="box-shadow: none">
                            <div class="card-image waves-effect waves-block waves-light">
                                <a href="montajes/PMontajes.php">
                                    <img src="../images/Montajes.svg" style="padding:3rem;">
                                </a>
                            </div>
                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                <!--<span class="activator waves-effect waves-light btn b-azul c-blanco">
                                    INFO
                                </span>-->
                                <svg  class="activator waves-effect waves-light" width="60px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                <p>DEMO.</p>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo 'Este usuario no tiene Acceso:' . $user->email . ',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="' . $redirect_uri . '?logout=1"> Log Out</a>]';
                }
            } else {
                echo 'Error en cosulta';
            }
        }
        ?>
        <br>
            <br>
                </div>
                </div>

                <?php include "$root_icloud/components/layout_bottom.php"; ?>
