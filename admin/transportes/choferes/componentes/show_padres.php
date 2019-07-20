<?php
//conseguir Padres
$sql = "SELECT  id, nombre,tipo,fotografia from usuarios where tipo>=3 and tipo<=4 and numero=$familia;";
mysqli_set_charset($conexion, 'utf8');
$padres= mysqli_query($conexion, $sql);
while($familiar=mysqli_fetch_array( $padres))
{
  $tipo= $familiar['tipo'];
  if ($tipo==3){
    //papa
    $nombre_papa=$familiar['nombre'];
  }
  if ($tipo==4){
    //mama
    $nombre_mama=$familiar['nombre'];
  }
}
?>
<table border="0" WIDTH="100%">
  <tr>
    <td WIDTH="100%" colspan="4"><br>
      <h4><b>Padres</b></h4><br>
    </td>
  </tr>
  <?php if (isset($nombre_papa)){
    ?>
    <tr>
      <td  WIDTH="100%" colspan="4">
        Nombre de Papá:
        <input
        name="papa" id="papa" type="text"
        class="form-control" placeholder="Sin papa"   value="<?php echo $nombre_papa ?>" readonly="" >
      </td>
    </tr>
    <?php
  } ?>
  <tr>
    <td><br> </td>
  </tr>
  <?php if (isset($nombre_mama)){
    ?>
    <tr>
      <td  WIDTH="100%" colspan="4">
        Nombre de Mama:
        <input
        name="mama" id="mama" type="text"
        class="form-control" placeholder="Colonia1"   value="<?php echo $nombre_mama ?>" readonly="" >
      </td>
    </tr>
    <?php
  } ?>
</table>
