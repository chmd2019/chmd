<ul class="nav nav-justified">
  <?php
  $perfiles= mysqli_query($conexion, "SELECT * FROM Ventana_modulos_transporte WHERE  idseccion=2 order by id;");
  while($perfil = mysqli_fetch_assoc($perfiles)){
    if ($perfil['modulo']==$perfil_actual){
      ?>
      <li class="active"><a  href="<?=$perfil['link']?>"><?=$perfil['modulo'];?></a></li>
      <?php
    }else{
      ?>
      <li><a href="<?=$perfil['link']?>"><?=$perfil['modulo'];?></a></li>
      <?php
    }
    ?>
    <?php
  }
  ?>
</ul>
