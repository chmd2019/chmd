<?php
$grupos = $control_administrativo->select_grupos_administrativos();
?>
<div class="row justify-content-around">
    <div class="card col-sm-12 col-md-6 border panel-personalizado">
        <div class="card-body p-0 pt-5">
            <h6 class="text-primary border-bottom">
                <i class="material-icons">group</i>&nbsp;&nbsp;LISTADO DE GRUPOS ADMINISTRATIVOS
            </h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table_adm">
                    <thead>
                        <tr>
                            <th>ID Grupo</th>
                            <th>Grupo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($grupos)) :
                            ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['grupo']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="row justify-content-around">
            </div>
        </div>
        <br>
        <br>
    </div>

    <div class="card col-sm-12 col-md-5 border panel-personalizado">
        <div class="card-body p-0 pt-5">
            <h6 class="text-primary border-bottom">
                <i class="material-icons">person_add</i>&nbsp;&nbsp;NUEVO GRUPO ADMINISTRATIVO
            </h6>
            <form class="needs-validation" novalidate onsubmit="return false;">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Nombre del grupo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="material-icons">group</i></span>
                            </div>
                            <input type="text"
                                   name="nombre"
                                   class="form-control text-uppercase" 
                                   placeholder="Nombre del grupo administrativo"
                                   autocomplete="off"
                                   autofocus
                                   required>
                        </div>
                    </div>         
                </div>
                <button class="btn btn-primary float-right">
                    Guardar &nbsp;&nbsp;<i class="material-icons">save</i>
                </button>
            </form>
        </div>         
    </div>
</div>

<script>
    var flag_guardar = false;
    $(document).ready(function () {
        set_table_desordenada('table_adm');
    });
    function enviar() {
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/admin/app/Administrativos/common/post_nuevo_grupo_administrativo.php",
            type: 'POST',
            dataType:'json',
            beforeSend:()=>{
                spinnerIn();
            },
            data: $('form').serialize()
        }).done((res) => {
            if (res === true) {
                success_alerta('Solicitud exitosa');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        }).always(()=>{
            spinnerOut();
        });
    }
</script>