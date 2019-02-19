<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');

$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';
$nombre_usuario = '';
$apellidos_usuario = '';
$genero = '';
$email_usuario = '';
$password_usuario = '';
$str_error = '';
$str_info = '';
$arr_genero = array(
    'F' => $lng['forms'][7],
    'M' => $lng['forms'][8]
);

//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________
if(isset($_POST['id_usuario'])){
    $ruu = $uM->update_usuario($id_usuario, $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['genero']);
    if($ruu){
        $str_info = 'Datos actualizados';
        $uM->add_post_zoho('https://creator.zoho.eu/api/pharmalink/json/ysanaapp/form/usuarios/record/add/', array(
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

//CONTROL__________________________________________________________________________
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
if (!isset($_SESSION['id_tipo_usuario'])) { //si hay login
    header('Location: '.$ruta_inicio);
    exit();
}
//CONTROL__________________________________________________________________________

include_once('../inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">

</script>

<body>
    <?php include_once('../inc/panel_top_clubysana.inc.php'); ?>
    <?php include_once('../inc/navbar_inicio.inc.php'); ?>
    <div class="container-fluid px-0">
        <ul id="nav-clubysana" class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="areapersonal-tab" data-toggle="tab" href="#areapersonal" role="tab" aria-controls="areapersonal" aria-selected="true">
                    <?php echo $lng['clubysana'][7]; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="experiencia-tab" data-toggle="tab" href="#experiencia" role="tab" aria-controls="experiencia" aria-selected="false">
                    <?php echo $lng['clubysana'][8]; ?>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="areapersonal" role="tabpanel" aria-labelledby="areapersonal-tab">
                <div class="container-fluid">
                    <nav>
                        <ol class="breadcrumb bg-white pl-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo $ruta_inicio; ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo $ruta_inicio; ?>clubysana"><?php echo $lng['breadcrumb'][2]; ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $lng['breadcrumb'][3]; ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="container-fluid d-flex flex-row justify-content-around align-items-center flex-wrap">
                    <div class="datos-personales py-5 min-wd-300">
                        <form method="post">
                            <h3><?php echo $lng['clubysana'][3]; ?></h3>
                            <?php
                            if($str_error){
                                echo $hM->get_alert_danger($str_error);
                            }else{
                                if($str_info){
                                    echo $hM->get_alert_success($str_info);
                                }
                                echo $iM->get_input_hidden('id_usuario', $id_usuario);
                                echo $iM->get_input_text('nombre_usuario', $nombre_usuario, 'inputFrm', '', $lng['forms'][4],'', '', '', '', 'form-group', false);
                                echo $iM->get_input_text('apellidos_usuario', $apellidos_usuario, 'inputFrm', '', $lng['forms'][5],'', '', '', '', 'form-group', false);
                                echo $iM->get_input_hidden('email_usuario', $email_usuario);
                                echo $iM->get_input_text('email', $email_usuario, 'inputFrm', '', $lng['forms'][14],'', '', '', '', 'form-group', true);
                                echo $iM->get_select('genero', $genero, $arr_genero, 'inputFrm');
                                echo '<button class="inputFrm enviar">'.$lng['forms'][19].'</button>';
                            }
                            ?>
                            
                        </form>
                    </div>
                    <div class="sueno">
                        <a target="_blank" href="https://survey.zohopublic.eu/zs/fbB8dr">
                            <img src="<?php echo $ruta_inicio;?>img/club-ysana-picto-sueño-1.png" alt="">
                            <h5><?php echo $lng['clubysana'][4]; ?></h5>
                            <button class="btn-degr-cy my-2"><?php echo $lng['clubysana'][5]; ?></button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="experiencia" role="tabpanel" aria-labelledby="experiencia-tab">
                <div class="container-fluid">
                    <nav>
                        <ol class="breadcrumb bg-white pl-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo $ruta_inicio; ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo $ruta_inicio; ?>clubysana"><?php echo $lng['breadcrumb'][2]; ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $lng['breadcrumb'][4]; ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="container-fluid">
                    <div class="tuexperiencia py-5">
                        <div class="cont">
                            <a href="<?php echo $ruta_inicio; ?>clubysana/areapersonal/neurologia">
                                <img src="<?php echo $ruta_inicio; ?>img/club-ysana-pictograma-usuario-mental.png" alt="">
                                <h2><?php echo $lng['clubysana'][6]; ?></h2>
                            </a>
                        </div>
                        <!-- <div class="cont">
                            <a href="#2">
                                <img src="<?php echo $ruta_inicio; ?>img/club-ysana-pictograma-usuario-mujer.png" alt="">
                                <h2>Club Ysana® 360 MUJER</h2>
                            </a>
                        </div>
                        <div class="cont">
                            <a href="#3">
                                <img src="<?php echo $ruta_inicio; ?>img/club-ysana-pictograma-usuario-vias altas.png" alt="">
                                <h2>Club Ysana® 360 VIAS ALTAS</h2>
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include_once('../inc/footer.inc.php'); ?>
</body>

</html>