<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');
$sM = load_model('seo');
$uM->control_sesion($ruta_inicio, ADMIN);


$arrCategorias = array();
$outProd = '';
$lang = (isset($_POST['lang']) ? $_POST['lang'] : 1);
$tipo_tienda = (isset($_POST['tipo_tienda']) ? $_POST['tipo_tienda'] : 0);
$arrTipoTienda = array(
    '0' => 'Todos',
    '1' => 'Experiencia',
    '2' => 'Directo farmacia'
);
//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

//LISTADO_______________________________________________________________________
$rgc = $aM->get_categorias(1);//1 es español
if($rgc){
    while($frgc = $rgc->fetch_assoc()){
        $arrCategorias = array_merge($arrCategorias, array($frgc['id_categoria']=>$frgc['nombre_categoria']));
    }
}
$rgaa = $aM->get_all_articulos(false, $lang, $tipo_tienda, false, false);
if($rgaa){
    while($frgaa = $rgaa->fetch_assoc()){
        /* echo '<pre>';
        print_r($frgaa);
        echo '</pre>'; */
        $outProd .= '<tr>
        <th scope="row">'.$frgaa['id_articulo'].'</th>
        <td>'.$frgaa['nombre'].'</td>
        <td><form method="post" action="'.$ruta_inicio.'admin-productos.php">
        <input name="id_lang_mod" value="'.$lang.'" hidden>
        <input name="id_tipo_tienda_mod" value="'.$tipo_tienda.'" hidden>
        <input name="id_articulo_mod" value="'.$frgaa['id_articulo'].'" hidden>
        <button type="submit" class="btn btn-outline-info">Modificar</button>
        </form></td>
        <td>';
        if($frgaa['activo']==0) $outProd .= '<span class="badge badge-danger">Desactivado</span>';
        else $outProd .= '<span class="badge badge-success">Activado</span>';
        $outProd .= '</td>
        </tr>';
    }
}
//LISTADO________________________________________________________________________

//POST-POST______________________________________________________________________

//POST-POST______________________________________________________________________
echo $sM->add_cabecera($ruta_inicio, '', 'admin'); 
?>

<body>
<?php include_once('inc/franja_top.inc.php'); ?>
    <div class="container-disabled">
        <div class="row mt-3">
            <div class="col-md-12">
                <form method="post" class="form-row">
                    <?php echo $iM->get_select('lang', $lang, $arrlang, 'form-control', 'Lenguaje', 'onchange="this.form.submit()"', false, 'form-group col-md-6'); ?>
                    <?php echo $iM->get_select('tipo_tienda', $tipo_tienda, $arrTipoTienda, 'form-control', 'Tipo tienda', 'onchange="this.form.submit()"', false, 'form-group col-md-6'); ?>
                </form>
                <div class="table-responsive-md">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Opción</th>
                                <th scope="col">Activado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $outProd; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>