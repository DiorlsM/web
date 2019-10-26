<?php

/**
 *
 * @author  Robert Salvatierra Q.
 * @version 2.0
 */
if (!class_exists("Adodb")) {
    require_once PATH . 'libs/adodb/Adodb.php';
}
if (!class_exists("Common")) {
    require_once PATH . 'libs/Common.php';
}

class smsUE extends Adodb {

    public $logistica;
    public $pais;
    public $tel_numero;
    public $mensaje;
    public $guia; //guia con el WYB o G
    public $resultado;

    public function __construct($pais, $tel_numero, $mensaje, $guia,$id_visita=0,$chk_id=0,$registrar='S',$linea=3) {
        
    }

    public function getResultado() {
        return $this->resultado;
    }

    public function string_replace($msg) {
        $search = array('á', 'é', 'í', 'ó', 'ú', 'Ã­', 'Â');
        $replace = array('a', 'e', 'i', 'o', 'u', 'i', ' ');
        $msg = str_replace($search, $replace, $msg);
        $msg = ereg_replace("[^A-Za-z0-9/,:.()/-]", " ", $msg);
        return $msg;
    }

  

}

?>