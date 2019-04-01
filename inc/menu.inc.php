<?php 
$url = $_SERVER['REQUEST_URI'];
$outMenu = '';
$carritoTotal = '0';
$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';
$cM = load_model('carrito');
$arrMenu = array(
    1 => array( 'txt'=>$lng[135], 'url'=>'' ),
    2 => array( 'txt'=>$lng[136], 'url'=>'productos-ysana' ),
    3 => array( 'txt'=>$lng[158], 'url'=>'blog' ),
    4 => array( 'txt'=>$lng[137], 'url'=>'experiencia' ),
    5 => array( 'txt'=>$lng[138], 'url'=>'directo-farmacia' ),
    6 => array( 'txt'=>$lng[139], 'url'=>'clubysana' ),
    7 => array( 'txt'=>$lng[140], 'url'=>'#form-contacto')
);
foreach ($arrMenu as $key => $value) {
    $url_format = '/ysana/'.$value['url'].'/';
    $url_format = str_replace('//', '/', $url_format);
    $outMenu .= '<li class="nav-item '.($url_format==$url ? 'active' : '').'"><a class="nav-link" href="'.$ruta_inicio.$value['url'].'">'.$value['txt'].'</a></li>';
}
if($id_usuario!='') $carritoTotal = $cM->get_total_carrito($id_usuario);
?>

<header id="menu-top" class="max-ysana">
    <nav class="navbar navbar-expand-lg navbar-light px-3">
        <a class="navbar-brand mx-0 ml-2" href="<?php echo $ruta_inicio; ?>">
            <img src="<?php echo $ruta_inicio; ?>img/logos/ysanacolor.svg" width="128px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto centrar-menu">
                <?php echo $outMenu; ?>
                <li class="nav-item nav-item-carrito">
                    <label><?php echo $carritoTotal; ?></label>
                    <a class="nav-link" href="<?php echo $ruta_inicio; ?>carrito">
                        <img src="<?php echo $ruta_inicio; ?>img/svg/carrito-01.svg" width="32px" alt="">
                    </a>
                </li>
                <div class="menu-movil">
                    <?php if(!isset($_SESSION['id_usuario'])){ ?>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio.$rutaysana; ?>login?ruta_anterior=<?php echo $request_uri; ?>"><?php echo $lng[143]; ?></a>
                        </li>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio.$rutaysana; ?>registro?ruta_anterior=<?php echo $request_uri; ?>"><?php echo $lng[144]; ?></a>
                        </li>
                    <?php }else{ ?>
                        <?php if($_SESSION['id_tipo_usuario']==ADMIN){ ?>
                            <li class="nav-item no-drop">
                                <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>admin">Panel admin</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?><?php echo ($clubysana!='') ? 'clubysana/' : ''; ?>profile"><?php echo $lng[145]; ?></a>
                        </li>
                        <li class="nav-item no-drop">
                            <a class="nav-link -<?php echo $clubysana; ?>" href="<?php echo $ruta_inicio; ?>login?unlogin"><?php echo $lng[146]; ?></a>
                        </li>
                    <?php } ?>
                    <li id="dropdown-idioma" class="nav-item dropdown dropleft">
                        <?php echo $outIdioma; ?>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php echo $outComodin; ?>
                        </div>
                        <?php echo $frmIdioma; ?>
                    </li>
                </div>
            </ul>
        </div>
    </nav>
</header>