<?php
//Codigo de familia
$familia=$_GET["nfamilia"];
//Cantidad de choferes
$sql = "SELECT count(*) as nchoferes from usuarios where not estatus=4 and tipo=7 and numero=$familia  ;";
mysqli_set_charset($conexion, 'utf8');
$query=mysqli_query($conexion, $sql);
if ($chofer=mysqli_fetch_array( $query)) { $nchoferes= $chofer['nchoferes'];}
//Cantidad de autos
$sql = "SELECT count(*) as nautos from Ventana_autos where  idfamilia=$familia limit 2;";
mysqli_set_charset($conexion, 'utf8');
$query=mysqli_query($conexion, $sql);
if ($auto=mysqli_fetch_array( $query)) { $nautos= $auto['nautos'];}

//conseguir Padres
$sql = "SELECT  id, nombre,tipo,fotografia from usuarios where tipo>=3 and tipo<=4 and numero=$familia limit 2;";
mysqli_set_charset($conexion, 'utf8');
$padres= mysqli_query($conexion, $sql);
while($familiar=mysqli_fetch_array( $padres))
{
  $tipo= $familiar['tipo'];
  if ($tipo==3){
    //papa
    $nombre_papa=$familiar['nombre'];
  }
  if ($tipo ==4){
    //mama
    $nombre_mama=$familiar['nombre'];
  }
}
?>
<center>
  <form id="chofer"  name="chofer" class="form-signin save-nivel" method='post'   onsubmit='enviar_formulario(<?=$nchoferes?>,<?=$nautos?>,<?=$familia?> ); return false'>
    <div class="alert-save"></div>
    <div class="modal-body">
      <table border="0" WIDTH="800">
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
        <tr>
          <td WIDTH="100%" colspan="4"><br>
            <h4><b>Agregar Chofer(es)</b></h4>
          </td>
        </tr>
      <?php
      if($nchoferes==0){
        for ($i=1; $i<= 2; $i++){
          include ('./componentes/add_chofer.php');
        }
      }else if ($nchoferes==1){
        $i=1;
        include ('./componentes/add_chofer.php');
      }else{
        ?>
        <tr>
          <td WIDTH="100%" colspan="4"><br>
            <h6>Esta familia ya cuenta con dos (2)  Choferes registrados.</h6>
          </td>
        </tr>
        <?php
      }
       ?>

          <td WIDTH="100%" colspan="4"><br>
            <h4><b>Agregar Automovil(es)</b></h4>
          </td>
        </tr>
        <?php
        if ($nautos==0){
          for($j =  1; $j <= 2; $j++){
            include ('./componentes/add_auto.php');
          }
        }else if($nautos==1){
          $j=1;
          include ('./componentes/add_auto.php');
        }else{
          ?>
          <tr>
            <td WIDTH="100%" colspan="4"><br>
              <h6>Esta familia ya cuenta con dos (2)  Automoviles registrados.</h6>
            </td>
          </tr>
          <?php
        }
         ?>

        </table>
        <input type="hidden" name="nchoferes" id="nchoferes"  value="<?php echo $nchoferes ?>" />
      <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
    </div>
    <div class="modal-footer">
      <button type="button" onclick="Cancelar(); return false;" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
    </div>
  </form>
</center>
