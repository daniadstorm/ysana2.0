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

<body class="">
    <?php include_once('inc/panel_top.inc.php'); ?>
    <?php include_once('inc/navbar_inicio.inc.php'); ?>
    <div class="container-fluid">
        <div class="embed-container">
            <iframe class="iframe-bono" src="https://forms.zohopublic.eu/pharmalink/form/BonofarmaciasAlphega/formperma/CcVKz2qxKOR6ok3wjDZ8X3tvYHbEOT2w79rIzkQv5QE" frameborder="0" allowfullscreen></iframe>
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