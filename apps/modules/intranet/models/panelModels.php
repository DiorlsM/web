<?php

/**
 * @link    
 * @author
 * @version 1.0
 */

class panelModels extends Adodb {

    private $dsn;

    public function __construct(){
       
    }

    public function SP_Panel_Img($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Panel_Img');//Marcas
        parent::SetParameterSP($p['vp_tipo'], 'char');
        parent::SetParameterSP($p['vp_cant'], 'char');
        parent::SetParameterSP($p['vp_id'], 'char');
        parent::SetParameterSP($p['vp_clave'], 'char');
        //echo '=>' . parent::getSql() . '</br>';
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Sube_imagen($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Sube_imagen');//Marcas
        parent::SetParameterSP($p['vp_tipo_carga'], 'int');
        parent::SetParameterSP($p['vp_cod'], 'char');
        parent::SetParameterSP($p['vp_tipo_imagen'], 'char');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Lista_imagen($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Lista_imagen');//Marcas
        parent::SetParameterSP($p['vp_tipo_carga'], 'int');
        parent::SetParameterSP($p['vp_cod'], 'char');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }   

    public function SP_elimina_imagen($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_elimina_imagen');//Marcas
        parent::SetParameterSP($p['vp_tipo_carga'], 'int');
        parent::SetParameterSP($p['vp_id'], 'int');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    } 

    public function SP_Graba_Datos_Prod($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Graba_Datos_Prod');//Marcas
        parent::SetParameterSP($p['vp_cod'], 'char');
        parent::SetParameterSP($p['vp_descri'], 'char');
        parent::SetParameterSP($p['vp_caract'], 'char');
        parent::SetParameterSP($p['vp_especi'], 'char');
        parent::SetParameterSP($p['vp_opt'], 'char');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Lista_Datos_Prod($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Lista_Datos_Prod');//Marcas
        parent::SetParameterSP($p['vp_cod'], 'char');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Sube_imagen_banner($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Sube_imagen_banner');//Marcas
        parent::SetParameterSP($p['vp_cod'], 'char');
        parent::SetParameterSP($p['vp_tipo_carga'], 'int');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Lista_imagen_banner($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Lista_imagen_banner');//Marcas
        parent::SetParameterSP($p['vp_cod'], 'char');
        parent::SetParameterSP($p['vp_tipo_carga'], 'int');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_elimina_imagen_banner($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_elimina_imagen_banner');//Marcas
        parent::SetParameterSP($p['vp_id'], 'int');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Lista_clasi_cate($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Lista_clasi_cate');//Marcas
        parent::SetParameterSP($p['vp_codigo'], 'char');
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Graba_clasi_cate($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Graba_clasi_cate');//Marcas
        parent::SetParameterSP($p['vp_cod_clasi'], 'char');
        parent::SetParameterSP($p['vp_cod_cate'], 'char');
        parent::SetParameterSP($p['vp_estado'], 'char');
        
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    


    


    
}
