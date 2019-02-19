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
            <h1><?php echo $lng['footer'][70]; ?></h1>
        </div>
        <div class="">
            <p><?php echo $lng['footer'][71]; ?></p>
            <p><?php echo $lng['footer'][72]; ?></p>
            
            <h2><?php echo $lng['footer'][73]; ?></h2>
            <p><?php echo $lng['footer'][74]; ?></p>
            <p><?php echo $lng['footer'][75]; ?></p>
            <ul>
                <li><?php echo $lng['footer'][76]; ?></li>
                <li><?php echo $lng['footer'][77]; ?></li>
            </ul>
            
            <h2><?php echo $lng['footer'][78]; ?></h2>
            <p><?php echo $lng['footer'][79]; ?></p>
            <p><?php echo $lng['footer'][80]; ?></p>
            
            <h2><?php echo $lng['footer'][81]; ?></h2>
            <p><?php echo $lng['footer'][82]; ?></p>
            
            <h2><?php echo $lng['footer'][83]; ?></h2>
            <p><?php echo $lng['footer'][84]; ?></p>
            <p><?php echo $lng['footer'][85]; ?></p>
            <p><?php echo $lng['footer'][86]; ?></p>
            <p><?php echo $lng['footer'][87]; ?></p>
            <p><?php echo $lng['footer'][88]; ?></p>
            
            <ul>
                <li><?php echo $lng['footer'][89]; ?></li>
                <li><?php echo $lng['footer'][90]; ?></li>
                <li><?php echo $lng['footer'][91]; ?></li>
                <li><?php echo $lng['footer'][92]; ?></li>
                <li><?php echo $lng['footer'][93]; ?></li>
                <li><?php echo $lng['footer'][94]; ?></li>
            </ul>
            
            <p><?php echo $lng['footer'][95]; ?></p>
            <p><?php echo $lng['footer'][96]; ?></p>
            
            <h2><?php echo $lng['footer'][97]; ?></h2>
            <p><?php echo $lng['footer'][98]; ?></p>
            <p><?php echo $lng['footer'][99]; ?></p>
            <p><?php echo $lng['footer'][100]; ?></p>
            
            <h2><?php echo $lng['footer'][101]; ?></h2>
            <p><?php echo $lng['footer'][102]; ?></p>
            <p><?php echo $lng['footer'][103]; ?></p>
            
        </div>
    </div>
        <?php include_once('inc/footer.inc.php'); ?>
</body>
</html>