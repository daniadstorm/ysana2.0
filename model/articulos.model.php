<?php

class articulosModel extends Model {
    
    public $dir = 'imgart/';
    public $max_imagenes_articulo = 5;
    
    function add_articulo($nombre_articulo,$referencia_articulo,$referencia_proveedor_articulo,$descripcion_articulo,$activado_articulo, $visible_en_tienda_articulo,
        $precio_coste_articulo,$coste_externo_portes_articulo,$PVP_final_articulo,$margen_articulo,$inicio_descuento_articulo,$fin_descuento_articulo,
        $descuento_porcentaje_articulo,$descuento_euros_articulo,$cantidad_articulo, $almacen_articulo) {
        
        $q  = ' INSERT INTO '.$this->pre.'articulos (nombre_articulo, referencia_articulo, referencia_proveedor_articulo, descripcion_articulo, activado_articulo, ';
        $q .=   ' visible_en_tienda_articulo, precio_coste_articulo, coste_externo_portes_articulo, PVP_final_articulo, margen_articulo, cantidad_articulo, ';
        $q .=   ' inicio_descuento_articulo, fin_descuento_articulo, descuento_porcentaje_articulo, descuento_euros_articulo, almacen_articulo ) VALUES ';
        $q .= ' ("' . $nombre_articulo . '", "' . $referencia_articulo . '", "' . $referencia_proveedor_articulo . '", "' . $descripcion_articulo . '", ';
        $q .= ' "' . $activado_articulo . '", "' . $visible_en_tienda_articulo . '", "' .$precio_coste_articulo . '", "' . $coste_externo_portes_articulo . '", ';
        $q .= ' "' . $PVP_final_articulo . '", "' . $margen_articulo . '","' . $cantidad_articulo . '", "' .$inicio_descuento_articulo. '", "' .$fin_descuento_articulo. '", ';
        $q .= ' "' .$descuento_porcentaje_articulo. '", "'.$descuento_euros_articulo.'","' . $almacen_articulo . '")';
        return $this->execute_query($q);
    }

    function add_articulo_etiquetas($id_articulo, $id_etiqueta) {
        $q  = ' INSERT INTO '.$this->pre.'articulo_etiquetas (id_articulo, id_etiqueta) VALUES ';
        $q .= ' (' . $id_articulo . ', ' . $id_etiqueta . ')';
        return $this->execute_query($q);
    }

    function delete_articulo_all_etiquetas($id_articulo) {
        $q  = ' DELETE FROM '.$this->pre.'articulo_etiquetas';
        $q .= ' WHERE id_articulo = ' . $id_articulo . ' ';
        return $this->execute_query($q);
    }

    function delete_articulo_etiquetas($id_articulo, $id_etiqueta) {
        $q  = ' DELETE FROM '.$this->pre.'articulo_etiquetas';
        $q .= ' WHERE id_articulo = ' . $id_articulo . ' AND id_etiqueta = ' . $id_etiqueta . ' ';
        return $this->execute_query($q);
    }

    function get_info_articulo($url){
        $q  = ' SELECT a.*,al.*,c.nombre_categoria FROM '.$this->pre.'articulos a ';
        $q .= ' INNER JOIN '.$this->pre.'articulos_lang as al ';
        $q .= ' ON a.id_articulo=al.id_articulo ';
        $q .= ' INNER JOIN '.$this->pre.'categorias_articulo as ca ';
        $q .= ' ON ca.id_articulo=a.id_articulo ';
        $q .= ' INNER JOIN '.$this->pre.'categorias as c ';
        $q .= ' ON ca.id_categoria=c.id_categoria ';
        $q .= ' WHERE a.deleted = 0 ';
        $q .= ' AND a.activo = 1 ';
        $q .= ' AND al.urlseo = "'.$url.'" ';
        return $this->execute_query($q);
    }

    function get_informacion($id_articulo, $lang){
        $q = ' SELECT * FROM '.$this->pre.'informacion_articulo as ia';
        $q .= ' INNER JOIN '.$this->pre.'lang as l';
        $q .= ' on ia.lang=l.id_lang';
        $q .= ' WHERE ia.id_articulo = ' . $id_articulo;
        $q .= ' and l.code="'.$lang.'"';
        return $this->execute_query($q);
    }

    function get_usos_articulo($id_articulo, $lang) {
        $q = ' SELECT * FROM '.$this->pre.'uso_articulo as ua';
        $q .= ' INNER JOIN '.$this->pre.'lang as l';
        $q .= ' on ua.lang=l.id_lang';
        $q .= ' WHERE ua.id_articulo = ' . $id_articulo;
        $q .= ' and l.code="'.$lang.'"';
        return $this->execute_query($q);
    }

    function comprobarArticuloLang($id_articulo, $id_lang){
        $q = ' SELECT * FROM '.$this->pre.'articulos_lang ';
        $q .= ' WHERE urlseo = "'.$id_articulo.'"';
        $q .= ' AND id_lang = "'.$id_lang.'"';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function get_articulo_lang($id_articulo, $id_lang){
        $q = ' SELECT * FROM '.$this->pre.'articulos_lang ';
        $q .= ' WHERE id_articulo = "'.$id_articulo.'"';
        $q .= ' AND id_lang = "'.$id_lang.'"';
        return $this->execute_query($q);
    }

    function buscar_farmacia($str){
        $q  = ' SELECT * FROM adst_adelgaysana_farmacias ';
        $q .= ' WHERE codigopostal_farmacia LIKE "%'.$str.'%"';
        return $this->execute_query($q);
    }

    /* USO */
    function existeuso($id_articulo){
        $q = ' SELECT * FROM '.$this->pre.'usoarticulos ';
        $q .= ' WHERE id_articulo = "'.$id_articulo.'"';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function addusos($id_articulo, $contenido){
        $q  = ' INSERT INTO '.$this->pre.'usoarticulos (id_articulo, contenido) VALUES ';
        $q .= ' ("'.$id_articulo.'", "'.$contenido.'")';
        return $this->execute_query($q);
    }

    function getusos($id_articulo){
        $q  = ' SELECT * FROM '.$this->pre.'usoarticulos ';
        $q .= ' WHERE id_articulo="'.$id_articulo.'"';
        return $this->execute_query($q);
    }

    function updateusos($id_articulo, $contenido){
        $q = ' UPDATE '.$this->pre.'usoarticulos SET ';
        $q .= ' contenido="'.$contenido.'" ';
        $q .= ' WHERE id_articulo="'.$id_articulo.'" ';
        return $this->execute_query($q);
    }
    /* USO */
    function update_precio($id_articulo, $precio){
        $q = ' UPDATE '.$this->pre.'articulos SET ';
        $q .= ' precio="'.$precio.'" ';
        $q .= ' WHERE id_articulo="'.$id_articulo.'" ';
        return $this->execute_query($q);
    }
    /* INFO */
    function existeinfo($id_articulo){
        $q = ' SELECT * FROM '.$this->pre.'informacionarticulo ';
        $q .= ' WHERE id_articulo = "'.$id_articulo.'"';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function addinfo($id_articulo, $contenido){
        $q  = ' INSERT INTO '.$this->pre.'informacionarticulo (id_articulo, contenido) VALUES ';
        $q .= ' ("'.$id_articulo.'", "'.$contenido.'")';
        return $this->execute_query($q);
    }

    function getinfo($id_articulo){
        $q  = ' SELECT * FROM '.$this->pre.'informacionarticulo ';
        $q .= ' WHERE id_articulo="'.$id_articulo.'"';
        return $this->execute_query($q);
    }

    function updateinfo($id_articulo, $contenido){
        $q = ' UPDATE '.$this->pre.'informacionarticulo SET ';
        $q .= ' contenido="'.$contenido.'" ';
        $q .= ' WHERE id_articulo="'.$id_articulo.'" ';
        return $this->execute_query($q);
    }
    /* INFO */
    function get_all_articulos($categoria, $lang, $tipo_tienda=1){
        $q = ' SELECT DISTINCT a.*,al.* FROM '.$this->pre.'articulos a ';
        $q .= ' INNER JOIN '.$this->pre.'articulos_lang al ';
        $q .= ' ON a.id_articulo=al.id_articulo ';

        $q .= ' INNER JOIN '.$this->pre.'categorias_articulo ca ';
        $q .= ' ON a.id_articulo=ca.id_articulo ';

        $q .= ' INNER JOIN '.$this->pre.'categorias c ';
        $q .= ' ON c.id_categoria=ca.id_categoria ';

        $q .= ' INNER JOIN '.$this->pre.'lang as l';
        $q .= ' on al.id_lang=l.id_lang';

        $q .= ' WHERE a.deleted=0 ';
        $q .= ' AND a.activo=1 ';
        $q .= ' AND a.tipo_tienda = '.$tipo_tienda.' ';
        $q .= ' AND c.nombre_categoria = "'.$categoria.'" ';
        $q .= ' AND l.code="'.$lang.'"';
        return $this->execute_query($q);
    }

    function get_articulos($pag, $regs_x_pag) {
        $q  = ' SELECT a.* FROM '.$this->pre.'articulos a ';
        $q .= ' WHERE a.deleted_articulo = 0 ';
        $q .= ' LIMIT ' . ($pag * $regs_x_pag) . ', ' . $regs_x_pag . ' ';
        return $this->execute_query($q);
    }

    function get_articulos_total_regs() {
        $q = ' SELECT a.* FROM '.$this->pre.'articulos a ';
        $q .= ' WHERE a.deleted_articulo = 0 ';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    /* function get_articulo($id_articulo) {
        $q = ' SELECT * FROM '.$this->pre.'articulos a';
        $q .= ' INNER JOIN '.$this->pre.'categorias_articulo as ca';
        $q .= ' INNER JOIN '.$this->pre.'categorias as c';
        $q .= ' INNER JOIN '.$this->pre.'precio_articulo as pa';
        $q .= ' on ca.id_articulo=a.id_articulo';
        $q .= ' and ca.id_categoria=c.id_categoria';
        $q .= ' and pa.id_articulo=a.id_articulo ';
        $q .= ' WHERE a.id_articulo = ' . $id_articulo . ' ';
        $q .=   ' AND a.deleted = 0';
        $q .=   ' AND pa.fecha=(';
        $q .=   ' SELECT MAX(spa.fecha) FROM '.$this->pre.'precio_articulo as spa';
        $q .=   ' WHERE spa.id_articulo='.$id_articulo.')';
        $q .=   ' AND a.visible = 1';
        return $this->execute_query($q);
    } */

    function get_articulo($id_articulo, $lang) {
        $q = ' SELECT * FROM '.$this->pre.'articulos a';
        $q .= ' INNER JOIN '.$this->pre.'articulos_lang as al';
        $q .= ' INNER JOIN '.$this->pre.'lang as l';
        $q .= ' INNER JOIN '.$this->pre.'categorias_articulo as ca';
        $q .= ' INNER JOIN '.$this->pre.'categorias as c';
        $q .= ' INNER JOIN '.$this->pre.'precio_articulo as pa';
        $q .= ' on a.id_articulo=al.id_articulo';
        $q .= ' and l.id_lang=al.id_lang';
        $q .= ' and ca.id_categoria=c.id_categoria';
        $q .= ' and pa.id_articulo=a.id_articulo';
        $q .= ' WHERE a.id_articulo='.$id_articulo;
        $q .= ' and pa.fecha=(SELECT max(spa.fecha) FROM '.$this->pre.'precio_articulo as spa WHERE spa.id_articulo='.$id_articulo.')';
        $q .= ' and a.visible=1';
        $q .= ' and l.code="'.$lang.'"';
        return $this->execute_query($q);
    }

    function get_infonutricional_articulo($id_articulo, $lang) {
        $q = ' SELECT * FROM '.$this->pre.'informacion_articulo as ia';
        $q .= ' INNER JOIN '.$this->pre.'lang as l';
        $q .= ' on ia.lang=l.id_lang';
        $q .= ' WHERE ia.id_articulo = ' . $id_articulo . ' ';
        $q .= ' and l.code="'.$lang.'"';
        return $this->execute_query($q);
    }

    function get_imgs_articulo($id_articulo) {
        $q = ' SELECT * FROM '.$this->pre.'imgs_articulo as ia';
        $q .= ' WHERE ia.id_articulo = ' . $id_articulo . ' ';
        return $this->execute_query($q);
    }

    function get_consejo_articulo($id_articulo, $lang) {
        $q = ' SELECT * FROM '.$this->pre.'consejo_articulo as ca';
        $q .= ' INNER JOIN '.$this->pre.'lang as l';
        $q .= ' on ca.lang=l.id_lang';
        $q .= ' WHERE ca.id_articulo = ' . $id_articulo . ' ';
        $q .= ' and l.code="'.$lang.'"';
        return $this->execute_query($q);
    }

    function get_preguntas_articulo($id_articulo, $limit) {
        $q = ' SELECT * FROM '.$this->pre.'valoracion_articulo as va';
        $q .= ' INNER JOIN '.$this->pre.'usuarios as a ';
        $q .= ' on va.id_usuario=a.id_usuario';
        $q .= ' WHERE va.id_articulo = '.$id_articulo.' ';
        $q .= ' AND a.deleted = 0 LIMIT '.$limit;
        return $this->execute_query($q);
    }

    function get_total_preguntas_articulo($id_articulo) {
        $q = ' SELECT * FROM '.$this->pre.'valoracion_articulo as va';
        $q .= ' WHERE va.id_articulo = '.$id_articulo.' ';
        $r = $this->execute_query($q);
        if ($r) {
            return $r->num_rows;
        } else return false;
    }

    function get_stock_articulo($id_articulo) {
        $q = ' SELECT * FROM '.$this->pre.'articulos as a';
        $q .= ' WHERE a.id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }

    function get_total_valoraciones($id_articulo) {
        $q = ' SELECT avg(va.puntuacion) as total FROM '.$this->pre.'valoracion_articulo as va';
        $q .= ' WHERE va.id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }
    
    function add_articulo_img($id_articulo, $ruta_imagen_articulo) {
        $q  = ' INSERT INTO '.$this->pre.'articulo_imagenes (id_articulo, ruta_imagen) VALUES ';
        $q .= ' ('.$id_articulo.', "'.$ruta_imagen_articulo.'") ';
        return $this->execute_query($q);
    }
    
    function get_imagenes_by_articulo($id_articulo) {
        $q  = ' SELECT ai.* FROM '.$this->pre.'articulo_imagenes ai ';
        $q .= ' WHERE ai.id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }
    
    function get_total_imagenes_articulo($id_articulo) {
        $q  = ' SELECT ai.* FROM '.$this->pre.'articulo_imagenes ai ';
        $q .= ' WHERE ai.id_articulo = '.$id_articulo.' ';
        $r = $this->execute_query($q);
        if ($r) {
            return $r->num_rows;
        } else return false;
    }
    
    function delete_articulo_imagen($id_articulo, $id_imagen) {
        $q  = ' DELETE FROM '.$this->pre.'articulo_imagenes ';
        $q .= ' WHERE id_articulo = '.$id_articulo.' ';
        $q .=   ' AND id_imagen = '.$id_imagen.' ';
        return $this->execute_query($q);
    }
    
    function clear_articulo_img($id_articulo) {
        $q  = ' DELETE FROM '.$this->pre.'articulo_imagenes ';
        $q .= ' WHERE id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }
    
    function clean_dir_imgart($document_root) {
        //todos los archivos que no estén en la tabla se eliminan
        
        $arr_bbdd = array();
        $arr_dir = array();
        
        $q  = ' SELECT ai.* FROM '.$this->pre.'articulo_imagenes ai ';
        
        $r = $this->execute_query($q);
        if ($r) {
            while ($f = $r->fetch_assoc()) {
                //array con nombres de archivo de tabla sql
                $arr_bbdd []= substr($f['ruta_imagen'], (strpos($f['ruta_imagen'], '/')+1), strlen($f['ruta_imagen'])); //desde la barra hasta el final
            }
        } else return false;
        
        //array con nombres de archivo existentes en directorio
        $arr_dir = scandir($this->dir);
        
        foreach ($arr_dir as $k => $v) {
            if ($v != '.' && $v != '..') {
                if (!in_array($v, $arr_bbdd)) {
                    unlink($document_root.$this->dir.$v);
                }
            }
        }
    }
    
    
    function update_articulo($id_articulo, $nombre_articulo, $referencia_articulo,$referencia_proveedor_articulo,$descripcion_articulo,$activado_articulo,
        $visible_en_tienda_articulo,$precio_coste_articulo,$coste_externo_portes_articulo,$PVP_final_articulo,$margen_articulo,$inicio_descuento_articulo,
        $fin_descuento_articulo,$descuento_porcentaje_articulo,$descuento_euros_articulo,$cantidad_articulo, $almacen_articulo){
        
        $q  = ' UPDATE ' . $this->pre . 'articulos SET ';
        $q .=   ' nombre_articulo = "' . $nombre_articulo . '", ';
        $q .=   ' referencia_articulo = "' . $referencia_articulo . '", ';
        $q .=   ' referencia_proveedor_articulo = "' . $referencia_proveedor_articulo . '", ';
        $q .=   ' descripcion_articulo = "' . $descripcion_articulo . '", ';
        $q .=   ' activado_articulo = "' . $activado_articulo . '", ';
        $q .=   ' visible_en_tienda_articulo = "' . $visible_en_tienda_articulo . '", ';
        $q .=   ' precio_coste_articulo = "' . $precio_coste_articulo . '", ';
        $q .=   ' coste_externo_portes_articulo = "' . $coste_externo_portes_articulo . '", ';
        $q .=   ' PVP_final_articulo = "' . $PVP_final_articulo . '", ';
        $q .=   ' margen_articulo = "' . $margen_articulo . '", ';
        $q .=   ' cantidad_articulo = "' . $cantidad_articulo . '", ';
        $q .=   ' inicio_descuento_articulo = "' . $inicio_descuento_articulo. '", ';
        $q .=   ' fin_descuento_articulo = "' . $fin_descuento_articulo. '", ';
        $q .=   ' descuento_porcentaje_articulo = ' . $descuento_porcentaje_articulo . ', ';
        $q .=   ' descuento_euros_articulo = "' . $descuento_euros_articulo . '", ';
        $q .=   ' almacen_articulo = ' . $almacen_articulo . ' ';
        $q .= ' WHERE id_articulo = ' . $id_articulo . ';';
        return $this->execute_query($q);
    }
    
    function get_combo_almacenes($id, $val, $class=false, $lbl=false, $onChange=false, $multiple=false) {
        $iM = load_model('inputs');
        $arr_almacenes = array(
            1 => 'Almacén general',
            2 => 'Almacén x',
        );
        return $iM->get_select($id, $val, $arr_almacenes, $class, $lbl, $onChange, $multiple);
    }
    
    function html_ficha_producto_mini($ad) {
        
        $aux_ruta_this_img = isset($ad['img'][1]) ? $ad['img'][1] : 'vestido-maxi-negro.jpg';
        
        $op = '';
        $op .= '<div class="sesnines_shopping_articulo">';
        
        //GESTION IMG__________________________________________________________
        /*
        foreach ($ad['img'] as $key => $val) {
            //montar slider?
            //$op .=  '<div><img src="csv/vestido-maxi-negro.jpg" alt=""></div>';
            //$op .=  '<div><img src="csv/'.$val.'" alt=""></div>';
        }
        */
        
        $op .=  '<div class= "sesnines_shopping_articulo_img">';
        $op .=      '<img src="csv/'.$aux_ruta_this_img.'" alt="">';
        $op .=  '</div>';
        
        //GESTION IMG__________________________________________________________
        
        $op .=  '<div class= "sesnines_shopping_articulo_nombre">'.strtoupper($ad['nombre_articulo']).'</div>';
        $op .=  '<div class= "sesnines_shopping_articulo_descripcion">'.strtoupper($ad['descripcion_articulo']).'</div>';
        
        
        $op .=  '<div class= "sesnines_shopping_articulo_porcentaje">';
        
    if($ad['descuento_porcentaje_articulo'] && $ad['PVP_final_articulo']) {
        
        $op .=      '<div class="sesnines_shopping_articulo_precio" style="float:left">';
        $op .=          '<b>'.$ad['PVP_final_articulo'].' € </b>';
        $op .=      '</div>';

        $op .=      '<div class="sesnines_shopping_articulo_descuento" style="float:right; color:salmon;" > ';      
        $op .=          $ad['descuento_porcentaje_articulo'].'%';
        $op .=      '</div>';
    } else {
        $op .=      '<div class="sesnines_shopping_articulo_precio">';
        $op .=          '<b>'.$ad['PVP_final_articulo'].' € </b>';
        $op .=      '</div>';                             
    }
        $op .=      '<div style="clear:both"></div>';
        $op .=  '</div>';
       
        $op .=  '</div>';
        
        
        return $op;
    }
    
    /* DEPRECATED */
    /*
    function add_imagen_art($id_articulo, $nombre_img, $num_img){
        $q = '';
        switch($num_img){
            case 0:
            $q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta0) VALUES ';
                break;
            case 1:
            //$q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta2) VALUES ';
            $q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta1) VALUES ';
                break;
            case 2:
            $q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta2) VALUES ';
                break;
            case 3:
            $q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta3) VALUES ';
                break;
            case 4:
            $q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta4) VALUES ';
                break;
        }
        //$q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta) VALUES ';
        $q .= ' ("'.$id_articulo.'", "'.$nombre_img.'")';
        //echo $q;
        return $this->execute_query($q);
    }
    */
    
    /* DEPRECATED */
    /*
    function update_imagen_art($id_articulo, $nombre_img, $num_img){
        $q = '';
        switch($num_img){
            case 0:
            $q  = ' UPDATE '.$this->pre.'img_articulos SET ruta0="'.$nombre_img.'" WHERE id_articulo='.$id_articulo;
                break;
            case 1:
            //$q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta2) VALUES ';
            $q  = ' UPDATE '.$this->pre.'img_articulos SET ruta1="'.$nombre_img.'" WHERE id_articulo='.$id_articulo;
                break;
            case 2:
            $q  = ' UPDATE '.$this->pre.'img_articulos SET ruta2="'.$nombre_img.'" WHERE id_articulo='.$id_articulo;
                break;
            case 3:
            $q  = ' UPDATE '.$this->pre.'img_articulos SET ruta3="'.$nombre_img.'" WHERE id_articulo='.$id_articulo;
                break;
            case 4:
            $q  = ' UPDATE '.$this->pre.'img_articulos SET ruta4="'.$nombre_img.'" WHERE id_articulo='.$id_articulo;
                break;
        }
        //$q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta) VALUES ';
        //$q .= ' ("'.$id_articulo.'", "'.$nombre_img.'")';
        //echo $q;
        return $this->execute_query($q);
    }
    */
}

?>