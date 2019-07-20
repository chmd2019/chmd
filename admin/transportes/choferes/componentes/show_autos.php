<table border="0" WIDTH="100%">
  <tr>
    <td WIDTH="100%" colspan="5"><br>
      <h4><b>Automoviles Registrados</b></h4><br>
    </td>
  </tr>
  <tr>
    <td WIDTH="20%" colspan="1">Marca:</td>
    <td WIDTH="20%" colspan="1">Modelo:</td>
    <td WIDTH="20%" colspan="1">Color:</td>
    <td WIDTH="20%" colspan="1">Placa:</td>
    <td WIDTH="20%" colspan="1"></td>
  </tr>
<?php
$sql = mysqli_query ( $conexion, "SELECT * from Ventana_autos where idfamilia=$familia limit 2" );
  while ( $auto = mysqli_fetch_assoc ( $sql ) ){
    $id_auto= $auto['idcarro'];
    $marca= $auto['marca'];
    $modelo= $auto['modelo'];
    $color= $auto['color'];
    $placa= $auto['placas'];

  ?>
  <tr>
    <td  WIDTH="23%" colspan="1">
      <input
      name="marca" id="marca" type="text"
      class="form-control" placeholder="Sin papa"   value="<?php echo $marca ?>" readonly="" >
    </td>
    <td  WIDTH="23%" colspan="1">
      <input
      name="modelo" id="modelo" type="text"
      class="form-control" placeholder="Sin papa"   value="<?php echo $modelo ?>" readonly="" >
    </td>
    <td  WIDTH="22%" colspan="1">
      <input
      name="color" id="color" type="text"
      class="form-control" placeholder="Sin papa"   value="<?php echo $color ?>" readonly="" >
    </td>
    <td  WIDTH="22%" colspan="1">
      <input
      name="placa" id="placa" type="text"
      class="form-control" placeholder="Sin papa"   value="<?php echo $placa ?>" readonly="" >
    </td>
    <td WIDTH="10%" colspan="1">
      <button class="btn btn-danger" type="button" name="button" onclick="cancelar_auto(<?=$id_auto?>)"><span class="glyphicon glyphicon-remove"></span></button>
    </td>
  </tr>
  <?php
  }
 ?>
  <tr>
    <td><br> </td>
  </tr>
</table>
<script type="text/javascript">
  function cancelar_auto(id){
      $.ajax({
        url: './common/post_cancelar_auto.php',
        type: 'POST',
        data: {
          submit: true,
          id_auto:id
        },
        success: function(res){
          if (res == 1) {
            alert("Guardado exitosamente");
            location.reload();
          } else {
              alert("Ha ocurido un Error");
              setInterval(() => {
                location.reload();

              }, 5000);
          }

        }

      });
  }
</script>
