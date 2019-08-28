<div class="switch">

    <label class="checks-autos">

        <input type="checkbox"

               id="a_sw_<?php echo $n; ?>"

               value="<?=$n?>" onchange="mostrar_auto_<?=$n?>()"/>

        <span class="lever"></span>

        AÑADIR AUTOMOVIL

    </label>

</div>

<br>

<div class="row"  id='addauto_<?=$n?>'  style="padding:0rem .5rem;" hidden>

<div   class="col s12 l6">

  <label for="marca" style="margin-left: 1rem">Marca</label>

  <div class="input-field" style="margin:0">

    <i class="material-icons prefix c-azul">airport_shuttle</i>

    <select id="marca<?=$n?>" style="font-size: 1rem"  type="text" >

      <option value="" disabled selected>Seleccione una Marca</option>

      <?php

      $lista_marca = $ctrol->listado_marcas();

      while ($r = mysqli_fetch_array($lista_marca) ){

        $marca = $r['marca'];

        ?>

        <option value="<?=$marca?>"><?=$marca?></option>

        <?php

      }

             ?>

    </select>

  </div>

</div>



    <div class="col s12 l6">

      <label for="submarca" style="margin-left: 1rem">Modelo</label>

      <div class="input-field" style="margin:0">

        <i class="material-icons prefix c-azul">directions_car</i>

        <input value=""

        id="submarca<?=$n?>"

        style="font-size: 1rem"

        type="text" placeholder="INGRESE MODELO" />

      </div>

    </div>

  <div class="col s12 l6">

    <label for="modelo" style="margin-left: 1rem">A&ntilde;o</label>

    <div class="input-field" style="margin:0">

      <i class="material-icons prefix c-azul">directions_car</i>

      <input value=""

      id="modelo<?=$n?>"

      style="font-size: 1rem"

      type="text" placeholder="INGRESE A&Ntilde;O"

      onKeyPress="return solo_numeros(event)"

      maxlength="4"  />

    </div>

  </div>

  <div   class="col s12 l6">

    <label for="color" style="margin-left: 1rem">Color</label>

    <div class="input-field" style="margin:0">

      <i class="material-icons prefix c-azul">color_lens</i>

      <select id="color<?=$n?>" style="font-size: 1rem"  type="text" >

        <option value="" disabled selected>Seleccione un Color</option>

        <?php

        $lista_color = $ctrol->listado_colores();

        while ($r = mysqli_fetch_array($lista_color) ){

          $color = $r['color'];

          ?>

          <option value="<?=$color?>"><?=$color?></option>

          <?php

        }

        ?>

      </select>

    </div>

  </div>



  <div class="col s12 l6">

    <label for="placa" style="margin-left: 1rem">Placa</label>

    <div class="input-field" style="margin:0">

      <i class="material-icons prefix c-azul">aspect_ratio</i>

      <input value=""

      id="placa<?=$n?>"

      style="font-size: 1rem"

      type="text" placeholder="INGRESE PLACA"

      maxlength="8"  />

    </div>

  </div>

</div>

<script type="text/javascript">

function mostrar_auto_<?=$n?>(){

    if( $('#addauto_<?=$n?>').prop('hidden')){

      $('#addauto_<?=$n?>').prop('hidden',false);

    }else{

      $('#addauto_<?=$n?>').prop('hidden',true);

    }

  }

</script>

