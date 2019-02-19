<?php
/* RUTAS */
//-------------------------------------------------------------------------------------

$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$base = "http://" . $host . $uri . "/";
//$ruta_inicio = 'http://localhost/ysana-dashboard/';
//$ruta_archivos = 'http://localhost/ysana-dashboard/';
$ruta_inicio = 'https://ysana.es/ysana-dashboard/';
$ruta_archivos = 'https://ysana.es/ysana-dashboard/';
//$document_root = $_SERVER['DOCUMENT_ROOT'].'/';
$document_root = $_SERVER['DOCUMENT_ROOT'].'/ysana-dashboard/';
//====================================================================================

/* CONSTANTES */
//-------------------------------------------------------------------------------------
define('DOCUMENT_ROOT', $document_root);
define('ADMIN', 1);
define('USER', 10);

define('GOOGLE_API_KEY', 'AIzaSyD2JKXHoHoz65hcwQemnoPGsQJ04gz85EE');

define('REQ_FIELD', 'Campo requerido');
define('EMPTY_DATE', '1970-01-01');
//-------------------------------------------------------------------------------------

/* LIBRERIA DE FUNCIONES */
//-------------------------------------------------------------------------------------
include_once(DOCUMENT_ROOT.'func/func.inc.php');
//====================================================================================

/* LIBRERIA DE BD */
//-------------------------------------------------------------------------------------
include_once(DOCUMENT_ROOT.'model/model.class.php');
$rootM = new Model(); //rootModel; supervariable raiz de modelo
//====================================================================================

/* INICIO DE SESION */
//-------------------------------------------------------------------------------------
if(!isset($_SESSION)) session_start();
//====================================================================================

/* CONFIGURANDO LENGUAJE */
//-------------------------------------------------------------------------------------
//castellano asignado por defecto doblemente
//lang = el nombre del lenguaje
//lng = array de textos
if (isset($_POST['idioma_seleccionado'])) $_SESSION['lang'] = $_POST['idioma_seleccionado'];
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'cast';
switch ($lang) {
    default:
    case 'cast':        include_once(DOCUMENT_ROOT.'lang/lang.cast.php');   break; //por defecto cast
    case 'eng':         include_once(DOCUMENT_ROOT.'lang/lang.eng.php');    break; 
    case 'cat':         include_once(DOCUMENT_ROOT.'lang/lang.cat.php');    break;
    case 'fra':         include_once(DOCUMENT_ROOT.'lang/lang.fra.php');    break;
}
//====================================================================================
?>