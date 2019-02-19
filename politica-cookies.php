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
    <div id="aviso-legal" class="container-fluid mt-5">
            <?php include_once('inc/politica-cookies.'.$lang.'.inc.php'); ?>
    </div>
    <!-- <div class="container-fluid mt-5">
        <div>
            <h1><?php echo $lng['footer'][29]; ?></h1>
        </div>
        <div class="">
            <p><?php echo $lng['footer'][30]; ?></p>
            <p><?php echo $lng['footer'][31]; ?></p>
            <p><?php echo $lng['footer'][32]; ?></p>
        </div>
        <div class="">
            <h2><?php echo $lng['footer'][33]; ?></h2>
            <h3><?php echo $lng['footer'][34]; ?></h3>
            <h4><?php echo $lng['footer'][35]; ?></h4>
            <p><?php echo $lng['footer'][36]; ?></p>
            <h4><?php echo $lng['footer'][37]; ?></h4>
            <p><?php echo $lng['footer'][38]; ?></p>
            
            <h3><?php echo $lng['footer'][39]; ?></h3>
            <h4><?php echo $lng['footer'][40]; ?></h4>
            <p><?php echo $lng['footer'][41]; ?></p>
            <h4><?php echo $lng['footer'][42]; ?></h4>
            <p><?php echo $lng['footer'][43]; ?></p>
            
            <h3><?php echo $lng['footer'][44]; ?></h3>
            <h4><?php echo $lng['footer'][45]; ?></h4>
            <p><?php echo $lng['footer'][46]; ?></p>
            <h4><?php echo $lng['footer'][47]; ?></h4>
            <p><?php echo $lng['footer'][48]; ?></p>
            <h4><?php echo $lng['footer'][49]; ?></h4>
            <p><?php echo $lng['footer'][50]; ?></p>
            <h4><?php echo $lng['footer'][51]; ?></h4>
            <p><?php echo $lng['footer'][52]; ?></p>
            <h4><?php echo $lng['footer'][53]; ?></h4>
            <p><?php echo $lng['footer'][54]; ?></p>
            
            <p><?php echo $lng['footer'][55]; ?></p>
            
            <h4><?php echo $lng['footer'][56]; ?></h4>
            <p><?php echo $lng['footer'][61]; ?></p>
            <p><?php echo $lng['footer'][62]; ?></p>
            <p><?php echo $lng['footer'][63]; ?></p>
            <p><?php echo $lng['footer'][64]; ?></p>
            
            <h4><?php echo $lng['footer'][57]; ?></h4>
            <p><?php echo $lng['footer'][61]; ?></p>
            <p><?php echo $lng['footer'][62]; ?></p>
            <p><?php echo $lng['footer'][63]; ?></p>
            <p><?php echo $lng['footer'][64]; ?></p>
            
            <h4><?php echo $lng['footer'][58]; ?></h4>
            <p><?php echo $lng['footer'][61]; ?></p>
            <p><?php echo $lng['footer'][62]; ?></p>
            <p><?php echo $lng['footer'][63]; ?></p>
            <p><?php echo $lng['footer'][64]; ?></p>
            
            <h4><?php echo $lng['footer'][59]; ?></h4>
            <p><?php echo $lng['footer'][61]; ?></p>
            <p><?php echo $lng['footer'][62]; ?></p>
            <p><?php echo $lng['footer'][63]; ?></p>
            <p><?php echo $lng['footer'][64]; ?></p>
            
            <h4><?php echo $lng['footer'][60]; ?></h4>
            <p><?php echo $lng['footer'][61]; ?></p>
            <p><?php echo $lng['footer'][62]; ?></p>
            <p><?php echo $lng['footer'][63]; ?></p>
            <p><?php echo $lng['footer'][64]; ?></p>
            
            <p><?php echo $lng['footer'][65]; ?></p>
            <p><?php echo $lng['footer'][66]; ?></p>
            <p><?php echo $lng['footer'][67]; ?></p>
        </div>
        <div class="">
            <p><?php echo $lng['footer'][68]; ?></p>
            <p><?php echo $lng['footer'][69]; ?></p>
            <ul>
                <li><?php echo $lng['footer'][22]; ?></li>
                <li><?php echo $lng['footer'][23]; ?></li>
                <li><?php echo $lng['footer'][24]; ?></li>
                <li><?php echo $lng['footer'][25]; ?></li>
                <li><?php echo $lng['footer'][26]; ?></li>
            </ul>
        </div>
    </div> -->
        <?php include_once('inc/footer.inc.php'); ?>
</body>
</html>