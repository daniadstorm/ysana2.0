<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
/* echo '<pre>';
print_r($_SESSION);
echo '</pre>'; */
if(isset($_GET['id_lang']) && isset($_GET['id_articulo'])){
    foreach ($arrlang as $key => $value) {
        if($value==$_GET['id_lang']){
            $nombre_img = "";
            $rgil = $aM->get_img_lang($_GET['id_articulo'], $key);
            if($rgil){
                while($frgil = $rgil->fetch_assoc()){
                    $nombre_img = $frgil['img'];
                }
                $ruil = $aM->update_img_lang($_GET['id_articulo'], $key);
                if($ruil){
                    //$json = json_encode("{status: success, data: null}");
                    echo json_encode("{status: success, data: null}");
                    if($nombre_img!=""){
                        unlink($document_root.'img/productos/'.$nombre_img);
                    }
                }
            }
        }
    }
}
    /* $json = json_encode("{status: success, data: null}");
    session_start();
    if(isset($_GET['del']) && isset($_GET['nombre_array'])){
        $fichero = $_GET['del'];
        $nombre_array = $_GET['nombre_array'];
        $ruta_fichero = 'img/productos/'.$fichero;
        if(file_exists($ruta_fichero)){
            for($i=0;$i<count($_SESSION[$nombre_array]);$i++){
                if($ruta_fichero==$_SESSION[$nombre_array][$i]){
                    //unset($_SESSION[$nombre_array][$i]);
                    //unlink($ruta_fichero);
                    echo $json;
                }
            }
        }
    } */
?>