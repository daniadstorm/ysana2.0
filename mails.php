<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$hM = load_model('html');
$iM = load_model('inputs');
$uM->control_sesion($ruta_inicio, ADMIN);

$arr_filtro = array(//Estados
    0 => "Recuperar contraseña",
    1 => "Nuevo usuario",
    2 => "Nuevo pedido",
    3 => "Dar de baja"
);
$arr_lang = array(
    1 => 'spa',
    2 => 'eng'
);
$arr_filtro_ps = 0;
$arr_lang_ps = 1;
$asuntomail = '';
$editormail = '';
$mailCompleto = '';
//GET___________________________________________________________________________
if(isset($_REQUEST['arr_filtro'])){
    $arr_filtro_ps=$_REQUEST['arr_filtro'];
}
/* echo '<pre>';
print_r($_POST);
echo '</pre>'; */

if(isset($_REQUEST['arr_lang'])){
    $arr_lang_ps=$_REQUEST['arr_lang'];
}

//GET___________________________________________________________________________

//POST__________________________________________________________________________
if(isset($_POST['editormail'])){
    if(!$uM->existemail($arr_filtro_ps, $arr_lang_ps)){
        $rau = $uM->addmail($arr_filtro_ps, $arr_lang_ps, $_POST['asuntomail'], $_POST['editormail']);
        if($rau){
            $str_info = 'Añadido correctamente';
        }else{
            $str_error = 'No se ha podido añadir';
        }
    }else{
        $rau = $uM->updatemail($arr_filtro_ps, $arr_lang_ps, $_POST['asuntomail'], $_POST['editormail']);
        if($rau){
            $str_info = 'Actualizado correctamente';
        }else{
            $str_error = 'No se ha podido actualizar';
        }
    }
}
//POST__________________________________________________________________________

//LISTADO_______________________________________________________________________
$rgm = $uM->getmail($arr_filtro_ps, $arr_lang_ps);
if($rgm){
    while($frgm = $rgm->fetch_assoc()){
        $editormail .= $frgm['cuerpo'];
        $asuntomail .= $frgm['asunto'];
    }
}

$mailCompleto = '<div style="display: block; margin: 0 auto; max-width: 750px;">
<div style="background-color: #00ABC8;">
    <img src="'.$ruta_inicio.'img/svg/ysanablanco.svg" height="88px" style="display: block; margin: 0 auto; padding-top: 12px; padding-bottom: 12px;">
</div>
<div style="background-color: #FFF; padding-top: 8px; padding-bottom: 8px;">';
$mailCompleto .= $editormail;
switch($arr_filtro_ps){
    case 0:
        $mailCompleto .= '<a href="#" target="_blank" style="color: #17a2b8; background-color: transparent; border: 1px solid #17a2b8; text-align: center; padding: .375rem .75rem; border-radius: .25rem; cursor: pointer;">Cambiar contraseña</a>';
    break;
}
$mailCompleto .= '</div>
<div style="padding-top: 8px; padding-bottom: 8px; background-color: #F1F1F1;">
    <div style="margin-left: auto;display: table;">
        <a href="https://www.facebook.com/YSanaVidaSana/"><img src="https://img.icons8.com/material-rounded/24/000000/facebook.png"
                width="32px"></a>
        <a href="https://twitter.com/Ysana_Vida_Sana"><img src="https://img.icons8.com/material-rounded/24/000000/twitter.png"
                width="32px"></a>
        <a href="https://www.instagram.com/ysanavidasana/"><img src="https://img.icons8.com/material-rounded/24/000000/instagram-new.png"
                width="32px"></a>
    </div>
</div>
</div>';
//LISTADO________________________________________________________________________

//POST-POST______________________________________________________________________
if(isset($_POST['enviarEmailPrueba'])){
    $rmp = $uM->mail_prueba($_POST['email'], $mailCompleto);
    if($rmp){
        echo 'Bien';
    }else{
        echo 'Mal';
    }
}
//POST-POST______________________________________________________________________

include_once('inc/cabecera.inc.php'); //cargando cabecera 

echo '<script type="text/javascript">
$(document).ready(function(){
    $("#editormail").summernote({
        height: 300,
        minHeight: null,
        maxHeight: null
    });
    $("#editormail").summernote(\'code\', `'.$editormail.'`);
    $(".select-tag").on(\'click\', function(){
        var textTemp = $(this).attr("valor");
        $(".note-editable.card-block").html(function(i, origText){
            return origText + textTemp;
        });
    });
});
</script>';
?>

<body>
<?php include_once('inc/franja_top.inc.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <h4>Vista previa: </h4>
                <form action="" method="post" class="d-flex mt-3">
                    <input type="email" name="email" class="form-control" placeholder="info@ejemplo.com">
                    <button type="submit" name="enviarEmailPrueba" class="btn btn-outline-info ml-3">Enviar mail de prueba</button>
                </form>
                <?php echo $mailCompleto; ?>
                
            </div>
            <div class="col-md-12">
                <div class="content mt-1">
                    <div class="layout">
                        <div class="layout-table">
                            <div id="alertas">
                                <?php if (isset($str_info)) echo $hM->get_alert_success($str_info); ?>
                                <?php if (isset($str_error)) echo $hM->get_alert_danger($str_error); ?>
                            </div>
                            <div class="layout-table-item">
                                <div class="layout-table-header">
                                    <h4 class="mb-0 mt-4">Mails</h4>
                                </div>
                                <div class="my-3">
                                    <div class="dropdown">
                                        <form method="post" style="display:flex;">
                                            <?php echo $uM->get_combo_array($arr_filtro,"arr_filtro",$arr_filtro_ps,"btn_aceptar bg_salmon tipogr_blanca",true) ?>
                                            <?php echo $uM->get_combo_array($arr_lang,"arr_lang",$arr_lang_ps,"btn_aceptar bg_salmon tipogr_blanca",true) ?>
                                        </form>
                                    </div>
                                </div>
                                <div class="layout-table-content">
                                    <div class="table-responsive-sm">
                                        <form method="post">
                                            <?php echo $iM->get_input_text("asuntomail", $asuntomail, 'form-control mb-0', 'Asunto'); ?>
                                            <?php echo $iM->get_input_hidden("arr_filtro", $arr_filtro_ps); ?>
                                            <?php echo $iM->get_input_hidden("arr_lang", $arr_lang_ps); ?>
                                            <p class="mb-2">Contenido</p>
                                            <div class="row">
                                                <div class="col-10">
                                                    <textarea id="editormail" name="editormail"></textarea>
                                                </div>
                                                <div class="col-2">
                                                    <h1 class="lead text-center">Tags</h1>
                                                    <nav class="nav nav-pills flex-column flex-sm-row">
                                                        <a class="flex-sm-fill text-sm-center nav-link select-tag btn btn-outline-info"
                                                            href="#" valor="[nombre_usuario]">Nombre usuario</a>
                                                    </nav>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mt-2">
                                                <button type="submit" class="btn btn-block btn-lg btn-info">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>