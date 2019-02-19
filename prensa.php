<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');
$frm_nombre = '';
$frm_email = '';
$frm_direccion = '';
$frm_cp = '';
$frm_tel = '';
$frm_pregunta = '';
$terminos_condiciones = '';


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

    <div class="jumbotronprensa jumbotronpersonalizado"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-lg-4 mt-4 mb-4">
                <div class="contenido-prensa d-flex flex-column align-items-center">
                    <img src="<?php echo $ruta_inicio; ?>img/wallpaper.png" class="prensa-img img-fluid" alt="">
                    <h1 class="titulo-prensa mt-3">Prueba 1</h1>
                    <p class="texto-prensa">Texto de prueba muy pero que muy muy muy largo eeeeeh</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 mt-4 mb-4">
                <div class="contenido-prensa d-flex flex-column align-items-center">
                    <img src="<?php echo $ruta_inicio; ?>img/wallpaper.png" class="prensa-img img-fluid" alt="">
                    <h1 class="titulo-prensa mt-3">Prueba 1</h1>
                    <p class="texto-prensa">Texto de prueba muy pero que muy muy muy largo eeeeeh</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 mt-4 mb-4">
                <div class="contenido-prensa d-flex flex-column align-items-center">
                    <img src="<?php echo $ruta_inicio; ?>img/wallpaper.png" class="prensa-img img-fluid" alt="">
                    <h1 class="titulo-prensa mt-3">Prueba 1</h1>
                    <p class="texto-prensa">Texto de prueba muy pero que muy muy muy largo eeeeeh</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 mt-4 mb-4">
                <div class="contenido-prensa d-flex flex-column align-items-center">
                    <img src="<?php echo $ruta_inicio; ?>img/wallpaper.png" class="prensa-img img-fluid" alt="">
                    <h1 class="titulo-prensa mt-3">Prueba 1</h1>
                    <p class="texto-prensa">Texto de prueba muy pero que muy muy muy largo eeeeeh</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 mt-4 mb-4">
                <div class="contenido-prensa d-flex flex-column align-items-center">
                    <img src="<?php echo $ruta_inicio; ?>img/wallpaper.png" class="prensa-img img-fluid" alt="">
                    <h1 class="titulo-prensa mt-3">Prueba 1</h1>
                    <p class="texto-prensa">Texto de prueba muy pero que muy muy muy largo eeeeeh</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 mt-4 mb-4">
                <div class="contenido-prensa d-flex flex-column align-items-center">
                    <img src="<?php echo $ruta_inicio; ?>img/wallpaper.png" class="prensa-img img-fluid" alt="">
                    <h1 class="titulo-prensa mt-3">Prueba 1</h1>
                    <p class="texto-prensa">Texto de prueba muy pero que muy muy muy largo eeeeeh</p>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('inc/footer.inc.php'); ?>
</body>

</html>