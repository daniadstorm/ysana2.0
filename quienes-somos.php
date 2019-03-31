<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');
$frm_nombre = '';
$frm_email = '';
$frm_direccion = '';
$frm_cp = '';
$frm_tel = '';
$frm_pregunta = '';
$terminos_condiciones = '';


//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng[0]);
?>
<script type="text/javascript">

</script>

<body>
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio.inc.php'); ?>

    <div class="jumbotronquienessomos_<?php echo $_SESSION['id_lang']; ?> jumbotronpersonalizado"></div>
    <div class="bg-color-6">
        <div class="container-fluid">
            <nav class="navqs">
                <ul>
                    <li><a href="#aqs" id=""><?php echo $lng['quienes-somos'][0]; ?></a></li>
                    <li><a href="#avls" id=""><?php echo $lng['quienes-somos'][1]; ?></a></li>
                    <li><a href="#lcomp" id=""><?php echo $lng['quienes-somos'][2]; ?></a></li>
                    <li><a href="#acompromiso" id=""><?php echo $lng['quienes-somos'][3]; ?></a></li>
                    <li><a href="#acq" id=""><?php echo $lng['quienes-somos'][4]; ?></a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="container-fluid">
        <div class="text-center mt-5">
            <h1 id="aqs"><?php echo $lng['quienes-somos'][5]; ?></h1>
            <div class="wd-qs">
                <p><?php echo $lng['quienes-somos'][6]; ?></p>
                <p><?php echo $lng['quienes-somos'][7]; ?></p>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6 titulo-qs text-right">
                <h2 id="avls" class="mb-0"><?php echo $lng['quienes-somos'][8]; ?></h2>
            </div>
        </div>
        <div class="text-center">
            <p class="mt-5"><?php echo $lng['quienes-somos'][9]; ?></p>
        </div>
        <div class="d-flex flex-wrap justify-content-around mt-5">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-icon__compromiso.svg" alt="" width="90px" class="img-qs img-fluid">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-icon__confianza.svg" alt="" width="90px" class="img-qs img-fluid">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-icon__innovación.svg" alt="" width="90px" class="img-qs img-fluid">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-icon__integridad.svg" alt="" width="90px" class="img-qs img-fluid">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-icon__trabajo-en-equipo.svg" alt="" width="90px" class="img-qs img-fluid">
            <!-- <div class="col-md-3 text-center">
                <div class="qs-img">
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="qs-img">
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="qs-img">
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="qs-img">
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="qs-img">
                </div>
            </div> -->
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6 titulo-qs text-left offset-md-6">
                <h2 id="lcomp" class="mb-0"><?php echo $lng['quienes-somos'][10]; ?></h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="text-center mt-5">
            <p><?php echo $lng['quienes-somos'][11]; ?></p>
            <p><?php echo $lng['quienes-somos'][12]; ?></p>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6 titulo-qs text-right">
                <h2 id="acompromiso" class="mb-0"><?php echo $lng['quienes-somos'][13]; ?></h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="text-center mt-5">
            <p><?php echo $lng['quienes-somos'][14]; ?></p>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6 titulo-qs text-left offset-md-6">
                <h2 id="acq" class="mb-0"><?php echo $lng['quienes-somos'][15]; ?></h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="text-center mt-5">
            <p><?php echo $lng['quienes-somos'][16]; ?></p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="d-flex flex-wrap justify-content-around mt-5">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-codigo-etico-design.png" alt=""  height="80px" class="img-qs">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-codigo-etico-development.png" alt=""  height="80px" class="img-qs">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-codigo-etico-logistics.png" alt=""  height="80px" class="img-qs">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-codigo-etico-productionicon.png" alt=""  height="80px" class="img-qs">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-codigo-etico-quality.png" alt=""  height="80px" class="img-qs">
            <img src="<?php echo $ruta_inicio; ?>img/qs/ysana-quienes-somos-codigo-etico-regulatory.png" alt=""  height="80px" class="img-qs">
            <!-- <div class="img-cq">
                <img src="<?php echo $ruta_inicio ?>img/wallpaper.png" alt="" class="img-qs img-fluid">
            </div>
            <div class="img-cq">
                <img src="<?php echo $ruta_inicio ?>img/wallpaper.png" alt="" class="img-qs img-fluid">
            </div>
            <div class="img-cq">
                <img src="<?php echo $ruta_inicio ?>img/wallpaper.png" alt="" class="img-qs img-fluid">
            </div>
            <div class="img-cq">
                <img src="<?php echo $ruta_inicio ?>img/wallpaper.png" alt="" class="img-qs img-fluid">
            </div>
            <div class="img-cq">
                <img src="<?php echo $ruta_inicio ?>img/wallpaper.png" alt="" class="img-qs img-fluid">
            </div> -->
        </div>
    </div>
    <?php include_once('inc/footer.inc.php'); ?>
</body>
<script>
    $('a[href*="#"]')
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
    if(location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) {
            return false;
          } else {
            $target.attr('tabindex','-1');
            $target.focus();
          };
        });
      }
    }
  });
</script>
</html>