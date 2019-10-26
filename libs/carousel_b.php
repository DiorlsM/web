<?php

class carousel {

    private $data = array();
    private $html = '';
    private $js = '';

    public function __construct() {
        
    }

    public function set_data($array) {
        $this->data = $array;
    }

    public function set_js($js) {
        $this->js = $js;
    }

    public function get_html() {
        $rs = $this->group_archivador();
        //var_export($rs);
        $html = '<div class="contenedor-carouselx" style="">';
        $html.='<div id="myCarousel" class="carouselx slide">';
        $html.='<div class="carouselx-inner">';
        $vj = 0;
        $vk = 0;
        $array_search = array();
        for ($vi = 0; $vi < count($rs); $vi += count($rs)) {
            $vk += count($rs);
            $html.='<div class="' . ($vi == 0 ? 'active' : '') . ' item">';
            for ($vj; $vj < count($rs); ++$vj) {
                if ($vj < $vk) {
                    $html.='<div class="div_archive">';
                    $html.= '<table>';
                    $html.='<caption>' . $rs[$vj]['anq_label'] . '</caption>';
                    $html.='<tbody class="boxesx">';
                    foreach ($rs[$vj]['hijos'] as $index => $value) {
                        $r = array_search(intval($rs[$vj]['anq_id']) . '-' . intval($value['gab_fila']), $array_search);
                        if (!is_numeric($r)) {
                            // echo intval($rs[$vj]['anq_id']).'-'.intval($value['gab_fila']).',';
                            $array_search[count($array_search)] = intval($rs[$vj]['anq_id']) . '-' . intval($value['gab_fila']);
                            $html.='<tr>';
                            foreach ($rs[$vj]['hijos'] as $index02 => $value02) {
                                if (intval($value02['gab_fila']) == intval($value['gab_fila'])) {

                                    $dataJs01 = array(
                                        'label' => $rs[$vj]['anq_label'],
                                        'id_anaquel' => $rs[$vj]['anq_id'],
                                        'id_gaveta' => $value02['gab_id'],
                                        'fila' => $value02['gab_fila'],
                                        'columna' => $value02['gab_columna'],
                                        'stock' => $value02['stk_actual'],
                                        'pendiente' => '0'
                                    );

                                    $html.='<td>';
                                    $html.="<div class='td-content'>
																	<span class='num'></span>
							                                		<strong class='quantity'>" . $value02['stk_actual'] . "</strong>
							                                		<div class='content_optionsx'>
							                                			<span class='optionsx optionBx' onclick='movimiento.stock_all(" . json_encode($dataJs01) . ")'></span>
							                                    		<span class='optionsx optionAx_' onclick='stock.open(" . json_encode($dataJs01) . ")'></span>
							                                    		<span class='optionsx optionBx_' onclick='movimiento.open(" . json_encode($dataJs01) . ")'></span>
							                                    		<span class='optionsx optionCx_'>(" . $value02['gab_fila'] . "," . $value02['gab_columna'] . ")</span>
							                                		</div>
							                            		</div>";
                                    $html.='</td>';
                                }
                            }
                            $html.='</tr>';
                        }
                    }
                    $html.='</tbody>';
                    $html.= '</table>';
                    $html.='</div>';
                } else {
                    break;
                }
            }
            $html.='</div>';
        }

        $html.='</div>';
        //$html.='<a class="carouselx-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>';
        //$html.='<a class="carouselx-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>';
        $html.='</div>';
        $html.='</div>';
        return $html;
    }

    public function group_archivador() {
        $array_result = array();
        $array_search = array();
        $vj = 0;
        //print "<pre>";print_r($this->data);
        //anq_id     anq_label     gab_id     stk_actual     gab_columna     gab_fila     bov_id
        // var_export($this->data);
        foreach ($this->data as $index => $value) {
            $r = array_search(intval($value['anq_id']), $array_search);
            if (!is_numeric($r)) {
                $vi = 0;
                $array_search[count($array_search)] = intval($value['anq_id']);
                $array_result[$vj]['anq_id'] = intval($value['anq_id']);
                $array_result[$vj]['anq_label'] = trim($value['anq_label']);
                $array_result[$vj]['hijos'] = array();
                // if (intval($value['id_arqueo']) != 0){
                $array_result[$vj]['hijos'][$vi]['gab_id'] = intval($value['gab_id']);
                // $array_result[$vj]['hijos'][$vi]['id_arqueo'] = intval($value['id_arqueo']);
                $array_result[$vj]['hijos'][$vi]['gab_fila'] = intval($value['gab_fila']);
                $array_result[$vj]['hijos'][$vi]['gab_columna'] = intval($value['gab_columna']);
                $array_result[$vj]['hijos'][$vi]['stk_actual'] = intval($value['stk_actual']);

                // }
                ++$vj;
            } else {
                ++$vi;
                $array_result[$r]['hijos'][$vi]['gab_id'] = intval($value['gab_id']);
                // $array_result[$r]['hijos'][$vi]['id_arqueo'] = intval($value['id_arqueo']);
                $array_result[$r]['hijos'][$vi]['gab_fila'] = intval($value['gab_fila']);
                $array_result[$r]['hijos'][$vi]['gab_columna'] = intval($value['gab_columna']);
                $array_result[$r]['hijos'][$vi]['stk_actual'] = intval($value['stk_actual']);
            }
        }
        //print "<pre>";print_r(json_encode($array_result));
        // var_export($array_result);
        return $array_result;
    }

}
