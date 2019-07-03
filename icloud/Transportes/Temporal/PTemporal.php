<?php
include_once '../components/layout_top.php';
include_once '../components/navbar.php';
require_once '../components/sesion.php';
if (isset($authUrl)) {
    ?>
    <div class="caja-login" align="center">
        <h5 class="c-azul">Mi Maguen</h5>
        <?php echo '<a href="' . $authUrl . '"><img class = "logo-login" src="../../images/google.png"/></a>' ?>
    </div>
    <?php
} else {
    ?>
    <div class="row">    
        <div class="col s12 m12 l9 b-blanco border-azul" style="float: none;margin: 0 auto;"> 
            <div>
                <br>
                <h4 class="c-azul" style="text-align: center;">Cambio temporal</h4>
                <div>
                    <?php include './View_temporal.php'; ?> 
                </div>
                <?php
            }
            ?>               
        </div>
    </div>
</div>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul">
        <i class="large material-icons">edit</i>
    </a>
    <ul>
        <li><a class="btn-floating green accent-3" href="vistas/vista_nuevo_permiso_temporal.php?idseccion=<?php echo $idseccion;?>"><i class="material-icons">add</i></a></li>
        <li><a class="btn-floating blue" href="https://www.chmd.edu.mx/pruebascd/icloud/menu.php?idseccion=<?php echo $idseccion;?>"><i class="material-icons">keyboard_backspace</i></a></li>
            <?php
            echo '<li><a href="' . $redirect_uri . '?logout=1" class="btn-floating red" >'
            . "<i class='material-icons'>exit_to_app</i>Salir</a></li>";
            ?>
    </ul>
</div>

<script>

    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
        setInterval(function(){            
            window.location.reload();
        }, 30000);
    });
</script>

<?php include '../components/layout_bottom.php'; ?>