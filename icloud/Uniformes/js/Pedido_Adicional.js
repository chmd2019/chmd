	function Pedido_Adicional()
        {
  
          
		var cliente_id = $('#cliente_id').attr('value');
		//var talla_sudadera = document.getElementById('talla_sudadera').value;
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
		
            
           if(tiposuda=="1")
                  {
                      var talla_sudadera = document.getElementById('talla_sudadera1').value;
                      //var talla_pants = document.getElementById('talla_pants1').value;
                  }
                 
	          if(tiposuda=="2")
                  {
                      var talla_sudadera = document.getElementById('talla_sudadera2').value;
                      //var talla_pants = document.getElementById('talla_pants2').value;
                  }
                 

                
		var idalumno = $("#idalumno").attr("value");
		var status = $("#status").attr("value");
                
                
                
                
      
                
                
                
var cantidad_kinder = document.getElementById('cantidad_kinder').value;
var cantidad_sudadera = document.getElementById('cantidad_sudadera').value;
var cantidad_pants = document.getElementById('cantidad_pants').value;
var cantidad_playera = document.getElementById('cantidad_playera').value;
var cantidad_educacionf = document.getElementById('cantidad_educacionf').value;

   
 var idpaquete = $("#idpaquete").attr("value");               
                
      
                
                
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
               
		
                
                
                
                
		
                
               
                
                
            
  
           
               
               
           
               
               
                
               
               
               
                 if(idpaquete==1)
        {
        
                if(cantidad_kinder == 0)
                {
                 swal("Error", "Selecciona cantidad de pants kinder", "error");
		  frmClienteActualizar.cantidad_kinder.focus();    // Damos el foco al control
                frmClienteActualizar.cantidad_kinder.style.backgroundColor = "#FF4D4D";
		return false;
		}
                  else
               {
               frmClienteActualizar.cantidad_kinder.style.backgroundColor = "white"; 
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
		
            
            }
           
            ////////////////
            if(idpaquete==2)
  {
      
      
      if(cantidad_sudadera > 0)
      {
          
              var valida=0;
                  if(tiposuda==0)
		{
		alert("Selecciona tipo de sudadera");
		return false;
		}
                if(talla_sudadera==0)
		{
		
               swal("Error", "Selecciona la talla de la sudadera", "error");
             
                //frmClienteActualizar.talla_sudadera.focus();    // Damos el foco al control
                //frmClienteActualizar.talla_sudadera.style.backgroundColor = "#FF4D4D";
              
		return false;
		}
                  else
               {
                  
               //frmClienteActualizar.talla_sudadera.style.backgroundColor = "white"; 
               }
          
          
      }
      
      else
      {
           var valida=1; 
      }
      if(cantidad_pants > 0)
      {
           var valida1=0;
           if(tipopants==0)
		{
		alert("Selecciona tipo de pants");
		return false;
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
      }
      else
      {
          valida1=1;
      }
      
      if(cantidad_playera > 0)
      {
           var valida2=0;
             if(tipoplayera==0)
		{
		alert("Selecciona tipo de playera");
		return false;
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
                
      }
      else
      {
         var valida2=1; 
      }
      if(cantidad_educacionf > 0)
      {
           var valida3=0;
           if(tipoedu==0)
		{
		alert("Selecciona tipo de eduacion fisica");
		return false;
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
               
                
          
      }
      else
      {
          var valida3=1; 
      }
      
        var  validar=valida+valida1+valida2+valida3;  
           
           if (validar==4)
           {
                 swal("Error", "Genera tu pedido", "error");
               
		return false;
           }
       
  }
          
              if(idpaquete==5 || idpaquete==3 || idpaquete==3)
  {
      
     
      
      if(cantidad_sudadera > 0)
      {
          
              var valida=0;
                  if(tiposuda==0)
		{
		alert("Selecciona tipo de sudadera");
		return false;
		}
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
          
          
      }
      
      else
      {
           var valida=1; 
      }
      if(cantidad_pants > 0)
      {
           var valida1=0;
           if(tipopants==0)
		{
		alert("Selecciona tipo de pants");
		return false;
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
      }
      else
      {
          valida1=1;
      }
      
      if(cantidad_playera > 0)
      {
           var valida2=0;
             if(tipoplayera==0)
		{
		alert("Selecciona tipo de playera");
		return false;
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
                
      }
      else
      {
         var valida2=1; 
      }
      if(cantidad_educacionf > 0)
      {
           var valida3=0;
           if(tipoedu==0)
		{
		alert("Selecciona tipo de eduacion fisica");
		return false;
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
               
                
          
      }
      else
      {
          var valida3=1; 
      }
      
        var  validar=valida+valida1+valida2+valida3;  
           
           if (validar==4)
           {
                 swal("Error", "Genera tu pedido", "error");
               
		return false;
           }
       
  }
         
               
                  
                
                
                

                
              
                
		
		$.ajax({
			url: 'Guardar_Pedido.php',
			type: "POST",
			data: "submit=&talla_sudadera="+talla_sudadera+"\
                                      &talla_pants="+talla_pants+"\
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
                                      &cantidad_kinder="+cantidad_kinder+"\
                                      &cantidad_sudadera="+cantidad_sudadera+"\
                                      &cantidad_pants="+cantidad_pants+"\
                                      &cantidad_playera="+cantidad_playera+"\
                                      &cantidad_educacionf="+cantidad_educacionf+"\
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
	
