<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$iM = load_model('inputs');
$aM = load_model('articulos');
$cM = load_model('carrito');
$sM = load_model('seo');
$hM = load_model('html');


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
$str_info = '';
$str_error = '';
$tipo_tienda = '';

//VARIABLES_________________________________________________

//GET_______________________________________________________

//GET_______________________________________________________

//POST______________________________________________________
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
if(isset($_POST['addCesta'])){
    if($cM->get_articulo_carrito($id_usuario, $_POST['id_articulo'])>0){
        $rsa = $cM->sumarArticulo($id_usuario, $_POST['id_articulo'], $cantidad_prod);
    }else{
        if($_POST['tipo_tienda']==1){
            $tipo_tienda = "exp";
        }else{
            $tipo_tienda = "df";
        }
        $raac = $cM->add_articulo_carrito($id_usuario, $_POST['id_articulo'], $cantidad_prod, $tipo_tienda);
    }
}
if(isset($_POST['editorusos'])){
    if(!$aM->existeuso($id_producto)){
        $rau = $aM->addusos($id_producto, $_POST['editorusos']);
        if($rau){
            $str_info = 'Usos añadido correctamente!';
        }else{
            $str_error = 'Error al añadir usos';
        }
    }else{
        $rau = $aM->updateusos($id_producto, $_POST['editorusos']);
        if($rau){
            $str_info = 'Usos actualizado correctamente!';
        }else{
            $str_error = 'Usos no actualizado';
        }
    }
}
if(isset($_POST['editorinfo'])){
    if(!$aM->existeinfo($id_producto)){
        $rau = $aM->addinfo($id_producto, $_POST['editorinfo']);
        if($rau){
            $str_info = 'Info añadido correctamente!';
        }else{
            $str_error = 'Error al añadir info';
        }
    }else{
        $rau = $aM->updateinfo($id_producto, $_POST['editorinfo']);
        if($rau){
            $str_info = 'Info actualizado correctamente!';
        }else{
            $str_error = 'Info no actualizado';
        }
    }
}
//POST______________________________________________________

//LISTADO___________________________________________________
if($id_producto!=''){
    $rgia = $aM->get_info_articulo($id_producto, $_SESSION['id_lang']);
    if($rgia){
        while($frgia = $rgia->fetch_assoc()){
            $nombre=$frgia['nombre'];
            $nombre_categoria=$frgia['nombre_categoria'];
            $descripcion=$frgia['descripcion'];
            $stock=$frgia['stock'];
            $precio=$frgia['precio'];
            $id_articulo=$frgia['id_articulo'];
            $imgs_producto = $frgia['img'];
            $tipo_tienda = $frgia['tipo_tienda'];
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

echo $sM->add_cabecera($ruta_inicio, $lng[0]); 

?>
<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); //panel superior ?>
        <?php include_once('inc/menu.inc.php'); //menu superior ?>
    </div>
    <div class="marg-ysana">
        <div id="marg-producto" class="max-ysana">
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
                        <form method="post" action="">
                            <div class="informacion-extra">
                                <div class="precio">
                                    <h1><?php echo $precio; ?>€</h1>
                                </div>
                                <div class="cantidad">
                                    <p><?php echo $lng[71]; ?></p>
                                    <select name="cantidad_productos" id="cantidad_prod">
                                        <?php for ($i=1; $i <= 10; $i++) { 
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="cesta">
                                    <?php echo $iM->get_input_hidden('id_articulo', $id_articulo); ?>
                                    <?php echo $iM->get_input_hidden('tipo_tienda', $tipo_tienda); ?>
                                    <button class="btn btn-add-cesta" name="addCesta"><?php echo $lng[72]; ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            echo ($str_info!='' ? $hM->get_alert_success($str_info) : '');
            echo ($str_error!='' ? $hM->get_alert_danger($str_error) : '');
            ?>
            <div id="info-articulo">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="usos-tab" data-toggle="tab" href="#usos" role="tab" aria-controls="usos"
                            aria-selected="true"><?php echo $lng[73]; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info"
                            aria-selected="false"><?php echo $lng[74]; ?></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="usos" role="tabpanel" aria-labelledby="usos-tab">
                        <?php if(isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario']==ADMIN){ ?>
                            <form method="post">
                                <textarea id="editorusos" name="editorusos"></textarea>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit" class="btn btn-outline-secondary"><?php echo $lng['productos_ysana'][17]; ?></button>
                                </div>
                            </form>
                        <?php
                        }else{
                            echo $usosEditor;
                        } ?>
                    </div>
                    <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <?php if(isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario']==ADMIN){ ?>
                        <form method="post">
                            <textarea id="editorinfo" name="editorinfo"></textarea>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-outline-secondary"><?php echo $lng['productos_ysana'][17]; ?></button>
                            </div>
                        </form>
                        <?php
                        }else{
                            echo $infoEditor;
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if(isset($_SESSION['id_tipo_usuario'])){
        if($_SESSION['id_tipo_usuario']==ADMIN){
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
    <?php include_once('inc/footer.inc.php'); //panel superior ?>
</body>
</html>