<?php

class usuarioModel extends Model {
    
    private $tipo_usuario = USER;
    private $tipo_admin = ADMIN;
    

    function __construct() {
    }

    function add_post_zoho($url, $params){
        //url-ify datos
        $params_string = '';
        foreach($params as $key=>$value){
            $params_string .= $key.'='.$value.'&';
        }
        rtrim($params_string, '&');
        $params_string = trim($params_string, '&');
        //Abrir conexion
        $ch = curl_init();
        //Añadir url, numero post params, datos
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //enviar post
        $result = curl_exec($ch);
        //cerrar conexión
        curl_close($ch);
    }

    function verificarCaptcha($secret, $response){
        $xd = false;
        // abrimos la sesión cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "secret=".$secret."&response=".$response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output1 = curl_exec ($ch);
        curl_close ($ch);
        $output = json_decode($output1, true);
        return ($output['success']) ? true : false;
    }

    function add_usuario($nombre_usuario, $apellidos_usuario, $email_usuario, $genero, $password_usuario) {
        $q = ' INSERT INTO '.$this->pre.'usuarios (nombre_usuario, apellidos_usuario, email_usuario, genero, password_usuario) ';
        $q .= ' VALUES ("'.$nombre_usuario.'","'.$apellidos_usuario.'","'.$email_usuario.'","'.$genero.'","'.$password_usuario.'")';
        return $this->execute_query($q);
    }

    function get_mail_user($id_usuario){
        $q = ' SELECT * FROM '.$this->pre.'usuarios ';
        $q .= ' WHERE id_usuario = "'.$id_usuario.'"';
        return $this->execute_query($q);
    }

    function update_usuario($id_usuario, $nombre_usuario, $apellidos_usuario, $genero){
        $q = ' UPDATE '.$this->pre.'usuarios SET ';
        $q .= ' nombre_usuario="'.$nombre_usuario.'", ';
        $q .= ' apellidos_usuario="'.$apellidos_usuario.'", ';
        $q .= ' genero="'.$genero.'" ';
        $q .= ' WHERE id_usuario='.$id_usuario.'';
        return $this->execute_query($q);
    }

    function update_password($password_usuario, $id_usuario, $randomkey){
        $q  = ' UPDATE '.$this->pre.'usuarios SET ';
        $q .= ' password_usuario="'.$password_usuario.'", ';
        $q .= ' randomkey="'.$randomkey.'" ';
        $q .= ' WHERE id_usuario='.$id_usuario.'';
        return $this->execute_query($q);
    }

    function set_estado_pedido_by_factura($id_pedido, $estado){
        $q  = ' UPDATE '.$this->pre.'pedidos SET ';
        $q .= ' completado="'.$estado.'" ';
        $q .= ' WHERE id_pedido='.$id_pedido.'';
        return $this->execute_query($q);
    }

    function add_randomkey_usuario($email_usuario, $length){
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $charsLength = strlen($characters) -1;
        $randomkey = "";
        for($i=0; $i<$length; $i++){
            $randNum = mt_rand(0, $charsLength);
            $randomkey .= $characters[$randNum];
        }
        /*------------------*/
        $q  = ' UPDATE '.$this->pre.'usuarios SET ';
        $q .=   ' randomkey="'.$randomkey.'" ';
        $q .= ' WHERE email_usuario="'.$email_usuario.'" ';
        if($this->execute_query($q)) return $randomkey;
        else return false;
       /*  return $this->execute_query($q); */
    }
    /* MAIL */
    function existemail($id_estado, $id_lang){
        $q = ' SELECT * FROM '.$this->pre.'mail ';
        $q .= ' WHERE id_estado = "'.$id_estado.'"';
        $q .= ' AND id_lang = "'.$id_lang.'"';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function addmail($id_estado, $id_lang, $asunto, $cuerpo){
        $q  = ' INSERT INTO '.$this->pre.'mail (id_estado, id_lang, asunto, cuerpo) VALUES ';
        $q .= ' ("'.$id_estado.'", "'.$id_lang.'", "'.$asunto.'", "'.$cuerpo.'")';
        return $this->execute_query($q);
    }

    function getmail($id_estado, $id_lang){
        $q  = ' SELECT * FROM '.$this->pre.'mail ';
        $q .= ' WHERE id_estado="'.$id_estado.'"';
        $q .= ' AND id_lang="'.$id_lang.'"';
        return $this->execute_query($q);
    }

    function updatemail($id_estado, $id_lang, $asunto, $cuerpo){
        $q = ' UPDATE '.$this->pre.'mail SET ';
        $q .= ' asunto="'.$this->escstr($asunto).'", ';
        $q .= ' cuerpo="'.$this->escstr($cuerpo).'" ';
        $q .= ' WHERE id_estado="'.$id_estado.'" ';
        $q .= ' AND id_lang="'.$id_lang.'" ';
        return $this->execute_query($q);
    }
    /* MAIL */

    function get_existe_correo($email_usuario) {
        $q = ' SELECT u.* FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.email_usuario="'.$email_usuario.'"';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function get_comprobar_randomkey($randomkey){
        $q = ' SELECT u.* FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.randomkey="'.$randomkey.'"';
        return $this->execute_query($q);
        /* $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false; */
    }

    function get_dardebaja_randomkey($randomkey){
        $q = ' SELECT u.* FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.randomkey="'.$randomkey.'"';
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function delete_user($randomkey){
        $q = ' UPDATE '.$this->pre.'usuarios SET ';
        $q .= ' deleted=1 ';
        $q .= ' WHERE randomkey="'.$randomkey.'" ';
        return $this->execute_query($q);
    }

    function get_usuarios($pag, $regs_x_pag, $arr_filtro_ps=false) {
        $q  = ' SELECT u.* FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.deleted = 0 and u.id_tipo_usuario=10 ';
        if($arr_filtro_ps=="si"){
            $q .= ' and ps_completo=1 ';
        }else if($arr_filtro_ps=="no"){
            $q .= ' and ps_completo=0 ';
        }
        $q .= ' LIMIT '.$pag*$regs_x_pag.','.$regs_x_pag.' ';
        return $this->execute_query($q);
    }

    function get_datos_pedido($id_pedido) {
        $q = ' SELECT * FROM '.$this->pre.'pedidos p ';
        $q .= ' WHERE p.id_pedido='.$id_pedido.' ';
        return $this->execute_query($q);
    }

    function get_datos_pedido_y_usuario($id_pedido) {
        $q = ' SELECT * FROM '.$this->pre.'pedidos p ';
        $q .= ' INNER JOIN '.$this->pre.'usuarios u ';
        $q .= ' ON u.id_usuario=p.id_usuario ';
        $q .= ' WHERE p.id_pedido='.$id_pedido.' ';
        return $this->execute_query($q);
    }

    function get_datos_usuario($id_usuario){
        $q  = ' SELECT u.* FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.id_usuario='.$id_usuario.'';
        return $this->execute_query($q);
    }

    function get_usuarios_total_regs($arr_filtro_ps=false) {
        $q  = ' SELECT u.* FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.deleted = 0 and u.id_tipo_usuario=10 ';
        if($arr_filtro_ps=="si"){
            $q .= ' and ps_completo=1 ';
        }else if($arr_filtro_ps=="no"){
            $q .= ' and ps_completo=0 ';
        }
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }
    
    function get_user_login($nombre_usuario, $contrasenya_usuario) {
        $q  = ' SELECT u.* FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.email_usuario = "'.$nombre_usuario.'" ';
        $q .= ' AND u.password_usuario = "'.$contrasenya_usuario.'" ';
        /* $q .= ' AND u.deleted = 0 '; */
        return $this->execute_query($q);
    }

    function get_input_array($arr,$id, $selected=false, $class=false, $onChange=false) {
        $o  = '';
        $o .= '<div>';
        foreach ($arr as $key => $val) $o .= '<input type="radio" '.(($selected == $key) ? ' checked="checked" ' : '').' value="'.$key.'" name="'.$id.'[]">'.$val.'</option>';
        $o .= '</div>';
        return $o;
    }

    function get_existe_articulo($id_articulo) {
        $q  = ' SELECT * FROM '.$this->pre.'img_articulos';
        $q .= ' WHERE id_articulo = '.$id_articulo;
        $r = $this->execute_query($q);
        if ($r) return $r->num_rows;
            else return false;
    }

    function get_combo_idioma($arr, $id, $selected=false, $class=false, $onChange=false) {
        $o  = '';
        $o2 = '';
        $o3 = '';
        $o .= '<div class="dropdown">
        <button class="dropdown-toggle" type="button" id="'.$id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ';
        if ($class) $o .= ' class ="'.$class.'" ';
        (!$onChange) ? $o .= '>' : $o .= 'onchange="this.form.submit()">';
        

        foreach ($arr as $key => $val){
            $o2 .= '<button class="dropdown-item" type="submit" name="'.$id.'" class="'.(($selected == $key) ? 'selected ' : 'no-selected').'" value="'.$key.'">'.$val.'</button>';
            $o3 .= (($selected == $key) ? $val : '');
        }
        //foreach ($arr as $key => $val) $o2 .= '<button class="dropdown-item" type="submit" name="'.$id.'" class="'.(($selected == $key) ? 'selected ' : 'no-selected').'" value="'.$key.'">'.$val.'</button>';

        $o .= $o3;
        $o .= '</button><div class="dropdown-menu" aria-labelledby="'.$id.'">';
        $o .= $o2.'</div></div>';
        return $o;
    }

    /* function get_combo_idioma($arr, $id, $selected=false, $class=false, $onChange=false) {
        $o  = '';
        $o .= '<select id="'.$id.'" name="'.$id.'" class="" ';
        if ($class) $o .= ' class ="'.$class.'" ';
        (!$onChange) ? $o .= '>' : $o .= 'onchange="this.form.submit()">';
        //$o .= '>';
        foreach ($arr as $key => $val) $o .= '<option '.(($selected == $key) ? ' selected="selected" ' : '').' value="'.$key.'">'.$val.'</option>';
        $o .= '</select>';
        return $o;
    } */

    function get_combo_array($arr, $id, $selected=false, $class=false, $onChange=false) {
        $o  = '';
        $o .= '<select id="'.$id.'" name="'.$id.'" class="form-control" ';
        if ($class) $o .= ' class ="'.$class.'" ';
        (!$onChange) ? $o .= '>' : $o .= 'onchange="this.form.submit()">';
        //$o .= '>';
        foreach ($arr as $key => $val) $o .= '<option '.(($selected == $key) ? ' selected="selected" ' : '').' value="'.$key.'">'.$val.'</option>';
        $o .= '</select>';
        return $o;
    }
    
    function get_combo_tipo_estilo($id, $selected=false, $class=false, $default=false) {
        $arr_estilos = array(
            'Holgada' => 'Holgada',
            'Recta' => 'Recta',
            'Entallada' => 'Entallada'
        );
        return $this->get_combo_array($arr_estilos, $id, $selected, $class, $default);
    }

    function get_combo_hijos($id, $selected=false, $class=false, $default=false){
        $arr_pregunta = array(
            'Si' => 'Si',
            'No' => 'No'
        );
        return $this->get_combo_array($arr_pregunta, $id, $selected, $class, $default);
    }

    function get_combo_textura_estilo($id, $selected=false, $class=false, $default=false) {
        $arr_estilos = array(
            'Estampados' => 'Estampados',
            'Colores lisos' => 'Colores lisos'
        );
        return $this->get_combo_array($arr_estilos, $id, $selected, $class, $default);
    }

    
    function get_combo_usuarios($id, $selected=false, $class=false, $onChange=false, $default=false, $filtro_tiendavf=false) {
        $o = ''; //output
        $q  = ' SELECT u.*, tvf.nombre_tiendavf FROM '.$this->pre.'usuarios u ';
        $q .= ' LEFT JOIN '.$this->pre.'tiendasvf tvf ON u.id_tiendavf = tvf.id_tiendavf ';
        $q .= ' WHERE u.id_tipo_usuario = '.$this->tipo_usuario.' ';
        if ($filtro_tiendavf > 0) $q .= ' AND u.id_tiendavf = '.$filtro_tiendavf.' ';
        $q .= ' AND u.deleted = 0 ';
        $q .= ' ORDER BY u.nombrecompleto_usuario ASC ';
        $r = $this->execute_query($q);
        if ($r) {
            $o .= '<select id="'.$id.'" name="'.$id.'" ';
            if ($class) $o .= ' class ="'.$class.'" ';
            if ($onChange) $o .= ' onchange="'.$onChange.'" ';
            $o .= '>';
            if ($default) $o .= '<option value="-1">-- Todos los usuarios --</option>';
            while($f = $r->fetch_assoc()) {
                $o .= '<option '.(($selected == $f['id_usuario']) ? ' selected="selected" ' : '').' value="'.$f['id_usuario'].'">'.
                    $f['nombrecompleto_usuario'].' ('.$f['nombre_tiendavf'].')'.
                    '</option>';
            }
            $o .= '</select>';
        } else return 'ERROR: '.$q;
        return $o;
    }
    
    function get_combo_tipos_usuario($id, $selected=false, $class=false, $onChange=false) {
        
        $o = ''; //output

        $arr_i = array($this->tipo_usuario => 'Comercial', $this->tipo_teamleader => 'Team Leader');
        
        $o .= '<select id="'.$id.'" name="'.$id.'" ';
        if ($class) $o .= ' class ="'.$class.'" ';
        if ($onChange) $o .= ' onchange="'.$onChange.'" ';
        $o .= '>';
        foreach ($arr_i as $key => $val) $o .= '<option '.(($selected == $key) ? ' selected="selected" ' : '').' value="'.$key.'">'.$val.'</option>';
        $o .= '</select>';

        return $o;
    }
    
    function get_lbl_tipo_usuario_by_id($id_tipo_usuario) {
        if (isset($this->lbl_tipos_usuario[$id_tipo_usuario])) return $this->lbl_tipos_usuario[$id_tipo_usuario];
            else return false;
    }

    function reset_user($id_usuario, $userpass, $randomkey){
        $q  = ' UPDATE '.$this->pre.'usuarios SET ';
        $q .=   ' contrasenya_usuario="'.$userpass.'", ';
        $q .=   ' randomkey="'.$randomkey.'" ';
        $q .= ' WHERE id_usuario="'.$id_usuario.'" ';
        return $this->execute_query($q);
    }

    
    /* function update_usuario($id_usuario, $nombre_usuario, $fecha_nacimiento, $nombrecompleto_usuario, $email_usuario, $contrasenya_usuario, $telf_usuario, $nie_usuario) {
        
        $q  = ' UPDATE '.$this->pre.'usuarios SET ';
        $q .=   ' nombre_usuario = "'.$nombre_usuario.'", ';
        $q .=   ' nombrecompleto_usuario = "'.$nombrecompleto_usuario.'", ';
        $q .=   ' fecha_nacimiento = "'.$fecha_nacimiento.'", ';
        $q .=   ' email_usuario = "'.$email_usuario.'", ';
        $q .=   ' contrasenya_usuario = "'.$contrasenya_usuario.'", ';
        $q .=   ' telf_usuario = "'.$telf_usuario.'", ';
        $q .=   ' nie_usuario = "'.$nie_usuario.'"';
        $q .= ' WHERE id_usuario='.$id_usuario.' ';
        return $this->execute_query($q);
    } */

    function delete_usuario($id_usuario) {
        $q  = ' UPDATE '.$this->pre.'usuarios SET ';
        $q .=   ' deleted = 1 ';
        $q .= ' WHERE id_usuario='.$id_usuario.' ';
        return $this->execute_query($q);
    }

    function clear_categorias_usuario($id_usuario){
        $q  = ' DELETE FROM '.$this->pre.'usuario_categorias ';
        $q .= ' WHERE id_usuario='.$id_usuario.' ';
        return $this->execute_query($q);
    }
    
    function login_usuario($nombre_usuario, $contrasenya_usuario, $msg, $msg2) {
        $return = true;
        
        $r = $this->get_user_login($nombre_usuario, $contrasenya_usuario); //verificar que el usuario existe en BD
        if ($r) { 
            $found = false;
            while ($f = $r->fetch_assoc()) {
                if($f['deleted']==0){
                    $found = true;
                    $_SESSION['id_usuario'] = $f['id_usuario'];
                    $_SESSION['nombre_usuario'] = $f['nombre_usuario'];
                    $_SESSION['apellidos_usuario'] = $f['apellidos_usuario'];
                    $_SESSION['email_usuario'] = $f['email_usuario'];
                    $_SESSION['id_tipo_usuario'] = $f['id_tipo_usuario'];
                }else $found = "debaja";
            }
            if($found=="debaja"){
                $return = '<div class="error_alert">'.$msg.'</div>';
            }else{
                $return = '<div class="error_alert">'.$msg2.'</div>';
            }
            /* if (!$found) $return = '<div class="error_alert">'.$msg.'</div>'; */
        } else $return = '<div class="error_alert">'.$msg2.'</div>';
        
        return $return;
    }
    
    function unlogin_usuario() {
        /* unset($_SESSION['id_usuario']);
        unset($_SESSION['nombre_usuario']);
        unset($_SESSION['apellidos_usuario']);
        unset($_SESSION['email_usuario']); */
        session_destroy();
    }
    
    //solo sirve para redirigir
    function control_sesion($ruta_inicio, $nivel, $redirect=true) {
        //si existe session, y el nivel de id_tipo_usuario menor o igual a nivel
        if (isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] <= $nivel) {
            // de momento no se da el caso
            return true;
        } else {
            if ($redirect == true) {
                header('Location: '.$ruta_inicio.'index.php');
                exit();
            }
            return false;
        }
    }

    function mail_prueba($email, $contenido){
        require("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; //Tipo de cifrado, TLS, STARTTLS..
        //$mail->SMTPDebug = 2;
        $mail->Host = "smtp-mail.outlook.com"; //Ex: mail.midominio.com
        $mail->Username = "info@ysana.es"; // Email de la cuenta de correo.
        $mail->Password = "Taz78446"; // La contraseña
        $mail->Port = 587; // Puerto 
        $mail->From = "info@ysana.es"; // Mismo mail que username
        $mail->FromName = "Ysana"; //A RELLENAR Nombre a mostrar del remitente. 
        $mail->AddAddress("dani.martinez@adstorm.es"); // Esta es la dirección a donde enviamos 
        //$mail->AddCC("info@ysana.es"); //CCopia
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = utf8_encode('Titulo'); // Este es el titulo del email. 
        $mail->Body = utf8_encode($contenido); // Mensaje a enviar.
        //$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
        $exito = $mail->Send(); // Envía el correo.

        return $exito;
    }

    function user_pedido_mail($id_pedido){
        $cM = load_model('carrito');
        $cuerpoMail = '';
        $asuntoMail = '';
        $xid_pedido = '';
        $xid_usuario = '';
        $xnombre = '';
        $xapellidos = '';
        $xdireccion = '';
        $xcodigo_postal = '';
        $xpoblacion = '';
        $xmovil = '';
        $xfecha_compra = '';
        $rgdyu = $this->get_datos_pedido_y_usuario($id_pedido);
        if($rgdyu){
            while($frgdyu = $rgdyu->fetch_assoc()){
                $xid_pedido = $frgdyu['id_pedido'];
                $xid_usuario = $frgdyu['id_usuario'];
                $xnombre = $frgdyu['nombre'];
                $xapellidos = $frgdyu['apellidos'];
                $xdireccion = $frgdyu['direccion'];
                $xcodigo_postal = $frgdyu['codigo_postal'];
                $xpoblacion = $frgdyu['poblacion'];
                $xmovil = $frgdyu['movil'];
                $xfecha_compra = $frgdyu['fecha_compra'];
            }
        }
        $rgdp = $cM->get_detallepedidos($xid_pedido);
        $outart = '';
        if($rgdp){
            while($frgdp = $rgdp->fetch_assoc()){
                $outart .= '<tr><td>'.$frgdp['nombre'].'</td><td>'.$frgdp['cantidad'].'</td><td>'.$frgdp['precio'].'</td><td>'.($frgdp['cantidad']*$frgdp['precio']).'</td></tr>';
            }
        }
        $cuerpoMail = '
        <table style="width:100%;">
            <tr>
                <th>ID Pedido</th><th>Nombre</th><th>Apellidos</th><th>Direccion</th><th>Codigo Postal</th><th>Poblacion</th><th>Fecha de compra</th>
            </tr>
            <tr>
                <td>'.$xid_pedido.'</td><td>'.$xnombre.'</td><td>'.$xapellidos.'</td><td>'.$xdireccion.'</td><td>'.$xcodigo_postal.'</td><td>'.$xpoblacion.'</td><td>'.mysql_to_date($xfecha_compra).'</td>
            </tr>
        </table>
        <br><br>
        <table style="width:100%;">
            <tr>
                <th>Nombre Articulo</th><th>Unidades</th><th>Precio</th><th>Total</th>
            </tr>
            '.$outart.'
        </table>';
        $asuntoMail = 'Nuevo Pedido - #'.$xid_pedido;
        //$cuerpoMail = str_replace("[nombre_usuario]", $nombre_usuario, $cuerpoMail);
        $op = '<!DOCTYPE html>
        <head><meta http-equiv="Content-Type" content="text/html; charset="UTF-8"></head>
        <html>
        <body>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
            }
        </style>
            <div style="display: block; margin: 0 auto; max-width: 1600px;">
                <div style="background-color: #00ABC8;">
                    <img src="https://adstorm.es/ysana/img/svg/ysanablanco.svg" height="88px" style="display: block; margin: 0 auto; padding-top: 12px; padding-bottom: 12px;">
                </div>
                <div style="background-color: #FFF; padding-top: 8px; padding-bottom: 8px;">';
        $op .= $cuerpoMail;
        $op .= '</div>        
                <div style="padding-top: 8px; padding-bottom: 8px; background-color: #F1F1F1;">
                    <div style="margin-left: auto;display: table;">
                        <a href="https://www.facebook.com/YSanaVidaSana/"><img src="https://img.icons8.com/material-rounded/24/000000/facebook.png" width="32px"></a>
                        <a href="https://twitter.com/Ysana_Vida_Sana"><img src="https://img.icons8.com/material-rounded/24/000000/twitter.png" width="32px"></a>
                        <a href="https://www.instagram.com/ysanavidasana/"><img src="https://img.icons8.com/material-rounded/24/000000/instagram-new.png" width="32px"></a>
                    </div>
                </div>
            </div>
        </body>
        </html>';

        require("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; //Tipo de cifrado, TLS, STARTTLS..
        //$mail->SMTPDebug = 2;
        $mail->Host = "smtp-mail.outlook.com"; //Ex: mail.midominio.com
        $mail->Username = "info@ysana.es"; // Email de la cuenta de correo.
        $mail->Password = "Taz78446"; // La contraseña
        $mail->Port = 587; // Puerto 
        $mail->From = "info@ysana.es"; // Mismo mail que username
        $mail->FromName = "Ysana"; //A RELLENAR Nombre a mostrar del remitente. 
        $mail->AddAddress("dani.martinez@adstorm.es"); // Esta es la dirección a donde enviamos 
        //$mail->AddCC("info@ysana.es"); //CCopia
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = utf8_encode($asuntoMail); // Este es el titulo del email. 
        $mail->Body = utf8_encode($op); // Mensaje a enviar.
        //$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
        $exito = $mail->Send(); // Envía el correo.

        return $exito;
    }

    function user_pedido_mail_df($id_usuario, $id_lang){
        $cM = load_model('carrito');
        $cuerpoMail = '';
        $asuntoMail = '';
        $nombertienda = '';
        $direccionfarmacia = '';
        $codigopostalfarmacia = '';
        $poblacionfarmacia = '';
        $provincia = '';
        
        $rgdp = $cM->get_cesta_df($id_usuario, $id_lang);
        $outart = '';
        if($rgdp){
            while($frgdp = $rgdp->fetch_assoc()){
                $nombertienda = utf8_encode($frgdp['nombrecompleto_farmacia']);
                $direccionfarmacia = utf8_encode($frgdp['direccion_farmacia']);
                $codigopostalfarmacia = utf8_encode($frgdp['codigopostal_farmacia']);
                $poblacionfarmacia = utf8_encode($frgdp['poblacion_farmacia']);
                $provincia = utf8_encode($frgdp['provincia_farmacia']);
                $outart .= '<tr><td>'.utf8_encode($frgdp['nombre']).'</td><td>'.utf8_encode($frgdp['cantidad']).'</td><td>'.utf8_encode($frgdp['precio']).'</td><td>'.($frgdp['cantidad']*$frgdp['precio']).'</td></tr>';
            }
        }
        $cuerpoMail = '
        <table style="width:100%;">
            <tr>
                <th>Nombre tienda</th><th>Direccion farmacia</th><th>Codigo postal</th><th>Poblacion</th><th>Provincia</th>
            </tr>
            <tr>
                <td>'.$nombertienda.'</td><td>'.$direccionfarmacia.'</td><td>'.$codigopostalfarmacia.'</td><td>'.$poblacionfarmacia.'</td><td>'.$provincia.'</td>
            </tr>
        </table>
        <br><br>
        <table style="width:100%;">
            <tr>
                <th>Nombre Articulo</th><th>Unidades</th><th>Precio</th><th>Total</th>
            </tr>
            '.$outart.'
        </table>';
        $asuntoMail = 'Nuevo Pedido - Farmacia:'.$nombertienda;
        //$cuerpoMail = str_replace("[nombre_usuario]", $nombre_usuario, $cuerpoMail);
        $op = '<!DOCTYPE html>
        <head><meta http-equiv="Content-Type" content="text/html; charset="UTF-8"></head>
        <html>
        <body>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
            }
        </style>
            <div style="display: block; margin: 0 auto; max-width: 1600px;">
                <div style="background-color: #00ABC8;">
                    <img src="https://adstorm.es/ysana/img/svg/ysanablanco.svg" height="88px" style="display: block; margin: 0 auto; padding-top: 12px; padding-bottom: 12px;">
                </div>
                <div style="background-color: #FFF; padding-top: 8px; padding-bottom: 8px;">';
        $op .= $cuerpoMail;
        $op .= '</div>        
                <div style="padding-top: 8px; padding-bottom: 8px; background-color: #F1F1F1;">
                    <div style="margin-left: auto;display: table;">
                        <a href="https://www.facebook.com/YSanaVidaSana/"><img src="https://img.icons8.com/material-rounded/24/000000/facebook.png" width="32px"></a>
                        <a href="https://twitter.com/Ysana_Vida_Sana"><img src="https://img.icons8.com/material-rounded/24/000000/twitter.png" width="32px"></a>
                        <a href="https://www.instagram.com/ysanavidasana/"><img src="https://img.icons8.com/material-rounded/24/000000/instagram-new.png" width="32px"></a>
                    </div>
                </div>
            </div>
        </body>
        </html>';

        require("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; //Tipo de cifrado, TLS, STARTTLS..
        //$mail->SMTPDebug = 2;
        $mail->Host = "smtp-mail.outlook.com"; //Ex: mail.midominio.com
        $mail->Username = "info@ysana.es"; // Email de la cuenta de correo.
        $mail->Password = "Taz78446"; // La contraseña
        $mail->Port = 587; // Puerto 
        $mail->From = "info@ysana.es"; // Mismo mail que username
        $mail->FromName = "Ysana"; //A RELLENAR Nombre a mostrar del remitente. 
        $mail->AddAddress("dani.martinez@adstorm.es"); // Esta es la dirección a donde enviamos 
        //$mail->AddCC("info@ysana.es"); //CCopia
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = $asuntoMail; // Este es el titulo del email. 
        $mail->Body = $op; // Mensaje a enviar.
        //$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
        $exito = $mail->Send(); // Envía el correo.

        return $exito;
    }

    function user_nuevousuario_mail($email, $ruta_inicio, $id_lang){
        $cuerpoMail = '';
        $asuntoMail = '';
        $rgm = $this->getmail(1, $id_lang);
        if($rgm){
            while($frgm = $rgm->fetch_assoc()){
                $cuerpoMail = $frgm['cuerpo'];
                $asuntoMail = $frgm['asunto'];
            }
        }
        $op = utf8_encode('<!DOCTYPE html>
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8""></head>
        <html>
        <body>
            <div style="display: block; margin: 0 auto; max-width: 750px;">
                <div style="background-color: #00ABC8;">
                    <img src="'.$ruta_inicio.'img/svg/ysanablanco.svg" height="88px" style="display: block; margin: 0 auto; padding-top: 12px; padding-bottom: 12px;">
                </div>
                <div style="background-color: #FFF; padding-top: 8px; padding-bottom: 8px;">');
        $op .= utf8_encode($cuerpoMail);
        $op .= utf8_encode('</div>        
                <div style="padding-top: 8px; padding-bottom: 8px; background-color: #F1F1F1;">
                    <div style="margin-left: auto;display: table;">
                        <a href="https://www.facebook.com/YSanaVidaSana/"><img src="https://img.icons8.com/material-rounded/24/000000/facebook.png" width="32px"></a>
                        <a href="https://twitter.com/Ysana_Vida_Sana"><img src="https://img.icons8.com/material-rounded/24/000000/twitter.png" width="32px"></a>
                        <a href="https://www.instagram.com/ysanavidasana/"><img src="https://img.icons8.com/material-rounded/24/000000/instagram-new.png" width="32px"></a>
                    </div>
                </div>
            </div>
        </body>
        </html>');

        require("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; //Tipo de cifrado, TLS, STARTTLS..
        //$mail->SMTPDebug = 2;
        $mail->Host = "smtp-mail.outlook.com"; //Ex: mail.midominio.com
        $mail->Username = "info@ysana.es"; // Email de la cuenta de correo.
        $mail->Password = "Taz78446"; // La contraseña
        $mail->Port = 587; // Puerto 
        $mail->From = "info@ysana.es"; // Mismo mail que username
        $mail->FromName = "Ysana"; //A RELLENAR Nombre a mostrar del remitente. 
        $mail->AddAddress($email); // Esta es la dirección a donde enviamos 
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = utf8_encode($asuntoMail); // Este es el titulo del email. 
        $mail->Body = utf8_encode($op); // Mensaje a enviar.
        //$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
        $exito = $mail->Send(); // Envía el correo.

        return $exito;
    }

    function get_name_by_email($email){
        $q = ' SELECT * FROM '.$this->pre.'usuarios u ';
        $q .= ' WHERE u.email_usuario="'.$email.'" ';
        return $this->execute_query($q);
    }

    function user_forgotpass_mail($email, $randomkey, $ruta_inicio, $id_lang){
        $cuerpoMail = '';
        $asuntoMail = '';
        $nombre_usuario = '';
        $rgm = $this->getmail(0, $id_lang);
        if($rgm){
            while($frgm = $rgm->fetch_assoc()){
                $cuerpoMail = $frgm['cuerpo'];
                $asuntoMail = $frgm['asunto'];
            }
        }
        $rgnbe = $this->get_name_by_email($email);
        if($rgnbe){
            while($frgnbe = $rgnbe->fetch_assoc()){
                $nombre_usuario = $frgnbe['nombre_usuario'];
            }
        }
        $cuerpoMail = str_replace("[nombre_usuario]", $nombre_usuario, $cuerpoMail);
        $op = '<!DOCTYPE html>
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8""></head>
        <html>
        <body>
            <div style="display: block; margin: 0 auto; max-width: 750px;">
                <div style="background-color: #00ABC8;">
                    <img src="'.$ruta_inicio.'img/svg/ysanablanco.svg" height="88px" style="display: block; margin: 0 auto; padding-top: 12px; padding-bottom: 12px;">
                </div>
                <div style="background-color: #FFF; padding-top: 8px; padding-bottom: 8px;">';
        $op .= $cuerpoMail;
        $op .= '<a href="'.$ruta_inicio.'forgot-password/?randomkey='.$randomkey.'" target="_blank"><button>Cambiar contraseña</button></a>
                </div>        
                <div style="padding-top: 8px; padding-bottom: 8px; background-color: #F1F1F1;">
                    <div style="margin-left: auto;display: table;">
                        <a href="https://www.facebook.com/YSanaVidaSana/"><img src="https://img.icons8.com/material-rounded/24/000000/facebook.png" width="32px"></a>
                        <a href="https://twitter.com/Ysana_Vida_Sana"><img src="https://img.icons8.com/material-rounded/24/000000/twitter.png" width="32px"></a>
                        <a href="https://www.instagram.com/ysanavidasana/"><img src="https://img.icons8.com/material-rounded/24/000000/instagram-new.png" width="32px"></a>
                    </div>
                </div>
            </div>
        </body>
        </html>';

        require("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; //Tipo de cifrado, TLS, STARTTLS..
        //$mail->SMTPDebug = 2;
        $mail->Host = "smtp-mail.outlook.com"; //Ex: mail.midominio.com
        $mail->Username = "info@ysana.es"; // Email de la cuenta de correo.
        $mail->Password = "Taz78446"; // La contraseña
        $mail->Port = 587; // Puerto 
        $mail->From = "info@ysana.es"; // Mismo mail que username
        $mail->FromName = "Ysana"; //Nombre a mostrar del remitente. 
        $mail->AddAddress($email); // Esta es la dirección a donde enviamos 
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = $asuntoMail; // Este es el titulo del email. 
        $mail->Body = $op; // Mensaje a enviar.
        //$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
        $exito = $mail->Send(); // Envía el correo.

        return $exito;
    }


    function user_unsuscribe_mail($email, $randomkey, $ruta_inicio, $id_lang){
        $cuerpoMail = '';
        $asuntoMail = '';
        $nombre_usuario = '';
        $rgm = $this->getmail(3, $id_lang);
        if($rgm){
            while($frgm = $rgm->fetch_assoc()){
                $cuerpoMail = $frgm['cuerpo'];
                $asuntoMail = $frgm['asunto'];
            }
        }
        $rgnbe = $this->get_name_by_email($email);
        if($rgnbe){
            while($frgnbe = $rgnbe->fetch_assoc()){
                $nombre_usuario = $frgnbe['nombre_usuario'];
            }
        }
        $cuerpoMail = str_replace("[nombre_usuario]", $nombre_usuario, $cuerpoMail);
        $op = '<!DOCTYPE html>
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8""></head>
        <html>
        <body>
            <div style="display: block; margin: 0 auto; max-width: 750px;">
                <div style="background-color: #00ABC8;">
                    <img src="'.$ruta_inicio.'img/svg/ysanablanco.svg" height="88px" style="display: block; margin: 0 auto; padding-top: 12px; padding-bottom: 12px;">
                </div>
                <div style="background-color: #FFF; padding-top: 8px; padding-bottom: 8px;">';
        $op .= $cuerpoMail;
        $op .= '<a href="'.$ruta_inicio.'unsubscribe/?randomkey='.$randomkey.'" target="_blank"><button>Darme de baja</button></a>
                </div>        
                <div style="padding-top: 8px; padding-bottom: 8px; background-color: #F1F1F1;">
                    <div style="margin-left: auto;display: table;">
                        <a href="https://www.facebook.com/YSanaVidaSana/"><img src="https://img.icons8.com/material-rounded/24/000000/facebook.png" width="32px"></a>
                        <a href="https://twitter.com/Ysana_Vida_Sana"><img src="https://img.icons8.com/material-rounded/24/000000/twitter.png" width="32px"></a>
                        <a href="https://www.instagram.com/ysanavidasana/"><img src="https://img.icons8.com/material-rounded/24/000000/instagram-new.png" width="32px"></a>
                    </div>
                </div>
            </div>
        </body>
        </html>';

        require("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; //Tipo de cifrado, TLS, STARTTLS..
        //$mail->SMTPDebug = 2;
        $mail->Host = "smtp-mail.outlook.com"; //Ex: mail.midominio.com
        $mail->Username = "info@ysana.es"; // Email de la cuenta de correo.
        $mail->Password = "Taz78446"; // La contraseña
        $mail->Port = 587; // Puerto 
        $mail->From = "info@ysana.es"; // Mismo mail que username
        $mail->FromName = "Ysana"; //Nombre a mostrar del remitente. 
        $mail->AddAddress($email); // Esta es la dirección a donde enviamos 
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = $asuntoMail; // Este es el titulo del email. 
        $mail->Body = $op; // Mensaje a enviar.
        //$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
        $exito = $mail->Send(); // Envía el correo.

        return $exito;
    }

    /* function generateRandomString($length){ 
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $charsLength = strlen($characters) -1;
        $string = "";
        for($i=0; $i<$length; $i++){
            $randNum = mt_rand(0, $charsLength);
            $string .= $characters[$randNum];
        }
        return $string;
    } */

}
?>