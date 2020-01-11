<?php
$control_permisos = new ControlPermisos();
$select_perfiles = $control_permisos->select_perfiles();
?>

<section class="border p-3">
    <h4 class="text-primary">Asociar permisos de acceso a modulos según perfiles</h4>
    <br>
    <div class="container-fluid">
        <div class="row">
            <?php
            $i = 0;
            foreach ($select_perfiles as $perfil):
                ?>
                <div class="col-sm-6">
                    <div class="card card-body shadow-none border">
                        <span>Perfil: <?= $perfil['nombre']; ?></span>
                        <?php
                        $flag_activo = boolval($perfil['activo']) == true;
                        if ($flag_activo === true) {
                            echo "<span>Estado:&nbsp;&nbsp;<span class='badge badge-success'>Activo</span></span>";
                        } else {
                            echo "<span>Estado:&nbsp;&nbsp;<span class='badge badge-danger'>Inactivo</span></span>";
                        }
                        ?>
                        <br>
                        <div class="row">
                            Permisos:
                            <div class="row col-sm-8">
                                <?php
                                $permisos_activos = array();
                                $select_permisos = $control_permisos->select_permisos($perfil['id_perfil']);
                                foreach ($select_permisos as $permiso):
                                    if ($flag_activo):
                                        array_push($permisos_activos, $permiso['id_modulo']);
                                        ?>
                                        <div class="custom-control custom-checkbox ml-3">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="check_<?= $permiso['id_perfiles_modulos']; ?>"
                                                   onchange="mostrar_ocultar_btn_guardar('btn_guardar_<?= $perfil["id_perfil"]; ?>');
                                                           add_modulo(this, <?= $perfil['id_perfil']; ?>, <?= $perfil["id_modulo"]; ?>);"
                                                   checked>
                                            <label class="custom-control-label"
                                                   for="check_<?= $permiso['id_perfiles_modulos']; ?>">
                                                <?= $permiso['modulo']; ?>
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <div class="badge badge-info">
                                            <?= $permiso['modulo']; ?>
                                        </div>
                                    <?php endif;
                                endforeach;
                                $select_modulos = $control_permisos->select_modulos();
                                foreach ($select_modulos as $modulo):
                                    if ($flag_activo):
                                        if (array_search($modulo['id_modulo'], $permisos_activos) === false):
                                            $i++;
                                            ?>
                                            <div class="custom-control custom-checkbox ml-3">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="check_modulo_<?= $i; ?>"
                                                       onchange="mostrar_ocultar_btn_guardar('btn_guardar_<?= $perfil["id_perfil"]; ?>');
                                                               add_modulo(this, <?= $perfil['id_perfil']; ?>, <?= $modulo["id_modulo"]; ?>);">
                                                <label class="custom-control-label"
                                                       for="check_modulo_<?= $i; ?>">
                                                    <?= $modulo['modulo']; ?>
                                                </label>
                                            </div>
                                        <?php
                                        endif;
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <?php if ($flag_activo): ?>
                            <div class="float-right">
                                <br>
                                <button type="button"
                                        class="btn btn-primary btn-squared float-right"
                                        id="btn_guardar_<?= $perfil['id_perfil']; ?>"
                                        onclick="guardar_permisos(<?= $perfil['id_perfil']; ?>);"
                                        hidden>
                                    Guardar <i class="fa fa-save"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <hr>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script>
    var modulos = new Set();

    function mostrar_ocultar_btn_guardar(id_btn) {
        btn = $('#' + id_btn);
        if (btn.prop('hidden')) {
            btn.prop('hidden', false);
        }
    }

    function add_modulo(el, id_perfil, id_modulo) {
        if (el.checked) {
            modulos.add({id_perfil: id_perfil, id_modulo: id_modulo});
        }
    }

    function guardar_permisos(id_perfil) {
        console.log(id_perfil);
    }
</script>