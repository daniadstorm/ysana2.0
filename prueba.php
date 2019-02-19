<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <pre>
    <?php
    include_once('config/config.inc.php'); //cargando archivo de configuracion
    /* print_r($productos); */
    
    $producto=$_GET['producto'];
    $existe=false;
    $i=0;
    $x=0;
    //comprobar si existe
    while(!$existe && $i<count($productos_ysana)){
        while(!$existe && $x<count($productos_ysana[$i]['productos_categoria'])){
            ($producto==$productos_ysana[$i]['productos_categoria'][$x]['url-seo']) ? $existe=true : '';
            //echo $productos_ysana[$i]['productos_categoria'][$x]['url-seo'].'<br>';
            $x++;
        }
        $x=0;
        $i++;
    }
    ?>
    <h1><?php echo ($existe) ? 'Si' : 'No'; ?></h1>
    
    
</body>
</html>