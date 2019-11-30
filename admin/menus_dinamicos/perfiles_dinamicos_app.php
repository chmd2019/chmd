<ul class="list-unstyled components">
    <li><a href="<?= $root_menu_session ?>" class="text-white">INICIO</a></li>
</ul>
<ul class="list-unstyled components">
    <?php
    $perfiles = mysqli_query($conexion, "SELECT * FROM Ventana_modulos_transporte WHERE  idseccion=8 order by modulo;");

    while ($perfil = mysqli_fetch_assoc($perfiles)) {
        $id = $perfil['id'];
        $modulo = $perfil ['modulo'];
        $link = $perfil ['link'];
        $id_capacidad = $perfil['id_capacidad'];

        if (in_array($id_capacidad, $capacidades)) {

            if ($id == $perfil_actual) {
                ?>
                <li>
                    <a class="activo" href="<?= $link ?>"><?= $modulo ?></a>
                </li>
                <?php
            } else {
                ?>
                <li>
                    <a class="text-white primary-hover" href="<?= $link ?>"><?= $modulo ?></a>
                </li>
                <?php
            }
        }
    }
    ?>
</ul>
<ul class="list-unstyled components">
    <li><a href="<?= $root_close_session ?>" class="text-white"><span class="glyphicon glyphicon-user" ></span> CERRAR SESION</a></li>
</ul>