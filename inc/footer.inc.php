<?php ?>

<div id="footer">
    <div class="max-ysana">
        <div class="row px-2 my-4">
            <div class="col-12 col-sm-3">
                <img src="<?php echo $ruta_inicio;?>img/logos/ysanacolor.svg" width="128px" alt="">
            </div>
            <div class="col-12 col-sm-3">
                <ul class="list-footer">
                    <li class="list-footer-item titulo"><?php echo $lng[147]; ?></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[135]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[136]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[137]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[138]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[139]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[140]; ?></a></li>
                </ul>
            </div>
            <div class="col-12 col-sm-3">
                <ul class="list-footer">
                    <li class="list-footer-item titulo"><a href="<?php echo $ruta_inicio; ?>sobre-ysana"><?php echo $lng[148]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>sobre-ysana/#sobreysana"><?php echo $lng[3]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>sobre-ysana/#conocemas"><?php echo $lng[149]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>sobre-ysana/#garantia"><?php echo $lng[150]; ?></a></li>
                </ul>
            </div>
            <div class="col-12 col-sm-3">
                <ul class="list-footer">
                    <li class="list-footer-item titulo"><?php echo $lng[153]; ?></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[154]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[155]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[156]; ?></a></li>
                    <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>"><?php echo $lng[157]; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

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