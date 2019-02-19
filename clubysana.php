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

    <div class="coming-soon container-fluid position-relative px-0">
        <div class="izquierda bg-clubysana d-flex justify-content-center align-items-center">
            <div class="clubysana">
                <div class="info d-flex justify-content-center align-items-center">
                    <div class="contenido m-3">
                        <img class="img-ysanaclub img-fluid" src="<?php echo $ruta_inicio; ?>img/ysanaclubbl.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div id="coming-soon-derecha" class="derecha d-flex justify-content-center align-items-center">
                <!-- <img src="<?php echo $ruta_inicio; ?>img/Pronto-en-ysana-club-ysana-.svg" class="w-100" alt=""> -->
            <div class="info d-flex justify-content-center align-items-center">
                <div class="contenido m-3 text-center">
                    <!--
                    <h1 class="titulo-comingsoon">COMING SOON</h1>
                    <h2 class="descripcion-comingsoon">Los mejores consejos y las noticias más interesantes sobre la vida sana.</h2>
                    -->
                    <h1 class="titulo-comingsoon"><?php echo $lng['clubysana']['ttl']; ?></h1>
                    <h2 class="descripcion-comingsoon"><?php echo $lng['clubysana']['txt']; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        function show_coming_soon(){
            $("#coming-soon-derecha").addClass("aparecer-ysana");
            console.log("aparecer-ysana");
        };
        setTimeout(show_coming_soon, 3900 );
    });
    </script>
        <?php include_once('inc/footer.inc.php'); ?>
</body>

</html>