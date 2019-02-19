<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');

$id_usuario = '';
$id_articulo = 0;
$nombre = '';
$descripcion = '';
$stock = '';
$precio = '';
$nombre_categoria = array();
$usos_producto = array();
$info_producto = array();
$consejo_producto = array();
$valoracion_producto = array();
$imgs_producto = array();
$cantidad_productos = array();
$total_stock = 0;
$stock=0;
$count_valoracion_producto = 0;
$total_valoracion_producto = 0;
//GET__________________________________________________________________________
(isset($_GET['id_articulo'])) ? $id_articulo=$_GET['id_articulo'] : '';

//GET__________________________________________________________________________

//LISTADO______________________________________________________________________
if($id_articulo!=''){
    $rga = $aM->get_articulo($id_articulo, $lang);
    if($rga){
        while($fga = $rga->fetch_assoc()){
            $nombre = $fga['nombre'];
            $descripcion = $fga['descripcion'];
            $stock = $fga['stock'];
            $precio = $fga['precio'];
            if($fga['descuento']){
                $descuento = ($fga['descuento_porcentaje']*$fga['precio'])/100;
                if($fga['fecha_inicio_descuento']<=date('Y-m-d') && $fga['fecha_fin_descuento']>=date('Y-m-d')){
                    $precio = $fga['precio']-$descuento;
                }
                /* var_dump(date('Y-m-d')<$fga['fecha_inicio_descuento']); */
            }
            array_push($nombre_categoria,$fga['nombre_categoria']);
        }
    }
    $rgua = $aM->get_usos_articulo($id_articulo, $lang);
    if($rgua){
        while($fgua = $rgua->fetch_assoc()){
            array_push($usos_producto,array('titulo'=>$fgua['titulo'],'des'=>$fgua['descripcion']));
        }
    }
    $rgia = $aM->get_infonutricional_articulo($id_articulo, $lang);
    if($rgia){
        while($fgia = $rgia->fetch_assoc()){
            array_push($info_producto,array('titulo'=>$fgia['titulo'],'des'=>$fgia['descripcion']));
        }
    }
    $rgca = $aM->get_consejo_articulo($id_articulo, $lang);
    if($rgca){
        while($fgca = $rgca->fetch_assoc()){
            array_push($consejo_producto,array('titulo'=>$fgca['titulo'],'des'=>$fgca['descripcion']));
        }
    }
    $rgia = $aM->get_imgs_articulo($id_articulo);
    if($rgia){
        while($fgia = $rgia->fetch_assoc()){
            array_push($imgs_producto,$fgia['url_img']);
        }
    }
    $rgia = $aM->get_stock_articulo($id_articulo);
    if($rgia){
        while($fgia = $rgia->fetch_assoc()){
            $total_stock = $fgia['stock'];
        }
        if($total_stock!=0){
            for($i=1;$i<=$total_stock;$i++){
                array_push($cantidad_productos,$i);
            }
        }
    }
    $rgva = $aM->get_preguntas_articulo($id_articulo, 5);
    if($rgva){
        while($fgva = $rgva->fetch_assoc()){
            array_push($valoracion_producto,array(
                'titulo'=>$fgva['titulo'],
                'des'=>$fgva['descripcion'],
                'fecha_valoracion'=>mysql_to_date($fgva['fecha_valoracion']),
                'puntuacion'=>$fgva['puntuacion'],
                'nombre_usuario'=>$fgva['nombre_usuario'],
                'apellidos_usuario'=>$fgva['apellidos_usuario']
            ));
        }
    }
    $count_valoracion_producto = $aM->get_total_preguntas_articulo($id_articulo);
    $rgtv = $aM->get_total_valoraciones($id_articulo);
    if($rgtv){
        while($fgtv = $rgtv->fetch_assoc()){
            $total_valoracion_producto = $fgtv['total'];
        }
    }
}
//LISTADO______________________________________________________________________
include_once('inc/cabecera.inc.php'); //cargando cabecera 
?>
<script type="text/javascript">
</script>

<body>
    <?php include_once('inc/franja_top.inc.php'); ?>
    <?php include_once('inc/main_menu.inc.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-info bg-white p-3 mt-3">
                    <div class="row">
                        <div class="imagenes col-md-12 col-lg-4 mb-2">
                            <!-- <?php
                            if(count($imgs_producto)>0){
                                $img = 0;
                                echo '<img src="'.$imgs_producto[$img].'" class="w-100">';
                                echo '<div class="row mt-2">';
                                while($img<count($imgs_producto)){
                                    if($img<count($imgs_producto)){
                                        echo '<div class="col-md-4">
                                                <img src="'.$imgs_producto[$img].'" class="w-100">
                                            </div>';
                                    }
                                $img++;
                                }
                                echo '</div>';
                            }
                            ?> -->
                            <img src="https://i1.wp.com/spintiresvenezuela.com/wp-content/uploads/2017/05/fondo-gris-claro.jpg" class="w-100">
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <img src="https://i1.wp.com/spintiresvenezuela.com/wp-content/uploads/2017/05/fondo-gris-claro.jpg" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <img src="https://i1.wp.com/spintiresvenezuela.com/wp-content/uploads/2017/05/fondo-gris-claro.jpg" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <img src="https://i1.wp.com/spintiresvenezuela.com/wp-content/uploads/2017/05/fondo-gris-claro.jpg" class="w-100">
                                </div>
                            </div>
                        </div>
                        <div class="info col-md-6 col-lg-5">
                            <p class="pb-0 mb-0 text-color-3">
                                <?php foreach($nombre_categoria as $valor){
                                if($valor!=end($nombre_categoria)) echo $valor.', ';
                                    else echo $valor;
                            } ?>
                            </p>
                            <h3>
                                <?php echo $nombre; ?>
                            </h3>
                            <p class="mb-2">
                                <?php echo $descripcion; ?>
                            </p>
                            <p class="mb-1 text-color-3">
                                <?php echo ($stock>0) ? 'En stock':'Sin stock'; ?>
                            </p>
                            <p class="mb-1 text-color-1">
                                <?php echo 'Añadir a Favoritos' ?>
                            </p>
                            <p>
                                <?php
                                for($i=1;$i<=5;$i++){
                                    echo ($i<=($total_valoracion_producto/2)) ? '<img class="img-start-puntuacion-16" src="'.$ruta_archivos.'img/star-color.png">':'<img class="img-start-puntuacion-16" src="'.$ruta_archivos.'img/star.png">';
                                }
                                ?>
                            </p>
                            <p class="o-50">
                                <?php echo $count_valoracion_producto; ?> Valoraciones</p>
                        </div>
                        <div class="compra col-md-6 col-lg-3 text-center" style="border-left: 1px solid #bbbbbb;">
                            <h1 class="display-4 mt-3">
                                <?php echo $precio.' €'; ?>
                            </h1>
                            <p>información adicional</p>
                            <form action="articulo.php" method="post">
                                <button class="btn btn-lg btn-color-5 mb-2 w-100">Comprar Ahora</button>
                                <button class="btn btn-lg btn-color-8 mb-2 w-100">Añadir a la Cesta</button>
                                <?php echo $iM->get_select("cantidad_productos", $stock, $cantidad_productos); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white mt-5">
        <div class="container">
            <div class="row pb-5">
                <div class="col-md-12">
                    <nav id="nav-info">
                        <div class="nav">
                            <a class="nav-item nav-link active" id="nav-usos-tab" data-toggle="tab" href="#nav-usos" role="tab" aria-controls="nav-usos"
                                aria-selected="true">Usos</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile"
                                aria-selected="false">Información Nutricional</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact"
                                aria-selected="false">Valoraciones</a>
                        </div>
                    </nav>
                    <div class="tab-content mt-4" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-usos" role="tabpanel" aria-labelledby="nav-usos-tab">
                            <?php foreach($usos_producto as $valor){
                                echo '<div class="uso ml-2">
                                <h6>'.$valor['titulo'].'</h6>
                                <p>'.$valor['des'].'</p>
                                </div>';
                            }?>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-md-6 h-100 d-flex flex-column align-items-center">
                                    <h5 class="text-center mt-2">Información Producto</h5>
                                    <div class="mt-3">
                                        <?php foreach($info_producto as $valor){
                                        echo '<div class="info mb-4">
                                        <h5>'.$valor['titulo'].'</h5>
                                        <p>'.$valor['des'].'</p>
                                        </div>';
                                    }?>
                                    </div>
                                </div>
                                <div class="col-md-6 bg-grayopacity-ysana pb-3">
                                    <div>
                                        <h5 class="text-center mt-2">Consejo Coach</h5>
                                        <div class="mt-3">
                                            <?php foreach($consejo_producto as $valor){
                                            echo '<div class="info mb-4 bg-white mx-2 p-3">
                                            <h6>'.$valor['titulo'].'</h6>
                                            <p>'.$valor['des'].'</p>
                                            </div>';
                                        }?>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="text-center mt-2">Preguntas</h5>
                                        <div class="mt-3">
                                            <?php foreach(array_slice($valoracion_producto, 0, 2) as $valor){
                                            echo '<div class="info mb-4 bg-white mx-2 p-3">
                                            <h6>'.$valor['titulo'].'</h6>
                                            <p class="mb-0">'.$valor['des'].'</p>';
                                            for($i=1;$i<=5;$i++){
                                                echo ($i<=($valor['puntuacion']/2)) ? '<img class="img-start-puntuacion-16" src="'.$ruta_archivos.'img/star-color.png">':'<img class="img-start-puntuacion-16" src="'.$ruta_archivos.'img/star.png">';
                                            }
                                            echo '<p class="o-50 mb-0 mt-1">'.$valor['fecha_valoracion'].' | Opinión de '.$valor['nombre_usuario'].' '.$valor['apellidos_usuario'].'</p>
                                            </div>';
                                        }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-3">
                                        <h5 class="o-50">
                                            <?php echo $count_valoracion_producto; ?> Valoraciones</h5>
                                        <?php foreach($valoracion_producto as $valor){
                                        echo '<div class="valoracion mb-4 p-3 row">
                                        <div class="col-md-2 m-0 px-0 d-flex align-items-center flex-column">
                                            <div class="estrellas">';
                                        for($i=1;$i<=5;$i++){
                                            echo ($i<=($valor['puntuacion']/2)) ? '<img class="img-start-puntuacion-20" src="'.$ruta_archivos.'img/star-color.png">':'<img class="img-start-puntuacion-20" src="'.$ruta_archivos.'img/star.png">';
                                        }
                                        echo '</div>
                                        <p class="o-50">'.$valor['fecha_valoracion'].'</p></div>';
                                        echo '<div class="col-md-10">
                                        <h5 class="mb-0">'.$valor['titulo'].'</h5>
                                        <p class="o-50"><strong>Publicado por:</strong> '.$valor['nombre_usuario'].' '.$valor['apellidos_usuario'].'</p>
                                        <p>'.$valor['des'].'</p>
                                    </div></div>';
                                    }?>
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