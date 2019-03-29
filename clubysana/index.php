<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');
if($uM->control_sesion($ruta_inicio, USER)){
    if(isset($_REQUEST['clubysana'])) header('Location: '.$ruta_inicio.'clubysana/miexperiencia');
    else header('Location: '.$ruta_inicio.'profile');
}
echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]);


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
            <p>Únete ahora al Club Ysana y enlaza con la vida sana. La primera comunidad online orientada al autocuidado y los hábitos de vida saludables, donde podrás compartir tus inquietudes, obtener consejos personalizados de farmacéuticos y coachs profesionales, obtener premios, acceder a muestras de producto en primicia, compartir experiencias y, por supuesto, mejorar tus hábitos de vida de manera constante.</p>
        </div>
        <div class="cta">
            <a href="<?php echo $ruta_inicio; ?>" class="btn btn-enlace">UNIRME AL CLUB YSANA</a>
        </div>
        <div class="skyline anchoclubysana">
            <img src="<?php echo $ruta_inicio; ?>img/svg/skylinemagenta.svg" alt="">
        </div>
    </div>

    <?php include_once('../inc/footer.inc.php'); ?>
</body>
</html>