<?php ?>

<div id="footer" class="max-ysana">
    <div class="row my-4">
        <div class="col-6 col-sm-3">
            <img src="<?php echo $ruta_inicio;?>img/logos/ysanacolor.svg" width="128px" alt="">
        </div>
        <div class="col-6 col-sm-3">
            <ul class="list-footer">
                <li class="list-footer-item titulo"><?php echo $lng['footer'][0]; ?></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#avls"><?php echo $lng['footer'][1]; ?></a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#lcomp"><?php echo $lng['footer'][2]; ?></a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#acompromiso"><?php echo $lng['footer'][3]; ?></a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#acq"><?php echo $lng['footer'][4]; ?></a></li>
            </ul>
        </div>
        <div class="col-6 col-sm-3">
            <ul class="list-footer">
                <li class="list-footer-item titulo"><?php echo $lng['footer'][10]; ?></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>aviso-legal"><?php echo $lng['footer'][11]; ?></a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>aviso-legal"><?php echo $lng['footer'][12]; ?></a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>aviso-legal"><?php echo $lng['footer'][13]; ?></a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>aviso-legal"><?php echo $lng['footer'][14]; ?></a></li>
            </ul>
        </div>
        <div class="col-6 col-sm-3">
            <ul class="list-footer">
                <li class="list-footer-item titulo"><?php echo $lng['footer'][15]; ?></li>
            </ul>
        </div>
    </div>
</div>
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
<!-- <?php
if (!isset($_SESSION['accept_cookies_policy']) || $_SESSION['accept_cookies_policy'] < 1) {
?>
<div id="cookies_policy_wrapper" class="cookies-accept-dialog">
    <div class="row"><?php echo $lng['footer'][17]; ?></div>
    <div class="row">
        <div class="d-flex justify-content-around w-100">
            <button onClick="accept_cookies_policy('<?php echo $ruta_inicio; ?>');" type="button" class="btn btn-sm btn-leer-mas mt-1"><?php echo $lng['footer'][18]; ?></button>
            <button onClick="location.href='<?php echo $ruta_inicio; ?>como-configurar-cookies'" type="button" class="btn btn-sm btn-leer-mas mt-1"><?php echo $lng['footer'][19]; ?></button>
        </div>
    </div>
</div>
<?php
}
?> -->