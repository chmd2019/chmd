function Alta_chofer()
{
  var nombres_chofer = document.getElementById('nombres_chofer').value;
  var apellidos_chofer = document.getElementById('apellidos_chofer').value;
//validacion
if (nombres_chofer==''){
  alert('Debe agregar los nombres del chofer.');
  return false;
}
if (apellidos_chofer==''){
  alert('Debe agregar los apelldos del chofer.');
  return false;
}
//captura de numero de familia
var nfamilia = document.getElementById('nfamilia').value;

$.ajax({
		url: 'Alta_chofer.php',
		type: "POST",
    data : {
      submit: 0,
      nfamilia: nfamilia,
      nombres_chofer:nombres_chofer,
      apellidos_chofer: apellidos_chofer
    },
		success: function(datos)
     {
  			alert("Guardado exitosamente");
        window.location = "../Choferes/PChoferes.php";
			}
		});
		return false;
}


function Cancelar()
{
     window.location.replace("../Choferes/PChoferes.php");
}
