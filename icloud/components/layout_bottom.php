<script>
    function logout() {
        var win = window.open("http://accounts.google.com/logout", "target");
        setInterval(function () {
            win.close();
            window.location.href = "<?php echo $redirect_uri; ?>?logout=1";
        }, 1000);
    }
</script>
<div class="modal-chmd-fondo" onclick="ocultar_modal_chmd()"></div>
<!-- Footer -->
<footer>
    <div class="b-blanco">  
        <br>
        <br>
        <div class="row">
            <div class="col s12 m12 l3 text-center">
                <img class="img-fluid " src="https://www.chmd.edu.mx/wp-content/uploads/2018/07/LogoCHMD.png">
            </div>
            <div class="col s12 m12 l3 text-center">
                <img class="img-fluid" src="https://www.chmd.edu.mx/wp-content/uploads/2018/07/imgBachillerato.jpg">
            </div>
            <div class="col s12 m12 l3 text-center">
                <img class="img-fluid" src="https://www.chmd.edu.mx/wp-content/uploads/2018/07/imgISTE.jpg">
            </div>
            <div class="col s12 m12 l3 text-center">
                <h5 class="c-azul"><strong>CONTACTO</strong></h5>
                <div class="c-gris">
                    <table>
                        <tbody>
                            <tr>
                                <td valign="top" class="p-3"><i class="material-icons" style="font-size: 1.5rem;">not_listed_location</i></td>
                                <td class="p-2"><span class="left text-left">Camino a Tecamachalco 370, Cuajimalpa de Morelos, Lomas de Vista Hermosa, 05100, CDMX</span></td>
                            </tr>
                            <tr>
                                <td class="p-2"><i class="material-icons" style="font-size: 1.5rem;">phone_callback</i></td>
                                <td class="p-2"><span class="left">01 55 5246 2600</span></td>
                            </tr>
                            <tr>
                                <td class="p-2"><i class="material-icons" style="font-size: 1.5rem;">mail</i></td>
                                <td class="p-2"><span class="left">chmd@www.chmd.edu.mx</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="grey lighten-1" style="padding:2rem 0rem">
            <ul style="text-align: center">
                <li style="display: inline;margin-left: .5rem">
                    <a class="c-blanco" target="_blank" href="https://www.facebook.com/Colegio-Hebreo-Maguen-David-121254917955692/">
                        <i class="fab fa-facebook-f"> </i>
                    </a>
                </li>
                <li style="display: inline;margin-left: .5rem">
                    <a class="c-blanco"  target="_blank" href="https://twitter.com/chmddigital?lang=en">
                        <i class="fab fa-twitter"> </i>
                    </a>
                </li>
                <li style="display: inline;margin-left: .5rem">
                    <a class="c-blanco"  target="_blank">
                        <i class="fab fa-instagram"> </i>
                    </a>
                </li>
                <li style="display: inline;margin-left: .5rem">
                    <a class="c-blanco"  href="https://www.facebook.com/EgresadosdelaMaguen?ref=bookmarks">
                        <i class="fa fa-graduation-cap"> </i>
                    </a>
                </li>
                <li style="display: inline;margin-left: .5rem">
                    <a class="c-blanco"  target="_blank" href="https://soundcloud.com/cultura-digital-chmd">
                        <i class="fab fa-soundcloud"></i>
                    </a>
                </li>
                <li style="display: inline;margin-left: .5rem">
                    <a class="c-blanco"  target="_blank" href="https://www.youtube.com/user/CanalCHMD">
                        <i class="fab fa-youtube"></i>
                    </a>
                </li>
                <li style="display: inline;margin-left: .5rem">
                    <a class="c-blanco"  target="_blank" href="https://vimeo.com/chmd">
                        <i class="fab fa-vimeo"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="grey darken-1 white-text" style="text-align: center">
            <br>
            <span>
                Colegio Hebreo Maguen David © 2018 | 
                <a href="https://www.chmd.edu.mx/aviso-de-privacidad/" class="c-blanco"> Aviso de privacidad</a>
            </span>
            <br>
            <br>
        </div>
        <!-- Copyright -->
    </div>
</footer>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<!-- FilePond library -->
<script src="/pruebascd/icloud/materialkit/js/filepond.js"></script>
</body>
</html>