<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');

include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]); 
?>
<script type="text/javascript">

</script>

<body>
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio.inc.php'); ?>

    <?php //include_once('inc/footer.inc.php'); ?>
    <div class="container-fluid mt-5">
        <div>
            <h1><?php echo $lng['footer'][28]; ?></h1>
        </div>
        <div class="">
            <p><?php echo $lng['footer'][20]; ?></p>
            <p><?php echo $lng['footer'][21]; ?></p>
        </div>
        <div class="">
            <ul>
                <li><?php echo $lng['footer'][22]; ?></li>
                <li><?php echo $lng['footer'][23]; ?></li>
                <li><?php echo $lng['footer'][24]; ?></li>
                <li><?php echo $lng['footer'][25]; ?></li>
                <li><?php echo $lng['footer'][26]; ?></li>
            </ul>
        </div>
        <div class="">
            <p><?php echo $lng['footer'][27]; ?></p>
        </div>
    </div>
        <?php include_once('inc/footer.inc.php'); ?>
</body>
</html>