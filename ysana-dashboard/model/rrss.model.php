<?php

class rrssModel extends Model {
    
    const TW_API_KEY = '025015a4b1116677bf0f2fcf0593a1bc';
    const TW_API_USERID = '2370248377';
    
    const FB_API_KEY = 'EAACSbXQrQIkBAEppzsoyAxlMfIdfdETj1EowFqytSuOjGnoJiXiq9nK964bJIDLPvZC0ho0ZCPIZB2DRcU8CKEXDZAp7hciGAvxOmxYp9IaZCwIsdcUmsKMZCs0jnvH7oMeiwcks7VpiNmzavy8fY5eCQnruWPbHSWCUbodTHMxAZDZD';
    const FB_API_USERID = 'YSanaVidaSana';
    
    const IG_API_KEY = '4553316207.5f6b5b5.00f2c37f2b904d8fbe2b79dabdd067d3';
   
    /*
    const GA_API_KEY = '949860246557-l4nsn923b88tt2830drji915fnq6io8b.apps.googleusercontent.com';
    const GA_CLIENT_SECRET = 'zc_6J2HOw8o4rm6jDY6j30MK';
    const GA_VIEW_ID_ysana = '160301715';
    */
    
    public $total_sesiones_adelgaysana = 1693;
    public $total_sesiones_ysana = 640;
    
    function get_tw() {
        $tw_url = 'http://api.twittercounter.com?twitter_id='.self::TW_API_USERID.'&apikey='.self::TW_API_KEY;
        return $this->execute_url($tw_url);
    }
    
    function get_fb() {
	$arrSeguidores = array();
        /*$fb_url = 'https://graph.facebook.com/'.self::FB_API_USERID.'?access_token='.self::FB_API_KEY.'&fields=name,fan_count';
        return $this->execute_url($fb_url);*/
	include('lib/simple_html_dom.php');
	$opc = array('http'=>array('header'=>"User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53\r\n"));
	$context = stream_context_create($opc);
	$html = file_get_html("https://www.facebook.com/pg/YSanaVidaSana/community/?ref=page_internal",false, $context);
	foreach($html->find('div') as $element){
    		if(is_numeric($element->innertext)){array_push($arrSeguidores,$element->innertext);}
	}
	return $arrSeguidores;
    }
    
    function get_ig() {
        $ig_url = 'https://api.instagram.com/v1/users/self/?access_token='.self::IG_API_KEY;
        return $this->execute_url($ig_url);
    }
    
    function get_ig_last_photo() {
        $ig_url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.self::IG_API_KEY.'&count=1';
        return $this->execute_url($ig_url);
    }
    
    /*
    function get_ga_api_key() {
        return self::GA_API_KEY;
    }
    */
    
    function get_visitas_hoy_ysanahome() {
        $hoy = date('Y-m-d');
        
        $q  = ' SELECT vh.* FROM '.$this->pre.'visitashome vh ';
        $q .= ' WHERE vh.fechahora LIKE "'.$hoy.'%" ';
        $r = $this->execute_query($q);
        if ($r) {
            return $r->num_rows;
        } else return false;
    }
    
    function get_total_visitas_ysanahome() {
        $q  = ' SELECT vh.* FROM '.$this->pre.'visitashome vh ';
        $r = $this->execute_query($q);
        if ($r) {
            return $r->num_rows + $this->total_sesiones_ysana;
        } else return false;
    }
    
    function get_visitas_hoy_adelgaysana() {
        $hoy = date('Y-m-d');
        
        $q  = ' SELECT v.* FROM '.$this->pre.'visitas v ';
        $q .= ' WHERE v.fechahora LIKE "'.$hoy.'%" ';
        $r = $this->execute_query($q);
        if ($r) {
            return $r->num_rows;
        } else return false;
    }
    
    function get_total_visitas_adelgaysana() {
        $q  = ' SELECT v.* FROM '.$this->pre.'visitas v ';
        $r = $this->execute_query($q);
        if ($r) {
            return $r->num_rows + $this->total_sesiones_adelgaysana;
        } else return false;
    }
    
    function get_participantes_adelgaysana() {
        $q  = ' SELECT id_participante FROM '.$this->pre.'participantes ';
        $r = $this->execute_query($q);
        if ($r) {
            return $r->num_rows;
        } else return false;
    }
    
    function execute_url($url) {
        // create curl resource 
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
        $output = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch); 
        //echo $output.'<br><br>'; //DEBUG
        return json_decode($output);
    }
    
}
?>