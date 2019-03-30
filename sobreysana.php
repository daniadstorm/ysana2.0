<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$iM = load_model('inputs');
$sM = load_model('seo');

$arrImg = array(
    "img/home/1.jpg",
    "img/home/2.jpg",
    "img/home/3.jpg"
);

echo $sM->add_cabecera($ruta_inicio, $lng[0]); 

?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); ?>
        <?php include_once('inc/menu.inc.php'); ?>
    </div>
    <div id="sobreysanaslider" class="parallax parallax-sobreysana">
        <div class="max-ysana">
            <div>
                <h1><?php echo $lng[1]; ?></h1>
                <a href="#" class="btn btn-bg-color-4"><?php echo $lng[2]; ?></a>
            </div>
        </div>
    </div>
    <div id="sobreysana" class="max-ysana">
        <div class="ttl">
            <h1><?php echo $lng[3]; ?></h1>
        </div>
        <div class="carteles">
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/3.svg" alt="">
                <h5><?php echo $lng[4]; ?></h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/1.svg" alt="">
                <h5><?php echo $lng[5]; ?></h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/2.svg" alt="">
                <h5><?php echo $lng[6]; ?></h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/5.svg" alt="">
                <h5><?php echo $lng[7]; ?></h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/4.svg" alt="">
                <h5><?php echo $lng[8]; ?></h5>
            </div>
        </div>
    </div>
    <div id="conoceysana" class="max-ysana">
        <div class="row">
            <div class="col-12 col-lg-6 conoce-1 d-none d-lg-block">
                <div id="sliderysana" class="wrapper1">
                    <!-- <img src="<?php echo $ruta_inicio; ?>img/home/3.jpg" class="img-fluid" alt=""> -->
                    <div class="botonslider">
                        <?php
                        $i = 0;
                        foreach ($arrImg as $value) {
                            echo '<label class="slider-'.$i.' slider-redonda'.($i==0 ? ' active' : '').'" onclick="cambiarImgSlider(\''.$value.'\',\'slider-'.$i.'\')"></label>';
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 conoce-2">
                <div class="conoceysana">
                    <h1 class="ttl"><?php echo $lng[9]; ?></h1>
                    <div class="d-lg-none d-xl-none">
                        <div id="sliderysanamenos-xl" class="wrapper2">
                            <div class="botonslider">
                                <?php
                                $i = 0;
                                foreach ($arrImg as $value) {
                                    echo '<label class="slider-'.$i.' slider-redonda'.($i==0 ? ' active' : '').'" onclick="cambiarImgSlider(\''.$value.'\',\'slider-'.$i.'\')"></label>';
                                    $i++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <p class="texto"><?php echo $lng[10]; ?></p>
                    <p class="texto"><?php echo $lng[11]; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div id="transparencia" class="max-ysana">
        <div>
            <h1><?php echo $lng[12]; ?></h1>
        </div>
    </div>
    <div id="garantia" class="max-ysana">
        <div class="texto">
            <h1 class="ttl"><?php echo $lng[13]; ?></h1>
            <p class="txt"><?php echo $lng[14]; ?></p>
        </div>
        <div id="sobreysanaimg" class="row px-5">
            <div class="mb-5 col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="imagen img-1">
                    <p class="texto color-1"><?php echo $lng[15]; ?></p>
                    <img src="<?php echo $ruta_inicio; ?>img/sobreysana/1.png" class="img-fluid" alt="">
                </div>
                <div class="col-imagen"></div>
            </div>
            <div class="mb-5 col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="imagen img-2">
                    <p class="texto color-2"><?php echo $lng[16]; ?></p>
                    <img src="<?php echo $ruta_inicio; ?>img/sobreysana/2.png" class="img-fluid" alt="">
                </div>
                <div class="col-imagen"></div>
            </div>
            <div class="mb-5 col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="imagen img-3">
                    <p class="texto color-3"><?php echo $lng[17]; ?></p>
                    <img src="<?php echo $ruta_inicio; ?>img/sobreysana/3.png" class="img-fluid" alt="">
                </div>
                <div class="col-imagen"></div>
            </div>
            <div class="mb-5 col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="imagen img-4">
                    <p class="texto color-4"><?php echo $lng[18]; ?></p>
                    <img src="<?php echo $ruta_inicio; ?>img/sobreysana/4.png" class="img-fluid" alt="">
                </div>
                <div class="col-imagen"></div>
            </div>
            <div class="mb-5 col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="imagen img-5">
                    <p class="texto color-5"><?php echo $lng[19]; ?></p>
                    <img src="<?php echo $ruta_inicio; ?>img/sobreysana/5.png" class="img-fluid" alt="">
                </div>
                <div class="col-imagen"></div>
            </div>
            <div class="mb-5 col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="imagen img-6">
                    <p class="texto color-6"><?php echo $lng[20]; ?></p>
                    <img src="<?php echo $ruta_inicio; ?>img/sobreysana/6.png" class="img-fluid" alt="">
                </div>
                <div class="col-imagen"></div>
            </div>
        </div>
        <!-- <ul class="timeline">
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
        </ul> -->
    </div>
    <?php include_once('inc/footer.inc.php'); ?>
    <script>
        var imgs = ["img/home/1.jpg", "img/home/2.jpg", "img/home/3.jpg"];
        var i=0;
        $(document).ready(function() {
            $(function(){
                slide();
                setInterval(function() {
                    slide();
                }, 12000);
            });
        });
        function slide(){
            $('.wrapper1').css("background-image", "url('"+imgs[i]+"')");
            $('.wrapper2').css("background-image", "url('"+imgs[i]+"')");
            i++;
            if(i === imgs.length) i = 0;
        }

        function cambiarImgSlider(img, clase){
            $('.wrapper1').css("background-image", "url('"+img+"')");
            $('.wrapper2').css("background-image", "url('"+img+"')");
            $('.slider-redonda').removeClass("active");
            $('.'+clase).addClass("active");
            /* console.log($('.'+clase)); */
        }

     
    </script>
</body>
</html>