<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');
$sM = load_model('seo');

$id_usuario = '';
$carrito_compra = array('123','1234');

//GET__________________________________________________________________________
(isset($_GET['id_articulo'])) ? $id_articulo=$_GET['id_articulo'] : '';

//GET__________________________________________________________________________

//LISTADO______________________________________________________________________

//LISTADO______________________________________________________________________
include_once('../inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]); 
?>
<script type="text/javascript">
</script>

<body>
    <?php //include_once('../inc/franja_top.inc.php'); ?>
    <?php //include_once('../inc/main_menu.inc.php'); ?>
    <?php //include_once('../inc/panel_top_experiencia.inc.php'); ?>
    <?php //include_once('../inc/navbar_inicio_experiencia.inc.php'); ?>
    <?php include_once('../inc/panel_top_experiencia.inc.php'); ?>
    <?php include_once('../inc/navbar_inicio_experiencia.inc.php'); ?>
    <div class="bg-carrito">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 my-4">
                    <div class="carrito p-3">
                        <h1 class="h3 m-b-1">
                            <strong>(2)</strong>
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
                                    <script>
                                        function addQtt($val) {
                                            var x = document.querySelectorAll('input[data-ref="' + $val + '"]');
                                            var t = document.querySelectorAll('td[data-ref-total="' + $val + '"]');
                                            if (x.length > 0) {
                                                x[0].value++;
                                                t[0].innerHTML = (150 * x[0].value) + '€';
                                            }
                                        }
                                        function restQtt($val) {
                                            var x = document.querySelectorAll('input[data-ref="' + $val + '"]');
                                            var t = document.querySelectorAll('td[data-ref-total="' + $val + '"]');
                                            if (x.length > 0 && x[0].value > 1) {
                                                x[0].value--;
                                                t[0].innerHTML = (150 * x[0].value) + '€';
                                            }
                                        }
/*                                         function actualizarTotal(){

                                        }
                                        $(document).ready(()=>{
                                            $(".qtt-input").change(()=>{
                                                console.log('jej')
                                            });
                                            var list = document.getElementsByClassName("qtt-input");
                                                for (var i = 0; i < list.length; i++) {
                                                    console.log(list[i]);
                                                    list[i].addEventListener('change', () => {
                                                        console.log('jeej')
                                                    })
                                                }
                                        }); */
                                    </script>
                                    <tr>
                                        <th scope="row">
                                            <div class="foto-carrito">
                                                <img src="https://thumb.pccomponentes.com/w-220-220/articles/9/96677/lg-25um58-p-25-led-ips-ultrawide.jpg" alt="" class="img-fluid">
                                            </div>
                                        </th>
                                        <td>
                                            <div class="dato-carrito">
                                                <div class="h5">LG 25UM58-P 25" LED IPS Ultrawide</div>
                                            </div>
                                        </td>
                                        <td>150€</td>
                                        <td>
                                            <span class="d-flex">
                                                <button type="button" onclick="restQtt(1);" class="btn btn-unidades btn-mini btn-sm qtt-menos">--</button>
                                                <input type="text" data-ref="1" class="form-control qtt-input" value="1">
                                                <button type="button" onclick="addQtt(1);" class="btn btn-unidades btn-mini btn-sm qtt-mas">+</button>
                                            </span>
                                        </td>
                                        <td data-ref-total="1">150€</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="foto-carrito">
                                                <img src="https://thumb.pccomponentes.com/w-530-530/articles/13/135336/1.jpg" alt="" class="img-fluid">
                                            </div>
                                        </th>
                                        <td>
                                            <div class="dato-carrito">
                                                <div class="h5">LG 32LJ510B 32" HD LED</div>
                                            </div>
                                        </td>
                                        <td>169€</td>
                                        <td>
                                            <span class="d-flex">
                                                <button type="button" onclick="restQtt(2);" class="btn btn-unidades btn-mini btn-sm qtt-menos">--</button>
                                                <input type="text" data-ref="2" class="form-control qtt-input" value="1">
                                                <button type="button" onclick="addQtt(2);" class="btn btn-unidades btn-mini btn-sm qtt-mas">+</button>
                                            </span>
                                        </td>
                                        <td data-ref-total="2">169€</td>
                                    </tr>
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
                                        <?php echo $lng['experiencia-carrito'][6]; ?>
                                    </div>
                                    <div class="ticket-pago_total">
                                        <strong class="w-100">
                                            <?php echo $lng['experiencia-carrito'][7]; ?>
                                            <span class="pull-xs-right">150 €</span>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="">
                            <button type="submit" class="btn bg-blue-ysana btn-lg btn-block mt-2 text-light"><?php echo $lng['experiencia-carrito'][8]; ?></button>
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


    <?php include_once('../inc/footer.inc.php'); ?>
</body>

</html>