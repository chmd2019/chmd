<?php
include './components/layout_top.php';
include './components/sesion.php';

if (isset($authUrl)) {
    //show login url
    ?>
    <div class="caja-login" align="center">
        <h2 class="alert alert-light text-primary text-center" role="alert">Mi Maguen</h2>
        <br><br>
        <?php echo '<a href="' . $authUrl . '"><img src="images/google.png" id="total"/></a>' ?>
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
        <div class="col-sm-12 col-md-9 b-blanco" style="margin:auto;">
            <br><br>
            <?php
            echo '<h2 class="alert alert-light text-primary text-center" role="alert">' . $titulo . '</h2>';
            ?>
            <div class="btn-group mr-3 right" role="group" aria-label="Basic example">
                <a href="index.php" class="btn btn-secondary" ><i class="fas fa-home"></i>&nbsp;Menú inicial</a>
                <?php echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-primary" >'
                . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a>";
                ?>
            </div>
            <div style="clear:both"></div>
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
                        <div class='col-sm-12 col-md-3 mb-3'>
                            <div class='card' style='width: 98%;margin:auto'>
                                <br>
                                <img class='card-img-top' src='<?php echo "pics/$estatuis1/$imagen"; ?>' style='width:50%;margin: auto' >
                                <div class='card-body'>
                                    <p class="card-text"><?php echo "$mensaje" ?></p>    
                                    <a href='<?php echo "$link?idmodulo=$idmodulo&idseccion=$idseccion"; ?>' class='btn btn-primary'>Entrar</a>         
                                </div>
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
    </div>
</div>   
}
?><br><br>
</div>
</div>
<?php include './components/layout_bottom.php'; ?>

