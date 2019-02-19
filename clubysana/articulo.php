<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');

$id_usuario = (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '';

$id_producto = (isset($_GET['id'])) ? $_GET['id'] : '';

//GET___________________________________________________________________________
if($id_producto!=''){

}
//GET___________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

//CONTROL__________________________________________________________________________

//CONTROL__________________________________________________________________________

include_once('../inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">

</script>

<body>
    <?php include_once('../inc/panel_top_clubysana.inc.php'); ?>
    <?php include_once('../inc/navbar_inicio.inc.php'); ?>
    <div class="container-fluid px-0">
        <ul id="nav-clubysana" class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="areapersonal-tab" href="<?php echo $ruta_inicio; ?>clubysana/areapersonal"><?php echo $lng['clubysana'][7]; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="experiencia-tab" href="<?php echo $ruta_inicio; ?>clubysana/areapersonal"><?php echo $lng['clubysana'][8]; ?></a>
            </li>
        </ul>
    </div>
    <div class="container-fluid" id="experiencia">
        <nav>
            <ol class="breadcrumb bg-white pl-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>clubysana"><?php echo $lng['breadcrumb'][2]; ?></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>clubysana/areapersonal/"><?php echo $lng['breadcrumb'][3]; ?></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>clubysana/areapersonal/neurologia/"><?php echo $lng['clubysana'][6]; ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $lng['articulo-sueno'][0]; ?></li>
            </ol>
        </nav>
    </div>
    <div id="recomendaciones" class="container-fluid my-5">
        <h1 class="titulo-consejo"><?php echo $lng['articulo-sueno'][0]; ?></h1>
        <div class="carousel-personalizado">
            <div class="consejos">
                <div class="consejo consejo-1">
                    <div class="consejo-responsive">
                        <div class="texto">
                            <h1>1</h1>
                            <h2><?php echo $lng['articulo-sueno'][1]; ?></h2>
                            <p><?php echo $lng['articulo-sueno'][2]; ?></p>
                            <a target="_blank" href="https://survey.zohopublic.eu/zs/fbB8dr">
                                <button class="btn-degr-cy my-2"><?php echo $lng['articulo-sueno'][0]; ?></button>
                            </a>
                        </div>
                        <div class="imagen">
                            <a target="_blank" href="https://survey.zohopublic.eu/zs/fbB8dr">
                                <img src="<?php echo $ruta_inicio; ?>img/club-ysana-picto-sueño-1.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="consejo consejo-2">
                    <div class="consejo-responsive">
                        <div class="texto">
                            <h1>2</h1>
                            <h2><?php echo $lng['articulo-sueno'][3]; ?></h2>
                            <p><?php echo $lng['articulo-sueno'][4]; ?></p>
                            <a target="_blank" href="https://survey.zohopublic.eu/zs/fbB8dr">
                                <button class="btn-degr-cy my-2"><?php echo $lng['articulo-sueno'][0]; ?></button>
                            </a>
                        </div>
                        <div class="imagen">
                            <a target="_blank" href="https://survey.zohopublic.eu/zs/fbB8dr">
                                <img src="<?php echo $ruta_inicio; ?>img/club-ysana-picto-sueño-2.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="consejo consejo-3">
                    <div class="consejo-responsive">
                        <div class="texto">
                            <h1>3</h1>
                            <h2><?php echo $lng['articulo-sueno'][5]; ?></h2>
                            <p><?php echo $lng['articulo-sueno'][6]; ?></p>
                            <a target="_blank" href="https://survey.zohopublic.eu/zs/fbB8dr">
                                <button class="btn-degr-cy my-2"><?php echo $lng['articulo-sueno'][0]; ?></button>
                            </a>
                        </div>
                        <div class="imagen">
                            <a target="_blank" href="https://survey.zohopublic.eu/zs/fbB8dr">
                                <img src="<?php echo $ruta_inicio; ?>img/club-ysana-picto-sueño-3.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="botones">
                <button id="btn1" class="btnSlider bg-rosa"></button>
                <button id="btn2" class="btnSlider"></button>
                <button id="btn3" class="btnSlider"></button>
            </div>
            <script>
                $(document).ready(function(){
                    $('.btnSlider').click(function(){
                        $('button').removeClass("bg-rosa");
                        $(this).addClass("bg-rosa");
                    });
                    $("#btn1").click(function(){
                        $('.consejo').css("transform","translateX(0%)");
                    });
                    $("#btn2").click(function(){
                        $('.consejo').css("transform","translateX(-100%)");
                    });
                    $("#btn3").click(function(){
                        $('.consejo').css("transform","translateX(-200%)");
                    });
                });
            </script>
        </div>
        <h1 class="titulo-consejo"><?php echo $lng['articulo-sueno'][0]; ?></h1>
        <div class="texto-general">
            <p class="blq"><?php echo $lng['articulo-sueno'][7]; ?></p>
            <p class="blq"><?php echo $lng['articulo-sueno'][8]; ?></p>
        </div>
    </div>
    <?php include_once('../inc/footer.inc.php'); ?>
</body>

</html>