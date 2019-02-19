<?php

class usuarioModel extends Model {
    
    private $tipo_usuario = USER;
    private $tipo_admin = ADMIN;
    
    public $lbl_tipos_usuario = array();
    
    function __construct() {
        $this->lbl_tipos_usuario = array($this->tipo_usuario => 'Usuario');
    }
    
    function add_participante($nombre_participante, $apellidos_participante, $email_participante, $edad_participante, $genero_participante, $poblacion_participante,
        $provincia_participante, $codigopostal_participante) {
        
        $q  = ' INSERT INTO '.$this->pre.'participantes ( '.
            'nombre_participante, apellidos_participante, email_participante, edad_participante, genero_participante, poblacion_participante, provincia_participante, codigopostal_participante, modelo) VALUES ';
        $q .= ' ("'.$nombre_participante.'", "'.$apellidos_participante.'", "'.$email_participante.'", "'.$edad_participante.'", "'.$genero_participante.'", "'.$poblacion_participante.'", "'.$provincia_participante.'", "'.$codigopostal_participante.'", "'.$_SESSION['modelo'].'" ) ';
        return $this->execute_query($q);
    }
    
    function get_estado_modelo() {
        $q  = ' SELECT em.* FROM '.$this->pre.'estado_modelo em ';
        $r = $this->execute_query($q);
        if ($r) {
            while ($f = $r->fetch_assoc()) {
                $modelo = $f['modelo'];
            }
            return $modelo;
        } else return 1;
    }
    
    function update_estado_modelo($modelo) {
        $q  = ' UPDATE '.$this->pre.'estado_modelo SET ';
        $q .=   ' modelo='.$modelo.' ';
        return $this->execute_query($q);
    }
    
    function get_participantes() {
        $q  = ' SELECT p.* FROM '.$this->pre.'participantes p ';
        $q .= ' ORDER BY p.fechahora DESC ';
        return $this->execute_query($q);
    }
    
    function get_participante($id_participante) {
        $q  = ' SELECT p.* FROM '.$this->pre.'participantes p ';
        $q .= ' WHERE p.id_participante = '.$id_participante.' ';
        return $this->execute_query($q);
    }
    
    function get_user_login($nombre_usuario, $contrasenya_usuario) {
        
    }
    
    function delete_usuario($id_usuario) {
        
    }
    
    function login_usuario($nombre_usuario, $contrasenya_usuario) {
        $return = true;
        
        $r = $this->get_user_login($nombre_usuario, $contrasenya_usuario); //verificar que el usuario existe en BD
        if ($r) { 
            $found = false;
            while ($f = $r->fetch_assoc()) {
                $found = true;
                $_SESSION['id_usuario'] = $f['id_usuario'];
                $_SESSION['nombre_usuario'] = $f['nombre_usuario'];
                $_SESSION['id_tipo_usuario'] = $f['id_tipo_usuario'];
                $_SESSION['nombrecompleto_usuario'] = $f['nombrecompleto_usuario'];
            }
            if (!$found) $return = '<div class="error_alert">Usuario o contraseña incorrecto</div>';
        } else $return = '<div class="error_alert">'.BD_ERR_MSG.'</div>';
        
        return $return;
    }
    
    function unlogin_usuario() {
        unset($_SESSION['id_usuario']);
        unset($_SESSION['nombre_usuario']);
        unset($_SESSION['id_tipo_usuario']);
        unset($_SESSION['nombrecompleto_usuario']);
    }
    
    function control_sesion($ruta_inicio, $nivel) {
        //si existe session, y el nivel de id_tipo_usuario meno o igual a nivel
        if (isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] <= $nivel) {
            return true;
        } else {
            header('Location: '.$ruta_inicio.'index.php'); exit();
        }
    }
}
?>