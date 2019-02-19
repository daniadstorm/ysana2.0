<?php
/* DRIVER DE BASE DE DATOS */
//se carga desde 'config/config.inc.php'

class Model {
    /*
    private $host_bd = 'localhost';
    private $name_bd = 'adst_adelgaysana';
    private $user_bd = 'root';
    private $pass_bd = '';
    public $pre = 'adst_adelgaysana_';
    */
    
    private $host_bd = '37.60.224.6';
    private $name_bd = 'steamp85_wp432';
    private $user_bd = 'steamp85_wp432';
    private $pass_bd = '-9ypJ11S)K';
    public $pre = 'adst_adelgaysana_';
    
    private $link_bd = false;
    
    function conectar_bd() {
        $this->link_bd = new mysqli($this->host_bd, $this->user_bd, $this->pass_bd, $this->name_bd);
        return $this->link_bd;
    }
    
    function execute_query($query) {
        $this->conectar_bd();
        $this->link_bd->query("SET NAMES 'utf8'"); //correccion para que busque caracters especiales (acentos, ç, ...)
        return $this->link_bd->query($query);
    }
    
    function escstr($str) {
        if (!$this->link_bd) $this->conectar_bd ();
        //return mysql_real_escape_string($str, $this->link_bd);
        return $this->link_bd->real_escape_string($str);
    }
    
    function get_insert_id() {
        return $this->link_bd->insert_id;
    }
    
    function get_affected_rows() {
        return $this->link_bd->affected_rows;
    }
    
    function date_to_mysql_datetime($date='now', $is_fechafin=false) {
        
        if (strlen($date) < 1) return '';
        
        $pattern = '';
        $time_append = '';
        
        switch ($date) {
            case 'now':
                $pattern = 'Y-m-d';
                $date = date($pattern);
                
                if ($is_fechafin) $time_append .= ' 23:59:59';
                    else $time_append .= ' 00:00:00';
            break;
            case 'complete':
                $pattern = 'Y-m-d H:i:s';
                $date = date($pattern);
            break;
            default:
                $pattern = 'Y-m-d';
                if ($is_fechafin) $time_append .= ' 23:59:59';
                    else $time_append .= ' 00:00:00';
            break;
        }
        
        $date = str_replace('/', '-', $date);
        $date = date($pattern,strtotime($date));
        $date .= $time_append;
            
        return $date;
    }
    
    function mysql_datetime_to_date($datetime) {
        $date = strtotime($datetime);
        return date('d/m/Y', $date);
    }
    
    function mysql_datetime_to_datetime($datetime) {
        $date = strtotime($datetime);
        return date('d/m/Y H:i:s', $date);
    }
    
    function get_formatted_price($precio) {
        return number_format((float)$precio, 2, ',', '');
    }
    
    function import_csv($filename) {
        $fila = 1;
        $check_headers = true;
        
        $q = '';
        $q_pre = ' UPDATE '.$this->pre.'farmacias SET ';
        /*
        $q_pre = 'INSERT INTO '.$this->pre.'farmacias '.
            '(nombrecompleto_farmacia, direccion_farmacia, codigopostal_farmacia, poblacion_farmacia, provincia_farmacia, link_gmaps_farmacia) VALUES ';
        */
        if (($gestor = fopen($filename, "r")) !== FALSE) {
            
            while (($datos = fgetcsv($gestor, 0, ";")) !== FALSE) {
                
                //verificacion de cabeceras-------------------------------------
                if ($fila == 1) {
                    
                } else { //proceso de insertar registros-------------------------
                    
                    $q = $q_pre;
                    
                    foreach($datos as $key => $val) {
                        //Nombre;DIRECCION;C.P.;POBLACION;PROVINCIA;LINK GMAPS
                        //$aux_val = $val;
                        switch ($key) {
                            case 0: //inicio
                                //$aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $aux_val = mb_convert_encoding($val, 'UTF-8', 'ASCII');
                                //$q .= '(\''.$aux_val.'\', ';
                            break;
                            
                            default: //intermedio texto
                                //$aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $aux_val = mb_convert_encoding($val, 'UTF-8', 'ASCII');
                                //$q .= '\''.$aux_val.'\', ';
                            break;
                            
                            case 5: //fin
                                //$aux_val = htmlentities(mb_convert_encoding($val, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
                                $aux_val = mb_convert_encoding($val, 'UTF-8', 'ASCII');
                                //$q .= '\''.$aux_val.'\') ';
                            break;
                            case 6:
                                $aux_val = mb_convert_encoding($val, 'UTF-8', 'ASCII');
                                $q .= ' link_embed_farmacia = \''.$aux_val.'\' ';
                                $q .= ' WHERE link_gmaps_farmacia = \''.mb_convert_encoding($datos[5], 'UTF-8', 'ASCII').'\' ';
                        }
                    }
                    //echo $q.'<br>';
                    $this->execute_query($q);
                }
                $fila++;
                //if ($fila > 2) break; //acortador de registros para debug
            }
            fclose($gestor);
        } else return 2;
        
        return true;
    }
}
?>