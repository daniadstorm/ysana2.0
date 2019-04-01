<?php
$urlYsana=false;
if($_SERVER["REQUEST_URI"]=="/ysana/clubysana/"){
    $urlYsana=true;
}
$outIdioma = '';
$outComodin = '';
$rutaysana = '';
$frmIdioma = '';
if(isset($_SERVER['REDIRECT_URL'])){
    if(!strpos($_SERVER['REDIRECT_URL'], "/ysana/login/") && !strpos($_SERVER['REDIRECT_URL'], "/ysana/registro/") && !strpos($_SERVER['REDIRECT_URL'], "/ysana/clubysana/login/") && !strpos($_SERVER['REDIRECT_URL'], "/ysana/clubysana/registro/")){
        $request_uri = (isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '');
    }else{
        $request_uri = '';
    }
}else{
    $request_uri = '';
}

$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');
if($clubysana!=''){
    $rutaysana = 'clubysana/';
}
foreach ($arrlang as $key => $value) {
    if($lang==$value){
        $outIdioma .= '<a class="nav-link dropdown-toggle -'.$clubysana.'" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$value.'</a>';
    }
    $outComodin .= '<a nombre="idioma'.$value.'" class="dropdown-item frmidioma -'.$clubysana.'" href="#">'.$value.'</a>';
    $frmIdioma .= '<form class="d-none" id="idioma'.$value.'" method="post"><input name="idioma_seleccionado" type="text" value="'.$value.'"></form>';
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.frmidioma').on('click', function(){
            $("#"+$(this).attr("nombre")).submit();
        });
    });
</script>
<div class="navbar-ad">
    <div id="panel-top" class="max-ysana">
        <div class="ttl">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link bienvenidoysana -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>"><?php echo ($clubysana) ? 'Bienvenido a ClubYsana' : 'Bienvenido a Ysana Vida Sana' ?></a>
                </li>
            </ul>
        </div>
        <div class="top-menu">
            <div class="d-none d-md-block">
                <ul class="nav">
                    <li class="nav-item no-drop">
                        <div class="rrss-top">
                            <a target="_blank" href="https://www.instagram.com/ysanavidasana/"><img src="<?php echo $ruta_inicio; ?>img/redes/8.svg" class="mx-1" width="24px" alt=""></a>
                            <a target="_blank" href="https://es-es.facebook.com/YSanaVidaSana/"><img src="<?php echo $ruta_inicio; ?>img/redes/7.svg" class="mx-1" width="24px" alt=""></a>
                            <a target="_blank" href="https://twitter.com/Ysana_Vida_Sana"><img src="<?php echo $ruta_inicio; ?>img/redes/1.svg" class="mx-1" width="24px" alt=""></a>
                            <a href="<?php echo $ruta_blog; ?>"><img src="<?php echo $ruta_inicio; ?>img/redes/2.svg" class="mx-1" width="24px" alt=""></a>
                        </div>
                    </li>
                    <?php if(!isset($_SESSION['id_usuario'])){ ?>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio.$rutaysana; ?>login?ruta_anterior=<?php echo $request_uri; ?>">Acceder</a>
                        </li>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio.$rutaysana; ?>registro?ruta_anterior=<?php echo $request_uri; ?>">Date de alta</a>
                        </li>
                    <?php }else{ ?>
                        <?php if($_SESSION['id_tipo_usuario']==ADMIN){ ?>
                            <li class="nav-item no-drop">
                                <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>admin">Panel admin</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?><?php echo ($clubysana!='') ? 'clubysana/' : ''; ?>profile">Mi Perfil</a>
                        </li>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>login?unlogin">Cerrar sesión</a>
                        </li>
                    <?php } ?>
                    <li id="dropdown-idioma" class="nav-item dropdown dropleft">
                        <?php echo $outIdioma; ?>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php echo $outComodin; ?>
                        </div>
                        <?php echo $frmIdioma; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>