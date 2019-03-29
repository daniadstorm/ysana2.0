<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$fM = load_model('form');
$sM = load_model('seo');
$hM = load_model('html');
$iM = load_model('inputs');

$nombre_usuario = '';
$contrasenya_usuario = '';
$captcha = false;
$arr_err = array();
$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');
$ruta_anterior = (isset($_REQUEST['ruta_anterior']) ? $_REQUEST['ruta_anterior'] : '/');

//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________

if(isset($_POST['id_usuario'])){
    if(!$uM->get_existe_correo($_POST['email_usuario'])){
        if($uM->add_usuario($_POST['nombre_usuario'],$_POST['apellidos_usuario'], $_POST['email_usuario'], $_POST['genero_usuario'], $_POST['password_usuario'])){
            $uM->add_post_zoho('https://creator.zoho.eu/api/pharmalink/json/ysanaapp/form/usuarios/record/add/', array(
                'authtoken' => AUTHTOKEN,
                'scope' => SCOPE,
                'id_usuario' => $_POST['email_usuario'],
                'nombre_usuario' => $_POST['nombre_usuario'],
                'apellidos_usuario' => $_POST['apellidos_usuario'],
                'email_usuario' => $_POST['email_usuario'],
                'genero_usuario' => $_POST['genero_usuario']
            ));
            $uM->user_nuevousuario_mail($_POST['email_usuario'], $ruta_inicio, $_SESSION['id_lang']);
            header('Location: '.$ruta_inicio.'login?str_info=registro');
        }else{
            $str_errores = $lng['forms'][12];
        }
    }else{
        $str_errores = $lng['forms'][13];
    }
}
//POST__________________________________________________________________________

//CONTROL_______________________________________________________________________
if (isset($_SESSION['id_tipo_usuario'])) { //si hay login
    header('Location: '.$ruta_dominio.$ruta_anterior);
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
                <h1 class="titulo<?php echo $clubysana; ?>">Registrate en Ysana</h1>
                <?php if(isset($str_errores) && $str_errores) echo $hM->get_alert($str_errores,"alert-danger"); ?>
                <form method="post" class="form-row">
                    <?php echo $iM->get_input_hidden('authtoken', AUTHTOKEN); ?>
                    <?php echo $iM->get_input_hidden('scope', SCOPE); ?>
                    <?php echo $iM->get_input_hidden('id_usuario', 0); ?>
                    <?php echo $iM->get_input_text('nombre_usuario', '', 'form-control col-12 col-md-8', '', 'Nombre', '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo $iM->get_input_text('apellidos_usuario', '', 'form-control col-12 col-md-8', '', 'Apellidos', '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo $iM->get_input_text('email_usuario', '', 'form-control col-12 col-md-8', '', 'Correo eléctronico', '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo $iM->get_input_text('password_usuario', '', 'form-control col-12 col-md-8', '', 'Password', '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo $iM->get_input_text('password_usuario', '', 'form-control col-12 col-md-8', '', 'Confirmar Password', '', '', '', false, 'form-group w-100', false); ?>
                    <?php echo '<input hidden type="text" name="cy" value="'.$clubysana.'">'; ?>
                    <input id="button_enviar" name="button_enviar" type="submit" class="btn btn-bg-color-2 btn-bg-color-2<?php echo $clubysana; ?>" value="Iniciar Sesión" disabled>
                </form>
            </div>
            <div class="footer">
                <p>¿Ya tienes una cuenta? <a href="<?php echo $ruta_inicio; ?>login">Inicia sesion »</a></p>
            </div>
        </div>
    </div>    
    <?php include_once('inc/footer.inc.php'); //panel superior ?>
</body>
<script>
    $(document).ready(function(){
        $('input').keyup(function(event){
            var password_usuario = document.getElementsByName('password_usuario')[0].value;
            var password_usuario1 = document.getElementsByName('password_usuario')[1].value;
            if(password_usuario==password_usuario1 && password_usuario!=''){
                $('#button_enviar').prop("disabled", false);
            }else{
                $('#button_enviar').prop("disabled", true);
            }
        });
    });
</script>
</html>


<!-- <body>
    <?php //include_once('inc/panel_top.inc.php'); ?>
    <?php //include_once('inc/navbar_inicio.inc.php'); ?>
    <div class="ysana-login">
        <div class="ysana-login-sub">
            
            <form method="post" class="inputs">
                <input name="authtoken" value="<?php echo AUTHTOKEN; ?>" hidden>
                <input name="scope" value="<?php echo SCOPE; ?>" hidden>
                <input type="text" name="id_usuario" value="0" hidden>
                <input type="text" name="nombre_usuario" minlength="4" placeholder="<?php echo $lng['forms'][4]; ?>" required>
                <input type="text" name="apellidos_usuario" minlength="6" placeholder="<?php echo $lng['forms'][5]; ?>" required>
                <input type="email" name="email_usuario" placeholder="<?php echo $lng['forms'][6]; ?>" required>
                <select name="genero_usuario" id="genero_usuario" required>
                    <option value="F"><?php echo $lng['forms'][7]; ?></option>
                    <option value="M"><?php echo $lng['forms'][8]; ?></option>
                </select>
                <input type="password" name="password_usuario" minlength="6" placeholder="<?php echo $lng['forms'][9]; ?>" required>
                <input type="password" name="password_usuario" minlength="6" placeholder="<?php echo $lng['forms'][10]; ?>" required>
                <div class="g-recaptcha" data-sitekey="6Lchi34UAAAAANUKKZmltkZCIcYozGdCT7YRgZq4"></div>
                <input id="button_enviar" disabled type="submit" name="button_enviar" value="<?php echo $lng['forms'][11]; ?>">
            </form>
            <script>
            $(document).ready(function(){
                $('input').keyup(function(event){
                    var password_usuario = document.getElementsByName('password_usuario')[0].value;
                    var password_usuario1 = document.getElementsByName('password_usuario')[1].value;
                    if(password_usuario==password_usuario1 && password_usuario!=''){
                        $('#button_enviar').prop("disabled", false);
                    }else{
                        $('#button_enviar').prop("disabled", true);
                    }
                });
            });
            </script>
        </div>
    </div>
    <?php include_once('inc/footer.inc.php'); ?>
</body>
</html> -->