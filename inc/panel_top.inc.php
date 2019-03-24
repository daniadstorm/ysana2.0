<?php
$arr_idioma = array(
    'spa' => '<img src="'.$ruta_inicio.'img/esp-idioma.png" width="16px">',
    'eng' => '<img src="'.$ruta_inicio.'img/eng-idioma.png" width="16px">'
);
$urlYsana=false;
if($_SERVER["REQUEST_URI"]=="/ysana/clubysana/"){
    $urlYsana=true;
}
?>

<div class="navbar-ad">
    <div id="panel-top" class="max-ysana mt-2">
        <div class="ttl">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link bienvenidoysana" href="#">Bienvenido a Ysana Vida Sana</a>
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
                        <a class="nav-link" href="#">Acceder</a>
                    </li>
                    <li class="nav-item no-drop">
                        <a class="nav-link" href="#">Date de alta</a>
                    </li>
                    <li id="dropdown-idioma" class="nav-item dropdown dropleft">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SP</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>