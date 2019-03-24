<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$fM = load_model('form');
$sM = load_model('seo');
$hM = load_model('html');

$str_info = array();
$str_error = array();

$enviar_mail = '';
$random = '';
$id_usuario = '';
$dardebaja = false;


//GET__________________________________________________________________________
if(isset($_GET['randomkey'])){
    $rgcr = $uM->get_dardebaja_randomkey($_GET['randomkey']);
    $random_prov = '';
    if($rgcr){
        $rdu = $uM->delete_user($_GET['randomkey']);
        $uM->unlogin_usuario();
        if($rdu) array_push($str_info, "Te has dado de baja correctamente");
        else array_push($str_error, "Error al darte de baja");
    }else header('Location: '.$ruta_inicio.'login.php');
}else header('Location: '.$ruta_inicio.'login.php');

//GET__________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

//CONTROL_______________________________________________________________________

//CONTROL_______________________________________________________________________

include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]); 
?>
<script type="text/javascript"></script>
<body>
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio.inc.php'); ?>
    <div class="ysana-login">
        <div class="ysana-login-sub">
            <div class="logo mt-5 mb-5">
                <img src="<?php echo $ruta_inicio;?>img/svg/ysanacolor.svg" class="img-responsive" alt="">
            </div>
            <?php
            if(count($str_error)>0) foreach ($str_error as $value) { echo $hM->get_alert_danger($value); }
            else if($str_info) foreach ($str_info as $value) { echo $hM->get_alert_success($value); }
            ?>
        </div>
    </div>
    <?php include_once('inc/footer.inc.php'); ?>
</body>
</html>