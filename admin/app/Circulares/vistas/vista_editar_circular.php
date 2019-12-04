<?php
$root = dirname(dirname(__DIR__));
require "{$root}/Circulares/common/ControlCirculares.php";
include "{$root}/Persistence/session.php";
$control_circulares = new ControlCirculares();
$consulta_grados = $control_circulares->select_catalogo_grado();
$consulta_grupos = $control_circulares->select_catalogo_grupos();
$id_circular = $_GET['id_circular'];
$grados_json = json_encode($grados_json);
$grupos_json = json_encode($grupos_json);
$circular = mysqli_fetch_assoc($control_circulares->select_circular($_GET['id_circular']));
$titulo = $circular['titulo'];
$descripcion = $circular['descripcion'];
$contenido = $circular['contenido'];
$estatus = $circular['estatus'];
$color = $circular['color'];
$id_estatus = $circular['id_estatus'];
//url para botón atrás
$url_btn_atras = "https://" . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['REQUEST_URI'])) . "/Circulares.php";
$consulta_niveles_edicion = $control_circulares->select_niveles_edicion($id_circular);
$aux_niveles = array();
foreach ($consulta_niveles_edicion as $value) {
    array_push($aux_niveles, [
        "id_nivel" => $value['id_nivel'],
        "nivel" => $value['nivel'],
        "id_grado" => $value['id_grado'],
        "grado" => $value['grado'],
        "id_grupo" => $value['id_grupo'],
        "grupo" => $value['grupo']
            ]
    );
    
}
$aux_niveles = json_encode($aux_niveles);
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
                    <div class="p-4">
                        <div class="alert alert-warning m-auto" role="alert">
                            <span>
                                <i class="material-icons">warning</i>
                                &nbsp;&nbsp;Edición de la circular &quot;<?= $titulo; ?>&quot;
                            </span>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="card col-sm-12 col-md-7 border panel-personalizado">
                            <div class="card-body p-0 pt-3">
                                <pre><?= $aux_niveles; ?></pre>
                                <h6 class="text-primary border-bottom">
                                    <i class="material-icons">chat_bubble</i>&nbsp;&nbsp;CIRCULAR (EDICIÓN)
                                </h6>
                                <br>
                                <form id="post_nuevo_administrativo"
                                      action="/pruebascd/admin/app/Circulares/common/post_nueva_circular.php" 
                                      class="needs-validation" novalidate>
                                    <div class="form-group col-md-6">
                                        <label>Título</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-bookmark"></i></span>
                                            </div>
                                            <input type="text"
                                                   value="<?= $titulo ?>"
                                                   id="input_titulo"
                                                   name="titulo"
                                                   class="form-control text-uppercase" 
                                                   placeholder="Título"
                                                   autocomplete="off"
                                                   autofocus
                                                   required>
                                        </div>
                                    </div>                
                                    <div class="form-group col-md-6">
                                        <label>Descripción</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-book-open"></i></span>
                                            </div>
                                            <input type="text"
                                                   value="<?= $descripcion ?>"
                                                   id="input_descripcion"
                                                   name="descripcion"
                                                   class="form-control text-uppercase" 
                                                   placeholder="Descripción"
                                                   autocomplete="off">
                                        </div>
                                    </div>       
                                    <div class="col-sm-12 col-md-6" hidden>
                                        <label>Estatus</label>
                                        <br>
                                        <select class="selectpicker form-control text-uppercase" 
                                                id="select_estatus"
                                                title="Seleccione estatus"
                                                name="estatus">
                                                    <?php
                                                    $consulta_catalogo_estatus = $control_circulares->select_catalogo_estatus();
                                                    while ($row = mysqli_fetch_array($consulta_catalogo_estatus)):
                                                        $id_estatus = $row[0];
                                                        $descripcion_estatus = $row[1];
                                                        $color_estatus = $row[2];
                                                        ?>
                                                <option value="<?php echo $id_estatus; ?>"><?php echo $descripcion_estatus; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            ¡Selecciona un estatus válido!
                                        </div>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <h5 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Selección de grupos y usuarios</h5>
                                    <hr>                
                                    <div class="row col-sm-12 justify-content-start">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" 
                                                   class="custom-control-input" 
                                                   id="check_enviar_todos"
                                                   name="enviar_todos"
                                                   onchange="chk_enviar_todos(this.checked);">
                                            <label class="custom-control-label" for="check_enviar_todos">Enviar a todos</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Usuarios</label>
                                        <br>
                                        <select class="selectpicker text-uppercase" 
                                                id="select_usuarios"
                                                title="Seleccione usuario"
                                                name="usuarios"
                                                data-live-search="true"
                                                multiple
                                                data-actions-box="true">
                                                    <?php
// id, nombre, numero, correo
                                                    $consulta_usuarios = $control_circulares->select_usuarios();
                                                    while ($row = mysqli_fetch_array($consulta_usuarios)):
                                                        $id = $row[0];
                                                        $nombre = $row[1];
                                                        $numero = $row[2];
                                                        $correo = $row[3];
                                                        ?>
                                                <option value="<?= $id; ?>"><?= $nombre; ?></option>
                                                <?php
                                            endwhile;
                                            ?>
                                        </select>
                                        <button type="button" 
                                                class="btn btn-primary" 
                                                data-toggle="modal" 
                                                data-target="#modal_usuarios"
                                                onclick="add_usuarios_table();">
                                            <i class="material-icons">search</i>
                                        </button>
                                        <div class="modal fade" id="modal_usuarios" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg p-0" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-primary">Usuarios</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body p-1">
                                                        <br>
                                                        <table class="stripe row-border order-column" id="id_table_usuarios">
                                                            <thead>
                                                                <tr>
                                                                    <th>Usuarios</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                            Ok &nbsp;&nbsp;<i class="material-icons right">done</i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="row col-sm-12 justify-content-between">
                                        <div class="">
                                            <label>Nivel</label>
                                            <br>
                                            <select class="selectpicker form-control text-uppercase" 
                                                    title="Seleccione nivel" 
                                                    onchange="setGrado(this.value)"
                                                    id="select_nivel">
                                                        <?php
                                                        $consulta_catalogo_nivel = $control_circulares->select_catalogo_nivel();
                                                        while ($row = mysqli_fetch_array($consulta_catalogo_nivel)):
                                                            $id_nivel = $row[0];
                                                            $descripcion_nivel = $row[1];
                                                            ?>
                                                    <option value="<?php echo $id_nivel; ?>"><?php echo $descripcion_nivel; ?></option>
                                                    <?php
                                                endwhile;
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                ¡Seleccione un nivel válido!
                                            </div>
                                        </div>
                                        <div class="">
                                            <label>Grado</label>
                                            <br>
                                            <select class="selectpicker text-uppercase" 
                                                    title="Seleccione grado" 
                                                    id="select_grado"
                                                    data-live-search="true"
                                                    onchange="setGrupo(this.value)"></select>
                                        </div>
                                        <div class="">
                                            <label>Grupo</label>
                                            <br>
                                            <select class="selectpicker text-uppercase" 
                                                    title="Seleccione grupo" 
                                                    data-live-search="true"
                                                    id="select_grupo"></select>
                                        </div>
                                        <div>
                                            <label>&nbsp;</label>
                                            <br>
                                            <button type="button" class="btn btn-success btn-squared" onclick="add_nivel();">
                                                Agregar &nbsp;&nbsp;<i class="material-icons">add</i>
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row justify-content-start col-sm-12">                    
                                        <div>
                                            <label>Grupos especiales</label>
                                            <br>
                                            <select class="selectpicker text-uppercase" 
                                                    id="select_grupos_especiales"
                                                    title="Seleccione grupo especial"
                                                    data-live-search="true"
                                                    data-actions-box="true"
                                                    multiple
                                                    onchange="add_grupo_especial_table();">
                                                        <?php
                                                        $consulta_grupos_especiales = $control_circulares->select_grupos_especiales();
                                                        while ($row = mysqli_fetch_array($consulta_grupos_especiales)):
                                                            $id_grupo = $row[0];
                                                            $grupo = $row[1];
                                                            ?>
                                                    <option value="<?= $id_grupo; ?>"><?= $grupo; ?></option>
                                                    <?php
                                                endwhile;
                                                ?>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;
                                        <div>
                                            <label>Grupos administrativos</label>
                                            <br>
                                            <select class="selectpicker text-uppercase" 
                                                    id="select_grupos_administrativos"
                                                    title="Seleccione grupo administrativo"
                                                    data-live-search="true"
                                                    data-actions-box="true"
                                                    multiple
                                                    onchange="add_grupos_administrativos_table();">
                                                        <?php
                                                        $consulta_grupos_administrativos = $control_circulares->select_grupos_administrativos();
                                                        while ($row = mysqli_fetch_array($consulta_grupos_administrativos)):
                                                            $id_grupo_adm = $row[0];
                                                            $grupo_adm = $row[1];
                                                            ?>
                                                    <option value="<?= $id_grupo_adm; ?>"><?= $grupo_adm; ?></option>
                                                    <?php
                                                endwhile;
                                                ?>
                                            </select>
                                        </div>
                                        <span class="col-sm-12"><br></span>                     
                                        <div>
                                            <label>Camiones (Mañana)</label>
                                            <br>
                                            <select class="selectpicker"
                                                    id="id_select_camiones"
                                                    title="Seleccione camiones"
                                                    data-live-search="true"
                                                    data-actions-box="true"
                                                    onchange="add_camiones();"
                                                    multiple>
                                                        <?php
                                                        $consulta_camiones = $control_circulares->select_camiones('2019-11-16');
                                                        $consulta_padres = $control_circulares->select_alumnos_ruta('2019-11-16');
                                                        $padres_camiones = array();
                                                        while ($row = mysqli_fetch_assoc($consulta_padres)):
                                                            array_push($padres_camiones, [
                                                                "id_ruta" => $row['id_ruta_h'],
                                                                "id_alumno" => $row['id_alumno'],
                                                                "id_papa" => $row['id_papa'],
                                                                "camion" => $row['camion'],
                                                                "nombre_ruta" => $row['nombre_ruta']
                                                            ]);
                                                        endwhile;
                                                        $padres_camiones = json_encode($padres_camiones);
                                                        while ($row = mysqli_fetch_assoc($consulta_camiones)):
                                                            ?>
                                                    <option value="<?= $row['id_ruta_h']; ?>">
                                                        Camión: <?= str_pad($row['camion'], 2, "0", STR_PAD_LEFT); ?> | Ruta: <?= $row['nombre_ruta']; ?>
                                                    </option>
                                                <?php endwhile; ?>   
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;
                                        <div>
                                            <label>Camiones (Tarde)</label>
                                            <br>
                                            <select class="selectpicker"
                                                    id="id_select_camiones_tarde"
                                                    title="Seleccione camiones"
                                                    data-live-search="true"
                                                    data-actions-box="true"
                                                    onchange="add_camiones_tarde();"
                                                    multiple>
                                                        <?php
                                                        $consulta_camiones_tarde = $control_circulares->select_camiones_tarde('2019-11-16');
                                                        $consulta_padres_tarde = $control_circulares->select_alumnos_ruta_tarde('2019-11-16');
                                                        $padres_camiones_tarde = array();
                                                        while ($row = mysqli_fetch_assoc($consulta_padres_tarde)):
                                                            array_push($padres_camiones_tarde, [
                                                                "id_ruta" => $row['id_ruta_h_s'],
                                                                "id_alumno" => $row['id_alumno'],
                                                                "id_papa" => $row['id_papa'],
                                                                "camion" => $row['camion'],
                                                                "nombre_ruta" => $row['nombre_ruta']
                                                            ]);
                                                        endwhile;
                                                        $padres_camiones_tarde = json_encode($padres_camiones_tarde);
                                                        while ($row = mysqli_fetch_assoc($consulta_camiones_tarde)):
                                                            ?>
                                                    <option value="<?= $row['id_ruta_h_s']; ?>">
                                                        Camión: <?= str_pad($row['camion'], 2, "0", STR_PAD_LEFT); ?> | Ruta: <?= $row['nombre_ruta']; ?>
                                                    </option>
                                                <?php endwhile; ?>   
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <h5 class="text-primary"><i class="material-icons">info</i>&nbsp;&nbsp;Información adicional</h5>
                                    <hr>
                                    <div class="form-row">
                                        <br>
                                    </div>                 
                                    <div id="editor"></div>
                                    <span class="col-md-12"><hr></span>
                                    <button class="btn btn-primary" type="submit" id="btn_enviar">
                                        Enviar &nbsp;&nbsp;<i class="material-icons">send</i>
                                    </button>
                                    <!-- Trigger -->
                                    <button type="button" 
                                            class="btn btn-primary" 
                                            data-toggle="modal" 
                                            data-target="#modal_programar_para">
                                        Programar
                                        <i class="material-icons right">alarm</i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal_programar_para" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Programar circular</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Programar para </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                                            </div>
                                                            <input type="text" 
                                                                   name="fecha_programada"
                                                                   class="form-control" 
                                                                   placeholder="Escoja fecha..."
                                                                   autocomplete="off"
                                                                   id="id_fecha_programada" 
                                                                   onkeypress="blur();">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        <i class="material-icons left">highlight_off</i>&nbsp;&nbsp;Cancelar
                                                    </button>
                                                    <button type="button" class="btn btn-primary">Ok 
                                                        &nbsp;&nbsp;<i class="material-icons right">done</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <br>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card col-sm-12 col-md-4 border panel-personalizado">
                            <div class="card-body p-0 pt-3">
                                <h6 class="text-primary border-bottom">
                                    <i class="material-icons">add_box</i>&nbsp;
                                    NIVELES, GRADOS Y GRUPOS AGREGADOS
                                </h6>
                                <br>
                                <h6 class="text-primary"><i class="material-icons">school</i>&nbsp;&nbsp;Alumnos</h6>
                                <div class="table-responsive">
                                    <table class="stripe row-border order-column" id="add_niveles_table">
                                        <thead>
                                            <tr>
                                                <th>Nivel</th>
                                                <th>Grado</th>
                                                <th>Grupo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consulta_niveles = $control_circulares->select_nivel_circular($id_circular);
                                            while ($row = mysqli_fetch_assoc($consulta_niveles)):
                                                ?>
                                                <tr>
                                                    <td><?= $row['nivel']; ?></td>
                                                    <td><?= $row['grado']; ?></td>
                                                    <td><?= $row['grupo']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-squared btn-sm"
                                                                onclick="remove_nivel()">
                                                            Quitar &nbsp;&nbsp;<i class="material-icons">remove</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            endwhile;
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Grupos especiales</h6>
                                    <table class="stripe row-border order-column" id="add_grupos_especiales_table">
                                        <thead>
                                            <tr>
                                                <th>Grupo</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td class="right">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-squared btn-sm"
                                                            onclick="remove_grupo_especial_table();">
                                                        X
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Grupos administrativos</h6>
                                    <table class="stripe row-border order-column" id="add_grupos_administrativos_table">
                                        <thead>
                                            <tr>
                                                <th>Administrativo</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td class="right">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-squared btn-sm"
                                                            onclick="remove_grupo_administrativos_table();">
                                                        X
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Camiones</h6>
                                    <table class="stripe row-border order-column" id="add_camiones_table">
                                        <thead>
                                            <tr>
                                                <th>Camión (Mañana)</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td class="right">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-squared btn-sm"
                                                            onclick="remove_camiones_table();">
                                                        X
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Camiones</h6>
                                    <table class="stripe row-border order-column" id="add_camiones_tarde_table">
                                        <thead>
                                            <tr>
                                                <th>Camión (Tarde)</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td class="right">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-squared btn-sm"
                                                            onclick="remove_camiones_tarde_table();">
                                                        X
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include "{$root}/Secciones/scripts.php";
                include "{$root}/components/footer.php";
                ?>
            </div>
        </div>
        <div class="overlay"></div>
        <?php
        include "{$root}/Secciones/spinner.php";
        include "{$root}/Secciones/notificaciones.php";
        ?>
        <script type="text/javascript">
            var set_aux_nivel = new Set(<?= $aux_niveles; ?>);
            var flag_guardar = false;

            $(document).ready(function () {
                console.log(set_aux_nivel);
                ckeditor();
                CKEDITOR.instances.editor.setData(`<?= html_entity_decode($contenido); ?>`);
                spinnerOut();
                set_menu_hamburguer();
                set_table('add_niveles_table');
                set_table('id_table_usuarios');
                set_table('add_grupos_especiales_table');
                set_table('add_grupos_administrativos_table');
                set_table('add_camiones_table');
                set_table('add_camiones_tarde_table');
                datepicker_es();
                $('#id_fecha_programada').datepicker({
                    calendarWeeks: true,
                    autoclose: true,
                    todayHighlight: true,
                    language: 'es',
                    startDate: new Date()
                });
            });
            function enviar() {
//                if (!validaciones())
//                    return;
                $.ajax({
                    url: 'https://www.chmd.edu.mx/pruebascd/admin/app/Circulares/common/post_edicion_circular.php',
                    type: 'POST',
                    beforeSend: () => {
                        spinnerIn();
                        //$("#btn_enviar").prop("disabled", true);
                    },
                    dataType: 'json',
                    data: {
                        titulo: $("#input_titulo").val(),
                        contenido: CKEDITOR.instances.editor.getData(),
                        descripcion: $("#input_descripcion").val(),
                        nivel: Array.from(set_aux_nivel)
                    }
                }).done((res) => {
                }).always(() => {
                    spinnerOut();
                });
            }
        </script>
    </body>
</html>