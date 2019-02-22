<?php

class carritoModel extends Model {
    
    function add_articulo_carrito($id_usuario, $id_articulo, $cantidad, $tipo_tienda) {
        $q  = ' INSERT INTO '.$this->pre.'carrito_compra (id_usuario, id_articulo, cantidad, tipo_tienda) VALUES ';
        $q .= ' ("'.$id_usuario.'", "'.$id_articulo.'", "'.$cantidad.'", "'.$tipo_tienda.'")';
        return $this->execute_query($q);
    }

    function add_direccion_envio($id_usuario, $nombre, $apellidos, $direccion, $cp, $poblacion, $movil){
        $q  = ' INSERT INTO '.$this->pre.'carrito_datos (id_usuario, nombre, apellidos, direccion, codigo_postal, poblacion, movil) VALUES ';
        $q .= ' ("'.$id_usuario.'", "'.$nombre.'", "'.$apellidos.'", "'.$direccion.'", "'.$cp.'", "'.$poblacion.'", "'.$movil.'")';
        return $this->execute_query($q);
    }

    function add_pedido($id_usuario, $nombre, $apellidos, $direccion, $codigo_postal, $poblacion, $movil){
        $q  = ' INSERT INTO '.$this->pre.'pedidos (id_usuario, nombre, apellidos, direccion, codigo_postal, poblacion, movil) VALUES ';
        $q .= ' ('.$id_usuario.', "'.$nombre.'", "'.$apellidos.'", "'.$direccion.'", "'.$codigo_postal.'", "'.$poblacion.'", "'.$movil.'")';
        return $this->execute_query($q);
    }

    function reset_predeterminada_carrito($id_usuario){
        $q = ' UPDATE ' . $this->pre . 'carrito_datos SET ';
        $q .= ' predeterminada = 0 ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        return $this->execute_query($q);
    }

    function clear_carrito($id_usuario){
        $q = ' DELETE FROM ' . $this->pre . 'carrito_compra ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        return $this->execute_query($q);
    }

    function update_predeterminada_carrito($id_usuario, $id_carrito){
        $q = ' UPDATE ' . $this->pre . 'carrito_datos SET ';
        $q .= ' predeterminada = 1 ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_carrito = '.$id_carrito.' ';
        return $this->execute_query($q);
    }

    function get_direccion($id_usuario, $id_carrito){
        $q = ' SELECT * FROM ' . $this->pre . 'carrito_datos ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_carrito = '.$id_carrito.' ';
        return $this->execute_query($q);
    }

    function get_direcciones($id_usuario, $pred=0){
        $q = ' SELECT * FROM ' . $this->pre . 'carrito_datos ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND predeterminada = '.$pred.' ';
        return $this->execute_query($q);
    }

    function get_gateway_format($precio) {
        return (string)number_format((float)$precio, 2, '', '');
    }

    function update_direccion_envio($id_usuario, $nombre, $apellidos, $direccion, $cp, $poblacion, $movil, $id_carrito){
        $q = ' UPDATE ' . $this->pre . 'carrito_datos SET ';
        $q .= ' nombre = "'.$nombre.'", ';
        $q .= ' apellidos = "'.$apellidos.'", ';
        $q .= ' direccion = "'.$direccion.'", ';
        $q .= ' codigo_postal = "'.$cp.'", ';
        $q .= ' poblacion = "'.$poblacion.'", ';
        $q .= ' movil = "'.$movil.'" ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_carrito = '.$id_carrito.' ';
        return $this->execute_query($q);
    }

    function get_carrito($id_usuario, $lang) {
        $q  = ' SELECT cc.id_articulo,a.precio,a.stock,al.urlseo,al.nombre,cc.cantidad,al.img_portada,CONCAT(al.img,".png") as img FROM '.$this->pre.'carrito_compra as cc INNER JOIN ';
        $q .= ' '.$this->pre.'articulos_lang as al ON cc.id_articulo=al.id_articulo INNER JOIN ';
        $q .= ' '.$this->pre.'articulos as a ON al.id_articulo=a.id_articulo INNER JOIN ';
        $q .= ' '.$this->pre.'lang as l ON al.id_lang=l.id_lang ';
        $q .= ' WHERE al.visible=1 AND cc.id_usuario='.$id_usuario.' and l.code="'.$lang.'" ';
        return $this->execute_query($q);
    }

    function add_detallepedidos($id_pedido, $cantidad, $precio, $nombre){
        $q  = ' INSERT INTO '.$this->pre.'detallepedidos (id_pedido, cantidad, precio, nombre) VALUES ';
        $q .= ' ('.$id_pedido.', '.$cantidad.', '.$precio.', "'.$nombre.'")';
        return $this->execute_query($q);
    }

    function get_detallepedidos($id_pedido){
        $q = ' SELECT * FROM '.$this->pre.'detallepedidos ';
        $q .= ' WHERE id_pedido='.$id_pedido.' ';
        return $this->execute_query($q);
    }

    function get_articulo_carrito($id_usuario, $id_articulo){
        $q = ' SELECT * FROM '.$this->pre.'carrito_compra ca ';
        $q .= ' WHERE ca.id_usuario='.$id_usuario.' ';
        $q .= ' AND ca.id_articulo='.$id_articulo.' ';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function get_transporte(){
        $q = ' SELECT * FROM '.$this->pre.'transporte t ';
        return $this->execute_query($q);
    }

    function get_unidades_articulo_usuario($id_usuario, $id_articulo){
        $q = ' SELECT cantidad as total FROM ' . $this->pre . 'carrito_compra ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }

    function restarArticulo($id_usuario, $id_articulo){
        $q = ' UPDATE ' . $this->pre . 'carrito_compra SET ';
        $q .= ' cantidad=cantidad-1 ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }

    function sumarArticulo($id_usuario, $id_articulo){
        $q = ' UPDATE ' . $this->pre . 'carrito_compra SET ';
        $q .= ' cantidad=cantidad+1 ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }

    function delete_articulo_usuario_carrito($id_usuario, $id_articulo){
        $q = ' DELETE FROM ' . $this->pre . 'carrito_compra ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_articulo = '.$id_articulo.' ';
        return $this->execute_query($q);
    }

    function delete_direccion($id_usuario, $id_carrito){
        $q = ' DELETE FROM ' . $this->pre . 'carrito_datos ';
        $q .= ' WHERE id_usuario = '.$id_usuario.' ';
        $q .= ' AND id_carrito = '.$id_carrito.' ';
        return $this->execute_query($q);
    }

    function enviar_factura($email, $numpedido){
        $op = '<div class="container">
        <div class="logo">
            <img src="https://ysana.es/img/svg/ysanacolor.svg" class="img-logo" alt="Ysana">
        </div>
        <div class="contenedor success ohidden">
            <div class="centrar-pd">
                <img src="https://img.icons8.com/ios/64/88d69b/security-checked.png">
                <span>
                    <strong>PAGO SEGURO</strong><br>
                    Pago 100% seguro
                </span>
            </div>
            <div class="centrar-pd">
                <img src="https://img.icons8.com/ios/64/88d69b/security-checked.png">
                <span>
                    <strong>PAGO SEGURO</strong><br>
                    Pago 100% seguro
                </span>
            </div>
        </div>
        <div class="contenedor ovy">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Art&iacute;culo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="https://ysana.es/img/productos/ysana-articulaciones-ywellness.png" class="img-producto" alt="">
                            <span>Y·Wellness Articular</span>
                        </td>
                        <td>25€</td>
                        <td>2</td>
                        <td>50€</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="https://ysana.es/img/productos/ysana-reduce-colesterol.png" class="img-producto" alt="">
                            <span>Y·Wellness Colesterol</span>
                        </td>
                        <td>39€</td>
                        <td>3</td>
                        <td>117€</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="https://ysana.es/img/productos/eficaps-sueno-caja-detalle-flor-capsula.png" class="img-producto" alt="">
                            <span>Eficaps® Sueño</span>
                        </td>
                        <td>120€</td>
                        <td>1</td>
                        <td>120€</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="contenedor rss">
            <div class="rss-icon facebook">
                <a target="_blank" href="https://www.facebook.com/YSanaVidaSana/">
                    <img src="https://img.icons8.com/ios-glyphs/32/FFFFFF/facebook-f.png" alt="">
                </a>
            </div>
            <div class="rss-icon instagram">
                <a target="_blank" href="https://www.instagram.com/ysanavidasana/">
                    <img src="https://img.icons8.com/ios-glyphs/32/FFFFFF/instagram-new.png" alt="">
                </a>
            </div>
            <div class="rss-icon twitter">
                <a target="_blank" href="https://twitter.com/Ysana_Vida_Sana">
                    <img src="https://img.icons8.com/ios-glyphs/32/FFFFFF/twitter.png" alt="">
                </a>
            </div>
        </div>
        <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                body {
                    background-color: white;
                }
                .container {
                    width: 100%;
                    padding-right: 15px;
                    padding-left: 15px;
                    margin-right: auto;
                    margin-left: auto;
                    /* background-color: #bababa; */
                }
                .container>div {
                    margin-top: 1rem;
                    margin-bottom: 1rem;
                }
                .logo {
                    display: flex;
                    padding-top: .5rem;
                    padding-bottom: .5rem;
                }
                .img-logo {
                    max-width: 100%;
                    height: 64px;
                    margin: 0 auto;
                    transition: 2s;
                }
                .contenedor {
                    /* background-color: #cecece; */
                    box-shadow: 0px 3px 8px gray;
                    border-radius: 4px;
                    padding: 1rem;
                }
                .ohidden{
                    overflow: hidden;
                }
                .contenedor table {
                    width: 100%;
                    text-align: center;
                    border-radius: 4px;
                    color: rgb(100, 100, 100);
                }
                table, th, td {
                    border-collapse: collapse;
                }
                th {
                    background-color: #ebeced;
                    border-top: 1px solid rgb(170, 170, 170);
                    border-bottom: 1px solid rgb(170, 170, 170);
                }
                tr{
                    border-bottom: 1px solid rgb(170, 170, 170);
                }
                /* tr:last-child{
                    border-bottom: 3px solid rgb(170, 170, 170);
                } */
                th, td {
                    padding: .6rem;
                }
                tr>td:first-child{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-width: 300px;
                }
                .img-producto {
                    max-width: 96px;
                    height: auto;
                }
                .centrar-pd{
                    display: flex;
                    align-items: center;
                    margin-top: .25rem;
                    margin-bottom: .25rem;
                }
                .ovy{
                    overflow-y: auto;
                }
                .success{
                    color: #155724;
                }
                .contenedor.success{
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-around;
                }
                img+span{
                    margin-left: .25rem;
                    margin-right: .25rem;
                }
                .rss{
                    display: flex;
                    flex-wrap: wrap;
                    padding: 0;
                    border-radius: 4px;
                    overflow: hidden;
                }
                .facebook{
                    background-color: #3b5998;
                }
                .instagram{
                    background: #d6249f;
                    background: radial-gradient(circle at 0% 207%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
                }
                .twitter{
                    background-color: #00aced;
                }
                .rss-icon{
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 33.33334%;
                    padding: .3rem;
                }
                @media screen and (max-width: 576px){
                    .rss{
                        box-shadow: 0px 0px 0px white;
                    }
                    .rss-icon{
                        width: 100%;
                        margin-top: .25rem;
                        margin-bottom: .25rem;
                    }
                }
        </style>
    </div>';

        $asunto = 'Ysana - Pedido #'+$numpedido;
        $mail_admin = 'info@ysana.es';

        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=utf-8";
        //TODO
        $headers[] = "From: <no.reply@ysana.es> Ysana ";
        $headers[] = "Reply-To: <no.reply@ysana.es> Ysana ";
        $headers[] = "X-Mailer: PHP/" . phpversion();

        $cabeceras = implode("\r\n", $headers);

        $result_mail_send = TRUE;
        $result_mail_send = mail($email, $asunto, $op, $cabeceras); //produccion
        //$result_mail_send = getbagservice_mail($email, $asunto, $op, $headers);

        return $result_mail_send;
    }
}

?>