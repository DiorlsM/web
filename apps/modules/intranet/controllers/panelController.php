<?php

set_time_limit(0);
ini_set("memory_limit", "-1");

class panelController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
         /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new panelModels();
    }

    public function index($p){
        $this->view('panel/form_index.php', $p);
    }

     public function lista_tipo($p) {
        
        $array = array(
            array('id_tipo'=>'1','descrip'=>'Clasificación'),
            array('id_tipo'=>'2','descrip'=>'Categoria'),
            array('id_tipo'=>'3','descrip'=>'Producto'),
            array('id_tipo'=>'4','descrip'=>'Marca'),
        );
        
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
        );
        return $this->response($data);
    }

    public function lista_cantidad($p) {
        
        $array = array(
            array('id_tipo'=>'0','descrip'=>'[ Todos ]'),
            array('id_tipo'=>'1','descrip'=>'Sin Imagen'),
            array('id_tipo'=>'2','descrip'=>'1 A 5'),
            array('id_tipo'=>'3','descrip'=>'6 A 10'),
            array('id_tipo'=>'4','descrip'=>'Mayores a 10')
        );
        
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
        );
        return $this->response($data);
    }

     public function tipo_imagen($p) {
        
        $array = array(
            array('id_tipo'=>'1','descrip'=>'Principal'),
            array('id_tipo'=>'2','descrip'=>'Adicionales')
        );
        
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
        );
        return $this->response($data);
    }

    public function tipo_producto($p) {
        
        $array = array(
            array('id_tipo'=>'1','descrip'=>'Normal'),
            array('id_tipo'=>'2','descrip'=>'Nuevo'),
            array('id_tipo'=>'3','descrip'=>'Oferta'),
        );
        
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
        );
        return $this->response($data);
    }

    


     public function SP_Panel_Img($p) {
        $rs = $this->objDatos->SP_Panel_Img($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function set_upload($p){
        $rs = $this->objDatos->SP_Sube_imagen($p);
        //var_export($rs);die();
        $dirdestino = PATH."public_html/".$p['vp_tipo_carga']."/";
        $dirdestino .= $rs[0]['nom_imagen'].'.jpg';
        //echo $dirdestino;die();
        if (move_uploaded_file($_FILES['panel-file-img']['tmp_name'],$dirdestino)){

        }else{
           
        }

        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }

        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
        );
        return $this->response($data);
    }

    public function set_uploadBanner($p){
        $rs = $this->objDatos->SP_Sube_imagen_banner($p);
        //var_export($rs);die();
        $dirdestino = PATH."public_html/banner/".$p['vp_tipo_carga']."/";
        $dirdestino .= $rs[0]['nom_imagen'].'.jpg';
        //echo $dirdestino;die();
        if (move_uploaded_file($_FILES['panel-file-img']['tmp_name'],$dirdestino)){

        }else{
           
        }

        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }

        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
        );
        return $this->response($data);
    }

    public function lista_imagenes($p){
        $rs = $this->objDatos->SP_Lista_imagen($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $value['nombre'] = '/'.$p['vp_tipo_carga'].'/'.$value['nombre'].'.jpg';
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function scm_del_img($p){
        $rs = $this->objDatos->SP_elimina_imagen($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function SP_Graba_Prod($p){
        $rs = $this->objDatos->SP_Graba_Datos_Prod($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function Lista_Prod($p){
        $rs = $this->objDatos->SP_Lista_Datos_Prod($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function Lista_baner($p){
        $rs = $this->objDatos->SP_Lista_imagen_banner($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $value['nombre'] = '/banner/'.$p['vp_tipo_carga'].'/'.$value['nombre'].'.jpg';
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function SP_elimina_imagen_banner($p){
        $rs = $this->objDatos->SP_elimina_imagen_banner($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function SP_Lista_clasi_cate($p){
        $rs = $this->objDatos->SP_Lista_clasi_cate($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $value['chk'] = $value['estado'] == 1 ?true:false;
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }

    public function SP_Graba_clasi_cate($p){
        $rs = $this->objDatos->SP_Graba_clasi_cate($p);
        $array = array();
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $array[] = $value;
            }
        }
        $data = array(
            'success' => true,
            'total' => count($array),
            'data' => $array,
            //'sql' => $this->objDatos->getSql()
        );
        return $this->response($data);
    }


    

    
}