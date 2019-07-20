<tr>
  <td colspan="1" class="checks-choferes" > <input  type="checkbox" name="" value="<?=$i?>" onchange="mostrar_chofer_<?=$i?>()" > Agregar Chofer</td>
</tr>
<tr id='add_chofer_<?=$i?>' hidden>
  <td colspan="2">
    Nombres:
    <input
    name="nombres_chofer" id="nombres<?=$i?>" type="text"
    class="form-control" placeholder="Agrege los nombres del chofer"  >
  </td>
  <td colspan="2">
    Apellidos:
    <input
    name="apellidos_chofer" id="apellidos<?=$i?>" type="text"
    class="form-control" placeholder="Agrege los apellidos del chofer"  >
  </td>
</tr>
<tr>
  <tr>
    <td><br> </td>
  </tr>
<script type="text/javascript">
function mostrar_chofer_<?=$i?>(){
    if( $('#add_chofer_<?=$i?>').prop('hidden')){
      $('#add_chofer_<?=$i?>').prop('hidden',false);
    }else{
      $('#add_chofer_<?=$i?>').prop('hidden',true);
    }
  }
</script>
