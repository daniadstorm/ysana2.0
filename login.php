<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$fM = load_model('form');
$sM = load_model('seo');
$hM = load_model('html');
$iM = load_model('inputs');

$nombre_usuario = '';
$contrasenya_usuario = '';

$arr_err = array();
$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');
$str_info = (isset($_REQUEST['str_info']) ? $lng[28] : '');
$ruta_anterior = (isset($_REQUEST['ruta_anterior']) ? $_REQUEST['ruta_anterior'] : '/');

//GET___________________________________________________________________________
if (isset($_GET['unlogin'])) {
    $uM->unlogin_usuario();
}
//GET___________________________________________________________________________

//POST__________________________________________________________________________
if (isset($_POST['nombre_usuario'])) { //si viene de submit de login
    
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasenya_usuario = $_POST['contrasenya_usuario'];
    
    $result_login = $uM->login_usuario($nombre_usuario, $contrasenya_usuario, $lng[29], $lng[30]);
    if (strlen($result_login) > 1) {
        $str_errores = $result_login;
    }
}
//POST__________________________________________________________________________
/* echo '<pre>'.print_r($_POST).'</pre>'; */
//CONTROL_______________________________________________________________________
if (isset($_SESSION['id_tipo_usuario'])) { //si hay login
    header('Location: '.$ruta_dominio.$ruta_anterior);
}
//CONTROL_______________________________________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng[0]); 

?>
<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); //panel superior ?>
        <?php include_once('inc/menu.inc.php'); //menu superior ?>
    </div>
    <div class="max-ysana w-100">
        <div class="login-responsive">
            <div class="wrapper">
                <h1 class="titulo<?php echo $clubysana; ?>"><?php echo $lng[31]; ?></h1>
                <?php if(isset($str_errores) && $str_errores) echo $hM->get_alert($str_errores,"alert-danger"); ?>
                <?php if(isset($str_info) && $str_info) echo $hM->get_alert($str_info,"alert-success"); ?>
                <form method="post" class="form-row">
                    <?php echo $iM->get_input_text('nombre_usuario', '', 'form-control col-12 col-md-6', '', $lng[32], '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo $iM->get_input_text('contrasenya_usuario', '', 'form-control col-12 col-md-6', '', $lng[33], '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo '<input hidden type="text" name="cy" value="'.$clubysana.'">'; ?>
                    <input type="submit" class="btn btn-bg-color-2 btn-bg-color-2<?php echo $clubysana; ?>" value="<?php echo $lng[34]; ?>">
                </form>
            </div>
            <div class="footer">
                <p><?php echo $lng[35]; ?> <a href="<?php echo $ruta_inicio; ?>registro"><?php echo $lng[36]; ?> »</a></p>
                <p><?php echo $lng[37]; ?> <a href="<?php echo $ruta_inicio; ?>forgot-password"><?php echo $lng[38]; ?> »</a></p>
            </div>
        </div>
    </div>
    <!-- <div class="ysana-login">
        <div class="ysana-login-sub">
            <div class="logo mt-5 mb-5">
                <img src="<?php echo $ruta_inicio;?>img/svg/<?php echo ($cy) ? 'clubysana' : 'ysanacolor' ?>.svg" class="img-responsive" alt="">
            </div>
            <?php
            if(isset($str_errores) && $str_errores){
                echo $hM->get_alert($str_errores,"alert-danger");
            } ?>
            <form method="post" class="inputs">
                <?php
                if($cy) echo '<input hidden type="text" name="cy" value="true">';
                ?>
                <input class="<?php echo ($cy) ? 'cycolor' : ''; ?>" type="text" name="nombre_usuario" placeholder="<?php echo $lng['forms'][0]; ?>">
                <input class="<?php echo ($cy) ? 'cycolor' : ''; ?>" type="password" name="contrasenya_usuario" placeholder="<?php echo $lng['forms'][1]; ?>">
                <input class="<?php echo ($cy) ? 'cycolor' : ''; ?>" type="submit" value="<?php echo $lng['forms'][2]; ?>">
                <a href="<?php echo $ruta_inicio; ?>forgot-password"><input class="<?php echo ($cy) ? 'cycolor' : ''; ?>" type="button" value="<?php echo $lng['forms'][3]; ?>"></a>
            </form>
        </div>
    </div> -->
    
    
    <?php include_once('inc/footer.inc.php'); //panel superior ?>
</body>


<script>
    $("#polaroid").on('click', '.pol', function(){
        console.log(this);
    });
</script>
</html>