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
/* new */
$strCarritonewexp = '';
$strCarritonewDf = '';
$arrProdExp = array();
$arrProdDf = array();
$ttlExp = 0;
$ttlDf = 0;
/* new */
/* echo '<pre>';
print_r($_POST);
echo '</pre>'; */

//GET__________________________________________________________________________
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
                        header("Refresh:0");
                    }else{
                        $cM->delete_articulo_usuario_carrito($id_usuario, $_REQUEST['id_articulo']);
                        header("Refresh:0");
                    }
                }
            }
            break;
        case "suma":
            $cM->sumarArticulo($id_usuario, $_REQUEST['id_articulo']);
            header("Refresh:0");
            break;
        case "borrar":
            $cM->delete_articulo_usuario_carrito($id_usuario, $_REQUEST['id_articulo']);
            header("Refresh:0");
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
//LISTADO______________________________________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]); 
?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); ?>
        <?php include_once('inc/menu.inc.php'); ?>
    </div>
    <div id="carrito" class="max-ysana marg-ysana">
        <div class="contenedor">
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
                        <div class="row">
                            <div class="col-12 col-lg-7 mb-2">
                                <?php echo $iM->get_input_text('buscarfarmacia', $buscarfarmacia, 'form-control', '', $lng['experiencia-carrito'][18], '', '', '', true); ?>
                                <?php echo $iM->get_select('selectfarmacia', $selectfarmacia, $arrselectfarmacia, 'form-control', false, false, false, 'form-group mb-0'); ?>
                            </div>
                            <div class="col-12 col-lg-5 mb-2 d-flex">
                                <button type="button" name="btnPedidodf" <?php echo ($ttlDf==0 ? 'disabled' : ''); ?>  class="btn btn-block btn-bg-color-2 mt-auto" data-toggle="modal" data-target="#realizarPedido">Reservar</button>
                            </div>
                        </div>
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
                        <div class="row mx-0 mt-2">
                            <?php echo $iM->get_input_text('totalprecio', $ttlExp, 'form-control', 'TOTAL', $ttlExp, '', false, false, false, 'form-group col-12 col-sm-6 mb-0 qmb', true); ?>
                            <div class="form-group col-12 col-sm-6 mb-0 qmb">
                                <label></label>
                                <button type="button" name="btnPedidodf" class="btn btn-block btn-bg-color-2" >Realizar pedido</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL -->
    <div class="modal fade" id="realizarPedido" tabindex="-1" role="dialog" aria-labelledby="realizarPedidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="realizarPedidoLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL -->
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