<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$hM = load_model('html');
$iM = load_model('inputs');
$farmM = load_model('farmacias');
$sM = load_model('seo');

$frm_buscar = '';
$lista_farmacias = $farmM->get_farmacias($ruta_inicio);
/*
$lista_farmacias = array(
    array('nombre'=>'FARMACIA BERNA QUILES','calle'=>'Carrer Teniente Coronel Chapuli, 1'),
);
*/

$titulo = '';
$cabecera = '';
$h1 = '';
$descripcion = '';
$seo_url = '';
$get_seo_url = (isset($_GET['producto'])) ? $_GET['producto'] : '';

if($get_seo_url!=''){
    $get_seo_url = explode('/',$get_seo_url);
    $seo_url = $get_seo_url[0];
}

/* echo '<pre>'; */
$encontrado = false;
$cp = 0;
while(!$encontrado && $cp<count($productos_ysana)){
    $fin = false;
    $cont_prod = 0;
    while(!$fin && $cont_prod<count($productos_ysana[$cp]['productos_categoria'])){
        if($productos_ysana[$cp]['productos_categoria'][$cont_prod]['url-seo']==$seo_url){
            $fin=true;
            $encontrado=true;
            $titulo = $productos_ysana[$cp]['productos_categoria'][$cont_prod]['nombre'];
            $cabecera = $productos_ysana[$cp]['productos_categoria'][$cont_prod]['cabecera'];
            $h1 = $productos_ysana[$cp]['productos_categoria'][$cont_prod]['h1'];
            $descripcion = $productos_ysana[$cp]['productos_categoria'][$cont_prod]['descripcion'];
        }
        /* print_r($productos_ysana[$cp]['productos_categoria'][$cont_prod]); */
        /* echo $productos_ysana[$cp]['productos_categoria'][$cont_prod]['nombre'].'-'.$cont_prod.'-'.count($productos_ysana[$cp]['productos_categoria']).'<hr>'; */
        $cont_prod++;
    }
    $cp++;
}
/* echo '</pre>'; */
//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">

</script>

<body>
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio.inc.php'); ?>

    <?php //include_once('inc/footer.inc.php'); ?>
    <main id="content" role="main">
        
        <div class="position-relative">
            <div class="videoysana">
                <video class="video-inline" autoplay loop muted src="<?php echo $ruta_inicio; ?>img/videofinal.mp4"></video>
            </div>
        </div>
        <div class="container-fluid">
            <nav class="d-none d-sm-block">
                <ol class="breadcrumb bg-white pl-0">
                    <li class="breadcrumb-item">
                        <a href="#">Ysana</a>
                        <!-- <a href="#"><?php echo $seo_url[0]; ?></a> -->
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Producto</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ficha producto</li>
                </ol>
            </nav>
        </div>
        <div class="container">
            <div class="max-w-producto m-auto">
                <h1>
                    <?php echo $titulo; ?>
                </h1>
                <h1>
                <?php echo $h1; ?>
                </h1>
                <p>
                    <?php echo $descripcion; ?>
                </p>
            </div>
        </div>
        <div class="container">
            <div class="d-flex flex-column align-items-center mt-5">
                <h1><?php echo $lng['productos_ysana'][0]; ?></h1>
                <p class="mb-1"><?php echo $lng['productos_ysana'][1]; ?></p>
                <div class="liniacategoria"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5 offset-lg-1">
                    <div class="ficha_producto">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="imagen">
                                <img src="<?php echo $ruta_inicio; ?>img/svg/experiencia.png" alt="" class="img-fluid">
                            </div>
                            <p class="ficha_producto-desc"><?php echo $lng['productos_ysana'][2]; ?></p>
                            <button type="button" class="btn btn-comprar btn-sm ficha_producto-btn_compra">EXPERIENCIA</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="ficha_producto">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="imagen">
                                <img src="<?php echo $ruta_inicio; ?>img/svg/farmacia.png" alt="" class="img-fluid">
                            </div>
                            <p class="ficha_producto-desc"><?php echo $lng['productos_ysana'][3]; ?></p>
                            <button type="button" class="btn btn-comprar btn-sm ficha_producto-btn_compra">FARMACIA DIRECTA</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('inc/mapa.inc.php'); ?>
        <div class="container my-5">
            <div class="d-flex flex-column align-items-center mt-2">
                <h1>También te puede interesar</h1>
                <p class="mb-1">Productos relacionados con tu busqueda</p>
                <div class="liniacategoria"></div>
            </div>
            <div class="row mt-5">
                <div class="col-6 col-md-3">
                    <a href="<?php echo $ruta_inicio; ?>ficha-producto.php?id_producto=1">
                        <div class="producto">
                            <div class="img">
                                <img class="img-categ img-fluid" src="<?php echo $ruta_inicio; ?>img/svg/producto1.png">
                            </div>
                            <div class="footer-prod">
                                <h5 class="mb-0">AdelgaYsana</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="<?php echo $ruta_inicio; ?>ficha-producto.php?id_producto=1">
                        <div class="producto">
                            <div class="img">
                                <img class="img-categ img-fluid" src="<?php echo $ruta_inicio; ?>img/svg/producto2.png">
                            </div>
                            <div class="footer-prod">
                                <h5 class="mb-0">AdelgaYsana</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="<?php echo $ruta_inicio; ?>ficha-producto.php?id_producto=1">
                        <div class="producto">
                            <div class="img">
                                <img class="img-categ img-fluid" src="<?php echo $ruta_inicio; ?>img/svg/producto2.png">
                            </div>
                            <div class="footer-prod">
                                <h5 class="mb-0">AdelgaYsana</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="<?php echo $ruta_inicio; ?>ficha-producto.php?id_producto=1">
                        <div class="producto">
                            <div class="img">
                                <img class="img-categ img-fluid" src="<?php echo $ruta_inicio; ?>img/svg/producto1.png">
                            </div>
                            <div class="footer-prod">
                                <h5 class="mb-0">AdelgaYsana</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <?php include_once('inc/footer.inc.php'); ?>
    </main>
</body>

</html>