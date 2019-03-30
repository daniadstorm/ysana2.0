<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');
$cyM = load_model('clubysana');
/* $uM->control_sesion($ruta_inicio, USER); */

$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';
$id_lang = (isset($_SESSION['id_lang'])) ? $_SESSION['id_lang'] : '';
$nombre_usuario = '';
$apellidos_usuario = '';
$email_usuario = '';
$genero = '';
$str_error = '';
$str_info = '';
$outPedidos = '';
$arrPedidos = array();
$pedidoAnterior = '';
$outPedidosArt = '';
$outCategoria = '';

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
            $str_error = 'Error al enviar el mail';
        }
    }else{
        $str_error = $lng['forms'][18];
    }
}
if(isset($_POST['guardarDatos'])){
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
    $rgpu = $uM->get_pedidos_usuario($id_usuario, 1);
    if($rgpu){
        while($frgpu = $rgpu->fetch_assoc()){
            $outPedidos .= '<tr class="sub-pedido">
                <td class="p-row">'.$frgpu['id_pedido'].'</td>
                <td>'.mysql_to_date($frgpu['fecha_compra']).'</td>
                <td><a class="collapsed" data-toggle="collapse" href="#pedidon-'.$frgpu['id_pedido'].'" role="button" aria-expanded="false" aria-controls="pedidon-'.$frgpu['id_pedido'].'"><img class="rtt-img" src="'.$ruta_inicio.'img/list-down.png"></a></td>
            </tr>';
            $outPedidos .= '<tr><td class="cs-4" colspan="4"><div class="collapse" id="pedidon-'.$frgpu['id_pedido'].'">
            <div class="card card-body">
            <table class="table table-responsive-sm table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="p-row">Articulo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Uds.</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>';
            $rgdp = $uM->get_detalles_pedido($frgpu['id_pedido']);
            if($rgdp){
                while($frgdp = $rgdp->fetch_assoc()){
                    /* echo '<pre>';
                    print_r($frgdp);
                    echo '</pre>'; */
                    $outPedidos .= '<tr>
                    <td class="p-row">'.$frgdp['nombre'].'</td>
                    <td>'.$frgdp['precio'].'</td>
                    <td>'.$frgdp['cantidad'].'</td>
                    <td>'.($frgdp['precio']*$frgdp['cantidad']).'</td>
                </tr>';
                }
            }
            $outPedidos .= '</tbody></table></div></div></td></tr>';
        }
    }
    $rge = $cyM->get_experiencias($id_lang);
    if($rge){
        while($frge = $rge->fetch_assoc()){
            /* echo '<pre>';
            print_r($frge);
            echo '</pre>'; */
            $outCategoria .= '<div class="contenedor-categoria row">
            <div class="categoria col-12 col-md-4 col-lg-4">
                <img class="img img-fluid" src="'.$ruta_inicio.'img/clubysana/'.$frge['imagen'].'" alt="">
                <h1 class="txt-cat">'.$frge['titulo'].'</h1>
            </div>
            <div class="subcategorias col-12 col-md-8 col-lg-8">
            <div class="cont-general">';
            $rgdeii = $cyM->get_datos_experiencias_idexp_idlang($frge['id_experiencia'], $id_lang);
            if($rgdeii){
                while($rfgdeii = $rgdeii->fetch_assoc()){
                    /* echo '<pre>';
                    print_r($rfgdeii);
                    echo '</pre>'; */
                    $outCategoria .= '<div class="subcat">
                    <div class="redonda"></div>
                    <img src="'.$ruta_inicio.'img/clubysana/'.$rfgdeii['imagen'].'" class="img" alt="">
                    <a href="#" class="txt-subcat">Sueño</a>
                </div>';
                }
            }
            $outCategoria .= '</div>
            </div></div>';
        }
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
                        <div class="errores">
                            <?php
                            if($str_error) echo $hM->get_alert_danger($str_error);
                            else if($str_info) echo $hM->get_alert_success($str_info);
                            ?>
                        </div>
                        <form action="" method="post" class="form-row mb-0 mt-3">
                            <?php
                            echo $iM->get_input_hidden('id_usuario', $id_usuario);
                            echo $iM->get_input_text('nombre_usuario', $nombre_usuario, 'form-control', $lng['forms'][4], '','', '', '', '', 'form-group col-md-6', false);
                            echo $iM->get_input_text('apellidos_usuario', $apellidos_usuario, 'form-control', $lng['forms'][5], '','', '', '', '', 'form-group col-md-6', false);
                            echo $iM->get_input_hidden('email_usuario', $email_usuario);
                            echo $iM->get_input_text('email', $email_usuario, 'form-control', $lng['forms'][14], '','', '', '', '', 'form-group col-md-6', true);
                            echo $iM->get_select('genero', $genero, $arr_genero, 'form-control', 'Genero', false, false, 'form-group col-md-6');
                            ?>
                            <div class="ml-auto btnmisdatos">
                                <button type="submit" class="btn btn-baja" name="dardeBaja">Darme de baja</button>
                                <button type="submit" class="btn btn-guardar" name="guardarDatos"><?php echo $lng['forms'][19]; ?></button>
                            </div>
                        </form>
                    </div>
                    <?php if(!$clubysana){ ?>
                    <div class="pedidos-<?php echo ($clubysana) ? 'cy' : 'y'; ?>-ttl">Mis pedidos</div>
                    <div class="pedidos pedidos-<?php echo ($clubysana) ? 'cy' : 'y'; ?>">
                        <table class="table table-responsive-sm table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="p-row">Número de pedido</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Información adicional</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $outPedidos; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade <?php echo ($opcion=="experiencia") ? 'show active' : ''; ?>" id="experiencia" role="tabpanel" aria-labelledby="experiencia-tab">
                    <div id="tuexp" class="max-ysana">
                        <?php echo $outCategoria; ?>
                        <!-- <div class="contenedor-categoria row">
                            <div class="categoria col-4">
                                <img class="img img-fluid" src="<?php echo $ruta_inicio; ?>img/clubysana/icono_neurologia.svg" alt="">
                                <h1 class="txt-cat">Neurología 360º</h1>
                            </div>
                            <div class="subcategorias col-8">
                                <div class="cont-general">
                                    <div class="subcat">
                                        <div class="redonda"></div>
                                        <img src="<?php echo $ruta_inicio; ?>img/clubysana/icono_sueno.svg" class="img" alt="">
                                        <a href="#" class="txt-subcat">Sueño</a>
                                    </div>
                                    <div class="subcat">
                                        <div class="redonda"></div>
                                        <img src="<?php echo $ruta_inicio; ?>img/clubysana/icono_sueno.svg" class="img" alt="">
                                        <a href="#" class="txt-subcat">Sueño</a>
                                    </div>
                                    <div class="subcat">
                                        <div class="redonda"></div>
                                        <img src="<?php echo $ruta_inicio; ?>img/clubysana/icono_sueno.svg" class="img" alt="">
                                        <a href="#" class="txt-subcat">Sueño</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="contenedor-categoria row">
                            <div class="categoria col-4">
                                <img class="img img-fluid" src="<?php echo $ruta_inicio; ?>img/clubysana/icono_nutricion.svg" alt="">
                                <h1>Nutrición</h1>
                            </div>
                            <div class="subcategorias col-8"></div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../inc/banRedes.inc.php'); ?>
    <?php include_once('../inc/footer.inc.php'); ?>
</body>
</html>