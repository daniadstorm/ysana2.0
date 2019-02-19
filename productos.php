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
        <div class="container">
            <div class="d-flex flex-column align-items-center my-4">
                <h1 class="h1-mbl">
                    <?php echo $lng['productos'][0]; ?>
                </h1>
                <p class="mb-1 text-center">
                    <?php echo $lng['productos'][1]; ?>
                </p>
                <div class="liniacategoria"></div>
            </div>
        </div>
        <div class="container mt-3 mb-5">
            <div id="accordion">
                <div class="card categoria">
                    <div class="card-header" id="acor_head1" data-toggle="collapse" data-target="#acordeon_eficaps"
                        aria-expanded="false" aria-controls="acordeon_eficaps">
                        <p>
                            <?php echo $lng['productos'][2]; ?>
                        </p>
                        <h5 class="mb-0">
                            <h1>
                                <?php echo $lng['productos'][3]; ?>
                            </h1>
                        </h5>
                    </div>
                    <div id="acordeon_eficaps" class="collapse" aria-labelledby="acor_head1" data-parent="#accordion">
                        <div class="card-body">
                            <div class="contenedor-productos mt-3">
                                <div class="row">
                                    <?php
                                    $qtt_prod = count($productos_ysana[0]['productos_categoria']);
                                    for($i=0;$i<$qtt_prod;$i++){
                                        if($productos_ysana[0]['productos_categoria'][$i]['activo']==1){
                                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <a href="'.$ruta_inicio.'productos_ysana/'.$productos_ysana[0]['productos_categoria'][$i]['url-seo'].'">
                                                <div class="producto">
                                                    <div class="img">
                                                        <img class="img-categ img-fluid" src="'.$ruta_inicio.'img/productos/'.$productos_ysana[0]['productos_categoria'][$i]['img'].'.png">
                                                    </div>
                                                    <div class="footer-prod">
                                                        <h5 class="mb-0">'.$productos_ysana[0]['productos_categoria'][$i]['nombre'].'</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                                        }
                                    }
                                    ?>
                                    <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
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
                                </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card categoria">
                    <div class="card-header" id="acor_head2" data-toggle="collapse" data-target="#acordeon_mujer"
                        aria-expanded="false" aria-controls="acordeon_mujer">
                        <p>
                            <?php echo $lng['productos'][4]; ?>
                        </p>
                        <h5 class="mb-0">
                            <h1>
                                <?php echo $lng['productos'][5]; ?>
                            </h1>
                        </h5>
                        <!-- <img class="img-categ" src="img/home/7.png"> -->
                    </div>
                    <div id="acordeon_mujer" class="collapse" aria-labelledby="acor_head2" data-parent="#accordion">
                        <div class="card-body">
                            <div class="contenedor-productos mt-3">
                                <div class="row">
                                    <?php
                                    $qtt_prod = count($productos_ysana[1]['productos_categoria']);
                                    for($i=0;$i<$qtt_prod;$i++){
                                        if($productos_ysana[1]['productos_categoria'][$i]['activo']==1){
                                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <a href="'.$ruta_inicio.'productos_ysana/'.$productos_ysana[1]['productos_categoria'][$i]['url-seo'].'">
                                                <div class="producto">
                                                    <div class="img">
                                                        <img class="img-categ img-fluid" src="'.$ruta_inicio.'img/productos/'.$productos_ysana[1]['productos_categoria'][$i]['img'].'.png">
                                                    </div>
                                                    <div class="footer-prod">
                                                        <h5 class="mb-0">'.$productos_ysana[1]['productos_categoria'][$i]['nombre'].'</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card categoria">
                    <div class="card-header" id="acor_head3" data-toggle="collapse" data-target="#acordeon_autocuidado"
                        aria-expanded="false" aria-controls="acordeon_autocuidado">
                        <p>
                            <?php echo $lng['productos'][6]; ?>
                        </p>
                        <h5 class="mb-0">
                            <h1>
                                <?php echo $lng['productos'][7]; ?>
                            </h1>
                        </h5>
                        <!-- <img class="img-categ" src="img/home/7.png"> -->
                    </div>
                    <div id="acordeon_autocuidado" class="collapse" aria-labelledby="acor_head3" data-parent="#accordion">
                        <div class="card-body">
                            <div class="contenedor-productos mt-3">
                                <div class="row">
                                    <?php
                                    $qtt_prod = count($productos_ysana[2]['productos_categoria']);
                                    for($i=0;$i<$qtt_prod;$i++){
                                        if($productos_ysana[2]['productos_categoria'][$i]['activo']==1){
                                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <a href="'.$ruta_inicio.'productos_ysana/'.$productos_ysana[2]['productos_categoria'][$i]['url-seo'].'">
                                                <div class="producto">
                                                    <div class="img">
                                                        <img class="img-categ img-fluid" src="'.$ruta_inicio.'img/productos/'.$productos_ysana[2]['productos_categoria'][$i]['img'].'.png">
                                                    </div>
                                                    <div class="footer-prod">
                                                        <h5 class="mb-0">'.$productos_ysana[2]['productos_categoria'][$i]['nombre'].'</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card categoria">
                    <div class="card-header" id="acor_head4" data-toggle="collapse" data-target="#acordeon_senior"
                        aria-expanded="false" aria-controls="acordeon_senior">
                        <p>
                            <?php echo $lng['productos'][8]; ?>
                        </p>
                        <h5 class="mb-0">
                            <h1>
                                <?php echo $lng['productos'][9]; ?>
                            </h1>
                        </h5>
                        <!-- <img class="img-categ" src="img/home/7.png"> -->
                    </div>
                    <div id="acordeon_senior" class="collapse" aria-labelledby="acor_head4" data-parent="#accordion">
                        <div class="card-body">
                            <div class="contenedor-productos mt-3">
                                <div class="row">
                                    <?php
                                    $qtt_prod = count($productos_ysana[3]['productos_categoria']);
                                    for($i=0;$i<$qtt_prod;$i++){
                                        if($productos_ysana[3]['productos_categoria'][$i]['activo']==1){
                                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <a href="'.$ruta_inicio.'productos_ysana/'.$productos_ysana[3]['productos_categoria'][$i]['url-seo'].'">
                                                <div class="producto">
                                                    <div class="img">
                                                        <img class="img-categ img-fluid" src="'.$ruta_inicio.'img/productos/'.$productos_ysana[3]['productos_categoria'][$i]['img'].'.png">
                                                    </div>
                                                    <div class="footer-prod">
                                                        <h5 class="mb-0">'.$productos_ysana[3]['productos_categoria'][$i]['nombre'].'</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card categoria">
                    <div class="card-header" id="acor_head5" data-toggle="collapse" data-target="#acordeon_respira"
                        aria-expanded="false" aria-controls="acordeon_respira">
                        <p>
                            <?php echo $lng['productos'][10]; ?>
                        </p>
                        <h5 class="mb-0">
                            <h1>
                                <?php echo $lng['productos'][11]; ?>
                            </h1>
                        </h5>
                        <!-- <img class="img-categ" src="img/home/7.png"> -->
                    </div>
                    <div id="acordeon_respira" class="collapse" aria-labelledby="acor_head5" data-parent="#accordion">
                        <div class="card-body">
                            <div class="contenedor-productos mt-3">
                                <div class="row">
                                    <?php
                                    $qtt_prod = count($productos_ysana[4]['productos_categoria']);
                                    for($i=0;$i<$qtt_prod;$i++){
                                        if($productos_ysana[4]['productos_categoria'][$i]['activo']==1){
                                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <a href="'.$ruta_inicio.'productos_ysana/'.$productos_ysana[4]['productos_categoria'][$i]['url-seo'].'">
                                                <div class="producto">
                                                    <div class="img">
                                                        <img class="img-categ img-fluid" src="'.$ruta_inicio.'img/productos/'.$productos_ysana[4]['productos_categoria'][$i]['img'].'.png">
                                                    </div>
                                                    <div class="footer-prod">
                                                        <h5 class="mb-0">'.$productos_ysana[4]['productos_categoria'][$i]['nombre'].'</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card categoria">
                    <div class="card-header" id="acor_head6" data-toggle="collapse" data-target="#acordeon_infantil"
                        aria-expanded="false" aria-controls="acordeon_infantil">
                        <p>
                            <?php echo $lng['productos'][12]; ?>
                        </p>
                        <h5 class="mb-0">
                            <h1>
                                <?php echo $lng['productos'][13]; ?>
                            </h1>
                        </h5>
                        <!-- <img class="img-categ" src="img/home/7.png"> -->
                    </div>
                    <div id="acordeon_infantil" class="collapse" aria-labelledby="acor_head6" data-parent="#accordion">
                        <div class="card-body">
                            <div class="contenedor-productos mt-3">
                                <div class="row">
                                    <?php
                                    $qtt_prod = count($productos_ysana[5]['productos_categoria']);
                                    for($i=0;$i<$qtt_prod;$i++){
                                        if($productos_ysana[5]['productos_categoria'][$i]['activo']==1){
                                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <a href="'.$ruta_inicio.'productos_ysana/'.$productos_ysana[5]['productos_categoria'][$i]['url-seo'].'">
                                                <div class="producto">
                                                    <div class="img">
                                                        <img class="img-categ img-fluid" src="'.$ruta_inicio.'img/productos/'.$productos_ysana[5]['productos_categoria'][$i]['img'].'.png">
                                                    </div>
                                                    <div class="footer-prod">
                                                        <h5 class="mb-0">'.$productos_ysana[5]['productos_categoria'][$i]['nombre'].'</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('inc/mapa.inc.php'); ?>
        <?php include_once('inc/footer.inc.php'); ?>
    </main>
</body>

</html>