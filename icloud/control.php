<?php
session_start(); //session start
include_once("Model/DBManager.php");
require_once ('libraries/Google/autoload.php');
require_once 'Model/Config.php';




//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}


$service = new Google_Service_Oauth2($client);

//echo "$service";
  
if (isset($_GET['code'])) 
    {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}


if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}
/*Agregar diseño*/

?>
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
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<!--[if lt IE 9]><script src="/apps/js/common/html5shiv-pack-1499875166000.js"></script><![endif]-->
<!--<link rel="stylesheet" href="apps/shared/main-pack-1499875166000.css" type="text/css">
-->
<link rel="stylesheet" href="shared/main.css" type="text/css">


<!---------maguen------------------------------------>
<link type="text/css" rel="stylesheet" href="css/permanete.css" />  
<link href="css/prueba3.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="js/alertify.js"></script>
<link rel="stylesheet" href="css/alertify.core.css" />
<link rel="stylesheet" href="css/alertify.default.css" />
	
   <!----------------alert-------------------->

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/run_prettify.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
$(function alert(){
    $('.source-code').each(function(index){
        var $section = $(this);
        var code = $(this).html().replace('<!--', '').replace('-->', '');
        
        // Code preview
        var $codePreview = $('<pre class="prettyprint lang-javascript"></pre>');
        $codePreview.text(code);
        $section.html($codePreview);
        
        // Run code
        if($section.hasClass('runnable'))
		{
            var $button = $('<button style="background-color: transparent !important; border:0;outline:0 none;"><img src="pics/ayuda.png" alt="Ayuda" width="30px" height="30px" /></button>');
            $button.on('click', {code: code}, function(event){
                eval(event.data.code);
            });
            $button.insertAfter($section);
            $('<div class="clearfix" style="margin-bottom: 10px;"></div>').insertAfter($button);
        }
    });
});
</script>
<!----------------Alert------------------------>		

<!----------------------------------------------------------->
<link rel="stylesheet" href="apps/shared/web_apps-pack-1499875166000.css" type="text/css">

<link href="apps/webapps/features/form-builder/css/public/core-pack-1499875166000.css"
type="text/css" rel="stylesheet">

<script src="apps/js/common/common-pack-1499875166000.js" type="text/javascript" charset="utf-8"></script>

<script src="apps/webapps/features/form-builder/js/public/bundle-pack-1499875166000.js" charset="utf-8"></script>
<script src="apps/js/recaptcha/ada-pack-1499875166000.js" charset="utf-8"></script>
<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "BreadcrumbList",
				"itemListElement": [
					
					
				]
			}
		</script>
</head>





	
		
		
			



<body >

<header id="header_main">
	<div id="header_inner">

		<h1 id="header_title"><a href="#"><span id="logo1" class="first-line">COLEGIO HEBREO</span> <span class="second-line" id="logo2">MAGUEN DAVID</span></a></h1>

		<a id="skip_to_content" href="#content_main">Skip to main content</a>

		<div id="topnav_holder">
			<a id="topnav_mobile_toggle" href="#">Main Menu Toggle</a>
			<nav id="topnav" aria-label="Main Site Navigation">
			<ul class="nav-menu">
			<li class="nav-item">
			<a href="apps/pages/index.jsp?uREC_ID=740955&type=d&pREC_ID=1153598"><span class="nav-item-inner">Somos</span></a>
			<div class="sub-nav">
			<ul class="sub-nav-group">
			<li><a href="apps/pages/index.jsp?uREC_ID=740955&type=d&pREC_ID=1153598">Filosofía</a></li>
			<li><a href="apps/pages/index.jsp?uREC_ID=740955&type=d&pREC_ID=1153693">Linea educativa</a></li>
			<li><a href="apps/pages/index.jsp?uREC_ID=740955&type=d&pREC_ID=1152801">Historia</a></li>
			<li><a href="apps/pages/index.jsp?uREC_ID=740955&type=d&pREC_ID=1153728">Reconocimientos</a></li>
			</ul>
			</div>
			</li>
					
						<li class="nav-item">
							<a href="/apps/pages/index.jsp?uREC_ID=742934&type=d&pREC_ID=1153729"><span class="nav-item-inner">Secciones</span></a>
							
								<div class="sub-nav">
									<ul class="sub-nav-group">
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=742934&type=d&pREC_ID=1153729">Motek</a></li>
											
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=742941&type=d&pREC_ID=1153734">Preescolar</a></li>
											
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=742956&type=d&pREC_ID=1153737">Primaria</a></li>
											
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=743218&type=d&pREC_ID=1153754">Bachillerato</a></li>
											
										
									</ul>
								</div>
							
						</li>
					
						<li class="nav-item">
							<a href="/apps/pages/index.jsp?uREC_ID=774071&type=d&pREC_ID=1174074"><span class="nav-item-inner">#AprenderTodos</span></a>
							
								<div class="sub-nav">
									<ul class="sub-nav-group">
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=772469&type=d">Student´s Zone</a></li>
											
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=772470&type=d">Teacher's Lab</a></li>
											
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=772471&type=d">Ideas</a></li>
											
										
									</ul>
								</div>
							
						</li>
					
						<li class="nav-item">
							<a href="/apps/pages/index.jsp?uREC_ID=772473&type=d&pREC_ID=1173038"><span class="nav-item-inner">Fundación</span></a>
							
								<div class="sub-nav">
									<ul class="sub-nav-group">
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=772473&type=d&pREC_ID=1173038">#TodosSomosMaguen</a></li>
											
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=772473&type=d&pREC_ID=1179967">Dona</a></li>
											
										
									</ul>
								</div>
							
						</li>
					
						<li class="nav-item">
							<a href="/apps/pages/index.jsp?uREC_ID=772474&type=d&pREC_ID=1173035"><span class="nav-item-inner">Academia</span></a>
							
								<div class="sub-nav">
									<ul class="sub-nav-group">
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=772474&type=d&pREC_ID=1173035">Talleres</a></li>
											
										
									</ul>
								</div>
							
						</li>
					
						<li class="nav-item">
							<a href="/apps/pages/index.jsp?uREC_ID=772475&type=d&pREC_ID=1173036"><span class="nav-item-inner">Nuestros Padres</span></a>
							
								<div class="sub-nav">
									<ul class="sub-nav-group">
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=772475&type=d&pREC_ID=1173036">Comité de Madres</a></li>
											
										
									</ul>
								</div>
							
						</li>
					
						<li class="nav-item">
							<a href="/apps/pages/index.jsp?uREC_ID=740955&type=d&pREC_ID=1153598"><span class="nav-item-inner">Egresados</span></a>
							
								<div class="sub-nav">
									<ul class="sub-nav-group">
										

											
												<li><a href="/apps/pages/index.jsp?uREC_ID=740955&type=d&pREC_ID=1153646">Nuestros Egresados</a></li>
											
										
									</ul>
								</div>
							
						</li>
					
						<li class="nav-item">
                                              <a href="apps/pages/index.jsp?uREC_ID=803899&type=d&pREC_ID=1192716" id="accessible-megamenu">
                                                <span class="nav-item-inner">Descargar</span></a>
							
						</li>
					
						<li class="nav-item">
							<a href="http://colgad.edliotest.com/apps/form/form.COLHMD.qoBAlgB.29m"><span class="nav-item-inner">Contacto</span></a>
							
						</li>
					
				</ul>
			</nav>
		</div>

		<!--<ul id="topbar_nav">
	    	<li class="item"><a href="http://colhmd.edlioadmin.com" id="edlio_login"><span class="edlio-logo"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 475.7 366.6" enable-background="new 0 0 475.7 366.6" xml:space="preserve"><path d="M475.7 366.6h-85.1c0-23.3-8.3-43.4-25-60.1 -16.7-17.1-36.8-25.3-60.1-25.3s-43.4 8.3-60.1 25.3c-16.3 16.7-24.7 36.8-24.7 60.1h-83v-27.5 -61.4 -1.8c25.4-4.5 47.8-16.5 66.8-35.7 7.1-7.1 13.3-14.7 18.3-22.7v0.1c25.3-14.1 53-21.4 82.7-21.4 46.9 0 87.2 16.7 120.3 50C459 279.4 475.7 319.7 475.7 366.6M228 157.4c-0.2 7.7-1.3 15.2-3 22.5 -0.2 0.9-0.4 1.8-0.7 2.6 -0.2 0.9-0.4 1.8-0.7 2.6 -0.2 0.7-0.4 1.4-0.7 2.1 -0.3 1-0.7 2.1-1 3s-0.7 2-1 2.9c-0.7 2.1-1.6 4.1-2.5 6.2 -0.1 0.1-0.1 0.2-0.1 0.3 0 0 0 0.1-0.1 0.1 -0.2 0.4-0.4 0.9-0.6 1.2 -1.4 3.1-2.9 6.1-4.7 9 -4.8 8.3-10.5 15.9-17.4 22.9 -0.3 0.4-0.7 0.7-1 1 -0.2 0.2-0.5 0.4-0.7 0.7 -0.3 0.3-0.6 0.6-0.9 0.8 -11.1 10.6-23.4 18.5-36.6 23.8 -1 0.4-2.1 0.8-3.1 1.2 -0.8 0.3-1.6 0.7-2.4 0.9 -11.4 3.9-23.4 5.8-36 5.8 -0.3 0-0.5 0-0.8 0 -0.4 0-0.7 0-1.1 0s-0.7 0-1 0c-1 0-2.1 0-3.1-0.1 -1.7-0.1-3.3-0.1-4.9-0.3 -0.6-0.1-1.2-0.1-1.8-0.1 -1.4-0.1-2.8-0.3-4.2-0.5 -0.9-0.1-1.8-0.2-2.6-0.4 -1-0.1-2.1-0.3-3.1-0.5 -4.4-0.8-8.6-1.9-12.8-3.2 -0.3-0.1-0.6-0.1-0.8-0.2 -1.4-0.4-2.8-0.9-4.2-1.4 -2.1-0.7-4-1.5-6-2.3 -15-6.4-28.3-16.3-40.1-29.4 -2.9-3.2-5.4-6.6-7.8-10 -0.3-0.4-0.5-0.7-0.8-1.2 -1.5-2.3-3-4.5-4.4-6.8 -0.4-0.7-0.7-1.3-1.1-2 -1.2-2.2-2.3-4.3-3.4-6.6 -0.2-0.4-0.4-1-0.7-1.4 -1.3-2.8-2.4-5.6-3.4-8.5 0-0.1-0.1-0.2-0.1-0.4C2.1 180 0 167.4 0 154.1c0-0.3 0-0.5 0-0.7 0-0.3 0-0.7 0-1 0-0.4 0-0.9 0-1.4 0-0.8 0-1.5 0.1-2.3 0.1-2.3 0.2-4.6 0.4-6.9l6.1-94.2c10 6.7 19 14.9 26.9 24.9 6.9-6.9 14.3-12.8 22.3-17.6l73.1-51.6c1 11.1 0.4 22.5-2 34.1l73.1-7.7c-4.9 10.9-11.4 21.1-19.9 30.6 7 5 13.4 10.9 19.3 17.6 8.6-9.4 18-17 28.3-23v90.5C228.1 149.4 228.2 153.4 228 157.4M170.9 152.8c0-1.8-0.1-3.6-0.2-5.3 0 0 0 0 0-0.1 -0.1-1.8-0.4-3.6-0.7-5.3 0-0.1 0-0.1-0.1-0.3 -0.3-1.5-0.7-3-1.1-4.4 -0.1-0.4-0.2-0.9-0.4-1.3 -0.3-1-0.7-2-1-2.9 -0.4-1-0.7-1.8-1.1-2.8 -0.2-0.4-0.4-0.9-0.7-1.3 -2.3-4.7-5.2-9.2-8.9-13.4 -2.6-2.9-5.3-5.5-8.2-7.8 -0.1-0.1-0.3-0.2-0.4-0.3 -1.3-1-2.6-1.9-4-2.8 -0.3-0.1-0.6-0.4-0.9-0.5 -1.2-0.8-2.6-1.5-3.9-2.2 -0.3-0.1-0.7-0.3-1-0.4 -1.3-0.7-2.7-1.2-4-1.8 -0.3-0.1-0.7-0.2-1-0.4 -1.4-0.5-2.8-1-4.2-1.3 -0.4-0.1-0.8-0.2-1.2-0.3 -1.3-0.3-2.6-0.6-4-0.8 -0.7-0.1-1.4-0.2-2.1-0.3 -1-0.1-2.1-0.3-3.1-0.4 -1.4-0.1-2.8-0.1-4.2-0.1 -0.3 0-0.7 0-1 0 -3.6 0-7 0.4-10.4 1 -0.5 0.1-1.1 0.2-1.6 0.4 -0.9 0.1-1.7 0.4-2.6 0.7 -1.2 0.4-2.5 0.7-3.7 1.2 -0.7 0.2-1.4 0.4-2.1 0.7 -0.9 0.4-1.8 0.7-2.7 1.2 -0.1 0-0.1 0.1-0.1 0.1 -1.8 0.9-3.7 1.8-5.5 2.9 -0.3 0.2-0.7 0.4-1 0.6 -0.7 0.4-1.5 1-2.2 1.5 -2.8 2-5.5 4.2-8 6.7 -2.6 2.5-4.8 5.2-6.7 8 -0.3 0.4-0.6 0.8-0.9 1.2 -0.4 0.7-0.8 1.4-1.2 2.1 -0.6 1-1.2 1.9-1.6 2.9 -0.1 0.1-0.1 0.2-0.1 0.4 -2.3 4.8-4 9.9-5.1 15.4 -0.1 0.7-0.2 1.5-0.3 2.3 -0.1 1-0.2 2-0.4 2.9 -0.3 3.6-0.2 7.3 0.2 11 0.3 2.9 0.9 5.6 1.5 8.3 1.8 6.4 4.6 12.5 8.7 18.4 9 12.7 21.3 20.5 36.7 23.4 0.8 0.1 1.5 0.2 2.3 0.3 1 0.1 2.1 0.3 3.1 0.4 0.4 0 0.7 0.1 1.1 0.1 1.4 0.1 2.7 0.1 4.1 0.1 0.9 0 1.8-0.1 2.6-0.1 0.9-0.1 1.7-0.1 2.6-0.2 1.1-0.1 2.1-0.2 3.1-0.4 0.7-0.1 1.5-0.2 2.3-0.4 1-0.1 1.8-0.4 2.7-0.7 1-0.2 2-0.5 2.9-0.8 0.6-0.1 1.1-0.4 1.7-0.5 6.6-2.3 12.8-5.9 18.5-10.8 1.2-1.1 2.3-2.2 3.5-3.4 1.1-1.2 2.2-2.3 3.2-3.7 4.4-5.4 7.5-11.2 9.7-17.2 0.4-1 0.7-2 1-3 0.1-0.6 0.3-1.2 0.4-1.8 0.3-1.2 0.5-2.3 0.7-3.5 0.1-0.7 0.2-1.5 0.3-2.3 0.1-1 0.3-2 0.4-3 0.1-1.2 0.1-2.6 0.1-3.8C170.9 153.7 170.9 153.2 170.9 152.8"/></svg>Edlio</span> Login</a></li>
	    </ul>-->

	    <ul id="header_links">
	    	<li class="item"><a href="/apps/pages/index.jsp?uREC_ID=772473&type=d&pREC_ID=1173038"><span class="svg-inner"><?xml version="1.0" encoding="utf-8"?>
<!-- Generator: Adobe Illustrator 20.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 32.7 32.7" style="enable-background:new 0 0 32.7 32.7;" xml:space="preserve">
<path d="M32.4,0.3C32.2,0.1,31.9,0,31.7,0C19.9,0.8,10.8,5.1,6.6,11.8c-3,4.8-3.3,10.6-0.9,16.8c-2.9,1.6-4.8,2-4.8,2.1
	c-0.6,0.1-0.9,0.6-0.8,1.2c0.1,0.5,0.5,0.8,1,0.8c0.1,0,0.1,0,0.2,0c0.2,0,2.5-0.5,5.7-2.4c2.8,0.9,5.4,1.4,7.7,1.4
	c3.3,0,6.3-0.9,8.7-2.7c7.7-5.6,9.4-18.3,9.4-28C32.7,0.7,32.6,0.5,32.4,0.3z M22.2,27.4c-3.4,2.4-7.7,2.9-13,1.5
	c3.8-2.6,8.3-7,12.4-14.2c0.3-0.5,0.1-1.1-0.4-1.4c-0.5-0.3-1.1-0.1-1.4,0.4c-4.1,7.2-8.8,11.5-12.4,13.9c-2-5.5-1.7-10.5,0.9-14.7
	C12,6.9,20.1,3,30.7,2.1C30.5,14.6,27.5,23.5,22.2,27.4z"/>
</svg>
</span>Apóyanos</a></li>
	    	<li class="item"><a href="apps/news"><span class="svg-inner"><?xml version="1.0" encoding="utf-8"?>
<!-- Generator: Adobe Illustrator 20.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 33.8 31.2" style="enable-background:new 0 0 33.8 31.2;" xml:space="preserve">
<g transform="translate(0,-952.36218)">
	<path d="M27,952.4c0.4,0,0.8,0.5,0.8,0.8v7.6h5.1c0.5,0,0.8,0.5,0.8,0.8v18.2c0,2.1-1.7,3.8-3.8,3.8H3.8c-2.1,0-3.8-1.7-3.8-3.8
		v-26.6c0-0.4,0.4-0.8,0.8-0.8H27z M26.2,954.1H1.7v25.8c0,1.2,0.9,2.1,2.1,2.1h23.1c-0.4-0.6-0.7-1.3-0.7-2.1V954.1z M22.8,956.6
		c0.4,0,0.8,0.5,0.8,0.8v5.9c0,0.4-0.4,0.8-0.8,0.8h-8.4c-0.4,0-0.8-0.4-0.8-0.8v-5.9c0-0.4,0.4-0.8,0.8-0.8H22.8z M10.1,957.4
		c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H10.1z M22,958.3h-6.8v4.2H22V958.3z
		 M10.1,961.7c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H10.1z M32.1,962.5h-4.2v17.3
		c0,1.2,0.9,2.1,2.1,2.1c1.2,0,2.1-0.9,2.1-2.1V962.5z M22.8,966.7c0.5,0,0.8,0.4,0.8,0.8c0,0.5-0.4,0.8-0.8,0.8H5.1
		c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H22.8z M22.8,971.4c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8
		s0.4-0.8,0.8-0.8H22.8z M22.8,976c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H22.8z"/>
</g>
</svg>
</span>Noticias</a></li>
	    	<li class="item"><a href="apps/album"><span class="svg-inner"><?xml version="1.0" encoding="utf-8"?>
<!-- Generator: Adobe Illustrator 20.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 35 30.3" style="enable-background:new 0 0 35 30.3;" xml:space="preserve">
<g>
	<path d="M30.8,4.5h-5.2l-1.5-3.9C24,0.2,23.7,0,23.4,0H11.7c-0.3,0-0.7,0.2-0.8,0.5L9.4,4.5H4.2C1.9,4.5,0,6.3,0,8.6v17.5
		c0,2.3,1.9,4.2,4.2,4.2h26.7c2.3,0,4.2-1.9,4.2-4.2V8.6C35,6.3,33.1,4.5,30.8,4.5z M12.2,1.7h10.5l1,2.8H11.2L12.2,1.7z M33.3,26.2
		c0,1.4-1.1,2.5-2.5,2.5H4.2c-1.4,0-2.5-1.1-2.5-2.5V8.6c0-1.4,1.1-2.5,2.5-2.5H10c0,0,0,0,0,0h0h20.8c1.4,0,2.5,1.1,2.5,2.5
		L33.3,26.2L33.3,26.2z"/>
	<path d="M17.5,8.5c-4.9,0-8.9,4-8.9,8.9c0,4.9,4,8.9,8.9,8.9c4.9,0,8.8-4,8.8-8.9C26.4,12.5,22.4,8.5,17.5,8.5z M17.5,24.6
		c-4,0-7.2-3.2-7.2-7.2c0-4,3.2-7.2,7.2-7.2c4,0,7.2,3.2,7.2,7.2C24.7,21.4,21.5,24.6,17.5,24.6z"/>
	<path d="M17.5,12.9c-2.5,0-4.4,2-4.4,4.4c0,2.5,2,4.4,4.4,4.4c2.5,0,4.4-2,4.4-4.4C22,14.9,20,12.9,17.5,12.9z M17.5,20.2
		c-1.5,0-2.8-1.2-2.8-2.8s1.2-2.8,2.8-2.8c1.5,0,2.8,1.2,2.8,2.8C20.3,18.9,19,20.2,17.5,20.2z"/>
</g>
</svg>
</span>Galería</a></li>
	    	<li class="item"><a href="/apps/pages/index.jsp?uREC_ID=803683&type=d&pREC_ID=1192607"><span class="svg-inner"><?xml version="1.0" encoding="utf-8"?>
<!-- Generator: Adobe Illustrator 20.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 48.6 29.5" style="enable-background:new 0 0 48.6 29.5;" xml:space="preserve">
<g>
	<path d="M11.6,6c1.4,0,2.6-0.9,3-2.2c0,0,0,0,0,0h4.1l7.8,7.7c0.3,0.3,0.7,0.4,1,0.5c0,0,0,0,0.1,0h8.3c0.6,0,1-0.4,1-1
		c0-0.5-0.5-1-1-1H28l-8-7.9c-0.2-0.2-0.4-0.3-0.6-0.4c-0.1-0.1-0.3-0.1-0.4-0.1h-4.4c-0.1,0-0.1,0-0.2,0c-0.5-1-1.6-1.7-2.8-1.7
		C9.8,0,8.4,1.4,8.4,3C8.4,4.7,9.8,6,11.6,6z M11.6,1.4c0.9,0,1.7,0.7,1.7,1.6c0,0.9-0.7,1.6-1.7,1.6S9.9,3.9,9.9,3
		C9.9,2.1,10.6,1.4,11.6,1.4z"/>
	<path d="M35.9,17.5h-8.3c0,0,0,0-0.1,0c-0.4,0-0.7,0.2-1,0.5l-7.8,7.7h-4.1c0,0,0,0,0,0c-0.4-1.2-1.6-2.2-3-2.2
		c-1.7,0-3.1,1.4-3.1,3c0,1.7,1.4,3,3.1,3c1.2,0,2.3-0.7,2.8-1.7c0.1,0,0.1,0,0.2,0h4.4c0.1,0,0.3,0,0.4-0.1
		c0.2-0.1,0.4-0.2,0.6-0.4l8-7.9h7.9c0.6,0,1-0.4,1-1S36.5,17.5,35.9,17.5z M11.6,28.1c-0.9,0-1.7-0.7-1.7-1.6s0.7-1.6,1.7-1.6
		s1.7,0.7,1.7,1.6S12.5,28.1,11.6,28.1z"/>
	<path d="M47.5,13.8H24.9c0-0.1-0.1-0.3-0.2-0.4l-4.2-5.2c-0.2-0.3-0.5-0.4-0.9-0.4c0,0,0,0,0,0h-8.5c-0.1,0-0.2,0-0.2,0
		C10.4,6.6,9.3,5.9,8,5.9c-1.7,0-3,1.3-3,2.9c0,1.6,1.4,2.9,3,2.9c1.3,0,2.4-0.8,2.8-1.8c0.1,0,0.2,0,0.2,0h8.2l3.1,3.9H7.9
		c-0.5-1.5-2-2.7-3.9-2.7c-2.2,0-4,1.6-4,3.6c0,2,1.8,3.6,4,3.6c1.8,0,3.4-1.1,3.9-2.7h14.5l-3,3.8h-8.2c-0.1,0-0.2,0-0.2,0
		c-0.4-1.1-1.5-1.8-2.8-1.8c-1.7,0-3,1.3-3,2.9c0,1.6,1.4,2.9,3,2.9c1.3,0,2.4-0.8,2.8-1.9c0.1,0,0.1,0,0.2,0h8.5c0,0,0,0,0,0
		c0.3,0,0.6-0.1,0.9-0.4l4.2-5.2c0.1-0.1,0.1-0.2,0.2-0.4h22.7c0.6,0,1.1-0.4,1.1-1S48.1,13.8,47.5,13.8z M8,10.3
		c-0.9,0-1.6-0.7-1.6-1.5c0-0.9,0.7-1.5,1.6-1.5c0.9,0,1.6,0.7,1.6,1.5C9.6,9.6,8.9,10.3,8,10.3z M4,16.6c-1.2,0-2.1-0.9-2.1-1.9
		s0.9-1.9,2.1-1.9s2.1,0.9,2.1,1.9S5.2,16.6,4,16.6z M8,22.1c-0.9,0-1.6-0.7-1.6-1.5C6.4,19.7,7.1,19,8,19c0.9,0,1.6,0.7,1.6,1.5
		C9.6,21.4,8.9,22.1,8,22.1z"/>
</g>
</svg>
</span>Cultura Digital</a></li>
	    
	    </ul>
                

 
	</div>
</header>
    <!----------------------adaptacion responsiva-->
<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function()
{
    
var isMobile = {
			Android: function() {
				return navigator.userAgent.match(/Android/i);
			},
			BlackBerry: function() {
				return navigator.userAgent.match(/BlackBerry/i);
			},
			iOS: function() {
				return navigator.userAgent.match(/iPhone|iPad|iPod/i);
			},
			Opera: function() {
				return navigator.userAgent.match(/Opera Mini/i);
			},
			Windows: function() {
				return navigator.userAgent.match(/IEMobile/i);
			},
			any: function() {
				return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
			}
		};
		
		if(isMobile.Android()) 
                {
                      $("#header_links").hide();
                       
                         $("#logo2").hide();
                          $("#logo1").hide();
                         $('#total').attr("src","images/googlemobile.png");
                         $('#total').css({ 'width':'100%', 'height':'190%' }); 
		}
		if(isMobile.iOS()) 
                {
                      $("#header_links").hide();
			
                      
                      
                       $("#logo2").hide();
                         $("#logo1").hide();
                         $('#total').attr("src","images/googlemobile.png");
                        $('#total').css({ 'width':'100%', 'height':'190%' });
                         
		}
                });
	</script>
    <!---------------------- fin adaptacion responsiva-->
    
    <!----------------------------------Java script solo para ------------------------------------------->
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
 
<script type="text/javascript">
$(document).ready(function(){
	// mostrar formulario de actualizar datos
	$("table tr .modi a").click(function(){
		$("#tabla").hide();
		$("#formulario").show();
		$.ajax({
			url: this.href,
			type: "GET",
			success: function(datos){
				$("#formulario").html(datos);
			}
		});
		return false;
	});
	
	
});

</script>   
<div id="content_main">

>
<?php


////////////// fin agregar diseño////////////////////////////////

if (isset($authUrl))
    { 
    
	//show login url
	echo '<div align="center">';
	echo '<h2><font color="#124A7B">Acceso Google</font></h2>';
	
	echo '<br><br><a  href="' . $authUrl . '"><img src="images/google.png"  id="total"/></a>';
	echo '</div>';
	

        
        
    } 
else 
{
    
   
       echo '<h2> <font color="#124A7B">Cambio:</font></h2>';  
                    ///////////////////////////////////
       echo '<h3> [<a href="'.$redirect_uri.'?logout=1">Logout</a>]<br>&nbsp; &nbsp;&nbsp; &nbsp;</h3>';
    
        
         $mod= $_GET["idmodulo"];
         $idseccion= $_GET["idseccion"];
        
        
	$user = $service->userinfo->get(); //get user info 
	$correo=$user->email;
        require('Model/Login.php');
       $objCliente=new Login();
       $consulta=$objCliente->Acceso($correo);
     
	if($consulta) //if user already exist change greeting text to "Welcome Back"
    {
         
 
 if( $cliente = mysql_fetch_array($consulta) )
              
{
                
$id=$cliente[0];
$correo=$cliente[1];
$perfil=$cliente[2];
$estatus=$cliente[3];
                    
?>  
///////////////////////////////////////////
 <div id="formulario" style="display:none;">
 </div>
<?php
 echo "<center>";
   echo '<div id="tabla">';
 include("$link1");
  echo '</div>';
 echo "</center>";
               ////////////////////////////// fin de while
           
      
  }
  else
      {
                  echo 'Este usuario no tiene Acceso:'.$user->email.',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="'.$redirect_uri.'?logout=1"> Log Out</a>]';
                  
              }
              
       
    }
	else //error en cosulta
	{ 
            
            echo 'Error en cosulta';
          
                //echo 'Hi '.$user->email.',<br> Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		//$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
		//$statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
		//$statement->execute();
		///echo $mysqli->error;
          
         }
	
       

}



?>

</div>
<footer id="footer_main">
<div id="footer_top">
<figure id="footer_logos">
 <!--
<a href="http://www.ibo.org/es/" target="_blank"><img src="pics/footer-logo-1.png" alt="Logo Bachillerato Internacional"></a>
<a href="https://www.iste.org/" target="_blank"><img src="pics/footer-logo-2.jpg" alt="Logo ISTE"></a>
-->
     </figure>
</div>
<div id="footer_bottom">
<div id="footer_inner">
<a href="/">Colegio Hebreo Maguen David &copy; <script>document.write(new Date().getFullYear());</script></a>

<script type="text/javascript">
$(function alert(){
    $('.source-code1').each(function(index){
        var $section = $(this);
        var code = $(this).html().replace('<!--', '').replace('-->', '');
        
        // Code preview
        var $codePreview = $('<pre class="prettyprint lang-javascript"></pre>');
        $codePreview.text(code);
        $section.html($codePreview);
        
        // Run code
        if($section.hasClass('runnable'))
		{
            var $button = $('<button style="background-color: transparent !important; border:0;outline:0 none; color: white;">Aviso de privacidad</button>');
            $button.on('click', {code: code}, function(event)
            {
                eval(event.data.code);
            });
            $button.insertAfter($section);
            $('<div class="clearfix" style="margin-bottom: 10px; color: white;" ></div>').insertAfter($button);
        }
    });
});
</script>   
<div class='source-code1 runnable'  style='display:none;'>
        <!--
        BootstrapDialog.alert({
            title: 'Aviso de privacidad',
            message: '<p align=justify>AVISO DE PRIVACIDAD VIGENTE A PARTIR DEL 1º DE DICIEMBRE DEL 2011 En Colegio Hebreo Maguen David  A.C., con domicilio en Antiguo Camino a Tecamachalco No.370 Col. Vista Hermosa  Delegación Cuajimalpa, Ciudad de México, Distrito Federal, la información de la comunidad estudiantil así como de los Padres de Familia y Tutores es tratada de forma estrictamente confidencial por lo que al proporcionar sus datos personales a esta Institución, consiente su tratamiento con las siguientes finalidades: 1.- La realización de los expedientes de todos y cada uno de los alumnos inscritos en este Colegio; 2.- La realización de encuestas, así como la creación e implementación de procesos analíticos y estadísticos necesarios o convenientes, relacionados con el mejoramiento del sistema educativo implementado en este Colegio; 3.- La promoción de servicios, beneficios adicionales, becas, bonificaciones, concursos, todo esto ofrecido por o relacionado con las Responsables o Terceros nacionales o extranjeros con quienes este Colegio mantenga alianzas educativas; 4.- La atención de requerimientos de cualquier autoridad competente; 5.- La realización de cualquier actividad complementaria o auxiliar necesaria para la realización de los fines anteriores; 6.- La realización de consultas, investigaciones y revisiones en relación a cualquier queja o reclamación; y 7.- Ponernos en contacto con Usted para tratar cualquier tema relacionado con las labores de sus hijos en su calidad de alumnos de este Colegio; 8.- Mantener actualizados nuestros registros. Para conocer el texto completo del aviso de privacidad para la comunidad del Colegio Hebreo Maguen David A.C. favor de consultar nuestra página en Internet www.chmd.edu.mx</p>'
        });
        -->
         </div>
</div>
</div>
</footer>
<nav id="mobile_nav">
<a href="/apps/events/"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 62.6 60.3" enable-background="new 0 0 62.6 60.3" xml:space="preserve"><path d="M43.5 30.5c1 0 1.9 0.2 2.6 0.5 0.8 0.3 1.5 0.8 2.3 1.4l3.2-4.9c-1.2-0.9-2.4-1.6-3.7-2 -1.3-0.5-2.8-0.7-4.5-0.7 -1.9 0-3.6 0.3-5 1 -1.4 0.7-2.6 1.7-3.6 2.9 -1 1.2-1.7 2.6-2.1 4.3 -0.5 1.7-0.7 3.4-0.7 5.4v0.1c0 2.3 0.3 4.2 0.8 5.7 0.6 1.5 1.3 2.7 2.2 3.6 0.9 0.9 1.9 1.6 3.1 2.1 1.2 0.5 2.7 0.7 4.4 0.7 1.3 0 2.6-0.2 3.8-0.6 1.2-0.4 2.2-1 3.1-1.8 0.9-0.8 1.6-1.7 2.1-2.8 0.5-1.1 0.8-2.3 0.8-3.7v-0.1c0-1.2-0.2-2.3-0.7-3.3 -0.4-1-1-1.8-1.8-2.4 -0.7-0.6-1.6-1.1-2.6-1.5 -1-0.3-2-0.5-3.1-0.5 -1.2 0-2.3 0.2-3.1 0.6 -0.8 0.4-1.6 0.8-2.2 1.3 0.2-1.5 0.6-2.8 1.4-3.8C41 31 42.1 30.5 43.5 30.5zM39.7 39.7c0.6-0.6 1.4-0.9 2.5-0.9 1.1 0 1.9 0.3 2.6 0.9 0.6 0.6 0.9 1.4 0.9 2.3h0V42c0 0.9-0.3 1.7-0.9 2.3 -0.6 0.6-1.4 0.9-2.5 0.9 -1.1 0-1.9-0.3-2.6-0.9 -0.6-0.6-0.9-1.4-0.9-2.3v-0.1C38.8 41 39.1 40.3 39.7 39.7zM19.8 37.8l-9.2 7.1v5.2h19.5v-5.6H19.9l4.2-3c0.9-0.7 1.7-1.3 2.4-1.9 0.7-0.6 1.3-1.3 1.8-1.9 0.5-0.7 0.9-1.4 1.1-2.2 0.2-0.8 0.4-1.7 0.4-2.7v-0.1c0-1.2-0.2-2.2-0.7-3.2 -0.4-1-1.1-1.8-1.9-2.5 -0.8-0.7-1.8-1.2-2.9-1.6 -1.1-0.4-2.3-0.6-3.7-0.6 -1.2 0-2.3 0.1-3.2 0.4 -1 0.2-1.8 0.6-2.6 1 -0.8 0.4-1.5 1-2.2 1.7 -0.7 0.7-1.4 1.4-2 2.3l4.6 3.9c1-1.1 1.8-1.9 2.6-2.4 0.7-0.5 1.5-0.8 2.3-0.8 0.8 0 1.5 0.2 2 0.7 0.5 0.4 0.8 1.1 0.8 1.8 0 0.8-0.2 1.5-0.7 2.1C21.7 36.1 20.9 36.9 19.8 37.8zM43.8 10.2h0.5c1.5 0 2.7-1.2 2.7-2.7V2.7C47 1.2 45.8 0 44.3 0h-0.5c-1.5 0-2.7 1.2-2.7 2.7v4.9C41.2 9 42.4 10.2 43.8 10.2zM18.6 10.2H19c1.5 0 2.7-1.2 2.7-2.7V2.7C21.7 1.2 20.5 0 19 0h-0.5c-1.5 0-2.7 1.2-2.7 2.7v4.9C15.9 9 17.1 10.2 18.6 10.2zM58.7 19.9h3.9V7.3c0-1.3-1.1-2.4-2.4-2.4H48v2.7c0 2-1.6 3.6-3.6 3.6h-0.5c-2 0-3.6-1.6-3.6-3.6V4.9H22.7v2.7c0 2-1.6 3.6-3.6 3.6h-0.5c-2 0-3.6-1.6-3.6-3.6V4.9H2.8c-1.3 0-2.4 1.1-2.4 2.4v12.6h3.9H58.7zM58.7 21.9v33.5c0 0.8-0.2 1-1 1H5.2c-0.8 0-1-0.2-1-1V21.9H0.3v36c0 1.3 1.1 2.4 2.4 2.4h57.4c1.3 0 2.4-1.1 2.4-2.4v-36H58.7z"/></svg>Calendario</a>
<a href="/"><?xml version="1.0" encoding="utf-8"?>

<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
viewBox="0 0 32.3 31.5" style="enable-background:new 0 0 32.3 31.5;" xml:space="preserve">
<defs xmlns="http://www.w3.org/1999/xhtml">
<style>
.st0 { fill: #FFFFFF; }
</style>
</defs>
<g>
<polygon class="st0" points="15.8,8 0,0 0,14.4 2.1,14.4 2.1,3.3 15.8,10.2 30.3,3.4 30.3,14.4 32.3,14.4 32.3,0.2 "/>
<polygon class="st0" points="30.3,29.5 2.1,29.5 2.1,17.8 0,17.8 0,31.5 32.3,31.5 32.3,17.8 30.3,17.8 "/>
<path class="st0" d="M9.2,13.6c-0.9,0-1.6,0.7-1.6,1.6v8.3c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6v-4.8c0-1.5,0.7-2.3,1.9-2.3
s1.9,0.8,1.9,2.3v4.8c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6v-4.8c0-1.5,0.7-2.3,1.9-2.3s1.9,0.8,1.9,2.3v4.8
c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6v-5.8c0-2.7-1.4-4.1-3.8-4.1c-1.5,0-2.7,0.6-3.7,1.8c-0.6-1.1-1.7-1.8-3.2-1.8
c-1.6,0-2.6,0.8-3.3,1.8v-0.1C10.8,14.3,10.1,13.6,9.2,13.6z"/>
</g>
</svg>
Cultura Digital</a>
<a href="/apps/pages/index.jsp?uREC_ID=803683&type=d&pREC_ID=1192607"><?xml version="1.0" encoding="utf-8"?>

<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
viewBox="0 0 33.8 31.2" style="enable-background:new 0 0 33.8 31.2;" xml:space="preserve">
<g transform="translate(0,-952.36218)">
<path d="M27,952.4c0.4,0,0.8,0.5,0.8,0.8v7.6h5.1c0.5,0,0.8,0.5,0.8,0.8v18.2c0,2.1-1.7,3.8-3.8,3.8H3.8c-2.1,0-3.8-1.7-3.8-3.8
v-26.6c0-0.4,0.4-0.8,0.8-0.8H27z M26.2,954.1H1.7v25.8c0,1.2,0.9,2.1,2.1,2.1h23.1c-0.4-0.6-0.7-1.3-0.7-2.1V954.1z M22.8,956.6
c0.4,0,0.8,0.5,0.8,0.8v5.9c0,0.4-0.4,0.8-0.8,0.8h-8.4c-0.4,0-0.8-0.4-0.8-0.8v-5.9c0-0.4,0.4-0.8,0.8-0.8H22.8z M10.1,957.4
c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H10.1z M22,958.3h-6.8v4.2H22V958.3z
M10.1,961.7c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H10.1z M32.1,962.5h-4.2v17.3
c0,1.2,0.9,2.1,2.1,2.1c1.2,0,2.1-0.9,2.1-2.1V962.5z M22.8,966.7c0.5,0,0.8,0.4,0.8,0.8c0,0.5-0.4,0.8-0.8,0.8H5.1
c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H22.8z M22.8,971.4c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8
s0.4-0.8,0.8-0.8H22.8z M22.8,976c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H22.8z"/>
</g>
</svg>
Noticias</a>
<a href="/apps/contact/"><svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1792 710v794q0 66-47 113t-113 47h-1472q-66 0-113-47t-47-113v-794q44 49 101 87 362 246 497 345 57 42 92.5 65.5t94.5 48 110 24.5h2q51 0 110-24.5t94.5-48 92.5-65.5q170-123 498-345 57-39 100-87zm0-294q0 79-49 151t-122 123q-376 261-468 325-10 7-42.5 30.5t-54 38-52 32.5-57.5 27-50 9h-2q-23 0-50-9t-57.5-27-52-32.5-54-38-42.5-30.5q-91-64-262-182.5t-205-142.5q-62-42-117-115.5t-55-136.5q0-78 41.5-130t118.5-52h1472q65 0 112.5 47t47.5 113z"/></svg>Contacto</a>
</nav>
<script type="text/javascript" charset="utf-8" src="apps/js/jquery/1.11.0/jquery-pack-1499875166000.js"></script>
<script src="apps/js/common/jquery-accessibleMegaMenu.js"></script>
<script type="text/javascript" src="shared/tabs.js"></script>
<script type="text/javascript" src="shared/slick.js"></script>
<script type="text/javascript" src="shared/TimeCircles.js"></script>
<script>
	$(function() {
		$('#topnav').accessibleMegaMenu();
	});
</script>
<script>

	window.onload = init;
	var topnavButton = document.getElementById('topnav_mobile_toggle');
	var topnavDisplay = document.getElementById('topnav');

	function init() {
		topnavButton.onclick = toggleNav;
	}

	function toggleNav(){
		topnavDisplay.classList.toggle("open");
	}

</script>
</body>
</html>


<!-- 76ms -->
