<?php

class farmaciasModel extends Model {
    
    function get_farmacias($ruta_inicio) {
        //csv example:
        //1;1;FARMACIA BERNA QUILES;Carrer Teniente Coronel Chapuli, 1;3001;ALACANT;ALICANTE;https://www.google.es/maps/place/Farmacia+Berna+Quiles/@36.9027133,-4.116296,17z/data=!4m5!3m4!1s0xd6237b22e1ad04b:0xe2df25345e536b7!8m2!3d38.3448531!4d-0.4839363;https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3190.483052807071!2d-4.116296!3d36.9027133!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6237b22e1ad04b%3A0xe2df25345e536b7!2sFarmacia+Berna+Quiles!5e0!3m2!1ses!2ses!4v1523865342891
        $return = array();
        $fila = 1;
        if (($gestor = fopen($ruta_inicio."/farmacias/adst_adelgaysana_farmacias.csv", "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                $return []= array(
                    'nombre'=>$datos[2],
                    'calle'=>$datos[3].' ('.$datos[4].' - '.$datos[5].')'
                );
            }
            fclose($gestor);
        }
        return $return;
    }

    function get_farmacias_importbbdd($ruta_inicio) {
        //csv example:
        //1;1;FARMACIA BERNA QUILES;Carrer Teniente Coronel Chapuli, 1;3001;ALACANT;ALICANTE;https://www.google.es/maps/place/Farmacia+Berna+Quiles/@36.9027133,-4.116296,17z/data=!4m5!3m4!1s0xd6237b22e1ad04b:0xe2df25345e536b7!8m2!3d38.3448531!4d-0.4839363;https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3190.483052807071!2d-4.116296!3d36.9027133!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6237b22e1ad04b%3A0xe2df25345e536b7!2sFarmacia+Berna+Quiles!5e0!3m2!1ses!2ses!4v1523865342891
        header('Content-Type: text/html; charset=UTF-8');
        date_default_timezone_set('Europe/Madrid');
        // Unix
        //setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $return = array();
        $fila = 1;
        if (($gestor = fopen($ruta_inicio."farmacias/farmacias.csv", "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                $return []= array(
                    'nombrecompleto_farmacia' => utf8_encode($datos[0]),
                    'direccion_farmacia' => utf8_encode($datos[1]),
                    'codigopostal_farmacia' => $datos[2],
                    'poblacion_farmacia' => utf8_encode($datos[3]),
                    'provincia_farmacia' => utf8_encode($datos[4]),
                    'link_gmaps_farmacia' => utf8_encode($datos[5]),
                    'link_embed_farmacia' => utf8_encode($datos[6]),
                );
            }
            fclose($gestor);
        }
        return $return;
    }

    function delete_farmacias(){
        $q = ' DELETE FROM adst_adelgaysana_farmacias ';
        return $this->execute_query($q);
    }

    function reset_farmacias(){
        $q = ' ALTER TABLE adst_adelgaysana_farmacias AUTO_INCREMENT = 1 ';
        return $this->execute_query($q);
    }

    function add_farmacia($nombrecompleto_farmacia, $direccion_farmacia, $codigopostal_farmacia, $poblacion_farmacia, $provincia_farmacia, $link_gmaps_farmacia, $link_embed_farmacia=""){
        $q  = ' INSERT INTO adst_adelgaysana_farmacias (nombrecompleto_farmacia, direccion_farmacia, codigopostal_farmacia, poblacion_farmacia, provincia_farmacia, link_gmaps_farmacia, link_embed_farmacia) VALUES ';
        $q .= ' ("'.$nombrecompleto_farmacia.'", "'.$direccion_farmacia.'", "'.$codigopostal_farmacia.'", "'.$poblacion_farmacia.'", "'.$provincia_farmacia.'", "'.$link_gmaps_farmacia.'", "'.$link_embed_farmacia.'")';
        return $this->execute_query($q);
    }
}

?>