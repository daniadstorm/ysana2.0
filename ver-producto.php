<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$iM = load_model('inputs');
$aM = load_model('articulos');
$cM = load_model('carrito');
$sM = load_model('seo');


//VARIABLES_________________________________________________
$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';
$id_producto = (isset($_GET['id'])) ? $_GET['id'] : '';
$id_articulo = (isset($_GET['id_articulo'])) ? $_GET['id_articulo'] : '';
$cantidad_prod = (isset($_POST['cantidad_productos']) ? $_POST['cantidad_productos'] : 1);

$nombre = '';
$nombre_categoria = '';
$descripcion = '';
$stock = '';
$precio = '';
$id_articulo = '';
$imgs_producto = '';
$usosEditor = '';
$infoEditor = '';

//VARIABLES_________________________________________________

//GET_______________________________________________________

//GET_______________________________________________________

//POST______________________________________________________

//POST______________________________________________________

//LISTADO___________________________________________________
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
            $imgs_producto = $frgia['img'];
            //array_push($imgs_producto, $frgia['img']);
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
    /* for($i=0;$i<=$stock;$i++){
        array_push($cantidad_productos, ($i+1));
    } */
}
if(isset($_POST['update_precio'])){
    $rup = $aM->update_precio($id_articulo, $_POST['update_precio']);
    if($rup){
        header("Refresh:0");
    }
}
//LISTADO___________________________________________________

//COMPROBACION______________________________________________
$new_url = '';
if($id_producto!=''){
    if($aM->comprobarArticuloLang($id_producto, $_SESSION['id_lang'])==0){
        $rgal = $aM->get_articulo_lang($id_articulo, $_SESSION['id_lang']);
        if($rgal){
            while($frgal = $rgal->fetch_assoc()){
                $new_url = $frgal['urlseo'];
            }
            if($new_url!=''){
                header('Location: '.$ruta_inicio.'producto/'.$new_url);
                exit();
            }
        }
    }
}
//COMPROBACION______________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]); 

?>
<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); //panel superior ?>
        <?php include_once('inc/menu.inc.php'); //menu superior ?>
    </div>
    <div class="marg-ysana">
        <div class="max-ysana">
            <!-- <pre><?php
                echo 'id_usuario: '.$id_usuario.'<br>';
                echo 'id_producto: '.$id_producto.'<br>';
                echo 'id_articulo: '.$id_articulo.'<br>';
                echo 'cantidad_prod: '.$cantidad_prod.'<br>';
                //echo 'usosEditor: '.$usosEditor.'<br>';
                //echo 'infoEditor: '.$infoEditor.'<br>';
                echo 'imgs_producto: '.$imgs_producto.'<br>';
            ?></pre> -->
            <div id="ver-articulo" class="row">
                <div class="col-md-5">
                    <div class="imagen">
                        <img src="<?php echo $ruta_inicio.'img/productos/'.$imgs_producto; ?>" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="contenedor-info">
                        <div class="informacion">
                            <div class="categoria">
                                <h1><?php echo $nombre_categoria; ?></h1>
                            </div>
                            <div class="nombre">
                                <h1><?php echo $nombre; ?></h1>
                            </div>
                            <div class="texto">
                                <p><?php echo $descripcion; ?></p>
                            </div>
                        </div>
                        <div class="informacion-extra">
                            <div class="precio"><?php echo $precio; ?></div>
                            <div class="cantidad"><?php echo $cantidad_prod; ?></div>
                            <div class="cesta"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>