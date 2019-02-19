<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$rrssM = load_model('rrss');

$last_update = date('d/m/Y H:i:s');
$today = date('d-m-Y');

$fb_fan_count_today = 0;
$ig_followers_today = 0;

$ov = ''; //output visitas

//TW____________________________________________________________________________
$rgtw = $rrssM->get_tw();

$tw_followers_current = $rgtw->{'followers_current'};
$tw_followers_yesterday = $rgtw->{'followers_yesterday'};
$tw_followers_today = $tw_followers_current - $tw_followers_yesterday;
//TW____________________________________________________________________________

//FB____________________________________________________________________________
$rgfb = $rrssM->get_fb();
if (isset($rgfb[0])) {

    $fb_fan_count = $rgfb[0];

    if (isset($_SESSION[$today]['fb'])) {
        $fb_fan_count_today = $fb_fan_count - $_SESSION[$today]['fb'];
    } else {
        $_SESSION[$today]['fb'] = $fb_fan_count;
        $fb_fan_count_today = 0;
    }
} else {
    $fb_fan_count = '.';
    $fb_fan_count_today = '.';
}
//FB____________________________________________________________________________

//IG____________________________________________________________________________
$rgig = $rrssM->get_ig();

$rgiglp = $rrssM->get_ig_last_photo();

$link_publicacion_ig = $rgiglp->{'data'}[0]->{'link'};

if (isset($rgig->{'data'}->{'counts'}->{'followed_by'})) {

    $ig_followers_current = $rgig->{'data'}->{'counts'}->{'followed_by'};

    if (isset($_SESSION[$today]['ig'])) {
        $ig_followers_today = $ig_followers_current - $_SESSION[$today]['ig'];
    } else {
        $_SESSION[$today]['ig'] = $ig_followers_current;
        $ig_followers_today = 0;
    }
} else {
    $ig_followers_current = 'err';
}
//IG____________________________________________________________________________

//PARTICIPANTES ADELGAYSANA_____________________________________________________
$participantes_adelgaysana = $rrssM->get_participantes_adelgaysana();
//PARTICIPANTES ADELGAYSANA_____________________________________________________

//GA____________________________________________________________________________
$visitas_hoy_ysanahome = $rrssM->get_visitas_hoy_ysanahome();
$total_visitas_ysanahome = $rrssM->get_total_visitas_ysanahome();
$visitas_hoy_adelgaysana = $rrssM->get_visitas_hoy_adelgaysana();
$total_visitas_adelgaysana = $rrssM->get_total_visitas_adelgaysana();
//GA____________________________________________________________________________

//CLASS SELECTOR________________________________________________________________
if (!isset($_SESSION['ysana-dashboard-web-bg'])) {
    $_SESSION['ysana-dashboard-web-bg'] = 'ysana-dashboard-web-home-bg';
} else {
    if ($_SESSION['ysana-dashboard-web-bg'] == 'ysana-dashboard-web-home-bg') {
        $_SESSION['ysana-dashboard-web-bg'] = 'ysana-dashboard-web-adelgaysana-bg';
    } else {
        $_SESSION['ysana-dashboard-web-bg'] = 'ysana-dashboard-web-home-bg';
    }
}
//CLASS SELECTOR________________________________________________________________

//CONTENT SELECTOR______________________________________________________________
if ($_SESSION['ysana-dashboard-web-bg'] == 'ysana-dashboard-web-home-bg') {
    //YSANA.ES
    $ov .= '<div class="ysana-dashboard-element-ttl">';
    $ov .=  'VISITAS WEB';
    $ov .= '</div>';
    
    //DIARIA--------------------------------------------------------------------
    $ov .= '<div class="ysana-dashboard-element-body">';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=      '<div class="ysana-dashboard-element-lbl">';
    $ov .=          'Hoy';
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:50%;">';
    $ov .=      '<div class="ysana-dashboard-element-contador">';
    $ov .=          $visitas_hoy_ysanahome;
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=  '</div>';
    $ov .=  '<div style="clear:both;"></div>';
    $ov .= '</div>';
    //DIARIA--------------------------------------------------------------------
    
    //TOTAL---------------------------------------------------------------------
    $ov .= '<div class="ysana-dashboard-element-body">';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=      '<div class="ysana-dashboard-element-lbl">';
    $ov .=          'Total';
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:50%;">';
    $ov .=      '<div class="ysana-dashboard-element-contador">';
    $ov .=          $total_visitas_ysanahome;
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=  '</div>';
    $ov .=  '<div style="clear:both;"></div>';
    $ov .= '</div>';
    //TOTAL---------------------------------------------------------------------
    
    $ov .= '<div class="ysana-dashboard-sep"></div>';
    
    $ov .= '<div class="ysana-dashboard-element-body">';
    $ov .=  '<div class="ysana-dashboard-element-ttl">';
    $ov .=      'visitas en ysana.es';
    $ov .=  '</div>';
    $ov .= '</div>';
    
} else {
    //ADELGAYSANA
    $ov .= '<div class="ysana-dashboard-element-ttl">';
    $ov .=  'VISITAS adelgaYsana';
    $ov .= '</div>';
    
    //DIARIA--------------------------------------------------------------------
    $ov .= '<div class="ysana-dashboard-element-body">';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=      '<div class="ysana-dashboard-element-lbl">';
    $ov .=          'Hoy';
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:50%;">';
    $ov .=      '<div class="ysana-dashboard-element-contador">';
    $ov .=          $visitas_hoy_adelgaysana;
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=  '</div>';
    $ov .=  '<div style="clear:both;"></div>';
    $ov .= '</div>';
    //DIARIA--------------------------------------------------------------------
    
    //TOTAL---------------------------------------------------------------------
    $ov .= '<div class="ysana-dashboard-element-body">';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=      '<div class="ysana-dashboard-element-lbl">';
    $ov .=          'Total';
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:50%;">';
    $ov .=      '<div class="ysana-dashboard-element-contador">';
    $ov .=          $total_visitas_adelgaysana;
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=  '</div>';
    $ov .=  '<div style="clear:both;"></div>';
    $ov .= '</div>';
    //TOTAL---------------------------------------------------------------------
    
    $ov .= '<div class="ysana-dashboard-sep"></div>';
    
    $ov .= '<div class="ysana-dashboard-element-ttl">';
    $ov .=  'PARTICIPANTES CONCURSO adelgaYsana';
    $ov .= '</div>';
    
    //TOTAL PARTICIPANTES-------------------------------------------------------
    $ov .= '<div class="ysana-dashboard-element-body">';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=      '<div class="ysana-dashboard-element-lbl">';
    $ov .=          'Total';
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:50%;">';
    $ov .=      '<div class="ysana-dashboard-element-contador">';
    $ov .=          $participantes_adelgaysana;
    $ov .=      '</div>';
    $ov .=  '</div>';
    $ov .=  '<div style="float:left;width:25%;">';
    $ov .=  '</div>';
    $ov .=  '<div style="clear:both;"></div>';
    $ov .= '</div>';
    //TOTAL PARTICIPANTES-------------------------------------------------------
    
    $ov .= '<div class="ysana-dashboard-sep"></div>';
    
    $ov .= '<div class="ysana-dashboard-element-body">';
    $ov .=  '<div class="ysana-dashboard-element-ttl">';
    $ov .=      'visitas en ysana.es/adelgaysana';
    $ov .=  '</div>';
    $ov .= '</div>';
}
//CONTENT SELECTOR______________________________________________________________

include_once('inc/cabecera.inc.php'); //cargando cabecera
?>
<script type="text/javascript">
    $( document ).ready(function() {
        setTimeout(function () {
            location.reload();
        }, 45000);
    });
</script>
<body>
<div id="main-container">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.0&appId=160998798082185&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <div class="ysana-dashboard-ttl">
        <div class="responsive-seccion">
            <div style="float:left;width:25%;">
                <a href="http://ysana.es/dashboard" target="_blank">
                    <img src="img/ysana-vida-sana-ttl.png"
                         alt="Ysana VIDA SANA" />
                </a>
            </div>
            <div style="float:left;width:50%;">
                <h1>PANEL DE CONTROL YSANA</h1>
            </div>
            <div style="float:right;width:25%;">
                <div class="last-update">
                    Última actualización: <span class="last-update-date"><?php echo $last_update; ?></span>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    <div class="ysana-dashboard-holder">
        <div class="responsive-seccion">
            <div class="ysana-dashboard-element ysana-dashboard-tw-holder">
                <div class="ysana-dashboard-tw-icon">
                    <img src="img/Ysana_dashboard_tw.png" />
                </div>
                <div class="ysana-dashboard-tw-body">
                    <div class="ysana-dashboard-element-ttl">
                        SEGUIDORES
                    </div>
                    <div class="ysana-dashboard-element-body">
                        <div style="float:left;width:25%;">
                            <div class="ysana-dashboard-element-lbl">
                                Hoy
                            </div>
                        </div>
                        <div style="float:left;width:50%;">
                            <div class="ysana-dashboard-element-contador">
                                <?php echo $tw_followers_today; ?>
                            </div>
                        </div>
                        <div style="float:left;width:25%;">
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div class="ysana-dashboard-element-body">
                        <div style="float:left;width:25%;">
                            <div class="ysana-dashboard-element-lbl">
                                Total
                            </div>
                        </div>
                        <div style="float:left;width:50%;">
                            <div class="ysana-dashboard-element-contador">
                                <?php echo $tw_followers_current; ?>
                            </div>
                        </div>
                        <div style="float:left;width:25%;">
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
                <div class="ysana-dashboard-lim"></div>
                <div class="ysana-dashboard-element-footer">
                    <a class="twitter-timeline" data-tweet-limit="1" href="https://twitter.com/Ysana_Vida_Sana?ref_src=twsrc%5Etfw">Tweets by Ysana_Vida_Sana</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>
            <div class="ysana-dashboard-element ysana-dashboard-fb-holder">
                <div class="ysana-dashboard-fb-icon">
                    <img src="img/Ysana_dashboard_fb.png" />
                </div>
                <div class="ysana-dashboard-fb-body">
                    <div class="ysana-dashboard-element-ttl">
                        LIKES
                    </div>
                    <div class="ysana-dashboard-element-body">
                        <div style="float:left;width:25%;">
                            <div class="ysana-dashboard-element-lbl">
                                Hoy
                            </div>
                        </div>
                        <div style="float:left;width:50%;">
                            <div class="ysana-dashboard-element-contador">
                                <?php echo $fb_fan_count_today; ?>
                            </div>
                        </div>
                        <div style="float:left;width:25%;">
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div class="ysana-dashboard-element-body">
                        <div style="float:left;width:25%;">
                            <div class="ysana-dashboard-element-lbl">
                                Total
                            </div>
                        </div>
                        <div style="float:left;width:50%;">
                            <div class="ysana-dashboard-element-contador">
                                <?php echo $fb_fan_count; ?>
                            </div>
                        </div>
                        <div style="float:left;width:25%;">
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div class="ysana-dashboard-lim"></div>
                    <div class="ysana-dashboard-element-footer">
<div class="fb-page" data-href="https://www.facebook.com/YSanaVidaSana" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/YSanaVidaSana" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/YSanaVidaSana">Ysana Vida Sana</a></blockquote></div></div>
                </div>
            </div>
            <div class="ysana-dashboard-element ysana-dashboard-ig-holder">
                <div class="ysana-dashboard-ig-icon">
                    <img src="img/Ysana_dashboard_insta.png" />
                </div>
                <div class="ysana-dashboard-ig-body">
                    <div class="ysana-dashboard-element-ttl">
                        SEGUIDORES
                    </div>
                    <div class="ysana-dashboard-element-body">
                        <div style="float:left;width:25%;">
                            <div class="ysana-dashboard-element-lbl">
                                Hoy
                            </div>
                        </div>
                        <div style="float:left;width:50%;">
                            <div class="ysana-dashboard-element-contador">
                                <?php echo $ig_followers_today; ?>
                            </div>
                        </div>
                        <div style="float:left;width:25%;">
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div class="ysana-dashboard-element-body">
                        <div style="float:left;width:25%;">
                            <div class="ysana-dashboard-element-lbl">
                                Total
                            </div>
                        </div>
                        <div style="float:left;width:50%;">
                            <div class="ysana-dashboard-element-contador">
                                <?php echo $ig_followers_current; ?>
                            </div>
                        </div>
                        <div style="float:left;width:25%;">
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
                <div class="ysana-dashboard-lim"></div>
                <div class="ysana-dashboard-element-footer" style="text-align: center;">
                    <iframe src="<?php echo $link_publicacion_ig; ?>embed" width="100%" height="100%" frameborder="0" scrolling="no" allowtransparency="true"></iframe>
                </div>
            </div>
            <div class="ysana-dashboard-element ysana-dashboard-web-holder <?php echo $_SESSION['ysana-dashboard-web-bg']; ?>">
                <div class="ysana-dashboard-web-icon">
                    <img src="img/Ysana_dashboard_ysana.png" class="<?php echo $_SESSION['ysana-dashboard-web-bg']; ?>" />
                </div>
                <div class="ysana-dashboard-web-body">
                    <?php echo $ov; ?>
                </div>
                <div id="embed-api-auth-container"></div>
                <div id="chart-container"></div>
                <div id="view-selector-container"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>
</body>
</html>
