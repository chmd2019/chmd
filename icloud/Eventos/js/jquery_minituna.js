$(document).ready(function()
{
    
    //////////////////proceso modal////////////////////////////////////////////////////
 $("#add_data_Modal").appendTo("body"); 
 $('#insert_form').on("submit", function(event)
 {  
  event.preventDefault();  
  if($('#tema').val() == "")  
  {  
   alert("tema obligatorio");  
  }  
  else if($('#acuerdos').val() == '')  
  {  
   alert("acuerdos obligatorio");  
  }  
  
   
  else  
  {  
   $.ajax({  
    url:"Agregar_tema.php",  
    method:"POST",  
    data:$('#insert_form').serialize(),  
    beforeSend:function(){  
     $('#insert').val("Agregando");  
    },  
    success:function(data)
    {  
     $('#insert_form')[0].reset();  
     $('#add_data_Modal').modal('hide');  
     $('#employee_table').html(data);  
    }  
   });  
  }  
 });
 ////////////////////////////////////////////proceso de eliminacion de imagen////////////////////////////////////
 
    ////////////////////////////////////////////////////////////////////////////
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
             //////////////////////////////////////////////////////////
var addButton = $('.btn-primary'); //Add button selector
  var wrapper = $('.col-sm-9'); //Input field wrapper
  var fieldHTML = '<div style="margin-top:10px"class="input-group"> <input type="text" name="field_producto[]" class="form-control"  placeholder="Ingresa tema" required>    <div class="input-group-btn">  <button type="button" id="btn-erase" class="btn btn-danger">-</button></div></div>'; //New input field html
  $(addButton).click(function()
  { //Once add button is clicked
        $(wrapper).append(fieldHTML);
       
  });
  $(wrapper).on('click', '#btn-erase', function(e)
  { //Once remove button is clicked
      e.preventDefault();
       $(this).parent().parent().remove(); //Remove field html
       
  });
  ////////////////////////////proceso de sistencia///////////////////////////////////////////////////////////
     
   //////////////////////////////////////////////////////////////////////////////////////////////    
      $("#integrante1").on('click',function(){ if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante2").on('click',function(){ if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante3").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante4").on('click',function(){ if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante5").on('click',function(){ if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante6").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); }; Asistencia(valor,usu); });
      $("#integrante7").on('click',function(){ if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante8").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante9").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante10").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante11").on('click',function(){ if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante12").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante13").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });
      $("#integrante14").on('click',function(){  if( $(this).is(':checked') ){var valor=1; var usu=$(this).val();} else {var valor=2; var usu=$(this).val(); } Asistencia(valor,usu); });        
          
             
             /////////////////////////////////////////////////////
             
             function Asistencia(valor,usu) 

          {
              
       
             var id_evento = $('#idusuario').val();
             
        
//////////////////////////////////////////////////////////////////////
                $.ajax(
	              {
                          url : 'Validar_temas.php?CambioAsistencia=true&idusuario='+usu+'&id_evento='+id_evento+'&status1='+valor,dataType : 'json',
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
              
              ////////////////////////////////////////////////////////
              
              
                 
             }    
             
    

  });
  
  