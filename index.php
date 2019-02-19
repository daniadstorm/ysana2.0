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

$frm_accept_advertising = '';
$arr_opt_accept_advertising = array(
    1 => $lng['index'][19],
    2 => $lng['index'][20]
);

//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

include_once('inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]); 
?>

<script type="text/javascript">

</script>

<body>
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio.inc.php'); ?>

    <?php //include_once('inc/footer.inc.php'); ?>
    <main id="content" role="main">
        <div class="contenedor">
        <!-- <div class="jumbotronysana"></div> -->
        <div class="position-relative">
            <div class="videoysana">
                <video class="video-inline" autoplay loop muted src="<?php echo $ruta_inicio; ?>img/nature2.mp4"></video>
            </div>
        </div>
        </div>
        <div class="contquiensomos">
            <div class="container">
                <div id="quiensomos" class="d-flex flex-column align-items-center">
                    <div class="titulo my-5">
                        <h2><?php echo $lng['index'][0]; ?></h2>
                    </div>
                    <div class="separadorqs"></div>
                    <img src="<?php echo $ruta_inicio; ?>img/home/1.png" alt="" class="img-botella">
                    <img src="<?php echo $ruta_inicio; ?>img/home/6.png" alt="" class="img-hoja1">
                    <img src="<?php echo $ruta_inicio; ?>img/home/5.png" alt="" class="img-botella2">
                    <div class="info qs bg-white">
                        <div class="contenido pb-3">
                            <p><?php echo $lng['index'][1]; ?></p>
                            <p><a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana"><button type="button" class="btn btn-sm btn-leer-mas mt-1"><?php echo $lng['clubysana'][2]; ?></button></a></p>
                            <img src="<?php echo $ruta_inicio; ?>img/home/3.png" alt="" class="img-fruta">
                            <img src="<?php echo $ruta_inicio; ?>img/home/4.png" alt="" class="img-hoja2">
                            <img src="<?php echo $ruta_inicio; ?>img/home/7.png" alt="" class="img-botella3">
                        </div>
                    </div>
                    <div class="separadorqs"></div>
                </div>
            </div>
        </div>
        <div class="clubysana">
            <a href="<?php echo $ruta_inicio; ?>clubysana">
            <div class="info-homee d-flex justify-content-center align-items-center h-100">
                <img class="img-ysanaclub img-fluid" src="<?php echo $ruta_inicio; ?>img/<?php echo $lng['index']['img'][0]; ?>" alt="">
                <!-- <div class="contenido m-3"> -->
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer convallis id sapien a dapibus. Aenean
                        efficitur nisi at fringilla molestie. Nunc varius, ipsum a iaculis interdum, sem dui blandit ligula,
                        vitae egestas arcu tortor finibus lectus.</p> -->
                <!-- </div> -->
            </div></a>
        </div>
        <div class="container">
            <div class="novedades text-center">
                <div class="titulo my-5">
                    <h2><?php echo $lng['index'][2]; ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-3">
                        <div class="adelgaysana">
                            <div class="img">
                                <div class="d-none d-sm-block">
                                    <div class="info">
                                        <h1><?php echo $lng['index'][3]; ?></h1>
                                        <p><?php echo $lng['index'][4]; ?></p>
                                        <a href="#"><button type="button" class="btn btn-sm btn-leer-mas mt-2"><?php echo $lng['clubysana'][2]; ?></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-block d-sm-none">
                            <div class="infoxs">
                                <h1><?php echo $lng['index'][5]; ?></h1>
                                <p class="m-0"><?php echo $lng['index'][6]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-3">
                        <div class="freenose">
                            <div class="img">
                                <div class="d-none d-sm-block">
                                    <div class="info">
                                        <h1><?php echo $lng['index'][3]; ?></h1>
                                        <p><?php echo $lng['index'][4]; ?></p>
                                        <a href="#"><button type="button" class="btn btn-sm btn-leer-mas mt-2"><?php echo $lng['clubysana'][2]; ?></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-block d-sm-none">
                            <div class="infoxs">
                                <h1><?php echo $lng['index'][5]; ?></h1>
                                <p class="m-0"><?php echo $lng['index'][6]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-contacto position-relative">
            <div class="footer-modificado">

            </div>
            <div class="container contacto">
                <div class="d-flex justify-content-end align-items-center position-relative">
                    <div class="titulo position-absolute">
                        <h1><?php echo $lng['index'][7]; ?></h1>
                        <h1><?php echo $lng['index'][8]; ?></h1>
                    </div>
                    <div class="frmcontacto">
                        <form id="form-contacto">
                            <div class="titulo mb-3">
                                <div class="d-flex justify-content-center">
                                    <h2><?php echo $lng['index'][7]; ?> <?php echo $lng['index'][8]; ?></h2>
                                </div>
                            </div>
                            <?php echo $iM->get_input_text($frm_nombre, $frm_nombre, $class='form-control border-frm-contact', $lbl='', $lng['index'][12]); ?>
                            <?php echo $iM->get_input_text($frm_email, $frm_email, $class='form-control border-frm-contact', $lbl='', $lng['index'][13]); ?>
                            <?php echo $iM->get_input_text($frm_direccion, $frm_direccion, $class='form-control border-frm-contact', $lbl='', $lng['index'][14]); ?>
                            <div class="">
                                <div class="row">
                                    <?php echo $iM->get_input_text($frm_cp, $frm_cp, $class='form-control border-frm-contact', $lbl='', $lng['index'][15],'',false,false,false,'col-md-6 mb-3'); ?>
                                    <?php echo $iM->get_input_text($frm_tel, $frm_tel, $class='form-control border-frm-contact', $lbl='', $lng['index'][16],'',false,false,false,'col-md-6 mb-3'); ?>
                                </div>
                            </div>
                            <?php echo $iM->get_input_textarea($frm_pregunta, $frm_pregunta, $class='form-control border-frm-contact', $lbl='', $lng['index'][17]); ?>
                            <p><?php echo $lng['index'][9]; ?></p>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-12">
                                    <div class="form-check pl-0 mb-2 d-flex align-items-center">
                                        <!-- <input class="form-check-input" type="checkbox" id="autoSizingCheck"> -->
                                        <div class="roundedOne">
                                            <input type="checkbox" id="roundedOne" name="terminos_condiciones" required />
                                            <label for="roundedOne"></label>
                                        </div>
                                        <div>
                                            <p class="form-check-label ml-2" for="autoSizingCheck">
                                                <?php echo $lng['index'][10]; ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <p>
                                            <?php echo $lng['index'][18]; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $iM->get_input_radio($frm_accept_advertising, $frm_accept_advertising, $arr_opt_accept_advertising, '', '', false, true); ?>
                                    </div>
                                    <div>
                                        <p>
                                            <?php echo $lng['index'][21]; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" target="_blank" action="mailto:lalvarado@pharmalink.es" class="btn btn-primary btn-lg w-100 border-frm-contact btn-color-6"><?php echo $lng['index'][11]; ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('inc/footer.inc.php'); ?>
    </main>
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