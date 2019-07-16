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

//asegurarse la cantidad de choferes activos que estan en la $familia
var choferes_activos = document.getElementById('nchoferes').value;
if (choferes_activos>=2){
  alert('La familia tiene dos choferes activos registrados, Debe eliminar uno para almacenar un nuevo chofer. ');
  return false;
}

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
        window.location = "../choferes/PChoferes.php";
			}
		});
		return false;
}


function Cancelar()
{
     window.location.replace("../choferes/PChoferes.php");
}
