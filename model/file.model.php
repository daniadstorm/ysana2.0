<?php

class fileModel extends Model {
    
    function add_img($id_articulo, $ruta) {
        $q  = ' INSERT INTO '.$this->pre.'img_articulos (id_articulo, ruta) VALUES ';
        $q .= ' ('.$id_articulo.',"'.$ruta.'")';
        
        echo $q;
        return $this->execute_query($q);
    }
    
    function add_file($id_articulo, $filename) {
        $q  = ' INSERT INTO '.$this->pre.'articulosimg (id_articulo, url_imagen) VALUES ';
        $q .= ' ('.$id_articulo.',"'.$filename.'") ';
        
        echo $q;
        
        return $this->execute_query($q);
    }
    
    function csv_exists($filename) {
        $q  = ' SELECT a.* FROM '.$this->pre.'archivos a ';
        $q .= ' WHERE a.nombre_archivo = "'.$filename.'" ';
        $r = $this->execute_query($q);
        if ($r) {
            if ($r->num_rows > 0) return true;
                else return false;
        } else return false;
    }
    
    function get_file($id_archivo) {
        $q  = ' SELECT a.* FROM '.$this->pre.'archivos a ';
        $q .= ' WHERE id_archivo = '.$id_archivo.' ';
        return $this->execute_query($q);
    }
    
    function get_files() {
        $q  = ' SELECT a.* FROM '.$this->pre.'archivos a ';
        $q .= ' ORDER BY a.fecha DESC ';
        return $this->execute_query($q);
    }
    
    function delete_file($id_archivo) {
        $q  = ' DELETE FROM '.$this->pre.'archivos ';
        $q .= ' WHERE id_archivo = '.$id_archivo.' ';
        return $this->execute_query($q);
    }
    
    function import_csv($filename) {
        $prM = load_model('pricing');
        $fila = 1;
        $check_headers = true;
        $arr_headers_pattern = array(
            0=>'MARCA',
            1=>'REFERENCIA',
            2=>'P/N',
            3=>'NOMBRE',
            4=>'STOCK',
            5=>'PRECIO',
            6=>'CANON',
            7=>'CATEGORIA',
            8=>'SUBCATEGORIA1',
            9=>'SUBCATEGORIA2',
            10=>'SUBCATEGORIA3',
            11=>'EAN',
            12=>'PROX. ENTRADA',
            13=>'DESCRIPCION',
            14=>'COMPATIBILIDADES',
            15=>'IMAGEN'
        );
        
        $q = '';
        $q_pre = 'INSERT INTO '.$this->pre.'articulos '.
            '(marca, referencia, p_n, nombre, stock, precio, precio_original, canon, categoria, subcategoria1, subcategoria2, subcategoria3, ean, prox_entrada, descripcion, compatibilidades, imagen) VALUES ';
        
        if (($gestor = fopen($filename, "r")) !== FALSE) {
            
            while (($datos = fgetcsv($gestor, 0, ";")) !== FALSE) {
                
                //verificacion de cabeceras-------------------------------------
                if ($fila == 1) {
                    if ($check_headers == true) {
                        foreach ($datos as $key => $val) {
                            if ($arr_headers_pattern[$key] != $val) {
                                return 3;
                            }
                        }
                        $check_headers = false;
                    }
                    
                    $this->execute_query('TRUNCATE '.$this->pre.'articulos ');
                } else { //proceso de insertar registros-------------------------
                    
                    $q = $q_pre;
                    
                    //si contiene la palabra "DESCATALOGADO" en datos[3] saltar bucle de while
                    //echo 'datos[3] = '.$datos[3].'<br>';
                    if (@strpos($datos[3], 'DESCATALOGADO') !== false) continue;
                    
                    foreach($datos as $key => $val) {
                        
                        //$aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                        //echo $val.'=>'.$aux_val.'<br><br>'; //para verificar la codificacion de caracteres
                        
                        switch ($key) {
                            case 0: //inicio
                                $aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $q .= '(\''.$aux_val.'\', ';
                            break;
                            case 4: //intermedio numerico (stock)
                                $aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $q .= $aux_val.', ';
                            break;
                            case 5: //decimal (precio)
                                //precio
                                $aux_subcategoria1 = htmlentities(mb_convert_encoding($datos[8], 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $aux_marca = htmlentities(mb_convert_encoding($datos[0], 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                
                                $aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $aux_val = str_replace(',', '.', $aux_val); //sql los valores menores a 0 (0,308) con coma los convierte a 0.000
                                $aux_val = $prM->get_precio($aux_subcategoria1, $aux_marca, $aux_val);
                                
                                $q .= '\''.$aux_val.'\', ';
                                
                                //precio original
                                $aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $aux_val = str_replace(',', '.', $aux_val); //sql los valores menores a 0 (0,308) con coma los convierte a 0.000
                                $q .= '\''.$aux_val.'\', ';
                            break;
                            case 6: //decimal (canon)
                                $aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $aux_val = str_replace(',', '.', $aux_val); //sql los valores menores a 0 (0,308) con coma los convierte a 0.000
                                $q .= '\''.$aux_val.'\', ';
                            break;
                            default: //intermedio texto
                                $aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $q .= '\''.$aux_val.'\', ';
                            break;
                            case 9 ://para subcategoria2 usar otra codificacion
                                //echo mb_detect_encoding($val).'<br>';
                                if (mb_detect_encoding($val) == 'UTF-8') {
                                    //echo $val.'<br>';
                                    $aux_val = $val;
                                } else {
                                    $aux_val = mb_convert_encoding($val, 'ASCII', 'UTF-8');
                                }
                                $q .= '\''.$aux_val.'\', ';
                            break;
                            case 15: //fin
                                $aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $q .= '\''.$aux_val.'\') ';
                            break;
                        }
                    }
                    $this->execute_query($q);
                }
                $fila++;
                //if ($fila > 100) break; //acortador de registros para debug
            }
            fclose($gestor);
        } else return 2;
        
        return true;
    }
}
?>