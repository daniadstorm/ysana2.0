<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');
$sM = load_model('seo');

$id_usuario = '';
$categoria = 'eficaps';
$out = '';


//GET__________________________________________________________________________
(isset($_GET['id_articulo'])) ? $id_articulo=$_GET['id_articulo'] : '';

(isset($_GET['categoria'])) ? $categoria=$_GET['categoria'] : 'eficaps';

//GET__________________________________________________________________________

//LISTADO______________________________________________________________________
$rgaa = $aM->get_all_articulos($categoria, $_SESSION['id_lang'], 2);
if($rgaa){
    while($frgaa = $rgaa->fetch_assoc()){
        $out .= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 article-block">
        <article class="tarjeta-articulo">
            <div class="tarjeta-articulo_elementos-basicos">
                <div class="tarjeta-articulo_foto">
                    <img src="'.$ruta_inicio.'img/productos/'.$frgaa['img'].'" alt="" class="img-fluid">
                </div>
                <div class="tarjeta-articulo_adicional d-flex flex-column">
                    <header class="tarjeta-articulo_info">
                        <h3 class="categoria">Ysana®</h3>
                        <h3 class="nombre">'.$frgaa['nombre'].'</h3>
                        <h3 class="precio">'.$frgaa['precio'].'€</h3>
                    </header>
                    <header class="tarjeta-articulo_extras">
                        <!--<div class="puntuacion">
                            <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                            <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                            <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                            <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                            <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                        </div>-->
                        <div class="boton">
                        <a href="'.$ruta_inicio.'directo_farmacia/producto/'.$frgaa['urlseo'].'">
                            <button type="button" class="btn btn-comprar btn-sm">'.$lng['directo-farmacia'][0].'</button>
                        </a>    
                        </div>
                    </header>
                </div>
            </div>
        </article>
    </div>';
    }
}
//LISTADO______________________________________________________________________
include_once('../inc/cabecera.inc.php'); //cargando cabecera 
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">
</script>

<body>
    <?php //include_once('../inc/franja_top.inc.php'); ?>
    <?php //include_once('../inc/main_menu.inc.php'); ?>
    <?php include_once('../inc/panel_top.inc.php'); ?>
    <?php //include_once('../inc/panel_top_experiencia.inc.php'); ?>
    <?php include_once('../inc/navbar_inicio_experiencia.inc.php'); ?>
    <div class="contenedor">
        <div class="position-relative">
            <div class="videoysana">
                <video class="video-inline" autoplay loop muted src="<?php echo $ruta_inicio; ?>img/<?php echo $lng['directo-index']['img'][0]; ?>"></video>
            </div>
        </div>
    </div>
    <!--
    <div class="container-fluid">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="http://recasens.com/wp-content/uploads/2017/02/r_095_pvc_1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="http://recasens.com/wp-content/uploads/2017/02/r_095_pvc_1.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="http://recasens.com/wp-content/uploads/2017/02/r_095_pvc_1.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    -->
    <div class="container-fluid">
        <nav>
            <ol class="breadcrumb bg-white pl-0">
                <!--
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>">Ysana</a>
                </li>
                -->
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><?php echo $lng['breadcrumb'][0]; ?></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo ucwords($categoria); ?></li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="familias mt-3">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>directo_farmacia/eficaps/">Eficaps</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>directo_farmacia/mujer/"><?php echo $lng['directo-index'][0]; ?></a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>directo_farmacia/autocuidado/"><?php echo $lng['directo-index'][1]; ?></a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>directo_farmacia/senior/"><?php echo $lng['directo-index'][2]; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>directo_farmacia/respira/"><?php echo $lng['directo-index'][3]; ?></a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>directo_farmacia/infantil/"><?php echo $lng['directo-index'][4]; ?></a>
                </li> -->
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row articulos mt-4">
            <?php
            echo $out;
            /* $cat_encontrado=false;
            $cat_count = 0;
            while(!$cat_encontrado && $cat_count<count($productos_ysana_df)){
                if(strtolower($productos_ysana_df[$cat_count]['nombre_categoria'])==strtolower($categoria)){
                    foreach($productos_ysana_df[$cat_count]['productos_categoria'] as $clave => $valor){
                        echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 article-block">
                            <article class="tarjeta-articulo">
                                <div class="tarjeta-articulo_elementos-basicos">
                                    <div class="tarjeta-articulo_foto">
                                        <img src="'.$ruta_inicio.'img/productos/'.$valor['img-portada'].'" alt="" class="img-fluid">
                                    </div>
                                    <div class="tarjeta-articulo_adicional d-flex flex-column">
                                        <header class="tarjeta-articulo_info">
                                            <h3 class="categoria">Ysana®</h3>
                                            <h3 class="nombre">'.$valor['nombre'].'</h3>
                                            <h3 class="precio">'.$valor['precio'].'</h3>
                                        </header>
                                        <header class="tarjeta-articulo_extras">
                                            <div class="puntuacion">
                                                <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                                                <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                                                <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                                                <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                                                <img class="img-start" src="'.$ruta_archivos.'img/star-color.png">
                                            </div>
                                            <div class="boton">
                                            <a href="'.$valor['url-seo'].'">
                                                <button type="button" class="btn btn-comprar btn-sm">'.$lng['experiencia-index'][0].'</button>
                                            </a>    
                                            </div>
                                        </header>
                                    </div>
                                </div>
                            </article>
                        </div>';
                    }
                }
                $cat_count++;
            }
            */
            ?>
        </div>
    </div>
    <!-- <div class="container-fluid footer2">
        <div class="row">
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="https://png.icons8.com/cotton/64/e74c3c/business-management.png">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="https://png.icons8.com/cotton/64/e74c3c/business-management.png">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="https://png.icons8.com/cotton/64/e74c3c/business-management.png">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="https://png.icons8.com/cotton/64/e74c3c/business-management.png">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
        </div>
    </div> -->
    <?php include_once('../inc/footer.inc.php'); ?>
</body>

</html>