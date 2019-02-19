<?php

class formModel {
    
    function get_input_text($id_campo, $lbl_campo, $value, $arr_err, $class='campo', $placeholder='', $max_length=false) {
        $aux_aplicar_max_length = $max_length > 0 ? 'maxlength="'.$max_length.'"' : '';
        
        $o = '<div class="form-group">
            <label>'.$lbl_campo.'</label>
            <input id="'.$id_campo.'" name="'.$id_campo.'" value="'.htmlspecialchars(stripslashes($value)).'" type="text" class="form-control" required>
            </div>';
        return $o;
    }
    
    function get_input_num($id_campo, $lbl_campo, $value, $arr_err, $class='campo', $placeholder='', $max_length=false) {
        
        $aux_aplicar_max_length = $max_length > 0 ? 'maxlength="'.$max_length.'"' : '';
        
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="text" id="'.$id_campo.'" name="'.$id_campo.'" '.$aux_aplicar_max_length.' placeholder="'.$placeholder.'" value="'.htmlspecialchars(stripslashes($value)).'" />';
        $o .= '</div>';
        return $o;
    }
    
   

    function get_input_date($id_campo, $lbl_campo, $value, $arr_err, $class='campo', $disabled='') {
        $o = '<div class="form-group">
        <label>'.$lbl_campo.'</label>
        <input type="date" id="'.$id_campo.'" name="'.$id_campo.'" value="'.htmlspecialchars(stripslashes($value)).'" class="form-control" required>
        </div>';

        /* $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="text" '.$disabled.' id="'.$id_campo.'" name="'.$id_campo.'" value="'.htmlspecialchars(stripslashes($value)).'" />';
        $o .= '</div>'; */
        
        //$o .= 'dateFormat: \'dd-mm-yy\',';
        //$o .= 'changeYear: true';
        //$o .= '}+-7'
        //        . '.30'
        //        . ');</script>';
        /* $o .= '<script>';
        $o .= '$(\'#'.$id_campo.'\').datepicker(';
        $o .= ');';
        $o .= '</script>'; */
        return $o;
    }
    
    function get_input_hidden($id_campo, $value) {
        $o  = '<input type="hidden" id="'.$id_campo.'" name="'.$id_campo.'" value="'.htmlspecialchars(stripslashes($value)).'" />';
        return $o;
    }
    
    function get_input_password($id_campo, $lbl_campo, $value, $arr_err, $class='campo', $max_length=false) {
        $o = '<div class="form-group">
            <label>'.$lbl_campo.'</label>
            <input id="'.$id_campo.'" name="'.$id_campo.'" value="'.htmlspecialchars(stripslashes($value)).'" type="password" class="form-control">
            </div>';
        return $o;
    }
    
    function get_input_number($id_campo, $lbl_campo, $value, $arr_err, $class='campo', $min=1, $max=9999, $decimal=false) {
        $aux_aplicar_decimal = ($decimal == true) ? ' step=".01" ' : '';
        
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="number" max="'.$max.'" min="'.$min.'" id="'.$id_campo.'" name="'.$id_campo.'" '.$aux_aplicar_decimal.' value="'.htmlspecialchars(stripslashes($value)).'" />';
        $o .= '</div>';
        return $o;
    }
    
    function get_input_checkbox($id_campo, $lbl_campo, $value, $arr_err, $class='campo') {
        $aux_is_checked = '';
        //El if es para editar y contorl de erroes
        if ($value == 1){ 
            $aux_is_checked = ' checked="checked" ';
            
        }else{$aux_is_checked ='';};
        
        $o  = '<div class="'.$class.'">'; //output
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="checkbox" id="'.$id_campo.'" name="'.$id_campo.'" '.$aux_is_checked.' />';
        $o .=   $lbl_campo;
        $o .= '</div>';
        return $o;
    }

    function get_input_checkbox_arr_selected_img($id_campo, $url_img, $value, $nombre, $arr_err,  $tipo='checkbox', $class='campo') {
        $aux_is_checked = '';
        if ($value != null) $aux_is_checked = ' checked="checked" ';
        
        $o =   '<input type="'.$tipo.'" id="'.$id_campo.'" name="'.$nombre.'" value="'.$id_campo.'" '.$aux_is_checked.' />';
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<label for="'.$id_campo.'">';
        $o .=   '<img style="width:12em; height:200px;" src="'.$url_img.'"/>';
        $o .=   '</label>';
        return $o;
    }
    
    function get_input_checkbox_arr($id_campo, $lbl_campo, $value, $nombre, $arr_err,  $tipo='checkbox', $class='campo') {
        $aux_is_checked = '';
        if ($value != null) $aux_is_checked = ' checked="checked" ';
        
        $o  = '<div class="'.$class.'">'; //output
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<input type="'.$tipo.'" id="'.$id_campo.'" name="'.$nombre.'" value="'.$id_campo.'" '.$aux_is_checked.' />';
        $o .=   $lbl_campo;
        $o .= '</div>';
        return $o;
    }
    
    
    function get_input_combo($id_campo, $lbl_campo, $sl_combo, $arr_err, $class='campo') {
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .=   '<div style="margin-bottom:16px;">'.$sl_combo.'</div>';
        $o .= '</div>';
        return $o;
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
    
    function check_is_date($id_campo, $value, &$verif, &$arr_err, $lbl_error=REQ_FIELD, $class_error='error_alert') {
        if(strpos($value,'/')){
            $result=explode('/',$value);
        }else if(strpos($value,'-')){
            $result=explode('-',$value);
        }
        
        $day = $result[0];
        $month = $result[1];
        $year = $result[2];
        if(!checkdate($month,$day,$year)){
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">El formato de la fecha no es válido</div>';
        }
        return true;
    }

    function check_length($id_campo, $value, &$verif, &$arr_err, $lbl_error=REQ_FIELD, $class_error='error_alert') {
        if (strlen($value) < 1) {   
            $verif = false;
            //hace un array con el div de error dentro.
            $arr_err[$id_campo] = '<div class="'.$class_error.'">'.$lbl_error.'</div>';
        }
        return true;
    }
    //function foto ()
    
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
    
    function check_is_greater_than_0($id_campo, $value, &$verif, &$arr_err, $class_error='error_alert') {
        if ($value < 1) {
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">Debe ser un valor mayor a 0 </div>';
        }
        return true;
    }
    
    
   /*  function check_img_no_empty($id_campo, $value, &$verif, &$arr_err, $class_error='error_alert') {
         $cantidad2=0;
         if (isset($value)) {
            $cantidad = count($value['tmp_name']); //Recibe un array de FILES que se hace poniendo el mismo name a todos los input[type="file"]
            
            for ($i = 0; $i < $cantidad; $i++) {
                $cantidad2++;
         }
        } 
         
         if ($cantidad2 < 1) {
            $verif = false;
            $arr_err[$id_campo] = '<div class="'.$class_error.'">Debe haber una imagen como mínimo </div>';
            
           }
               
        return true;
    }
    
     function get_input_img($id_campo, $lbl_campo, $arr_err, $class='campo') {
        
        //$aux_aplicar_max_length = $max_length > 0 ? 'maxlength="'.$max_length.'"' : '';
        //echo 'antes<br>';
        $o  = '<div class="'.$class.'">'; //output
        $o .=   $lbl_campo;
        $o .=   (isset($arr_err[$id_campo])) ? $arr_err[$id_campo] : '';
        $o .= '</div>';
        //echo 'después<br>';
        return $o;
    }*/
}
