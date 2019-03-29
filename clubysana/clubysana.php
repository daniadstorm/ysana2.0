<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');
$uM->control_sesion($ruta_inicio, USER);

$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';
$nombre_usuario = '';
$apellidos_usuario = '';
$email_usuario = '';
$genero = '';
$arr_genero = array(
    'M' => $lng['forms'][8],
    'F' => $lng['forms'][7]
);
$opcion = 'experiencia';
$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');

if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
}

//GET___________________________________________________________________________
//GET___________________________________________________________________________

//POST__________________________________________________________________________
if(isset($_POST['dardeBaja'])){
    $raru = $uM->add_randomkey_usuario($_POST['email_usuario'], 24);
    if($raru){
        $rufm = $uM->user_unsuscribe_mail($_POST['email_usuario'], $raru, $ruta_inicio, $_SESSION['id_lang']);
        if($rufm){
            $str_info = $lng['clubysana'][12];
        }else{
            //echo 'Todo mal';
        }
    }else{
        $str_errores = $lng['forms'][18];
    }
}
if(isset($_POST['id_usuario'])){
    $ruu = $uM->update_usuario($id_usuario, $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['genero']);
    if($ruu){
        $str_info = 'Datos actualizados';
        $rapz = $uM->add_post_zoho('https://creator.zoho.eu/api/pharmalink/json/ysanaapp/form/usuarios/record/add/', array(
            'authtoken' => AUTHTOKEN,
            'scope' => SCOPE,
            'id_usuario' => $_POST['email_usuario'],
            'nombre_usuario' => $_POST['nombre_usuario'],
            'apellidos_usuario' => $_POST['apellidos_usuario'],
            'email_usuario' => $_POST['email_usuario'],
            'genero_usuario' => $_POST['genero']
        ));
    }else{
        $str_error = $lng['forms'][20];
    }
}
//POST__________________________________________________________________________

//CONTROL_______________________________________________________________________
if($id_usuario>0){
    $rgdu = $uM->get_datos_usuario($id_usuario);
    if($rgdu){
        while($frgdu = $rgdu->fetch_assoc()){
            $nombre_usuario = $frgdu['nombre_usuario'];
            $apellidos_usuario = $frgdu['apellidos_usuario'];
            $email_usuario = $frgdu['email_usuario'];
            $genero = $frgdu['genero'];
        }
    }else{
        $str_error = $lng['forms'][21];
    }
}
//CONTROL_______________________________________________________________________


echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]);
?>

<body>
    <div id="menu-sticky">
        <?php include_once('../inc/panel_top.inc.php'); ?>
        <?php include_once('../inc/menu.inc.php'); ?>
    </div>

    <div id="clubysana-general" class="max-ysana marg-ysana">
        <div class="general px-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item <?php echo ($clubysana=='') ? 'quitar-lateral' : ''; ?>">
                    <a class="nav-link <?php echo ($opcion=="perfil") ? 'active' : ''; ?>" id="perfil-tab" data-toggle="tab" href="#perfil" role="tab" aria-controls="perfil" aria-selected="true">Mi perfil</a>
                </li>
                <?php if($clubysana!=''){ ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($opcion=="experiencia") ? 'active' : ''; ?>" id="experiencia-tab" data-toggle="tab" href="#experiencia" role="tab" aria-controls="experiencia" aria-selected="false">Tu Experiencia</a>
                </li>
                <?php } ?>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade <?php echo ($opcion=="perfil") ? 'show active' : ''; ?>" id="perfil" role="tabpanel" aria-labelledby="perfil-tab">
                    <div class="<?php echo ($clubysana) ? 'cy-color' : 'y-color'; ?> cont-max">
                        <div class="ttl">Mis datos personales</div>
                        <form action="" method="post" class="form-row mb-0 mt-3">
                            <?php
                            echo $iM->get_input_hidden('id_usuario', $id_usuario);
                            echo $iM->get_input_text('nombre_usuario', $nombre_usuario, 'form-control', $lng['forms'][4], '','', '', '', '', 'form-group col-md-6', false);
                            echo $iM->get_input_text('apellidos_usuario', $apellidos_usuario, 'form-control', $lng['forms'][5], '','', '', '', '', 'form-group col-md-6', false);
                            echo $iM->get_input_hidden('email_usuario', $email_usuario);
                            echo $iM->get_input_text('email', $email_usuario, 'form-control', $lng['forms'][14], '','', '', '', '', 'form-group col-md-6', true);
                            echo $iM->get_select('genero', $genero, $arr_genero, 'form-control', 'Genero', false, false, 'form-group col-md-6');
                            ?>
                            <div class="ml-auto">
                                <button><?php echo $lng['forms'][19]; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade <?php echo ($opcion=="experiencia") ? 'show active' : ''; ?>" id="experiencia" role="tabpanel" aria-labelledby="experiencia-tab">

                </div>
            </div>
        </div>
    </div>
    <?php include_once('../inc/footer.inc.php'); ?>
</body>
</html>