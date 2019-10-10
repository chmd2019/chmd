<nav class="nav-extended b-azul" style="padding:1rem;">
    <div class="nav-wrapper">
        <a href="https://www.chmd.edu.mx/pruebascd/icloud/" class="brand-logo">
            <img class="logo" src="https://www.chmd.edu.mx/wp-content/uploads/2018/07/LogoMaguenWT.png">
        </a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>
                <a href="https://www.chmd.edu.mx/pruebascd/icloud/">
                    <img src="https://www.chmd.edu.mx/wp-content/uploads/2018/08/iconChMaguen2.png">
                    &nbsp;MI MAGUEN
                </a>
            </li>
            <li>
                <a href="https://www.chmd.edu.mx/galeria/">
                    <img src="https://www.chmd.edu.mx/wp-content/uploads/2018/08/iconChGaleria2.png">
                    &nbsp;GALERÍA 
                </a>
            </li>
            <li>
                <a href="https://www.chmd.edu.mx/galeria/">
                    <img src="https://www.chmd.edu.mx/wp-content/uploads/2018/08/iconChApoyanos2.png"></i>
                    &nbsp;APÓYANOS 
                </a>
            </li>
            <li>
                <a href="https://www.chmd.edu.mx/galeria/">
                    <img src="https://www.chmd.edu.mx/wp-content/uploads/2018/08/iconChCultura2.png"></i>
                    &nbsp;CULTURA DIGITAL 
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- Dropdown desktop -->
<ul id="dropdown_somos" class="dropdown-content">
    <li><a href="https://www.chmd.edu.mx/filosofia/" class="c-azul">Filosofía</a></li>
    <li><a href="https://www.chmd.edu.mx/linea-educativa/" class="c-azul">Línea educativa</a></li>
    <li><a href="https://www.chmd.edu.mx/historia/" class="c-azul">Historia</a></li>
    <li><a href="https://www.chmd.edu.mx/egresados/" class="c-azul">Egresados</a></li>
</ul>
<ul id="dropdown_secciones" class="dropdown-content">
    <li><a href="https://www.chmd.edu.mx/motek/" class="c-azul">Motek</a></li>
    <li><a href="https://www.chmd.edu.mx/preescolar/" class="c-azul">Preescolar</a></li>
    <li><a href="https://www.chmd.edu.mx/primaria/" class="c-azul">Primaria</a></li>
    <li><a href="https://www.chmd.edu.mx/bachillerato/" class="c-azul">Bachillerato</a></li>
</ul>
<ul id="dropdown_contacto" class="dropdown-content">
    <li><a href="https://www.chmd.edu.mx/bolsa-de-trabajo/" class="c-azul">Trabaja con nosotros</a></li>
    <li><a href="https://www.evaluatest.com/CHMD/evaluate/IUEvaluacion/CHMDBolsaTrabajo.asp" class="c-azul">Vacantes</a></li>
</ul>

<!-- Dropdown movil -->
<ul id="dropdown_somos_movil" class="dropdown-content">
    <li><a href="https://www.chmd.edu.mx/filosofia/" class="c-azul">Filosofía</a></li>
    <li><a href="https://www.chmd.edu.mx/linea-educativa/" class="c-azul">Línea educativa</a></li>
    <li><a href="https://www.chmd.edu.mx/historia/" class="c-azul">Historia</a></li>
    <li><a href="https://www.chmd.edu.mx/egresados/" class="c-azul">Egresados</a></li>
</ul>
<ul id="dropdown_secciones_movil" class="dropdown-content">
    <li><a href="https://www.chmd.edu.mx/motek/" class="c-azul">Motek</a></li>
    <li><a href="https://www.chmd.edu.mx/preescolar/" class="c-azul">Preescolar</a></li>
    <li><a href="https://www.chmd.edu.mx/primaria/" class="c-azul">Primaria</a></li>
    <li><a href="https://www.chmd.edu.mx/bachillerato/" class="c-azul">Bachillerato</a></li>
</ul>
<ul id="dropdown_contacto_movil" class="dropdown-content">
    <li><a href="https://www.chmd.edu.mx/bolsa-de-trabajo/" class="c-azul">Trabaja con nosotros</a></li>
    <li><a href="https://www.evaluatest.com/CHMD/evaluate/IUEvaluacion/CHMDBolsaTrabajo.asp" class="c-azul">Vacantes</a></li>
</ul>
<nav class="b-azul hide-on-med-and-down">
    <div class="nav-wrapper">
        <ul class="left hide-on-med-and-down">
            <li><a href="https://www.chmd.edu.mx">INICIO</a></li>
            <li><a class="dropdown-trigger" href="#!" data-target="dropdown_somos">SOMOS<i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a class="dropdown-trigger" href="#!" data-target="dropdown_secciones">SECCIONES<i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a href="https://www.chmd.edu.mx/fundacion/">FUNDACIÓN</a></li>
            <li><a href="https://www.chmd.edu.mx/academia/">ACADEMIA</a></li>
            <li><a class="dropdown-trigger" href="#!" data-target="dropdown_contacto">CONTACTO<i class="material-icons right">arrow_drop_down</i></a></li>
            <?php
            $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            if ($url != "www.chmd.edu.mx/pruebascd/icloud/" && $url != "www.chmd.edu.mx/pruebascd/icloud/?logout=1"):
                ?>
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown_contacto" onclick="logout();">CERRAR SESIÓN<i class="material-icons right">lock</i></a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<ul class="sidenav b-azul" id="mobile-demo">
    <li><a href="https://www.chmd.edu.mx" class="white-text">INICIO</a></li>
    <li><a class="dropdown-trigger white-text" href="#!" data-target="dropdown_somos_movil">SOMOS<i class="material-icons right white-text">arrow_drop_down</i></a></li>
    <li><a class="dropdown-trigger white-text" href="#!" data-target="dropdown_secciones_movil">SECCIONES<i class="material-icons right white-text">arrow_drop_down</i></a></li>
    <li><a href="https://www.chmd.edu.mx/fundacion/" class="white-text">FUNDACIÓN</a></li>
    <li><a href="https://www.chmd.edu.mx/academia/" class="white-text">ACADEMIA</a></li>
    <li><a class="dropdown-trigger white-text" href="#!" data-target="dropdown_contacto_movil">CONTACTO<i class="material-icons right white-text">arrow_drop_down</i></a></li>
    <?php
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if ($url != "www.chmd.edu.mx/pruebascd/icloud/" && $url != "www.chmd.edu.mx/pruebascd/icloud/?logout=1"):
        ?>
        <li><a class="dropdown-trigger white-text" href="#!" data-target="dropdown_contacto" onclick="logout();">CERRAR SESIÓN<i class="material-icons right white-text">lock</i></a></li>
        <?php endif; ?>
</ul>

<script>
    $(".dropdown-trigger").dropdown();
    $('.sidenav').sidenav();
</script>