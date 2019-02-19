<?php
$title = 'Ysana';
$meta_lang = $lang; //hacer switch con traduccion si necesario (o array)
$meta_desc = '';
$meta_kw = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html class="ag-toolbar" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="<?php echo $meta_lang; ?>" />
<meta http-equiv="Cache-control" content="no-cache" />
<meta name="description" content="<?php echo $meta_desc; ?>" />
<meta name="keywords" content="<?php echo $meta_kw; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<title><?php echo $title; ?></title>

<link rel="shortcut icon" href="<?php echo $ruta_archivos; ?>img/favicon/favicon.ico" />

<link rel="stylesheet" href="<?php echo $ruta_archivos; ?>css/jquery-ui.min.css" />
<script src="<?php echo $ruta_archivos; ?>js/external/jquery/jquery.js"></script>
<script src="<?php echo $ruta_archivos; ?>js/jquery-ui.min.js"></script>

<link type="text/css" href="<?php echo $ruta_archivos; ?>css/sesnines.css" rel="Stylesheet" />
<script type="text/javascript" src="<?php echo $ruta_archivos; ?>js/sesnines.js"></script>

<link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
<script type="text/javascript" src="js/colorpicker.js"></script>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script src="jquery.ui.datepicker-es.js"></script>


    
<script type="text/javascript">
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<script src="<?php echo $ruta_archivos; ?>js/facebook.js"></script>

<script type="text/javascript">
    
</script>
</head>