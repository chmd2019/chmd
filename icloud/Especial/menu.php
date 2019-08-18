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
        <a class="waves-effect waves-light btn b-azul c-blanco"
           href="<?php echo $redirect_uri; ?>">
            <i class="material-icons left">keyboard_backspace</i>Atrás
        </a>
        <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
            <i class="material-icons left">lock</i>Salir
        </a>
    </div>
    <!--MENU-->
    <div class="row">
        <div class="col s12 m8" style="float:none;margin:auto">
            <?php
            if ($consulta) {
                if ($cliente = mysqli_fetch_array($consulta)) {
                    $familia = $cliente[2];
                    ?>  

                    <div class="col s12 m10 l4">
                        <div class="card" style="box-shadow: none"> 
                            <div class="card-image waves-effect waves-block waves-light">     
                                <a href='Extraordinario/PExtraordinario.php?idseccion=1<?php //echo "$link?idmodulo=$idmodulo&idseccion=$idseccion";         ?>'>
                                    <img src="../pics/activos/extraudinario.png" style="padding:3rem;">  
                                </a>
                            </div>
                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                    INFO
                                </span>      
                            </div>
                            <div class="card-reveal b-azul white-text">
                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                <p>Permisos para salir del Colegio. Deberán solicitarse antes de las 11:30 h. 
                                    Si bien el sistema no permitirá realizar solicitudes para el mismo día después
                                    del horario establecido, sí podrá hacer solicitudes para días posteriores.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m10 l4">
                        <div class="card" style="box-shadow: none"> 
                            <div class="card-image waves-effect waves-block waves-light">     
                                <a href='Eventos/PEventos.php<?php //echo "$link?idmodulo=$idmodulo&idseccion=$idseccion";         ?>'>
                                    <img src="../pics/activos/especial.png" style="padding:3rem;">  
                                </a>
                            </div>
                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                    INFO
                                </span>      
                            </div>
                            <div class="card-reveal b-azul white-text">
                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                <p>Genera tu evento</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m10 l4">
                        <div class="card" style="box-shadow: none"> 
                            <div class="card-image waves-effect waves-block waves-light">     
                                <a href='#!' onclick="abrir_modal_consultar_codigo()">
                                    <img src="../pics/activos/ingresa_tu_codigo.png" style="padding:3rem;">  
                                </a>
                            </div>
                            <div class="card-content text-center" style="padding:0px;margin-top: -15px">
                                <span class="activator waves-effect waves-light btn b-azul c-blanco">
                                    INFO
                                </span>      
                            </div>
                            <div class="card-reveal b-azul white-text">
                                <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                                <p>Gestiona el permiso de asistencia de tu hijo(a) a algún evento.</p>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo 'Este usuario no tiene Acceso:' . $user->email . ',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="' . $redirect_uri . '?logout=1"> Log Out</a>]';
                }
            } 
            else {
                echo 'Error en cosulta';
            }
        }
        ?>
        <br>
        <br>
    </div>
</div> 

<?php include "$root_icloud/Especial/Codigo/modales/consultar_codigo.php"; ?>
    
<script>
    
    $(document).ready(function(){  
        $('.modal').modal();      
    });
    
    function abrir_modal_consultar_codigo(){
        var consultar_codigo = M.Modal.getInstance(document.getElementById("modal_consultar_codigo"));  
        consultar_codigo.open();
    }

</script>    
    
<?php include "$root_icloud/components/layout_bottom.php"; ?>
