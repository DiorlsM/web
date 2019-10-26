<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class Adodb {

    private $arrayDsn=array();
    private $conex;
    private $parameter=array();
    private $nomProcedure='';
    private $scheme = '';
    private $data='';
    private $arrayData=array();
    private $query;
    private $pathFileDebug;
    private $connectionAutoClose = TRUE;

    private $result;
    private $link;

    public function  __construct(){
        //$this->pathFileDebug = PATH."debug/debug.log";
    }

    public function ConnectionOpen($_dsn=array(),$_sp='', $_scheme = 'dbo'){
        $this->arrayDsn = $_dsn;
        $this->nomProcedure = $_sp;
        $this->scheme = $_scheme;

        switch (strtoupper($this->arrayDsn['dbtype'])){
            case 'MYSQL':
                $this->conex = mysql_connect('127.0.0.1', 'root', '')
                or die('No se pudo conectar: ' . mysql_error());
                mysql_select_db('eac') or die('No se pudo seleccionar la base de datos');
                break;
            case 'MSSQL':
                $this->conex = mssql_connect($this->arrayDsn['dbhost'], $this->arrayDsn['dbuser'], $this->arrayDsn['dbpass']);
                if (!$this->conex){
                    exit();
                }else{
                    $db = mssql_select_db($this->arrayDsn['dbname'], $this->conex);
                }
                break;
            case 'INFORMIX':
                try{
                    $this->arrayDsn = $_dsn;
                    $this->arrayDsn['dbname'] = $_db==''?$_dsn['dbname']:$_db;
                    $this->nomProcedure = $_sp;
                    $dsn = $_dsn['dbtype'].':host='.$_dsn['dbhost'].';service='.$_dsn['dbservices'].';database='.$_dsn['dbname'].';server='.$_dsn['dbserver'].';protocol='.$_dsn['protocolo'].';EnableScrollableCursors='.$_dsn['scrolle'];
                    $this->conex = new PDO($dsn,$_dsn['dbuser'],$_dsn['dbpass']);
                }catch(PDOException $e){
                    //error_log(date('d-m-Y h:i:s A', time())."Error:SQL".$e.'PID:'.getmypid().chr(13),3,'/error.log');
                    exec('kill -9 '.getmypid());
                    throw new Exception("Error:Conexion Fallida");
                    exit();
                }
                break;
        }
    }

    public function SetParameterSP($pValue,$_tparam){
        $_tparam=trim($_tparam)==''?'VARCHAR':trim($_tparam);
        $replace = array("'");
        
        switch(strtoupper($_tparam)){
            case "NUMERIC": case "INT": case "INTEGER": case "DECIMAL":
                if ($pValue=="")                        $pValue="NULL";
                else if(strtoupper($pValue)=="NULL")    $pValue = "NULL";   
                else                                    $pValue = "$pValue";                
            break;
            case "VARCHAR": case "TEXT":    default:        
                $pValue = str_replace($replace,'',$pValue);
                $pValue = utf8_decode($pValue);
                if ($pValue=="")                        $pValue="''";
                else if(strtoupper($pValue)=="NULL")    $pValue = "NULL";   
                else                                    $pValue = "'$pValue'";  
            break;   
            case "DATE":
                if ($pValue=="")                        $pValue="''";
                else if(strtoupper($pValue)=="NULL")    $pValue = "''";
                else                                    $pValue = "'".Common::getFormatDMY($pValue)."'";
        }
        $this->parameter[]=$pValue;
    }

    public function Prepare_Procedure(){
        switch (strtoupper($this->arrayDsn['dbtype'])){
            case 'MYSQL':
                $query = " Call ".$this->nomProcedure."(";
                if(count($this->parameter)>0)
                    foreach ($this->parameter as $value) $query.=$value.",";
                $len = strlen($query);
                if(count($this->parameter)>0)
                    $len-=1;
                $this->query = substr($query, 0, $len).")";
                break;
            case 'MSSQL':
                $query = " Execute ".$this->scheme.'.'.$this->nomProcedure." ";
                if(count($this->parameter)>0)
                    foreach ($this->parameter as $value) $query.=$value.",";
                $len = strlen($query);
                if(count($this->parameter)>0)
                    $len-=1;
                $this->query = substr($query, 0, $len)." ";
                break;
        }
        return $this->query;
    }

    public function getSql(){
        return utf8_encode($this->Prepare_Procedure());
    }

    public function ExecuteSP(){
        $this->conex;
        $query = $this->Prepare_Procedure();
        switch (strtoupper($this->arrayDsn['dbtype'])){
            case 'MYSQL':
                $this->data = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
                break;
            case 'MSSQL':
                $this->data = mssql_query($query);
                break;
        }
    }

    public function ExecuteSPArray($noInclude = array()){
        $this->ExecuteSP();
        switch (strtoupper($this->arrayDsn['dbtype'])){
            case 'MYSQL':
                $retorno = array();
                //var_export($this->data);
                while ($line = mysql_fetch_array($this->data, MYSQL_ASSOC)){
                    $retorno[] = $line;
                }
                $this->arrayData = Common::UTF8($retorno);
                $this->CLOSE_MYSQL();
                break;
            case 'MSSQL':
                $num_rows = mssql_num_rows($this->data);
                if (!empty($num_rows) || intval($num_rows) > 0){
                    mssql_data_seek($this->data, 0);
                    while ($row = mssql_fetch_array($this->data, MSSQL_BOTH)) {
                        $this->arrayData[] = $row;
                    }
                    $this->arrayData = Common::iaLower($this->arrayData);
                }
                break;
            case 'INFORMIX':
                //var_dump($this->data->fetchAll);
                //var_dump($this->data->fetchAll(PDO::FETCH_ASSOC));
                // echo '<pre>' , print_r($this->data->fetch(PDO::FETCH_ASSOC)), '</pre>';
                // die();
                if ($this->data == false){
                    //var_dump($this->data->fetchAll);
                    //echo $this->getSql();die();
                    //throw new Exception("Error:SQL".$this->getSql());
                    error_log(date('d-m-Y h:i:s A', time())." PID:".getmypid()."Error:SQL".$this->getSql().chr(13),3,'/error.log');
                }else{
                    $this->arrayData = Common::UTF8(Common::iaLower($this->data->fetchAll(PDO::FETCH_ASSOC)), $noInclude);    
                    //$this->arrayData = Common::UTF8(Common::iaLower($this->data->fetchAll()), $noInclude);    
                }
                break;
            case 'INFORMIXMOBIL':
                if (is_bool($this->data)) {
                    $ERROR = $this->conex->errorInfo();

                    $response               = new stdClass();
                    $response->success      = FALSE;
                    $response->data         = array();
                    $response->code_error   = $ERROR[1];
                    $response->msg_error    = $ERROR[2];
                    $response->sql_query    = $this->query;
                    echo json_encode($response);
                    $this->Close();
                    die();
                } else {
                    $this->arrayData = Common::UTF8(Common::iaLower($this->data->fetchAll(PDO::FETCH_ASSOC)), $noInclude);
                }
                $this->printDebug($this->query, $this->arrayData);
                break;
        }
        $this->Close();
        //echo count($this->arrayData);
        return count($this->arrayData)>0?$this->arrayData:array();
    }

    public function ReiniciarSQL(){
        unset ($this->query);
        unset ($this->parameter);
        unset ($this->arrayData);
        $this->pathFileDebug = PATH."debug/debug.log";
    }

    public function Close(){
        //$this->data->close();
        //$this->conex->close();
        $this->data = null;
        $this->conex = null;
    }

    public function setQuery($_query=''){
        $this->query = $_query;
    }

    public function setPathDebug($pathFileDebug) {
        $this->pathFileDebug = $pathFileDebug;
    }

    private function printDebug($query, $result) {
        $debug = "Execute Query\n".
            "Fecha:\t\t".date('d/m/Y')."\n".
            "Hora:\t\t".date('H:i:s')."\n".
            "Execute:\t$query\n".
            "Result:\t\t".json_encode($result)."\n\n";
        error_log($debug, 3, $this->pathFileDebug);
    }

    public function openConnection($_dsn = array(), $_sp = '',  $_scheme = 'dbo') {
        $this->arrayDsn = $_dsn;
        $this->nomProcedure = $_sp;
        $this->scheme = $_scheme;

        try {
            $dsn = 'informix:host='.$_dsn['dbhost'].';service='.$_dsn['dbservices'].';database='.$_dsn['dbname'].';server='.$_dsn['dbserver'].';protocol='.$_dsn['protocolo'].';EnableScrollableCursors='.$_dsn['scrolle'];
            $this->conex = new PDO($dsn,$_dsn['dbuser'],$_dsn['dbpass']);
        } catch(PDOException $e) {
            $response               = new stdClass();
            $response->success      = FALSE;
            $response->data         = array();
            $response->code_error   = "2516";
            $response->msg_error    = "Error - 2516";

            echo json_encode($response);
            exec('kill -9 '.getmypid());
            die();
        }
    }

    public function setConnectionAutoClose($connectionAutoClose) {
        $this->connectionAutoClose = $connectionAutoClose;
    }

    public function closeConnection() {
        $this->conex = null;
        $this->data = null;
        $this->arrayData = null;

        $this->query = null;
        $this->parameter = null;
        $this->printDebug("Conexion cerrada manualmente.", array());
    }

    public function executeStoreProcedure($noInclude = array()) {
        $this->ExecuteSP();

        if (is_bool($this->data)) {
            $ERROR = $this->conex->errorInfo();

            $response               = new stdClass();
            $response->success      = FALSE;
            $response->data         = array();
            $response->code_error   = $ERROR[1];
            $response->msg_error    = $ERROR[2];
            $response->sql_query    = $this->query;
            echo json_encode($response);
            $this->closeConnection();
            die();
        } else {
            $this->arrayData = Common::UTF8(Common::iaLower($this->data->fetchAll(PDO::FETCH_ASSOC)), $noInclude);
        }

        $this->printDebug($this->query, $this->arrayData);

        if ($this->connectionAutoClose) {
            $this->closeConnection();
            $this->printDebug("Conexion cerrada automaticamente.", array());
        }

        return count($this->arrayData)>0?$this->arrayData:array();
    }

    public function MYSQL_EXE($query){
        $this->link = mysql_connect('grupo-eac.dyndns.org', 'GRUPOEAC', '123456')
        or die('No se pudo conectar: ' . mysql_error());
        mysql_select_db('EAC') or die('No se pudo seleccionar la base de datos');
        $this->result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
        $retorno = array();
        while ($line = mysql_fetch_array($this->result, MYSQL_ASSOC)){
            $retorno[] = $line;
        }
        return $retorno;
        
    }
    public function CLOSE_MYSQL(){
        mysql_free_result($this->data);
        mysql_close($this->conex);
        unset ($this->query);
    }

    public function ReiniciarMYSQL(){
        unset($this->data);
        unset($this->conex);
        unset($this->query);
        unset($this->parameter);
    }



}