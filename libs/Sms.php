<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

if (!class_exists("Adodb")){
    require_once PATH . 'libs/adodb/Adodb.php';
}
if (!class_exists("Common")){
    require_once PATH . 'libs/Common.php';
}

class Sms extends Adodb {

    private $api_user = '';//'lyric_api';
    private $api_pass = '';//'admini';
    private $api_version = '';//'0.08';


    private $url = '';
    private $data = array();
    private $context = null;
    private $estado = -1;
    private $message_id = -1;
    private $msg = '';
    private $destination = '';
    private $guia = 0;

    private $dsn;
    private $lyric_conf;

    function __construct($msg, $destination, $gui_numero){
        /*$this->lyric_conf = Common::read_ini(PATH . 'config/config.ini', 'server_lyric');
        var_export($this->lyric_conf);*/
        $this->lyric_conf = new Zend_Config_Ini(PATH . 'config/config.ini', 'server_lyric');
        $this->api_user = $this->lyric_conf->api_user;
        $this->api_pass = $this->lyric_conf->api_pass;
        $this->api_version = $this->lyric_conf->api_version;
        
        //var_export($this->lyric_conf);die();
        $this->msg = $this->string_replace($msg);
        $this->destination = $destination;
        $this->guia = $gui_numero;
        $this->url = "http://" . $this->lyric_conf->web_user . ":" . $this->lyric_conf->web_pass . "@" . $this->lyric_conf->lyric_ip . "/cgi-bin/exec";
        //echo $this->url;
        //die();
        $this->setData();
        $this->setContext();

        //$this->dsn = Common::read_ini(PATH . 'config/config.ini', 'server_pcll');

    }

    public function string_replace($msg){
        $search = array('á','é','í','ó','ú','Ã­');
        $replace = array('a','e','i','o','u','i');
        return str_replace($search, $replace, $msg);
    }
}