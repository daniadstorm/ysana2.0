<?php

class formModel {
    
    function get_input_text($id_campo, $lbl_campo, $value, $arr_err, $class='campo', $placeholder='', $max_length=false) {
        $aux_aplicar_max_length = $max_length > 0 ? 'maxlength="'.$max_length.'"' : '';
        
        $aux_style = (isset($arr_err[$id_campo])) ? ' style="background-color:#ffe6e6;" ' : '';
        
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        //$o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input '.$aux_style.' type="text" id="'.$id_campo.'" name="'.$id_campo.'" '.$aux_aplicar_max_length.' placeholder="'.$placeholder.'" value="'.htmlspecialchars(stripslashes($value)).'" />';
        $o .= '</div>';
        return $o;
    }
    
    function get_input_hidden($id_campo, $value) {
        $o  = '<input type="hidden" id="'.$id_campo.'" name="'.$id_campo.'" value="'.htmlspecialchars(stripslashes($value)).'" />';
        return $o;
    }
    
    //NOTA: para que placeholder se muestre, el valor recibido debe ser un string vacio
    function get_input_number($id_campo, $lbl_campo, $value, $arr_err, $class='campo', $min=1, $max=9999, $decimal=false, $placeholder='') {
        $aux_aplicar_decimal = ($decimal == true) ? ' step=".01" ' : '';
        
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="number" max="'.$max.'" min="'.$min.'" id="'.$id_campo.'" name="'.$id_campo.'" '.$aux_aplicar_decimal.' placeholder="'.$placeholder.'" value="'.htmlspecialchars(stripslashes($value)).'" />';
        $o .= '</div>';
        return $o;
    }
    
    function get_input_checkbox($id_campo, $lbl_campo, $value, $arr_err, $class='campo') {
        $aux_is_checked = '';
        if ($value === 'on') $aux_is_checked = ' checked="checked" ';
        
        $o  = '<div class="'.$class.'">'; //output
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="checkbox" id="'.$id_campo.'" name="'.$id_campo.'" '.$aux_is_checked.' />';
        $o .=   $lbl_campo;
        $o .= '</div>';
        return $o;
    }
    
    function get_input_combo($id_campo, $lbl_campo, $sl_combo, $arr_err, $class='campo') {
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   $sl_combo;
        $o .= '</div>';
        return $o;
    }
    
    function get_combo_array($arr, $id, $selected=false, $class=false, $onChange=false) {
        $o  = '';
        $o .= '<select id="'.$id.'" name="'.$id.'" ';
        if ($class) $o .= ' class ="'.$class.'" ';
        $o .= '>';
        foreach ($arr as $key => $val) $o .= '<option '.(($selected == $key) ? ' selected="selected" ' : '').' value="'.$key.'">'.$val.'</option>';
        $o .= '</select>';
        return $o;
    }
    
    function get_combo_rango_edades($id, $selected=false, $class=false, $default=true) {
        $arr_rango_edades = array(
            '18 - 24' => '18 - 24',
            '25 - 30' => '25 - 30',
            '31 - 35' => '31 - 35',
            '36 - 40' => '36 - 40',
            '41 - 45' => '41 - 45',
            '46 - 50' => '46 - 50',
            '51 - 55' => '51 - 55',
            '56 - 60' => '56 - 60',
            '61 - 65' => '61 - 65',
            '66 - 70' => '66 - 70',
            '71 - 75' => '71 - 75',
            '+ 75' => '+ 75'
        );
        return $this->get_combo_array($arr_rango_edades, $id, $selected, $class, $default);
    }
    
    function get_combo_genero($id, $selected=false, $class=false, $default=true) {
        $arr_rango_edades = array(
            'Mujer' => 'Mujer',
            'Hombre' => 'Hombre'
        );
        return $this->get_combo_array($arr_rango_edades, $id, $selected, $class, $default);
    }
    
    function get_input_colorpicker($id_campo, $lbl_campo, $value, $arr_err, $class='campo') {
        $options = 'onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	}';
        
        //$options = '';
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="text" id="'.$id_campo.'" name="'.$id_campo.'" value="'.htmlspecialchars(stripslashes($value)).'" />';
        $o .= '</div>';
        $o .= '<script>';
        $o .= '$(\'#'.$id_campo.'\').ColorPicker({'.$options.'});';
        //$o .= '.bind(\'keyup\', function(){ $(this).ColorPickerSetColor(this.value); });';
        $o .= '</script>';
        
        return $o;
    }
    
    function check_length($id_campo, $value, &$verif, &$arr_err, $lbl_error=REQ_FIELD, $class_error='error_alert') {
        if (strlen($value) < 1) {
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">'.$lbl_error.'</div>';
        }
        return true;
    }
    
    function check_length_match($id_campo, $value, $length, &$verif, &$arr_err, $class_error='error_alert') {
        if (strlen($value) != $length) {
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">Campo debe tener longitud de '.$length.' carácteres</div>';
        }
        return true;
    }
    
    function check_combo($id_campo, $value, &$verif, &$arr_err, $lbl_error=REQ_FIELD, $class_error='error_alert') {
        if ($value == -1) {
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">'.$lbl_error.'</div>';
        }
        return true;
    }
    
    function check_is_valid_email($id_campo, $value, &$verif, &$arr_err, $lbl_error=REQ_FIELD, $class_error='error_alert'){ 
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">'.$lbl_error.'</div>';
        }
        return true;
    }
    
    function check_is_hexadecimal($id_campo, $value, &$verif, &$arr_err, $class_error='error_alert') {
        //ctype_xdigit
        if (!ctype_xdigit($value)) {
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">Debe ser un valor hexadecimal</div>';
        }
        return true;
    }
}
?>