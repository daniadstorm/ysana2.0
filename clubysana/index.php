<?php
include_once('../config/config.inc.php'); //cargando archivo de configuracion

$uM = load_model('usuario'); //uM userModel
$hM = load_model('html');
$iM = load_model('inputs');
$sM = load_model('seo');
$uM->control_sesion($ruta_inicio, USER, false);

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

//CONTROL_______________________________________________________________________
if (isset($_SESSION['id_tipo_usuario'])) { //si hay login
    header('Location: '.$ruta_inicio.'clubysana/areapersonal/');
}
//CONTROL_______________________________________________________________________

include_once('../inc/cabecera.inc.php'); //cargando cabecera
echo $sM->add_cabecera($lng['header'][0]);
?>
<script type="text/javascript">

</script>

<body class="ysana-body-color">
    <?php include_once('../inc/panel_top.inc.php'); ?>
    <?php include_once('../inc/navbar_inicio.inc.php'); ?>
    <div class="container-fluid">
        <nav>
            <ol class="breadcrumb ysana-body pl-0">
                <!--
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>">Ysana</a>
                </li>
                -->
                <li class="breadcrumb-item">
                    <a href="<?php echo $ruta_inicio; ?>">Home</a>
                </li>
            </ol>
        </nav>
    </div>
    <!-- <div class="coming-soon container-fluid position-relative px-0">
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
            <div class="info d-flex justify-content-center align-items-center">
                <div class="contenido m-3 text-center">
                    <h1 class="titulo-comingsoon"><?php echo $lng['clubysana']['ttl']; ?></h1>
                    <h2 class="descripcion-comingsoon"><?php echo $lng['clubysana']['txt']; ?></h2>
                </div>
            </div>
        </div>
    </div> -->
    <div class="club-ysana-home">
        <div class="cy-container">
            <div class="logo">
                <img src="../img/ysanaclubbl.png" alt="Logo Ysana">
            </div>
            <div class="texto-bienvenida">
                <p><?php echo $lng['clubysana'][0]; ?></p>
                <!-- <p>Únete ahora al Club Ysana y enlaza con la vida sana. La primera comunidad online orientada al autocuidado y los hábitos de vida saludables, donde podrás compartir tus inquietudes, obtener consejos personalizados de farmacéuticos y coachs profesionales, obtener premios, acceder a muestras de producto en primicia, compartir experiencias y, por supuesto, mejorar tus hábitos de vida de manera constante.</p> -->
            </div>
            <div class="cy-inputs">
                <button class="cy-btn">
                    <a href="registro/" class="text-i"><?php echo $lng['clubysana'][1]; ?></a>
                </button>
                <!-- <button class="cy-btn">
                    <a href="#" class="text-i">Pertenecer Club Ysana® Farmecéutico</a>
                </button> -->
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
        <?php include_once('../inc/footer.inc.php'); ?>
</body>

</html>