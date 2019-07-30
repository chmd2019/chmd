<ul class="nav nav-justified">
  <?php
  $perfiles= mysqli_query($conexion, "SELECT * FROM Ventana_modulos_transporte WHERE  idseccion=3 order by id;");//colocer idseccion=3, para nuevo de choferes
  while($perfil = mysqli_fetch_array($perfiles)){
    if ($perfil['modulo']==$perfil_actual){
      ?>
      <li class="active"><a  href="<?=$perfil['link']?>">Solicitudes  <?=$perfil['modulo'];?></a></li>
      <?php
    }else{
      ?>
      <li><a href="<?=$perfil['link']?>">Solicitudes <?=$perfil['modulo'];?></a></li>
      <?php
    }
    ?>
    <?php
  }
  ?>
</ul>
