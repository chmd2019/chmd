<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/components/sesion.php";
include_once "$root_icloud/components/layout_top.php";



if (isset($authUrl)) {
    header("Location: $redirect_uri?logout=1");
} else {
        $user = $service->userinfo->get();
        $correo = $user->email;
        require_once '../Model/Login.php';
        $objCliente = new Login();
        $consulta = $objCliente->acceso_login($correo);
        include_once "$root_icloud/components/navbar.php";
        ?>
        <div class="row">
          <div class="col s12 m12 l9 b-blanco border-azul" style="float: none;margin: 0 auto;">
              <div>
                  <br>
                  <h4 class="c-azul" style="text-align: center;">Mis Archivos</h4>
                  <div>
                      <?php
                      include './vistas/view_lista_archivos.php';
                        ?>
                  </div>
              </div>
        </div>
        </div>
        <?php
      }
      ?>


<script>
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
    });
</script>
<?php include_once "$root_icloud/components/layout_bottom.php"; ?>
