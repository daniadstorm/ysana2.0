<?php

class sliderModel extends Model{
    function add_slider($titulo_slider,$img_slider, $tipo_slider){
        $q = ' INSERT INTO '.$this->pre.'sliders ( ';
        $q .= ' titulo_slider, img_slider, tipo_slider) ';
        $q .= ' VALUES ("'.$titulo_slider.'","'.$img_slider.'","'.$tipo_slider.'")';
        return $this->execute_query($q);
    }

    function get_sliders(){
        $q = ' SELECT * FROM '.$this->pre.'sliders ';
        return $this->execute_query($q);
    }
}

?>