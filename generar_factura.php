<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario');
$aM = load_model('articulos');
$cM = load_model('carrito');
$pdfM = load_model('fpdf');

if (!isset($_SESSION['id_tipo_usuario'])) { //si hay login
    header('Location: '.$ruta_inicio.'login');
}

$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';

//GET__________________________________________________________________________
$id_pedido = (isset($_REQUEST['id_pedido'])) ? $_REQUEST['id_pedido'] : '';

//1- verificar que el pedido pertenece al usuario

//2- hay factura solo si es de experiencias
$rgdpu = $uM->get_datos_pedido($id_pedido);

if ($rgdpu) {

    //el pedido debe existir y estar pagado
    if ($rgdpu->num_rows < 1) { header('Location: '.$ruta_inicio.'index.php'); exit(); }

    $data = array('iduser', 'fullname', 'email');
    while($fgdpu = $rgdpu->fetch_assoc()) {
        
        if ($fgdpu['id_usuario'] != $id_usuario) { header('Location: '.$ruta_inicio.'index.php'); exit(); }

        //echo '<pre>'.print_r($fgdpu).'</pre><br>';

        /*
        $d['fecha'] = '';
        $d['fullname'] = 'fullname';
        $d['nombre_direccion'] = 'nombre direccion';
        $d['dni'] = 'dni';
        $d['direccion'] = 'direccion';
        $d['telf'] = 'telf';
        $d['poblacion'] = 'poblacion';
        $d['codigo_postal'] = '';
        $d['email'] = 'email';
        $d['provincia'] = '';
        */

        $d['fecha'] = mysql_to_date($fgdpu['fecha_compra']);
        $d['fullname'] = $fgdpu['nombre'].' '.$fgdpu['apellidos'];
        $d['nombre_direccion'] = $fgdpu['nombre_usuario'];
        $d['direccion'] = $fgdpu['direccion_entrega'];
        $d['telf'] = $fgdpu['movil'];
        $d['poblacion'] = $fgdpu['poblacion'];
        $d['codigo_postal'] = $fgdpu['codigo_postal'];
        $d['email'] = $fgdpu['email_usuario'];
        //$d['provincia'] = 

        //echo '<pre>'.print_r($d).'</pre><br>';

        /*
        Array ( 
            [id_pedido] => 201 
            [id_usuario] => 28 
            [nombre] => asd 
            [apellidos] => sasa 
            [direccion] => sss 
            [codigo_postal] => sss 
            [poblacion] => ss 
            [movil] => sssssss 
            [fecha_compra] => 2019-03-30 09:36:32 
            [completado] => 1 
            [email_usuario] => dani.martinez@adstorm.es 
            [password_usuario] => 123456 
            [id_tipo_usuario] => 1 
            [deleted] => 0 
            [nombre_usuario] => beta 
            [apellidos_usuario] => AdStorm 
            [direccion_entrega] => 
            //[direccion_facturacion] => 
            [edad_usuario] => 0 
            [randomkey] => H6O2xcrlHEBH3TCIZzSwZmPO 
            [genero] => M [terminos_legales] => 0 
        )
        */

        $pdfM->set_url_img($ruta_inicio.'/img/');
        $rgfp = $pdfM->generar_factura_pdf($ruta_inicio, $id_pedido, $d);
        
        if ($rgfp) {
            //TODO OK :)
        } else {
            //control de errores
                //no se ha podido generar el documento pdf
        }
    }

} else { header('Location: '.$ruta_inicio.'index.php'); exit(); }
/*
$rgppbf = $pM->get_propietario_pedido_by_factura($id_pedido, true);
if ($rgppbf) {
    
    if ($rgppbf->num_rows < 1) { header('Location: '.$ruta_inicio.'index.php'); exit(); }
    
    $data = array('iduser', 'fullname', 'email');
    while ($fgppbf = $rgppbf->fetch_assoc()) {
        $data['iduser'] = $fgppbf['id_usuario'];
        $data['fullname'] = utf8_decode($fgppbf['fullname']);
        $data['dni'] = utf8_decode($fgppbf['nie_usuario']);
        $data['telf'] = utf8_decode($fgppbf['mobilephone']);
        $data['email'] = utf8_decode($fgppbf['email']);
    }
    
    $pdfM->set_url_img($ruta_inicio.'/img/');
    $rgfp = $pdfM->generar_factura_pdf($ruta_inicio, $factura_pedido, $data);
    
    if ($rgfp) {
        //TODO OK :)
    } else {
        //control de errores
            //no se ha podido generar el documento pdf
    }

} else { header('Location: '.$ruta_inicio.'index.php'); exit(); }
*/
?>