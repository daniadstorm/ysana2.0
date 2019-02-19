<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion
$uM = load_model('usuario');
$iM = load_model('inputs');
$uM->control_sesion($ruta_inicio, ADMIN);
include_once('inc/cabecera.inc.php'); //cargando cabecera 
?>

<body>
    <?php include_once('inc/franja_top.inc.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>aaa</h1>
            </div>
        </div>
    </div>
</body>
</html>