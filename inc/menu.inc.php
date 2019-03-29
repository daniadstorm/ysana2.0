<?php 
$url = $_SERVER['REQUEST_URI'];
$outMenu = '';
$arrMenu = array(
    1 => array(
        1 => array( 'txt'=>'Inicio', 'url'=>'' ),
        2 => array( 'txt'=>'Productos', 'url'=>'productos-ysana' ),
        3 => array( 'txt'=>'Experiencias', 'url'=>'experiencia' ),
        4 => array( 'txt'=>'Farmacias', 'url'=>'directo-farmacia' ),
        5 => array( 'txt'=>'Club Ysana', 'url'=>'clubysana' ),
        6 => array( 'txt'=>'Contacto', 'url'=>'#form-contacto')
    ),
    2 => array(
        1 => array( 'txt'=>'Inicio', 'url'=>'' ),
        2 => array( 'txt'=>'Productos', 'url'=>'productos-ysana' ),
        3 => array( 'txt'=>'Experiencias', 'url'=>'experiencia' ),
        4 => array( 'txt'=>'Farmacias', 'url'=>'directo-farmacia' ),
        5 => array( 'txt'=>'Club Ysana', 'url'=>'#' ),
        6 => array( 'txt'=>'Contacto', 'url'=>'#form-contacto')
    )
);
foreach ($arrMenu[$_SESSION['id_lang']] as $key => $value) {
    $url_format = '/ysana/'.$value['url'].'/';
    $url_format = str_replace('//', '/', $url_format);
    $outMenu .= '<li class="nav-item '.($url_format==$url ? 'active' : '').'"><a class="nav-link" href="'.$ruta_inicio.$value['url'].'">'.$value['txt'].'</a></li>';
}
?>

<header id="menu-top" class="max-ysana">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="<?php echo $ruta_inicio; ?>">
            <img src="<?php echo $ruta_inicio; ?>img/logos/ysanacolor.svg" width="128px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <?php echo $outMenu; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>carrito">
                        <img src="<?php echo $ruta_inicio; ?>img/svg/carrito-01.svg" width="32px" alt="">
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>