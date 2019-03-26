<?php
$urlYsana=false;
if($_SERVER["REQUEST_URI"]=="/ysana/clubysana/"){
    $urlYsana=true;
}
$outIdioma = '';
$outComodin = '';

foreach ($arrlang as $key => $value) {
    if($lang==$value){
        $outIdioma .= '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$value.'</a>';
    }
    $outComodin .= '<a class="dropdown-item" href="'.$ruta_actual.'?idioma_seleccionado='.$value.'">'.$value.'</a>';
}
?>

<div class="navbar-ad">
    <div id="panel-top" class="max-ysana mt-2">
        <div class="ttl">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link bienvenidoysana" href="<?php echo $ruta_inicio; ?>">Bienvenido a Ysana Vida Sana</a>
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
                    <li class="nav-item no-drop">
                        <a class="nav-link" href="<?php echo $ruta_inicio; ?>login">Acceder</a>
                    </li>
                    <li class="nav-item no-drop">
                        <a class="nav-link" href="<?php echo $ruta_inicio; ?>registro">Date de alta</a>
                    </li>
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