$(document).ready(function()
{
    
  
  var addButton = $('.btn-danger'); //Add button selector
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
  
  /////*

  
    




//////////////////////////////////////////////
/*
$("#temavalida").blur(function()
{

///////////////////////////////////////////////
  var temavalida = $('#temavalida').val();
     $.ajax(
	{
		url : 'Validar_temas.php?ValidaTema=true&temavalida='+temavalida,
					dataType : 'json',
				}).done(function(data) {
			if (data.id == '-1')
                        {
                  // nomcampo.focus();    // Damos el foco al control
                  // nomcampo.style.backgroundColor = "#FF4D4D";
                  $(this).css("background-color", "#FFFFCC");
                   alertify.error("Error: nombre del tema ya existe"+temavalida);  
                   $( "#temavalida" ).focus();
               
                   return false; //devolvemos el foco
			} 
                        else 
                        {
			///	alert("temavalida"+temavalida);
			}
		});





/////////////////////////////////////
});





*/

////////////////////////////////////////////////

  
  });