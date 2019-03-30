<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');
if (isset($_SESSION['id_tipo_usuario'])) { //si hay login
    header('Location: '.$ruta_inicio.'clubysana/miexperiencia/');
}
echo $sM->add_cabecera($ruta_inicio, $lng[0]);
?>

<body>
    <div id="menu-sticky">
        <?php include_once('../inc/panel_top.inc.php'); ?>
        <?php include_once('../inc/menu.inc.php'); ?>
    </div>

    <div id="clubysana-home" class="max-ysana marg-ysana px-2">
        <div class="logocy">
            <img src="<?php echo $ruta_inicio; ?>img/svg/clubysana.svg" alt="">
        </div>
        <div class="texto">
            <p><?php echo $lng[45]; ?></p>
        </div>
        <div class="cta">
            <a href="<?php echo $ruta_inicio; ?>clubysana/registro" class="btn btn-enlace"><?php echo $lng[46]; ?></a>
        </div>
        <div class="skyline anchoclubysana">
            <img src="<?php echo $ruta_inicio; ?>img/svg/skylinemagenta.svg" alt="">
        </div>
    </div>

    <?php include_once('../inc/footer.inc.php'); ?>
</body>
</html>