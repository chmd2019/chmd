<?php
include 'sesion_admin.php';
include 'conexion.php';

if (in_array('13', $capacidades)) {
    //redireccionar al menu de Seguridad
    header('Location: seguridad/menu_seguridad.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="img/favicon.png">
        <title>CHMD :: Menu</title>
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link href="css/menu.css" rel="stylesheet">

        <!-- Dependencias Globales -->
        <?php include 'components/header.php'; ?>

    </head>

    <body>
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav class="" id="sidebar">
                <div id="dismiss">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="sidebar-header">
                    <h3>EVENTOS</h3>
                </div>
                <?php
                $perfil_actual = '-1';
                include ('./menus_dinamicos/perfiles_dinamicos_main.php');
                ?>

            </nav>

            <!-- Page Content  -->
            <div id="content">

                <?php
                $seccion = 'menu';
                include_once "components/navbar.php";
                ?>
                <div class="container">
                    <div class="row" style="margin-top:60px">
                        <?php
                        if (in_array('0', $capacidades)) {
                            ?>
                            <!-- <div class="col-lg-6" style="margin-bottom:30px"> -->
                              <!-- <center> -->
                            <!-- <a href="transportes/PDiario.php"> -->
                            <!-- <button style="width:100%;height:150px;font-size: xx-large;border-radius: 10px;" class="btn btn-large btn-primary" type="button">Solicitudes</button> -->
                            <!-- </a> -->
                            <!-- </center> -->
                            <!-- </div> -->
                            <?php
                        }
                        if (in_array('1', $capacidades)) {
                            //seccion de Transportes
                            ?>
                            <div class="col-lg-6" style="margin-bottom:30px">
                                <center>
                                    <a href="transportes/PDiario.php">
                                        <button style="width:100%;height:150px;font-size: xx-large;border-radius: 10px;" class="btn btn-large btn-primary" type="button">Transportes</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        }
                        if (in_array('2', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="transportes/choferes/PChoferes.php">
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">Choferes</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        }
                        if (in_array('3', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="extraordinario/PextraordinarioKinder.php" >
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">Extraordinario</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        } if (in_array('4', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="eventos/Peventos.php">
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">Eventos</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        } if (in_array('26', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="eventosInternos/PeventosInternosKin.php">
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">Internos</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        }

                        if (in_array('12', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="seguridad/menu_seguridad.php">
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">Seguridad</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        }

                        if (in_array('25', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="emergencias/Pemergencia.php">
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">Emergencias</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        }

                        if (in_array('31', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="app/Ppadres.php">
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">App</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        }
                        if (in_array('32', $capacidades)) {
                            ?>
                            <div class="col-lg-6 justify-self-center" style="margin-bottom:30px">
                                <center>
                                    <a href="rutas/Prutas_diaria.php">
                                        <button style="width:100%;height:150px;font-size: xx-large; border-radius: 10px;" class="btn btn-large btn-primary" type="button">Rutas</button>
                                    </a>
                                </center>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Site footer -->
                <?php include_once "components/footer.php"; ?>
            </div>
            <div class="overlay"></div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script type="text/javascript" src="dist/js/bootstrap.js"></script>
        <!-- jQuery Custom Scroller CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#dismiss, .overlay').on('click', function () {
                    $('#sidebar').removeClass('active');
                    $('.overlay').removeClass('active');
                });

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').addClass('active');
                    $('.overlay').addClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            });
        </script>
    </body>
</html>
