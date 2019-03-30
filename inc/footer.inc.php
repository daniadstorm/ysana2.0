<?php ?>

<div id="footer" class="max-ysana">
    <div class="row my-4">
        <div class="col-12 col-sm-3">
            <img src="<?php echo $ruta_inicio;?>img/logos/ysanacolor.svg" width="128px" alt="">
        </div>
        <div class="col-12 col-sm-3">
            <ul class="list-footer">
                <li class="list-footer-item titulo">Mapa Web</li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Home</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Productos</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Experiencias</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Farmacia</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Club Ysana</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Contacto</a></li>
            </ul>
        </div>
        <div class="col-12 col-sm-3">
            <ul class="list-footer">
                <li class="list-footer-item titulo"><a href="<?php echo $ruta_inicio; ?>sobre-ysana">Sobre ysana</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Corporate</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Valores</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Compañía</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Compromiso</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Código Etico</a></li>
            </ul>
        </div>
        <div class="col-12 col-sm-3">
            <ul class="list-footer">
                <li class="list-footer-item titulo">Políticas</li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Aviso Legal</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Política de privacidad</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Política de cookies</a></li>
                <li class="list-footer-item"><a href="<?php echo $ruta_inicio; ?>">Política de ventas</a></li>
            </ul>
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