<?php

class seoModel {

    function __construct() {
    }

    function add_cabecera($title="Ysana",$description="",$keywords=""){
        $o = '';
        $o .= '<meta name="description" content="'.$description.'"/>';
        $o .= '<meta name="keywords" content="'.$keywords.'"/>';
        $o .= '<title>'.$title.'</title>';
        $o .= '</head>';
        
        return $o;
    }

}

?>