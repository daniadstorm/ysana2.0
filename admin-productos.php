<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');
$hM = load_model('html');
$uM->control_sesion($ruta_inicio, ADMIN);

$out1 = '';
$out2 = '';
$contout = 0;
$arrCategorias = array();
$str_info = array();
$str_error = array();
$arrActivo = array(
    '1' => 'Activo',
    '0' => 'No activo'
);
$arrVisible = array(
    '1' => 'Visible',
    '2' => 'No Visible'
);
$arrTipoTienda = array(
    '1' => 'Experiencia',
    '2' => 'Directo farmacia'
);
$producto = array(
    'tipo_tienda' => '1',
    'categoria' => '0',
    'activo' => '1',
    'stock' => '',
    'precio' => '',
    'iva' => '',
    'spa' => array(
        'nombre' => '',
        'urlseo' => '',
        'visible' => '',
        'titulo' => '',
        'descripcion' => '',
        'imagen' => array()
    ),
    'eng' => array(
        'nombre' => '',
        'urlseo' => '',
        'visible' => '',
        'titulo' => '',
        'descripcion' => '',
        'imagen' => array()
    )
);
$id_articulo_mod = (isset($_POST['id_articulo_mod']) ? $_POST['id_articulo_mod'] : false);
$id_tipo_tienda_mod = (isset($_POST['id_tipo_tienda_mod']) ? $_POST['id_tipo_tienda_mod'] : false);
/* echo '<pre>';
print_r($_POST);
print_r($_SESSION);
echo '</pre>'; */

//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________
if(isset($_POST['editArticulo'])){
    /* echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>'; */
    $rua = $aM->update_articulo($_POST['id_articulo_mod'], $_POST['stock'], $_POST['precio'], $_POST['activo'], $_POST['tipo_tienda'], $_POST['iva']);
    if($rua) array_push($str_info, "Tabla articulo OK");
    else array_push($str_error, "Tabla articulo KO");
    foreach ($arrlang as $key => $value) {
        $img_temp = '';
        if(isset($_FILES)){
            $cantidad = count($_FILES['imagen'.$value]['tmp_name']);//Recibe un array de FILES que se hace poniendo el mismo name a todos los input[type="file"]
            for ($i=0;$i<$cantidad;$i++) {//Recorre el bucle
                if($_FILES['imagen'.$value]['name'][$i]!=""){//Si está vacio es que no ha insertado ninguna imagen por lo tanto no hace las siguientes comprobaciones
                    $imagenInfo = getimagesize($_FILES['imagen'.$value]['tmp_name'][$i]);//Saca el mime "type" pero que no se puede modificar
                    if ($imagenInfo['mime']=='image/png' || $imagenInfo['mime']=='image/jpeg') {//Si tiene una de las siguientes extensiones es que es imagen
                        $res = move_uploaded_file($_FILES['imagen'.$value]['tmp_name'][$i],$document_root.'img/productos/'.$_FILES['imagen'.$value]['name'][$i]);
                        if($res){
                            array_push($str_info, "Imágen insertada OK");
                            $img_temp = $_FILES['imagen'.$value]['name'][$i];
                        }
                        else array_push($str_error, "Imágen NO insertada OK");
                    }else array_push($str_error, "El archivo no es de tipo imagen - ".$key);
                }
            }
        }
        $rual = $aM->update_articulo_lang($_POST['id_articulo_mod'], $_POST['urlseo'][$value], $key, $_POST['nombre'][$value], $_POST['descripcion'][$value], $_POST['titulo'][$value], $img_temp);
        if($rual) array_push($str_info, "Tabla lang OK");
        else array_push($str_error, "Tabla lang KO");
    }

}
if(isset($_POST['addArticulo'])){
    /* echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>'; */
    $raa = $aM->add_articulo($_POST['stock'], $_POST['precio'], $_POST['activo'], $_POST['tipo_tienda'], $_POST['iva']);
    if($raa){
        $id_articulo = $aM->get_insert_id();
        foreach ($arrlang as $value => $key) {
            //key = spa - $value = 0
            $raal = $aM->add_articulo_lang($id_articulo, $_POST['urlseo'][$key], $value, $_POST['nombre'][$key], $_POST['descripcion'][$key], $_POST['titulo'][$key], $_FILES['imagen'.$key]['name'][0], $_POST['tipo_tienda']);
            if($raal){
                $cantidad = count($_FILES['imagen'.$key]['tmp_name']);//Recibe un array de FILES que se hace poniendo el mismo name a todos los input[type="file"]
                for ($i=0;$i<$cantidad;$i++) {//Recorre el bucle
                    if($_FILES['imagen'.$key]['name'][$i]!=""){//Si está vacio es que no ha insertado ninguna imagen por lo tanto no hace las siguientes comprobaciones
                        $imagenInfo = getimagesize($_FILES['imagen'.$key]['tmp_name'][$i]);//Saca el mime "type" pero que no se puede modificar
                        if ($imagenInfo['mime']=='image/png' || $imagenInfo['mime']=='image/jpeg') {//Si tiene una de las siguientes extensiones es que es imagen
                            $res = move_uploaded_file($_FILES['imagen'.$key]['tmp_name'][$i],$document_root.'img/productos/'.$_FILES['imagen'.$key]['name'][$i]);
                        }else array_push($str_error, "El archivo no es de tipo imagen - ".$key);
                    }
                }
            }
        }
        $raac = $aM->add_articulo_cat(($_POST['categorias']+1), $id_articulo);
        if($raac){
            array_push($str_info, "Articulo añadido");
        }else{
            array_push($str_error, "Categoria no añadida");
        }
    }else{
        array_push($str_error, "Error al añadir el articulo");
    }
}
if(isset($_POST['id_articulo_mod'])){
    $rgaa = $aM->get_all_articulos(false, false, $_POST['id_tipo_tienda_mod'], $_POST['id_articulo_mod'], false);
    if($rgaa){
        while($frgaa = $rgaa->fetch_assoc()){
            foreach ($arrlang as $key => $value) {
                if($frgaa['id_lang']==$key){
                    $producto[$value]['nombre'] = $frgaa['nombre'];
                    $producto[$value]['urlseo'] = $frgaa['urlseo'];
                    $producto[$value]['visible'] = $frgaa['visible'];
                    $producto[$value]['titulo'] = $frgaa['h1'];
                    $producto[$value]['descripcion'] = $frgaa['descripcion'];
                    $producto[$value]['imagen'][0] = $frgaa['img'];
                }
            }
            $producto['tipo_tienda'] = $frgaa['tipo_tienda'];
            $producto['categoria'] = ($aM->get_cat_articulo($_POST['id_articulo_mod']))-1;
            $producto['activo'] = $frgaa['activo'];
            $producto['stock'] = $frgaa['stock'];
            $producto['precio'] = $frgaa['precio'];
            $producto['iva'] = $frgaa['iva'];
            /* echo '<pre>';
            print_r($frgaa);
            echo '</pre>'; */
        }
    }
}
//POST__________________________________________________________________________

//LISTADO_______________________________________________________________________
$rgc = $aM->get_categorias(1);//1 es español
if($rgc){
    while($frgc = $rgc->fetch_assoc()){
        $arrCategorias = array_merge($arrCategorias, array($frgc['id_categoria']=>$frgc['nombre_categoria']));
    }
}
if(isset($arrlang)){
    foreach ($arrlang as $value => $key) {
        $out1 .= '<li class="nav-item ysana">
        <a class="nav-link '.(($contout==0) ? 'active' : '').'" id="'.$key.'-tab" data-toggle="tab" href="#'.$key.'" role="tab" aria-controls="'.$key.'" aria-selected="true">'.$key.'</a></li>';
        $out2 .= '<div class="tab-pane fade '.(($contout==0) ? 'show active' : '').'" id="'.$key.'" role="tabpanel" aria-labelledby="'.$key.'-tab">';
        $out2 .= '<div class="form-row">';
        $out2 .= $iM->get_input_hidden('id_articulo_mod', $id_articulo_mod);
        $out2 .= $iM->get_input_hidden('id_tipo_tienda_mod', $id_tipo_tienda_mod);
        $out2 .= $iM->get_input_text('nombre', $producto[$key]['nombre'], 'form-control', 'Nombre', 'Nombre', '', false, false, false, 'form-group col-md-6', false, '['.$key.']');
        $out2 .= $iM->get_input_text('urlseo', $producto[$key]['urlseo'], 'form-control', 'URL', 'url-producto', '', false, false, false, 'form-group col-md-6', false, '['.$key.']');
        /* $out2 .= $iM->get_input_radio('visible', $producto[$key]['visible'], $arrVisible, 'w-100 label-lg', 'Visible', false, false, 'form-group col-md-4', '['.$key.']'); */
        $out2 .= $iM->get_input_text('titulo', $producto[$key]['titulo'], 'form-control', 'Titulo', 'Titulo', '', false, false, false, 'form-group col-md-12', false, '['.$key.']');
        $out2 .= $iM->get_input_textarea('descripcion', $producto[$key]['descripcion'], 'form-control', 'Descripción', 'Descripción', '', false, false, false, 3, 'form-group col-md-12', '['.$key.']');
        $out2 .= $iM->get_input_img('imagen'.$key, $producto[$key]['imagen'], $ruta_inicio, 'w-100', 'Imágen', 'required', false, false, '[]', $key, $_POST['id_articulo_mod']);
        //$_SESSION['id_lang_mod'].';'.$_SESSION['id_articulo_mod'].';'.
        $out2 .= '</div></div>';
        $contout++;
    }
}
//LISTADO________________________________________________________________________

//POST-POST______________________________________________________________________

//POST-POST______________________________________________________________________
include_once('inc/cabecera.inc.php'); //cargando cabecera 
?>

<body>
<?php include_once('inc/franja_top.inc.php'); ?>
    <div class="container-disabled">
        <div class="row">
            <div class="col-md-12">
                <form method="post" class="mt-3" enctype="multipart/form-data">
                    <div id="alertas-admin" class="d-flex flex-column">
                        <?php
                            if(count($str_error)>0) foreach ($str_error as $value) { echo $hM->get_alert_danger($value); }
                            else if($str_info) foreach ($str_info as $value) { echo $hM->get_alert_success($value); }
                        ?>
                    </div>
                    <div class="form-row">
                        <?php echo $iM->get_select('tipo_tienda', $producto['tipo_tienda'], $arrTipoTienda, 'form-control', 'Tipo tienda', false, false, 'form-group col-md-6'); ?>
                        <?php echo $iM->get_select('categorias', $producto['categoria'], $arrCategorias, 'form-control', 'Categorias', false, false, 'form-group col-md-6'); ?>
                        <?php echo $iM->get_input_radio('activo', $producto['activo'], $arrActivo, 'w-100 label-lg', 'Activo', false, false, 'form-group col-md-3'); ?>
                        <?php echo $iM->get_input_number('stock', $producto['stock'], 'form-control', 'Stock', 'Stock', '', 1, 100, 'int', false, 'form-group col-md-3'); ?>
                        <?php echo $iM->get_input_number('precio', $producto['precio'], 'form-control', 'Precio', 'Precio', '', 0, 100, 'centesimal', false, 'form-group col-md-3'); ?>
                        <?php echo $iM->get_input_number('iva', $producto['iva'], 'form-control', 'IVA', 'IVA', '', 0, 100, 'centesimal', false, 'form-group col-md-3'); ?>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php echo $out1; ?>
                    </ul>
                    <div class="tab-content" id="border-admin">
                        <?php echo $out2; ?>
                    </div>
                    <div class="form-row mt-2">
                        <button type="submit" name="<?php echo ($id_articulo_mod!=false ? 'editArticulo' : 'addArticulo'); ?>" class="btn btn-info btn-block"><?php echo ($id_articulo_mod!=false ? 'Editar articulo' : 'Añadir articulo'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>