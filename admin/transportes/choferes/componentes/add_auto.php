<tr>
  <td class="checks-autos" ><input  type="checkbox" name="" value="<?=$j?>" onchange="mostrar_auto_<?=$j?>()" >Agregar Automovil</td>
</tr>
<tr  id='add_auto_<?=$j?>' hidden>
  <td colspan="1">
    Marca:
    <input
    name="marca_auto" id="marca<?=$j?>" type="text"
    class="form-control" placeholder="Agrege la marca del auto"  >
  </td>
  <td colspan="1">
    Modelo:
    <input
    name="modelo_auto" id="modelo<?=$j?>" type="text"
    class="form-control" placeholder="Agrege el modelo del auto"  >
  </td>
  <td colspan="1">
    Color:
    <input
    name="color_auto" id="color<?=$j?>" type="text"
    class="form-control" placeholder="Agrege el color del auto"  >
  </td>
  <td colspan="1">
    Placa:
    <input
    name="placa_auto" id="placa<?=$j?>" type="text"
    class="form-control" placeholder="Agrege la placa del auto"  >
  </td>
</tr>
<tr>
  <td><br> </td>
</tr>
<script type="text/javascript">
function mostrar_auto_<?=$j?>(){
    if( $('#add_auto_<?=$j?>').prop('hidden')){
      $('#add_auto_<?=$j?>').prop('hidden',false);
    }else{
      $('#add_auto_<?=$j?>').prop('hidden',true);
    }
  }
</script>
