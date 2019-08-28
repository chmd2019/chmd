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
    type="text" placeholder="INGRESE NOMBRES" />
  </div>
</div>
<div class="col s12 l6">
  <label for="Chofer" style="margin-left: 1rem">Apellidos</label>
  <div class="input-field" style="margin:0">
    <i class="material-icons prefix c-azul">person</i>
    <input value=""
    id="Apellido<?=$n?>"
    style="font-size: 1rem"
    type="text" placeholder="INGRESE APELLIDOS" />
  </div>
</div>
</div>
<script type="text/javascript">
function mostrar_chofer_<?=$n?>(){
    if( $('#addchofer_<?=$n?>').prop('hidden')){
      $('#addchofer_<?=$n?>').prop('hidden',false);
    }else{
      $('#addchofer_<?=$n?>').prop('hidden',true);
    }
  }
</script>
