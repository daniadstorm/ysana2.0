<?php

?>
<div id="footer-img" class="container-fluid px-0">
<img id="img-footer" src="<?php echo $ruta_inicio; ?>img/ysana-footer.svg" alt="">
</div>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-3 d-flex flex-column align-items-start">
                <div class="d-flex flex-column align-items-start">
                    <h3><?php echo $lng['footer'][0]; ?></h3>
                    <ol>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#avls"><?php echo $lng['footer'][1]; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#lcomp"><?php echo $lng['footer'][2]; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#acompromiso"><?php echo $lng['footer'][3]; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>quien-es-ysana-vida-sana/#acq"><?php echo $lng['footer'][4]; ?></a>
                        </li>
                        <!--
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>productos_ysana"><?php echo $lng['footer'][16]; ?></a>
                        </li>
                        -->
                    </ol>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 d-flex flex-column align-items-start">
                <div class="d-flex flex-column align-items-start">
                    <!--
                    <h3><a class="text-light" href="<?php echo $ruta_inicio; ?>#"><?php echo $lng['footer'][5];?></a></h3>
                    <ol>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>#"><?php echo $lng['footer'][6]; ?></a>
                        </li>
                        <li>
                            <a href="#"><?php echo $lng['footer'][7]; ?></a>
                        </li>
                        <li>
                            <a href="#"><?php echo $lng['footer'][8]; ?></a>
                        </li>
                        <li>
                            <a href="#"><?php echo $lng['footer'][9]; ?></a>
                        </li>
                    </ol>
                    -->
                </div>
            </div>
            <div class="col-sm-6 col-md-3 d-flex flex-column align-items-start">
                <div class="d-flex flex-column align-items-start">
                    <h3><?php echo $lng['footer'][10]; ?></h3>
                    <ol>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>aviso-legal"><?php echo $lng['footer'][11]; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>politica-privacidad"><?php echo $lng['footer'][12]; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>politica-cookies"><?php echo $lng['footer'][13]; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>politica-ventas"><?php echo $lng['footer'][14]; ?></a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 d-flex flex-column align-items-start">
                <div class="d-flex flex-column align-items-start">
                    <h3><?php echo $lng['footer'][15]; ?></h3>
                    <ol class="pl-0">
                        <li>
                            <a href="<?php echo $ruta_inicio; ?>clubysana">
                                <img src="<?php echo $ruta_inicio; ?>img/svg/clubysanaicono.svg" height="64px" alt="">
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (!isset($_SESSION['accept_cookies_policy']) || $_SESSION['accept_cookies_policy'] < 1) {
?>
<div id="cookies_policy_wrapper" class="cookies-accept-dialog">
    <div class="row"><?php echo $lng['footer'][17]; ?></div>
    <div class="row">
        <div class="col-6">
            <button onClick="accept_cookies_policy('<?php echo $ruta_inicio; ?>');" type="button" class="btn btn-sm btn-leer-mas mt-1"><?php echo $lng['footer'][18]; ?></button>
        </div>
        <div class="col-6">
            <button onClick="location.href='<?php echo $ruta_inicio; ?>como-configurar-cookies'" type="button" class="btn btn-sm btn-leer-mas mt-1"><?php echo $lng['footer'][19]; ?></button>
        </div>
    </div>
</div>
<?php
}
?>