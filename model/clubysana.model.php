<?php

class clubysanaModel extends Model {

    function add_experiencia($titulo, $imagen, $urlseo, $id_lang){
        $q  = ' INSERT INTO '.$this->pre.'experiencias (titulo, imagen, urlseo, id_lang) VALUES ';
        $q .= ' ("'.$titulo.'", "'.$imagen.'", "'.$urlseo.'", "'.$id_lang.'")';
        return $this->execute_query($q);
    }

    function get_experiencia_urlseo_idlang($urlseo, $id_lang){
        $q  = ' SELECT * FROM '.$this->pre.'experiencias e ';
        $q .= ' WHERE e.id_lang='.$id_lang.' ';
        $q .= ' AND e.urlseo="'.$urlseo.'" ';
        $q .= ' ORDER BY e.id_experiencia ASC ';
        return $this->execute_query($q);
    }

    function get_experiencias($id_lang){
        $q  = ' SELECT * FROM '.$this->pre.'experiencias e ';
        $q .= ' WHERE e.id_lang='.$id_lang.' ';
        $q .= ' ORDER BY e.id_experiencia ASC ';
        return $this->execute_query($q);
    }

    function update_experiencias($id, $titulo, $imagen=false, $urlseo, $id_lang){
        $q = ' UPDATE '.$this->pre.'experiencias SET ';
        $q .= ' titulo="'.$titulo.'", ';
        if($imagen!=false) $q .= ' imagen="'.$imagen.'", ';
        $q .= ' urlseo="'.$urlseo.'" ';
        $q .= ' WHERE id_experiencia='.$id.' ';
        $q .= ' AND id_lang='.$id_lang.' ';
        return $this->execute_query($q);
    }

    function delete_experiencia($id_experiencia) {
        $q  = ' DELETE FROM '.$this->pre.'experiencias';
        $q .= ' WHERE id_experiencia='.$id_experiencia.' ';
        return $this->execute_query($q);
    }

    function add_datos_experiencia($id_experiencia, $titulo, $imagen, $urlseo, $id_lang) {
        $q  = ' INSERT INTO '.$this->pre.'datosexperiencias (id_experiencia, titulo, imagen, urlseo, id_lang) VALUES ';
        $q .= ' ("'.$id_experiencia.'", "'.$titulo.'", "'.$imagen.'", "'.$urlseo.'", "'.$id_lang.'")';
        return $this->execute_query($q);
    }

    function get_datos_experiencias(){
        $q  = ' SELECT * FROM '.$this->pre.'datosexperiencias de ';
        $q .= ' ORDER BY de.id_datoexperiencia ASC ';
        return $this->execute_query($q);
    }

    function get_breadcrumb_datos($urlseo, $urlseo2){
        $q  = ' SELECT e.titulo, de.id_datoexperiencia, ie.id_info FROM '.$this->pre.'experiencias e ';
        $q .= ' INNER JOIN '.$this->pre.'datosexperiencias de ';
        $q .= ' INNER JOIN '.$this->pre.'infoexperiencia ie ';
        $q .= ' ON e.id_experiencia=de.id_experiencia ';
        $q .= ' AND de.id_datoexperiencia=ie.id_exp ';
        $q .= ' WHERE e.urlseo="'.$urlseo.'" ';
        $q .= ' AND de.urlseo="'.$urlseo2.'" ';
        $q .= ' ORDER BY de.id_datoexperiencia ASC ';
        return $this->execute_query($q);
    }

    function get_datos_experiencias_urlseo($urlseo){
        $q  = ' SELECT * FROM '.$this->pre.'datosexperiencias de ';
        $q .= ' INNER JOIN '.$this->pre.'infoexperiencia ie ';
        $q .= ' ON de.id_datoexperiencia=ie.id_exp ';
        $q .= ' WHERE de.urlseo="'.$urlseo.'" ';
        return $this->execute_query($q);
    }

    function get_sliders($urlseo){
        $q  = ' SELECT * FROM '.$this->pre.'datosexperiencias de ';
        $q .= ' INNER JOIN '.$this->pre.'infoexperiencia ie ';
        $q .= ' ON de.id_datoexperiencia=ie.id_exp ';
        $q .= ' WHERE de.urlseo="'.$urlseo.'" ';
        return $this->execute_query($q);
    }

    function get_datos_experiencias_idexp_idlang($id_exp, $id_lang){
        $q  = ' SELECT * FROM '.$this->pre.'datosexperiencias de ';
        $q .= ' WHERE de.id_experiencia='.$id_exp.' ';
        $q .= ' AND de.id_lang='.$id_lang.' ';
        $q .= ' ORDER BY de.id_datoexperiencia ASC ';
        return $this->execute_query($q);
    }

    function get_datos_leftjoin_experiencias(){
        $q  = ' SELECT de.* FROM '.$this->pre.'datosexperiencias de ';
        $q .= ' LEFT JOIN '.$this->pre.'infoexperiencia ie ';
        $q .= ' ON de.id_datoexperiencia=ie.id_exp ';
        $q .= ' WHERE ie.id_exp IS NULL ';
        $q .= ' ORDER BY de.id_datoexperiencia ASC ';
        return $this->execute_query($q);
    }

    function delete_datos_experiencia($id_dato) {
        $q  = ' DELETE FROM '.$this->pre.'datosexperiencias';
        $q .= ' WHERE id_datoexperiencia='.$id_dato.' ';
        return $this->execute_query($q);
    }

    function add_infoexperiencia($id, $titulo, $col1, $col2) {
        $q  = ' INSERT INTO '.$this->pre.'infoexperiencia (id_exp, titulo, texto_columna1, texto_columna2) VALUES ';
        $q .= ' ("'.$id.'", "'.$titulo.'", "'.$col1.'", "'.$col2.'")';
        return $this->execute_query($q);
    }

    function add_sliderinfoexperiencia($id, $titulo, $descripcion, $img) {
        $q  = ' INSERT INTO '.$this->pre.'slider_experiencia (id_slider, titulo, descripcion, img) VALUES ';
        $q .= ' ("'.$id.'", "'.$titulo.'", "'.$descripcion.'", "'.$img.'")';
        return $this->execute_query($q);
    }

    function get_info_experiencias($id){
        $q  = ' SELECT * FROM '.$this->pre.'infoexperiencia i ';
        $q .= ' WHERE i.id_exp='.$id.' ';
        $q .= ' ORDER BY i.id_info ASC ';
        return $this->execute_query($q);
    }

    function update_info_experiencias($id, $titulo, $col1, $col2){
        $q = ' UPDATE '.$this->pre.'infoexperiencia SET ';
        $q .= ' titulo="'.$titulo.'", ';
        $q .= ' texto_columna1="'.$col1.'", ';
        $q .= ' texto_columna2="'.$col2.'" ';
        $q .= ' WHERE id_info='.$id.'';
        return $this->execute_query($q);
    }

    function get_sliders_experiencias($id){
        $q  = ' SELECT * FROM '.$this->pre.'slider_experiencia s ';
        $q .= ' WHERE s.id_slider='.$id.' ';
        $q .= ' ORDER BY s.id_identificador ASC ';
        return $this->execute_query($q);
    }

    
}

?>