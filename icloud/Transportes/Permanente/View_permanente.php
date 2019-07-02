<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Transportes/common/ControlTransportes.php";
$idseccion = $_GET['idseccion'];
$user = $service->userinfo->get(); //get user info
$correo = $user->email;
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);
//zona horaria para America/Mexico_city
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Helpers/DateHelper.php";
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m/d/Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";
$consulta = mysqli_fetch_array($consulta);
$familia = str_pad($consulta[4], 4, 0, STR_PAD_LEFT);
$dias = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
?>

<br>
<div>
    <span>
        <h6 class=""><?php echo $fecha_actual_impresa_script; ?></h6>
    </span>

    <?php
    $control_permanente = new ControlTransportes();
    $listado_permiso_permanente = $control_permanente->listado_permiso_permanente($familia);
    $contador = mysqli_num_rows($listado_permiso_permanente);
    if ($contador == 0) {
        ?>
        <br>
        <span class="badge blue c-blanco col s12">Sin permisos para mostrar</span>
        <?php
    } else {
        ?>
        <br>
        <!--Pinta solo el encabezado de la tabla-->
        <table class="highlight">
            <thead>
                <tr class="b-azul white-text">
                    <th scope="col">Dias del permiso</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                while ($permiso = mysqli_fetch_array($listado_permiso_permanente)) {
                    $id_permiso = $permiso[0];
                    $lunes = $permiso[1];
                    $martes = $permiso[2];
                    $miercoles = $permiso[3];
                    $jueves = $permiso[4];
                    $viernes = $permiso[5];
                    $nfamilia = $permiso[6];
                    $estatus = $permiso[7];
                    $tipo_permiso = 3;
                    if ($estatus == 1) {
                        $status_detalle = "Pendiente";
                        $badge = "badge blue c-blanco";
                    }
                    if ($estatus == 2) {
                        $status_detalle = "Autorizado";
                        $badge = "badge green c-blanco";
                    }
                    if ($estatus == 3) {
                        $status_detalle = "Declinado";
                        $badge = "badge orange c-blanco";
                    }
                    if ($estatus == 4) {
                        $status_detalle = "Cancelado por usuario";
                        $badge = "badge red c-blanco";
                    }
                    //oculta boton de cancelar de acuerdi a condiciones de hora limite, status
                    $ver_btn_cancelar = "";
                    if ($objDateHelper->obtener_hora_limite() || $estatus != 1) {
                        $ver_btn_cancelar = "d-none";
                    }
                    //formato para mostrar dias del permiso
                    $lunes = $lunes == "0" ? "" : $lunes;
                    $martes = $martes == "0" ? "" : " $martes";
                    $miercoles = $miercoles == "0" ? "" : " $miercoles";
                    $jueves = $jueves == "0" ? "" : " $jueves";
                    $viernes = $viernes == "0" ? "" : " $viernes";
                    ?>
                    <tr style="cursor:pointer;">
                        <th scope="row"><?php echo "$lunes$martes$miercoles$jueves$viernes "; ?></th>
                        <td><span class="<?php echo $badge; ?>"><?php echo $status_detalle; ?></span></td>
                        <td>   
                            <div class="row">
                                <div class="col s12 l3">  
                                    <a class="waves-effect waves-light btn green accent-3" 
                                       href="https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Permanente/vistas/vista_consulta_permiso_permanente.php?id=<?php echo $id_permiso; ?>&&tipo_permiso=3&&idseccion=<?php echo $idseccion; ?>">
                                        <i class="material-icons">pageview</i>
                                    </a>
                                </div>
                                &nbsp;
                                <div class="col s12 l3">
                                    <?php include './modales/modal_cancelar_permiso.php'; ?>
                                </div>                                    
                            </div>
                        </td>
                    </tr> 
                    <?php
                }
            }
            ?>
        </tbody>
    </table>    
</div>
<br>
<br>