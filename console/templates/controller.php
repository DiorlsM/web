<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class [template]Controller extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        // $this->valida();

        $this->objDatos = new [template]Models();
    }

    public function index($p){
        /**
         * Cargando datos de archivo de configuracion
         */
        
        $this->view('[template]/form_index.php', $p);
    }    

}