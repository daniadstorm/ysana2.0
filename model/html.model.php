<?php

class htmlModel {
    
    private $arr_opciones_slider;
    
    function __construct() {
        $sM = load_model('slider');
        $rgs = $sM->get_sliders();
        $i=1;
        if($rgs){
            $this->arr_opciones_slider = array();
            while($row = $rgs->fetch_assoc()){
                array_push($this->arr_opciones_slider,array('ttl'=>'', 'txt'=>$row['titulo_slider'], 'bg'=>$row['img_slider']));
            }
        }
    }
    
    function get_alert_success($msg) {
        return $this->get_alert($msg, 'alert-success');
    }
    
    function get_alert_danger($msg) {
        return $this->get_alert($msg, 'alert-danger');
    }
    
    function get_alert($msg, $class) {
        $r  = '<div class="alert '.$class.'" role="alert">';
        $r .=   $msg;
        $r .= '</div>';
        return $r;
    }
    
    function get_slider($ruta_inicio) {
        $r  = '<div id="option_slider">';
        $r .=   '<div id="option_slider_wrapper">';
        $r .=       '<input type="hidden" id="slider_last_option" value="'.count($this->arr_opciones_slider).'" />';
        $r .=       '<input type="hidden" id="slider_this_option" value="0" />';
        /*
        $r .=       '<div style="float:left;" id="option_slider_navigator_left" class="option_slider_navigator">';
        $r .=           '<a href="javascript:option_slider_navigate(\'prev\');"><img src="'.$ruta_inicio.'img/navigate_left.png" /></a>';
        $r .=       '</div>';
        */
        $r .=       '<div id="slider_options_content" style="float:left;">';
        foreach ($this->arr_opciones_slider as $key=>$this_option) {
            
            $styles_bg = 'background-image: url(./img/slider/'.$this_option['bg'].');background-size: cover;background-repeat: no-repeat;background-position: center center;';
            
            $style = $key > 0 ? 'style="display: none;'.$styles_bg.'"' : 'style="'.$styles_bg.'"';
            
            $r .=       '<div id="slider_option_'.$key.'" class="option_to_slide" '.$style.'>';
            /*
            $r .=           '<div id="slider_option_left" style="float:left;" class="slider_option">';
            $r .=               $this_option['ttl'];
            $r .=           '</div>';
            */
            $r .=           '<div id="slider_option_right" style="float:right;" class="slider_option">';
            $r .=               $this_option['txt'];
            $r .=           '</div>';
            $r .=       '</div>';
        }
        $r .=       '</div>';
        /*
        $r .=       '<div style="float:right;" id="option_slider_navigator_right" class="option_slider_navigator">';
        $r .=           '<a href="javascript:option_slider_navigate(\'next\');"><img src="'.$ruta_inicio.'img/navigate_right.png" /></a>';
        $r .=       '</div>';
        */
        $r .=       '<div style="clear:both;"></div>';
        $r .=   '</div>';
        $r .= '</div>';
        
        $r .= '<script>';
        $r .=   'var tid = setInterval(option_slider_navigate, 4500);';
        $r .= '</script>';
        
        return $r;
    }
    
}    
?>