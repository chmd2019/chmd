<?php
switch ($_nivel) {
  case '1':
    ?>
    <a href="alta_extraordinarioKinder.php" style="cursor: pointer; margin:2px" class="btn btn-primary btn-default pull-right btn-nuevo"><span class="glyphicon glyphicon-plus"></span></a>
    <?php
    break;
  case '2':
  ?>
  <a href="alta_extraordinarioPrimaria.php" style="cursor: pointer; margin:2px" class="btn btn-primary btn-default pull-right btn-nuevo"><span class="glyphicon glyphicon-plus"></span></a>
  <?php
    // primaria...
    break;
  case '3':
  ?>
  <a href="alta_extraordinarioBachillerato.php" style="cursor: pointer; margin:2px" class="btn btn-primary btn-default pull-right btn-nuevo"><span class="glyphicon glyphicon-plus"></span></a>
  <?php
    // bachillerato...
      break;
}

if (in_array('11', $capacidades)){
?>
<a href="alta_extraordinario.php" style="cursor: pointer; margin:2px" class="btn btn-primary btn-default pull-right btn-nuevo"><span class="glyphicon glyphicon-plus"></span>Super</a>
<?php  
}
 ?>
