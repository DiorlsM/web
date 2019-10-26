<?php

set_time_limit(0);
ini_set("memory_limit", "-1");

class indexController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
         /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new indexModels();
    }

    public function index($p){
        $this->view('index/form_index.php', $p);
    }

}