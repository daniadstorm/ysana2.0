<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$sM = load_model('seo');
$cyM = load_model('clubysana');
/* $uM->control_sesion($ruta_inicio, USER); */

$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';
$id_lang = (isset($_SESSION['id_lang'])) ? $_SESSION['id_lang'] : '';
$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');
$id_articulo = (isset($_REQUEST['urlseo']) ? $_REQUEST['urlseo'] : '');

/*  */
$titulo = '';
$texto_col1 = '';
$texto_col2 = '';
$id_slider = '';
$arr_sliders = array();
/*  */

//GET___________________________________________________________________________
//GET___________________________________________________________________________

//POST__________________________________________________________________________
//POST__________________________________________________________________________

//CONTROL_______________________________________________________________________
if($id_articulo!=''){
    $rgdeii = $cyM->get_datos_experiencias_urlseo($id_articulo);
    if($rgdeii){
        while($frgdeii = $rgdeii->fetch_assoc()){
            /* echo '<pre>';    
            print_r($frgdeii);
            echo '</pre>'; */
            $titulo = $frgdeii['titulo'];
            $texto_col1 = $frgdeii['texto_columna1'];
            $texto_col2 = $frgdeii['texto_columna2'];
            $id_slider = $frgdeii['id_info'];
        }
    }
    $rgse = $cyM->get_sliders_experiencias($id_slider);
    if($rgse){
        while($frgse = $rgse->fetch_assoc()){
            array_push($arr_sliders, $frgse);
            /* echo '<pre>';
            print_r($frgse);
            echo '</pre>'; */
        }
    }

}else{
    header('Location: '.$ruta_inicio.'clubysana/miexperiencia/');
}
//CONTROL_______________________________________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng[0]);
?>

<body>
    <div id="menu-sticky">
        <?php include_once('../inc/panel_top.inc.php'); ?>
        <?php include_once('../inc/menu.inc.php'); ?>
    </div>

    <div id="clubysana-articulo" class="max-ysana marg-ysana">
        <div class="margen-general">
            <div class="titulo">
                <h1 class="ttl"><?php echo $titulo; ?></h1>
            </div>
            <?php if(count($arr_sliders)>0){ ?>
            <div class="row art-col-1">
                <div class="col-sm-6 art-slider izq">
                    <h1 class="slider-titulo"><?php echo $arr_sliders[0]['titulo']; ?></h1>
                    <p class="slider-descripcion"><?php echo $arr_sliders[0]['descripcion']; ?></p>
                </div>
                <div class="col-sm-6 art-slider der">
                    <img src="<?php echo $ruta_inicio ?>img/clubysana/<?php echo $arr_sliders[0]['img']; ?>" alt="" class="img-fluid">
                </div>
            </div>
            <?php } ?>
            <div class="row art-col-2">
                <div class="col-12 col-md-6">
                    <p class="columna"><?php echo $texto_col1; ?></p>
                </div>
                <div class="col-12 col-md-6">
                    <p class="columna"><?php echo $texto_col2; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../inc/banRedes.inc.php'); ?>
    <?php include_once('../inc/footer.inc.php'); ?>
</body>
</html>