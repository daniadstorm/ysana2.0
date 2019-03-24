<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<?php
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
$cM = load_model('carrito');
$outcarrito = '';
$sumaTotal = 0;
$qttCarrito = 0;
$unidades = 0;
//LISTADO______________________________________________________________________
if($id_usuario>0){
    $rgcc = $cM->get_carrito($id_usuario, $_SESSION['lang']);
    if($rgcc){
        while($frgcc = $rgcc->fetch_assoc()){
            $outcarrito .= '<li class="d-flex align-items-center">
            <img src="'.$ruta_inicio.'img/productos/';
            if($frgcc["img_portada"]!=""){
                $outcarrito .= $frgcc["img_portada"];
            }else{
                $outcarrito .= $frgcc["img"];
            }
            $outcarrito .= '" class="img-prod" alt="">
            <div class="d-flex flex-column justify-content-between align-items-start">
                <p class="m-0 fs-8rem">'.$frgcc["nombre"].'</p>
                <p class="m-0 text-muted fs-8rem">'.$lng['experiencia-carrito'][10].' '.$frgcc["cantidad"].'</p>
                <span class="precio">'.$frgcc["precio"].' €</span>
            </div>
            </li>
            <hr>';
            $sumaTotal+=($frgcc["precio"]*$frgcc["cantidad"]);
            $qttCarrito++;
            $unidades+=$frgcc['cantidad'];
        }
    }
}
//LISTADO______________________________________________________________________

?>
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
                    <li class="nav-item text-right">
                        <a href="<?php echo $ruta_inicio; ?>carrito">
                            <div class="carrito-img p-2">
                                <img src="<?php echo $ruta_inicio; ?>img/carritoazul.svg" width="32px" class="">
                                <label class="num"><?php echo $unidades; ?></label>
                                <ul id="carrito-flotante" class="p-2">
                                    <?php echo $outcarrito; ?>

                                    <li class="unit">
                                        <p class="d-flex justify-content-between p-3 mb-2">(<?php echo $unidades; ?>) <?php echo $lng['experiencia-carrito'][11]; ?>
                                            <span class="pull-xs-right"><?php echo $sumaTotal; ?>€</span>
                                        </p>
                                    </li>
                                    <li>
                                        <form action="<?php echo $ruta_inicio; ?>carrito/">
                                            <button class="btn btn-lg btn-block bg-blue-ysana text-light"><?php echo $lng['experiencia-carrito'][12]; ?></button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </li>
<!--                     <li class="nav-item d-block d-sm-none text-right">
                        <p class="m-0 bienvenidosx"><?php echo $lng['navbar_inicio'][4]; ?></p>
                    </li> -->
                </ul>
            </div>
        </nav>
    </div>
</div>