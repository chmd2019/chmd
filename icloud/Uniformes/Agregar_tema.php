<?php

if(!empty($_POST))
{
 require('Ctr_minuta.php');
 $objCliente=new Ctr_minuta();
 
 
$tema =  $_POST["tema"];  
$acuerdos =$_POST["acuerdos"];  
//$gender = $_POST["gender"];
$id_evento = $_POST["id_evento"]; 
   

///////////////////////////////////////////////////////////////////////
if ( $objCliente->Evento_Alta2(array($tema,$acuerdos,$id_evento)) == false)
 {
    echo " <h2> <font color='#124A7B'>Temas:</font></h2>  ";    
    $objTema=new Ctr_minuta();
$consulta2=$objTema->mostrar_temas($id_evento);
$counter = 0;      
while( $cliente2 = mysql_fetch_array($consulta2) )
 {
     
$counter = $counter + 1;
$id_tema=$cliente2[0];
$tema=$cliente2[1];
$estatustema=$cliente2[3];
$acuardos=$cliente2[4];
$id_comite=$cliente2[5];
$update=$cliente2[8];               
                 
 ?>                
     <script>
         $(document).ready(function()
{ 
     var dato1 = "<?php echo $estatustema; ?>" ;
     

           $("#status<?php echo"$counter"; ?> option[value='<?php echo $estatustema; ?>']").attr("selected",true);
   
     
     
     
   
    
    
    
});
      
  </script> 

<p>
 <input class="w3-input" name="id_tema<?php echo"$counter"; ?>" type="hidden"  id="id_tema<?php echo"$counter"; ?>" value="<?php echo "$id_tema"; ?>" placeholder="Agregar tutulo" readonly/>
<input  name="titulo1" type="text"  class="confondo" id="tema<?php echo "$counter"; ?>" value="<?php echo "$tema"; ?>" placeholder="Agregar tutulo" readonly/>
             
  <?php
  
  $objTemap=new Ctr_minuta();
$consulta3=$objTemap->mostrar_tema_pendiente2($tema);
$total = mysql_num_rows($consulta3);
 if($total==0)
 {
    if($estatus=='')
{
   if($estatustema==0)
       {
       //validamos si ya agregaron texto pero aun no cambien de estatus
       
       if($update==1)
           {
           echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' >$acuardos</textarea>  ";
           }
           else
           {
              echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' >$acuardos</textarea>  "; 
           }
        
      } 
   else 
   {
      echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' >$acuardos</textarea>  ";  
   }
   
 
}

 }
 else
 {
      while( $cliente3 = mysql_fetch_array($consulta3) )
 {
     $id_tema1=$cliente3[0];
     $tem1a=$cliente3[1];
    $acuardos1=$cliente3[2];
    echo "<textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdosp$counter' name='acuerdos' readonly >$acuardos1</textarea>  ";
    
 }
     if($update==1)
           {
           echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' >$acuardos</textarea>  ";
           }
           else
           {
              echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' ></textarea>  "; 
           }
 }

  ?>
  
<label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Estatus</font></label> 
<select  type="select" name="status<?php echo"$counter"; ?>" class="w3-input" id="status<?php echo"$counter"; ?>"  required> 
<option value="">Selecciona Estatus </option> 
<option value="1">Pendiente</option> 
<option value="2">Concluido</option>
</select>
</p> 
<?php
  }
  }
 else
 {
		echo 'Se produjo un error. Intente nuevamente ';
     
 }

}
?>
 <script>
     $(document).ready(function()
     { 
         $("#status1").change(function(){ var valor=1; muestraAlerta(valor); });
      $("#status2").change(function(){ var valor=2; muestraAlerta(valor); });
      $("#status3").change(function(){ var valor=3; muestraAlerta(valor); });
      $("#status4").change(function(){ var valor=4; muestraAlerta(valor); });
      $("#status5").change(function(){ var valor=5; muestraAlerta(valor); });
      $("#status6").change(function(){ var valor=6; muestraAlerta(valor); });
      $("#status7").change(function(){ var valor=7; muestraAlerta(valor); });
      $("#status8").change(function(){ var valor=8; muestraAlerta(valor); });
      $("#status9").change(function(){ var valor=9; muestraAlerta(valor); });
      $("#status10").change(function(){ var valor=10; muestraAlerta(valor); });
      $("#status11").change(function(){ var valor=11; muestraAlerta(valor); });
      $("#status12").change(function(){ var valor=12; muestraAlerta(valor); });
      $("#status13").change(function(){ var valor=13; muestraAlerta(valor); });
      $("#status14").change(function(){ var valor=14; muestraAlerta(valor); });
      $("#status15").change(function(){ var valor=15; muestraAlerta(valor); });
        
      $("#status16").change(function(){ var valor=16; muestraAlerta(valor); });
      $("#status17").change(function(){ var valor=17; muestraAlerta(valor); });
      $("#status18").change(function(){ var valor=18; muestraAlerta(valor); });
      $("#status19").change(function(){ var valor=19; muestraAlerta(valor); });
      $("#status20").change(function(){ var valor=20; muestraAlerta(valor); });
      $("#status21").change(function(){ var valor=21; muestraAlerta(valor); });
      $("#status22").change(function(){ var valor=22; muestraAlerta(valor); });
      $("#status23").change(function(){ var valor=23; muestraAlerta(valor); });
      $("#status24").change(function(){ var valor=24; muestraAlerta(valor); });
      $("#status25").change(function(){ var valor=25; muestraAlerta(valor); });
      $("#status26").change(function(){ var valor=26; muestraAlerta(valor); });

    
              
             function muestraAlerta(valor) 

          {
              
              
           var id_tema1 = $('#id_tema'+valor).val();  
            var acuerdos1 = $('#acuerdos'+valor).val();
            var status1=$('select[id=status'+valor+']').val();
            var tema1 = $('#tema'+valor).val();
             var idusuario = $('#idusuario').val();
             
        

                $.ajax(
	              {url : 'Validar_temas.php?temanpendientes=true&id_tema1='+id_tema1+'&acuerdos1='+acuerdos1+'&status1='+status1+'&tema1='+tema1+'&idusuario='+idusuario,dataType : 'json',
		     }).done(function(data) 
                     {
			if (data.id == '-1')
                        {

                         alertify.error("Error: ");  
  
			} 
                        else 
                        {
				 alertify.success("Correcto");  
  
			}
		})
              
              
              
              
                 
             }
      
     
    
    
    });
     </script>