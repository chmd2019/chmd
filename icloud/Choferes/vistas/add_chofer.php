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
  <label for="Chofer" style="margin-left: 1rem">Nombre y Apellido</label>
  <div class="input-field">
    <i class="material-icons prefix c-azul">person</i>
    <input value=""
    id="Chofer<?=$n?>"
    style="font-size: 1rem"
    type="text" placeholder="INGRESE NOMBRE Y APELLIDO" />
  </div>
</div>
<div class="col s12 l6">
  <label for="Chofer" style="margin-left: 1rem">Celular</label>
  <div class="input-field">
    <i class="material-icons prefix c-azul">phone</i>
    <input value=""
    id="celular<?=$n?>"
    style="font-size: 1rem"
    type="text" placeholder="INGRESE NUMERO CELULAR" />
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
