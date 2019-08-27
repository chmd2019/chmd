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
                                                <p>Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales.</p>
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
                                                <p>Generar permisos extraordinarios, cumpleaños y Bar Mitzvá.</p>
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
                                            <a href='Eventos/menu.php'>
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
                                        <img src="https://www.chmd.edu.mx/pruebascd/icloud/pics/activos/party.svg"
                                             style="padding:3rem;width: 70%;margin: auto">
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
            } elseif ($tipo == 8) {
                ?>

                    <div style="text-align: right;margin:1rem 1rem 0 0">
                        <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                            <i class="material-icons left">lock</i>Salir
                        </a>
                    </div>

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
                                            <a href='Eventos/menu.php'>
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
                                            <p>Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card" style="box-shadow: none">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='Eventos/menu.php '>
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
                                    <div class="card" style="box-shadow: none;">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <a href='Evento/menu.php'>
                                                <img src="https://www.chmd.edu.mx/pruebascd/icloud/pics/activos/party.svg"
                                                     style="padding:3rem;width: 85%;margin: auto">
                                            </a>
                                        </div>
                                        <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
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
                                            <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                                INFO
                                            </span>
                                        </div>
                                        <div class="card-reveal b-azul white-text">
                                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                            <p>Generar permisos extraordinarios, cumpleaños y Bar Mitzvá.</p>
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
                '</span><br> ¡Favor de comunicarse para validar datos!  '
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
