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
$orgcc = '';
$qttCarrito = 1;
$sumaTotal = 0;
$valid=true;
$iva = 0.21;


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

//LISTADO______________________________________________________________________
if($id_usuario>0){
    $rgcc = $cM->get_carrito($id_usuario, $_SESSION['lang']);
    if($rgcc){
        while($frgcc = $rgcc->fetch_assoc()){
            $orgcc .= '<tr>
            <th scope="row">
                <div class="foto-carrito">
                    <img src="'.$ruta_inicio.'img/productos/';
            if($frgcc["img_portada"]!=""){
                $orgcc .= $frgcc["img_portada"];
            }else{
                $orgcc .= $frgcc["img"];
            }
            $orgcc .= '" alt="" class="img-fluid">
                </div>
            </th>
            <td>
                <div class="dato-carrito">
                    <div class="h5">'.$frgcc["nombre"].'</div>
                </div>
            </td>
            <td>'.$frgcc["precio"].'€</td>
            <td>
                <form class="d-flex mb-0">
                    <a class="d-flex" href="?id_articulo='.$frgcc["id_articulo"].'&opc=resta"><button type="button" class="btn btn-unidades btn-mini btn-sm qtt-menos">--</button></a>
                    <input type="text" class="form-control qtt-input" value="'.$frgcc["cantidad"].'">
                    <a class="d-flex" href="?id_articulo='.$frgcc["id_articulo"].'&opc=suma"><button type="button" class="btn btn-unidades btn-mini btn-sm qtt-mas">+</button></a>
                </form>
            </td>
            <td>
                <label>'.($frgcc["precio"]*$frgcc["cantidad"]).'€</label>
                <a href="?id_articulo='.$frgcc["id_articulo"].'&opc=borrar" class="cerrar">
                    <img src="'.$ruta_inicio.'img/borrarProducto.png" alt="">
                </a>
            </td>
        </tr>';
        $sumaTotal+=($frgcc["precio"]*$frgcc["cantidad"]);
        $qttCarrito++;
        }
    }
    if(isset($_POST['btnPedido']) && $qttCarrito>1){
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
                <div class="col-12 col-md-12 col-lg-8 my-4">
                    <div class="carrito p-3">
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
                        <h1 class="h3 m-b-1">
                            <strong>(<?php
                            if($qttCarrito==0){
                                echo '0';
                            }else{
                                echo $qttCarrito-1;
                            }
                            ?>)</strong>
                            <?php echo $lng['experiencia-carrito'][0]; ?>
                            <strong> <?php echo $lng['experiencia-carrito'][1]; ?></strong>
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
                                    <?php echo $orgcc; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 my-4">
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
                    <!-- <div class="lista-top">
                        <div class="lista">
                            <div class="ticket-pago_desglose">
                                <div class="ticket-pago_articulos">

                                </div>
                                <div class="ticket-pago_total">
                                    <strong class="w-100">
                                        TOTAL
                                        <span class="pull-xs-right">149,99 €</span>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <form action="">
                            <button type="submit" class="btn bg-blue-ysana btn-lg btn-block mt-2 text-light">REALIZAR PEDIDO</button>
                        </form>
                    </div> -->
                </div>
            </div>
        </div>
    </div>


    <?php include_once('inc/footer.inc.php'); ?>
</body>

</html>