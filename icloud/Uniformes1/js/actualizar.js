	function ActualizarDatos()
        {
		var cliente_id = $('#cliente_id').attr('value');
		var talla_sudadera = document.getElementById('talla_sudadera').value;
              //  var tiposuda = document.getElementById('tiposuda').value;
                
                var talla_playera = document.getElementById('talla_playera').value;
                var tipoplayera = document.getElementById('tipoplayera').value;
                
                var tipopants = document.getElementById('tipopants').value;
                var tipoedu = document.getElementById('tipoedu').value;
                
                
                
                   var nfamilia = document.getElementById('nfamilia').value;
                   var talla_pants = document.getElementById('talla_pants').value;
                   var talla_educacionf = document.getElementById('talla_educacionf').value;
                   var talla_kinder = document.getElementById('talla_kinder').value;
		
		 var tiposuda = $('input:radio[name=tiposuda]:checked').val();
		
             
              

                
		var idalumno = $("#idalumno").attr("value");
		var status = $("#status").attr("value");
                
              //  var tipopants = $("#tipopants").attr("value");
	//	var tipoedu = $("#tipoedu").attr("value");
               // var tipoplayera = $("#tipoplayera").attr("value");
                ///////
              // swal("Good job!", "You clicked the buttonzzz!", "success");
           
               
        // alert("valor de tipoplayera:"+tipoplayera);
                
                if(tiposuda==0)
		{
		
                swal("Error", "Selecciona tipo de sudadera", "error");
		return false;
		} 
                else if(tiposuda=='undefined' || tiposuda.length<0)
                {
                var tiposuda='3';    
                }
             

              if(tipoplayera==0)
		{
		
                swal("Error", "Selecciona tipo de playera", "error");
                frmClienteActualizar.tipoplayera.focus();    // Damos el foco al control
                frmClienteActualizar.tipoplayera.style.backgroundColor = "#FF4D4D";
		return false;
		}
                   else
               {
               frmClienteActualizar.tipoplayera.style.backgroundColor = "white"; 
               }
                
                
               
                
                
                if(tipopants==0)
		{
		
                 swal("Error", "Selecciona tipo de pants", "error");
                frmClienteActualizar.tipopants.focus();    // Damos el foco al control
                frmClienteActualizar.tipopants.style.backgroundColor = "#FF4D4D";
                
		return false;
		}
               else
               {
               frmClienteActualizar.tipopants.style.backgroundColor = "white"; 
               }
            
                
                
                
                
                if(tipoedu==0)
		{
		
                swal("Error", "Selecciona tipo de eduacion fisica", "error");
                frmClienteActualizar.tipoedu.focus();    // Damos el foco al control
                frmClienteActualizar.tipoedu.style.backgroundColor = "#FF4D4D";
                
		return false;
		}
                 else
               {
               frmClienteActualizar.tipoedu.style.backgroundColor = "white"; 
               }
                  
                /////////////////////////////////////////////
               
		if(talla_sudadera==0)
		{
		
               swal("Error", "Selecciona la talla de la sudadera", "error");
             
                frmClienteActualizar.talla_sudadera.focus();    // Damos el foco al control
                frmClienteActualizar.talla_sudadera.style.backgroundColor = "#FF4D4D";
              
		return false;
		}
                  else
               {
                  
               frmClienteActualizar.talla_sudadera.style.backgroundColor = "white"; 
               }
                
                
                
                
		if(talla_pants==0)
		{
		
                 swal("Error", "Selecciona la talla del pants de pantalon", "error");
                
		  frmClienteActualizar.talla_pants.focus();    // Damos el foco al control
                frmClienteActualizar.talla_pants.style.backgroundColor = "#FF4D4D";
		return false;
		}
                  else
               {
               frmClienteActualizar.talla_pants.style.backgroundColor = "white"; 
               }
                
               
                
                
                
		if(talla_playera==0)
		{
		
                
                 swal("Error", "Selecciona la talla  de la  playera", "error");
		  frmClienteActualizar.talla_playera.focus();    // Damos el foco al control
                frmClienteActualizar.talla_playera.style.backgroundColor = "#FF4D4D";
		return false;
		}
                  else
               {
               frmClienteActualizar.talla_playera.style.backgroundColor = "white"; 
               }
                
  
                
                
		if(talla_educacionf==0)
		{
		
                 swal("Error", "Selecciona la talla  del pants de educacion fisica", "error");
		  frmClienteActualizar.talla_educacionf.focus();    // Damos el foco al control
                frmClienteActualizar.talla_educacionf.style.backgroundColor = "#FF4D4D";
		return false;
		}
                  else
               {
               frmClienteActualizar.talla_educacionf.style.backgroundColor = "white"; 
               }
               
               if(talla_kinder==0)
		{
		
                 swal("Error", "Selecciona la talla  del pants kinder", "error");
		  frmClienteActualizar.talla_kinder.focus();    // Damos el foco al control
                frmClienteActualizar.talla_kinder.style.backgroundColor = "#FF4D4D";
		return false;
		}
                  else
               {
               frmClienteActualizar.talla_kinder.style.backgroundColor = "white"; 
               }
                
              
                
		
		$.ajax({
			url: 'actualizar.php',
			type: "POST",
			data: "submit=&talla_sudadera="+talla_sudadera+"&talla_pants="+talla_pants+"\
                                      &talla_playera="+talla_playera+"\
                                      &talla_educacionf="+talla_educacionf+"\
                                      &talla_kinder="+talla_kinder+"\
                                      &idalumno="+idalumno+"\
                                      &tiposuda="+tiposuda+"\
                                      &tipoplayera="+tipoplayera+"\
                                      &tipopants="+tipopants+"\
                                      &tipoedu="+tipoedu+"\
                                      &nfamilia="+nfamilia+"\
                                      &status="+status+"\
                                      &cliente_id="+cliente_id,
			success: function(datos)
                        {
                            //swal("Good job!", datos, "success");
				alert(datos);
				//ConsultaDatos();
				$("#formulario").hide();
				$("#tabla").show();
                                window.location = window.location;
                                
			}
		});
		return false;
	}
	
	function ConsultaDatos(){
		$.ajax({
			url: 'consulta.php',
			cache: false,
			type: "GET",
			success: function(datos){
				$("#tabla").html(datos);
			}
		});
	}
	


	function Cancelar(){
		$("#formulario").hide();
		$("#tabla").show();
		return false;
	}
	
