<?php

/**
 * 
 * @link    http://www.yx.cl/developer/sms/api/web/0.08/lyric_api_web_documentation_0.08.pdf
 * @author  Robert Salvatierra Q.
 * @version 2.0
 */

if (!class_exists("Adodb")){
    require_once PATH . 'libs/adodb/Adodb.php';
}
if (!class_exists("Common")){
    require_once PATH . 'libs/Common.php';
}

class Sms extends Adodb {
    private $dsn;
    private $api_user = '';//'lyric_api';
    private $api_pass = '';//'admini';
    private $api_version = '';//'0.08';
    /*Para saber la version del api soportada*/
    //http://192.168.41.15/cgi-bin/exec?cmd=api_get_version

    private $url = '';
    private $data = array();
    private $context = null;
    private $estado = -1;
    private $message_id = -1;
    private $lyric_conf;
    /***Variables de inicio***/
    private $msg = '';
    private $destination = '';
    private $guia = 0;
    private $id_visita = 0;
    private $tel_id = 0;
    private $chk_id = 0;
    
    
    

    function __construct($msg, $destination, $gui_numero,$id_visita,$tel_id,$chk_id){
        
        $this->lyric_conf = new Zend_Config_Ini(PATH . 'config/config.ini', 'server_lyric');
        $this->api_user = $this->lyric_conf->api_user;
        $this->api_pass = $this->lyric_conf->api_pass;
        $this->api_version = $this->lyric_conf->api_version;
        
        $this->msg = substr(trim($this->string_replace($msg)),0,160);//160 caracteres es lo permitido
        $this->destination = trim($destination);
        $this->guia = $gui_numero;
        $this->id_visita = $id_visita;
        $this->tel_id = $tel_id;
        $this->chk_id = $chk_id;

        $this->url = "http://".$this->lyric_conf->web_user.":".$this->lyric_conf->web_pass."@".$this->lyric_conf->lyric_ip."/cgi-bin/exec";

        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_pyp30');

    }

    public function string_replace($msg){
        $search = array('á','é','í','ó','ú','Ã­','Â');
        $replace = array('a','e','i','o','u','i',' ');
        $msg = str_replace($search, $replace, $msg);
        $msg = ereg_replace("[^A-Za-z0-9/,:.()/-]", " ", $msg);
        return $msg;
    }

    public function get_msg(){
        return $this->msg;
    }

    public function get_destination(){
        return $this->destination;
    }

    public function get_guia(){
        return $this->guia;
    }
   //
    public function send(){
        //echo 'curl -H "Content-type: application/x-www-form-urlencoded" -d "cmd=api_queue_sms&username='.$this->api_user.'&password='.$this->api_pass.'&content='.$this->msg.'&destination='.$this->destination.'&api_version='.$this->api_version.'" '. $this->url;
        exec('curl -H "Content-type: application/x-www-form-urlencoded" -d "cmd=api_queue_sms&username='.$this->api_user.'&password='.$this->api_pass.'&content='.$this->msg.'&destination='.$this->destination.'&api_version='.$this->api_version.'" '. $this->url, $output);
        //error_log('curl -H "Content-type: application/x-www-form-urlencoded" -d "cmd=api_queue_sms&username='.$this->api_user.'&password='.$this->api_pass.'&content='.$this->msg.'&destination='.$this->destination.'&api_version='.$this->api_version.'" '. $this->url,3,'/error.log');
        $res = json_decode($output[0], true);
        
        if ($res['success']){
            $this->estado = 0;
            $this->message_id = $res['message_id'];//
            echo 'Mensaje insertado exitosamente. Ticket: ' . $this->message_id . '</br>';
            $this->pyp_envio_sms_log($this->message_id,'0');
        }else{
            $this->estado = -1;
            //echo $output[0];
            //error_log('curl -H "Content-type: application/x-www-form-urlencoded" -d "cmd=api_queue_sms&username='.$this->api_user.'&password='.$this->api_pass.'&content='.$this->msg.'&destination='.$this->destination.'&api_version='.$this->api_version.'" '. $this->url,3,'/error.log');//
            //echo 'curl -H "Content-type: application/x-www-form-urlencoded" -d "cmd=api_queue_sms&username='.$this->api_user.'&password='.$this->api_pass.'&content='.$this->msg.'&destination='.$this->destination.'&api_version='.$this->api_version.'" '. $this->url;
            echo 'Error al insertar mensaje. Codigo de error: ' . $res['error_code'] . '</br>';
            if ($res['error_code'] == '1'){
                $res['error_code'] = '4';
            }else if ($res['error_code'] == '2'){
                $res['error_code'] = '5';
            }else if ($res['error_code'] == '3'){
                $res['error_code'] = '6';
            }else if ($res['error_code'] == '4'){
                $res['error_code'] = '7';
            }else if ($res['error_code'] == '5'){
                $res['error_code'] = '8';
            }else if ($res['error_code'] == '0'){
                $res['error_code'] = '9';
            }
            $this->pyp_envio_sms_log('0',$res['error_code']);
        }
    }

    public function get_status(){
        if ($this->estado == -1 || $this->estado >= 2)
            return $this->estado;
        exec('curl -H "Content-type: application/x-www-form-urlencoded" -d "cmd=api_get_status&username='.$this->api_user.'&password='.$this->api_pass.'&message_id='.$this->message_id.'&api_version='.$this->api_version.'" '. $this->url, $output);
        $res = json_decode($output[0], true);
        
        if ($res['success']){
            $this->estado = $res['message_status'];
            if (intval($this->estado) == 2){
                echo 'Ticket: ' . $this->message_id . ' Estado: ' . $this->estado . '</br>';
               //$this->pyp_envio_sms_log();
            }
            return $res['message_status'];
        }else{
            
            echo 'Error al consultar estado. Codigo de error: ' . $res['error_code'] . '</br>';
            return -1;
        }
    }

    public function get_statusAll($message_id){
        exec('curl -H "Content-type: application/x-www-form-urlencoded" -d "cmd=api_get_status&username='.$this->api_user.'&password='.$this->api_pass.'&message_id='.$message_id.'&api_version='.$this->api_version.'" '. $this->url, $output);
        $res = json_decode($output[0], true);
        
        if ($res['success']){
            $this->estado = $res['message_status'];
            /*if (intval($this->estado) == 2){
                echo 'Ticket: ' . $this->message_id . ' Estado: ' . $this->estado . '</br>';
            }*/
            return $res['message_status'];
        }else{
            if ($res['error_code'] == '1'){
                $res['error_code'] = '4';
            }else if ($res['error_code'] == '2'){
                $res['error_code'] = '5';
            }else if ($res['error_code'] == '3'){
                $res['error_code'] = '6';
            }else if ($res['error_code'] == '4'){
                $res['error_code'] = '7';
            }else if ($res['error_code'] == '5'){
                $res['error_code'] = '8';
            }else if ($res['error_code'] == '0'){
                $res['error_code'] = '9';
            }
            return $res['error_code'];
        }
    }

    public function pyp_envio_sms_log($vp_message_id,$vp_estado){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'pyp_envio_sms_log');
        parent::SetParameterSP($this->id_visita, 'int');
        parent::SetParameterSP($this->msg, 'varchar');
        parent::SetParameterSP($this->tel_id, 'int');
        parent::SetParameterSP($this->chk_id, 'int');

        parent::SetParameterSP($vp_message_id, 'char');
        parent::SetParameterSP($vp_estado, 'char');
        parent::SetParameterSP('1', 'int');
        $array = parent::ExecuteSPArray();
        //error_log(parent::getSql(),3,'/error.log');
        /*error_log($this->id_visita,3,'/error.log');//
        error_log($this->msg,3,'/error.log');//
        error_log($this->get_msg().'-robert',3,'/error.log');//*/
            
        //echo parent::getSql(); //die();
        return $array;
    }
      /*public function setDataLog(){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'pcl_envio_sms_log');
        parent::SetParameterSP($this->get_guia(), 'int');
        parent::SetParameterSP($this->get_msg(), 'varchar');
        parent::SetParameterSP($this->get_destination(), 'varchar');
        parent::SetParameterSP('ER', 'varchar');
        parent::SetParameterSP(1, 'int');
        // echo parent::getSql(); die();
        $array = parent::ExecuteSPArray();
        return $array;
    }*/

   

}