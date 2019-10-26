<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class indexController extends AppController {

    private $objDatos;
    private $objServicios;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        //$this->valida();


        $this->objDatos = new indexModels();
        session_start();
    }

 public function index($p){
        $this->view('index/form_index.php', $p);
    }
    public function header($p){
        $this->view('index/header.php', $p);
    }
    public function footer($p){
        $this->view('index/footer.php', $p);
    }
    public function compras($p){
        $this->view('index/carrito.php', $p);   
    }
    public function contacto($p){
        $this->view('index/contacto.php', $p);   
    }
    public function cuentas($p){
        $this->view('index/cuentas.php', $p);   
    }

    
    public function productos($p){
        $this->view('index/form_productos.php', $p);
    }
    public function muestra($p){
        $this->objDatos->muestra($p);
    }
    public function linea_producto(){
        $rs = $this->objDatos->linea();
        $cuenta = count($rs);
        $columnas = 4;
        $tot_col = ceil($cuenta / $columnas);
        $html = '';
        $i=0;

        if (count($rs) > 0){
            foreach($rs as $idx => $value){
                if ($i==0){
                    $html .= '<div class="col-md-3">';    
                }
                
                $html .='<p><a href="/inicio/index/?S1='.utf8_encode($value['cod_linea']).'">'.utf8_encode($value['nom_linea']).'</a></p>';
                $i++;
                if ($i==$tot_col){
                    $html .='</div>';
                    $i=0;
                }
            }
            echo $html;
        }

    }

    public function linea_marca(){
        $rs = $this->objDatos->marcas();
        $cuenta = count($rs);
        $columnas = 10;
        $tot_col = ceil($cuenta / $columnas);
        $html = '';
        $i=0;
        if (count($rs) > 0){
            foreach($rs as $idx => $value){
                if ($i==0){
                    $html .= '<div class="col-md-2">';    
                }
                
                $html .='<p style="margin-bottom: 2.1px;"><a href="/inicio/index/?M1='.utf8_encode($value['cod_subproducto']).'">'.utf8_encode($value['nom_subproducto']).'</a></p>';
                $i++;
                if ($i==$tot_col){
                    $html .='</div>';
                    $i=0;
                }
            }
            echo $html;
        }
    }

    public function listaMarcas(){
        $rs = $this->objDatos->marcas();
        $array = array();
        $html = '';
        if (count($rs) > 0){
            foreach($rs as $index => $value){
                if ($value['url_img']== ''){
                    $value['url_img'] = '/images/icon/sin-imagen.jpg';
                }
                $html .= '<div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4" style="cursor:pointer" onClick="window.location=\'/inicio/index/?M1='.utf8_encode($value['cod_subproducto']).'\'">';
                        $html .='<div class="card text-center" style="padding: 5px 5px 5px 5px;">';
                            $html .= '<div class="card-block">';
                                $html .= '<img src="'.$value['url_img'].'" class="img-fluid">';
                                $html .= '<div class="card-title">';
                                    $html .= '<h5>'.$value['nom_subproducto'].'</h5>';
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .='</div>';

                $html .='</div>';
            }
        }
        echo $html;
    }

    public function categorias($p){
        $rs = $this->objDatos->categorias($p);
        $array = array();
        $html = '';
        if (count($rs) > 0){
            foreach($rs as $index => $value){
                if ($value['url_img']== ''){
                    $value['url_img'] = '/images/icon/sin-imagen.jpg';
                }
                $html .= '<div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4" style="cursor:pointer" onClick="window.location=\'/inicio/index/?CA='.$value['cod_categoria'].'\'">';
                        $html .='<div class="card text-center" style="padding: 5px 5px 5px 5px;">';
                            $html .= '<div class="card-block">';
                                $html .= '<img src="'.$value['url_img'].'" class="img-fluid">';
                                $html .= '<div class="card-title">';
                                    $html .= '<h5>'.$value['nom_categoria'].'</h5>';
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .='</div>';

                $html .='</div>';
            }
        }
        echo $html;
    }

    public function like($p){
        $rs = $this->objDatos->busquedalike($p);
        //echo $this->objDatos->getSql();die();
        //var_export($rs);die();
        $array = array();
        $html = '';
        if (count($rs) > 0){
            foreach($rs as $index => $value){
                if ($value['url_img'] == ''){
                    $value['url_img'] = '/images/icon/sin-imagen.jpg';
                }
                $value['stock_actual'] = intval($value['stock_actual']);
                if ($value['stock_actual'] > 10){
                    $value['stock_actual'] = '>10';
                }
                $value['pre_venta'] = number_format($value['pre_venta'],2);
                $html .= '<div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4" >';
                    $html .='<div class="card text-center" style="padding: 5px 5px 5px 5px;cursor:pointer" onClick="window.location=\'/inicio/index/productos/?produc='.$value['cod_producto'].'\'">';
                        $html .= '<div class="card-block">';
                            if ($value['prod_tipo'] == 3){
                                $html .= '<div class="oferta"><div class="oferta-1">Oferta</div></div>';    
                            }else if($value['prod_tipo'] == 2){
                                $html .= '<div class="nuevo"><div class="nuevo-1">Nuevo</div></div>';    
                            }
                            
                            $html .= '<img src="'.$value['url_img'].'" class="img-fluid">';
                            $html .= '<div class="card-title text-produc" title="'.$value['nom_producto'].'">';
                                $html .= '<h6 style="margin-top: 8px;" class="font-eac">'.ucwords(strtr(strtolower($value['nom_producto']),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü")).'</h6>';
                            $html .= '</div>';
                            $html .= '<div class="card-text">';
                                $html .='<h6 class="card-subtitle mb-2 text-muted font-eac">Marca: '.utf8_encode($value['nom_Subproducto']).'</h6>  ';
                                $html .='<h6 class="card-subtitle mb-2 text-muted font-eac">Codigo: '.utf8_decode($value['cod_producto']).'</h6>';
                                $html .='<h6 class="card-subtitle mb-2 text-muted font-eac">Stock: '.$value['stock_actual'].'</h6>';
                            $html .= '</div>';
                            $html .= '<div class="card-footer text-center">';
                                $html .='<h4 class="card-subtitle mb-2 font-eac" style="color: #ea2840 !important;margin-top: 7px;">Dolares: $'.$value['pre_venta'].'</h4>';
                                $html .='<h4 class="card-subtitle mb-2 font-eac" style="color: #ea2840 !important;">Soles: S/. '.$value['pre_soles'].' </h4>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .='</div>';
                $html .='</div>';
            }
        }
        echo $html;
    }

    public function detalleProducto($p){
        $html = '';
        $html .= '<div class="row col-12 col-sm-12 col-md-12 col-lg-8 mb-7" style="margin-top: 16px;">';
            $html .= '<div class="col-12 col-sm-12 col-md-10 col-lg-7 mb-6 " >';
                $html .='<div class="owl-carousel owl-theme border-img" id="productos" >';
                    $imagenes = $this->objDatos->SP_Lista_imagen($p);
                    foreach ($imagenes as $key => $value) {
                        $value['nombre'] = '/3/'.$value['nombre'].'.jpg';
                        $html .='<div class="item" >';
                            $html .='<img src="'.$value['nombre'].'" class="img-fluid">';
                        $html .='</div>';
                    }
                $html .='</div>';
            $html .= '</div>';
            $prd = $this->objDatos->productoCarro(array('cod_produc'=>$p['produc']));
            //var_export($prd);die();
            $prd = $prd[0];
            $html .= '<div class="col-12 col-sm-12 col-md-12 col-lg-5 mb-6 " >';
                $html .= '<div class=" col-12 name_produc font-eac">'.$prd['nom_producto'].'</div>';
                $html .= '<div class=" col-12 text-right font-color-precio">$ '.$prd['pre_dolares'].'</div>';
                $html .= '<div class=" col-12 text-right font-color-precio">S/ '.$prd['pre_soles'].'</div>';
                $html .= '<div class=" col-12 text-center"><button id="btn-producto" section="'.$p['produc'].'" type="button" class="btn btn-dark" >Agregar al Carrito</button></div>';//onClick="addCarrito(\''.$p['produc'].'\')"
            $html .= '</div>';
            $detalleProduc = $this->objDatos->SP_Lista_Datos_Prod($p);
            if (count($detalleProduc) > 0){
                foreach ($detalleProduc as $key => $value) {
                    $html .= '<div class="col-12" style="margin-top: 16px;min-height: 600px;">';
                        $html .= '<nav>';
                          $html .= '<div class="nav nav-tabs tab-style" id="nav-tab" role="tablist">';
                            $html .= '<a class="nav-item nav-link active" id="id_descri-tab" data-toggle="tab" href="#id_descri" role="tab" aria-controls="id_descri" aria-selected="true">Descripcion</a>';
                            $html .= '<a class="nav-item nav-link" id="id_caract-tab" data-toggle="tab" href="#id_caract" role="tab" aria-controls="id_caract-tab" aria-selected="false">Caracteristicas</a>';
                            $html .= '<a class="nav-item nav-link" id="id_especif-tab" data-toggle="tab" href="#id_especif" role="tab" aria-controls="id_especif" aria-selected="false">Especificaciones</a>';
                          $html .= '</div>';
                        $html .= '</nav>';
                        $html .= '<div class="tab-content " id="nav-tabContent">';
                          $html .= '<div class="tab-pane fade show active" id="id_descri" role="tabpanel" aria-labelledby="id_descri-tab">'.$value['prod_descri'].'</div>';
                          $html .= '<div class="tab-pane fade" id="id_caract" role="tabpanel" aria-labelledby="id_caract-tab">'.$value['prod_caract'].'</div>';
                          $html .= '<div class="tab-pane fade" id="id_especif" role="tabpanel" aria-labelledby="id_especif-tab">'.$value['prod_especif'].'</div>';
                        $html .= '</div>';
                        
                    $html .= '</div>';
                }
            }
            
            
        $html .= '</div>';//cierre final
    
        echo $html;
    }

    public function addCarrito($p){
        //session_start();
        $add = true;
        if (count($_SESSION['carrito'])>0){
            foreach ($_SESSION['carrito'] as $key => $val) {
                //echo $val['cod_produc'].'-'.$p['cod_produc'].'-'.$key.'<br>';
                if ($val['cod_produc'] == $p['cod_produc']){
                    $newValor = $_SESSION['carrito'][$key]['cnt']+1;
                    if ($newValor >=6){
                        die();
                    }
                    $_SESSION['carrito'][$key]['cnt'] = $newValor;
                    $add = false;
                }   
            }
            if ($add == true){
                $_SESSION['carrito'][] =array('cod_produc'=>$p['cod_produc'],'cnt'=>'1'); 
            }    
        }else{
            $_SESSION['carrito'][] =array('cod_produc'=>$p['cod_produc'],'cnt'=>'1');  
        }
    }
    public function changeCnt($p){
        if (count($_SESSION['carrito'])>0){
            foreach ($_SESSION['carrito'] as $key => $val){
                if ($val['cod_produc'] == $p['cod_produc']){
                    $_SESSION['carrito'][$key]['cnt'] = $p['cnt'];
                }
            }
        }
        var_export($_SESSION['carrito']);
    }
    public function cuentaCarro($p){
        //session_start();
        $cuenta = 0;
        if (count($_SESSION['carrito'])>0){
            foreach ($_SESSION['carrito'] as $key => $val) {
                $cuenta = $cuenta + $val['cnt'];
            }
            echo $cuenta;
        }else{
            echo $cuenta;
        }
    }

    public function htmlCarrito($p){
        //session_start();
        //session_destroy();
        //var_export($_SESSION);die();
        $html ='';
        if (count($_SESSION['carrito'])>0){
            foreach ($_SESSION['carrito'] as $key => $val) {
                $prd = $this->objDatos->productoCarro($val);
                $prd = $prd[0];
                //var_export($prd);die();
                if ($prd['url_img'] == ''){
                    $prd['url_img'] = '/images/icon/sin-imagen.jpg';
                }

                $prd['pre_dolares'] = number_format($prd['pre_dolares']*$val['cnt'],2);
                $prd['pre_soles'] = number_format($prd['pre_soles']*$val['cnt'],2);
                $html .='<div class="row" style="margin: 5px 0px 0px 0px;">';
                    $html .='<div class="col-12 col-sm-2 col-lg-2">';
                        $html .='<div class="" >';
                          $html .='<img src="'.$prd['url_img'].'" class="img-fluid">';
                        $html .='</div>';
                      $html .='</div>';
                    $html .='<div class="col-12 col-sm-10 col-lg-10">';
                        $html .='<div class="">';
                            $html .='<h5>'.ucwords(strtr(strtolower($prd['nom_producto']),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü")).'</h5>';
                            $html .='<div style="color: #ea2840 !important;font-weight: bold;" class=""> Dolares: '.$prd['pre_dolares'].'</div>';
                            $html .='<div style="color: #ea2840 !important;font-weight: bold;" class="mt-1 mb-1"> Soles: '.$prd['pre_soles'].'</div>';
                            $html .='<div class="" style="width: 137px;display: inline-flex;">';
                                $html .='<select class="form-control mr-2" id="'.$val['cod_produc'].'">';
                                    if ($val['cnt'] == '1'){
                                        $html .='<option prd="'.$val['cod_produc'].'" selected value="1">1</option>';
                                    }else{
                                        $html .='<option prd="'.$val['cod_produc'].'" value="1">1</option>';
                                    }
                                    if ($val['cnt'] == '2'){
                                        $html .='<option prd="'.$val['cod_produc'].'" selected value="2">2</option>';
                                    }else{
                                        $html .='<option prd="'.$val['cod_produc'].'" value="2">2</option>';
                                    }
                                    if ($val['cnt'] == '3'){
                                        $html .='<option prd="'.$val['cod_produc'].'" selected value="3">3</option>';
                                    }else{
                                        $html .='<option prd="'.$val['cod_produc'].'" value="3">3</option>';
                                    }
                                    if ($val['cnt'] == '4'){
                                        $html .='<option prd="'.$val['cod_produc'].'" selected value="4">4</option>';
                                    }else{
                                        $html .='<option prd="'.$val['cod_produc'].'" value="4">4</option>';
                                    }
                                    if ($val['cnt'] == '5'){
                                        $html .='<option prd="'.$val['cod_produc'].'" selected value="5">5</option>';
                                    }else{
                                        $html .='<option prd="'.$val['cod_produc'].'" value="5">5</option>';
                                    }
                                $html .='</select>';
                                $html .='<button type="button" class="btn btn-danger">Quitar</button>';
                            $html .='</div>';

                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            }
        }
        echo $html;
    }
    public function promociones($p){
        $rs = $this->objDatos->SP_Lista_imagen_banner($p);
        $html = '';
        $htmlLista = '';
        $htmlImg = '';
        if (count($rs) > 0) {
            foreach ($rs as $index => $value) {
                $value['nombre'] = '/banner/'.$p['vp_tipo_carga'].'/'.$value['nombre'].'.jpg';
                if ($index==0){
                    $htmlLista .='<li data-target="#myCarousel" data-slide-to="'.$index.'" class="active"></li>';       
                }else{
                    $htmlLista .='<li data-target="#myCarousel" data-slide-to="'.$index.'"></li>';    
                }
                if ($index == 0){
                    $htmlImg .='<div class="carousel-item active">';
                        $htmlImg .='<img class="img-fluid" src="'.$value['nombre'].'" alt="" >';
                    $htmlImg .='</div>';
                }else{
                    $htmlImg .='<div class="carousel-item">';
                        $htmlImg .='<img class="img-fluid" src="'.$value['nombre'].'" alt="" >';
                    $htmlImg .='</div>';
                }
                
            }
        }
        //echo $htmlImg;
        $html .='<div id="myCarousel" class="carousel slide" data-ride="carousel">';
            $html .='<ol class="carousel-indicators">';
                $html .= $htmlLista;
            $html .='</ol>';
            $html .='<div class="carousel-inner">';
                $html .= $htmlImg;
            $html .='</div>';
            $html .='<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">';
            $html .='<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            $html .='<span class="sr-only">Previous</span>';
            $html .='</a>';
            $html .='<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">';
            $html .='<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            $html .='<span class="sr-only">Next</span>';
            $html .='</a>';
        $html .='</div>';
        echo $html;
    }

    public function sendMail($p){
       
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $this->include_mailer();
        $mail = new PHPMailer();
        $mail->IsSMTP();

        $mail->SMTPAuth = true;
        $mail->Host = 'astro.hostinglabs.net';
        $mail->Username   = 'ventas@eac.pe';
        $mail->Password  = 'ventas@eac!2018';
        //$mail->SMTPSecure = 'ssl';
        $mail->Port = '25';
        $mail->SetFrom('ventas@eac.pe', 'EAC Consulting');

        $mail->IsHTML(true);
        $mail->Subject = utf8_decode('Alerta de Compra');
        $mail->Timeout = 30;
        $mail->MsgHTML($this->html($p));

        $mail->AddAddress(trim($p['correo']), 'Compras' );
        $mail->AddBCC('ventas@eac.pe', 'Compras');


        try {
            if (!$mail->Send()) {
                $errormsn = $mail->ErrorInfo;
                echo $errormsn;
            }else{
                echo 'OK';
                session_destroy();
            }
        } catch(Exception $e){
            echo $e;
        }
    }
    public function html($p){
        $html = '';
        $sumaDolare = 0;
        $sumaSoles = 0;
        $sumaCnt = 0;
        $html .= '<table bgcolor="" cellpadding="3" cellspacing="3" width="50%" align="center">';
            $html .= '<tr style="background-color: blue;color: white;font-weight: bold;">';
                $html .= '<td>Cliente</td>';
                $html .= '<td>Telefono</td>';
                $html .= '<td>Correo</td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<td>'.$p['nombre'].'</td>';
                $html .= '<td> '.$p['telefono'].'</td>';
                $html .= '<td> '.$p['correo'].'</td>';
            $html .= '<tr>';
        $html .= '</table>';
        $html .= '<table bgcolor="" cellpadding="3" cellspacing="3" width="90%" align="center">';
            $html .= '<tr style="background-color: blue;color: white;font-weight: bold;">';
                $html .= '<td>Nombre Producto</td>';
                $html .= '<td>Cantidad</td>';
                $html .= '<td>Dolares</td>';
                $html .= '<td> Soles</td>';
            $html .= '</tr>';
            foreach ($_SESSION['carrito'] as $key => $val){
                $prd = $this->objDatos->productoCarro($val);
                $prd = $prd[0];
                $prd['pre_dolares'] = number_format($prd['pre_dolares']*$val['cnt'],2);
                $prd['pre_soles'] = number_format($prd['pre_soles']*$val['cnt'],2);
                $sumaDolare = number_format($sumaDolare +$prd['pre_dolares'],2);
                $sumaSoles = number_format($sumaSoles + $prd['pre_soles'],2);
                $sumaCnt = $sumaCnt +$val['cnt'];
                $html .= '<tr>';
                    $html .= '<td>'.ucwords(strtr(strtolower($prd['nom_producto']),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü")).'</td>';
                    $html .= '<td> '.$val['cnt'].'</td>';
                    $html .= '<td> $ '.$prd['pre_dolares'].'</td>';
                    $html .= '<td> S/ '.$prd['pre_soles'].'</td>';
                $html .= '<tr>';
            }
            $html .= '<tr>';
                $html .= '<td>Total a Pagar</td>';
                $html .= '<td> '.$sumaCnt.'</td>';
                $html .= '<td> $ '.$sumaDolare.'</td>';
                $html .= '<td> S/ '.$sumaSoles.'</td>';
            $html .= '<tr>';
            
        $html .= '</table>';
        return $html;
    }

}