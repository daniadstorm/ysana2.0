<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$iM = load_model('inputs');
$sM = load_model('seo');
$frm_nombre = '';
$frm_email = '';
$frm_direccion = '';
$frm_cp = '';
$frm_tel = '';
$frm_pregunta = '';
$terminos_condiciones = '';

$frm_accept_advertising = '';
$arr_opt_accept_advertising = array(
    1 => $lng['index'][19],
    2 => $lng['index'][20]
);

//GET___________________________________________________________________________

//GET___________________________________________________________________________

//POST__________________________________________________________________________

//POST__________________________________________________________________________

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]); 
?>

<body>
    <div id="menu-sticky">
        <?php include_once('inc/panel_top.inc.php'); //panel superior ?>
        <?php include_once('inc/menu.inc.php'); //menu superior ?>
    </div>
    <div class="parallax parallax-home1"></div>
    <div class="texto-subhome">
        <h1>La fórmula del éxito: ejercicio, comida sana e Ysana</h1>
    </div>
    <div class="parallax parallax-home2">
        <div id="paneles" class="max-ysana">
            <div class="row">
                <div class="col-12 col-md-6 panel panel-izq">
                    <div class="p-3">
                        <h1>¿Qué es Ysana Vida Sana?</h1>
                        <p>Ysana® es una marca dedicada al bienestar de las personas. Nuestro equipo profesional y dinámico está comprometido con la innovación constante para incorporar extractos naturales a productos que ayuden a las personas a mantener un estilo de vida saludable.</p>
                        <a href="#" class="btn btn-bg-color-2">Nuestros productos</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 panel panel-der">
                    <div id="polaroid">
                        <div class="polaroid polzi-1"><img src="<?php echo $ruta_inicio ?>img/polaroid/1.png" class="pol pol-1" alt=""></div>
                        <div class="polaroid polzi-2"><img src="<?php echo $ruta_inicio ?>img/polaroid/1.png" class="pol pol-2" alt=""></div>
                        <div class="polaroid polzi-3"><img src="<?php echo $ruta_inicio ?>img/polaroid/1.png" class="pol pol-3" alt=""></div>
                        <div class="polaroid polzi-4"><img src="<?php echo $ruta_inicio ?>img/polaroid/1.png" class="pol pol-4" alt=""></div>
                        <div class="polaroid polzi-5"><img src="<?php echo $ruta_inicio ?>img/polaroid/1.png" class="pol pol-5" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="texto-subpolaroid">
        <h1>Conoce más de ysana</h1>
        <a href="#" class="btn btn-bg-color-white">Ir a Corporate</a>
    </div>
    <div class="parallax parallax-home3">
        <div id="redes-sociales">
            <h1>Redes sociales</h1>
            <p>Síguenos en nuestras redes sociales para estar al día de todas las novedades, recetas healthy, promociones y concursos.</p>
            <div class="img-redes">
                <img src="<?php echo $ruta_inicio; ?>img/redes/3.svg" class="mx-1" width="40px" alt="">
                <img src="<?php echo $ruta_inicio; ?>img/redes/4.svg" class="mx-1" width="40px" alt="">
                <img src="<?php echo $ruta_inicio; ?>img/redes/5.svg" class="mx-1" width="40px" alt="">
                <img src="<?php echo $ruta_inicio; ?>img/redes/6.svg" class="mx-1" width="40px" alt="">
            </div>
        </div>
    </div>
    <div class="parallax parallax-home4">
        <div id="paneles-clubysana" class="max-ysana">
            <div class="panel panel-izq">
                <div class="logo-ysana">
                    <img src="<?php echo $ruta_inicio; ?>img/logos/clubysana.svg" width="192px" alt="">

                </div>
                <p>Únete ahora al Club Ysana y enlaza con la vida sana. La primera comunidad online orientada al autocuidado y los hábitos de vida saludables, donde podrás compartir tus inquietudes, obtener consejos personalizados de farmacéuticos y coachs profesionales, obtener premios, acceder a muestras de producto en primicia, compartir experiencias y, por supuesto, mejorar tus hábitos de vida de manera constante.</p>
                <a href="#" class="btn btn-bg-color-3">Nuestros productos</a>
            </div>
        </div>
    </div>
    <div class="parallax parallax-home5">
        <div id="form-contacto" class="max-ysana">
            <div class="row w-100 align-items-center">
                <div class="col-12 col-md-6 contacto-1">
                    <h1>Contacta con Ysana</h1>
                    <p>Si deseas más información sobre nuestro laboratorio o gama de productos naturales para el autocuidado, no dudes en contactarnos.</p>
                    <img src="<?php echo $ruta_inicio; ?>img/logos/skyline.svg" class="" alt="">
                </div>
                <form method="post" class="col-12 col-md-6 contacto-2">
                    <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', 'Nombre y Apellidos', '', '', '', '', false, 'form-group', false); ?>
                    <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', 'E-mail', '', '', '', '', false, 'form-group', false); ?>
                    <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', 'Dirección', '', '', '', '', false, 'form-group', false); ?>
                    <div class="form-row">
                        <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', 'CP', '', '', '', '', false, 'form-group col-6', false); ?>
                        <?php echo $iM->get_input_text('frm_nombre', '', 'form-control', 'Telf', '', '', '', '', false, 'form-group col-6', false); ?>
                    </div>
                    <?php echo $iM->get_input_textarea('frm_pregunta', '', 'form-control', 'Tu pregunta', '', 10, 500, true, false, 5, 'form-group') ?>
                    <div class="d-flex justify-content-end">
                        <button id="btnEnviar" type="submit" class="btn btn-bg-color-3">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once('inc/footer.inc.php'); //panel superior ?>
</body>


<script>
    $("#polaroid").on('click', '.pol', function(){
        console.log(this);
    });
</script>
</html>