<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

// use \Geekode\Geekode;

//require_once PATH . 'libs/Auth.php';


class AppController extends \Geekode\Geekode{

    private $dsn;

    function __construct(){
    }

    /**
     * Instancia a la clase Auth para validar la session del usuario.
     */

    function valida(){
        $objAuth = new Auth();
        $objAuth->valida();
    }

    /**
     * Instancia a la clase Auth para finalizar la session usuario.
     */
    function expire(){
        $objAuth = new Auth();
        $objAuth->expire();
    }

    function status(){
        $objAuth = new Auth();
        return $objAuth->status();
    }

    /**
     * Se encarga de renderizar las vistas.
     */
    function view($path = '', $p = array()){
        try{
            if (!file_exists(APPPATH_VIEW . $path)){
                throw new Exception('This views you request was not found.', 404);
            }else{
                require APPPATH_VIEW . $path;
            }
        } catch (Exception $e) {
            require_once PATH . 'public_html/template/error.php';
        }
    }

    function getImg_base64($img){
        $path = PATH . 'public_html/images/front/'. $img;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    function response($data, $content_type = 'application/json'){
        $this->set_headers('Content-Type', $content_type);
        return $this->getData($data);
    }

    function include_excel(){
        set_time_limit(180);
        ini_set("memory_limit", "-1");
        require_once PATH . 'libs/PHPExcel/PHPExcel.php';
    }

    function include_mailer(){
        require_once PATH . 'libs/phpmailer/class.phpmailer.php';
    }

}
