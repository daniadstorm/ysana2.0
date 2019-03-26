<?php
$urlYsana=false;
if($_SERVER["REQUEST_URI"]=="/ysana/clubysana/"){
    $urlYsana=true;
}
$outIdioma = '';
$outComodin = '';
$rutaysana = '';
$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');
if($clubysana!=''){
    $rutaysana = 'clubysana/';
}
foreach ($arrlang as $key => $value) {
    if($lang==$value){
        $outIdioma .= '<a class="nav-link dropdown-toggle -'.$clubysana.'" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$value.'</a>';
    }
    $outComodin .= '<a class="dropdown-item -'.$clubysana.'" href="'.$ruta_actual.'?idioma_seleccionado='.$value.'">'.$value.'</a>';
}
?>

<div class="navbar-ad">
    <div id="panel-top" class="max-ysana mt-2">
        <div class="ttl">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link bienvenidoysana -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>">Bienvenido a Ysana Vida Sana</a>
                </li>
            </ul>
        </div>
        <div class="top-menu">
            <div class="d-none d-md-block">
                <ul class="nav">
                    <li class="nav-item no-drop">
                        <div class="rrss-top">
                            <img src="<?php echo $ruta_inicio; ?>img/redes/8.svg" class="mx-1" width="24px" alt="">
                            <img src="<?php echo $ruta_inicio; ?>img/redes/7.svg" class="mx-1" width="24px" alt="">
                            <img src="<?php echo $ruta_inicio; ?>img/redes/1.svg" class="mx-1" width="24px" alt="">
                            <img src="<?php echo $ruta_inicio; ?>img/redes/2.svg" class="mx-1" width="24px" alt="">
                        </div>
                    </li>
                    <?php if(!isset($_SESSION['id_usuario'])){ ?>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio.$rutaysana; ?>login">Acceder</a>
                        </li>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio.$rutaysana; ?>registro">Date de alta</a>
                        </li>
                    <?php }else{ ?>
                        <?php if($_SESSION['id_tipo_usuario']==ADMIN){ ?>
                            <li class="nav-item no-drop">
                                <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>admin">Panel admin</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>profile">Mi Perfil</a>
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
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>