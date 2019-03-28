<?php
include_once('config/config.inc.php'); //cargando archivo de configuracion
$sM = load_model('seo');

echo $sM->add_cabecera($ruta_inicio, $lng['header'][0]); 

$Ds_version = $_REQUEST['Ds_version'];
$Ds_params = $_REQUEST['Ds_params'];
$Ds_signature = $_REQUEST['Ds_signature'];

?>
<body>
<form action="<?php echo URL_PASARELA; ?>" method="post" id="form_gateway" name="form_gateway">
    <input type="hidden" name="Ds_SignatureVersion" value="<?php echo $Ds_version; ?>" />
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $Ds_params; ?>" />
    <input type="hidden" name="Ds_Signature" value="<?php echo $Ds_signature; ?>" />
    <input type="submit" class="btn_aceptar" style="padding:4px 22px;max-width:200px;margin-left:auto;margin-right:auto;" value="Aceptar" />
</form>
<script>
    $(document).ready(function () {
        //$("#form_gateway").submit();
    });
</script>
</body>
</html>