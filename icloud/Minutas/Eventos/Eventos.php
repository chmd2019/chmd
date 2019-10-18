<?php
session_start();
$root = dirname(dirname(__DIR__));
require_once "{$root}/components/sesion.php";
require_once "{$root}/libraries/Google/autoload.php";
require_once "{$root}/Model/Login.php";
require_once "{$root}/Model/DBManager.php";
require_once "{$root}/Model/Config.php";
require_once "{$root}/Helpers/DateHelper.php";
include_once "{$root}/components/layout_top.php";
require_once "../common/ControlMinutas.php";

if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
}
$service = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit;
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    $authUrl = $client->createAuthUrl();
}
if (isset($authUrl)) :
    header("Location: $redirect_uri?logout=1");
else :
    $user = $service->userinfo->get();
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    $date_helper = new DateHelper();
    $date_helper->set_timezone();
    $idseccion = $_GET['idseccion'];
    include "{$root}/components/navbar.php";
    ?>
    <div class="row">
        <div class="col s12 l8 border-azul" style="float: none;margin: auto;">
            <br>
            <br>
            <h5 class="col s12 c-azul text-center">Comité: Consejo Directivo</h5> 
            <h6><?php echo $date_helper->fecha_listados(); ?></h6>
            <br>
            <div class="right" style="margin-right: 1rem;">
                <a class="waves-effect waves-light"
                   href="https://www.chmd.edu.mx/pruebascd/icloud/Minutas/menu.php?idseccion=1">
                    <img src='../../images/Atras.svg' style="width: 110px">
                </a>
                <a class="waves-effect waves-light"
                   href="vistas/vista_nuevo_evento.php?idseccion=<?php echo $idseccion; ?>">
                    <img src='../../images/Nuevo.svg' style="width: 110px">
                </a>
            </div>
            <div class="col s12"><br></div>
            <?php
            $controlMinutas = new ControlMinutas();
            $minutas = $controlMinutas->consultar_minutas();
            if (mysqli_num_rows($minutas) > 0):
                ?>            
                <table class="table highlight" id="table">
                    <thead>
                        <tr class="b-azul white-text">
                            <th>Fecha de evento</th>
                            <th>Titulo</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($minutas)):
                        //a.id, a.titulo, a.fecha, a.convocante, b.status, b.color_estatus
                        $id_minuta = $row[0];
                        $titulo = $row[1];
                        $fecha = $row[2];
                        $convocante = $row[3];
                        $estatus = $row[4];
                        $color_estatus = $row[5];
                        ?>
                        <tr style="cursor: pointer;">
                            <td><b><?php echo $fecha; ?></b></td>
                            <td><?php echo $titulo; ?></td>
                            <td>
                                <div class="text-center">
                                    <span class="chip <?php echo $color_estatus; ?> c-blanco"><?php echo $estatus; ?></span>
                                </div>
                            </td>
                            <td>                             
                                <a class="waves-effect waves-light"
                                   href="https://www.chmd.edu.mx/pruebascd/icloud/Minutas/Eventos/vistas/vista_consulta_minuta.php?id_minuta=<?php echo $id_minuta;?>">
                                    <img src='../../images/Ver.svg' style="width: 40px;margin-top: .4rem;">
                                </a>                        
                                <a class="waves-effect waves-light"
                                   href="">
                                    <img src='../../images/Descargar.svg' style="width: 40px;margin-top: .4rem;">
                                </a> 
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </table>
                <script>
                    $('#table').DataTable({
                        "language": {
                            "lengthMenu": "_MENU_",
                            "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
                            "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
                            "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
                            "infoFiltered": "(filtrado de _MAX_ total de registros)",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "paginate": {
                                "first": "Primero",
                                "last": "Último",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        }
                    });
                    $("select").formSelect();
                </script>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>
<?php include "{$root}/components/layout_bottom.php"; ?>