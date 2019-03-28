<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');
$cM = load_model('carrito');
$hM = load_model('html');
$sM = load_model('seo');

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
if(isset($_POST['transporte'])){
    $_SESSION['transporte']=$_POST['transporte'];
}
$gasto_envio = isset($_SESSION['transporte']) ? $_SESSION['transporte'] : '';
$precioEnvio = 0;
$carrito_compra = array('123','1234');
$orgcc = '';
$qttCarrito = 1;
$sumaTotalexp = 0;
$ivatotal = 0;
//datos
$id_carrito=0;
$predeterminada = false;
$nombre = '';
$apellidos = '';
$direccion = '';
$cp = '';
$poblacion = '';
$movil = '';
$str_error = '';
$str_success = '';
$old = '';
$oldad = '';
$cont_direcciones = 0;
$oca = '';
$otransporte = '';
$aux_id_factura = '';
$cargar=false;
//datos

//GET__________________________________________________________________________
if(isset($_GET['opc'])){
    switch($_GET['opc']){
        case "del":
            $rdd = $cM->delete_direccion($id_usuario, $_GET['direccion']);
            if($rdd){
                $str_success = $lng['forms'][22];
            }else{
                $str_error = $lng['forms'][23];
            }
            break;
        case "update":
            $rrdc = $cM->reset_predeterminada_carrito($id_usuario);
            if($rrdc){
                $cM->update_predeterminada_carrito($id_usuario, $_GET['carrito']);
            }else{
                $str_error = $lng['forms'][24];
            }
            break;
    }
}
//GET__________________________________________________________________________

//POST__________________________________________________________________________
if(isset($_POST['id_carrito'])){
    switch($_POST['id_carrito']){
        case 0:
            $rade = $cM->add_direccion_envio($id_usuario, $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['direccion_usuario'], $_POST['cp_usuario'], $_POST['poblacion_usuario'], $_POST['movil_usuario']);
            if($rade){
                //header("Refresh:0");
                $str_success = $lng['forms'][25];
            }else{
                $str_error = $lng['forms'][26];
            }
            break;
        default:
            $rude = $cM->update_direccion_envio($id_usuario, $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['direccion_usuario'], $_POST['cp_usuario'], $_POST['poblacion_usuario'], $_POST['movil_usuario'], $_POST['id_carrito']);
            if($rude){
                $str_success = $lng['forms'][27];
            }else{
                $str_error = $lng['forms'][20];
            }
            break;
    }
}

//POST__________________________________________________________________________

//LISTADO______________________________________________________________________
if($id_usuario>0){
    $rgd = $cM->get_direcciones($id_usuario, 1);
    if($rgd){
        while($frgd = $rgd->fetch_assoc()){
            $old .= '<div class="direccion-envio green-bg my-2 p-3">';
            $old .= '<p class="my-0">'.$frgd['nombre'].' '.$frgd['apellidos'].'</p>';
            $old .= '<p class="my-0">'.$frgd['direccion'].'</p>';
            //$old .= '<p class="my-0">'.$frgd['codigo_postal'].'</p>';
            $old .= '<p class="my-0">'.$frgd['poblacion'].', '.$frgd['codigo_postal'].'</p>';
            $old .= '<p class="my-0">'.$frgd['movil'].'</p>';
            $old .= '<hr><div class="d-flex justify-content-end text-right">';
            $old .= '<p class="mb-1 mx-2" data-toggle="modal" data-target="#modalDireccion'.$cont_direcciones.'">'.$lng['forms'][28].'</p><a href="?opc=del&direccion='.$frgd['id_carrito'].'"><p class="mb-1 mx-2">'.$lng['forms'][29].'</p></a>';
            $old .= '</div></div>';
            $old .= '<div class="modal fade" id="modalDireccion'.$cont_direcciones.'" tabindex="-1" role="dialog" aria-labelledby="modalDireccion'.$cont_direcciones.'Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header info-datos">
            <h5 class="modal-title" id="modalDireccion'.$cont_direcciones.'Label">'.$lng['forms'][30].'</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>
            <form action="" method="post"><div class="modal-body">';
            $old .= $iM->get_input_hidden('id_carrito', $frgd['id_carrito']);
            $old .= $iM->get_input_text('nombre_usuario', $frgd['nombre'], 'form-control', '', $lng['forms'][4]);
            $old .= $iM->get_input_text('apellidos_usuario', $frgd['apellidos'], 'form-control', '', $lng['forms'][5]);
            $old .= $iM->get_input_text('direccion_usuario', $frgd['direccion'], 'form-control', '', $lng['forms'][31]);
            $old .= $iM->get_input_text('cp_usuario', $frgd['codigo_postal'], 'form-control', '', $lng['forms'][32]);
            $old .= $iM->get_input_text('poblacion_usuario', $frgd['poblacion'], 'form-control', '', $lng['forms'][33]);
            $old .= $iM->get_input_text('movil_usuario', $frgd['movil'], 'form-control', '', $lng['forms'][34]);
            $old .= '</div><div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">'.$lng['forms'][36].'</button>
            <button type="submit" class="btn btn-primary">'.$lng['forms'][35].'</button>
            </div></form></div></div></div>';
            $nombre = $frgd['nombre'];
            $apellidos = $frgd['apellidos'];
            $direccion = $frgd['direccion'];
            $poblacion = $frgd['poblacion'];
            $cp = $frgd['codigo_postal'];
            $movil = $frgd['movil'];
                $cont_direcciones++;
        }
    }
    $rgt = $cM->get_transporte();
    if($rgt){
        $otransporte .= '<form id="frmenvio" method="post" class="m-0">';
        while($frgt = $rgt->fetch_assoc()){
            $otransporte .= '<div class="input-group my-1">
            <div class="input-group-prepend">
              <div class="input-group-text">
              <input ';
              if($gasto_envio==$frgt['id_transporte']){
                  $otransporte .= 'checked';
                  $precioEnvio = $frgt['precio'];
              }
            $otransporte .= ' type="radio" name="transporte" value="'.$frgt['id_transporte'].'">
              </div>
            </div>
            <p class="form-control">'.$frgt['nombre'].'</p>
          </div>';
        }
        $otransporte .= '</form>';
    }
    $rgd2 = $cM->get_direcciones($id_usuario, 0);
    if($rgd2){
        while($frgd2 = $rgd2->fetch_assoc()){
            $oldad .= '<div class="my-2 p-3">';
            $oldad .= '<p class="my-0">'.$frgd2['nombre'].' '.$frgd2['apellidos'].'</p>';
            $oldad .= '<p class="my-0">'.$frgd2['direccion'].'</p>';
            $oldad .= '<p class="my-0">'.$frgd2['poblacion'].', '.$frgd2['codigo_postal'].'</p>';
            $oldad .= '<p class="my-0">'.$frgd2['movil'].'</p>';
            $oldad .= '<a href="?opc=update&carrito='.$frgd2['id_carrito'].'"><button type="button" class="btn mt-2 br-n-c">'.$lng['forms'][37].'</button></a>
            </div><hr>';
        }
    }
    $rgcc = $cM->get_carrito($id_usuario,$_SESSION['lang']);
    if($rgcc){
        while($frgcc = $rgcc->fetch_assoc()){
            if($frgcc['tipo_tienda']=="exp"){
                $oca .= '<div class="articulos-enviar-item">
                <img src="'.$ruta_inicio.'img/productos/';
                if($frgcc["img_portada"]!=""){
                    $oca .= $frgcc["img_portada"];
                }else{
                    $oca .= $frgcc["img"];
                }
                $oca .= '" alt="">
                <div class="articulos-enviar-texto-info">
                    '.$frgcc['nombre'].'
                        <div class="stock">
                            '.$lng['experiencia-carrito'][11].': '.$frgcc['cantidad'].'
                            <br>
                            '.$lng['experiencia-carrito'][15].': ';
                if($frgcc['stock']>=$frgcc['cantidad']){
                    $oca .= '<span class="positive-emp">'.$lng['productos_ysana'][10].'</span>';
                }else{
                    $oca .= '<span class="negative-emp">'.$lng['productos_ysana'][11].'</span>';
                }
                $oca .= '</div>
                </div>
                </div>';
                $sumaTotalexp+=($frgcc["precio"]*$frgcc["cantidad"]);
                $ivatotal+=round($sumaTotalexp*$frgcc["iva"],2);
            }
        }
    }
}
if(isset($_POST['btnPedido']) && $sumaTotalexp>0){
    $rap = $cM->add_pedido($id_usuario, $nombre, $apellidos, $direccion, $cp, $poblacion, $movil);
    if($rap){
        $aux_id_factura = $cM->get_insert_id();
        $aux_id_factura = $rootM->zerofill($aux_id_factura, 8);
    }

    include_once('lib/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php');

    $apiRedsys = new RedsysAPI;

    $Ds_Merchant_MerchantCode = DS_MERCHANT_CODE;
    $Ds_Merchant_Terminal = DS_MERCHANT_TERMINAL;
    $Ds_Merchant_TransactionType = DS_AUTORIZACION;
    $Ds_Merchant_Amount = $cM->get_gateway_format($sumaTotalexp+$precioEnvio);
    $DS_Merchant_Currency = DS_EURO;
    $Ds_Merchant_Order = $aux_id_factura; //$aux_id_factura;
    $Ds_Merchant_MerchantURL = DS_MERCHANT_URL;
    $Ds_Merchant_MerchantURLOK = DS_MERCHANT_URL.'?factura='.$aux_id_factura.'&result=ok';
    $Ds_Merchant_MerchantURLKO = DS_MERCHANT_URL.'?factura='.$aux_id_factura.'&result=ko';
    $Ds_Merchant_MerchantName = DS_MERCHANT_NAME;

    $apiRedsys->setParameter('DS_MERCHANT_AMOUNT', $Ds_Merchant_Amount);
    $apiRedsys->setParameter('DS_MERCHANT_ORDER', strval($Ds_Merchant_Order));
    $apiRedsys->setParameter('DS_MERCHANT_MERCHANTCODE', $Ds_Merchant_MerchantCode);
    $apiRedsys->setParameter('DS_MERCHANT_CURRENCY', $DS_Merchant_Currency);
    $apiRedsys->setParameter('DS_MERCHANT_TRANSACTIONTYPE', $Ds_Merchant_TransactionType);
    $apiRedsys->setParameter('DS_MERCHANT_TERMINAL', $Ds_Merchant_Terminal);
    $apiRedsys->setParameter('DS_MERCHANT_MERCHANTURL', $Ds_Merchant_MerchantURL);
    $apiRedsys->setParameter('DS_MERCHANT_URLOK', $Ds_Merchant_MerchantURLOK);
    $apiRedsys->setParameter('DS_MERCHANT_URLKO', $Ds_Merchant_MerchantURLKO);
    $apiRedsys->setParameter('DS_MERCHANT_MERCHANTNAME', $Ds_Merchant_MerchantName);

    $Ds_version = DS_VERSION;
    $Ds_KEY = DS_MERCHANT_KEY;

    $Ds_params = $apiRedsys->createMerchantParameters();
    $Ds_signature = $apiRedsys->createMerchantSignature($Ds_KEY);
    //CONFIGURAR DATOS TPV -------------------------------------
    $cargar=true;
}
//LISTADO______________________________________________________________________
//REQUEST______________________________________________________________________

//REQUEST______________________________________________________________________
include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('input[type="radio"]').change(function () {
            $('#frmenvio').submit();
        });
    });
</script>

<body>
    <?php //include_once('inc/franja_top.inc.php'); ?>
    <?php //include_once('inc/main_menu.inc.php'); ?>
    <?php //include_once('inc/panel_top_experiencia.inc.php'); ?>
    <?php //include_once('inc/navbar_inicio_experiencia.inc.php'); ?>
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio_experiencia.inc.php'); ?>
    <div class="bg-carrito">
        <div class="container carrito-datos">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 my-4">
                    <div id="mensajeenvio" class="d-none">
                        <div class="mb-3">
                            <?php echo $hM->get_alert_danger($lng['experiencia-carrito'][20]); ?>
                        </div>
                    </div>
                    <?php
                        if($str_error){
                            echo $hM->get_alert_danger($str_error);
                        ?>
                    <div class="mb-3"></div>
                    <?php }else if($str_success){
                            echo $hM->get_alert_success($str_success);
                        ?>
                    <div class="mb-3"></div>
                    <?php } ?>
                    <div class="info-datos">
                        <div class="info-resumen">
                            <div class="d-flex justify-content-between">
                                <h5><?php echo $lng['forms'][38]; ?></h5>
                                <a data-toggle="modal" data-target="#modalDireccionSeleccionar"><?php echo $lng['forms'][39]; ?></a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modalDireccionSeleccionar" tabindex="-1" role="dialog"
                                aria-labelledby="modalDireccionSeleccionarLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header info-datos">
                                            <h5 class="modal-title" id="modalDireccionSeleccionarLabel"><?php echo $lng['forms'][30]; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <?php echo $oldad; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lng['forms'][36]; ?></button>
                                                <button type="submit" class="btn btn-primary"><?php echo $lng['forms'][35]; ?></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <?php echo $old; ?>
                            </div>
                            <div class="botones mt-3">
                                <button id="btndireccion" class="btnAdddireccion btn btn-lg" data-toggle="modal"
                                    data-target="#modalDireccion"><?php echo $lng['forms'][40]; ?></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="articulos-enviar">
                        <div class="articulos-enviar-title"><?php echo $lng['forms'][41]; ?></div>
                        <div class="articulos-enviar-list-items">
                            <?php echo $oca; ?>
                            <!-- <div class="articulos-enviar-item">
                                    <img src="//thumb.pccomponentes.com/w-85-85/articles/14/144765/a3.jpg" alt="">
                                    <div class="articulos-enviar-texto-info">
                                            Toshiba OCZ TR200 SSD 240GB SATA3
                                            <div class="stock">
                                                Unidades: 1
                                                <br>
                                                Disponibilidad: En stock
                                            </div>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDireccion" tabindex="-1" role="dialog" aria-labelledby="modalDireccionLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header info-datos">
                                    <h5 class="modal-title" id="modalDireccionLabel"><?php echo $lng['forms'][30]; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="post">
                                    <div class="modal-body">
                                        <?php
                                            echo $iM->get_input_hidden('id_carrito', $id_carrito);
                                            echo $iM->get_input_text('nombre_usuario', $nombre, 'form-control', '', $lng['forms'][4]);
                                            echo $iM->get_input_text('apellidos_usuario', $apellidos, 'form-control', '', $lng['forms'][5]);
                                            echo $iM->get_input_text('direccion_usuario', $direccion, 'form-control', '', $lng['forms'][31]);
                                            echo $iM->get_input_text('cp_usuario', $cp, 'form-control', '', $lng['forms'][32]);
                                            echo $iM->get_input_text('poblacion_usuario', $poblacion, 'form-control', '', $lng['forms'][33]);
                                            echo $iM->get_input_text('movil_usuario', $movil, 'form-control', '', $lng['forms'][34]);
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lng['forms'][36]; ?></button>
                                        <button type="submit" class="btn btn-primary"><?php echo $lng['forms'][35]; ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="info-datos transporte">
                        <div class="info-resumen">
                            <?php echo $otransporte; ?>
                        </div>
                    </div>
                </div>
                <div class="pedido show col-12 col-md-12 col-lg-4 my-4">
                    <div class="info-pago">
                        <div class="ticket-resumen">
                            <div class="ticket-pago">
                                <div class="ticket-pago_desglose">
                                    <div class="ticket-pago_articulos">
                                        <div class="d-flex flex-column">
                                            <strong class="w-100">
                                                <span>IVA</span>
                                                <span data-precio-total class="pull-xs-right">
                                                    <?php echo $ivatotal; ?> €</span>
                                            </strong>
                                            <strong class="w-100">
                                                <span><?php echo $lng['experiencia-carrito'][13]; ?></span>
                                                <span data-precio-total class="pull-xs-right">
                                                    <!--<?php echo $precioEnvio; ?> €-->
                                                    <?php echo $lng['experiencia-carrito'][14]; ?>
                                                </span>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="ticket-pago_total">
                                        <strong class="w-100">
                                            <?php echo $lng['experiencia-carrito'][7]; ?>
                                            <span data-precio-total class="pull-xs-right">
                                                <?php echo ($sumaTotalexp+$precioEnvio); ?> €</span>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="">
                            <button id="btnPagar" type="submit" name="btnPedido" <?php //echo (!$precioEnvio) ? 'disabled' : '' ; ?> class="btn bg-blue-ysana btn-lg btn-block mt-2 text-light">
                                <?php echo $lng['experiencia-carrito'][9]; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login_form d-none">
        <form action="<?php echo URL_PASARELA; ?>" method="post" id="form_gateway" name="form_gateway">
            <input type="hidden" name="Ds_SignatureVersion" value="<?php echo $Ds_version; ?>" />
            <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $Ds_params; ?>" />
            <input type="hidden" name="Ds_Signature" value="<?php echo $Ds_signature; ?>" />
            <input type="submit" class="btn_aceptar" style="padding:4px 22px;max-width:200px;margin-left:auto;margin-right:auto;" value="Aceptar" />
        </form>
    </div>
    
    <?php
        if($cargar){
            echo '<script>
            $(document).ready(function () {
                $("#form_gateway").submit();
            });
        </script>';
        }
    ?>
    <script>
        $("#btnPagar").on('click', function(e){
            if($('.direccion-envio').length==0){
                e.preventDefault();
                $("#mensajeenvio").addClass("d-block");
            }else{
                $("#mensajeenvio").addClass("d-none");
            }
        });
    </script>
    <?php include_once('inc/footer.inc.php'); ?>
</body>

</html>