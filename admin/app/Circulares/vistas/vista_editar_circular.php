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
$tema_ics = $circular['tema_ics'];
$fecha_ics = $circular['fecha_ics'];
$hora_inicial_ics = $circular['hora_inicial_ics'];
$hora_final_ics = $circular['hora_final_ics'];
$ubicacion_ics = $circular['ubicacion_ics'];
$flag_evento = false;
if (strlen($tema_ics) > 0 && strlen($fecha_ics) > 0 && strlen($hora_inicial_ics) > 0 &&
    strlen($hora_final_ics) > 0 && strlen($ubicacion_ics) > 0) {
    $flag_evento = true;
}
//url para botón atrás
$url_btn_atras = "https://" . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['REQUEST_URI'])) . "/Circulares.php";
$consulta_niveles_edicion = $control_circulares->select_niveles_edicion($id_circular);
$aux_niveles = array();
$aux_grupos_especiales = array();
$aux_grupos_administrativos = array();
$aux_camiones_manana = array();
foreach ($consulta_niveles_edicion as $value) {
    array_push($aux_niveles, [
            "id_nivel" => intval($value['id_nivel']),
            "nivel" => $value['nivel'],
            "id_grado" => intval($value['id_grado']),
            "grado" => $value['grado'],
            "id_grupo" => intval($value['id_grupo']),
            "grupo" => $value['grupo']
        ]
    );

}
$aux_niveles = json_encode($aux_niveles);
$nivel_json = array();
$grados_json = array();
$grupos_json = array();
$catalogo_grp_especiales = array();
$catalogo_grp_administrativos = array();
$catalogo_usuarios = array();
$select_grp_especial = $control_circulares->select_grupos_especiales();
$select_grp_administrativos = $control_circulares->select_grupos_administrativos();
$select_usuarios = $control_circulares->select_usuarios();

while ($row = mysqli_fetch_assoc($select_grp_especial)) {
    array_push($catalogo_grp_especiales, [
        "id_grp_especial" => intval($row['id']),
        "grupo" => $row['grupo']
    ]);
}

while ($row = mysqli_fetch_assoc($select_grp_administrativos)) {
    array_push($catalogo_grp_administrativos, [
        "id_grp_administrativo" => intval($row['id']),
        "grupo" => $row['grupo']
    ]);
}

while ($row = mysqli_fetch_assoc($select_usuarios)) {
    array_push($catalogo_usuarios, [
        "id_usuario" => intval($row['id']),
        "nombre" => $row['nombre']
    ]);
}

while ($row = mysqli_fetch_array($consulta_grados)) {
    array_push($grados_json, ["id_grado" => intval($row[0]), "grado" => $row[1], "id_nivel" => intval($row[2])]);
}

while ($row = mysqli_fetch_array($consulta_grupos)) {
    array_push($grupos_json, ["id_grupo" => intval($row[0]), "grupo" => $row[1], "id_grado" => intval($row[2])]);
}

$grados_json = json_encode($grados_json);
$grupos_json = json_encode($grupos_json);
//consulta de rutas del dia (manana)
$fecha_ruta = $control_circulares->select_fecha_ruta_grabada($id_circular);
$flag_ruta = false;
if ($fecha_ruta == date("2019-12-21")) {
    $flag_ruta = true;
}

//catalogo de rutas
$catalogo_rutas_manana = array();
$catalogo_rutas_tarde = array();
//usuarios de cada ruta
$usuarios_ruta_manana = $control_circulares->select_usuarios_ruta_manana(date("2019-12-21"));
$usuarios_ruta_tarde = $control_circulares->select_usuarios_ruta_tarde(date("2019-12-21"));
//rutas asignadas de la circular por el usuario al momento de crear
$set_rutas_manana_asignadas = array();
$set_rutas_tarde_asignada = array();
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
            <?php if (count($circular) == 0): ?>
                <div class="alert alert-danger m-auto" role="alert">
                    <span>
                        <i class="material-icons">danger</i>
                        &nbsp;&nbsp;Circular no existe
                    </span>
                </div>
                <br>
                <br>
            <?php else: ?>
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
                                <div class="form-group col-md-6">
                                    <?php if ($flag_evento): ?>
                                        <div class="alert alert-info" role="alert">
                                            <i class="material-icons">info</i> &nbsp; Ésta circular tiene eventos
                                            relacionados
                                        </div>
                                    <?php endif; ?>
                                    <a href="#!"
                                       class="btn btn-primary btn-squared"
                                       data-toggle="modal" data-target="#modal_adjuntar">
                                        &nbsp;Adjuntar evento
                                        <i class="material-icons">event</i>
                                    </a>
                                    &nbsp;&nbsp;
                                    <i class="material-icons text-success"
                                       style="font-size: 1.5rem;"
                                       id="id_icon_done_adjuntado"
                                       <?php if (!$flag_evento): ?>hidden<?php endif; ?>>
                                        done
                                    </i>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modal_adjuntar" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-info">
                                                        <i class="material-icons">help</i>
                                                        &nbsp;Información del evento
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group col-md-12">
                                                        <label>Tema del evento</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="fa fa-bookmark"></i></span>
                                                            </div>
                                                            <input type="text"
                                                                   id="id_tema_evento"
                                                                   class="form-control text-uppercase"
                                                                   placeholder="Tema del evento"
                                                                   value="<?= $tema_ics; ?>"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Cuándo</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">calendar_today</i>
                                                </span>
                                                            </div>
                                                            <input type="text"
                                                                   id="id_cuando"
                                                                   class="form-control _datepicker"
                                                                   placeholder="Cuándo"
                                                                   autocomplete="off"
                                                                   value="<?= $fecha_ics; ?>"
                                                                   onclick="blur();">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Hora inicial</label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   id="id_time_inicial"
                                                                   class="form-control"
                                                                   placeholder="Hora inicial"
                                                                   autocomplete="off"
                                                                   onchange="validar_horario_ics();"
                                                                   value="<?= $hora_inicial_ics; ?>"
                                                                   onclick="blur();">
                                                        </div>
                                                        <script>
                                                            $('#id_time_inicial').timepicker({
                                                                uiLibrary: 'bootstrap4',
                                                                mode: '24hr'
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Hora final</label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   id="id_time_final"
                                                                   class="form-control"
                                                                   placeholder="Hora final"
                                                                   autocomplete="off"
                                                                   onchange="validar_horario_ics();"
                                                                   value="<?= $hora_final_ics; ?>"
                                                                   onclick="blur();">
                                                        </div>
                                                        <script>
                                                            $('#id_time_final').timepicker({
                                                                uiLibrary: 'bootstrap4',
                                                                mode: '24hr'
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Ubicación</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                            class="material-icons">near_me</i></span>
                                                            </div>
                                                            <input type="text"
                                                                   id="id_ubicacion"
                                                                   class="form-control text-uppercase"
                                                                   placeholder="Ubicación"
                                                                   value="<?= $ubicacion_ics; ?>"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-danger btn-squared"
                                                            data-dismiss="modal"
                                                            onclick="cancelar_adjuntar_ics();">
                                                        <i class="material-icons">cancel</i>
                                                        &nbsp;Cancelar
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-primary btn-squared"
                                                            onclick="adjuntar_ics();">
                                                        Ok
                                                        &nbsp;<i class="material-icons">done</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="clearfix"></span>

                                <br>
                                <h5 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Selección de
                                    grupos y usuarios</h5>
                                <hr>
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
                                                array_push($nivel_json, ["id_nivel" => intval($id_nivel), "nivel" => $descripcion_nivel]);
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
                                        <button type="button"
                                                class="btn btn-success btn-squared"
                                                onclick="add_nivel_grado_grupo();">
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
                                                onchange="add_grupo_especial_table(this);">
                                            <?php
                                            $consulta_grupos_especiales = $control_circulares->select_grupos_especiales();
                                            while ($row = mysqli_fetch_array($consulta_grupos_especiales)):
                                                $id_grupo = $row[0];
                                                $grupo = $row[1];
                                                ?>
                                                <option value="<?= $id_grupo; ?>"
                                                    <?php
                                                    $grupos_especiales = $control_circulares->select_grupos_especiales_x_circular($id_circular);
                                                    while ($row_grp_especial = mysqli_fetch_assoc($grupos_especiales)) {
                                                        if ($row_grp_especial['id_grupo_espepcial'] == $id_grupo) {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?>
                                                >
                                                    <?= $grupo; ?>
                                                </option>
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
                                                onchange="add_grupos_administrativos_table(this);">
                                            <?php
                                            $consulta_grupos_administrativos = $control_circulares->select_grupos_administrativos();
                                            while ($row = mysqli_fetch_array($consulta_grupos_administrativos)):
                                                $id_grupo_adm = $row[0];
                                                $grupo_adm = $row[1];
                                                ?>
                                                <option value="<?= $id_grupo_adm; ?>"
                                                    <?php
                                                    $grupos_administrativos = $control_circulares->select_grupos_administrativos_x_circular($id_circular);
                                                    while ($row_grp_adm = mysqli_fetch_assoc($grupos_administrativos)) {
                                                        if ($row_grp_adm['id_grupo_administrativo'] == $id_grupo_adm) {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?>
                                                >
                                                    <?= $grupo_adm; ?>
                                                </option>
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
                                                onchange="add_ruta_manana();"
                                                multiple>
                                            <?php
                                            if ($flag_ruta):
                                                $fecha_actual = date("2019-12-21");
                                                $consulta_ruta_manana_circular = $control_circulares->select_ruta_manana_circular($id_circular);
                                                $consulta_rutas_manana = $control_circulares->select_ruta_manana($fecha_actual);
                                                while ($row = mysqli_fetch_assoc($consulta_rutas_manana)):
                                                    //id_ruta_manana, b.nombre_ruta, camion
                                                    array_push($catalogo_rutas_manana, [
                                                        "id_ruta_manana" => $row['id_ruta_manana'],
                                                        "nombre_ruta" => $row['nombre_ruta'],
                                                        "camion" => $row['camion']
                                                    ]); ?>
                                                    <option value="<?= $row['id_ruta_manana']; ?>"
                                                        <?php
                                                        while ($row_ruta = mysqli_fetch_assoc($consulta_ruta_manana_circular)) {
                                                            if ($row_ruta['id_ruta_h'] == $row['id_ruta_manana']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        ?>
                                                    >
                                                        Ruta: <?= strtoupper($row['nombre_ruta']); ?> |
                                                        Camión: <?= $row['camion']; ?></option>
                                                <?php endwhile;
                                            endif; ?>
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
                                                onchange="add_ruta_tarde();"
                                                multiple>
                                            <?php
                                            if ($flag_ruta):
                                                $fecha_actual = date("2019-12-21");
                                                $consulta_ruta_tarde_circular = $control_circulares->select_ruta_tarde_circular($id_circular);
                                                $consulta_rutas_tarde = $control_circulares->select_ruta_tarde($fecha_actual);
                                                while ($row = mysqli_fetch_assoc($consulta_rutas_tarde)):
                                                    //id_ruta_manana, b.nombre_ruta, camion
                                                    array_push($catalogo_rutas_tarde, [
                                                        "id_ruta_tarde" => $row['id_ruta_tarde'],
                                                        "nombre_ruta" => $row['nombre_ruta'],
                                                        "camion" => $row['camion']
                                                    ]); ?>
                                                    <option value="<?= $row['id_ruta_tarde']; ?>"
                                                        <?php
                                                        while ($row_ruta = mysqli_fetch_assoc($consulta_ruta_tarde_circular)) {
                                                            if ($row_ruta['id_ruta_h'] == $row['id_ruta_tarde']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        ?>
                                                    >
                                                        Ruta: <?= strtoupper($row['nombre_ruta']); ?> |
                                                        Camión: <?= $row['camion']; ?></option>
                                                <?php endwhile;
                                            endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <?php
                                if (!$flag_ruta):
                                    ?>
                                    <div class="container">
                                        <div class="alert alert-info" role="alert">
                                            <i class="material-icons">info</i>&nbsp;&nbsp;
                                            Ésta circular tiene rutas seleccionadas editables.
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="container">
                                        <div class="alert alert-warning" role="alert">
                                            <button type="button" class="close text-white" data-dismiss="alert"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <i class="material-icons">info</i>&nbsp;&nbsp;
                                            Al momento de actualizar esta circular, las rutas se asignaran
                                            de la selección actual ya que la circular fue creada en una fecha
                                            diferente a la actual.
                                        </div>
                                        <p></p>
                                        <?php
                                        $consulta_rutas_manana = $control_circulares->select_ruta_manana_circular($id_circular);
                                        $consulta_rutas_tarde = $control_circulares->select_ruta_tarde_circular($id_circular);
                                        if (count($consulta_rutas_manana) > 0):
                                            ?>
                                            <div class="alert alert-info" role="alert">
                                                <button type="button" class="close text-white" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <i class="material-icons">info</i>&nbsp;&nbsp;
                                                Rutas para la mañana asignadas anteriormente en ésta circular:
                                                <?php foreach ($consulta_rutas_manana as $ruta): ?>
                                                    <div>Ruta: <?= $ruta['nombre_ruta']; ?> |
                                                        Camión: <?= $ruta['camion']; ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                            <p></p>
                                        <?php
                                        endif;
                                        if (count($consulta_rutas_tarde) > 0):
                                            ?>
                                            <div class="alert alert-info" role="alert">
                                                <button type="button" class="close text-white" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <i class="material-icons">info</i>&nbsp;&nbsp;
                                                Rutas para la tarde asignadas anteriormente en ésta circular:
                                                <?php foreach ($consulta_rutas_manana as $ruta): ?>
                                                    <div>Ruta: <?= $ruta['nombre_ruta']; ?> |
                                                        Camión: <?= $ruta['camion']; ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                            <p></p>
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>
                                <br>
                                <h5 class="text-primary">
                                    <i class="material-icons">group_add</i>&nbsp;&nbsp;Adicionales
                                </h5>
                                <hr>
                                <div class="row col-sm-12 justify-content-start">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="check_enviar_todos"
                                               name="enviar_todos"
                                               onchange="chk_enviar_todos(this.checked);">
                                        <label class="custom-control-label" for="check_enviar_todos">Enviar a
                                            todos</label>
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
                                            <option value="<?= $id; ?>"
                                                <?php
                                                $select_usuarios_sin_grupo = $control_circulares->select_usuarios_sin_grupo($id_circular);
                                                while ($row_usuario = mysqli_fetch_assoc($select_usuarios_sin_grupo)) {
                                                    if ($id == $row_usuario['id_usuario']) echo "selected";
                                                }
                                                ?>
                                            >
                                                <?= $nombre; ?>
                                            </option>
                                        <?php
                                        endwhile;
                                        $coleccion_usuarios_json = json_encode($coleccion_usuarios);
                                        ?>
                                    </select>
                                    <button type="button"
                                            class="btn btn-primary btn-squared"
                                            data-toggle="modal"
                                            data-target="#modal_usuarios"
                                            onclick="add_usuarios_table();">
                                        <i class="material-icons">search</i>
                                    </button>
                                    <div class="modal fade" id="modal_usuarios" tabindex="-1" role="dialog"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-lg p-0" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-primary">Usuarios</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body p-1">
                                                    <br>
                                                    <table class="stripe row-border order-column"
                                                           id="id_table_usuarios">
                                                        <thead>
                                                        <tr>
                                                            <th class="w-75">Usuarios</th>
                                                            <th class="w-25 text-center">Quitar</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $select_usuarios_sin_grupo = $control_circulares->select_usuarios_sin_grupo($id_circular);
                                                        while ($row = mysqli_fetch_assoc($select_usuarios_sin_grupo)): ?>
                                                            <tr>
                                                                <td><?= $row['nombre']; ?></td>
                                                                <td>
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-squared btn-sm ml-5"
                                                                            onclick="remove_usuario_tabla(this, <?= intval($row['id_usuario']); ?>);">
                                                                        X &nbsp;&nbsp;<i
                                                                                class="material-icons">remove</i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary btn-squared"
                                                            data-dismiss="modal">
                                                        Ok &nbsp;&nbsp;<i class="material-icons right">done</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <h5 class="text-primary"><i class="material-icons">info</i>&nbsp;&nbsp;Información de
                                    contenido</h5>
                                <hr>
                                <br>
                                <div id="editor"></div>
                                <span class="col-md-12"><hr></span>
                                <button class="btn btn-primary" type="submit" id="btn_enviar">
                                    Actualizar &nbsp;&nbsp;<i class="material-icons">send</i>
                                </button>
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
                                                        onclick="remove_nivel(this, <?= intval($row['id_nivel']); ?>,<?= intval($row['id_grado']); ?>,<?= intval($row['id_grupo']); ?>);">
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
                                <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Grupos
                                    especiales</h6>
                                <table class="stripe row-border order-column" id="add_grupos_especiales_table">
                                    <thead>
                                    <tr>
                                        <th class="w-75">Grupo</th>
                                        <th class="text-center w-25">Quitar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $grupos_especiales = $control_circulares->select_grupos_especiales_x_circular($id_circular);
                                    while ($row = mysqli_fetch_assoc($grupos_especiales)):
                                        array_push($aux_grupos_especiales, [
                                            "id_grp_especial" => intval($row['id_grupo_espepcial']),
                                            "grupo" => $row['grupo'],
                                        ]);
                                        ?>
                                        <tr>
                                            <td><?= strtoupper($row['grupo']); ?></td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-warning text-white btn-squared btn-sm ml-2"
                                                        onclick="remove_grp_especial_tabla(this, <?= intval($row['id_grupo_espepcial']); ?>);">
                                                    X
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>Quitar todos</td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-danger btn-squared btn-sm"
                                                    onclick="remove_grupo_especial_table();">
                                                X
                                            </button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <hr>
                                <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Grupos
                                    administrativos</h6>
                                <table class="stripe row-border order-column" id="add_grupos_administrativos_table">
                                    <thead>
                                    <tr>
                                        <th class="w-75">Administrativo</th>
                                        <th class="w-25">Quitar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $grupos_administrativos = $control_circulares->select_grupos_administrativos_x_circular($id_circular);
                                    while ($row = mysqli_fetch_assoc($grupos_administrativos)):
                                        array_push($aux_grupos_administrativos, [
                                            "id_grp_administrativo" => intval($row['id_grupo_administrativo']),
                                            "grupo" => $row['grupo']
                                        ]);
                                        ?>
                                        <tr>
                                            <td><?= strtoupper($row['grupo']); ?></td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-warning text-white btn-squared btn-sm ml-2"
                                                        onclick="remove_grp_adm_tabla(this, <?= intval($row['id_grupo_administrativo']); ?>);">
                                                    X
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>Quitar todos</td>
                                        <td class="right">
                                            <button type="button"
                                                    class="btn btn-danger btn-squared btn-sm"
                                                    onclick="remove_grupo_administrativos_table();">
                                                X
                                            </button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <hr>
                                <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Camiones
                                </h6>

                                <table class="stripe row-border order-column" id="add_camiones_table">
                                    <thead>
                                    <tr>
                                        <th class="w-75">Camión (Mañana)</th>
                                        <th class="w-25">Quitar</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <td>Quitar todo</td>
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
                                    <?php
                                    if ($flag_ruta):
                                        $consulta_rutas_manana = $control_circulares->select_ruta_manana_circular($id_circular);
                                        while ($row = mysqli_fetch_assoc($consulta_rutas_manana)):
                                            array_push($set_rutas_manana_asignadas, [
                                                "id_ruta_manana" => $row['id_ruta_h'],
                                                "nombre_ruta" => $row['nombre_ruta'],
                                                "camion" => $row['camion']
                                            ])
                                            ?>
                                            <tr>
                                                <td>Ruta: <?= $row['nombre_ruta']; ?> |
                                                    Camión: <?= $row['camion']; ?>
                                                </td>
                                                <td>
                                                    <a href="#!"
                                                       class="btn btn-sm btn-warning btn-squared text-white ml-2"
                                                       onclick="remover_ruta_manana(this, <?= $row['id_ruta_h']; ?>)">
                                                        X
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        endwhile;
                                    endif;
                                    ?>
                                    </tbody>
                                </table>
                                <hr>
                                <h6 class="text-primary"><i class="material-icons">group_add</i>&nbsp;&nbsp;Camiones
                                </h6>
                                <table class="stripe row-border order-column" id="add_camiones_tarde_table">
                                    <thead>
                                    <tr>
                                        <th>Camión (Tarde)</th>
                                        <th>Quitar</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <td>Quitar todo</td>
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
                                    <?php ?>

                                    <?php ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
    var catalogo_grp_especiales = new Set(<?= json_encode($catalogo_grp_especiales);?>);
    var catalogo_grp_administrativos = new Set(<?=json_encode($catalogo_grp_administrativos);?>);
    var catalogo_usuarios = new Set(<?=json_encode($catalogo_usuarios);?>);
    var set_nivel_grado_grupo = new Set(<?= $aux_niveles; ?>);
    var set_grupos_especiales = new Set(<?=json_encode($aux_grupos_especiales);?>);
    var set_grupos_administrativos = new Set(<?=json_encode($aux_grupos_administrativos);?>);
    var flag_guardar = false;
    var flag_programada = false;
    var id_circular = <?=$id_circular;?>;
    //catalogo de usuarios
    var set_catalogo_usuarios_ruta_manana = new Set(<?= json_encode($usuarios_ruta_manana);?>);
    var set_catalogo_usuarios_ruta_tarde = new Set(<?= json_encode($usuarios_ruta_tarde);?>);
    //rutas asignadas por el usuario
    var set_rutas_manana_asignadas = new Set(<?=json_encode($set_rutas_manana_asignadas);?>);
    var set_rutas_tarde_asignada = new Set();
    //catalogo de rutas del dia
    var set_catalogo_rutas_manana = new Set(<?= json_encode($catalogo_rutas_manana);?>);
    var set_catalogo_rutas_tarde = new Set(<?= json_encode($catalogo_rutas_tarde);?>);

    $(document).ready(function () {
        ckeditor();
        <?php if (count($circular) != 0): ?>
        CKEDITOR.instances.editor.setData(`<?= html_entity_decode($contenido); ?>`);
        <?php endif; ?>
        spinnerOut();
        set_menu_hamburguer();
        set_table_sin_paginacion_sin_buscar('add_niveles_table');
        set_table('id_table_usuarios');
        set_table_sin_paginacion_sin_buscar('add_grupos_especiales_table');
        set_table_sin_paginacion_sin_buscar('add_grupos_administrativos_table');
        set_table_sin_paginacion_sin_buscar('add_camiones_table');
        set_table_sin_paginacion_sin_buscar('add_camiones_tarde_table');
        datepicker_es();
        $('#id_fecha_programada').datepicker({
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,
            language: 'es',
            startDate: new Date()
        });
        $('._datepicker').datepicker({
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,
            language: 'es',
            startDate: new Date()
        });
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

    function enviar() {
        /*if (!validaciones())
        return;*/
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/admin/app/Circulares/common/post_edicion_circular.php',
            type: 'POST',
            beforeSend: () => {
                spinnerIn();
                //$("#btn_enviar").prop("disabled", true);
            },
            dataType: 'json',
            data: {
                id_circular: id_circular,
                titulo: $("#input_titulo").val(),
                contenido: CKEDITOR.instances.editor.getData(),
                descripcion: $("#input_descripcion").val(),
                nivel: coleccion_nivel(),
                tema_ics: $("#id_tema_evento").val(),
                fecha_ics: $("#id_cuando").val(),
                hora_inicial_ics: $("#id_time_inicial").val(),
                hora_final_ics: $("#id_time_final").val(),
                ubicacion_ics: $("#id_ubicacion").val(),
                grp_especiales: Array.from(set_grupos_especiales),
                grp_administrativos: Array.from(set_grupos_administrativos),
                usuarios: $("#select_usuarios").selectpicker('val'),
                coleccion_usuarios_ruta_manana: coleccion_usuarios_ruta_manana(),
                coleccion_usuarios_ruta_tarde: coleccion_usuarios_ruta_tarde()
            }
        }).done((res) => {
        }).always(() => {
            spinnerOut();
        });
    }

    function add_nivel_grado_grupo() {
        let id_nivel = null;
        let nivel = null;
        let id_grado = null;
        let grado = null;
        let id_grupo = null;
        let grupo = null;
        let _catalogo_niveles = new Set(catalogo_niveles);
        let _catalogo_grados = new Set(catalogo_grados);
        let _catalogo_grupos = new Set(catalogo_grupos);

        _catalogo_niveles.forEach(item => {
            if (item.id_nivel == $("#select_nivel").val()) {
                id_nivel = item.id_nivel;
                nivel = item.nivel;
            }
        });
        _catalogo_grados.forEach(item => {
            if (item.id_grado == $("#select_grado").val()) {
                id_grado = item.id_grado;
                grado = item.grado;
            }
        });
        _catalogo_grupos.forEach(item => {
            if (item.id_grupo == $("#select_grupo").val()) {
                id_grupo = item.id_grupo;
                grupo = item.grupo;
            }
        });
        let flag_tabla = true;
        set_nivel_grado_grupo.forEach(item => {
            if (id_nivel === item.id_nivel && nivel === item.nivel &&
                id_grado === item.id_grado && grado === item.grado &&
                id_grupo === item.id_grupo && grupo === item.grupo) {
                set_nivel_grado_grupo.delete(item);
                flag_tabla = !flag_tabla;
            }
        });
        set_nivel_grado_grupo.add({id_nivel, nivel, id_grado, grado, id_grupo, grupo});
        if (flag_tabla) {
            let tabla = $("#add_niveles_table").DataTable();
            tabla.row.add([nivel, grado, grupo,
                `<button type="button"
                class="btn btn-danger btn-squared btn-sm"
                onclick="remove_nivel(this,${id_nivel},${id_grado},${id_grupo})">
                Quitar &nbsp;&nbsp;<i class="material-icons">remove</i>
                </button>`]).draw().node();
        }
    }

    function remove_nivel(el, id_nivel, id_grado, id_grupo) {
        let tabla = $("#add_niveles_table").DataTable();
        /*        id_grado = id_grado === 0 ? null : id_grado;
                id_grupo = id_grupo === 0 ? null : id_grupo;*/
        set_nivel_grado_grupo.forEach(item => {
            if (parseInt(item.id_nivel) === id_nivel && item.id_grado === id_grado && item.id_grupo === id_grupo) {
                tabla.row($(el).parents('tr')).remove().draw();
                set_nivel_grado_grupo.delete(item);
            }
        });
        console.log(set_nivel_grado_grupo);
    }

    function programar() {
        if ($("#id_fecha_programada").val() !== "" && $("#id_time_hora_programada").val() !== "") {
            $("#modal_programar_para").modal('hide');
            return;
        }
        fail_alerta('¡Datos inválidos, por favor revisar!');
    }

    function adjuntar_ics() {
        var tema_ics = $("#id_tema_evento").val();
        var fecha_ics = $("#id_cuando").val();
        var hora_inicial_ics = $("#id_time_inicial").val();
        var hora_final_ics = $("#id_time_final").val();
        var ubicacion_ics = $("#id_ubicacion").val();

        if (tema_ics === "" || fecha_ics === "" || hora_inicial_ics === "" ||
            hora_final_ics === "" || ubicacion_ics === "") {
            fail_alerta('Debe asignar todos los campos');
            $("#id_icon_done_adjuntado").prop("hidden", true);
            return;
        }
        $("#id_icon_done_adjuntado").prop("hidden", false);
        $("#modal_adjuntar").modal('hide');
    }

    function cancelar_adjuntar_ics() {
        $("#id_tema_evento").val("");
        $("#id_cuando").val("");
        $("#id_time_inicial").val("");
        $("#id_time_final").val("");
        $("#id_ubicacion").val("");
        $("#id_icon_done_adjuntado").prop("hidden", true);
    }

    function validar_horario_ics() {
        if (parseInt($("#id_time_inicial").val().split(":")[0]) > parseInt($("#id_time_final").val().split(":")[0])) {
            $("#id_time_final").val("");
            fail_alerta('¡La hora final debe ser mayor a la hora inicial!');
        }
    }

    function desprogramar() {
        $("#id_fecha_programada").val('');
    }

    function chk_enviar_todos(value) {
        if (value) {
            $("#select_usuarios").selectpicker('selectAll');
            success_alerta('Ha seleccionado enviar a todos los usuarios disponibles');
        } else {
            $("#select_usuarios").selectpicker('deselectAll');
            success_alerta('Ha quitado enviar a todos los usuarios disponibles');
        }
        $("#select_usuarios").selectpicker('render');
    }

    function add_grupo_especial_table(el) {
        let tabla = $('#add_grupos_especiales_table').DataTable();
        let set = new Set($(el).selectpicker('val'));
        set_grupos_especiales.clear();
        tabla.clear().draw();
        set.forEach(item => {
            catalogo_grp_especiales.forEach(itemCatalogo => {
                if (itemCatalogo.id_grp_especial === parseInt(item)) {
                    set_grupos_especiales.forEach(itemAsignado => {
                        if (itemAsignado.id_grp_especial === parseInt(item)) {
                            set_grupos_especiales.delete(itemAsignado);
                        }
                    });
                    set_grupos_especiales.add({
                        id_grp_especial: itemCatalogo.id_grp_especial,
                        grupo: itemCatalogo.grupo
                    });
                    tabla.row.add([
                        itemCatalogo.grupo.toUpperCase(),
                        `<button type="button"
                                class="btn btn-warning text-white btn-squared btn-sm ml-2"
                                onclick="remove_grp_especial_tabla(this, ${itemCatalogo.id_grp_especial});">
                            X
                        </button>`
                    ]).draw().node();
                }
            });
        });
    }

    function remove_grupo_especial_table() {
        let tabla = $("#add_grupos_especiales_table").DataTable();
        $("#select_grupos_especiales").selectpicker('deselectAll');
        tabla.clear().draw();
        set_grupos_especiales.clear();
    }

    function add_grupos_administrativos_table(el) {
        let tabla = $("#add_grupos_administrativos_table").DataTable();
        let set = new Set($(el).selectpicker('val'));
        set_grupos_administrativos.clear();
        tabla.clear().draw();
        set.forEach(item => {
            catalogo_grp_administrativos.forEach(itemCatalogo => {
                if (itemCatalogo.id_grp_administrativo === parseInt(item)) {
                    set_grupos_administrativos.forEach(itemAsignado => {
                        if (itemAsignado.id_grp_administrativo === parseInt(item)) {
                            set_grupos_administrativos.delete(itemAsignado);
                        }
                    });
                    set_grupos_administrativos.add({
                        id_grp_administrativo: itemCatalogo.id_grp_administrativo,
                        grupo: itemCatalogo.grupo
                    });
                    tabla.row.add([itemCatalogo.grupo.toUpperCase(),
                        `<button type="button"
                                class="btn btn-warning text-white btn-squared btn-sm ml-2"
                                onclick="remove_grp_adm_tabla(this, ${itemCatalogo.id_grp_administrativo});">
                            X
                        </button>`
                    ]).draw().node();
                }
            });
        });
    }

    function remove_grupo_administrativos_table() {
        let tabla = $("#add_grupos_administrativos_table").DataTable();
        $("#select_grupos_administrativos").selectpicker('deselectAll');
        tabla.clear().draw();
        set_grupos_administrativos.clear();
    }

    function add_usuarios_table() {
        let select_usuarios = new Set($("#select_usuarios").val());
        let tabla = $("#id_table_usuarios").DataTable();
        tabla.clear().draw();
        select_usuarios.forEach(item => {
            catalogo_usuarios.forEach(usuario => {
                if (usuario.id_usuario == item) {
                    tabla.row.add([usuario.nombre,
                        `<button type="button" class="btn btn-warning text-white btn-squared btn-sm ml-5"
                                onclick="remove_usuario_tabla(this, ${usuario.id_usuario});">
                            X
                        </button>`
                    ]).draw().node();
                }
            });
        });
    }

    //elimina items individuales de las tablas de grupos especiales y administrativos, y usaurios
    function remove_grp_especial_tabla(el, id_grp_especial) {
        set_grupos_especiales.forEach(item => {
            if (item.id_grp_especial === id_grp_especial) {
                set_grupos_especiales.delete(item);
                $("#add_grupos_especiales_table").DataTable().row($(el).parents('tr')).remove().draw();
                let set_grp_especiales = new Set($("#select_grupos_especiales").val());
                set_grp_especiales.forEach(item_grp_especial => {
                    if (parseInt(item_grp_especial) === id_grp_especial) {
                        set_grp_especiales.delete(item_grp_especial);
                        $("#select_grupos_especiales").val(Array.from(set_grp_especiales));
                        $("#select_grupos_especiales").selectpicker('refresh');
                    }
                });
            }
        });
    }

    function remove_grp_adm_tabla(el, id_grp_administrativo) {
        set_grupos_administrativos.forEach(item => {
            if (item.id_grp_administrativo === id_grp_administrativo) {
                set_grupos_administrativos.delete(item);
                $("#add_grupos_administrativos_table").DataTable().row($(el).parents('tr')).remove().draw();
                let set = new Set($("#select_grupos_administrativos").val());
                set.forEach(item_grp_adm => {
                    if (parseInt(item_grp_adm) === id_grp_administrativo) {
                        set.delete(item_grp_adm);
                        $("#select_grupos_administrativos").val(Array.from(set));
                        $("#select_grupos_administrativos").selectpicker('refresh');
                    }
                });
            }
        });
    }

    function remove_usuario_tabla(el, id_usuario) {
        let set_usuarios = new Set($("#select_usuarios").val());
        let tabla = $("#id_table_usuarios").DataTable();
        set_usuarios.forEach(item => {
            if (parseInt(item) === id_usuario) {
                set_usuarios.delete(item);
                $("#select_usuarios").val(Array.from(set_usuarios));
                $('#select_usuarios').selectpicker('refresh');
                tabla.row($(el).parents('tr')).remove().draw();
            }
        });
    }

    function coleccion_nivel() {
        set_nivel_grado_grupo.forEach(item => {
            if (item.id_nivel === 0) {
                set_nivel_grado_grupo.delete(item);
            }
        })
        return Array.from(set_nivel_grado_grupo)
    }

    function add_ruta_manana() {
        let set = new Set($("#id_select_camiones").val());
        let tabla = $("#add_camiones_table").DataTable();
        set_rutas_manana_asignadas.clear();
        tabla.clear().draw();
        set.forEach(ruta => {
            set_catalogo_rutas_manana.forEach(catalogo => {
                if (catalogo.id_ruta_manana === ruta) {
                    let td = `Ruta: ${catalogo.nombre_ruta} | Camión: ${catalogo.camion}`;
                    let btn = `<a href="#!"
                                   class="btn btn-sm btn-warning btn-squared text-white ml-2"
                                   onclick="remover_ruta_manana(this, ${catalogo.id_ruta_manana});"> X
                               </a>`;
                    //comprueba si ruta existe en lista de asignados para no hacer duplicados
                    set_rutas_manana_asignadas.forEach(item => {
                        if (item.id_ruta_manana === ruta) {
                            set_rutas_manana_asignadas.delete(item);
                        }
                    });
                    set_rutas_manana_asignadas.add({
                        id_ruta_manana: catalogo.id_ruta_manana,
                        nombre_ruta: catalogo.nombre_ruta,
                        camion: catalogo.camion
                    });
                    tabla.row.add([td, btn]).draw().node();
                }
            });
        });
    }

    function add_ruta_tarde() {
        let set = new Set($("#id_select_camiones_tarde").val());
        let tabla = $("#add_camiones_tarde_table").DataTable();
        set_rutas_tarde_asignada.clear();
        tabla.clear().draw();
        set.forEach(ruta => {
            set_catalogo_rutas_tarde.forEach(catalogo => {
                if (catalogo.id_ruta_tarde === ruta) {
                    let td = `Ruta: ${catalogo.nombre_ruta} | Camión: ${catalogo.camion}`;
                    let btn = `<a href="#!"
                                   class="btn btn-sm btn-warning btn-squared text-white ml-2"
                                   onclick="remover_ruta_tarde(this, ${catalogo.id_ruta_tarde});"> X
                               </a>`;
                    //comprueba si ruta existe en lista de asignados para no hacer duplicados
                    set_rutas_tarde_asignada.forEach(item => {
                        if (item.id_ruta_tarde === ruta) {
                            set_rutas_tarde_asignada.delete(item);
                        }
                    });
                    set_rutas_tarde_asignada.add({
                        id_ruta_tarde: catalogo.id_ruta_tarde,
                        nombre_ruta: catalogo.nombre_ruta,
                        camion: catalogo.camion
                    });
                    tabla.row.add([td, btn]).draw().node();
                }
            });
        });
    }

    function remover_ruta_manana(el, id_ruta_manana) {
        set_rutas_manana_asignadas.forEach(item => {
            if (parseInt(item.id_ruta_manana) === id_ruta_manana) {
                set_rutas_manana_asignadas.delete(item);
                $("#add_camiones_table").DataTable().row($(el).parents('tr')).remove().draw();
            }
        });
    }

    function remover_ruta_tarde(el, id_ruta_tarde) {
        set_rutas_tarde_asignada.forEach(item => {
            if (parseInt(item.id_ruta_tarde) === id_ruta_tarde) {
                set_rutas_tarde_asignada.delete(item);
                $("#add_camiones_tarde_table").DataTable().row($(el).parents('tr')).remove().draw();
            }
        });
    }

    function coleccion_usuarios_ruta_manana() {
        let usuarios_ruta_manana = new Set();
        set_rutas_manana_asignadas.forEach(asignado => {
            set_catalogo_usuarios_ruta_manana.forEach(item => {
                if (asignado.id_ruta_manana === item.id_ruta_manana) {
                    usuarios_ruta_manana.add({
                        id_usuario: item.id_usuario,
                        id_alumno: item.id_alumno,
                        turno: 1,
                        id_ruta_manana: asignado.id_ruta_manana
                    });
                }
            });
        });
        return Array.from(usuarios_ruta_manana);
    }

    function coleccion_usuarios_ruta_tarde() {
        let usuarios_ruta_tarde = new Set();
        set_rutas_tarde_asignada.forEach(asignado => {
            set_catalogo_usuarios_ruta_tarde.forEach(item => {
                if (asignado.id_ruta_tarde === item.id_ruta_tarde) {
                    usuarios_ruta_tarde.add({
                        id_usuario: item.id_usuario,
                        id_alumno: item.id_alumno,
                        turno: 2,
                        id_ruta_tarde: asignado.id_ruta_tarde
                    });
                }
            });
        });
        console.log(usuarios_ruta_tarde)
        return Array.from(usuarios_ruta_tarde);
    }

    //catalogo_usuario_ruta, set_camiones_manana
</script>
</body>
</html>