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
/* echo '<pre>';
print_r($_POST);
echo '</pre>'; */

//GET__________________________________________________________________________
if(isset($_POST['btnPedido']) && isset($_GET['opc'])){
    $valid=false;
}

if(isset($_GET['id_articulo']) && isset($_GET['opc']) && $valid){
    switch($_GET['opc']){
        case "resta":
            $rguau = $cM->get_unidades_articulo_usuario($id_usuario, $_GET['id_articulo']);
            if($rguau){
                while($frguau = $rguau->fetch_assoc()){
                    if($frguau['total']>1){
                        $cM->restarArticulo($id_usuario, $_GET['id_articulo']);
                    }else{
                        $cM->delete_articulo_usuario_carrito($id_usuario, $_GET['id_articulo']);
                    }
                }
            }
            break;
        case "suma":
            $cM->sumarArticulo($id_usuario, $_GET['id_articulo']);
            break;
        case "borrar":
            $cM->delete_articulo_usuario_carrito($id_usuario, $_GET['id_articulo']);
            break;
        default:
            break;
    }
}
//GET__________________________________________________________________________
//POST_________________________________________________________________________
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
if($id_usuario>0){
    $rgcc = $cM->get_carrito($id_usuario, $_SESSION['lang']);
    if($rgcc){
        while($frgcc = $rgcc->fetch_assoc()){
            if($frgcc["tipo_tienda"]=="exp"){
                $outcarritoexp .= '<tr><th scope="row"><div class="foto-carrito"><img src="'.$ruta_inicio.'img/productos/';
                if($frgcc["img_portada"]!=""){
                    $outcarritoexp .= $frgcc["img_portada"];
                }else{
                    $outcarritoexp .= $frgcc["img"];
                }
                $outcarritoexp .= '" alt="" class="img-fluid"></div></th><td><div class="dato-carrito"><div class="h5">'.$frgcc["nombre"].'</div></div></td>
                <td>'.$frgcc["precio"].'€</td><td>
                <form class="d-flex mb-0">
                <a class="d-flex" href="?id_articulo='.$frgcc["id_articulo"].'&opc=resta"><button type="button" class="btn btn-unidades btn-mini btn-sm qtt-menos">--</button></a>
                <input type="text" class="form-control qtt-input" value="'.$frgcc["cantidad"].'">
                <a class="d-flex" href="?id_articulo='.$frgcc["id_articulo"].'&opc=suma"><button type="button" class="btn btn-unidades btn-mini btn-sm qtt-mas">+</button></a></form></td><td>
                <label>'.($frgcc["precio"]*$frgcc["cantidad"]).'€</label>
                <a href="?id_articulo='.$frgcc["id_articulo"].'&opc=borrar" class="cerrar">
                <img src="'.$ruta_inicio.'img/borrarProducto.png" alt=""></a></td></tr>';
                $sumaTotalexp+=($frgcc["precio"]*$frgcc["cantidad"]);
                $ivatotalexp+=round($sumaTotalexp*$frgcc["iva"],2);
                $qttCarritoexp+=$frgcc["cantidad"];
            }else if($frgcc["tipo_tienda"]=="df"){
                $outcarritodf .= '<tr><th scope="row"><div class="foto-carrito"><img src="'.$ruta_inicio.'img/productos/';
                if($frgcc["img_portada"]!=""){
                    $outcarritodf .= $frgcc["img_portada"];
                }else{
                    $outcarritodf .= $frgcc["img"];
                }
                $outcarritodf .= '" alt="" class="img-fluid"></div></th><td><div class="dato-carrito"><div class="h5">'.$frgcc["nombre"].'</div></div></td>
                <td>'.$frgcc["precio"].'€</td><td>
                <form class="d-flex mb-0">
                <a class="d-flex" href="?id_articulo='.$frgcc["id_articulo"].'&opc=resta"><button type="button" class="btn btn-unidades btn-mini btn-sm qtt-menos">--</button></a>
                <input type="text" class="form-control qtt-input" value="'.$frgcc["cantidad"].'">
                <a class="d-flex" href="?id_articulo='.$frgcc["id_articulo"].'&opc=suma"><button type="button" class="btn btn-unidades btn-mini btn-sm qtt-mas">+</button></a></form></td><td>
                <label>'.($frgcc["precio"]*$frgcc["cantidad"]).'€</label>
                <a href="?id_articulo='.$frgcc["id_articulo"].'&opc=borrar" class="cerrar">
                <img src="'.$ruta_inicio.'img/borrarProducto.png" alt=""></a></td></tr>';
                $sumaTotaldf+=($frgcc["precio"]*$frgcc["cantidad"]);
                $ivatotaldf+=round($sumaTotaldf*$frgcc["iva"],2);
                $qttCarritodf+=$frgcc["cantidad"];
            }
        }
    }
    if(isset($_POST['btnPedido']) && $qttCarritoexp>0){
        header('Location: '.$ruta_inicio.'carrito/datos/');
    }
}
//LISTADO______________________________________________________________________
include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">
</script>

<body>
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio_experiencia.inc.php'); ?>
    <div class="bg-carrito">
        <div class="container carrito">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 my-4">
                    <div class="carrito p-3">
                        <?php
                            if($str_error) echo $hM->get_alert_danger($str_error);
                            else if($str_success) echo $hM->get_alert_success($str_success);
                        ?>
                        <div class="<?php echo (isset($_GET['compra']) ? 'pb-3' : ''); ?>">
                        <?php
                        if(isset($_GET['compra'])){
                            if($_GET['compra']=='ok'){
                                echo $hM->get_alert_success("Pago realizada con éxito!");
                            }else if($_GET['compra']=='ko'){
                                echo $hM->get_alert_danger("El pago no se ha podido realizar");
                            }
                        }
                        ?>
                        </div>
                        <!-- experiencia -->
                        <h1 class="h3 m-b-1">
                            <strong>(<?php echo $qttCarritoexp; ?>)</strong>
                            <?php echo $lng['experiencia-carrito'][0]; ?>
                            <strong> <?php echo $lng['experiencia-carrito'][1]; ?></strong>
                            <?php echo $lng['experiencia-carrito'][16]; ?>
                        </h1>
                        <div class="tabla-carrito pt-2">
                            <table class="table">
                                <thead class="bg-grayopacity-ysana">
                                    <tr>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][2]; ?></th>
                                        <th scope="col"></th>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][3]; ?></th>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][4]; ?></th>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][5]; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $outcarritoexp; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="info-pago">
                                    <div class="ticket-resumen">
                                        <div class="ticket-pago">
                                            <div class="ticket-pago_desglose">
                                                <div class="ticket-pago_articulos">
                                                    <div class="d-flex flex-column">
                                                        <strong class="w-100">
                                                            <span>IVA</span>
                                                            <span data-precio-total class="pull-xs-right">
                                                                <?php echo $ivatotalexp; ?> €</span>
                                                        </strong>
                                                        <strong class="w-100">
                                                            <span>
                                                                <?php echo $lng['experiencia-carrito'][13]; ?></span>
                                                            <span data-precio-total class="pull-xs-right">
                                                                <?php echo $lng['experiencia-carrito'][14]; ?></span>
                                                        </strong>
                                                    </div>
                                                </div>
                                                <div class="ticket-pago_total">
                                                    <strong class="w-100">
                                                        <?php echo $lng['experiencia-carrito'][7]; ?>
                                                        <span data-precio-total class="pull-xs-right">
                                                            <?php echo $sumaTotalexp; ?> €</span>
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <form method="post" action="">
                                    <button type="submit" name="btnPedido" class="btn bg-blue-ysana btn-lg btn-block text-light">
                                    <?php echo $lng['experiencia-carrito'][8]; ?></button>
                                </form>
                            </div>
                        </div>
                        <!-- experiencia -->
                        <br>
                        <hr>
                        <br>
                        <!-- directo farmacia -->
                        <h1 class="h3 m-b-1">
                            <strong>(<?php echo $qttCarritodf; ?>)</strong>
                            <?php echo $lng['experiencia-carrito'][0]; ?>
                            <strong> <?php echo $lng['experiencia-carrito'][1]; ?></strong>
                            <?php echo $lng['experiencia-carrito'][17]; ?>
                        </h1>
                        <div class="tabla-carrito pt-2">
                            <table class="table">
                                <thead class="bg-grayopacity-ysana">
                                    <tr>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][2]; ?></th>
                                        <th scope="col"></th>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][3]; ?></th>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][4]; ?></th>
                                        <th scope="col"><?php echo $lng['experiencia-carrito'][5]; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $outcarritodf; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="info-pago">
                                    <div class="ticket-resumen">
                                        <div class="ticket-pago">
                                            <div class="ticket-pago_desglose">
                                                <div class="ticket-pago_articulos">
                                                    <div class="d-flex flex-column">
                                                        <strong class="w-100">
                                                            <span>IVA</span>
                                                            <span data-precio-total class="pull-xs-right">
                                                                <?php echo $ivatotaldf; ?> €</span>
                                                        </strong>
                                                        <strong class="w-100">
                                                            <span>
                                                                <?php echo $lng['experiencia-carrito'][13]; ?></span>
                                                            <span data-precio-total class="pull-xs-right">
                                                                <?php echo $lng['experiencia-carrito'][14]; ?></span>
                                                        </strong>
                                                    </div>
                                                </div>
                                                <div class="ticket-pago_total">
                                                    <strong class="w-100">
                                                        <?php echo $lng['experiencia-carrito'][7]; ?>
                                                        <span data-precio-total class="pull-xs-right">
                                                            <?php echo $sumaTotaldf; ?> €</span>
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <form method="post" action="">
                                    <?php echo $iM->get_input_text('buscarfarmacia', $buscarfarmacia, 'form-control', '', $lng['experiencia-carrito'][18], '', '', '', true); ?>
                                    <?php echo $iM->get_select('selectfarmacia', $selectfarmacia, $arrselectfarmacia, 'form-control'); ?>
                                    <button type="button" name="btnPedidodf" class="btn bg-blue-ysana btn-lg btn-block text-light" data-toggle="modal" data-target="#exampleModalCenter">
                                    <?php echo $lng['experiencia-carrito'][8]; ?></button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $lng['experiencia-carrito'][19]; ?></h5>
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
                                                    <?php echo $iM->get_input_date('fechadia', $fechadia, 'form-control', $lng['experiencia-carrito'][23] , '', '', '', '', true) ?>
                                                    <p class="font-italic"><?php echo $lng['experiencia-carrito'][25]; ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lng['experiencia-carrito'][27]; ?></button>
                                                    <button type="submit" name="cestadf" class="btn bg-blue-ysana text-light"><?php echo $lng['experiencia-carrito'][24]; ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                </form>
                            </div>
                        </div>
                        <!-- directo farmacia -->
                    </div>
                </div>
                <!-- <div class="col-12 col-md-12 col-lg-4 my-4">
                    <div class="info-pago">
                        <div class="ticket-resumen">
                            <div class="ticket-pago">
                                <div class="ticket-pago_desglose">
                                    <div class="ticket-pago_articulos">
                                        <div class="d-flex flex-column">
                                            <strong class="w-100">
                                                <span>IVA (21%)</span>
                                                <span data-precio-total class="pull-xs-right"><?php echo round($sumaTotal*$iva,2); ?> €</span>
                                            </strong>
                                            <strong class="w-100">
                                                <span><?php echo $lng['experiencia-carrito'][13]; ?></span>
                                                <span data-precio-total class="pull-xs-right"><?php echo $lng['experiencia-carrito'][14]; ?></span>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="ticket-pago_total">
                                        <strong class="w-100">
                                            <?php echo $lng['experiencia-carrito'][7]; ?>
                                            <span data-precio-total class="pull-xs-right"><?php echo $sumaTotal; ?> €</span>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="">
                            <button type="submit" name="btnPedido" class="btn bg-blue-ysana btn-lg btn-block mt-2 text-light"><?php echo $lng['experiencia-carrito'][8]; ?></button>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
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