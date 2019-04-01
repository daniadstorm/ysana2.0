<?php
$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');
?>

<div id="bannerredes" class="w-100 redes-<?php echo ($clubysana) ? 'cy' : 'y'; ?>">
    <div class="max-ysana">
        <div class="redes">
            <div class="texto">
                <h1><?php echo $lng[70]; ?></h1>
            </div>
            <div class="imagenes">
                <a href="https://www.facebook.com/YSanaVidaSana/"><img src="<?php echo $ruta_inicio; ?>img/redes/10.svg" width="64px" alt=""></a>
                <a href="https://twitter.com/Ysana_Vida_Sana"><img src="<?php echo $ruta_inicio; ?>img/redes/12.svg" width="64px" alt=""></a>
                <a href="https://www.instagram.com/ysanavidasana/"><img src="<?php echo $ruta_inicio; ?>img/redes/9.svg" width="64px" alt=""></a>
                <a href="<?php echo $ruta_blog; ?>"><img src="<?php echo $ruta_inicio; ?>img/redes/11.svg" width="64px" alt=""></a>
            </div>
        </div>
    </div>
</div>