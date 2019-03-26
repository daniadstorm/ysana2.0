<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$aM = load_model('articulos');
$iM = load_model('inputs');
$sM = load_model('seo');

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]);

$arrCategorias = array();

$out = '';
$outTemp = '';
$count = 0;
//LISTADO____________________________________________________________________
$rgcp = $aM->get_categorias_idlang($_SESSION['id_lang']);
if($rgcp){
    while($frgcp = $rgcp->fetch_assoc()){
        array_push($arrCategorias,array(
            'id_categoria' => $frgcp['id_categoria'],
            'nombre_categoria' => $frgcp['nombre_categoria'],
            'descripcion_categoria' => $frgcp['descripcion_categoria'],
            'imagen_categoria' => $frgcp['imagen_categoria'],
            'productos' => array()
        ));
    }
    foreach ($arrCategorias as $key => $value) {
        $rgax = $aM->get_articulos_xcat($value['id_categoria'], $_SESSION['id_lang'], 1);
        if($rgax){
            while($frgax = $rgax->fetch_assoc()){
                array_push($arrCategorias[$key]['productos'], $frgax);
            }
        }
    }
    foreach ($arrCategorias as $key => $value) {
        $id = strtolower(str_replace(' ', "", $value['nombre_categoria']));
        $numeropar = $count%2;
        if(count($arrCategorias[$key]['productos'])>0){
            $count++;
            $out .= '<div id="'.$id.'" class="producto-caja collapsed">
            <div data-toggle="collapse" href="#collapse'.$id.'" role="button" aria-expanded="false" class="w-100 collapsed" aria-controls="collapse'.$id.'">
            <div class="row mx-0 w-100 '.($numeropar ? 'flex-row-reverse' : '').'">
                <div class="col-md-6 centrar-vertical izq">
                    <div class="contenedor">
                        <h1 class="ttl">'.$value['nombre_categoria'].'</h1>
                        <p class="txt">'.$value['descripcion_categoria'].'</p>
                    </div>
                </div>
                <div class="col-md-6 max-imagen-prod centrar-vertical '.(!$numeropar ? 'der' : '').'">
                    <img src="'.$ruta_inicio.'img/categorianew/'.$value['imagen_categoria'].'" class="img-fluid" alt="">
                </div>
            </div>
            <div class="linea"></div>
            </div>
        </div>';
            $out .= '<div class="collapse colapsad" id="collapse'.$id.'">
            <div class="card card-body">
                <section class="row">';
                foreach ($arrCategorias[$key]['productos'] as $key2 => $value2) {
                    $out .= '<div class="col-6 col-sm-4 col-md-3 col-lg-3 article-block">
                    <a href="'.$ruta_inicio.'producto/'.$value2['urlseo'].'" class="enlace">
                        <article>
                            <div class="article_foto"><img src="'.$ruta_inicio.'img/productos/'.$value2['img'].'" class="img-fluid"></div>
                            <div class="article_texto"><h5>'.$value2['nombre'].'</h5></div>
                        </article>
                    </a>
                    </div>';
                }
            $out .= '</section></div></div>';
        }
    }
}
/* echo '<pre>';
print_r($arrCategorias);
echo '</pre>'; */
//LISTADO____________________________________________________________________

?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); ?>
        <?php include_once('inc/menu.inc.php'); ?>
    </div>
    <div id="productos" class="max-ysana">
        <div id="todosproductos">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 centrar-vertical">
                    <div class="contenedor">
                        <h1 class="ttl">Todos los productos de Ysana® Vida Sana</h1>
                        <p class="txt principal">YSANA® PONE LA GRAN EXPERIENCIA TERAPÉUTICA A NIVEL INTERNACIONAL DE PHARMALINK AL SERVICIO DE SUS GAMAS DE PRODUCTOS NATURALES, PARA TU CUIDADO Y EL DE LOS TUYOS.</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 centrar-vertical der">
                    <img src="<?php echo $ruta_inicio; ?>img/productosnew/ysanavidasana.jpg" class="img-fluid" alt="">
                </div>
            </div>
        </div>
        <?php echo $out; ?>
    </div>
    <?php include_once('inc/mapa.inc.php'); ?>
    <?php include_once('inc/footer.inc.php'); ?>
</body>
</html>