<?php
include './components/layout_top.php';
include './components/sesion.php';
include './components/navbar.php';

if (isset($authUrl)) {
    //show login url
    ?>
    <div class="caja-login" align="center">
        <h2 class="alert alert-light text-center c-azul" role="alert">Mi Maguen</h2>
        <?php echo '<a  href="' . $authUrl . '"><img style="width:200px" src="images/google.png" id="total"/></a>' ;?>
    </div>
    <?php
} else {
    $user = $service->userinfo->get(); //get user info
    $correo = $user->email;
    require('Model/Login.php');
    $objCliente = new Login();
    $consulta = $objCliente->Acceso($correo);
    if ($consulta) { //if user already exist change greeting text to "Welcome Back"
        if ($cliente = mysqli_fetch_array($consulta)) {
            $id = $cliente[0];
            $correo1 = $cliente[1];
            $perfil = $cliente[2];
            $estatus = $cliente[3];
            $anio_actual = date("Y");

            if ($perfil == 3) {
                ?>
                <!--MENU PERFIL3-->
                <div class="row"><br><br>
                    <div class="col-sm-12 col-md-9 b-blanco" style="margin:auto;">
                        <?php
                        echo '<h2 class="alert alert-light text-center b-azul c-blanco" role="alert">Mi Maguen ' . $anio_actual . '</h2>';
                        echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-pill b-azul white-text mr-3 right">'
                        . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a><div style='clear:both'></div>";
                        ?>
                        <br>

                        <div class='row' style='width:100%;margin:auto;'>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/transportes.png" class="img-fluid p-3 m-auto">
                                    <a href='menu.php?idseccion=1'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Solicitudes de cambio Permanente, Temporal, Del día." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/colegi.png" class="img-fluid p-3 m-auto">
                                    <a href='http://colegium.chmd.edu.mx'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Consulta de evaluación." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/schoolcloud.png" class="img-fluid p-3 m-auto">
                                    <a href='https://users.schoolcloud.net/campus/chmd'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Consulta de evaluación." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/facturacion.png" class="img-fluid p-3 m-auto">
                                    <a href='RFC/RFC.php'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Historial de facturas y modificación de datos de facturación." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/uniformes.png" class="img-fluid p-3 m-auto">
                                    <a href='Uniformes/menu.php'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales." >Info</button>
                                </div>
                            </div> 
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="https://chmd.edu.mx/wp-content/uploads/2018/07/iconGaleria.png" class="img-fluid p-3">
                                    <a href='https://chmd.edu.mx/galeria/' class="mb-3 m-auto">
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Podrás ver las imágenes de eventos del colegio." >Info</button>
                                </div>  
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/permisos.png" class="img-fluid p-3 m-auto">
                                    <a href='https://chmd.edu.mx/galeria/'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Generar permisos extraordinarios, Cumpleaños, bar mitzvah." >Info</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <?php
            } elseif ($perfil == 4) {
                ?>  
                <!--MENU PERFIL4-->

                <div class="row"><br><br>
                    <div class="col-sm-12 col-md-9 b-blanco" style="margin:auto;">
                        <?php
                        echo '<h2 class="alert alert-light text-center b-azul c-blanco" role="alert">Mi Maguen ' . $anio_actual . '</h2>';
                        echo '<a href="' . $redirect_uri . '?logout=1" class="btn b-azul white-text btn-pill mr-3 right">'
                        . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a><div style='clear:both'></div>";
                        ?>
                        <br>
                        <div class='row b-blanco' style='margin:auto'>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/transportes.png" class="img-fluid p-3 m-auto">
                                    <a href='menu.php?idseccion=1'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Solicitudes de cambio Permanente, Temporal, Del día." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/colegi.png" class="img-fluid p-3 m-auto">
                                    <a href='http://colegium.chmd.edu.mx'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Consulta de evaluación." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/schoolcloud.png" class="img-fluid p-3 m-auto">
                                    <a href='https://users.schoolcloud.net/campus/chmd'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Consulta de evaluación." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/facturacion.png" class="img-fluid p-3 m-auto">
                                    <a href='RFC/RFC.php'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Historial de facturas y modificación de datos de facturación." >Info</button>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/uniformes.png" class="img-fluid p-3 m-auto">
                                    <a href='Uniformes/menu.php'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales." >Info</button>
                                </div>
                            </div> 
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="https://chmd.edu.mx/wp-content/uploads/2018/07/iconGaleria.png" class="img-fluid p-3 m-auto">
                                    <a href='https://chmd.edu.mx/galeria/' class="mb-3">
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text mt-3" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Podrás ver las imágenes de eventos del colegio." >Info</button>
                                </div>                                
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/eventos.png" class="img-fluid p-3 m-auto">
                                    <a href='Eventos/menu.php '>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Podrás realizar un evento y generación de minuta del evento." >Info</button>
                                </div>                                    
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class="view p-3">
                                    <img src="pics/activos/permisos.png" class="img-fluid p-3">
                                    <a href='https://chmd.edu.mx/galeria/'>
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                            data-content="Generar permisos extraordinarios, Cumpleaños, bar mitzvah." >Info</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            } else {
                echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-pill b-azul white-text mr-3 right">'
                . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a><div style='clear:both'></div>";
                ?>
                <div class="row ">                  
                    <div class="col-sm-12 col-md-10" style='background-color: white;margin:auto'>
                        <br><br>
                        <div id='respon' class='row' style='width:100%;margin:auto'>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/hangout.png' style='width:50%;margin: auto'>
                                    <br>
                                    <a href='https://hangouts.google.com/' class='btn btn-primary w-50 m-auto'>Entrar</a>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/calendar.png' style='width:50%;margin: auto' >
                                    <br>
                                    <a href='https://www.google.com/calendar?tab=mc' class='btn btn-primary w-50 m-auto'>Entrar</a>   
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/classroom.png' style='width:50%;margin: auto' >
                                    <br>
                                    <a href='http://classroom.google.com/' class='btn btn-primary w-50 m-auto'>Entrar</a>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/drive.png' style='width:50%;margin: auto' >
                                    <br>
                                    <a href='https://drive.google.com/?tab=mo&authuser=0' class='btn btn-primary w-50 m-auto'>Entrar</a>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/ebsco.png' style='width:50%;margin: auto'  >
                                    <br>
                                    <a href='http://search.ebscohost.com/login.aspx?authtype=uid&user=maguen&password=ebsco&group=main' class='btn btn-primary w-50 m-auto'>Entrar</a>
                                </div>
                            </div> 
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/gmail.png' style='width:50%;margin: auto'>
                                    <br>
                                    <a href='https://mail.google.com/mail/?tab=mm' class='btn btn-primary w-50 m-auto'>Entrar</a>    
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/moodle.png' style='width:50%;margin: auto' >
                                    <br>
                                    <a href='http://chmd.chmd.edu.mx:61085/login/index.php' class='btn btn-primary w-50 m-auto'>Entrar</a>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/sites.png' style='width:50%;margin: auto' >
                                    <br>
                                    <a href='https://sites.google.com/?tab=m3' class='btn btn-primary w-50 m-auto'>Entrar</a> 
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/colegium.png' style='width:50%;margin: auto' >
                                    <br>
                                    <a href='http://sn3.colegium.com/es_CL/login/alternativo?id=1583E1CHMD-mx.sha1(YobA6ixTNSO2klMq+1).1' class='btn btn-primary w-50 m-auto'>Entrar</a>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card border border-0' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/brainpop.png' style='width:50%;margin: auto' >
                                    <br>                                    
                                    <a href='http://esp.brainpop.com/user/loginDo.weml?user=maguen1&password=biblioteca' class='btn btn-primary w-50 m-auto'>Entrar</a> 
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
            echo 'Este usuario no tiene Acceso:' . $user->email . ',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="' . $redirect_uri . '?logout=1"> Log Out</a>]';
        }
    } else {
        echo 'Error';
    }
}
?><br><br>
</div>
</div>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover();
    })
</script>
<?php include './components/layout_bottom.php'; ?>

