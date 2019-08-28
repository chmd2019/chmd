<a class="waves-effect waves-light btn modal-trigger  blue accent-3"  href="#modal_download_<?php echo "$id_chofer"; ?>">
    <i class="material-icons">file_download</i>
</a>

<div id="modal_download_<?php echo "$id_chofer"; ?>" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Desea Descargar la carta de Autorizacion del chofer?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>
        <a href="#!" class="waves-effect btn-flat b-azul white-text"  onclick="recargar(<?php echo "$id_chofer"; ?>, <?=$familia?>)"  >Aceptar</a>
    </div>
    <br>
</div>
<script type="text/javascript">
function recargar(id, nfamilia){
  var modal_download = M.Modal.getInstance($("#modal_download_"+id));
  modal_download.close();
  //verifica que exitan tarjetones creados y activos...
  $.get("./common/get_cantidad_tarjetones_activos.php", {nfamilia:nfamilia }).done(function(data){
  //  alert(data);
    var res = JSON.parse(data);
    if(res.n_tajetones>0){
      M.toast({html: 'Solicitud realizada con éxito, Descargando...', classes: 'green accent-4'});
      setTimeout(() => {
        window.location="./common/pdf_chofer.php?idchofer=" + id;
      }, 1500);
    }else{
      //No hay tarjetones activos, por lo que no existen autos registrados
      M.toast({html: 'Para Descargar, Debe registrar al menos un automóvil.', classes: 'red accent-4'});
    }
  });
}
</script>
