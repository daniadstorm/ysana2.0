<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$iM = load_model('inputs');
$aM = load_model('articulos');
$sM = load_model('seo');

$id_usuario = '';
$out = '';
//GET__________________________________________________________________________
(isset($_GET['id_articulo'])) ? $id_articulo=$_GET['id_articulo'] : '';

//GET__________________________________________________________________________

//LISTADO______________________________________________________________________
$rgaa = $aM->get_all_articulos("Packs experiencias", $_SESSION['id_lang'], 1);
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
                        <a href="'.$frgaa['urlseo'].'">
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

    <div class="">
        <img src="../img/<?php echo $lng['experiencia-index']['img'][0]; ?>" style="width:100%;"/>
    </div>
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
                <li class="breadcrumb-item" aria-current="page"><?php echo $lng['breadcrumb'][1]; ?></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $lng['experiencia-index'][3]; ?></li>
            </ol>
        </nav>
    </div>
    <!-- <div class="container-fluid">
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
    </div> -->
    <div class="container-fluid">
        <div class="familias mt-3 mb-5">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item max-w20">
                    <a class="nav-link" href="#"><?php echo $lng['experiencia-index'][3]; ?></a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">NUTRICIÓN</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">ARTICULACIONES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">SUEÑO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">MENOPAUSIA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ANSIEDAD</a>
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
            $categoria = "Pack experiencias";
            while(!$cat_encontrado && $cat_count<count($productos_ysana_experiencia)){
                if(strtolower($productos_ysana_experiencia[$cat_count]['nombre_categoria'])==strtolower($categoria)){
                    foreach($productos_ysana_experiencia[$cat_count]['productos_categoria'] as $clave => $valor){
                        if($valor['activo']==ACTIVADO){
                            echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 article-block">
                            <article class="tarjeta-articulo">
                                <div class="tarjeta-articulo_elementos-basicos">
                                    <div class="tarjeta-articulo_foto">
                                        <img src="'.$ruta_inicio.'img/productosexp/'.$valor['img-portada'].'" alt="" class="img-fluid">
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
                }
                $cat_count++;
            } */
            ?>
        </div>
    </div>
    <div class="container-fluid footer2">
        <!-- <div class="d-flex">
            <div class="d-inline-block">
                <img src="<?php echo $ruta_inicio; ?>img/sub-footer/1.svg" alt="">
            </div>
            <div class="d-inline-block">
                <img src="<?php echo $ruta_inicio; ?>img/sub-footer/2.svg" alt="">
            </div>
            <div class="d-inline-block">
                <img src="<?php echo $ruta_inicio; ?>img/sub-footer/3.svg" alt="">
            </div>
            <div class="d-inline-block">
                <img src="<?php echo $ruta_inicio; ?>img/sub-footer/4.svg" alt="">
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="<?php echo $ruta_inicio; ?>img/sub-footer/1.svg" height="44">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="<?php echo $ruta_inicio; ?>img/sub-footer/2.svg" height="44">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="<?php echo $ruta_inicio; ?>img/sub-footer/3.svg" height="44">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                <div class="d-flex flex-column align-items-center">
                    <img class="img-footer2" src="<?php echo $ruta_inicio; ?>img/sub-footer/4.svg" height="44">
                    <label>Sin gastos de envio</label>
                </div>
            </div>
        </div> -->
    </div>
    <?php include_once('../inc/footer.inc.php'); ?>
</body>

</html>