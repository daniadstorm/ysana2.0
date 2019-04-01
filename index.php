<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$iM = load_model('inputs');
$sM = load_model('seo');
$frm_nombre = '';
$frm_email = '';
$frm_direccion = '';
$frm_cp = '';
$frm_tel = '';
$frm_pregunta = '';
$terminos_condiciones = '';

$frm_accept_advertising = '';
/* $arr_opt_accept_advertising = array(
    1 => $lng['index'][19],
    2 => $lng['index'][20]
); */

//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng[0]); 
?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); //panel superior ?>
        <?php include_once('inc/menu.inc.php'); //menu superior ?>
    </div>
    <div class="parallax parallax-home1 marg-ysana">
        <div class="max-ysana">
            <div id="centrar-home1">
                <img width="96px" src="<?php echo $ruta_inicio; ?>img/logos/logoy.svg" alt="">
                <h1><?php echo $lng[116]; ?></h1>
                <h1><?php echo $lng[117]; ?></h1>
            </div>
        </div>
    </div>
    <div class="texto-subhome">
        <h1><?php echo $lng[118]; ?></h1>
    </div>
    <div class="parallax parallax-home2">
        <div id="paneles" class="max-ysana">
            <div class="row">
                <div class="col-12 col-md-6 panel panel-izq">
                    <div class="p-3">
                        <h1><?php echo $lng[119]; ?></h1>
                        <p><?php echo $lng[120]; ?></p>
                        <a href="<?php echo $ruta_inicio; ?>productos-ysana" class="btn btn-bg-color-2 mt-2"><?php echo $lng[121]; ?></a>
                    </div>
                </div>
                <div class="col-12 col-md-6 panel panel-der">
                    <div id="polaroid">
                        <div class="polaroid polzi-1"><img src="<?php echo $ruta_inicio ?>img/polaroid/1.jpg" class="pol pol-1" alt=""></div>
                        <div class="polaroid polzi-2"><img src="<?php echo $ruta_inicio ?>img/polaroid/2.jpg" class="pol pol-2" alt=""></div>
                        <div class="polaroid polzi-3"><img src="<?php echo $ruta_inicio ?>img/polaroid/3.jpg" class="pol pol-3" alt=""></div>
                        <div class="polaroid polzi-4"><img src="<?php echo $ruta_inicio ?>img/polaroid/4.jpg" class="pol pol-4" alt=""></div>
                        <div class="polaroid polzi-5"><img src="<?php echo $ruta_inicio ?>img/polaroid/5.jpg" class="pol pol-5" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="texto-subpolaroid">
        <h1><?php echo $lng[122]; ?></h1>
        <a href="<?php echo $ruta_inicio; ?>sobre-ysana" class="btn btn-bg-color-white"><?php echo $lng[123]; ?></a>
    </div>
    <div class="parallax parallax-home3">
        <div id="redes-sociales">
            <h1><?php echo $lng[124]; ?></h1>
            <p><?php echo $lng[125]; ?></p>
            <div class="img-redes">
                <a target="_blank" href="https://www.instagram.com/ysanavidasana/"><img src="<?php echo $ruta_inicio; ?>img/redes/3.svg" class="mx-1" width="40px" alt=""></a>
                <a target="_blank" href="https://es-es.facebook.com/YSanaVidaSana/"><img src="<?php echo $ruta_inicio; ?>img/redes/4.svg" class="mx-1" width="40px" alt=""></a>
                <a target="_blank" href="https://twitter.com/Ysana_Vida_Sana"><img src="<?php echo $ruta_inicio; ?>img/redes/5.svg" class="mx-1" width="40px" alt=""></a>
                <a href="<?php echo $ruta_blog; ?>"><img src="<?php echo $ruta_inicio; ?>img/redes/6.svg" class="mx-1" width="40px" alt=""></a>
            </div>
        </div>
    </div>
    <div class="parallax parallax-home4">
        <div id="paneles-clubysana" class="max-ysana">
            <div class="panel panel-izq">
                <div class="logo-ysana">
                    <img src="<?php echo $ruta_inicio; ?>img/logos/clubysana.svg" width="192px" alt="">
                </div>
                <p><?php echo $lng[126]; ?></p>
                <a href="<?php echo $ruta_inicio; ?>productos-ysana" class="btn btn-bg-color-3 mt-2"><?php echo $lng[159]; ?></a>
            </div>
        </div>
    </div>
    <div class="parallax parallax-home5">
        <div id="form-contacto" class="max-ysana">
            <div class="row w-100 align-items-center">
                <div class="col-12 col-md-6 contacto-1">
                    <h1><?php echo $lng[127]; ?></h1>
                    <p><?php echo $lng[128]; ?></p>
                    <img src="<?php echo $ruta_inicio; ?>img/logos/skyline.svg" class="" alt="">
                </div>
                <form method="post" class="col-12 col-md-6 contacto-2">
                    <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', $lng[129], '', '', '', '', false, 'form-group', false); ?>
                    <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', $lng[130], '', '', '', '', false, 'form-group', false); ?>
                    <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', $lng[85], '', '', '', '', false, 'form-group', false); ?>
                    <div class="form-row">
                        <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', $lng[86], '', '', '', '', false, 'form-group col-6', false); ?>
                        <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', $lng[131], '', '', '', '', false, 'form-group col-6', false); ?>
                    </div>
                    <?php echo $iM->get_input_textarea('frm_pregunta', '', 'form-control', $lng[132], '', 10, 5, 500, false, 5, 'form-group') ?>
                    <a class="mb-0"><input id="" type="checkbox" name="" required><a href="#terminoos" class="ml-2 text-light"><?php echo $lng[133]; ?></a></p>
                    <div class="d-flex justify-content-end">
                        <button id="btnEnviar" type="submit" class="btn btn-bg-color-3"><?php echo $lng[134]; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once('inc/footer.inc.php'); //panel superior ?>
</body>


<script>
    $("#polaroid").on('click', '.pol', function(){
        console.log(this);
    });
</script>
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