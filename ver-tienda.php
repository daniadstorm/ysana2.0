<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$aM = load_model('articulos');
$iM = load_model('inputs');
$sM = load_model('seo');

$categoria = '';
$tienda = '';
$rgaa = '';
$out = '';
$outCatNombres = '';
$outCatContenido = '';
$outCatMovil = '';
$arr_categorias = array();
$tit_dropdown = '';
if(isset($_GET['tienda'])){
    if($_GET['tienda']=="df") $tienda = 2;
    else if($_GET['tienda']=="exp") $tienda = 1;
}

$rgbi = $aM->get_categorias_byid($_SESSION['id_lang'], $tienda);
if($rgbi){
    while($frgbi = $rgbi->fetch_assoc()){
        array_push($arr_categorias, $frgbi);
    }
}

foreach ($arr_categorias as $key => $value) {
    $outCatNombres .= '<a class="nav-item nav-link '.($key==0 ? 'active' : '').'" id="nav-'.$key.'-tab" data-toggle="tab" href="#nav-'.$key.'" role="tab" aria-controls="nav-'.$key.'" aria-selected="true">'.$value['nombre_categoria'].'</a>';
    $outCatMovil .= '<button class="dropdown-item '.($key==0 ? 'active show' : '').'" type="button"  data-toggle="tab" href="#nav-'.$key.'" role="tab" aria-controls="nav-'.$key.'" aria-selected="true">'.$value['nombre_categoria'].'</button>';
    $outCatContenido .= '<div class="tab-pane fade '.($key==0 ? 'show active' : '').'" id="nav-'.$key.'" role="tabpanel" aria-labelledby="nav-'.$key.'-tab">';
    $outCatContenido .= '<div class="row">';
    if($key==0) $tit_dropdown = $value['nombre_categoria'];
    $rgaa = $aM->get_all_articulos($value['nombre_categoria'], $_SESSION['id_lang'], $tienda);
    if($rgaa){
        while($frgaa = $rgaa->fetch_assoc()){
            $ttl = '';
            if($tienda==1) $ttl = 'Ysana®';
            else $ttl = $value['nombre_categoria'];
            $outCatContenido .= '<div class="col-12 col-sm-6 col-md-4">';
                $outCatContenido .= '<article class="article-tienda">';
                    $outCatContenido .= '<div class="tarjeta-articulo__elementos-basicos">';
                        $outCatContenido .= '<div class="tarjeta-articulo__foto">';
                            $outCatContenido .= '<img src="'.$ruta_inicio.'img/productos/'.$frgaa['img'].'" class="img-fluid">';
                        $outCatContenido .= '</div>';
                        $outCatContenido .= '<div class="tarjeta-articulo__info">';
                            $outCatContenido .= '<h3 class="titulo">Ysana®</h3>';
                            $outCatContenido .= '<h3 class="nombre">'.$frgaa['nombre'].'</h3>';
                            $outCatContenido .= '<h3 class="precio">'.$frgaa['precio'].'€</h3>';
                        $outCatContenido .= '</div>';
                        $outCatContenido .= '<div class="tarjeta-articulo__venta">';
                            $outCatContenido .= '<a href="'.$ruta_inicio.'producto/'.$frgaa['urlseo'].'"><button class="btn btn-block btn-bg-color-2">Pídelo ahora</button></a>';
                        $outCatContenido .= '</div>';
                    $outCatContenido .= '</div>';
                $outCatContenido .= '</article>';
            $outCatContenido .= '</div>';
        }
    }
    $outCatContenido .= '</div></div>';
}

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]);

?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); ?>
        <?php include_once('inc/menu.inc.php'); ?>
    </div>
    <?php if($tienda==1){ //Experiencia ?>
        <div id="slidertienda-<?php echo $tienda; ?>" class="max-ysana" style="margin-top: 128px;">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 centrar-vertical">
                    <div class="contenedor">
                        <h1 class="ttl">Recibe tus pack experiencia Ysana en casa</h1>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 centrar-vertical der">
                    <img src="<?php echo $ruta_inicio; ?>img/banners/experiencia.jpg" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    <?php }else{ //Farmacia ?>
        <div id="slidertienda-<?php echo $tienda; ?>" class="w-100" style="margin-top: 128px;">
            <div class="max-ysana">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 centrar-vertical">
                        <div class="contenedor">
                            <h1 class="ttl">Reserva tus productos Ysana y recogelos en tu farmacia más cercana</h1>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 centrar-vertical der"></div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="w-100 max-ysana">
        <nav id="catPc<?php echo $tienda; ?>">
            <div class="nav nav-pills nav-justified" id="categorias" role="tablist">
                <?php echo $outCatNombres; ?>
            </div>
        </nav>
        <nav id="catMovil<?php echo $tienda; ?>" class="px-3">
            <div class="dropdown">
                <button id="menuCategorias" class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $tit_dropdown; ?>
                </button>
                <div class="nav dropdown-menu" aria-labelledby="dropdownMenu2">
                    <?php echo $outCatMovil; ?>
                </div>
            </div>
        </nav>
        <div id="articulos-tienda" class="tab-content mt-4 mx-2" id="nav-tabContent">
            <?php echo $outCatContenido; ?>
        </div>
    </div>
    <?php include_once('inc/mapa.inc.php'); ?>
    <?php include_once('inc/footer.inc.php'); ?>
</body>
</html>