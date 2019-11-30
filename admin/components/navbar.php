
<nav class="navbar navbar-light" style="background: #12487E !important; padding: 5px; border-radius:0px; margin-bottom: 0;">
    <a class="navbar-brand" href="https://www.chmd.edu.mx/pruebascd/icloud/">
        <img width="60%" class="logo" src="https://www.chmd.edu.mx/wp-content/uploads/2018/07/LogoMaguenWT.png" >
    </a>
    <?php if (!isset($login)) {
        ?>
        <a   href="<?= $root_close_session ?>" role="button" class="btn btn-common btn-sm d-none d-sm-block" style= "font-family: 'Varela Round';" >
            <span class="glyphicon glyphicon-user" ></span> CERRAR SESION
        </a>
    <?php }
    ?>
    <?php
    if (!isset($seccion)) {
        ?>
        <a href="<?= $root_menu_session ?>" role="button" class="btn btn-common btn-sm d-none d-sm-block" style= "font-family: 'Varela Round';">
            <span class="glyphicon glyphicon-th"></span> MENU
        </a>
        <?php
    }
    ?>
</nav>
<nav class="navbar navbar-expand-lg navbar-light w-0" style="background: #12487E !important; padding: 0px !important;">
    <div class="container-fluid d-inline-block " style="padding: 0px !important;">
        <a  role="button" id="sidebarCollapse" class="btn btn-menu text-white" style="border-radius: 0px; float:right;font-size: 30px">
            <i class="fas fa-bars"></i>
        </a>
    </div>
</nav>
