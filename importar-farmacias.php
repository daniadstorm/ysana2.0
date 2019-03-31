<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$fM = load_model('farmacias');
$iM = load_model('inputs');
$hM = load_model('html');
$sM = load_model('seo');
$uM->control_sesion($ruta_inicio, ADMIN);

/* echo '<pre>';
print_r($_POST);
print_r($producto);
echo '</pre>'; */
$farmacias = array();
$out = '';
$str_info = array();
$str_error = array();
//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________
if(isset($_POST['verFarmacias'])){
    $farmacias = $fM->get_farmacias_importbbdd($ruta_inicio);
    foreach ($farmacias as $key => $value) {
        $out .= '<tr>
        <th scope="row">'.$key.'</th>
        <td>'.$value['nombrecompleto_farmacia'].'</td>
        <td>'.$value['direccion_farmacia'].'</td>
        <td>'.$value['codigopostal_farmacia'].'</td>
        <td>'.$value['poblacion_farmacia'].'</td>
        <td>'.$value['provincia_farmacia'].'</td>
        <td><a target="_blank" href="'.$value['link_gmaps_farmacia'].'" class="btn btn-outline-info">Info</a></td>
    </tr>';
    }
}
if(isset($_POST['importarFarmacias'])){
    $farmacias = $fM->get_farmacias_importbbdd($ruta_inicio);
    foreach ($farmacias as $key => $value) {
        $raf = $fM->add_farmacia($value['nombrecompleto_farmacia'], $value['direccion_farmacia'], $value['codigopostal_farmacia'], $value['poblacion_farmacia'], $value['provincia_farmacia'], $value['link_gmaps_farmacia'], $value['link_embed_farmacia']);
        if(!$raf){
            array_push($str_error, "Error al insertar farmacia #".$key);
        }
    }
}
if(isset($_POST['deleteFarmacias'])){
    $rdf = $fM->delete_farmacias();
    if($rdf){
        $rrf = $fM->reset_farmacias();
        array_push($str_info, "Farmacias eliminadas correctamente");
    }
}
if(isset($_POST['subirFichero'])){
    $ruta_total = $document_root.'farmacias/farmacias.csv';
    if($_FILES['inputFichero']['type']=="application/vnd.ms-excel"){
        if(move_uploaded_file($_FILES['inputFichero']['tmp_name'], $ruta_total)){
            array_push($str_info, "Fichero subido correctamente");
        }else{
            array_push($str_error, "Error al subir el fichero");
        }
    }else{
        array_push($str_error, "Extensión no admitida, solo .csv");
    }
}
//POST__________________________________________________________________________

//LISTADO_______________________________________________________________________

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
                <div id="alertas-admin" class="d-flex flex-column mt-3">
                    <?php
                        if(count($str_error)>0) foreach ($str_error as $value) { echo $hM->get_alert_danger($value); }
                        else if($str_info) foreach ($str_info as $value) { echo $hM->get_alert_success($value); }
                    ?>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="inputFichero" required class="custom-file-input" id="inputGroupFile04">
                            <label class="custom-file-label" for="inputGroupFile04">Seleccionar fichero</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" name="subirFichero" type="submit">Subir fichero</button>
                        </div>
                    </div>
                </form>
                <form method="post">
                    <button type="submit" name="deleteFarmacias" class="btn btn-outline-danger btn-block mt-3">Borrar farmacias</button>
                </form>
                <form method="post">
                    <button type="submit" name="importarFarmacias" class="btn btn-outline-success btn-block mt-3">Importar farmacias</button>
                </form>
                <form method="post">
                    <button type="submit" name="verFarmacias" class="btn btn-outline-info btn-block mt-3">Ver farmacias</button>
                </form>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Codigo postal</th>
                            <th scope="col">Poblacion</th>
                            <th scope="col">Provincia</th>
                            <th scope="col">Link GMaps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $out; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>