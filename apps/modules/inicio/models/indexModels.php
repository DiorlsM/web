<?php

/**
 * @link    
 * @author
 * @version 1.0
 */

class indexModels extends Adodb {

    private $dsn;

    public function __construct(){
        //$this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_menu');
    }

    public function linea(){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Linea');
      echo '=>' . parent::getSql() . '</br>';
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function marcas(){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_SubProductos');//Marcas
        //echo '=>' . parent::getSql() . '</br>';
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function categorias($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Categorias');//categorias
        
        parent::SetParameterSP($p['codigo'], 'char');
        //echo '=>' . parent::getSql() . '</br>';
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function productoCarro($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Datos_Producto');//categorias
        parent::SetParameterSP($p['cod_produc'], 'char');
        //echo '=>' . parent::getSql() . '</br>';
        $array = parent::ExecuteSPArray();
        return $array;
    }

    

    public function busquedalike($p){
        /*parent::ReiniciarMYSQL();
        $array = parent::MYSQL_EXE('select st.cod_prod,so.nom_prod,s2.nom_sub2,pr.precio_venta ,sum(st.stock_act)  from sopprod so inner join stocks st on st.cod_prod=so.cod_prod inner join almacen al on al.cod_alma=st.cod_alma inner join precios pr on pr.cod_prod = so.cod_prod inner join sopsub2 s2 on s2.cod_sub2 = so.cod_subc where so.nom_prod like "%'.$like['like'].'%" and pr.precio_venta > 0  group by 1,2,3,4');// having sum(st.stock_act) >0
        parent::CLOSE_MYSQL();
        return $array;*/

        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Lista_Productos_tipo');//Marcas
        parent::SetParameterSP($p['codigo'], 'char');
        parent::SetParameterSP($p['tipo'], 'int');
        //echo '=>' . parent::getSql() . '</br>';
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Lista_Datos_Prod($p){
        //var_export($p);die();
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Lista_Datos_Prod');//Marcas
        parent::SetParameterSP($p['produc'], 'char');//vp_cod
        //echo '=>' . parent::getSql() . '</br>';die();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function SP_Lista_imagen($p){
        parent::ReiniciarMYSQL();
        parent::ConnectionOpen(array('dbtype'=>'MYSQL'), 'SP_Lista_imagen');//Marcas
        parent::SetParameterSP('3', 'int');
        parent::SetParameterSP($p['produc'], 'char');
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





      
}
