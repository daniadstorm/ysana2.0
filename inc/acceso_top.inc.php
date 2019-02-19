<?php
//COMPROBACION
$array = explode('/', $_SERVER['PHP_SELF']);
$nombre_fichero = array_pop($array);
//COMPROBACION

/* $str = '<div class="menu_top"> <a href="login.php" class="';
($nombre_fichero=="login.php") ? $str .= 'bg_salmon tipogr_blanca' : $str .='bg_gris tipogr_negra';
$str .= '">INICIA SESIÓN</a><a href="new-account.php" class="';
($nombre_fichero=="login.php") ? $str .= 'bg_gris tipogr_negra' : $str .='bg_salmon tipogr_blanca';
$str .= '">REGISTRARSE</a><div style="clear:both;"></div></div>';
 */

 $str = '<div class="container">
     <div class="row">
         <div class="col-md-6"><a href="login.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">INICIAR SESIÓN</a></div>
         <div class="col-md-6"><a href="new-account.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">REGISTRARSE</a></div>
     </div>
 </div>';
echo $str;
?>