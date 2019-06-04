
		
	
 <?php 

 $linea=$_GET['linea'];
 $id_comite=$_GET['id_comite'];
 

 ?>
	
<link href="assets/css/style.css" rel="stylesheet" />
		<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
                     <input type="hidden" name="variable1" value="<?php echo "$linea"; ?>" />
                     
			<div id="drop">
				 <input type="hidden" name="id_comite" id="id_comite"  value="<?php echo "$id_comite"; ?>" />
                               <font color="#124A7B">ARRASTRA EL DOCUMENTO O IMAGEN AQUÍ</font>
                                <BR><a>ADJUNTAR ARCHIVO</a>
				<input type="file" name="upl" multiple />
			</div>

			<ul>
                            <?php
                             $q =$_POST['consulta'];
                            ?>
				<!-- The file uploads will be shown here -->
			</ul>
                        <?php
                        echo "<h1 id='contenedor'></h1>";
                       
                        ?>
                      
		</form>

        
		<!-- JavaScript Includes -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                
                
		

		<!-- jQuery File Upload Dependencies -->
                <script src="assets/js/jquery.knob.js"></script>
		<script src="assets/js/jquery.ui.widget.js"></script>
		<script src="assets/js/jquery.iframe-transport.js"></script>
		<script src="assets/js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="assets/js/script.js"></script>


		<!-- Only used for the demos. Please ignore and remove. --> 
     
