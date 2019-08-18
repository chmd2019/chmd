<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/components/sesion.php";
include_once "$root_icloud/components/layout_top.php";
$idseccion = $_GET['idseccion'];

if (isset($authUrl)) {
    header("Location: $redirect_uri?logout=1");
} else {
    $user = $service->userinfo->get(); //get user info
    $correo = $user->email;
    require_once './Model/Login.php';
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    $idseccion = $_GET["idseccion"];
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
    <!--MENU-->
    <div class="row"> 
        <div style="text-align: right;margin:1rem 1rem 0 0">   
            <a class="waves-effect waves-light btn b-azul c-blanco" href="index.php">
                <i class="material-icons left">keyboard_backspace</i>Atrás
            </a>                
            <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                <i class="material-icons left">lock</i>Salir
            </a>  
        </div>
        <div class="col s12 m8 l10" style="float:none;margin:auto">
            <?php
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
                        $info = $cliente1[8];
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
                                    <p><?php echo $info;?></p>
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
<?php include './components/layout_bottom.php'; ?>

