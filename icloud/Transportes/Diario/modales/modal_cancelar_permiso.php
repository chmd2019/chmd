<div class="text-center">
    <button type="button"  class="btn btn-danger ml-1 <?php echo $ver_btn_cancelar; ?>" 
            data-toggle="modal" data-target="#modal_cancelar_permiso_<?php echo "$Idpermiso"; ?>">
        <i class="fas fa-trash ml-1"></i>
    </button>
</div>

<div class="modal fade bottom" id="modal_cancelar_permiso_<?php echo "$Idpermiso"; ?>" tabindex="-1" role="dialog" aria-labelledby="modal_cancelar_permiso_<?php echo "$Idpermiso"; ?>"
     aria-hidden="t`rue">
    <div class="modal-dialog modal-notify modal-danger modal-side modal-top-right" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading">Confirmación</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <p>¿Confirma usted que desea cancelar permiso?</p>
                        </center>
                    </div>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">No</button>
                <button type="button" class="btn b-azul white-text ml-1"
                        onclick="cancelar_permiso_diario('<?php echo "$Idpermiso"; ?>')"> 
                    <i class="fas fa-check white-text"></i>&nbsp;&nbsp;Aceptar
                </button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Danger Demo-->
<script>
    function cancelar_permiso_diario(id) {
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/post_cancela_permiso_diario.php",
            type: "POST",
            data: {id_permiso_diario: id},
            success: function (res) {
                if (res == 1) {
                    swal("Información", "Solicitud realizada con éxito!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 2500);
                }else{
                        swal("Información", "Solicitud no realizada!", "error");
                }
            }
        });
    }
</script>