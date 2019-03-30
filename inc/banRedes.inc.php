<?php
$clubysana = (isset($_REQUEST['clubysana']) ? $_REQUEST['clubysana'] : '');
?>

<div id="bannerredes" class="w-100 redes-<?php echo ($clubysana) ? 'cy' : 'y'; ?>">
    <div class="max-ysana">
        <div class="redes">
            <div class="texto">
                <h1>Síguenos en las redes</h1>
            </div>
            <div class="imagenes">
                <img src="<?php echo $ruta_inicio; ?>img/redes/10.svg" width="64px" alt="">
                <img src="<?php echo $ruta_inicio; ?>img/redes/12.svg" width="64px" alt="">
                <img src="<?php echo $ruta_inicio; ?>img/redes/9.svg" width="64px" alt="">
                <img src="<?php echo $ruta_inicio; ?>img/redes/11.svg" width="64px" alt="">
            </div>
        </div>
    </div>
</div>