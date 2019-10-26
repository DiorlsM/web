<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class [template]Models extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_mysql');
    }

    /*public function pa_demo($p){
     parent::ReiniciarSQL();
     parent::ConnectionOpen($this->dsn, 'pa_demo');
     parent::SetParameterSP(trim($p['param1']), 'int');
     parent::SetParameterSP(trim($p['param2']), 'int');
     //echo parent::getSql().'<br>'; exit();
     $array = parent::ExecuteSPArray();
     return $array;
    }*/

}
