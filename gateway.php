<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion
if (isset($_SESSION['username']) && isset($_SESSION['usertype']) && $_SESSION['usertype'] <= USER) { //seguridad;

//CARGA DE MODELOS______________________________________________________________
$cM = load_model('carrito');
$dM = load_model('direcciones');
$pM = load_model('pedidos');
$sM = load_model('seo');
//CARGA DE MODELOS______________________________________________________________

//control de carrito con productos
if($cM->get_total_articulos() < 1) { header('Location: '.$ruta_inicio.'index.php'); exit(); }

//DECLARAR VARIABLES____________________________________________________________
$opda = '';
$oc = '';
//DECLARAR VARIABLES____________________________________________________________

//POST__________________________________________________________________________
//POST__________________________________________________________________________

//CONTROL_______________________________________________________________________
$rgds = $dM->get_direccion_selected($_SESSION['iduser']);
if ($rgds) {
    if ($rgds->num_rows > 0) {
        while ($row = $rgds->fetch_assoc()) {

            $total_articulos = $cM->get_total_articulos();
            $total_precio = $cM->get_total_precio();
            $total_iva_productos = $cM->get_total_iva();
            $total_precio_productos = $total_precio + $total_iva_productos;

            $total_envio = $cM->get_total_envio($total_precio_productos, $row['zona']);
            $total_envio_html = $cM->get_total_envio_html($total_precio_productos, $row['zona']);

            $total_absoluto = $total_precio_productos + $total_envio;

            //control de que no exista ya la factura
            //if (!$cM->is_factura_set()) {

                //guardar pedido como pendiente
                $rap = $pM->add_pedido($_SESSION['iduser'], $row['id_direccion'], $row['zona']);
                if ($rap) {

                    //VARIABLES PREVIAS A CONFIGURAR TPV
                    //$total_absoluto //se obtiene de carrito
                    $aux_id_factura = $rap;
                    //$cM->set_factura($aux_id_factura);
                } else {
                    header('Location: '.$ruta_inicio.'checkout.php?error=Error añadiendo pedido'); exit();
                }
            /*
            } else {
                $aux_id_factura = $cM->get_factura();
            }
            */
        }
        //CONFIGURAR DATOS TPV -------------------------------------
        include_once('lib/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php');

        $apiRedsys = new RedsysAPI;

        $Ds_Merchant_MerchantCode = DS_MERCHANT_CODE;
        $Ds_Merchant_Terminal = DS_MERCHANT_TERMINAL;
        $Ds_Merchant_TransactionType = DS_AUTORIZACION;
        $Ds_Merchant_Amount = $cM->get_gateway_format($total_absoluto);
        $DS_Merchant_Currency = DS_EURO;
        $Ds_Merchant_Order = $aux_id_factura;
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

    } else {
        header('Location: '.$ruta_inicio.'checkout.php?error=Ninguna dirección seleccionada'); exit();
    }
} else {
    header('Location: '.$ruta_inicio.'checkout.php?error=Error cargando dirección'); exit();
}
//CONTROL_______________________________________________________________________

//LISTADO_______________________________________________________________________
//LISTADO_______________________________________________________________________

include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">
    
</script>
<body>
<div id="main_container">
    <div id="public_content">
        <?php include_once('inc/franja_top.inc.php'); ?>
        <div class="menu_container">
            <?php include_once('inc/menu.inc.php'); ?>
        </div>
        
        <div id="seccion_front">
            <div class="delimitador">
                <div style="margin-bottom:30px;margin-top:30px;">
                    <h1 class="form_ttl" style="font-family:'montserratbold';">Redirección a pasarela</h1>
                </div>
                <div class="login_form">
                    <form action="<?php echo URL_PASARELA; ?>" method="post" id="form_gateway" name="form_gateway" >
                        <input type="hidden" name="Ds_SignatureVersion" value="<?php echo $Ds_version; ?>" />
                        <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $Ds_params; ?>" />
                        <input type="hidden" name="Ds_Signature" value="<?php echo $Ds_signature; ?>" />
                        <div class="campo nav_link" style="text-align:center;color:#000;">
                            A continuación se le va a redirigir a la pasarela de pago
                        </div>
                        <div class="campo nav_link" style="text-align:center;color:#000;">
                            Pedido: <?php echo $aux_id_factura; ?>
                        </div>
                        <div class="campo">
                            <input type="submit" class="btn_aceptar" style="padding:4px 22px;max-width:200px;margin-left:auto;margin-right:auto;" value="Aceptar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
    </div>
</div>
<?php include_once('inc/footer.inc.php'); ?>
</body>
</html>
<?php } else { unset($_SESSION['username']);header('Location: '.$ruta_inicio.'checkout.php'); exit(); } ?>