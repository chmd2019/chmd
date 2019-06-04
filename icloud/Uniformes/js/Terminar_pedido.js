	function Terminar_pedido()
{
  
          
		  
		var validar = document.getElementById('validar').value;
                var familia = document.getElementById('familia').value;
            
            
            if (validar==0)
            {
                swal("Error", "Realizar pedido", "error");
                   return false; 
            }
                


                alert("familia"+familia);

                
              
                
		
		$.ajax({
			url: 'View_Adicional.php',
			type: "POST",
			data: "submit=&familia="+familia,
			success: function(datos)
                        {
                           
				
				
                                window.location = window.location;
                                
			}
		});
		return false;
	}