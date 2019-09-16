#!/usr/bin/php -q
<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/DBManager.php";
//include_once("Model/DBManager.php");
//require('Model/Login.php');
require('common/ControlCorreo.php');

use PHPMailer\PHPMailer\PHPMailer;
// Load Composer's autoloader
require '../vendor/autoload.php';

//include("lib/class.phpmailer.php");
//include("lib/class.smtp.php");

//$objCliente=new Login();
$objCliente = new ControlCorreo();
$consulta = $objCliente->PermisosPermanentes();


/*Permiso permanente*/

if($cliente=mysqli_fetch_array($consulta))
{

  $id=$cliente['id_permiso'];
  $correo=$cliente['correo'];
  $estatus=$cliente['estatus'];
  $notificacion1  = $cliente['notificacion1'];
  $notificacion2  = $cliente['notificacion2'];
  $notificacion3  = $cliente['notificacion3'];
  $mensaje=$cliente['mensaje'];
  echo 'id:'. $id . 'correo:'.$correo. 'mensaje:'.$mensaje. 'estatus: '.$estatus. 'notificacion1:'. $notificacion1. 'notificacion2:'. $notificacion2. '$notificacion3:'. $notificacion3 . '<br>';
  /*permiso permanente nuevo*/
  if($estatus==1)
  {
    if($notificacion1==0)
    {
      /*metodo de correo*/
      $resultado3="Hemos recibido su  cambio permanente a la brevedad recibirá respuesta.";
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Host = "smtp.gmail.com";
      //$mail->Port = 465;
      $mail->Port = 587;
      //$mail->SMTPSecure = "ssl";
      $mail->SMTPSecure = "tls";
      $mail->SMTPAuth = true;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';

      $mail->Subject = "Cambio Permanente";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML($resultado3);

      //Set who the message is to be sent from
  //    $mail->setFrom('transportes@chmd.edu.mx', 'Colegio Hebreo Maguen David');

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.

    //  $mail->AddAddress($correo,'transportes');
       $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita');
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');


      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error permanente 1:$id " . $mail->ErrorInfo;
      } else
      {

        if( $objCliente->notificacion_permanente_solicitud($id) == true)
        {
          echo "¡hecho permanente:$id";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE permanente 1:$id¡";}

      }

    }
  }
  /**************permiso permanente Autorizado************************/

  if($estatus==2)
  {
    if($notificacion2==0)
    {
      //metodo de correo//
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'ssl';
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
    //  $mail->From = 'CHMD';
    //  $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Cambio permanente autorizado.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Su cambio permanente ha sido Autorizado..<p>$mensaje</p>");

      //Set who the message is to be sent from
      $mail->setFrom('transportes@chmd.edu.mx', 'Colegio Hebreo Maguen David');

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.
      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita'); //$mail->AddAddress($correo, $correo);
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');

      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error permanente 2: " . $mail->ErrorInfo;
      } else
      {

        if( $objCliente->notificacion_permanente_autorizdo($id) == true)
        {
          echo "¡hecho permanente2:$id";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE permanente 2:$id¡";}

      }




    }

  }
  /************Solicitud  cancelada***********/

  if($estatus==3)
  {
    if($notificacion3==0)
    {
      //metodo de correo//

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Cambio permanente Declinado.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Su cambio permanente ha sido Declinado.<p>$mensaje</p>");

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.
      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita'); //$mail->AddAddress($correo, $correo);
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');

      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error permanente 3:$correo <br>: " . $mail->ErrorInfo;
      } else
      {

        if( $objCliente->notificacion_permanente_declinado($id) == true)
        {
          echo "¡hecho permanente3:$id";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE permanente 3:$id¡";}



      }

    }
  }




}

/******************Fin de permiso permanente**********

/****************Permiso de diario.********************/
$consulta1=$objCliente->PermisosDiarios();



if($cliente1=mysqli_fetch_array($consulta1))
{

  $id1=$cliente1[0];
  $correo1=$cliente1[1];
  $estatus1=$cliente1[2];
  $notificacion11=$cliente1[3];
  $notificacion21=$cliente1[4];
  $notificacion31=$cliente1[5];
  $mensaje1=$cliente1[6];
  /*permiso Diario nuevo*/
  if($estatus1==1)
  {
    if($notificacion11==0)
    {
      /*metodo de correo*/

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Cambio del Dia.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Hemos recibido su  cambio del dia a la brevedad recibirá respuesta.");

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.
      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita');
//      $mail->AddAddress($correo1, $correo1);
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');
      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error diario:$correo1 " . $mail->ErrorInfo;
      } else
      {
        echo"$correo1<br>;";

        if( $objCliente->notificacion_dia_solicitud($id1) == true)
        {
          echo "¡hecho dia:$id1<br>";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE dia 1:$id1<br>¡";}


      }

    }
  }
  /**************permiso Diario Autorizado************************/

  if($estatus1==2)
  {
    if($notificacion21==0)
    {
      /*metodo de correo*/

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Cambio del dia autorizado.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Su cambio del dia ha sido Autorizado.<p>$mensaje1</p>");

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');
      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita');
      //$mail->AddAddress($correo1, $correo1);
      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error diario2:$correo1: " . $mail->ErrorInfo;
      } else
      {

        if( $objCliente->notificacion_dia_autorizdo($id1) == true)
        {
          echo "¡hecho dia 2:$id<br>";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE dia2:$id1<br>¡";}



      }

    }
  }
  /************Solicitud  cancelada***********/
  if($estatus1==3)
  {
    if($notificacion31==0)
    {
      /*metodo de correo*/

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Cambio del dia Declinado.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Su cambio del dia ha sido Declinado.<p>$mensaje1</p>");

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');
      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita');
      //$mail->AddAddress($correo1, $correo1);
      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error diario3:$correo1: " . $mail->ErrorInfo;
      } else
      {


        if( $objCliente->notificacion_dia_declinado($id1) == true)
        {
          echo "¡hecho dia 3:$id1<br>";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE¡ dia 3:$id1 <br>";}

      }

    }
  }


}
/********************Permiso de viaje o temporales************************/
$consulta2=$objCliente->PermisosTemporales();




if($cliente2=mysqli_fetch_array($consulta2))
{

  $id2=$cliente2[0];
  $correo2=$cliente2[1];
  $estatus2=$cliente2[2];
  $notificacion12=$cliente2[3];
  $notificacion22=$cliente2[4];
  $notificacion32=$cliente2[5];


  $mensaje2=$cliente2[6];
  /*permiso Temporal nuevo*/
  if($estatus2==1)
  {
    if($notificacion12==0)
    {
      /*metodo de correo*/

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Cambio Temporal.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Hemos recibido su  cambio temporal a la brevedad recibirá respuesta.");

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.

      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita'); //$mail->AddAddress($correo2, $correo2);
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');
      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error temporas:$correo1: " . $mail->ErrorInfo;
      } else
      {

        ///////////////////

        if( $objCliente->notificacion_viaje_solicitud($id2) == true)
        {
          echo "¡hecho:$id2";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE¡";}
        //////////////////


      }

    }
  }
  /**************permiso Viaje Autorizado************************/

  if($estatus2==2)
  {
    if($notificacion22==0)
    {
      /*metodo de correo*/

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Su cambio temporal ha sido autorizado.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Su cambio Temporal ha sido Autorizado.<p>$mensaje2</p>");

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.

      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita'); //$mail->AddAddress($correo2, $correo2);
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');
      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error temporas2:$correo1: " . $mail->ErrorInfo;
      } else
      {
        if( $objCliente->notificacion_viaje_autorizdo($id2) == true)
        {
          echo "¡hecho:$id2";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE¡";}

      }

    }
  }


  /************Solicitud  de viaje cancelada***********/

  if($estatus2==3)
  {
    if($notificacion32==0)
    {
      /*metodo de correo*/

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->Username = "transportes@chmd.edu.mx";
      $mail->Password = "Chmd2017.";
      $mail->From = 'CHMD';
      $mail->FromName = 'Colegio Hebreo Maguen David ';
      $mail->Subject = "Cambio Declinado.";
      $mail->AltBody = "El correo ha sido enviado.";
      $mail->MsgHTML("Su cambio Temporal ha sido Declinado.<p>$mensaje2</p>");

      // Adjuntar archivos
      // Podemos agregar mas de uno si queremos.

      $mail->AddAddress('carlosmaita2009@gmail.com', 'Carlos Maita'); //$mail->AddAddress($correo2, $correo2);
      //$mail->AddAddress('cdumani@chmd.edu.mx', 'celina dumani');
      //$mail->AddAddress('vnere@chmd.edu.mx','Vianey Nere');
      $mail->IsHTML(true);
      if(!$mail->Send())
      {
        echo "Error temporas3:$correo1: " . $mail->ErrorInfo;
      } else
      {
        ///////////////////////////////////
        if( $objCliente->notificacion_viaje_declinado($id2) == true)
        {
          echo "¡hecho:$id2";
        }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE¡";}
        /////////////////////////////////
      }
    }
  }
}
?>
