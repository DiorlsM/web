<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

set_time_limit(0);
ini_set("memory_limit", "-1");

class indexController extends AppController {

    private $objDatos;
    private $arrayMenu;

    function __construct(){
        header('X-XSS-Protection: 1; mode=block');
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        $this->objDatos = new indexModels();
    }

    public function index($p){
        /**
         * Cargando datos de archivo de configuracion
         */
        if (!isset($p['error']))
            $p['error'] = 0;
        session_start();
        //session_destroy();
       
        if ($_SESSION['id_user'] > 0) {
            header('Location: /intranet/index/');
        } else {
            $this->view('index/form_index.php', $p);
        }
    }

    /**
     * Valida el inicio de session.
     */
    public function valida($p){
        $p['ip'] = Common::get_Ip();
        $rs = $this->objDatos->usr_sis_login($p);
        //var_export($rs);die();

        $rs = $rs[0];
        if (intval($rs['opt']) >= 0 ){
            $this->set_session($rs);//die();
        }else{
            $p['opt'] = intval($rs['opt']);
            $p['mensaje'] = trim($rs['mensaje']);
            
            /*$HTTP_REFERER = str_replace('/login/index/valida','',$_SERVER['HTTP_REFERER']);
            $HTTP_REFERER = str_replace('/inicio/index/','',$HTTP_REFERER);
            $HTTP_REFERER = str_replace('http://','',$HTTP_REFERER);
            $HTTP_REFERER = str_replace('https://','',$HTTP_REFERER);
            
            $url = $_SERVER['HTTP_HOST'].'/';
            //echo $HTTP_REFERER.'<br>'. $url;
            if(!empty($HTTP_REFERER) && $HTTP_REFERER != $url){
                header("Location: /public_html/template/error.php");
                die();
            }*/
            
            $this->view('index/form_logout.php', $p);
        }
    }

    /**
     * Se encarga de validar y almacenar las variables del inicio de session. 
     */
    public function set_session($rs){
        session_start();
        $_SESSION['timeout'] = time();
        $_SESSION['id_user'] = intval($rs['id_user']);
        $_SESSION['time_session'] = intval('900');
        header('Location: /intranet/index/');
    }

    public function status_session(){
        session_start(); 
        set_time_limit(0);
        ini_set("memory_limit", "-1");
        $data = $this->status();
        return $this->response($data);
    }

}