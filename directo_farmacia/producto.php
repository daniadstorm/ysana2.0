<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$iM = load_model('inputs');
$aM = load_model('articulos');
$cM = load_model('carrito');
$sM = load_model('seo');

$id_usuario = '';
$id_producto = '';
$id_articulo = 0;
$nombre = 'N/A';
$nombre_categoria = 'N/A';
$usos_prod = array();
$info_producto = array();
$descripcion = 'N/A';
$stock=0;
$precio = 'N/A';
$total_stock = 0;
$usosEditor = '';
$infoEditor = '';
$imgPortada = '';

$consejo_producto = array(
    array('titulo'=>'Titulo','des'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut commodo quam, id aliquet sem. Cras interdum sed elit quis malesuada. Vivamus mauris enim, fermentum ut tempor nec, ultrices ac nisi. Vestibulum facilisis, sapien ut faucibus elementum, nibh enim vestibulum orci, sed auctor ante enim eget tortor. Ut vel faucibus est, quis dictum arcu. Etiam eu justo quis felis ornare mattis. Nulla facilisi. Etiam arcu diam, feugiat aliquam iaculis et, scelerisque a est. Donec nisi leo, cursus vitae purus nec, ultrices fermentum quam.')
);
$preguntas_producto = array(
    array('titulo'=>'Pregunta lorem ipsuuuum','des'=>'Respuesta a lorem ipsuuuuuuuuuuum.','puntuacion'=>9,'fecha_valoracion'=>'20-08-2018','nombre_usuario'=>'Dani','apellidos_usuario'=>'AdStorm'),
    array('titulo'=>'Pregunta lorem ipsuuuum','des'=>'Respuesta a lorem ipsuuuuuuuuuuum.','puntuacion'=>2,'fecha_valoracion'=>'20-08-2018','nombre_usuario'=>'Sergio','apellidos_usuario'=>'AdStorm')
);
$valoracion_producto = array(
    array('titulo'=>'Pregunta lorem ipsuuuum','des'=>'Respuesta a lorem ipsuuuuuuuuuuum.','puntuacion'=>9,'fecha_valoracion'=>'20-08-2018','nombre_usuario'=>'Dani','apellidos_usuario'=>'AdStorm'),
    array('titulo'=>'Pregunta lorem ipsuuuum','des'=>'Respuesta a lorem ipsuuuuuuuuuuum.','puntuacion'=>6,'fecha_valoracion'=>'20-08-2018','nombre_usuario'=>'Sergio','apellidos_usuario'=>'AdStorm'),
    array('titulo'=>'Pregunta lorem ipsuuuum','des'=>'Respuesta a lorem ipsuuuuuuuuuuum.','puntuacion'=>7,'fecha_valoracion'=>'20-08-2018','nombre_usuario'=>'Dani','apellidos_usuario'=>'AdStorm'),
    array('titulo'=>'Pregunta lorem ipsuuuum','des'=>'Respuesta a lorem ipsuuuuuuuuuuum.','puntuacion'=>3,'fecha_valoracion'=>'20-08-2018','nombre_usuario'=>'Sergio','apellidos_usuario'=>'AdStorm')
);
$imgs_producto = array();
$cantidad_productos = array();

$count_valoracion_producto = 4;
$total_valoracion_producto = 7;

//GET__________________________________________________________________________
(isset($_GET['id_articulo'])) ? $id_articulo=$_GET['id_articulo'] : '';
$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';
$id_producto = (isset($_GET['id'])) ? $_GET['id'] : '';
$cantidad_prod = (isset($_POST['cantidad_productos']) ? ($_POST['cantidad_productos']+1) : 1);

//GET__________________________________________________________________________

//POST__________________________________________________________________________

if(isset($_POST['enviarazoho'])){
    $uM->add_post_zoho('https://creator.zoho.eu/api/pharmalink/json/ysanaapp/form/producto/record/add/', array(
        'authtoken' => AUTHTOKEN,
        'scope' => SCOPE,
        'id_producto' => $_POST['id_producto'],
        'categoria' => $_POST['nombre_categoria'],
        'titulo' => str_replace('%','&#37;',$_POST['nombre']),
        'descripcion' => substr(str_replace('%','&#37;',$_POST['descripcion']), 0, 255),
        'imagen' => $_POST['imagen'],
        'precio' => $_POST['precio'],
        'tipo_tienda' => $_POST['tipo_tienda']
    ));
}
//btnCestaph

if((isset($_POST['btnCesta']) || isset($_POST['btnCestaph'])) && $id_usuario>0){
    echo $cM->get_articulo_carrito($id_usuario, $_POST['id_articulo']);
    if($cM->get_articulo_carrito($id_usuario, $_POST['id_articulo'])>0){
        $rsa = $cM->sumarArticulo($id_usuario, $_POST['id_articulo'], $cantidad_prod);
    }else{
        $raac = $cM->add_articulo_carrito($id_usuario, $_POST['id_articulo'], $cantidad_prod, "df");
    }
    if(isset($_POST['btnCestaph'])){
        header('Location: '.$ruta_inicio.'carrito');
    }
}else if($id_usuario==''){
    header('Location: '.$ruta_inicio.'login');
}
if(isset($_POST['editorusos'])){
    if(!$aM->existeuso($id_producto)){
        $rau = $aM->addusos($id_producto, $_POST['editorusos']);
        if($rau){
            echo 'bien add';
        }else{
            echo 'todo mal add';
        }
    }else{
        $rau = $aM->updateusos($id_producto, $_POST['editorusos']);
        if($rau){
            echo 'bien update';
        }else{
            echo 'todo mal update';
        }
    }
}
if(isset($_POST['editorinfo'])){
    if(!$aM->existeinfo($id_producto)){
        $rau = $aM->addinfo($id_producto, $_POST['editorinfo']);
        if($rau){
            echo 'bien add';
        }else{
            echo 'todo mal add';
        }
    }else{
        $rau = $aM->updateinfo($id_producto, $_POST['editorinfo']);
        if($rau){
            echo 'bien update';
        }else{
            echo 'todo mal update';
        }
    }
}

//POST__________________________________________________________________________

//LISTADO______________________________________________________________________
if($id_producto!=''){
    $rgia = $aM->get_info_articulo($id_producto);
    if($rgia){
        while($frgia = $rgia->fetch_assoc()){
            $nombre=$frgia['nombre'];
            $nombre_categoria=$frgia['nombre_categoria'];
            $descripcion=$frgia['descripcion'];
            $stock=$frgia['stock'];
            $precio=$frgia['precio'];
            $id_articulo=$frgia['id_articulo'];
            array_push($imgs_producto, $frgia['img']);
        }
        $imgPortada = $imgs_producto[0];
    }
    $rgu = $aM->getusos($id_producto);
    if($rgu){
        while($frgu = $rgu->fetch_assoc()){
            $usosEditor .= $frgu['contenido'];
        }
    }
    $rgi = $aM->getinfo($id_producto);
    if($rgi){
        while($frgi = $rgi->fetch_assoc()){
            $infoEditor .= $frgi['contenido'];
        }
    }
    for($i=0;$i<=$stock;$i++){
        array_push($cantidad_productos, ($i+1));
    }
}
if(isset($_POST['update_precio'])){
    $rup = $aM->update_precio($id_articulo, $_POST['update_precio']);
    if($rup){
        header("Refresh:0");
    }
}

//LISTADO______________________________________________________________________

//COMPROBACION_________________________________________________________________
$new_url = '';
if($id_producto!=''){
    if($aM->comprobarArticuloLang($id_producto, $_SESSION['id_lang'])==0){
        $rgal = $aM->get_articulo_lang($id_articulo, $_SESSION['id_lang']);
        if($rgal){
            while($frgal = $rgal->fetch_assoc()){
                $new_url = $frgal['urlseo'];
            }
            if($new_url!=''){
                header('Location: '.$ruta_inicio.'directo_farmacia/producto/'.$new_url);
                exit();
            }
        }
    }
}
//COMPROBACION_________________________________________________________________


include_once('../inc/cabecera.inc.php'); //cargando cabecera 
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">
</script>

<body>
    <?php //include_once('../inc/franja_top.inc.php'); ?>
    <?php //include_once('../inc/main_menu.inc.php'); ?>
    <?php include_once('../inc/panel_top_experiencia.inc.php'); ?>
    <?php include_once('../inc/navbar_inicio_experiencia.inc.php'); ?>
    <div class="container-fluid">
        <nav>
            <ol class="breadcrumb bg-white pl-0">
                <!--
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>">Ysana</a>
                </li>
                -->
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>directo_farmacia/"><?php echo $lng['breadcrumb'][0]; ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $nombre; ?></li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-info bg-white p-3 mt-3">
                    <div class="row py-4" style="box-shadow: 0px 3px 10px 2px #0000001c;">
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
                            <img src="<?php echo $ruta_inicio; ?>img/productos/<?php echo $imgs_producto[0]; ?>" class="w-100">
                            <!-- <div class="row mt-2">
                                <div class="col-md-4">
                                    <img src="https://i1.wp.com/spintiresvenezuela.com/wp-content/uploads/2017/05/fondo-gris-claro.jpg" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <img src="https://i1.wp.com/spintiresvenezuela.com/wp-content/uploads/2017/05/fondo-gris-claro.jpg" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <img src="https://i1.wp.com/spintiresvenezuela.com/wp-content/uploads/2017/05/fondo-gris-claro.jpg" class="w-100">
                                </div>
                            </div> -->
                        </div>
                        <div class="info col-md-6 col-lg-5">
                            <p class="pb-0 mb-0 text-color-3">
                                <?php echo $nombre_categoria; ?>
                            </p>
                            <h3>
                                <?php echo $nombre; ?>
                            </h3>
                            <p class="mb-2">
                                <?php echo $descripcion; ?>
                            </p>
                            <!-- <p class="mb-1 text-color-3">
                                <?php echo ($stock>0) ? $lng['productos_ysana'][10]:$lng['productos_ysana'][11]; ?>
                            </p>
                            <p class="mb-1 text-color-1">
                            <?php echo $lng['productos_ysana'][12]; ?>
                            </p>
                            <p>
                                <?php
                                for($i=1;$i<=5;$i++){
                                    echo ($i<=($total_valoracion_producto/2)) ? '<img class="img-start-puntuacion-16" src="'.$ruta_archivos.'img/star-color.png">':'<img class="img-start-puntuacion-16" src="'.$ruta_archivos.'img/star-color.png">';
                                }
                                ?>
                            </p>
                            <p class="o-50">
                                <?php echo $count_valoracion_producto; ?> <?php echo $lng['productos_ysana'][6]; ?></p>
                            <div id="compartir" class="d-flex pt-2">
                                <p class="o-50 pt-1 mr-3"><?php echo $lng['productos_ysana'][13]; ?></p>
                                <img src="https://png.icons8.com/color/50/f39c12/gmail.png" height="30px" class="mr-2">
                                <img src="https://png.icons8.com/color/50/f39c12/facebook.png" height="30px" class="mr-2">
                                <img src="https://png.icons8.com/color/50/f39c12/twitter.png" height="30px" class="mr-2">
                            </div> -->
                        </div>
                        <?php if($stock>0){ ?>
                        <div class="compra col-md-6 col-lg-3 text-center" style="border-left: 1px solid #bbbbbb;">
                            <?php if(isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario']==10){ ?>
                                <form method="post">
                                    <input type="number" name="update_precio" step="0.01" value="<?php echo $precio; ?>" class="form-control mb-2">
                                </form>
                            <?php }else{ ?>
                            <h1 class="display-4 mt-3">
                                <?php echo $precio.' €'; ?>
                            </h1>
                            <?php } ?>
                            <!-- <p>información adicional</p> -->
                            <form action="" method="post">
                                <!-- <a href="<?php echo $ruta_inicio; ?>carrito"><input type="button" class="btn btn-lg btn-color-5 mb-2 w-100" value="<?php echo $lng['productos_ysana'][7]; ?>"></a> -->
                                <button name="btnCestaph" class="btn btn-lg btn-color-5 mb-2 w-100"><?php echo $lng['productos_ysana'][7]; ?></button>
                                <!-- <a href="<?php echo $ruta_inicio; ?>carrito"><button class="btn btn-lg btn-color-5 mb-2 w-100"><?php echo $lng['productos_ysana'][7]; ?></button></a> -->
                                <?php echo $iM->get_input_hidden('id_articulo', $id_articulo); ?>
                                <button class="btn btn-lg btn-cesta mb-2 w-100" name="btnCesta"><?php echo $lng['productos_ysana'][8]; ?></button>
                                <div class="caja d-flex">
                                    <label class="mr-3"><?php echo $lng['productos_ysana'][9]; ?></label>
                                    <?php echo $iM->get_select("cantidad_productos", 0, $cantidad_productos,''); ?>
                                </div>
                            </form>
                            <?php if(isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario']==10){ ?>
                            <form method="post">
                                <!-- ZOHO -->
                                <?php echo $iM->get_input_hidden('id_producto', $id_producto); ?>
                                <?php echo $iM->get_input_hidden('nombre', $nombre); ?>
                                <?php echo $iM->get_input_hidden('nombre_categoria', $nombre_categoria); ?>
                                <?php echo $iM->get_input_hidden('descripcion', $descripcion); ?>
                                <?php echo $iM->get_input_hidden('precio', $precio); ?>
                                <?php //echo $iM->get_input_hidden('usosEditor', $usosEditor); ?>
                                <?php //echo $iM->get_input_hidden('infoEditor', $infoEditor); ?>
                                <?php echo $iM->get_input_hidden('imagen', $ruta_inicio.'img/productos/'.$imgPortada); ?>
                                <?php echo $iM->get_input_hidden('tipo_tienda', 'directo_farmacia'); ?>
                                <?php echo '<button type="submit" name="enviarazoho" class="btn btn-block btn-outline-info">Enviar a Zoho</button>'; ?>
                            </form>
                            <?php } ?>
                        </div>
                        <?php }else{ ?>
                        <div class="compra col-md-6 col-lg-3 text-center" style="border-left: 1px solid #bbbbbb;">
                            <img src="https://png.icons8.com/ios/50/e74c3c/out-of-stock-filled.png">
                            <p style="color:#e74c3c; font-weight:bold;" class="m-0"><?php echo $lng['productos_ysana'][14]; ?></p>
                            <p style="color:#e74c3c; font-weight:bold;" class="m-1"><?php echo $lng['productos_ysana'][15]; ?></p>
                            <p style="font-size:12px;" class="m-1"><?php echo $lng['productos_ysana'][16]; ?></p>
                            <button class="btn btn-lg btn-color-5 mb-2 w-100" style="background-color:var(--ysana-color-2);" data-toggle="modal" data-target=".bd-example-modal-sm">email</button>
                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <!-- Formulario para introducir el correo :) -->
                                    </div>
                                </div>
                            </div>
                            <!-- <form action="producto.php" method="post">
                                <button class="btn btn-lg btn-color-5 mb-2 w-100">avisar</button>
                            </form> -->
                        </div>
                        <?php } ?>
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
                                aria-selected="true"><?php echo $lng['productos_ysana'][4]; ?></a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile"
                                aria-selected="false"><?php echo $lng['productos_ysana'][5]; ?></a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact"
                                aria-selected="false"><?php echo $lng['productos_ysana'][6]; ?></a>
                        </div>
                    </nav>
                    <div class="tab-content mt-4" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-usos" role="tabpanel" aria-labelledby="nav-usos-tab">
                            <div class="uso ml-2">
                                <?php echo $usosEditor; ?>
                            </div>
                            <?php if(isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario']==10){ ?>
                            <form method="post">
                                <textarea id="editorusos" name="editorusos"></textarea>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit" class="btn btn-outline-secondary"><?php echo $lng['productos_ysana'][17]; ?></button>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-md-6 h-100 d-flex flex-column align-items-center">
                                    <h5 class="text-center mt-2"><?php echo $lng['productos_ysana'][18]; ?></h5>
                                    <div class="mt-3 w-100">
                                        <?php echo $infoEditor; ?>
                                    </div>
                                    <?php if(isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario']==10){ ?>
                                    <form method="post">
                                        <textarea id="editorinfo" name="editorinfo"></textarea>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-outline-secondary"><?php echo $lng['productos_ysana'][17]; ?></button>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6 pb-3">
                                    <!-- bg-grayopacity-ysana -->
                                    <div class="no-blur-consejo">
                                        <div class="nb-pers">
                                            <h1><?php echo $lng['productos_ysana'][23]; ?></h1>
                                        </div>
                                    </div>
                                    <div class="blur-consejos no_seleccion">
                                        <div>
                                            <h5 class="text-center mt-2"><?php echo $lng['productos_ysana'][20]; ?></h5>
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
                                            <h5 class="text-center mt-2"><?php echo $lng['productos_ysana'][21]; ?></h5>
                                            <div class="mt-3">
                                                <?php foreach(array_slice($preguntas_producto, 0, 2) as $valor){
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
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-3">
                                    <div class="no-blur-consejo">
                                        <div class="nb-pers">
                                            <h1><?php echo $lng['productos_ysana'][24]; ?></h1>
                                        </div>
                                    </div>
                                        <h5 class="o-50">
                                            <?php echo $count_valoracion_producto; ?> <?php echo $lng['productos_ysana'][6]; ?></h5>
                                        <?php foreach($valoracion_producto as $valor){
                                        echo '<div class="valoracion blur-x5  mb-4 p-3 row">
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
    <?php
    if(isset($_SESSION['id_tipo_usuario'])){
        if($_SESSION['id_tipo_usuario']==10){
            echo '<script type="text/javascript">
            $(document).ready(function () {
                $("#editorusos").summernote({
                    height: 300,
                    minHeight: null,
                    maxHeight: null
                });
                $("#editorusos").summernote(\'code\', `'.$usosEditor.'`);
                $("#editorinfo").summernote({
                    height: 300,
                    minHeight: null,
                    maxHeight: null
                });
                $("#editorinfo").summernote(\'code\', `'.$infoEditor.'`);
            });
        </script>';
        }
    }
    ?>
    <?php include_once('../inc/footer.inc.php'); ?>
</body>

</html>