<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$cM = load_model('carrito');



if (isset($_REQUEST['Ds_SignatureVersion'])) { //si hay post pq lo manda la pasarela:
    
    //VERIFICACION POR ALGORITMO SHA256 ----------------------------------------
    include_once('lib/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php');
    $apiRedsys = new RedsysAPI;
    
    $Ds_KEY = DS_MERCHANT_KEY;
    $Ds_version = $_REQUEST['Ds_SignatureVersion'];
    $Ds_params = $_REQUEST['Ds_MerchantParameters'];
    $Ds_signature = $_REQUEST['Ds_Signature'];
    
    $Ds_decodec = $apiRedsys->decodeMerchantParameters($Ds_params);
    
    $Ds_response = $apiRedsys->getParameter('Ds_Response');
    $Ds_Order = $apiRedsys->getParameter('Ds_Order');
    
    //adstormlog($Ds_Order.'    INICIO');
    
    $Ds_CalculatedSignature = $apiRedsys->createMerchantSignatureNotif($Ds_KEY, $Ds_params);
    
    if ($Ds_CalculatedSignature != $Ds_signature) {
        adstormlog($Ds_Order.'    SHA256 SIGNATURE ERROR');
        exit();
    }
    //VERIFICACION POR ALGORITMO SHA256 ----------------------------------------
    
    $Ds_response_error = array(101 => 'Card expired',
        102 => 'Card transitional derogation or suspected fraud',
        104 => 'Operation not allowed for that card or terminal',
        9104 => 'Operation not allowed for that card or terminal',
        116 => 'Available insufficient',
        118 => 'Card not registered',
        129 => 'Security code (CVV2/CVC2) wrong',
        180 => 'Alien card service',
        184 => 'Error authentication holder',
        190 => 'Unspecified Denial Reason',
        191 => 'Wrong expiration date',
        202 => 'Card transitional derogation or suspected fraud with card removal',
        912 => 'Issuer not available',
        9912 => 'Issuer not available');
    
    //adstormlog($Ds_Order.'    '.$Ds_response);
    
    if ($Ds_response < 100) { //0000 a 0099 Transacción autorizada para pagos y preautorizaciones
        
        //$rsepbf = $uM->set_estado_pedido_by_factura($Ds_Order, 1); //PENDIENTE ARCHIVAR
        $rsepbf = $uM->set_estado_pedido_by_factura($_SESSION['aux_id_factura'], 1); //PENDIENTE ARCHIVAR
        if ($rsepbf) {
            //obtener el mail del usuario por p.factura_pedido
            $rgppbf = $uM->get_propietario_pedido_by_factura($Ds_Order);
            if ($rgppbf) {
                
                $data = array('iduser', 'fullname', 'email', 'randomkey');
                while ($fgppbf = $rgppbf->fetch_assoc()) {
                    $data['iduser'] = $fgppbf['id_usuario'];
                    $data['fullname'] = $fgppbf['fullname'];
                    $data['email'] = $fgppbf['email'];
                    $data['randomkey'] = $fgppbf['randomkey'];
                }
                
                $rfm = $uM->factura_mail($ruta_inicio, $Ds_Order, $data);
                if ($rfm) {
                    adstormlog($Ds_Order.'    SUCCESS'); //TODO OK :)
                } else adstormlog($Ds_Order.'    EMAIL ERROR');
                
            } else adstormlog($Ds_Order.'    ERROR CARGANDO DATOS USUARIO');
            
        } else adstormlog($Ds_Order.'    BD ERROR 001'); //esta pagada pero no se refleja en sistema por error de BD
        
    } else if ($Ds_response == 900) { //Transacción autorizada para devoluciones y confirmaciones
        adstormlog($Ds_response.'    TRANSACCION 900');
        
        /*
        $redb = $bM->cancel_booking_by_order($Ds_Order); //bd delete = 1 y automaticamente regenera la factura
        if ($redb) {
            
            $rbbo = $bM->get_booking_by_order($redb); //obtener los datos del usuario por la factura/booking
            if ($rbbo) {
                
                while ($fbbo = mysql_fetch_assoc($rbbo)) { $mail_usuario = $fbbo['contactmail']; }
                
                if (informe_cancel_booking($mail_usuario, ADMIN_MAIL, $Ds_Order)) { //enviar correo con factura al usuario y al admin
                    gtbglog($Ds_Order.'    CANCEL SUCCESS'); //TODO OK :)
                } else gtbglog($Ds_Order.'    EMAIL ERROR 002'); //esta cancelada pero no se ha podido enviar el correo por error de MAIL 
            } else gtbglog($Ds_Order.'    BD ERROR 011'); //esta pagada pero no se han podido obtener datos de booking by factura por error de BD    
        } else gtbglog($Ds_Order.'    BD ERROR 010'); //esta devuelta pero no se refleja en sistema por error de BD o no se ha podido generar una nueva factura
        */
    } else { //Transacción denegada
        
        $err_desc = 'Transaction refused ('.$Ds_response.')';
        if (in_array($Ds_response, $Ds_response_error) ){ //si esta el error en el array, modificar $err_desc
            $err_desc = $Ds_response_error[$Ds_response];
        }
        
        adstormlog($Ds_Order.'    '.$err_desc);
        
        //obtener el mail del usuario por p.factura_pedido
        $rgppbf = $pM->get_propietario_pedido_by_factura($Ds_Order);
        if ($rgppbf) {

            $data = array('iduser', 'fullname', 'email');
            while ($fgppbf = $rgppbf->fetch_assoc()) {
                $data['iduser'] = $fgppbf['id_usuario'];
                $data['fullname'] = $fgppbf['fullname'];
                $data['email'] = $fgppbf['email'];
            }

            //enviar email
            if ($uM->mail_transaction_error($Ds_Order, $data, $err_desc, $ruta_archivos)) {
                adstormlog($Ds_Order.'    TRANSACCION DENEGADA, MAIL OK, '.$err_desc); //error de transaccion con email enviado
            } else {
                adstormlog($Ds_Order.'    TRANSACCION DENEGADA, MAIL KO, '.$err_desc); //error de transaccion con email enviado
            }
            
        } else adstormlog($Ds_Order.'    TRANSACCION DENEGADA, ERROR CARGANDO DATOS USUARIO, '.$err_desc);
        
    }
    
} else { //Segunda carga de TPV (para gestion y redireccion)
    //adstormlog('    ERROR INDEFINIDO:'. printf($POST));
    /*
    //RECUPERAR DATOS DEL GET
    
    //recuperar email del cliente y enviar aviso
    $rbbo = $bM->get_booking_by_order($_GET['factura']); //obtener los datos del usuario por la factura/booking
    if ($rbbo) {
        
        if ($_GET['result'] != 'ok' && $_GET['result'] != 'delete_ok') { //control de segunda llamada
        
            while ($fbbo = mysql_fetch_assoc($rbbo)) { 
                $id_booking = $fbbo['id_booking'];
                $mail_usuario = $fbbo['contactmail'];
                $id_session = $fbbo['id_session'];
            }

            if (informe_transaccion_denegada($mail_usuario, ADMIN_MAIL, $_GET['factura'], $id_booking, '', $ruta_archivos, $id_session)) { //enviar correo de errores al usuario y al admin
                gtbglog($_GET['factura'].'    ERROR - FACTURA REINICIADA, '.$err_desc); //error de transaccion con email enviado
            } else gtbglog($_GET['factura'].'    EMAIL ERROR, (ERROR INDEFINIDO)'); //error de transaccion y error de envio de correo

            //reset de factura
            $redb = $bM->cancel_booking_by_order($_GET['factura']); //bd delete = 1 y automaticamente regenera la factura

        } //else es la segunda llamada con todo ok; se gestiona debajo
        
    } else gtbglog($_GET['factura'].'/'.$redb.'    BD ERROR 003, (ERROR INDEFINIDO)'); //error de transaccion pero no se han podido obtener datos de booking by factura por error de BD
    */
}

if (isset($_REQUEST['result'])) {
    if ($_REQUEST['result'] == 'ok') {
        header('Location: '.$ruta_inicio.'validation.php?saved_order=true&factura='.$_REQUEST['factura']); //enviar a la pantalla de bookings con exito
        exit();
    } else if ($_REQUEST['result'] == 'ko') {
        header('Location: '.$ruta_inicio.'checkout.php?transaccion_denegada=true'); //enviar a la pantalla de bookings con error
        exit();
    } else {
        header('Location: '.$ruta_inicio.'index.php'); exit();
    }
}


if(isset($_REQUEST['saved_order']) && isset($_REQUEST['factura'])){
    $factura = preg_replace('/^0+/', '', $_REQUEST['factura']); 
    $rsepbf = $uM->set_estado_pedido_by_factura($_REQUEST['factura'], 1);
    if($rsepbf){
        $rgc = $cM->get_carrito($_SESSION['id_usuario'], $_SESSION['lang'], "exp");
        if($rgc){
            while($frgc = $rgc->fetch_assoc()){
                $cM->add_detallepedidos($_REQUEST['factura'], $frgc['cantidad'], $frgc['precio'], $frgc['nombre']);
                echo '<pre>';
                print_r($frgc);
                echo '</pre>';
                $uM->add_post_zoho('https://creator.zoho.eu/api/pharmalink/json/ysanaapp/form/relacional_pedido/record/add/', array(
                    'authtoken' => AUTHTOKEN,
                    'scope' => SCOPE,
                    'id_pedido' => $_REQUEST['factura'],
                    'id_producto' => $frgc['id_articulo'],
                    'cantidad' => $frgc['cantidad'],
                    'precio' => $frgc['precio'],
                ));
            }
        }
        $rgpd = $uM->get_datos_pedido($factura);
        if($rgpd){
            while($frgpd = $rgpd->fetch_assoc()){
                echo '<pre>';
                print_r($frgpd);
                echo '</pre>';
                $id_correo_usuario = '';
                $rgmu = $uM->get_mail_user($_SESSION['id_usuario']);
                if($rgmu){
                    while($frgmu = $rgmu->fetch_assoc()){
                        $id_correo_usuario = $frgmu['email_usuario'];
                    }
                }
                $uM->add_post_zoho('https://creator.zoho.eu/api/pharmalink/json/ysanaapp/form/pedido/record/add/', array(
                    'authtoken' => AUTHTOKEN,
                    'scope' => SCOPE,
                    'id_pedido' => $_REQUEST['factura'],
                    'id_usuario' => $id_correo_usuario,
                    'nombre' => $frgpd['nombre'],
                    'apellidos' => $frgpd['apellidos'],
                    'direccion' => $frgpd['direccion'],
                    'codigo_postal' => $frgpd['codigo_postal'],
                    'poblacion' => $frgpd['poblacion'],
                    'movil' => $frgpd['movil'],
                    'fecha_compra' => date("Y-m-d H:i:s"),
                    'completado' => '1'
                ));
            }
        }
        $uM->user_pedido_mail($factura);
        $rcc = $cM->clear_carrito($_SESSION['id_usuario'], "exp");
        //enviar mail
        if($rcc){
            echo 'ok';
            //header('Location: '.$ruta_inicio.'carrito/?compra=ok');
            exit();
        }else{
            echo 'ko';
            //header('Location: '.$ruta_inicio.'carrito/?compra=ko');
            exit();
        }
    }
}else{
    /* header('Location: '.$ruta_inicio);
    exit(); */
    
    function enviar_factura($email, $numpedido){
        $op = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><div class="container">
        <div class="logo">
            <img src="https://ysana.es/img/svg/ysanacolor.svg" class="img-logo" alt="Ysana">
        </div>
        <div class="contenedor success ohidden">
            <div class="centrar-pd">
                <img src="https://img.icons8.com/ios/64/88d69b/security-checked.png">
                <span>
                    <strong>PAGO SEGURO</strong><br>
                    Pago 100% seguro
                </span>
            </div>
            <div class="centrar-pd">
                <img src="https://img.icons8.com/ios/64/88d69b/security-checked.png">
                <span>
                    <strong>PAGO SEGURO</strong><br>
                    Pago 100% seguro
                </span>
            </div>
        </div>
        <div class="contenedor ovy">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Art&iacute;culo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="https://ysana.es/img/productos/ysana-articulaciones-ywellness.png" class="img-producto" alt="">
                            <span>Y·Wellness Articular</span>
                        </td>
                        <td>25€</td>
                        <td>2</td>
                        <td>50€</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="https://ysana.es/img/productos/ysana-reduce-colesterol.png" class="img-producto" alt="">
                            <span>Y·Wellness Colesterol</span>
                        </td>
                        <td>39€</td>
                        <td>3</td>
                        <td>117€</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="https://ysana.es/img/productos/eficaps-sueno-caja-detalle-flor-capsula.png" class="img-producto" alt="">
                            <span>Eficaps® Sueño</span>
                        </td>
                        <td>120€</td>
                        <td>1</td>
                        <td>120€</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="contenedor rss">
            <div class="rss-icon facebook">
                <a target="_blank" href="https://www.facebook.com/YSanaVidaSana/">
                    <img src="https://img.icons8.com/ios-glyphs/32/FFFFFF/facebook-f.png" alt="">
                </a>
            </div>
            <div class="rss-icon instagram">
                <a target="_blank" href="https://www.instagram.com/ysanavidasana/">
                    <img src="https://img.icons8.com/ios-glyphs/32/FFFFFF/instagram-new.png" alt="">
                </a>
            </div>
            <div class="rss-icon twitter">
                <a target="_blank" href="https://twitter.com/Ysana_Vida_Sana">
                    <img src="https://img.icons8.com/ios-glyphs/32/FFFFFF/twitter.png" alt="">
                </a>
            </div>
        </div>
        <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                body {
                    background-color: white;
                }
                .container {
                    width: 100%;
                    padding-right: 15px;
                    padding-left: 15px;
                    margin-right: auto;
                    margin-left: auto;
                    /* background-color: #bababa; */
                }
                .container>div {
                    margin-top: 1rem;
                    margin-bottom: 1rem;
                }
                .logo {
                    display: flex;
                    padding-top: .5rem;
                    padding-bottom: .5rem;
                }
                .img-logo {
                    max-width: 100%;
                    height: 64px;
                    margin: 0 auto;
                    transition: 2s;
                }
                .contenedor {
                    /* background-color: #cecece; */
                    box-shadow: 0px 3px 8px gray;
                    border-radius: 4px;
                    padding: 1rem;
                }
                .ohidden{
                    overflow: hidden;
                }
                .contenedor table {
                    width: 100%;
                    text-align: center;
                    border-radius: 4px;
                    color: rgb(100, 100, 100);
                }
                table, th, td {
                    border-collapse: collapse;
                }
                th {
                    background-color: #ebeced;
                    border-top: 1px solid rgb(170, 170, 170);
                    border-bottom: 1px solid rgb(170, 170, 170);
                }
                tr{
                    border-bottom: 1px solid rgb(170, 170, 170);
                }
                /* tr:last-child{
                    border-bottom: 3px solid rgb(170, 170, 170);
                } */
                th, td {
                    padding: .6rem;
                }
                tr>td:first-child{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-width: 300px;
                }
                .img-producto {
                    max-width: 96px;
                    height: auto;
                }
                .centrar-pd{
                    display: flex;
                    align-items: center;
                    margin-top: .25rem;
                    margin-bottom: .25rem;
                }
                .ovy{
                    overflow-y: auto;
                }
                .success{
                    color: #155724;
                }
                .contenedor.success{
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-around;
                }
                img+span{
                    margin-left: .25rem;
                    margin-right: .25rem;
                }
                .rss{
                    display: flex;
                    flex-wrap: wrap;
                    padding: 0;
                    border-radius: 4px;
                    overflow: hidden;
                }
                .facebook{
                    background-color: #3b5998;
                }
                .instagram{
                    background: #d6249f;
                    background: radial-gradient(circle at 0% 207%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
                }
                .twitter{
                    background-color: #00aced;
                }
                .rss-icon{
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 33.33334%;
                    padding: .3rem;
                }
                @media screen and (max-width: 576px){
                    .rss{
                        box-shadow: 0px 0px 0px white;
                    }
                    .rss-icon{
                        width: 100%;
                        margin-top: .25rem;
                        margin-bottom: .25rem;
                    }
                }
        </style></div></html>';

        $asunto = 'Ysana - Pedido #'+$numpedido;
        $mail_admin = 'info@ysana.es';

        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=utf-8";
        //TODO
        $headers[] = "From: <no.reply@ysana.es> Ysana ";
        $headers[] = "Reply-To: <no.reply@ysana.es> Ysana ";
        $headers[] = "X-Mailer: PHP/" . phpversion();

        $cabeceras = implode("\r\n", $headers);

        //$result_mail_send = TRUE;
        $result_mail_send = mail($email, $asunto, $op, $cabeceras); //produccion
        //$result_mail_send = getbagservice_mail($email, $asunto, $op, $headers);

        echo 'Result: '.$result_mail_send.'<hr>';
        return $result_mail_send;
    }
}

?>