<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<div id="navbar_inicio">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-xl navbar-light px-0">
            <a class="navbar-brand" href="<?php echo $ruta_inicio; ?>">
                <img src="<?php echo $ruta_inicio; ?>img/svg/ysanacolor.svg" height="44px" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-auto" id="navbarSupportedContent">
                <!-- <form id="frmbuscar" class="form-inline mt-2 my-lg-0 ml-auto mr-4">
                    <input class="form-control mr-sm-2" type="search" placeholder="Busca tu producto" aria-label="Busca tu producto">
                    <img name="search" src="https://png.icons8.com/ios/64/000000/search.png">
                </form> -->
                <ul id="nav_inicio" class="navbar-nav ml-auto">
                    <li class="nav-item <?php echo ($activePage == 'productos') ? 'active':''; ?> text-right">
                        <a class="nav-link" href="<?php echo $ruta_inicio; ?>productos.php"><?php echo $lng['navbar_inicio'][0]; ?></a>
                    </li>
                    <li class="nav-item text-right">
                        <a class="nav-link text-color-2" href="<?php echo $ruta_inicio; ?>experiencia"><?php echo $lng['navbar_inicio'][1]; ?></a>
                    </li>
                    <li class="nav-item <?php echo ($activePage=='') ? 'active':''; ?> text-right">
                        <a class="nav-link text-color-2" href="<?php echo $ruta_inicio; ?>directo_farmacia"><?php echo $lng['navbar_inicio'][2]; ?></a>
                    </li>
                    <li class="nav-item text-right">
                        <a class="nav-link pt-0 mt-0" href="<?php echo $ruta_inicio; ?>clubysana">
                            <img src="<?php echo $ruta_inicio; ?>img/svg/clubysana.svg" height="32px" alt="">
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($activePage=='') ? 'active':''; ?> text-right">
                        <a class="nav-link" href="<?php echo $ruta_inicio; ?>#form-contacto"><?php echo $lng['navbar_inicio'][3]; ?></a>
                    </li>
                    <li class="nav-item text-right">
                        <form id="frmbuscar" class="form-inline-block mt-2 my-lg-0 ml-auto">
                            <input class="form-control mr-sm-2" type="search" placeholder="" aria-label="">
                            <img name="search" src="https://png.icons8.com/ios/64/000000/search.png">
                        </form>
                    </li>
                    <!-- <li class="nav-item d-block d-sm-none text-right">
                        <p class="m-0 bienvenidosx"><?php echo $lng['navbar_inicio'][4]; ?></p>
                    </li> -->
                </ul>
            </div>
        </nav>
    </div>
</div>