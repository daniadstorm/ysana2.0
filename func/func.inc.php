<?php
// de europeo a yanki
function date_to_mysql($date=false) { //dd-mm-YYYY => YYYY-mm-dd
    if (!$date) return '';
        else {
            $date = str_replace('/', '-', $date);
            return date("Y-m-d",strtotime($date));
        }
}
// de yanki a europeo
function mysql_to_date($date=false, $separador="-") { //YYYY-mm-dd => dd-mm-YYYY
    if (!$date) return false;
    else if ($date == '0000-00-00') return '';
        else return date("d".$separador."m".$separador."Y",strtotime($date));
}

function load_model($model){
    include_once(DOCUMENT_ROOT.'/model/'.$model.'.model.php');
    $class_name = $model.'Model';
    return new $class_name;
}

function generate_password($random_string_length) {
    
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $string = '';
    
    for ($i = 0; $i < $random_string_length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $string;
}

function combo_anyos($id, $selected=false, $class=false, $onChange=false) {
    $r = ''; //return
    
    $arr_i = array();
    for ($i=2018;$i<=(date('Y') + 2);$i++) {
        $arr_i []= $i;
    }
    
    /*
    $arr_i = array('2018', '2019', '2020', '2021', '2022', '2023', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    */
    $r .= '<select id="'.$id.'" name="'.$id.'" ';
    if ($class) $r .= ' class ="'.$class.'" ';
    if ($onChange) $r .= ' onchange="'.$onChange.'" ';
    $r .= '>';
    foreach ($arr_i as $key => $val) $r .= '<option '.(($selected == $val) ? ' selected="selected" ' : '').' value="'.$val.'">'.$val.'</option>';
    $r .= '</select>';
    
    return $r;
}

function combo_meses($id, $selected=false, $class=false, $onChange=false) {
    $r = ''; //return
    
    $arr_i = array('01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril', '05'=>'Mayo', '06'=>'Junio',
        '07'=>'Julio', '08'=>'Agosto', '09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre');
    
    $r .= '<select id="'.$id.'" name="'.$id.'" ';
    if ($class) $r .= ' class ="'.$class.'" ';
    if ($onChange) $r .= ' onchange="'.$onChange.'" ';
    $r .= '>';
    foreach ($arr_i as $key => $val) $r .= '<option '.(($selected == $key) ? ' selected="selected" ' : '').' value="'.$key.'">'.$val.'</option>';
    $r .= '</select>';
    
    return $r;
}

function combo_horas($id, $selected=false, $class=false) {
    $r = ''; //return
    
    $arr_h = array();
    for ($i = 0; $i<=23; $i++) {
        $aux_id = ($i < 10) ? '0'.$i : "$i";
        $arr_h[$aux_id] = $aux_id;
    }
    
    /*$arr_h = array(1 => '00', 2=>'01', 3=>'02', 4=>'03', 5=>'04', 6=>'05', 7=>'06', 8=>'07', 9=>'08', 10=>'09', 11=>'10', 
        12=>'11', 13=>'12', 14=>'13', 15=>'14', 16=>'15', 17=>'16', 18=>'17', 19=>'18', 20=>'19', 21=>'20', 22=>'21', 23=>'22', 24=>'23');*/
    
    $r .= '<select id="'.$id.'" name="'.$id.'" ';
    if ($class) $r .= ' class ="'.$class.'" ';
    $r .= '>';
    foreach ($arr_h as $key => $val) $r .= '<option '.(($selected == $val) ? ' selected="selected" ' : '').' value="'.$val.'">'.$val.'</option>';
    $r .= '</select>';
    
    return $r;
}

function combo_minutos($id, $selected=false, $class=false) {
    $r = ''; //return
    
    /*
    $arr_m = '';
    for ($i=0;$i<=55;$i=$i+5) {
        $aux_id = ($i < 10) ? '0'.$i : "$i";
        $arr_m[$aux_id] = $aux_id;
    }
    */
    
    $arr_m = array(1 => '00', 2=>'05', 3=>'10', 4=>'15', 5=>'20', 6=>'25', 7=>'30', 8=>'35', 9=>'40', 10=>'45', 11=>'50', 12=>'55');
    
    $r .= '<select id="'.$id.'" name="'.$id.'" ';
    if ($class) $r .= ' class ="'.$class.'" ';
    $r .= '>';
    foreach ($arr_m as $key => $val) $r .= '<option '.(($selected == $val) ? ' selected="selected" ' : '').' value="'.$val.'">'.$val.'</option>';
    $r .= '</select>';
    
    return $r;
}

function combo_idiomas($id, $selected=false, $class=false) {
    $r = ''; //return
    
    $arr_i = array('cast'=>'Castellano', 'cat'=>'Catal&aacute;', 'eng'=>'English', 'fra'=>'Francais');
    
    $r .= '<select id="'.$id.'" name="'.$id.'" ';
    if ($class) $r .= ' class ="'.$class.'" ';
    $r .= '>';
    foreach ($arr_i as $key => $val) $r .= '<option '.(($selected == $key) ? ' selected="selected" ' : '').' value="'.$key.'">'.$val.'</option>';
    $r .= '</select>';
    
    return $r;
}

function transformar_img($val, $new_w, $new_h, $pos_x, $pos_y, $factor, $final_w, $final_h) {
    
    //normalizando valores
    $new_w = $new_w / $factor;
    $new_h = $new_h / $factor;
    $pos_x = $pos_x / $factor;
    $pos_y = $pos_y / $factor;
    
    $partes_ruta = pathinfo($val);
    switch($partes_ruta['extension']) {
        case 'JPG':
        case 'jpg':
            $img_r = @imagecreatefromjpeg($val);
        break;
        case 'GIF':
        case 'gif':
            $img_r = @imagecreatefromgif($val);
        break;
        case 'PNG':
        case 'png':
            $img_r = @imagecreatefrompng($val);
        break;
        default:
            //
        break;
    }
    
    list($old_w, $old_h) = getimagesize($val);
    
    $dst_r = ImageCreateTrueColor($final_w, $final_h); //crea imagen con base negro (existe crearla en blanco, pero esta es  la recomendada por php.net)
    imagealphablending($dst_r, false); //asignando transparencia para los png
    imagesavealpha($dst_r, true); //asignando transparencia para los png
    
    $aux_w = ($old_w > $new_w) ? $new_w : $old_w;
    $aux_h = ($old_h > $new_h) ? $new_h : $old_h;
    
    imagecopyresized($dst_r, $img_r, 0, 0, $pos_x, $pos_y,$final_w, $final_h, $aux_w, $aux_h);

    $return = imagepng($dst_r, $val, 0); //guardar el archivo en la ruta; siempre es un png para conservar la transparencia en aquellos archivos que la tengan

    imagedestroy($dst_r); //liberar memoria
    imagedestroy($img_r); //liberar memoria
    
    return $return;
}

function get_url_filename($url) {
    list($aux1, $aux2, $filename) = explode('/', $url);
    return $filename;
}

function verificaremail($email){ 
    /*
    $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
    if (!preg_match($pattern,$name)) return FALSE;
        else return TRUE;
    */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return FALSE;
        else return TRUE;
}
?>