<script>
    function logout() {
        var win = window.open("http://accounts.google.com/logout", "target");
        setInterval(function () {
            win.close();
            window.location.href = "<?php echo $redirect_uri; ?>?logout=1";
        }, 1000);
    }
    //paginacion de tablas

    var $table = document.getElementById("tabla_paginacion"),
            // number of rows per page
            $n = 5,
            // number of rows of the table
            $rowCount = $table.rows.length,
            // get the first cell's tag name (in the first row)
            $firstRow = $table.rows[0].firstElementChild.tagName,
            // boolean var to check if table has a head row
            $hasHead = ($firstRow === "TH"),
            // an array to hold each row
            $tr = [],
            // loop counters, to start count from rows[1] (2nd row) if the first row has a head tag
            $i, $ii, $j = ($hasHead) ? 1 : 0,
            // holds the first row if it has a (<TH>) & nothing if (<TD>)
            $th = ($hasHead ? $table.rows[(0)].outerHTML : "");
    // count the number of pages
    var $pageCount = Math.ceil($rowCount / $n);
    // if we had one page only, then we have nothing to do ..
    if ($pageCount > 1) {
        // assign each row outHTML (tag name & innerHTML) to the array
        for ($i = $j, $ii = 0; $i < $rowCount; $i++, $ii++)
            $tr[$ii] = $table.rows[$i].outerHTML;
        // create a div block to hold the buttons
        $table.insertAdjacentHTML("afterend", "<div id='buttons' style='text-align:right;margin-top:1.5rem'></div");
        // the first sort, default page is the first one
        sort(1);
    }

    // ($p) is the selected page number. it will be generated when a user clicks a button
    function sort($p) {
        /* create ($rows) a variable to hold the group of rows
         ** to be displayed on the selected page,
         ** ($s) the start point .. the first row in each page, Do The Math
         */
        var $rows = $th, $s = (($n * $p) - $n);
        for ($i = $s; $i < ($s + $n) && $i < $tr.length; $i++)
            $rows += $tr[$i];

        // now the table has a processed group of rows ..
        $table.innerHTML = $rows;
        // create the pagination buttons
        document.getElementById("buttons").innerHTML = pageButtons($pageCount, $p);
        // CSS Stuff
        document.getElementById("id" + $p).setAttribute("class", "active waves-effect waves-light white-text blue");
    }


    // ($pCount) : number of pages,($cur) : current page, the selected one ..
    function pageButtons($pCount, $cur) {
        /* this variables will disable the "Prev" button on 1st page
         and "next" button on the last one */
        var $prevDis = ($cur == 1) ? "disabled" : "",
                $nextDis = ($cur == $pCount) ? "disabled" : "",
                /* this ($buttons) will hold every single button needed
                 ** it will creates each button and sets the onclick attribute
                 ** to the "sort" function with a special ($p) number..
                 */
                $buttons = "<a href='#!' class='waves-effect waves-light grey-text' onclick='sort(" + ($cur - 1) + ")' " + $prevDis + " style='padding:.5rem;'><i class='material-icons'>arrow_back_ios</i><a>";
        for ($i = 1; $i <= $pCount; $i++)
            $buttons += "<a href='#!' class='waves-effect waves-light white blue-text ' id='id" + $i + "' onclick='sort(" + $i + ")' style='padding:.5rem;width:30px;text-align:center'>" + $i + "<a>";
        $buttons += "<a href='#!' class='waves-effect waves-light  grey-text' onclick='sort(" + ($cur + 1) + ")' " + $nextDis + " style='padding:.5rem;'><i class='material-icons'>arrow_forward_ios</i><a>";
        return $buttons;
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
</body>
</html>