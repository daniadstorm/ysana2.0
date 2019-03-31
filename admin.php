<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion
$uM = load_model('usuario');
$iM = load_model('inputs');
$sM = load_model('seo');
$uM->control_sesion($ruta_inicio, ADMIN);

echo $sM->add_cabecera($ruta_inicio, '', 'admin'); 
?>

<body>
    <?php include_once('inc/franja_top.inc.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>Panel admin</h1>
            </div>
        </div>
    </div>
</body>
</html>