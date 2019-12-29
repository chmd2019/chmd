<?php
$root = dirname(__DIR__);
require_once "{$root}/menus_dinamicos/Perfiles.php";
$ob_perfiles = new Perfiles();
?>
<ul class="list-unstyled components">
    <li><a href="<?= $root_menu_session ?>" class="text-white">INICIO</a></li>
    <hr style="background-color: #C1C1C1;">
    <?php
    $perfiles = $ob_perfiles->menu_perfil($id_seccion);

    while ($perfil = mysqli_fetch_assoc($perfiles)) :
        $id = $perfil['id'];
        $modulo = $perfil ['modulo'];
        $link = $perfil ['link'];
        $id_capacidad = $perfil['id_capacidad'];
        ?>
        <li>
            <a class="text-white primary-hover" href="<?= $link ?>"><?= $modulo ?></a>
        </li>
    <?php endwhile; ?>
    <li>
        <a href="<?= $root_close_session ?>" class="text-white">
            <span class="glyphicon glyphicon-user"></span> CERRAR SESION
        </a>
    </li>
</ul>