<?php
$html_mmnu = '';
$arr_mmnu = array(
    1 => array('txt'=>'Inicio admin', 'url'=>'admin.php'),
    2 => array('txt'=>'Mails', 'url'=>'mails.php'),
    3 => array('txt'=>'Ver Productos', 'url'=>'ver-productos.php'),
    4 => array('txt'=>'Añadir productos', 'url'=>'admin-productos.php'),
    5 => array('txt'=>'Farmacias', 'url'=>'importar-farmacias.php'),
    6 => array('txt'=>'Club Ysana', 'url'=>'admin-clubysana.php')
);

foreach ($arr_mmnu as $k => $v) {
    //<li class="nav-item active">
      //<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
    //</li>
    
    //<li class="nav-item">
      //<a class="nav-link" href="#">Link</a>
    //</li>
    
    $html_mmnu .= '<li class="nav-item">';
    $html_mmnu .=   '<a class="nav-link" href="'.$v['url'].'">'.$v['txt'].'</a>';
    $html_mmnu .= '</li>';
}
    /* $html_mmnu .= '<li class="nav-item d-block d-sm-none">';
    $html_mmnu .=   '<a class="nav-link text-light" href="'.$ruta_inicio.'"new-account.php>Iniciar Sesión</a>';
    $html_mmnu .= '</li>';
    $html_mmnu .= '<li class="nav-item d-block d-sm-none">';
    $html_mmnu .=   '<a class="nav-link text-light" href="'.$ruta_inicio.'"new-account.php>Crear cuenta</a>';
    $html_mmnu .= '</li>'; */

//POST__________________________________________________________________________
//POST__________________________________________________________________________

//ACCIONES______________________________________________________________________
//ACCIONES______________________________________________________________________

?>
<header>
  <div class="navbar p-1 navbar-light bg-blue-ysana sticky-top">
    <div class="navbar-brand">
      <button class="btn bg-transparent border-0" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
        aria-expanded="false" aria-label="Toggle navigation">
        <img src="<?php echo $ruta_archivos; ?>img/mnu-principal.png" width="34" />
      </button>
      <a class="navbar-brand" href="<?php echo $ruta_inicio; ?>">
        <img src="<?php echo $ruta_inicio; ?>img/svg/ysanablanco.svg" height="44px" alt="">
      </a>
    </div>
    <!-- <div class="d-flex align-items-center">
      <?php
            if(!isset($_SESSION['id_tipo_usuario'])){?>
      <div class="d-none d-sm-block">
        <a href="<?php $ruta_archivos?>new-account.php" class="text-light pb-1"><?php echo $lng['experiencia-index'][1]; ?></a>
        <label class="ml-1 mr-1 text-light">|</label>
        <a href="<?php $ruta_archivos?>new-account.php" class="text-light pb-1"><?php echo $lng['experiencia-index'][2]; ?></a>
      </div>

      <?php } ?>
      <a href="<?php echo $ruta_inicio; ?>experiencia/carrito.php">
        <div class="carrito-img p-2 mx-3">
          <img src="<?php echo $ruta_inicio; ?>img/svg/carro2.svg" width="32px" class="">
          <label class="num">0</label>
        </div>
      </a>
    </div> -->
    <div class="navbar-collapse collapse" id="navbarCollapse">
      <ul id="menu-admin-ysana" class="navbar-nav mr-auto">
        <?php echo $html_mmnu; ?>
      </ul>
    </div>
  </div>
</header>