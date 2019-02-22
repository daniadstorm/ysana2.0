<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$aM = load_model('articulos');

/* echo '<pre>';
print_r($_REQUEST);
print_r($_SESSION);
echo '</pre>'; */

$consultaBusqueda = (isset($_REQUEST['valorBusqueda']) ? $_REQUEST['valorBusqueda'] : '');

//Filtro anti-xss
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("&lt;", "&gt;", "&quot;", "&#x27;", "&#x2F;", "&#060;", "&#062;", "&#039;", "&#047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

//GET___________________________________________________________________________
//GET___________________________________________________________________________
$arrDatos = array();
//POST__________________________________________________________________________
if(isset($consultaBusqueda)){
    $rbf = $aM->buscar_farmacia($consultaBusqueda);
    if($rbf){
        while($frbf = $rbf->fetch_assoc()){
            array_push($arrDatos, $frbf);
        }
    }
}
$jsonDatos = json_encode($arrDatos);
//print_r($jsonDatos);
header('Content-type: application/json; charset=utf-8');
echo $jsonDatos;
//POST__________________________________________________________________________

//LISTADO_______________________________________________________________________
//LISTADO________________________________________________________________________

//POST-POST______________________________________________________________________
//POST-POST______________________________________________________________________

?>