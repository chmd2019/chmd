<?php
$root = dirname(dirname(__DIR__));
require "{$root}/Circulares/common/ControlCirculares.php";
include "{$root}/Persistence/session.php";
$control_circulares = new ControlCirculares();
$id_circular = $_GET['id_circular'];
$circular = mysqli_fetch_assoc($control_circulares->select_circular($id_circular));
//variables de conteo tabla padres
$count_padres = 0;
$count_leidos = 0;
$count_no_leidos = 0;
$favoritos = 0;
$eliminados = 0;
$notificados = 0;
$no_notificados = 0;
//variables de conteo tabla administrativos
$count_adm = 0;
$count_leidos_adm = 0;
$count_no_leidos_adm = 0;
$favoritos_adm = 0;
$eliminados_adm = 0;
$notificados_adm = 0;
$no_notificados_adm = 0;
//url para botón atrás
$url_btn_atras = "https://" . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['REQUEST_URI'])) . "/Circulares.php";
//consulta de estatus para validar eliminados
$id_estatus = $circular['id_estatus'];
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <?php include "{$root}/Secciones/head.php"; ?>
        <title>Circulares</title>
    </head>

    <body style="font-size: .85rem;">        
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav class="navbar" id="sidebar">
                <div id="dismiss">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="sidebar-header">
                    <h3 class="text-white">APP</h3>
                </div>
                <?php
                $perfil_actual = '40';
                include "{$root}/menus_dinamicos/perfiles_dinamicos_app.php";
                ?>
            </nav>
            <div id="content" style="overflow: hidden">
                <?php include "{$root}/components/navbar.php"; ?>
                <div class="p-3">
                    <div class="masthead">

                    </div>
                    <center>
                        <?php echo isset($_POST['guardar']) ? $verificar : ''; ?>
                    </center>
                    <a href="<?= $url_btn_atras; ?>" 
                       class="btn btn-info btn-squared float-right">
                        <i class="fas fa-arrow-left"></i>&nbsp; Atrás
                    </a>
                    <div class="clearfix"></div>
                    <br>
                    <?php if ($id_estatus == 4): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle"></i>&nbsp;¡La circular ha sido eliminada!
                        </div>
                    <?php endif; ?>
                    <div>
                        <div>
                            <div class="border rounded p-4">
                                <div class="row">
                                    <div class="col-sm-6 border-right">
                                        <h4 class="card-title text-primary">Información general de la circular</h4>
                                        <hr>
                                        <div class="form-group col-sm-12">
                                            <div class="input-group">
                                                <span class="badge badge-pill badge-info">
                                                    <i class="material-icons">calendar_today</i> 
                                                    &nbsp;&nbsp;Ciclo escolar: <?= $circular['ciclo']; ?>
                                                </span>
                                                &nbsp;&nbsp;&nbsp;
                                                <span class="badge badge-pill badge-<?= $circular['color']; ?>">
                                                    <i class="material-icons">info</i> 
                                                    &nbsp;&nbsp;<?= $circular['estatus']; ?>
                                                </span>
                                            </div>
                                        </div> 
                                        <div class="form-group col-sm-12">
                                            <label>Título</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-bookmark"></i></span>
                                                </div>
                                                <input type="text"
                                                       class="form-control text-uppercase" 
                                                       style="cursor: text;"
                                                       value="<?= $circular['titulo']; ?>"
                                                       readonly>
                                            </div>
                                        </div> 
                                        <div class="form-group col-sm-12">
                                            <label>Descripción</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-bookmark"></i></span>
                                                </div>
                                                <textarea type="text"
                                                          class="form-control text-uppercase" 
                                                          style="cursor: text;"
                                                          readonly><?= $circular['descripcion']; ?></textarea>
                                            </div>
                                        </div>                                             
                                        <?php if ($circular['id_estatus'] == 3): ?>
                                            <div class="form-group float-right">     
                                                <a href="#!" 
                                                   class="btn btn-primary btn-squared"
                                                   data-toggle="modal" data-target="#modal_enviar">
                                                    &nbsp;Enviar
                                                    <i class="material-icons">mail</i>
                                                </a>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal_enviar" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-warning">
                                                                <i class="material-icons">help</i>
                                                                &nbsp;Aviso importante
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Está seguro(a) de enviar la circular?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-squared" 
                                                                    data-dismiss="modal">
                                                                <i class="material-icons">cancel</i>
                                                                &nbsp;Cancelar
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-primary btn-squared"
                                                                    onclick="enviar(2, <?= $id_circular; ?>)">
                                                                Ok
                                                                &nbsp;<i class="material-icons">done</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <span class="clearfix"></span>
                                    </div>

                                    <?php if ($circular['contenido'] != '<p><br></p>'): ?>
                                        <article class="col-sm-6">
                                            <h4 class="text-primary">Contenido</h4>
                                            <hr>
                                            <?= $circular['contenido']; ?>
                                        </article>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <br><br>
                        </div>
                        <h3 class="text-primary">Totales</h3>
                        <div class="p-4">
                            <table class="table table-striped table-bordered" id="table_global">
                                <tbody>
                                    <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th>Leidos</th>
                                        <th>No leidos</th>
                                        <th>Favoritos</th>
                                        <th>Eliminadas</th>
                                        <th>Notificaciones Enviadas</th>
                                        <th>Notificaciones No Enviadas</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        $consulta_usuarios = $control_circulares->select_usuarios_circular($id_circular);
                        if (mysqli_num_rows($consulta_usuarios) > 0):
                            ?>
                            <h3 class="text-primary">Usuarios </h3>
                            <table class="table-striped table-bordered" id="id_table_usuario">
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="p-1">ID</th>
                                        <th class="p-1">Usuario</th>				
                                        <th class="p-1">Leído</th>
                                        <th class="p-1">Favorito</th>
                                        <th class="p-1">Eliminada</th>
                                        <th class="p-1">Notificacion Enviada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($consulta_usuarios)):
                                        $id = $row[0];
                                        $usuario = $row[1];
                                        $leido = $row[2] == FALSE ? 'No' : 'SI';
                                        $favorito = $row[3] == FALSE ? 'No' : 'SI';
                                        $eliminado = $row[4] == FALSE ? 'No' : 'SI';
                                        $notificacion = $row[5] == FALSE ? 'No' : 'SI';
                                        ?>
                                        <tr>                                    
                                            <td> <?= $id; ?></td>
                                            <td> <?= strtoupper($usuario); ?></td>
                                            <td> <?= $leido; ?></td>
                                            <td> <?= $favorito; ?></td>
                                            <td> <?= $eliminado; ?></td>
                                            <td> <?= $notificacion; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <?php
                        endif;
                        $consulta_padres_nivel = $control_circulares->select_padres($id_circular);
                        if (mysqli_num_rows($consulta_padres_nivel) > 0):
                            ?>
                            <br>
                            <br>
                            <h3 class="text-primary">Padres</h3>
                            <table class="table-striped table-bordered" id="id_table_padres_nivel">
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="p-1">ID Padre</th>
                                        <th class="p-1">Padre</th>				
                                        <th class="p-1">Parentesco</th>		
                                        <th class="p-1">Leído</th>
                                        <th class="p-1">Favorito</th>
                                        <th class="p-1">Eliminada</th>
                                        <th class="p-1">Notificacion Enviada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($consulta_padres_nivel)):
                                        $count_padres++;
                                        $id_padre = $row['id_usuario'];
                                        $padre = $row['padre'];
                                        $parentesco = $row['parentesco'];
                                        $leido = $row['leido'] == FALSE ? 'No' : 'SÍ';
                                        $favorito = $row['favorito'] == FALSE ? 'No' : 'SÍ';
                                        $eliminado = $row['eliminado'] == FALSE ? 'No' : 'SÍ';
                                        $notificacion = $row['notificado'] == FALSE ? 'No' : 'SÍ';
                                        //conteo de leidos, favoritos, eliminados y notificados
                                        if ($row['leido'] == TRUE) {
                                            $count_leidos++;
                                        } else {
                                            $count_no_leidos++;
                                        }
                                        if ($row['eliminado'] == TRUE) {
                                            $eliminados++;
                                        }
                                        if ($row['favorito'] == TRUE) {
                                            $favoritos++;
                                        }
                                        if ($row['notificado'] == TRUE) {
                                            $notificados++;
                                        } else {
                                            $no_notificados++;
                                        }
                                        ?>
                                        <tr>                                    
                                            <td> <?= $id_padre; ?></td>         
                                            <td> <?= $padre; ?></td>             
                                            <td> <?= $parentesco; ?></td>    
                                            <td> <?= $leido; ?></td>
                                            <td> <?= $favorito; ?></td>
                                            <td> <?= $eliminado; ?></td>
                                            <td> <?= $notificacion; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <?php
                        endif;
                        $consulta_adm = $control_circulares->select_administrativos($id_circular);
                        if (mysqli_num_rows($consulta_adm) > 0):
                            ?>
                            <br>
                            <br>
                            <h3 class="text-primary">Administrativos</h3>
                            <table class="table-striped table-bordered" id="id_table_adm">
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="p-1">ID</th>
                                        <th class="p-1">Grupo</th>
                                        <th class="p-1">Administrativo</th>				
                                        <th class="p-1">Leído</th>
                                        <th class="p-1">Favorito</th>
                                        <th class="p-1">Eliminada</th>
                                        <th class="p-1">Notificacion Enviada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($consulta_adm)):
                                        $count_adm++;
                                        $id = $row[0];
                                        $grupo = $row[1];
                                        $adm = $row[2];
                                        $leido = $row[3] == FALSE ? 'No' : 'SI';
                                        $favorito = $row[4] == FALSE ? 'No' : 'SI';
                                        $eliminado = $row[5] == FALSE ? 'No' : 'SI';
                                        $notificacion = $row[6] == FALSE ? 'No' : 'SI';
                                        //conteo de leidos, favoritos, eliminados y notificados
                                        if ($row[3] == TRUE) {
                                            $count_leidos_adm++;
                                        } else {
                                            $count_no_leidos_adm++;
                                        }
                                        if ($row[5] == TRUE) {
                                            $eliminados_adm++;
                                        }
                                        if ($row[4] == TRUE) {
                                            $favoritos_adm++;
                                        }
                                        if ($row[6] == TRUE) {
                                            $notificados_adm++;
                                        } else {
                                            $no_notificados_adm++;
                                        }
                                        ?>
                                        <tr>                                    
                                            <td> <?= $id; ?></td>
                                            <td> <?= $grupo; ?></td>
                                            <td> <?= $adm; ?></td>
                                            <td> <?= $leido; ?></td>
                                            <td> <?= $favorito; ?></td>
                                            <td> <?= $eliminado; ?></td>
                                            <td> <?= $notificacion; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Site footer -->
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <?php
                include "{$root}/Secciones/scripts.php";
                include "{$root}/components/footer.php";
                ?>
            </div>
            <div class="overlay"></div>
        </div>

        <?php
        include "{$root}/Secciones/spinner.php";
        include "{$root}/Secciones/notificaciones.php";
        ?>

        <script type="text/javascript">
            $(document).ready(function () {
                spinnerOut();
                set_table_desordenada('id_table_padres');
                set_table_desordenada('id_table_adm');
                set_table_desordenada('id_table_usuario');
                set_table_desordenada('id_table_padres_nivel');
                set_menu_hamburguer();

                var count_padres = <?= $count_padres; ?>;
                var count_leidos = <?= $count_leidos; ?>;
                var count_no_leidos = <?= $count_no_leidos; ?>;
                var favoritos = <?= $favoritos; ?>;
                var eliminados = <?= $eliminados; ?>;
                var notificados = <?= $notificados; ?>;
                var no_notificados = <?= $no_notificados; ?>;

                var count_adm = <?= $count_adm; ?>;
                var count_leidos_adm = <?= $count_leidos_adm; ?>;
                var count_no_leidos_adm = <?= $count_no_leidos_adm; ?>;
                var favoritos_adm = <?= $favoritos_adm; ?>;
                var eliminados_adm = <?= $eliminados_adm; ?>;
                var notificados_adm = <?= $notificados_adm; ?>;
                var no_notificados_adm = <?= $no_notificados_adm; ?>;
                var thead = `<tr>
                                <td>Padres</td>
                                <td>${count_padres}</td>
                                <td>${count_leidos}</td>
                                <td>${count_no_leidos}</td>
                                <td>${favoritos}</td>
                                <td>${eliminados}</td>
                                <td>${notificados}</td>
                                <td>${no_notificados}</td>
                            </tr>
                                <tr>
                                <td>Administrativos</td>
                                <td>${count_adm}</td>
                                <td>${count_leidos_adm}</td>
                                <td>${count_no_leidos_adm}</td>
                                <td>${favoritos_adm}</td>
                                <td>${eliminados_adm}</td>
                                <td>${notificados_adm}</td>
                                <td>${no_notificados_adm}</td>
                            </tr>`;
                $("#table_global").append(thead);
            });

            function enviar(estatus, id_circular) {
                $.ajax({
                    url: '/pruebascd/admin/app/Circulares/common/post_actualizar_estatus_circular.php',
                    type: 'POST',
                    beforeSend: () => {
                        spinnerIn();
                        $("#btn_enviar").prop("disabled", true);
                    },
                    dataType: 'json',
                    data: {estatus: estatus, id_circular: id_circular}
                }).done((res) => {
                    if (res === true) {
                        success_alerta('Solicitud exitosa');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        fail_alerta('¡Solicitud no realizada!');
                    }
                }).always(() => spinnerOut());
            }
        </script>
    </body>

</html>