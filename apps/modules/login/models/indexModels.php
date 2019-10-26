<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class indexModels extends Adodb {

    private $dsn;

    public function __construct(){
        //$this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_menu');
    }

    public function usr_sis_login($p){
        /*parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'usr_sis_login');
        parent::SetParameterSP($p['usuario'], 'varchar');
        parent::SetParameterSP(sha1($p['password']), 'varchar');
        parent::SetParameterSP($p['ip'], 'varchar');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;*/

        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_login_usuarios');//Marcas
        parent::SetParameterSP($p['vp_codigo'], 'char');
        parent::SetParameterSP(sha1($p['vp_clave']), 'char');
        parent::SetParameterSP('@', 'int');
        parent::SetParameterSP('@', 'int');
        parent::SetParameterSP('@', 'int');
        //echo '=>' . parent::getSql() . '</br>';
        $array = parent::ExecuteSPArray();
        return $array;
    }

   /* public function usr_sis_change_password($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'usr_sis_change_password');
        parent::SetParameterSP($p['usuario'], 'varchar');
        parent::SetParameterSP(sha1($p['password_old']), 'varchar');
        parent::SetParameterSP(sha1($p['password_new']), 'varchar');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_novedad($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'scm_novedad_status');
        parent::SetParameterSP(USR_ID, 'int');
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function get_cloud($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'scm_down_reporte_cloud');
        parent::SetParameterSP(USR_ID, 'varchar');
        $array = parent::ExecuteSPArray();
        return $array;
    } */  

    

}
