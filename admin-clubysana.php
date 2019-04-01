<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$iM = load_model('inputs');
$hM = load_model('html');
$cyM = load_model('clubysana');
$sM = load_model('seo');
$uM->control_sesion($ruta_inicio, ADMIN);

$filtro_idioma = (isset($_POST['filtr_idioma']) ? $_POST['filtr_idioma'] : 1);
$outExperiencias = '';
$outDatosExp = '';
$arrDatos = array();
$arrDatosInfo = array();
$arrDatosInfo1 = array();
$arrDatosInfo2 = array();
$arrDatos1 = array();
$arrDatos2 = array();
$str_info = array();
$str_error = array();
$datosFijo = array(
    'titulo1' => '',
    'titulo2' => '',
    'col1' => '',
    'col2' => ''
);
/* echo '<pre>';
print_r($_POST);
print_r($_FILES);
echo '</pre>'; */
//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________
if(isset($_POST['updateInfoExp'])){
    $ruie = $cyM->update_info_experiencias($_POST['id_info'], $_POST['titulo'], $_POST['col1'], $_POST['col2']);
    if($ruie){
        array_push($str_info, "Info experiencia insertada correctamente");
    }else array_push($str_error, "Info experiencia no insertada");
}
if(isset($_POST['addInfoExp'])){
    $rai = $cyM->add_infoexperiencia($_POST['experiencia'], $_POST['titulo1'], $_POST['col1'], $_POST['col2']);
    if($rai){
        $id_info = $cyM->get_insert_id();
        for ($i=0;$i<count($_POST['titulo-slider']);$i++) {
            if($_FILES['img']!=""){//Si está vacio es que no ha insertado ninguna imagen por lo tanto no hace las siguientes comprobaciones
                $imagenInfo = getimagesize($_FILES['img']['tmp_name'][$i]);//Saca el mime "type" pero que no se puede modificar
                if ($imagenInfo['mime']=='image/png' || $imagenInfo['mime']=='image/jpeg') {//Si tiene una de las siguientes extensiones es que es imagen
                    $res = move_uploaded_file($_FILES['img']['tmp_name'][$i],$document_root.'img/clubysana/'.$_FILES['img']['name'][$i]);
                    if($res){
                        $ras = $cyM->add_sliderinfoexperiencia($id_info ,$_POST['titulo-slider'][$i], $_POST['descripcion-slider'][$i], $_FILES['img']['name'][$i], $_POST['url_enlace'][$i]);
                        if($ras){
                            array_push($str_info, "Experiencia insertada correctamente - ".$i);
                        } else array_push($str_error, "Experiencia no insertada");
                    } else array_push($str_error, "Imágen no guardada");
                } else array_push($str_error, "El archivo no es de tipo imagen - ");
            }
        }
        //array_push($str_info, "Experiencia insertada correctamente");
    }else array_push($str_error, "Error al añadir experiencia");
}
if(isset($_POST['addExp'])){
    if($_FILES['img']!=""){//Si está vacio es que no ha insertado ninguna imagen por lo tanto no hace las siguientes comprobaciones
        $imagenInfo = getimagesize($_FILES['img']['tmp_name']);//Saca el mime "type" pero que no se puede modificar
        if ($imagenInfo['mime']=='image/png' || $imagenInfo['mime']=='image/jpeg') {//Si tiene una de las siguientes extensiones es que es imagen
            $res = move_uploaded_file($_FILES['img']['tmp_name'],$document_root.'img/clubysana/'.$_FILES['img']['name']);
            if($res){
                $rae = $cyM->add_experiencia($_POST['titulo'], $_FILES['img']['name'], $_POST['urlseo'], $_POST['idioma_select']);
                if($rae) array_push($str_info, "Experiencia insertada correctamente");
                else array_push($str_error, "Experiencia no insertada");
            } else array_push($str_error, "Imágen no guardada");
        } else array_push($str_error, "El archivo no es de tipo imagen - ");
    }
}
if(isset($_POST['delExp'])){
    $rde = $cyM->delete_experiencia($_POST['delExp']);
    if($rde){
        array_push($str_info, "Experiencia eliminada correctamente");
    }else array_push($str_error, "Experiencia no eliminada");
}
if(isset($_POST['delDatosExp'])){
    $rde = $cyM->delete_datos_experiencia($_POST['delDatosExp']);
    if($rde){
        array_push($str_info, "Experiencia eliminada correctamente");
    }else array_push($str_error, "Experiencia no eliminada");
}
if(isset($_POST['datosaddExp'])){
    if($_FILES['img']!=""){//Si está vacio es que no ha insertado ninguna imagen por lo tanto no hace las siguientes comprobaciones
        $imagenInfo = getimagesize($_FILES['img']['tmp_name']);//Saca el mime "type" pero que no se puede modificar
        if ($imagenInfo['mime']=='image/png' || $imagenInfo['mime']=='image/jpeg') {//Si tiene una de las siguientes extensiones es que es imagen
            $res = move_uploaded_file($_FILES['img']['tmp_name'],$document_root.'img/clubysana/'.$_FILES['img']['name']);
            if($res){
                $rae = $cyM->add_datos_experiencia($_POST['experiencia'], $_POST['titulo'], $_FILES['img']['name'], $_POST['urlseo'], $_POST['idioma_select']);
                if($rae){
                    array_push($str_info, "Dato insertado correctamente");
                } else array_push($str_error, "Dato no insertado");
            } else array_push($str_error, "Imágen no guardada");
        } else array_push($str_error, "El archivo no es de tipo imagen - ");
    }
}
if(isset($_POST['updateExp'])){
    if($_FILES['img']['name']!=""){
        $imagenInfo = getimagesize($_FILES['img']['tmp_name']);//Saca el mime "type" pero que no se puede modificar
        if ($imagenInfo['mime']=='image/png' || $imagenInfo['mime']=='image/jpeg') {//Si tiene una de las siguientes extensiones es que es imagen
            $res = move_uploaded_file($_FILES['img']['tmp_name'],$document_root.'img/clubysana/'.$_FILES['img']['name']);
            if($res){
                $rue = $cyM->update_experiencias($_POST['id_exp'], $_POST['nombre'], $_FILES['img']['name'], $_POST['urlseo'], $filtro_idioma);
                if($rue) array_push($str_info, "Actualizado correctamente");
                else array_push($str_error, "Error al actualizar");
            } else array_push($str_error, "Imágen no guardada");
        } else array_push($str_error, "El archivo no es de tipo imagen - ");
    }else{
        $rue = $cyM->update_experiencias($_POST['id_exp'], $_POST['nombre'], $imagen=false, $_POST['urlseo'], $filtro_idioma);
        if($rue) array_push($str_info, "Actualizado correctamente");
        else array_push($str_error, "Error al actualizar");
    }
}
//POST__________________________________________________________________________

//LISTADO_______________________________________________________________________
$rge = $cyM->get_experiencias($filtro_idioma);
if($rge){
    while($frge = $rge->fetch_assoc()){
        $outExperiencias .= '<tr>
        <td class="align-middle text-center">'.$frge['titulo'].'</td>
        <td class="align-middle text-center">'.$frge['urlseo'].'</td>
        <td><img src="'.$ruta_inicio.'img/clubysana/'.$frge['imagen'].'" class="rounded mx-auto d-block mw-150"></td>
        <td class="btn-opciones-cy"><form method="post"><input name="delExp" value="'.$frge['id_experiencia'].'" hidden><button type="button" name="delDatosExp" data-toggle="modal" data-target="#datoedit-'.$frge['id_experiencia'].'" class="btn btn-outline-info crs-pointer mr-1"><img src="https://img.icons8.com/metro/26/000000/edit-property.png" width="16px"></button>        
        <button type="submit" class="btn btn-outline-danger"><img src="https://img.icons8.com/windows/32/000000/cancel.png" width="16px"></button></form></td></tr>';
        $outExperiencias .= '<div class="modal fade" id="datoedit-'.$frge['id_experiencia'].'" tabindex="-1" role="dialog" aria-labelledby="datoedit-'.$frge['id_experiencia'].'Label" aria-hidden="true">
        <div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">
        <h5 class="modal-title" id="datoedit-'.$frge['id_experiencia'].'Label">'.$frge['titulo'].'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><form method="post" enctype="multipart/form-data"><div class="form-row">';
        $outExperiencias .= $iM->get_input_hidden('id_exp', $frge['id_experiencia']);
        $outExperiencias .= $iM->get_input_text('nombre', $frge['titulo'], 'form-control', 'Nombre', 'Nombre', '', false, false, false, 'form-group col-md-12');
        $outExperiencias .= $iM->get_input_text('urlseo', $frge['urlseo'], 'form-control', '', 'URL', '', false, false, false, 'form-group col-md-6');
        $outExperiencias .= '<div class="form-group col-6"><div class="custom-file">
            <input type="file" name="img" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Seleccionar imágen</label></div></div>';

        $outExperiencias .= '</div></div><div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="updateExp" class="btn btn-primary">Guardar</button></div></div></div></div></form>';

        $outDatosExp .= '<ul class="list-group mx-2">
        <li class="list-group-item list-group-item-action list-group-item-dark">'.$frge['titulo'].'</li>';
        array_push($arrDatos1, $frge['id_experiencia']);
        array_push($arrDatos2, $frge['titulo']);
        $rgdle = $cyM->get_datos_leftjoin_experiencias();
        if($rgdle){
            while($frgde = $rgdle->fetch_assoc()){
                if($frge['id_experiencia']==$frgde['id_experiencia']){
                    array_push($arrDatosInfo1, $frge['titulo'].' - '.$frgde['titulo']);
                    array_push($arrDatosInfo2, $frgde['id_datoexperiencia']);
                }
            }
        }
        $rgde = $cyM->get_datos_experiencias();
        if($rgde){
            while($frgde = $rgde->fetch_assoc()){
                if($frge['id_experiencia']==$frgde['id_experiencia']){
                    //array_push($arrDatosInfo1, $frge['titulo'].' - '.$frgde['titulo']);
                    //array_push($arrDatosInfo2, $frgde['id_datoexperiencia']);
                    $outDatosExp .= '<li class="list-group-item">'.$frgde['titulo'].' <button type="button" name="delDatosExp" data-toggle="modal" data-target="#dato-'.$frgde['id_datoexperiencia'].'" class="btn btn-outline-info crs-pointer mr-1"><img src="https://img.icons8.com/metro/26/000000/edit-property.png" width="16px"></button>';
                    $outDatosExp .= '<form method="post" class="d-inline-block m-0"><button type="submit" value="'.$frgde['id_datoexperiencia'].'" name="delDatosExp" class="btn btn-outline-danger crs-pointer"><img src="https://img.icons8.com/windows/32/000000/cancel.png" width="16px"></button></form></li>';
                    $outDatosExp .= '<div class="modal fade bd-example-modal-lg" id="dato-'.$frgde['id_datoexperiencia'].'" tabindex="-1" role="dialog" aria-labelledby="dato-'.$frgde['id_datoexperiencia'].'Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header">
                    <h5 class="modal-title" id="dato-'.$frgde['id_datoexperiencia'].'Label">'.$frge['titulo'].' - '.$frgde['titulo'].'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><form method="post"><div class="form-row">';
                    $rgie = $cyM->get_info_experiencias($frgde['id_datoexperiencia']);
                    if($rgie){
                        while($frgie = $rgie->fetch_assoc()){
                            $outDatosExp .= $iM->get_input_hidden('id_info', $frgde['id_datoexperiencia']);
                            $outDatosExp .= $iM->get_input_text('titulo', $frgie['titulo'], 'form-control', 'Titulo', 'Titulo', '', false, false, false, 'form-group col-md-12');
                            $outDatosExp .= $iM->get_input_textarea('col1', $frgie['texto_columna1'], 'form-control', 'Columna 1', 'Columna 1', '', false, false, false, 6, 'form-group col-md-6');
                            $outDatosExp .= $iM->get_input_textarea('col2', $frgie['texto_columna2'], 'form-control', 'Columna 2', 'Columna 2', '', false, false, false, 6, 'form-group col-md-6');
                            /* SLIDER */
                            $rgse = $cyM->get_sliders_experiencias($frgde['id_datoexperiencia']);
                            if($rgse){
                                $outDatosExp .= '<div class="slider-admin w-100">';
                                while($frgse = $rgse->fetch_assoc()){
                                    $outDatosExp .= '<div class="form-row my-1"><div class="col-3">
                                    <input type="text" name="titulo-slider[]" value="'.$frgse['titulo'].'" class="form-control" placeholder="Nombre" required></div>
                                    <div class="col-4">
                                    <input type="text" name="descripcion-slider[]" value="'.$frgse['descripcion'].'" class="form-control" placeholder="Descripcion" required></div>
                                    <div class="col-4"><div class="custom-file">
                                    <input type="file" name="img[]" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Seleccionar imágen</label></div></div></div>';
                                }
                                $outDatosExp .= '</div>';
                            }
                        }
                    }
                    $outDatosExp .= '</div></div><div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="updateInfoExp" class="btn btn-primary">Guardar</button></div></div></div></div></form>';
                }
            }
        }
        $outDatosExp .= '</ul>';
    }
    $arrDatos = array_combine($arrDatos1, $arrDatos2);
    $arrDatosInfo = array_combine($arrDatosInfo2, $arrDatosInfo1);
}
if(isset($arrlang)){
    foreach ($arrlang as $value => $key){
        /* $out1 .= '<li class="nav-item ysana">
        <a class="nav-link '.(($contout==0) ? 'active' : '').'" id="'.$key.'-tab" data-toggle="tab" href="#'.$key.'" role="tab" aria-controls="'.$key.'" aria-selected="true">'.$key.'</a></li>';
        $out2 .= '<div class="tab-pane fade '.(($contout==0) ? 'show active' : '').'" id="'.$key.'" role="tabpanel" aria-labelledby="'.$key.'-tab">';
        $out2 .= '<div class="form-row">';
        $out2 .= $iM->get_input_hidden('id_articulo_mod', $id_articulo_mod);
        $out2 .= $iM->get_input_hidden('id_tipo_tienda_mod', $id_tipo_tienda_mod);
        $out2 .= $iM->get_input_text('nombre', $producto[$key]['nombre'], 'form-control', 'Nombre', 'Nombre', '', false, false, false, 'form-group col-md-6', false, '['.$key.']');
        $out2 .= $iM->get_input_text('urlseo', $producto[$key]['urlseo'], 'form-control', 'URL', 'url-producto', '', false, false, false, 'form-group col-md-6', false, '['.$key.']');
        $out2 .= $iM->get_input_text('titulo', $producto[$key]['titulo'], 'form-control', 'Titulo', 'Titulo', '', false, false, false, 'form-group col-md-12', false, '['.$key.']');
        $out2 .= $iM->get_input_textarea('descripcion', $producto[$key]['descripcion'], 'form-control', 'Descripción', 'Descripción', '', false, false, false, 3, 'form-group col-md-12', '['.$key.']');
        $out2 .= $iM->get_input_img('imagen'.$key, $producto[$key]['imagen'], $ruta_inicio, 'w-100', 'Imágen', 'required', false, false, '[]', $key, $_POST['id_articulo_mod']);
        $out2 .= '</div></div>';
        $contout++; */
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
        <div class="row">
            <div class="col-md-12">
                <div class="mt-3">
                    <div id="alertas-admin" class="d-flex flex-column">
                        <?php
                            if(count($str_error)>0) foreach ($str_error as $value) { echo $hM->get_alert_danger($value); }
                            else if($str_info) foreach ($str_info as $value) { echo $hM->get_alert_success($value); }
                        ?>
                    </div>
                    <form action="" method="post" class="mb-0">
                        <?php echo $iM->get_select('filtr_idioma', $filtro_idioma, $arrlang, 'form-control', 'Filtrar todo por idioma:', 'onchange="this.form.submit()"', false, 'form-group col-3'); ?>
                    </form>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-link-cy" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Experiencias
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <form class="mb-3" method="post" enctype="multipart/form-data">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-3">
                                                <input type="text" name="titulo" class="form-control" placeholder="Nombre" required>
                                            </div>
                                            <div class="form-group col-3">
                                                <input type="text" name="urlseo" class="form-control" placeholder="Url-seo" required>
                                            </div>
                                            <div class="form-group col-3">
                                                <div class="custom-file">
                                                    <input type="file" name="img" class="custom-file-input" id="customFile" required>
                                                    <label class="custom-file-label" for="customFile">Seleccionar imágen</label>
                                                </div>
                                            </div>
                                                <?php echo $iM->get_select('idioma_select', $filtro_idioma, $arrlang, 'form-control', '', false, false, 'form-group col-3'); ?>
                                            <div class="col-4 offset-4">
                                                <button type="submit" name="addExp" class="btn btn-block btn-outline-info">Añadir experiencia</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-bordered">
                                        <!-- <thead>
                                            <td colspan="4">
                                                <form action="" method="post" class="mb-0">
                                                    <?php echo $iM->get_select('filtr_idioma', $filtro_idioma, $arrlang, 'form-control', '', 'onchange="this.form.submit()"', false, 'form-group col-3 mb-0'); ?>
                                                </form>
                                            </th>
                                        </thead> -->
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">URL</th>
                                                <th scope="col">Imágen</th>
                                                <th scope="col">Opciónes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $outExperiencias; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-link-cy collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Datos de experiencias
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <form class="mb-3" method="post" enctype="multipart/form-data">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-4">
                                                <input type="text" name="titulo" class="form-control" placeholder="Titulo" required>
                                            </div>
                                            <?php echo $iM->get_select('experiencia', '', $arrDatos, 'form-control', '', false, false, 'form-group col-4'); ?>
                                            <div class="form-group col-4">
                                                <input type="text" name="urlseo" class="form-control" placeholder="Url-seo" required>
                                            </div>
                                            <div class="form-group col-4">
                                                <div class="custom-file">
                                                    <input type="file" name="img" class="custom-file-input" id="customFile" required>
                                                    <label class="custom-file-label" for="customFile">Seleccionar imágen</label>
                                                </div>
                                            </div>
                                            <?php echo $iM->get_select('idioma_select', $filtro_idioma, $arrlang, 'form-control', '', false, false, 'form-group col-4'); ?>
                                            <div class="form-group col-4">
                                                <button type="submit" name="datosaddExp" class="btn btn-block btn-outline-info">Añadir dato</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- <form action="" method="post">
                                        <div class="form-row">
                                            <?php echo $iM->get_select('filtr_idioma', $filtro_idioma, $arrlang, 'form-control', 'Filtrar por idioma:', 'onchange="this.form.submit()"', false, 'form-group mb-1 col-4'); ?>
                                        </div>
                                    </form> -->
                                    <div class="d-flex">
                                        <?php echo $outDatosExp; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-link-cy collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Información
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <?php if(count($arrDatosInfo)>0){ ?>
                                    <form action="" class="row" method="post" enctype="multipart/form-data">
                                        <?php echo $iM->get_select('experiencia', '', $arrDatosInfo, 'form-control', '', false, false, 'form-group col-12'); ?>
                                        <?php echo $iM->get_input_text('titulo1', $datosFijo['titulo1'], 'form-control', '', 'Titulo 1', '', false, false, false, 'form-group col-12'); ?>
                                        <?php //echo $iM->get_input_text('titulo2', $datosFijo['titulo2'], 'form-control', '', 'Titulo 2', '', false, false, false, 'form-group col-12'); ?>
                                        <?php echo $iM->get_input_textarea('col1', $datosFijo['col1'], 'form-control', '', 'Columna 1', '', false, false, false, 3, 'form-group col-6'); ?>
                                        <?php echo $iM->get_input_textarea('col2', $datosFijo['col2'], 'form-control', '', 'Columna 2', '', false, false, false, 3, 'form-group col-6'); ?>
                                        <div class="form-group col-12">
                                            <div class="d-flex justify-content-center my-2">
                                                <button id="addSlider" type="button" class="btn btn-outline-success">Añadir slider</button>
                                            </div>
                                            <div id="sliders" class="slider-admin"></div>
                                            <div class="d-flex justify-content-start my-2">
                                                <button id="addInfoExp" name="addInfoExp" type="submit" class="btn btn-outline-info">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <?php }else{
                                        echo 'No hay información para insertar';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
$("#addSlider").on('click', function(e){
    var fechaEnMiliseg = Date.now();
    $("#sliders").append(`<div id="`+fechaEnMiliseg+`" class="row my-1 position-relative my-3">
    <div class="col-6">
    <input type="text" name="titulo-slider[]" value="" class="form-control" placeholder="Nombre" required></div>
    <div class="col-6">
    <input type="text" name="descripcion-slider[]" value="" class="form-control" placeholder="Descripcion" required></div>
    <div class="col-6">
    <div class="custom-file">
    <input type="file" name="img[]" class="custom-file-input" id="customFile" required>
    <label class="custom-file-label" for="customFile">Seleccionar imágen</label>
    </div></div>
    <div class="col-6">
    <input type="text" name="url_enlace[]" value="" class="form-control" placeholder="URL Enlace" required></div>
    <span class="badge badge-danger crs-pointer del-slider centrar-btn-absoluto" type-id="`+fechaEnMiliseg+`">X</span>
    </div>`);
});
$("#sliders").on('click', '.del-slider', function(e){
    $("#"+$(this).attr("type-id")).remove();
});
</script>
</html>