<?php
include './components/layout_top.php';
include './components/navbar.php';
include './components/sesion.php';

if (isset($authUrl)) {
    //show login url
    ?>
    <style>
        body{
            background-image: url('/pruebascd/icloud/pics/body_bg.jpg');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding:0px;
            margin:0px;
            overflow: hidden;
        }
    </style>
    <div class="main" style="overflow: hidden;">
        <div class="caja-login" align="center">
            <h2 class="alert alert-light text-center c-azul" role="alert">Mi Maguen</h2>
            <?php echo '<a href="' . $authUrl . '"><img class="logo-login" src="images/google.png" id="total"/></a>' ?>
        </div>
        <?php
    } else {
        $idseccion = $_GET["idseccion"];
        if ($idseccion == 1) {
            $titulo = "Cambios de transportes";
        }
        if ($idseccion == 5) {
            $titulo = "Datos de facturación";
        }
        ?>
        <h4 class="b-azul c-blanco text-center" style="padding:1rem;margin-top:0px">
            Mi Maguen 
            <?php
            echo $anio_actual;
            ?>
        </h4>
        <!--MENU-->
        <div class="row">
            <br>
            <div class="col s12 m8 l10" style="float:none;margin:auto">
                <?php
                $idseccion = $_GET["idseccion"];
                $user = $service->userinfo->get(); //get user info
                $correo = $user->email;
                require('Model/Login.php');
                $objCliente = new Login();
                $consulta = $objCliente->acceso_login($correo);
                if ($consulta) {
                    if ($cliente = mysqli_fetch_array($consulta)) {
                        
                        $consulta1 = $objCliente->acceso_perfil($correo, $idseccion);
                        $contador = 0;
                        while ($cliente1 = mysqli_fetch_array($consulta1)) {
                            $modulo = $cliente1[0];
                            $link = $cliente1[1];
                            $imagen = $cliente1[2];
                            $idseccion = $cliente1[3];
                            $estatus = $cliente1[4];
                            $idusuario = $cliente1[5];
                            $idmodulo = $cliente1[6];
                            $nfamilia = $cliente1[7];
                            $contador++;
                            if ($estatus == 1) {
                                $estatuis1 = "activos";
                            } else {
                                $estatuis1 = "inactivos";
                            }
                            ?>
                            <div class="col s12 m10 l4">
                                <div class="card" style="box-shadow: none"> 
                                    <div class="card-image waves-effect waves-block waves-light">     
                                        <a href='<?php echo "$link?idmodulo=$idmodulo&idseccion=$idseccion"; ?>'>
                                            <img src="<?php echo "pics/$estatuis1/$imagen"; ?>" style="padding:3rem;">  
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
                            <?php
                        }
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
</div>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul">
        <i class="large material-icons">edit</i>
    </a>
    <ul>
        <li><a class="btn-floating blue" href="index.php"><i class="material-icons">keyboard_backspace</i></a></li>
            <?php
            echo '<li><a href="' . $redirect_uri . '?logout=1" class="btn-floating red" >'
            . "<i class='material-icons'>exit_to_app</i>Salir</a></li>";
            ?>
    </ul>
</div>
<script>
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
    });
</script>
<?php include './components/layout_bottom.php'; ?>

