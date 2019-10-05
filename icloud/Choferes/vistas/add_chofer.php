<div class="switch">
  <label class="checks-choferes">
      <input  type="checkbox"
             id="c_sw_<?php echo $n; ?>"
             value="<?php echo $n;?>" onchange="mostrar_chofer_<?=$n?>()"/>
      <span class="lever"></span>
      AÑADIR CHOFER
  </label>
</div>
<br>
<div class="row" id='addchofer_<?=$n?>'  style="padding:0rem .5rem;"  hidden>
<div class="col s12 l6">
  <label for="Chofer" style="margin-left: 1rem">Nombres</label>
  <div class="input-field" style="margin:0">
    <i class="material-icons prefix c-azul">person</i>
    <input value=""
    id="Chofer<?=$n?>"
    style="font-size: 1rem"
    type="text" placeholder="INGRESE NOMBRES" onkeyup="may_nombre_<?=$n?>()" />
  </div>
</div>
<div class="col s12 l6">
  <label for="Chofer" style="margin-left: 1rem">Apellidos</label>
  <div class="input-field" style="margin:0">
    <i class="material-icons prefix c-azul">person</i>
    <input value=""
    id="Apellido<?=$n?>"
    style="font-size: 1rem"
    type="text" placeholder="INGRESE APELLIDOS" onkeyup="may_apellido_<?=$n?>()" />
  </div>
</div>
</div>
<script type="text/javascript">
function mostrar_chofer_<?=$n?>(){
    if( $('#addchofer_<?=$n?>').prop('hidden')){
      $('#addchofer_<?=$n?>').prop('hidden',false);
        $('#addauto_<?=$n?>').prop('hidden',false);
    }else{
      $('#addchofer_<?=$n?>').prop('hidden',true);
        $('#addauto_<?=$n?>').prop('hidden',true);
    }
  }

function may_nombre_<?=$n?>(){
  var texto = $("#Chofer<?=$n?>").val();
  texto = texto.toLowerCase();
  texto = ucwords(texto);

  //alert(texto);
  $("#Chofer<?=$n?>").val(texto);
}

function may_apellido_<?=$n?>(){
  var texto = $("#Apellido<?=$n?>").val();
  texto = texto.toLowerCase();
  texto = ucwords(texto);

  //alert(texto);
  $("#Apellido<?=$n?>").val(texto);
}

function ucwords(oracion){
    return oracion.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1){
       return $1.toUpperCase();
    });
}

</script>
