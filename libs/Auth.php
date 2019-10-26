<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

/**
 * Clase para autenticar al usuario.
 */

class Auth {

    public function __construct() {

        session_start();
        /**
         * Definiendo variables de session que se utilizaran en todo el sistema.
         */
        define(USR_ID, $_SESSION['id_user']);
        
        
        //define(MENU, $_SESSION['menu']);
        //define(MENU, $_COOKIE["menu"]);
        
    }

    /**
     * Validando el estado de la session
     */
    public function valida($p='') {
    	$inactivo = /*60 * */$_SESSION['time_session'];
        if (isset($_SESSION["timeout"])) {
            $tiempoSession = time() - $_SESSION["timeout"];            
            if ($tiempoSession > $inactivo) {
                session_destroy();
                $p['sql_error'] = -2;
                $p['msn_error'] = 'Tiempo de session expirado!';
                require_once PATH . 'apps/modules/login/views/index/form_logout.php';
            }
        }
        $_SESSION["timeout"] = time();

        if (!isset($_SESSION['id_user'])){
            $this->expire($p);
            header("Location: /");
            exit();
        }
    }

    /**
     * Liberando session de usuario
     */
    public function expire($p='') {
        session_start();

        session_destroy();
    }

    public function status(){
        //var_export($_SESSION);die();
        $inactivo = /*60*/ $_SESSION['time_session'];
        $a = array('time' => 0);
        if (isset($_SESSION["timeout"])) {
            $tiempoSession = time() - $_SESSION["timeout"];
            if ($tiempoSession > $inactivo) {
                session_destroy();
                $a = array('time' => 0);
            }else
                $a = array('time' => $tiempoSession == 0 ? 1 : $tiempoSession,'vence'=>$inactivo);
        }else
            $a = array('time' => 0);
        return $a;
    }

}
