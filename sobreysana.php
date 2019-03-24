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

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]); 
/* echo '<pre style="height:200vh;">';
print_r($_SERVER);
echo '</pre>'; */
?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); ?>
        <?php include_once('inc/menu.inc.php'); ?>
    </div>
    <div id="sobreysanaslider" class="parallax parallax-sobreysana">
        <div class="max-ysana">
            <div>
                <h1>Ysana® es una marca natural e innovadora dedicada al bienestar de las personas.</h1>
                <a href="#" class="btn btn-bg-color-4">Nuestros productos</a>
            </div>
        </div>
    </div>
    <div id="sobreysana" class="max-ysana">
        <div class="ttl">
            <h1>Valores Ysana</h1>
        </div>
        <div class="carteles">
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/3.svg" alt="">
                <h5>Innovación</h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/1.svg" alt="">
                <h5>Compromiso</h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/2.svg" alt="">
                <h5>Integridad</h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/5.svg" alt="">
                <h5>Trabajo en Equipo</h5>
            </div>
            <div class="caja">
                <img src="<?php echo $ruta_inicio; ?>img/home/4.svg" alt="">
                <h5>Confianza</h5>
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
                    <h1 class="ttl">Conoce más de Ysana®</h1>
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
                    <p class="texto">Nuestra planta de producción está ubicada en Vilabella (Tarragona) de más de 10.000 m2. Completamente equipada con la más avanzada tecnología para la fabricación de: Complementos Alimenticios en viales monodosis, extemporáneos, tecnología Eficaps®, y spray oral; en cuanto a Dispositivos Médicos contamos con áreas especializadas en aspiradores nasales para bebés, esprays de bomba y esprays “bulk on valve”. Desde nuestra sede en Barcelona diseñamos, desarrollamos y fabricamos productos tecnológicamente avanzados, con formulaciones exclusivas a base de extractos de plantas e ingredientes naturales, rigurosamente escogidos y avalados por estudios científicos. El equipo de I+D de Ysana Vida Sana desarrolla constantemente tecnologías propias e impulsa estudios clínicos específicos de eficacia y seguridad.</p>
                    <p class="texto">Contamos con las principales ISO y GMP de exigencia a nivel Europeo, de la misma manera todos los productos Ysana® cuentan con las certificaciones técnicas de los organismos notificados nacionales, esta ardua y rigurosa labor se lleva a cabo desde nuestro departamento de Regulatorio cuyo equipo tiene amplio conocimiento y dominio de las normas tanto locales como en otros países del mundo.</p>
                </div>
            </div>
        </div>
    </div>
    <div id="transparencia" class="max-ysana">
        <div>
            <h1>En Ysana® basamos nuestro trabajo en el compromiso por la calidad, una innovación constante de nuestros productos basados en principios activos naturales, un código ético de transparencia y comunicación, además de un riguroso cumplimiento de los estándares legales.</h1>
        </div>
    </div>
    <div id="garantia" class="max-ysana">
        <div class="texto">
            <h1 class="ttl">Garantía Ysana</h1>
            <p class="txt">En Ysana® Vida Sana no sólo nos encargamos de la producción, sino que también desarrollamos los productos, realizamos los estudios de eficacia y seguridad, llevamos a cabo los controles de calidad y seguimos todas las etapas del proceso regulatorio cumpliendo un exigente código de compromiso con la calidad.</p>
        </div>
        <ul class="timeline">
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
            <li class="li"><div class="imagen"></div></li>
        </ul>
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