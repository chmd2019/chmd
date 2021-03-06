<?php
$root = dirname(dirname(__DIR__));
require "{$root}/Circulares/common/ControlCirculares.php";
include "{$root}/Persistence/session.php";
$control_circulares = new ControlCirculares();
$consulta_grados = $control_circulares->select_catalogo_grado();
$consulta_grupos = $control_circulares->select_catalogo_grupos();
$nivel_json = array();
$grados_json = array();
$grupos_json = array();
while ($row = mysqli_fetch_array($consulta_grados)) {
    array_push($grados_json, ["id_grado" => intval($row[0]), "grado" => $row[1], "id_nivel" => intval($row[2])]);
}
while ($row = mysqli_fetch_array($consulta_grupos)) {
    array_push($grupos_json, ["id_grupo" => intval($row[0]), "grupo" => $row[1], "id_grado" => intval($row[2])]);
}
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
                        <div class="alert alert-info m-auto" role="alert">
                            <span>
                                <i class="material-icons">info</i>
                                &nbsp;&nbsp;Plantilla duplicada de la circular &quot;<?= $titulo; ?>&quot;
                            </span>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="card col-sm-12 col-md-7 border panel-personalizado">
                            <div class="card-body p-0 pt-3">
                                <h6 class="text-primary border-bottom">
                                    <i class="material-icons">chat_bubble</i>&nbsp;&nbsp;DUPLICAR CIRCULAR ()
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
                                                   value="<?= $titulo ?> (COPIA)"
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
                                                   value="<?= $descripcion ?> (COPIA)"
                                                   id="input_descripcion"
                                                   name="descripcion"
                                                   class="form-control text-uppercase" 
                                                   placeholder="Descripción"
                                                   autocomplete="off"
                                                   required>
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
                                                    $coleccion_usuarios = array();
                                                    while ($row = mysqli_fetch_array($consulta_usuarios)):
                                                        $id = $row[0];
                                                        $nombre = $row[1];
                                                        $numero = $row[2];
                                                        $correo = $row[3];
                                                        array_push($coleccion_usuarios, ["id_usuario" => $id, "nombre" => $nombre]);
                                                        ?>
                                                <option value="<?= $id; ?>"><?= $nombre; ?></option>
                                                <?php
                                            endwhile;
                                            $coleccion_usuarios_json = json_encode($coleccion_usuarios);
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
                                                            array_push($nivel_json, ["id_nivel" => $id_nivel, "nivel" => $descripcion_nivel]);
                                                            ?>
                                                    <option value="<?php echo $id_nivel; ?>"><?php echo $descripcion_nivel; ?></option>
                                                    <?php
                                                endwhile;
                                                $nivel_json = json_encode($nivel_json);
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
                                                        $coleccion_grupos_especiales = array();
                                                        $consulta_grupos_especiales = $control_circulares->select_grupos_especiales();
                                                        while ($row = mysqli_fetch_array($consulta_grupos_especiales)):
                                                            $id_grupo = $row[0];
                                                            $grupo = $row[1];
                                                            array_push($coleccion_grupos_especiales, ["id" => $id_grupo, "grupo" => $grupo]);
                                                            ?>
                                                    <option value="<?= $id_grupo; ?>"><?= $grupo; ?></option>
                                                    <?php
                                                endwhile;
                                                $coleccion_grupos_especiales = json_encode($coleccion_grupos_especiales);
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
                                                        $coleccion_grupos_administrativos = array();
                                                        $consulta_grupos_administrativos = $control_circulares->select_grupos_administrativos();
                                                        while ($row = mysqli_fetch_array($consulta_grupos_administrativos)):
                                                            $id_grupo_adm = $row[0];
                                                            $grupo_adm = $row[1];
                                                            array_push($coleccion_grupos_administrativos, ["id" => $id_grupo_adm, "grupo" => $grupo_adm]);
                                                            ?>
                                                    <option value="<?= $id_grupo_adm; ?>"><?= $grupo_adm; ?></option>
                                                    <?php
                                                endwhile;
                                                $coleccion_grupos_administrativos = json_encode($coleccion_grupos_administrativos);
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
                                    <textarea id="editor"><?= $contenido; ?></textarea>
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
            var catalogo_niveles = <?= $nivel_json; ?>;
            var catalogo_grados = <?= $grados_json; ?>;
            var catalogo_grupos = <?= $grupos_json; ?>;
            var coleccion_usuarios_json = <?= $coleccion_usuarios_json; ?>;
            var coleccion_grupos_especiales_json = <?= $coleccion_grupos_especiales; ?>;
            var coleccion_grupos_administrativos_json = <?= $coleccion_grupos_administrativos; ?>;
            var coleccion_padres_camiones_json = <?= $padres_camiones; ?>;
            var coleccion_padres_camiones_tarde_json = <?= $padres_camiones_tarde; ?>;
            var coleccion_niveles = [];
            var coleccion_grados = [];
            var coleccion_grupos = [];
            var coleccion_nivel_grado_grupo = [];
            var set_padres_camiones = new Set();
            var set_padres_camiones_tarde = new Set();
            var suneditor = null;

            $(document).ready(function () {
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
                suneditor = SUNEDITOR.create((document.getElementById('editor') || 'editor'), {
                    font: [
                        'Arial',
                        'Calibri',
                        'Comic Sans',
                        'Courier New,Courier',
                        'Courier',
                        'Georgia',
                        'Gotham Rounded Book',
                        'Gracia',
                        'Helvetica',
                        'Impact',
                        'Script',
                        'Tohoma',
                        'Varela Round',
                        'Verdana'
                    ],
                    showPathLabel: false,
                    charCounter: true,
                    width: 'auto',
                    height: '350px',
                    minHeight: '100px',
                    maxHeight: '450px',
                    buttonList: [
                        ['undo', 'redo',
                            'font', 'fontSize', 'formatBlock',
                            'bold', 'underline', 'italic', 'strike', 'subscript', 'superscript',
                            'removeFormat',
                            'fontColor', 'hiliteColor',
                            'outdent', 'indent',
                            'align', 'horizontalRule', 'list', 'table',
                            'link', 'image', 'video',
                            'fullScreen', 'showBlocks', 'codeView',
                            'preview', 'print', 'template']
                    ],
                    callBackSave: function (contents) {
                        console.log(contents);
                    }
                });
                (function () {
                    'use strict';
                    window.addEventListener('load', function () {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function (form) {
                            form.addEventListener('submit', function (event) {
                                if (form.checkValidity() === false) {
                                    window.scroll(0, 0);
                                } else {
                                    enviar();
                                }
                                event.preventDefault();
                                event.stopPropagation();
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();
            });

            function setGrado(id_nivel) {
                var grados = [];
                for (var item in catalogo_grados) {
                    if (catalogo_grados[item].id_nivel === parseInt(id_nivel)) {
                        grados.push(catalogo_grados[item]);
                    }
                }
                $("#select_grupo").html('');
                $("#select_grupo").selectpicker('refresh');
                var options = "";
                for (var item in grados) {
                    options += `<option value="${grados[item].id_grado}">${grados[item].grado}</option>`;
                }
                $("#select_grado").html(options);
                $("#select_grado").selectpicker('refresh');
            }
            function setGrupo(id_grado) {
                var grupos = [];
                for (var item in catalogo_grupos) {
                    if (catalogo_grupos[item].id_grado === parseInt(id_grado)) {
                        grupos.push(catalogo_grupos[item]);
                    }
                }
                $("#select_grupo").html('');
                var options = "";
                for (var item in grupos) {
                    options += `<option value="${grupos[item].id_grupo}">${grupos[item].grupo}</option>`;
                }
                $("#select_grupo").html(options);
                $("#select_grupo").selectpicker('refresh');
            }
            function add_nivel() {
                var select_nivel = $("#select_nivel").val();
                var select_grado = $("#select_grado").val();
                var select_grupo = $("#select_grupo").val();
                var td_nivel = null;
                var td_grado = null;
                var td_grupo = null;

                for (var item in catalogo_niveles) {
                    if (catalogo_niveles[item].id_nivel === select_nivel) {
                        var set = new Set([...coleccion_niveles]);
                        if (!set.has(parseInt(catalogo_niveles[item].id_nivel))) {
                            coleccion_niveles.push(parseInt(catalogo_niveles[item].id_nivel));
                        }
                        td_nivel = catalogo_niveles[item].nivel;
                    }
                }
                for (var item in catalogo_grados) {
                    if (catalogo_grados[item].id_grado === parseInt(select_grado)) {
                        var set = new Set([...coleccion_grados]);
                        if (!set.has(catalogo_grados[item].id_grado)) {
                            coleccion_grados.push(catalogo_grados[item].id_grado);
                        }
                        td_grado = catalogo_grados[item].grado;
                    }
                }
                for (var item in catalogo_grupos) {
                    if (catalogo_grupos[item].id_grupo === parseInt(select_grupo)) {
                        var set = new Set([...coleccion_grupos]);
                        if (!set.has(catalogo_grupos[item].id_grupo)) {
                            coleccion_grupos.push(catalogo_grupos[item].id_grupo);
                        }
                        td_grupo = catalogo_grupos[item].grupo;
                    }
                }
                var set_coleccion = new Set(coleccion_nivel_grado_grupo);
                set_coleccion.add({conjunto: {td_nivel, td_grado, td_grupo}});
                coleccion_nivel_grado_grupo = Array.from(set_coleccion);

                if (td_nivel !== null || td_grado !== null || td_grupo !== null) {
                    select_nivel = select_nivel !== "" ? select_nivel : 0;
                    select_grado = select_grado !== "" ? select_grado : 0;
                    select_grupo = select_grupo !== "" ? select_grupo : 0;
                    var objeto_nivel_grado_grupo = `{conjunto:{td_nivel:'${td_nivel}', td_grado:'${td_grado}', td_grupo:'${td_grupo}'}}`;
                    var row = [
                        td_nivel, td_grado, td_grupo,
                        `<button type="button" 
                class="btn btn-danger btn-squared btn-sm" 
                onclick="remove_nivel(this, ${select_nivel}, ${select_grado}, ${select_grupo}, ${objeto_nivel_grado_grupo})"> 
                Quitar &nbsp;&nbsp;<i class="material-icons">remove</i>
                </button>`
                    ];
                    $("#add_niveles_table").DataTable().row.add(row).draw().node();
                    $("#select_nivel").val('default').selectpicker("refresh");
                    $("#select_grado").html('').selectpicker("refresh");
                    $("#select_grupo").html('').selectpicker("refresh");
                }
            }
            function remove_nivel(el, id_nivel, id_grado, id_grupo, objeto_nivel_grado_grupo) {
                var td_nivel = objeto_nivel_grado_grupo.conjunto.td_nivel === "null" ? null : objeto_nivel_grado_grupo.conjunto.td_nivel;
                var td_grado = objeto_nivel_grado_grupo.conjunto.td_grado === "null" ? null : objeto_nivel_grado_grupo.conjunto.td_grado;
                var td_grupo = objeto_nivel_grado_grupo.conjunto.td_grupo === "null" ? null : objeto_nivel_grado_grupo.conjunto.td_grupo;
                var set = new Set([...coleccion_nivel_grado_grupo]);
                set.forEach((item) => {
                    if (item.conjunto.td_nivel == td_nivel &&
                            item.conjunto.td_grado == td_grado &&
                            item.conjunto.td_grupo == td_grupo) {
                        set.delete(item);
                        coleccion_nivel_grado_grupo = Array.from(set);
                    }
                });
                $("#add_niveles_table").DataTable().row($(el).parents('tr')).remove().draw();
                var set_nivel = new Set([...coleccion_niveles]);
                var set_grado = new Set([...coleccion_grados]);
                var set_grupo = new Set([...coleccion_grupos]);
                set_nivel.delete(id_nivel);
                set_grado.delete(id_grado);
                set_grupo.delete(id_grupo);
                coleccion_niveles = Array.from(set_nivel);
                coleccion_grados = Array.from(set_grado);
                coleccion_grupos = Array.from(set_grupo);
            }
            function enviar() {
                if (!validaciones())
                    return;
                $.ajax({
                    url: $("#post_nuevo_administrativo").prop('action'),
                    type: 'POST',
                    beforeSend: () => {
                        spinnerIn();
                        $("#btn_enviar").prop("disabled", true);
                    },
                    dataType: 'json',
                    data: {
                        titulo: $("#input_titulo").val(),
                        contenido: suneditor.getContents(),
                        descripcion: $("#input_descripcion").val(),
                        estatus: $("#select_estatus").val(),
                        envia_todos: $("#check_enviar_todos")[0].checked,
                        usuarios: $("#select_usuarios").val(),
                        coleccion_nivel_grado_grupo: coleccion_nivel_grado_grupo,
                        grupos_especiales: $("#select_grupos_especiales").val(),
                        grupos_administrativos: $("#select_grupos_administrativos").val(),
                        fecha_programada: $("#id_fecha_programada").val(),
                        coleccion_padres_camiones: Array.from(set_padres_camiones),
                        coleccion_padres_camiones_tarde: Array.from(set_padres_camiones_tarde)
                    }
                }).done((res) => {
                    if (res === true) {
                        success_alerta('Solicitud exitosa');
                        setInterval(() => {
                            window.location.href = '<?=$url_btn_atras;?>';
                        }, 2000);
                    } else {
                        fail_alerta(`¡Solicitud no realizada!, ${res}`);
                        $("#btn_enviar").prop("disabled", false);
                    }
                }).always(() => {
                    spinnerOut();
                });
            }
            function add_usuarios_table() {
                //id_table_usuarios 
                var select_usuarios = $("#select_usuarios").val();
                if (select_usuarios.length > 0) {
                    var select_usuarios = new Set([...select_usuarios]);
                    var usuarios = new Set([...coleccion_usuarios_json]);
                    if (select_usuarios.size > 0) {
                        select_usuarios.forEach((item) => {
                            usuarios.forEach((item_usuario) => {
                                if (item === item_usuario.id_usuario) {
                                    var row = [
                                        `${item_usuario.nombre}`
                                    ];
                                    $("#id_table_usuarios").DataTable().row.add(row).draw().node();
                                }
                            });
                        });
                    }
                } else {
                    $("#id_table_usuarios").DataTable().clear().draw();
                }
            }
            function add_grupo_especial_table() {
                var select_grupos_especiales = $("#select_grupos_especiales").val();
                var set_grupo = new Set([...coleccion_grupos_especiales_json]);
                var tabla = $("#add_grupos_especiales_table").DataTable();
                tabla.clear().draw();
                for (var item in select_grupos_especiales) {
                    set_grupo.forEach(element => {
                        if (element.id === select_grupos_especiales[item]) {
                            tabla.row.add([`${element.grupo}`]).draw().node();
                        }
                    });
                }
            }
            function remove_grupo_especial_table() {
                var tabla = $("#add_grupos_especiales_table").DataTable();
                tabla.clear().draw();
                $("#select_grupos_especiales").selectpicker('deselectAll');
            }
            function chk_enviar_todos(value) {
                if (value) {
                    $("#select_usuarios").selectpicker('selectAll');
                } else {
                    $("#select_usuarios").selectpicker('deselectAll');
                }
                $("#select_usuarios").selectpicker('render');
            }
            function add_grupos_administrativos_table() {
                var select_grupos_administrativos = $("#select_grupos_administrativos").val();
                var set = new Set([...coleccion_grupos_administrativos_json]);
                var table = $("#add_grupos_administrativos_table").DataTable();
                table.clear().draw();
                for (var item in select_grupos_administrativos) {
                    set.forEach(element => {
                        if (element.id === select_grupos_administrativos[item]) {
                            table.row.add([`${element.grupo}`]).draw().node();
                        }
                    });
                }
            }
            function remove_grupo_administrativos_table() {
                $("#select_grupos_administrativos").selectpicker('deselectAll');
                $("#select_grupos_administrativos").selectpicker('render');
                var table = $("#add_grupos_administrativos_table").DataTable();
                table.clear().draw();
            }
            function validaciones() {
                let select_usuarios = $("#select_usuarios").val(),
                        select_grupos_especiales = $("#select_grupos_especiales").val(),
                        select_grupos_administrativos = $("#select_grupos_administrativos").val(),
                        id_select_camiones = $("#id_select_camiones").val(),
                        select_camiones = $("#id_select_camiones_tarde").val();
                if (select_usuarios.length === 0 &&
                        select_grupos_especiales.length === 0 &&
                        select_grupos_administrativos.length === 0 &&
                        select_camiones.length === 0 &&
                        coleccion_niveles.length === 0 &&
                        coleccion_grados.length === 0 &&
                        coleccion_grupos.length === 0 &&
                        id_select_camiones.length === 0) {
                    fail_alerta('Debe seleccionar al menos un grupo de usuarios');
                    return false;
                }
                return true;
            }
            function add_camiones() {
                var select_camiones = $("#id_select_camiones").val();
                var set = new Set(coleccion_padres_camiones_json);
                set_padres_camiones.clear();
                var tabla_camiones = $("#add_camiones_table").DataTable();
                tabla_camiones.clear().draw();
                var camiones = new Set();
                for (var item in select_camiones) {
                    set.forEach(element => {
                        if (select_camiones[item] === element.id_ruta) {
                            camiones.add(`Camión: ${element.camion} | Ruta: ${element.nombre_ruta}`);
                            set_padres_camiones.add({id_alumno: element.id_alumno, id_papa: element.id_papa});
                        }
                    });
                }
                camiones.forEach(element => {
                    tabla_camiones.row.add([`${element}`]).draw().node();
                });
            }
            function remove_camiones_table() {
                var tabla_camiones = $("#add_camiones_table").DataTable();
                tabla_camiones.clear().draw();
                set_padres_camiones.clear();
                $("#id_select_camiones").selectpicker('deselectAll');
                $("#id_select_camiones").selectpicker('render');
            }
            function add_camiones_tarde() {
                var select_camiones = $("#id_select_camiones_tarde").val();
                var set = new Set(coleccion_padres_camiones_tarde_json);
                set_padres_camiones_tarde.clear();
                var tabla_camiones = $("#add_camiones_tarde_table").DataTable();
                tabla_camiones.clear().draw();
                var camiones = new Set();
                for (var item in select_camiones) {
                    set.forEach(element => {
                        if (select_camiones[item] === element.id_ruta) {
                            camiones.add(`Camión: ${element.camion} | Ruta: ${element.nombre_ruta}`);
                            set_padres_camiones_tarde.add({id_alumno: element.id_alumno, id_papa: element.id_papa});
                        }
                    });
                }
                camiones.forEach(element => {
                    tabla_camiones.row.add([`${element}`]).draw().node();
                });
            }
            function remove_camiones_tarde_table() {
                $("#id_select_camiones_tarde").selectpicker('deselectAll');
                $("#id_select_camiones_tarde").selectpicker('render');
                set_padres_camiones_tarde.clear();
                var tabla_camiones = $("#add_camiones_tarde_table").DataTable();
                tabla_camiones.clear().draw();
            }
        </script>
    </body>
</html>