<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$fM = load_model('form');
$sM = load_model('seo');
$hM = load_model('html');

$nombre_usuario = '';
$contrasenya_usuario = '';
$str_info = '';
$arr_err = array();

$enviar_mail = '';
$random = '';
$id_usuario = '';



//GET__________________________________________________________________________
if(isset($_GET['randomkey'])){
    $enviar_mail = false;
    $rgcr = $uM->get_comprobar_randomkey($_GET['randomkey']);
    $random_prov = '';
    if($rgcr){
        while($frgcr = $rgcr->fetch_assoc()){
            $id_usuario = $frgcr['id_usuario'];
            $random_prov = $frgcr['randomkey'];
        }
        if($random_prov==$_GET['randomkey']){
            $random = $_GET['randomkey'];
        }else{
            header('Location: '.$ruta_inicio.'login.php');
        }
    }
}else{
    $enviar_mail = true;
}
//GET__________________________________________________________________________


//POST__________________________________________________________________________
if(isset($_POST['randomkey'])){
    if($_POST['password_usuario']==$_POST['password_conf_usuario']){
        
        $rup = $uM->update_password($_POST['password_usuario'], $_POST['id_usuario'], rand(50000,100000));
        if($rup){
            $str_info = $lng['forms'][16];
        }else{
            $str_info = $lng['forms'][17];
        }
    }
}


if(isset($_POST['email_usuario'])){
    $raru = $uM->add_randomkey_usuario($_POST['email_usuario'],24);
    if($raru){
        $rufm = $uM->user_forgotpass_mail($_POST['email_usuario'], $raru, $ruta_inicio, $_SESSION['id_lang']);
        if($rufm){
            //echo 'Todo bien';
        }else{
            //echo 'Todo mal';
        }
    }else{
        $str_errores = $lng['forms'][18];
    }
}
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
            if(isset($str_errores) && $str_errores){
                echo $hM->get_alert($str_errores,"alert-danger");
            } ?>
            <?php if($enviar_mail){ ?>
            <form method="post" class="inputs">
            <input type="text" name="recuperacion" hidden>
                <p>Introduce tu dirección de correo electrónico de recuperación</p>
                <input type="text" name="email_usuario" placeholder="<?php echo $lng['forms'][14]; ?>" required>
                <input type="submit" value="Enviar">
            </form>
            <?php }else if(!$str_info){ ?>
            <form method="post" class="inputs">
                <input type="text" name="id_usuario" value="<?php echo $id_usuario; ?>" hidden>
                <input type="text" name="randomkey" value="<?php echo $random; ?>" hidden>
                <p>Introduce tu nueva nueva contraseña</p>
                <input type="password" name="password_usuario" minlength="6" placeholder="<?php echo $lng['forms'][9]; ?>" required>
                <input type="password" name="password_conf_usuario" minlength="6" placeholder="<?php echo $lng['forms'][10]; ?>" required>
                <input type="submit" value="Enviar">
            </form>
            <?php }else if(isset($str_info) && $str_info){ 
                    echo $hM->get_alert_success($str_info);
                }
            ?>
        </div>
    </div>
    <?php include_once('inc/footer.inc.php'); ?>
</body>
</html>