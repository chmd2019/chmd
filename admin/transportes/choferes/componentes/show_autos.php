<table border="0" WIDTH="100%">
  <tr>
    <td WIDTH="100%" colspan="5"><br>
      <h4><b>Automoviles Registrados</b></h4><br>
    </td>
  </tr>
  <tr>
    <td WIDTH="20%" colspan="1">Marca:</td>
    <td WIDTH="20%" colspan="1">Modelo:</td>
    <td WIDTH="10%" colspan="1">Año:</td>
    <td WIDTH="15%" colspan="1">Color:</td>
    <td WIDTH="15%" colspan="1">Placa:</td>
    <td WIDTH="10%" colspan="1">Tarjeton:</td>
    <td WIDTH="10%" colspan="1"></td>
  </tr>
<?php
$sql = mysqli_query ( $conexion, "SELECT * from tarjeton_automoviles where idfamilia=$familia and estatus='2' limit 2" );
  while ( $auto = mysqli_fetch_assoc ( $sql ) ){
    $id_auto= $auto['idtarjeton'];
    $marca= $auto['marca'];
    $submarca= $auto['submarca'];
    $modelo= $auto['modelo'];
    $color= $auto['color'];
    $placa= $auto['placa'];
    $tarjeton= $id_auto;
  ?>
  <tr>
    <td  WIDTH="20%" colspan="1">
      <input
      name="marca" id="marca" type="text"
      class="form-control" placeholder="Sin Marca"   value="<?php echo $marca ?>" readonly="" >
    </td>
    <td  WIDTH="20%" colspan="1">
      <input
      name="submarca" id="submarca" type="text"
      class="form-control" placeholder="Sin Modelo"   value="<?php echo $submarca ?>" readonly="" >
    </td>
    <td  WIDTH="10%" colspan="1">
      <input
      name="modelo" id="modelo" type="text"
      class="form-control" placeholder="Sin Año"   value="<?php echo $modelo ?>" readonly="" >
    </td>
    <td  WIDTH="15%" colspan="1">
      <input
      name="color" id="color" type="text"
      class="form-control" placeholder="Sin Color"   value="<?php echo $color ?>" readonly="" >
    </td>
    <td  WIDTH="15%" colspan="1">
      <input
      name="placa" id="placa" type="text"
      class="form-control" placeholder="Sin Placa"   value="<?php echo $placa ?>" readonly="" >
    </td>
    <td  WIDTH="10%" colspan="1">
      <input
      name="tarjeton" id="tarjeton" type="text"
      class="form-control" placeholder="Sin Tarjeton"   value="<?php echo $tarjeton ?>" readonly="" >
    </td>
    <td WIDTH="10%" colspan="1">
      <a class="" type="button" name="button" onclick="cancelar_auto(<?=$id_auto?>)">
        <?php include 'componentes/btn_eliminar.php' ?>
      </a>
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
