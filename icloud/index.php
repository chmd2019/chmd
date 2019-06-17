<?php
include './components/layout_top.php';
include './components/sesion.php';

if (isset($authUrl)) {
    //show login url
    ?>
    <div class="caja-login" align="center">
        <h2 class="alert alert-light text-primary text-center" role="alert">Mi Maguen</h2>
        <br><br>
        <?php echo '<a  href="' . $authUrl . '"><img src="images/google.png" id="total"/></a>' ?>
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
                        <br><br>
                        <?php
                        echo '<h2 class="alert alert-light text-primary text-center" role="alert">Mi Maguen ' . $anio_actual . '</h2>';
                        echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-primary btn-pill mr-3 right">'
                        . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a><div style='clear:both'></div>";
                        ?>
                        <br>
                        <div class='row' style='width:100%;margin:auto'>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/transportes.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Solicitudes de cambio Permanente, Temporal, Del día.</p>    
                                        <a href='menu.php?idseccion=1' class='btn btn-primary'>Entrar</a>         
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/colegi.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Consulta de evaluación.</p><br>
                                        <a href='http://colegium.chmd.edu.mx' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/schoolcloud.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Consulta de evaluación.</p><br>
                                        <a href='https://users.schoolcloud.net/campus/chmd' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/facturacion.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Historial de facturas y modificación de datos de facturación.</p>
                                        <a href='RFC/RFC.php' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/inactivos/uniformes.png' style='width:50%;margin: auto'  >
                                    <div class='card-body'>
                                        <p class="card-text">Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales.</p>
                                        <a href='Uniformes/menu.php' class='btn btn-primary'>Entrar</a>        
                                    </div>
                                </div>
                            </div> 
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='https://chmd.edu.mx/wp-content/uploads/2018/07/iconGaleria.png' style='width:50%;margin: auto'>
                                    <div class='card-body mb-3'>
                                        <p class="card-text">Podrás ver las imágenes de eventos del colegio.</p><br>
                                        <a href='https://chmd.edu.mx/galeria/' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                              <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/permisos.png' style='width:50%;margin: auto'>
                                    <div class='card-body mb-3'>
                                        <p class="card-text">Generar permisos extraordinarios, Cumpleaños, bar mitzvah.</p><br>
                                        <a href='https://chmd.edu.mx/galeria/' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <?php
            } elseif ($perfil == 4)
                {
                ?>  
                <!--MENU PERFIL4-->
                <div class="row"><br><br>
                    <div class="col-sm-12 col-md-9 b-blanco" style="margin:auto;">
                        <br><br>
                        <?php
                        echo '<h2 class="alert alert-light text-primary text-center" role="alert">Mi Maguen ' . $anio_actual . '</h2>';
                        echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-primary btn-pill mr-3 right">'
                        . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a><div style='clear:both'></div>";
                        ?>
                        <br>
                        <div class='row b-blanco' style='width:100%;padding:1rem;margin:auto'>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/transportes.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Solicitudes de cambio Permanente, Temporal, Del día.</p>    
                                        <a href='menu.php?idseccion=1' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/colegi.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Consulta de evaluación.</p><br>
                                        <a href='http://colegium.chmd.edu.mx' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/schoolcloud.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Consulta de evaluación.</p><br>
                                        <a href='https://users.schoolcloud.net/campus/chmd' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/facturacion.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class="card-text">Historial de facturas y modificación de datos de facturación.</p>
                                        <a href='RFC/RFC.php' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/uniformes.png' style='width:50%;margin: auto'  >
                                    <div class='card-body'>
                                        <p class="card-text">Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales.</p>
                                        <a href='Uniformes/menu.php' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div> 
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='https://chmd.edu.mx/wp-content/uploads/2018/07/iconGaleria.png' style='width:50%;margin: auto'>
                                    <div class='card-body mb-3'>
                                        <p class="card-text">Podrás ver las imágenes de eventos del colegio.</p><br>
                                        <a href='https://chmd.edu.mx/galeria/' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/eventos.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <p class='card-text'>Podrás realizar un evento y generación de minuta del evento.</p><br>
                                        <a href='Eventos/menu.php' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                             <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <br>
                                    <img class='card-img-top' src='pics/activos/permisos.png' style='width:50%;margin: auto'>
                                    <div class='card-body mb-3'>
                                        <p class="card-text">Generar permisos extraordinarios, Cumpleaños, bar mitzvah.</p><br>
                                        <a href='https://chmd.edu.mx/galeria/' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            } else {
                echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-primary btn-pill mr-3 right">'
                . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a><div style='clear:both'></div>";
                ?>
                <div class="row ">                  
                    <div class="col-sm-12 col-md-10" style='background-color: white;margin:auto'>
                        <br><br>
                        <div id='respon' class='row' style='width:100%;margin:auto'>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/hangout.png' style='width:50%;margin: auto' >
                                    <div class='card-body'> 
                                        <a href='https://hangouts.google.com/' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/calendar.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <a href='https://www.google.com/calendar?tab=mc' class='btn btn-primary'>Entrar</a>                                     
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/classroom.png' style='width:50%;margin: auto' >
                                    <div class='card-body'> 
                                        <a href='http://classroom.google.com/' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/drive.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>

                                        <a href='https://drive.google.com/?tab=mo&authuser=0' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/ebsco.png' style='width:50%;margin: auto'  >
                                    <div class='card-body'>
                                        <a href='http://search.ebscohost.com/login.aspx?authtype=uid&user=maguen&password=ebsco&group=main' class='btn btn-primary'>Entrar</a>
                                    </div>
                                </div>
                            </div> 
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/gmail.png' style='width:50%;margin: auto'>
                                    <div class='card-body mb-3'>
                                        <a href='https://mail.google.com/mail/?tab=mm' class='btn btn-primary'>Entrar</a>                                     
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/moodle.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <a href='http://chmd.chmd.edu.mx:61085/login/index.php' class='btn btn-primary'>Entrar</a>                                     
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/sites.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <a href='https://sites.google.com/?tab=m3' class='btn btn-primary'>Entrar</a>                                                                          
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/colegium.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>
                                        <a href='http://sn3.colegium.com/es_CL/login/alternativo?id=1583E1CHMD-mx.sha1(YobA6ixTNSO2klMq+1).1' class='btn btn-primary'>Entrar</a>                                     
                                    </div>                                     
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-3 mb-3'>
                                <div class='card' style='width: 98%;margin:auto;'>
                                    <img class='card-img-top' src='pics/brainpop.png' style='width:50%;margin: auto' >
                                    <div class='card-body'>                                     
                                        <a href='http://esp.brainpop.com/user/loginDo.weml?user=maguen1&password=biblioteca' class='btn btn-primary'>Entrar</a>                                     
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
            echo 'Este usuario no tiene Acceso:' . $user->email . ',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="' . $redirect_uri . '?logout=1"> Log Out</a>]';
        }
    } else {
        echo 'Error';
    }
}
?><br><br>
</div>
</div>
<?php include './components/layout_bottom.php'; ?>

