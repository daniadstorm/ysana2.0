<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');
$cM = load_model('carrito');
$hM = load_model('html');
$sM = load_model('seo');

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
$carrito_compra = array('123','1234');
$qttCarrito = 1;
$sumaTotal = 0;
$valid=true;
$iva = 0.21;
$str_success = '';
$str_error = '';
if(isset($_REQUEST['compra'])){
    if($_REQUEST['compra']=='ok'){
        $str_success = 'Compra realizada con éxito';
    }else if($_REQUEST['compra']=='ko'){
        $str_error = 'Error al realizar el pago';
    }
}
/* exp */
$outcarritoexp = '';
$sumaTotalexp = 0;
$qttCarritoexp = 0;
/* exp */
/* df */
$outcarritodf = '';
$sumaTotaldf = 0;
$qttCarritodf = 0;
/* df */
$unidades = 0;
$buscarfarmacia = '';
$selectfarmacia = '';
$fechadia = '';
$arrselectfarmacia = array();
$ivatotalexp = 0;
$ivatotaldf = 0;
$timecesta = "mañana";
$arrtimecesta = array(
    'mañana' => $lng['experiencia-carrito'][22],
    'tarde' => $lng['experiencia-carrito'][28]
);
/* new */
$hoy = date("Y").'-'.date("m").'-'.(date("d")+1);
$strCarritonewexp = '';
$strCarritonewDf = '';
$arrProdExp = array();
$arrProdDf = array();
$ttlExp = 0;
$ttlDf = 0;
$old = '';
$oldad = '';
$cont_direcciones = 0;
$oca = '';
$otransporte = '';
$aux_id_factura = '';
$cargar=false;
$gasto_envio = isset($_SESSION['transporte']) ? $_SESSION['transporte'] : '';
$precioEnvio = 0;
$id_carrito = 0;
/* new */
/* echo '<pre>';
print_r($_POST);
echo '</pre>'; */

if (!isset($_SESSION['id_tipo_usuario'])) { //si hay login
    header('Location: '.$ruta_inicio.'login');
}

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
if(isset($_POST['btnPedido']) && isset($_REQUEST['opc'])){
    $valid=false;
}

if(isset($_REQUEST['id_articulo']) && isset($_REQUEST['opc']) && $valid){
    switch($_REQUEST['opc']){
        case "resta":
            $rguau = $cM->get_unidades_articulo_usuario($id_usuario, $_REQUEST['id_articulo']);
            if($rguau){
                while($frguau = $rguau->fetch_assoc()){
                    if($frguau['total']>1){
                        $cM->restarArticulo($id_usuario, $_REQUEST['id_articulo']);
                        //header("Refresh:0");
                    }else{
                        $cM->delete_articulo_usuario_carrito($id_usuario, $_REQUEST['id_articulo']);
                        //header("Refresh:0");
                    }
                }
            }
            break;
        case "suma":
            $cM->sumarArticulo($id_usuario, $_REQUEST['id_articulo']);
            //header("Refresh:0");
            break;
        case "borrar":
            $cM->delete_articulo_usuario_carrito($id_usuario, $_REQUEST['id_articulo']);
            //header("Refresh:0");
            break;
        default:
            break;
    }
}
//GET__________________________________________________________________________
//POST_________________________________________________________________________
if(isset($_POST['id_carrito'])){
    switch($_POST['id_carrito']){
        case 0:
            if($cM->get_direccion_envio_estado($id_usuario, 1)==0){
                $rade = $cM->add_direccion_envio($id_usuario, 1, $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['direccion_usuario'], $_POST['cp_usuario'], $_POST['poblacion_usuario'], $_POST['movil_usuario']);
            }else{
                $rade = $cM->add_direccion_envio($id_usuario, 0, $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['direccion_usuario'], $_POST['cp_usuario'], $_POST['poblacion_usuario'], $_POST['movil_usuario']);
            }
            //$rade = $cM->add_direccion_envio($id_usuario, 1, $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['direccion_usuario'], $_POST['cp_usuario'], $_POST['poblacion_usuario'], $_POST['movil_usuario']);
            if($rade) $str_success = $lng['forms'][25];
            else $str_error = $lng['forms'][26];
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
if(isset($_POST['cestadf'])){
    $rapd = $cM->add_pedido_df($_POST['selectfarmacia'], $_SESSION['id_usuario'], $_POST['timecesta'], date_to_mysql($_POST['fechadia']));
    if($rapd){
        $uM->user_pedido_mail_df($_SESSION['id_usuario'], $_SESSION['id_lang']);
        $cM->update_pedido_df($_SESSION['id_usuario'], "pendiente");
        $str_success = $lng['experiencia-carrito'][26];
    }else{
        $str_error = 'No se ha podido realizar el pedido';
    }
}
//POST_________________________________________________________________________

//LISTADO______________________________________________________________________
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
            $old .= '<p class="mb-1 mx-2 editarDireccion" data-toggle="modal" data-target="#modalDireccion'.$cont_direcciones.'">'.$lng['forms'][28].'</p><a class="delDireccion" href="?opc=del&direccion='.$frgd['id_carrito'].'"><p class="mb-1 mx-2">'.$lng['forms'][29].'</p></a>';
            $old .= '</div></div>';
            $old .= '<div class="modal fade" id="modalDireccion'.$cont_direcciones.'" tabindex="-1" role="dialog" aria-labelledby="modalDireccion'.$cont_direcciones.'Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
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
            $oldad .= '<a href="?opc=update&carrito='.$frgd2['id_carrito'].'"><button type="button" class="btn mt-2 br-n-c btnAdddireccion">'.$lng['forms'][37].'</button></a>
            </div><hr>';
        }
    }
if($id_usuario>0){
    $rgcc = $cM->get_carrito($id_usuario, $_SESSION['lang']);
    if($rgcc){
        while($frgcc = $rgcc->fetch_assoc()){
            if($frgcc['tipo_tienda']=="exp"){
                array_push($arrProdExp, $frgcc);
            }else if($frgcc['tipo_tienda']=="df"){
                array_push($arrProdDf, $frgcc);
            }
        }
    }
}
if(count($arrProdExp)>0){
    foreach ($arrProdExp as $key => $value) {
        /* print_r($value); */
        $strCarritonewexp .= '<tr>';
        $strCarritonewexp .= '<td class="img"><img src="'.$ruta_inicio.'img/productos/'.$value['img'].'" width="128px" class="img-thumbnail"></td>';
        $strCarritonewexp .= '<td><a target="_blank" href="'.$ruta_inicio.'producto/'.$value['urlseo'].'">'.$value['nombre'].'</a></td>';
        $strCarritonewexp .= '<td>'.$value['precio'].'€</td>';
        $strCarritonewexp .= '<td><div class="input-group"><form method="post" class="d-inline-block">';
        $strCarritonewexp .= $iM->get_input_hidden('id_articulo', $value['id_articulo']);
        $strCarritonewexp .= $iM->get_input_hidden('opc', 'resta');
        $strCarritonewexp .= '<button type="submit" class="btn">-</button></form>';
        $strCarritonewexp .= '<span class="input-group-text">'.$value['cantidad'].'</span>';
        $strCarritonewexp .= '<form method="post" class="d-inline-block">';
        $strCarritonewexp .= $iM->get_input_hidden('id_articulo', $value['id_articulo']);
        $strCarritonewexp .= $iM->get_input_hidden('opc', 'suma');
        $strCarritonewexp .= '<button type="submit" class="btn">+</button></form>';
        $strCarritonewexp .= '</div></td>';
        //$strCarritonewexp .= '<td>'.$value['cantidad'].'</td>';
        $strCarritonewexp .= '<td>'.($value['precio']*$value['cantidad']).'€</td>';
        $strCarritonewexp .= '<td><a href="?id_articulo='.$value["id_articulo"].'&opc=borrar" class="cerrar"><img width="16px" src="'.$ruta_inicio.'img/borrarProducto.png" alt=""></a></td>';
        $strCarritonewexp .= '</tr>';
        $ttlExp += ($value['precio']*$value['cantidad']);
        $sumaTotalexp += ($value['precio']*$value['cantidad']);
    }
}
if(count($arrProdDf)>0){
    foreach ($arrProdDf as $key => $value) {
        $strCarritonewDf .= '<tr>';
        $strCarritonewDf .= '<td class="img"><img src="'.$ruta_inicio.'img/productos/'.$value['img'].'" width="128px" class="img-thumbnail"></td>';
        $strCarritonewDf .= '<td><a target="_blank" href="'.$ruta_inicio.'producto/'.$value['urlseo'].'">'.$value['nombre'].'</a></td>';
        $strCarritonewDf .= '<td>'.$value['precio'].'€</td>';
        $strCarritonewDf .= '<td><div class="input-group"><form method="post" class="d-inline-block">';
        $strCarritonewDf .= $iM->get_input_hidden('id_articulo', $value['id_articulo']);
        $strCarritonewDf .= $iM->get_input_hidden('opc', 'resta');
        $strCarritonewDf .= '<button type="submit" class="btn">-</button></form>';
        $strCarritonewDf .= '<span class="input-group-text">'.$value['cantidad'].'</span>';
        $strCarritonewDf .= '<form method="post" class="d-inline-block">';
        $strCarritonewDf .= $iM->get_input_hidden('id_articulo', $value['id_articulo']);
        $strCarritonewDf .= $iM->get_input_hidden('opc', 'suma');
        $strCarritonewDf .= '<button type="submit" class="btn">+</button></form>';
        $strCarritonewDf .= '</div></td>';
        //$strCarritonewDf .= '<td>'.$value['cantidad'].'</td>';
        $strCarritonewDf .= '<td>'.($value['precio']*$value['cantidad']).'€</td>';
        $strCarritonewDf .= '<td><a href="?id_articulo='.$value["id_articulo"].'&opc=borrar" class="cerrar"><img width="16px" src="'.$ruta_inicio.'img/borrarProducto.png" alt=""></a></td>';
        $strCarritonewDf .= '</tr>';
        $ttlDf += ($value['precio']*$value['cantidad']);
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
    $Ds_Merchant_Amount = $cM->get_gateway_format($sumaTotalexp);
    //$Ds_Merchant_Amount = 0;
    $DS_Merchant_Currency = DS_EURO;
    $Ds_Merchant_Order = $aux_id_factura; //$aux_id_factura;
    //$Ds_Merchant_Order = '00030888'; //$aux_id_factura;
    $Ds_Merchant_MerchantURL = DS_MERCHANT_URL;
    $Ds_Merchant_MerchantURLOK = DS_MERCHANT_URL.'?factura='.$aux_id_factura.'&result=ok';
    $Ds_Merchant_MerchantURLKO = DS_MERCHANT_URL.'?factura='.$aux_id_factura.'&result=ko';
    //$Ds_Merchant_MerchantURLOK = DS_MERCHANT_URL.'?factura=00000888&result=ok';
    //$Ds_Merchant_MerchantURLKO = DS_MERCHANT_URL.'?factura=00000888&result=ko';
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
    //header('Location: '.$ruta_inicio.'enviarDatosPasarela.php?Ds_version='.$Ds_version.'&Ds_params='.$Ds_params.'&Ds_signature='.$Ds_signature);
    //exit();
}
//LISTADO______________________________________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]);
?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); ?>
        <?php include_once('inc/menu.inc.php'); ?>
    </div>
    <div class="max-ysana marg-ysana">
        <div id="carrito">
            <div class="contenedor">
                <?php if($str_success) echo $hM->get_alert_success($str_success); ?>
                <div class="ttl">
                    <h1>Tu cesta de experiencias</h1>
                </div>
                <div class="table-responsive-lg">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Artículo</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Unidades</th>
                                <th scope="col">Total</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="body-carrito">
                            <?php echo $strCarritonewexp; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="contenedor">
                <div class="info-datos">
                    <div class="info-resumen">
                        <div class="d-flex justify-content-between">
                            <h5 class="ttl_direccion">
                                Dirección de entrega
                            </h5>
                            <a class="otraDireccion" data-toggle="modal" data-target="#modalDireccionSeleccionar">
                                Seleccionar otra dirección
                            </a>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalDireccionSeleccionar" tabindex="-1" role="dialog" aria-labelledby="modalDireccionSeleccionarLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header info-datos">
                                        <h5 class="modal-title" id="modalDireccionSeleccionarLabel">
                                            <?php echo $lng['forms'][30]; ?>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <?php echo $oldad; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btnAdddireccion" data-dismiss="modal">
                                                <?php echo $lng['forms'][36]; ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php echo $old; ?>
                        </div>
                        <div class="botones mt-3">
                            <button id="btndireccion" class="btnAdddireccion btn btn-lg" data-toggle="modal" data-target="#modalDireccion">+ Añadir direccion de envio</button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalDireccion" tabindex="-1" role="dialog" aria-labelledby="modalDireccionLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
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
                                                echo $iM->get_input_text('nombre_usuario', '', 'form-control', '', $lng['forms'][4]);
                                                echo $iM->get_input_text('apellidos_usuario', '', 'form-control', '', $lng['forms'][5]);
                                                echo $iM->get_input_text('direccion_usuario', '', 'form-control', '', $lng['forms'][31]);
                                                echo $iM->get_input_text('cp_usuario', '', 'form-control', '', $lng['forms'][32]);
                                                echo $iM->get_input_text('poblacion_usuario', '', 'form-control', '', $lng['forms'][33]);
                                                echo $iM->get_input_text('movil_usuario', '', 'form-control', '', $lng['forms'][34]);
                                                /* echo $iM->get_input_hidden('id_carrito', $id_carrito);
                                                echo $iM->get_input_text('nombre_usuario', $nombre, 'form-control', '', $lng['forms'][4]);
                                                echo $iM->get_input_text('apellidos_usuario', $apellidos, 'form-control', '', $lng['forms'][5]);
                                                echo $iM->get_input_text('direccion_usuario', $direccion, 'form-control', '', $lng['forms'][31]);
                                                echo $iM->get_input_text('cp_usuario', $cp, 'form-control', '', $lng['forms'][32]);
                                                echo $iM->get_input_text('poblacion_usuario', $poblacion, 'form-control', '', $lng['forms'][33]);
                                                echo $iM->get_input_text('movil_usuario', $movil, 'form-control', '', $lng['forms'][34]); */
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lng['forms'][36]; ?></button>
                                            <button type="submit" class="btn btnAdddireccion"><?php echo $lng['forms'][35]; ?></button>
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
    
    <div id="carrito2" class="max-ysana w-100">
        <div class="contenedor">
            <div class="row carrito-cart">
                <div class="col-md-12 col-lg-7">
                    <div class="contenedor-farmacia">
                        <div class="ttl">
                            <h1>Reserva en tu farmacia:</h1>
                        </div>
                        <div class="table-responsive-xl">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Artículo</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Unidades</th>
                                        <th scope="col">Total</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="body-carrito">
                                    <?php echo $strCarritonewDf; ?>
                                </tbody>
                            </table>
                        </div>
                        <form action="" class="mb-0" method="post">
                            <div class="row">
                                <div class="col-12 col-lg-7 mb-2">
                                    <?php echo $iM->get_input_text('buscarfarmacia', $buscarfarmacia, 'form-control', '', $lng['experiencia-carrito'][18], '', '', '', true); ?>
                                    <?php echo $iM->get_select('selectfarmacia', $selectfarmacia, $arrselectfarmacia, 'form-control', false, false, false, 'form-group mb-0'); ?>
                                </div>
                                <div class="col-12 col-lg-5 mb-2 d-flex">
                                    <button type="button" name="btnPedidodf" <?php echo ($ttlDf==0 ? 'disabled' : ''); ?>  class="btn btn-block btn-bg-color-2 mt-auto" data-toggle="modal" data-target="#realizarPedido">Reservar</button>
                                </div>
                                <!-- MODAL -->
                                <div class="modal fade" id="realizarPedido" tabindex="-1" role="dialog" aria-labelledby="realizarPedidoLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="realizarPedidoLabel">¿Cuándo te gustaría recoger tu orden?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <div>
                                                        <label><?php echo $lng['experiencia-carrito'][21]; ?></label>
                                                    </div>
                                                    <?php echo $iM->get_select('timecesta', $timecesta, $arrtimecesta, 'form-control'); ?>
                                                </div>
                                                <?php echo $iM->get_input_date('fechadia', $fechadia, 'form-control', $lng['experiencia-carrito'][23] , '', '', $hoy, '', false) ?>
                                                <p class="font-italic"><?php echo $lng['experiencia-carrito'][25]; ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lng['experiencia-carrito'][27]; ?></button>
                                                <button type="submit" name="cestadf" class="btn bg-blue-ysana text-light"><?php echo $lng['experiencia-carrito'][24]; ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- MODAL -->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div class="total-carrito">
                        <div class="ttl">
                            <h1>Total mi cesta experiencia</h1>
                        </div>
                        <div id="totalexp">
                            <strong class="d-flex-jcb">
                                <span>Base imp.</span>
                                <span>0€</span>
                            </strong>
                            <strong class="d-flex-jcb">
                                <span>IVA</span>
                                <span>0€</span>
                            </strong>
                            <strong class="d-flex-jcb">
                                <span>Gastos de envío</span>
                                <span>0€</span>
                            </strong>
                            <strong class="d-flex-jcb">
                                <span>TOTAL</span>
                                <span><?php echo $ttlExp; ?>€</span>
                            </strong>
                        </div>
                        <form action="" method="post">
                            <div class="row mx-0 mt-2">
                                <?php echo $iM->get_input_text('totalprecio', $ttlExp, 'form-control', 'TOTAL', $ttlExp, '', false, false, false, 'form-group col-12 col-sm-6 mb-0 qmb', true); ?>
                                <div class="form-group col-12 col-sm-6 mb-0 qmb">
                                    <label></label>
                                    <button type="submit" name="btnPedido" class="btn btn-block btn-bg-color-2">Realizar pedido</button>
                                </div>
                                <!-- MODAL -->
                                <!-- <div class="modal fade" id="realizarPedidoexp" tabindex="-1" role="dialog" aria-labelledby="realizarPedidoexpLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="realizarPedidoexpLabel">¿Cuándo te gustaría recoger tu orden?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div>
                                                            <label><?php echo $lng['experiencia-carrito'][21]; ?></label>
                                                        </div>
                                                        <?php echo $iM->get_select('timecesta', $timecesta, $arrtimecesta, 'form-control'); ?>
                                                    </div>
                                                    <?php echo $iM->get_input_date('fechadia', $fechadia, 'form-control', $lng['experiencia-carrito'][23] , '', '', $hoy, '', false) ?>
                                                    <p class="font-italic"><?php echo $lng['experiencia-carrito'][25]; ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lng['experiencia-carrito'][27]; ?></button>
                                                    <button type="submit" name="cestadf" class="btn bg-blue-ysana text-light"><?php echo $lng['experiencia-carrito'][24]; ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                <!-- MODAL -->
                            </div>
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
    <?php include_once('inc/footer.inc.php'); ?>
<script>
    function MaysPrimera(string){
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    function buscarFarmacia(){
        consulta = $("#buscarfarmacia").val();
            $.ajax({
                //url: "http://192.168.1.2/ysana/buscar-farmacia.php",
                url: "https://adstorm.es/ysana/buscar-farmacia.php",
                method: "POST",
                data: { valorBusqueda: consulta },
                dataType: "json",
                beforeSend: function(){
                    $("#selectfarmacia").html('<div class="sublistafarmacia"><img style="width:64px;" src="https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif"></div>');
                }
            })
            .done(function(data, textStatus, jqXHR){
                strData = '';
                data.forEach(function(element){
                    strData += '<option value="'+element.id_farmacia+'">'+MaysPrimera(element.nombrecompleto_farmacia.toLowerCase())+'</option>';
                });
                $("#selectfarmacia").html(strData);
            })
            .fail(function(){});
    }
    consulta = '';
    $(document).ready(function(){
        buscarFarmacia();
        $("#buscarfarmacia").keyup(function(e){
            buscarFarmacia();
        });
    });
</script>
</body>
</html>