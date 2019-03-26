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
$cy=false;

//GET___________________________________________________________________________
if (isset($_GET['unlogin'])) {
    $uM->unlogin_usuario();
}
if (isset($_GET['cy'])){
    $cy=true;
}
//GET___________________________________________________________________________

//POST__________________________________________________________________________
if (isset($_POST['nombre_usuario'])) { //si viene de submit de login
    
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasenya_usuario = $_POST['contrasenya_usuario'];
    
    $result_login = $uM->login_usuario($nombre_usuario, $contrasenya_usuario, $lng['index'][22], $lng['index'][23]);
    if (strlen($result_login) > 1) {
        $str_errores = $result_login;
    }
}
//POST__________________________________________________________________________
/* echo '<pre>'.print_r($_POST).'</pre>'; */
//CONTROL_______________________________________________________________________
if (isset($_SESSION['id_tipo_usuario'])) { //si hay login
    switch ($_SESSION['id_tipo_usuario']) {
        default:
        case USER:
            if(isset($_POST['cy'])) header('Location: '.$ruta_inicio.'clubysana');
            else header('Location: '.$ruta_inicio);
            exit();
        break;
        case ADMIN:
            header('Location: '.$ruta_inicio.'admin.php');
            exit();
        break;
    }
}
//CONTROL_______________________________________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]); 

?>
<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); //panel superior ?>
        <?php include_once('inc/menu.inc.php'); //menu superior ?>
    </div>
    <div class="max-ysana w-100">
        <div class="login-responsive">
            <div class="wrapper">
                <h1 class="titulo">Inicia sesión en Ysana</h1>
                <?php if(isset($str_errores) && $str_errores) echo $hM->get_alert($str_errores,"alert-danger"); ?>
                <form method="post" class="form-row">
                    <?php echo $iM->get_input_text('nombre_usuario', '', 'form-control col-12 col-md-6', '', 'Correo eléctronico', '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo $iM->get_input_text('contrasenya_usuario', '', 'form-control col-12 col-md-6', '', 'Password', '', '', '', false, 'form-group w-100', false); ?>
                    <input type="submit" class="btn btn-bg-color-2" value="Iniciar Sesión">
                </form>
            </div>
            <div class="footer">
                <p>¿Nuevo en Ysana? <a href="<?php echo $ruta_inicio; ?>registro">Regístrate ahora »</a></p>
                <p>¿Has olvidado tu contraseña? <a href="<?php echo $ruta_inicio; ?>forgot-password">Recuperar contraseña »</a></p>
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