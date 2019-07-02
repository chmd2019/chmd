<?php
include './components/layout_top.php';
include './components/sesion.php';
include './components/navbar.php';

if (isset($authUrl)) {
    //show login url
    ?>
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
    <!--MENU-->
    <div class="row"><br><br>
        <div class="col-sm-12 col-md-9 b-blanco" style="margin:auto; width: 100vw">
            <?php
            echo '<h2 class="alert alert-light  b-azul c-blanco text-center border-azul border-radius-none" role="alert">' . $titulo . '</h2>';
            ?>
            <div class="btn-group right" role="group">
                <a href="index.php" class="btn b-azul white-text" ><i class="fas fa-home"></i>&nbsp;Menú inicial</a>
                <?php
                echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-danger" >'
                . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a>";
                ?>
            </div>
            <br>
            <?php
            $idseccion = $_GET["idseccion"];
            $user = $service->userinfo->get(); //get user info
            $correo = $user->email;
            require('Model/Login.php');
            $objCliente = new Login();
            $consulta = $objCliente->Acceso($correo);
            if ($consulta) {
                if ($cliente = mysqli_fetch_array($consulta)) {
                    $id = $cliente[0];
                    $correo = $cliente[1];
                    $perfil = $cliente[2];
                    $estatus = $cliente[3];
                    ///////////////////////////////////////////
                    $consulta1 = $objCliente->Acceso2($correo, $idseccion);
                    $contador = 0;
                    echo "<div class='row' style='width:100%;margin:auto'>"; //inicio del panel
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
                        <div class='col-sm-12 col-md-3 mb-3 m-auto'>
                            <div class="view p-3 text-center">
                                <img src="<?php echo "pics/$estatuis1/$imagen"; ?>" class="img-fluid p-3 m-auto">
                                <a href='<?php echo "$link?idmodulo=$idmodulo&idseccion=$idseccion"; ?>'>
                                    <div class="mask rgba-white-slight"></div>
                                </a>
                                <button type="button" class="btn b-azul white-text" data-toggle="popover" data-placement="top" title="Información"
                                        data-content="Pedidos de paquete de uniformes incluido en la canasta básica y de uniformes adicionales." >Info</button>
                            </div>
                        </div>                        
                        <?php
                    }
                    echo "</div>"; //fin de panel
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
<?php include './components/layout_bottom.php'; ?>

