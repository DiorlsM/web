<?php 

//require_once PATH . 'libs/adodb/Adodb.php';

class Session_Handlers {
	function informix_session_open ($save_path, $session_name) {
	    return true;
	} 

	function informix_session_close() {
	    return true;
	} 

	function informix_session_read ($SessionID) {
	    $Adodb = new Adodb;
	    $ses_id = Common::read_ini(PATH.'config/config.ini', 'server_menu');
	    //$SessionID = addslashes($SessionID); 
	    $Adodb->ReiniciarSQL();
	    $Adodb->ConnectionOpen($ses_id, 'usr_sis_session_read');
	    $Adodb->SetParameterSP($SessionID, 'char');
	    //echo '=>' . $Adodb->getSql();die();
	    $array = $Adodb->ExecuteSPArray();

	    if (intVal($array[0]['exist']) > 0){
	        return trim($array[0]['data_ses']);
	    }else{
	        return false;
	    }
	}

	function informix_session_write ($SessionID, $val) {
	    $Adodb = new Adodb;
	    $ses_id = Common::read_ini(PATH.'config/config.ini', 'server_menu');
	    //$SessionID = addslashes($SessionID);
	    //$val = addslashes($val);
	    $Adodb->ReiniciarSQL();
	    $Adodb->ConnectionOpen($ses_id, 'usr_sis_session_write');
	    $Adodb->SetParameterSP($SessionID, 'char');
	    $Adodb->SetParameterSP($val, 'char');
	    $Adodb->SetParameterSP($_SESSION['id_user'], 'int');
	    $Adodb->SetParameterSP(Common::get_Ip(), 'char');
	   // echo '=>' . $Adodb->getSql();die();
	    $array = $Adodb->ExecuteSPArray();
	    //return $array;
	    return false;
	}

	function informix_session_destroy ($SessionID) {
	    $Adodb = new Adodb;
	    $ses_id = Common::read_ini(PATH.'config/config.ini', 'server_menu');

	    //$SessionID = addslashes($SessionID);
	    $Adodb->ReiniciarSQL();
	    $Adodb->ConnectionOpen($ses_id, 'usr_sis_session_destroy');
	    $Adodb->SetParameterSP($SessionID, 'char');
	    //echo '=>' . $Adodb->getSql();die();
	    $array = $Adodb->ExecuteSPArray();
	    //return $array;
	    return true;
	}

	function informix_session_gc ($maxlifetime = 1800) {
	    $Adodb = new Adodb;
	    $ses_id = Common::read_ini(PATH.'config/config.ini', 'server_menu');

	    $Adodb->ReiniciarSQL();
	    $Adodb->ConnectionOpen($ses_id, 'usr_sis_session_trash');
	    //echo '=>' . $Adodb->getSql();die();
	    $array = $Adodb->ExecuteSPArray();
	    //return $array;
	    return true;
	} 
} 
//session_set_save_handler ('informix_session_open','informix_session_close','informix_session_read','informix_session_write','informix_session_destroy','informix_session_gc');

session_set_save_handler(
	array('Session_Handlers', 'informix_session_open'),
	array('Session_Handlers', 'informix_session_close'),
	array('Session_Handlers', 'informix_session_read'),
	array('Session_Handlers', 'informix_session_write'),
	array('Session_Handlers', 'informix_session_destroy'),
	array('Session_Handlers', 'informix_session_gc')
);

register_shutdown_function('session_write_close');

//session_start();