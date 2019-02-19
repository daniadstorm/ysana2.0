<?php

class inputsModel extends Model {
    
    /*
    https://stackoverflow.com/questions/10281962/is-there-a-minlength-validation-attribute-in-html5

    You can use the pattern attribute. The required attribute is also needed, otherwise an input field with an empty value will be excluded from constraint validation.

    <input pattern=".{3,}"   required title="3 characters minimum">
    <input pattern=".{5,10}" required title="5 to 10 characters">
    
    If you want to create the option to use the pattern for "empty, or minimum length", you could do the following:
    <input pattern=".{0}|.{5,10}" required title="Either 0 OR (5 to 10 chars)">
    <input pattern=".{0}|.{8,}"   required title="Either 0 OR (8 chars minimum)">
    */
    function get_input_text($id, $val, $class='', $lbl='', $placeholder='', $err_desc='', $min_length=false, $max_length=false, $allow_empty=false, $classdiv='form-group', $desactivado=false) {
        $val = $this->safe_show($val);
        $str_tmp = '';
        $aux_required = 'required';
        
        $aux_pattern = '';
        if ($allow_empty != false) {
            $aux_pattern .= '.{0}|';
            $aux_required = '';
        }
        $aux_pattern.= '.{';
        if ($min_length != false) $aux_pattern .= $min_length;
        $aux_pattern .= ',';
        if ($max_length != false) $aux_pattern .= $max_length;
        $aux_pattern .= '}';
        $str_tmp .= ($desactivado) ? ' disabled ' : '';
        
        $o  = '<div class="'.$classdiv.'">';
        if (strlen($lbl) > 0) $o .= '<label>'.$lbl.'</label>';
        $o .=   '<input type="text" '.$aux_required.' id="'.$id.'" name="'.$id.'" value="'.$val.'" class="'.$class.'" placeholder="'.$placeholder.'" pattern="'.$aux_pattern.'" title="'.$err_desc.'" '.$str_tmp.'>';
        $o .= '</div>';
            
        return $o;
    }

    function get_input_textarea($id, $val, $class='', $lbl='', $placeholder='', $err_desc='', $min_length=false, $max_length=false, $allow_empty=false, $rows=3) {
        $val = $this->safe_show($val);
        
        $aux_required = 'required';
        $aux_min_length = '';
        $aux_max_lenght = '';
        
        if ($allow_empty != false) $aux_required = '';
        if ($min_length != false) $aux_min_length = 'minlength="'.$min_length.'"';
        if ($max_length != false) $aux_max_lenght = 'maxlength="'.$max_length.'"';
        
        $o  = '<div class="form-group">';
        if (strlen($lbl) > 0) $o .= '<label>'.$lbl.'</label>';
        $o .=   '<textarea '.$aux_required.' id="'.$id.'" name="'.$id.'" class="'.$class.'" placeholder="'.$placeholder.'" '.$aux_min_length.' '.$aux_max_lenght.' title="'.$err_desc.'" rows="'.$rows.'">';
        $o .=       $val;
        $o .=   '</textarea>';
        $o .= '</div>';
            
        return $o;
    }
    
    function get_input_number($id, $val, $class='', $lbl='', $placeholder='', $err_desc='', $min=false, $max=false, $step='int', $allow_empty=false) {
        $val = $this->safe_show($val);
        
        $aux_required = 'required';
        $aux_min = '';
        $aux_max = '';
        
        switch ($step) {
            default:
            case 'int':
                $aux_step = 'step="1"';
            break;
            case 'decimal':
                $aux_step = 'step=".1"';
            break;
            case 'price':
            case 'centesimal':
                $aux_step = 'step=".01"';
            break;
        }
        
        if ($allow_empty != false) $aux_required = '';
        if ($min != false) $aux_min = 'min="'.$min.'"';
        if ($max != false) $aux_max = 'max="'.$max.'"';
        
        $o  = '<div class="form-group">';
        if (strlen($lbl) > 0) $o .= '<label>'.$lbl.'</label>';
        $o .=   '<input type="number" '.$aux_required.' id="'.$id.'" name="'.$id.'" value="'.$val.'" class="'.$class.'" placeholder="'.$placeholder.'" '.
                    $aux_min.' '.$aux_max.' title="'.$err_desc.'" '.$aux_step.'>';
        $o .= '</div>';
            
        return $o;
    }
    
    /*
    https://stackoverflow.com/questions/17443034/input-type-date-min-and-max-values-validate-against-yyyy-mm-dd-instead-of-dd-mm
    formato de fechas requerido: YYYY-mm-dd
    testear si para comprar dos fechas se puede: min='$("#segunda_fecha").val()'
     */
    function get_input_date($id, $val, $class='', $lbl='', $placeholder='', $err_desc='', $min=false, $max=false, $allow_empty=false) {
        $val = $this->safe_show($val);
        
        $aux_required = 'required';
        $aux_min = '';
        $aux_max = '';
        
        if ($allow_empty != false) $aux_required = '';
        if ($min != false) $aux_min = 'min="'.$min_length.'"';
        if ($max != false) $aux_max = 'max="'.$max_length.'"';
        
        $o = '<div class="form-group">';
        if (strlen($lbl) > 0) $o .= '<div><label>'.$lbl.'</label></div>';
        
        $o .=   '<input type="date" '.$aux_required.' id="'.$id.'" name="'.$id.'" value="'.$val.'" class="'.$class.'" placeholder="'.$placeholder.'" '.
                    $aux_min.' '.$aux_max.' title="'.$err_desc.'">';
        $o .= '</div>';
        
        return $o;
    }
    
    
    function get_input_hidden($id, $val) {
        $val = $this->safe_show($val);
        $o  = '<input type="hidden" id="'.$id.'" name="'.$id.'" value="'.$val.'" />';
        return $o;
    }
    
    function get_input_radio($id, $val, $arr_opt, $class='', $lbl='', $allow_empty=false, $sep=false) {
        $val = $this->safe_show($val);
        
        $aux_required = ($allow_empty == false) ? 'required' : '';
        
        $o  = '<div class="form-group">';
        if (strlen($lbl) > 0) $o .= '<div><label>'.$lbl.'</label></div>';
        
        if ($sep == false) $o .=   '<div class="btn-group btn-group-toggle '.$class.'" data-toggle="buttons">';
            else if ($sep == true) $o .=   '<div class="btn-group-vertical btn-group-toggle '.$class.'" data-toggle="buttons">';
        
        foreach ($arr_opt as $k => $v) {
            
            $aux_active = '';
            $aux_checked = '';
            
            if ($val == $k) {
                $aux_active = 'active';
                $aux_checked = 'checked';
            }
            
            $o .=       '<label class="btn btn-secondary '.$aux_active.'">';
            $o .=           '<input type="radio" name="'.$id.'" id="'.$id.$k.'" value="'.$k.'" autocomplete="off" '.$aux_checked.' '.$aux_required.'> '.$v;
            $o .=       '</label>';
        }
        
        $o .=   '</div>';
        $o .= '</div>';
        
        return $o;
    }
    
    /*
    http://plugins.krajee.com/file-basic-usage-demo
    */
    function get_input_img($id, $val, $ruta_archivos, $class='', $lbl='', $required='required',$multiple=false, $maxFileCount=false) {

        $aux_multiple = '';
        $initial_preview_config = '';
        if ($multiple) $aux_multiple = 'multiple';

        if (count($val) > 0) {
            $aux_imagen_categoria_required = '';
            /* $aux_js_editar = 'initialPreview: [\''.$ruta_archivos.$val.'\'],initialPreviewAsData: true,'; */
            $aux_js_editar = 'initialPreview: [';
            $ruta_imgs = '';
            $preview_config = '';
            foreach($val as $value){
                ($value==end($val)) ? $ruta_imgs .= '\''.$ruta_archivos.$value.'\'' : $ruta_imgs .= '\''.$ruta_archivos.$value.'\',';
                $value = str_replace('imgaltaps/','',$value);
                $preview_config .= '{caption: "'.$value.'", filename: "'.$value.'", url: "http://localhost/sesninesapp/del.php?del='.$value.'&nombre_array=imagen_categoria"}';
                if($value!=end($val)) $preview_config .= ',';
                /* if (strlen($value) > 0) {
                    ($value==end($val)) ? $ruta_imgs .= '\''.$ruta_archivos.$value.'\'' : $ruta_imgs .= '\''.$ruta_archivos.$value.'\',';
                } */
            }
            $aux_js_editar .= $ruta_imgs.'],initialPreviewAsData: true, ';
            $initial_preview_config = 'initialPreviewConfig:['.$preview_config.'],';
        } else {
            $aux_imagen_categoria_required = $required;
            $aux_js_editar = '';
        }
        
        $o  = '<div class="form-group '.$class.'">';
        $o .=   '<label>'.$lbl.'</label>';
        $o .=   '<div class="file-loading">';
        $o .=       '<input '.$aux_imagen_categoria_required.' id="'.$id.'" name="'.$id.'[]" type="file" '.$aux_multiple.'>';
        $o .=   '</div>';
        $o .= '</div>';
        
        $o .= '<script>';
        $o .=   '$(\'#'.$id.'\').fileinput({';
        $o .=       'theme: \'fa\',';
        $o .=       'language: \'es\',';
        $o .=       'showUpload: false,';
        $o .= $initial_preview_config;
        ($maxFileCount!=false) ? $o .= 'maxFileCount: '.$maxFileCount.',' : '';
        $o .=       $aux_js_editar;
        $o .=       'allowedFileExtensions: [\'jpg\', \'png\', \'gif\']';
        $o .=   '});';
        $o .= '</script>';
        
        return $o;
    }
    
    function get_select($id, $val, $arr_opt, $class=false, $lbl=false, $onChange=false, $multiple=false) {
        
        $aux_onChange = '';
        $aux_multiple = '';
        
        if ($onChange != false) $aux_onChange = $onChange;
        if ($multiple != false) $aux_multiple = 'multiple';
        
        $o  = '<div class="form-group">';
        if (strlen($lbl) > 0) $o .= '<div><label for="'.$id.'">'.$lbl.'</label></div>';
        $o .=   '<select '.$aux_multiple.' id="'.$id.'" name="'.$id.'" class="'.$class.'" '.$aux_onChange.'>';
        
        foreach ($arr_opt as $k => $v) $o .= '<option '.(($val == $k) ? ' selected="selected" ' : '').' value="'.$k.'">'.$v.'</option>';
        
        $o .=   '</select>';
        $o .= '</div>';
        
        return $o;
    }
}
