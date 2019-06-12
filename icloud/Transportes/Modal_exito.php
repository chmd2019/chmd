   
<?php

class Modal_exito {

    public function redirigir_pagina($pagina) {
        echo '
            <!DOCTYPE html>
            <!-- Powered by Edlio -->
            <html lang="en" class="desktop">
                <!-- w103 -->
                <head>
                    <title>Colegio Hebreo Maguen David</title>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <meta name="description" content="Colegio Hebreo Maguen David">
                    <meta name="generator" content="Edlio CMS">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    <link rel="icon" href="favicon.ico" type="image/x-icon">
                    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
                    <link rel="stylesheet" href="../shared/main.css" type="text/css">

                    <!---------maguen------------------------------------>
                    <link type="text/css" rel="stylesheet" href="../css/permanete.css" />  
                    <link href="../css/prueba3.css" type="text/css" rel="stylesheet">

                    <!----------------alert-------------------->

                    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
                    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
                </head>

                <div class="modal fade" id="modal_confirmacion_exitosa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"> <h4 class="modal-title">Confirmación</h4>
                            </div>
                            <div class="modal-body">
                                Solicitud realizada con éxito
                            </div>
                        </div>
                    </div>
                </div>
                <script>$("#modal_confirmacion_exitosa").modal({show:true})</script>';
        header("Refresh:2, URL=$pagina");
    }
}
?>
